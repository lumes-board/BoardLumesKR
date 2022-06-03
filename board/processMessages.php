<?php
    header('Content-Type: text/html; charset=utf-8');
?>

<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>루메스 보드</title>
        <link rel="shortcut icon" href="../../favicon/favicon.ico">
    </head>

</html>

<?php

    session_start();

    require("../common/reCAPTCHA/verify_reCAPTCHA_server.php");
    require("../common/dbconnection.php");
    include('../common/resource.html');
    
    $reCAPTCHApass = check_reCAPTCHA();

    if(!isset($_SESSION['id'])) {

        // 로그인도 안 하면서 글을 쓰려고 하는 경우

        ?>

            <script>
                
                // reCAPTCHA 인증에 실패함
                Swal.fire({
                    icon: 'error',
                    title: 'You are not a...!',
                    footer: '아니, 로그인부터 하고 글을 적으라구요!!'
                }).then((result) => {
                    location.href = "../index.php";
                })

            </script>

        <?php

    }

    if($reCAPTCHApass === true){
 
        // reCAPTCHA 인증에 성공 -> 절차 진행
        $addMessageOnBoardData = [
            'id'            => $_SESSION['id'],
            'message'       => addslashes(htmlspecialchars($_POST['message'])),
            'date'          => date("Y-m-d H:i:s"),
            'ip'            => $_SERVER['REMOTE_ADDR']
        ];

        $query = "INSERT INTO board (id, message, date, ip)
                         VALUES (:id, :message, :date, :ip)";
        $stmt = $db->prepare($query);

        try {

            $db->beginTransaction();
            $stmt->execute($addMessageOnBoardData);
            $db->commit();

            $userExpAward = rand(50000, 80000);

            // 유저 통계 업데이트
            $updateUserStatus = "UPDATE member 
                                  SET exp = exp + :userEXPReward, guestbookQty	= guestbookQty + 1 
                                   WHERE id = :id";
            $stmt = $db->prepare($updateUserStatus);
            $stmt->bindParam(':userEXPReward', $userExpAward, PDO::PARAM_STR); 
            $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);

            $stmt->execute();
            

            echo '<script>location.href="../index.php"</script>';

        } catch(PDOException $PDOerr) {

            die($PDOerr->getMessage());

        } 


    } else {

        // reCAPTCHA 인증에 실패 -> 절차 거부

        ?>

            <script>
                
                // reCAPTCHA 인증에 실패함
                Swal.fire({
                    icon: 'error',
                    title: 'Are you a robot?',
                    footer: 'reCAPTCHA를 성공적으로 통과하셔야 해요!'
                }).then((result) => {
                    location.href = "../index.php";
                })

            </script>

        <?php

    }

?>