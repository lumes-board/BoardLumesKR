<?php
    header('Content-Type: text/html; charset=utf-8');
?>

<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>루메스 보드 회원인증</title>
        <link rel="stylesheet" href="../../css/font.css">
        <link rel="shortcut icon" href="../../favicon/favicon.ico">

        <?php include('../../common/resource.html'); ?>

    </head>

</html>

<?php

    $verifierID    = addslashes(htmlspecialchars($_GET['userID']));
    $verifierEmail = addslashes(htmlspecialchars($_GET['userEmail']));
    $verifierHash  = addslashes(htmlspecialchars($_GET['verifyID']));

    require("../../common/dbconnection.php");

    // 계정 활성화를 위한 검증
    $query = "SELECT * 
                FROM member 
                    WHERE id = :verifierID and email = :verifierEmail and registrationHash = :verifierHash";
    $stmt  = $db->prepare($query);
        
    $stmt->bindParam(':verifierID', $verifierID, PDO::PARAM_STR);
    $stmt->bindParam(':verifierEmail', $verifierEmail, PDO::PARAM_STR);
    $stmt->bindParam(':verifierHash', $verifierHash, PDO::PARAM_STR);

    $stmt->execute();

    $requestedUserInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $requestedUserInfo = $requestedUserInfo[0];

    if(!empty($requestedUserInfo)) {
        if($requestedUserInfo['isActivated'] === "FALSE") {
            // 계정 인증 대상인데 계정 인증에 성공하였으므로 계정 활성화를 시작함
            try{

                $query = "UPDATE member
                            SET isActivated = 'TRUE'
                                WHERE id = :verifierID";   
                $stmt  = $db->prepare($query);
                $stmt->bindParam(':verifierID', $verifierID, PDO::PARAM_STR);
            
                $stmt->execute();

                ?>

                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: '환영합니다!',
                            footer: '계정이 성공적으로 인증되었습니다. 원래 탭으로 돌아가셔서 로그인 해 보세요.'
                        }).then((result) => {
                            window.close();
                        })
                    </script>                    

                <?php

            } catch (PDOException $PDOerr) {

                die($PDOerr->getMessage());

            }
        } else {

            // 해당 계정은 있긴 하지만, 인증 대상 계정이 아님. (보통은 인증이 다 되어서 "isActivated"가 TRUE가 된 경우.)
            ?>

                <script>
                    Swal.fire({
                        icon: 'error',
                        title: '잘못된 접근',
                        footer: '해당 계정은 인증 대상 계정이 아닙니다.'
                    }).then((result) => {
                        window.close();
                    })
                </script>                    

            <?php

        }
    } else {

        // 등록된 계정이 아님.
        ?>

            <script>
                Swal.fire({
                    icon: 'error',
                    title: '잘못된 접근',
                    footer: '해당 계정은 인증 대상 계정이 아닙니다.'
                }).then((result) => {
                    window.close();
                })
            </script>                    

        <?php

        die();
    }

?>