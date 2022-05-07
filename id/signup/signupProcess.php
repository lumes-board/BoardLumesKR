<?php
    header('Content-Type: text/html; charset=utf-8');
?>

<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>루메스 보드 회원가입 진행</title>
        <link rel="shortcut icon" href="../../favicon/favicon.ico">
    </head>

</html>

<?php

    session_start();
    
    require("../../common/verify_reCAPTCHA.php");
    require("../../common/dbconnection.php");
    include('../../common/resource.html');
    
    $reCAPTCHApass = check_reCAPTCHA();

    if($reCAPTCHApass === true){

        // reCAPTCHA 인증에 성공하였으므로 가입을 진행함

        $id               = addslashes(htmlspecialchars($_POST['userID']));
        $nickname         = addslashes(htmlspecialchars($_POST['userNickname']));
        $password         = addslashes(htmlspecialchars($_POST['userPassword1']));
        $email            = addslashes(htmlspecialchars($_POST['userEmail']));

        // 회원가입에 필요한 값이 전송되지 않음
        if(!(isset($id) && isset($nickname) && isset($password) && isset($email))){

            ?>

                <script>
                    Swal.fire({
                        icon: 'error',
                        title: '값이 사라졌네요...?',
                        footer: '회원가입에 필요한 값이 사라졌어요!! 중간에 일부러 유실시키지 마세요!'
                    }).then((result) => {
                        location.href = './signup.php';
                    })
                </script>

            <?php

            die();

        }

        // ID와 이메일 형식 재검증 (server-side)
        if((!preg_match("/^[a-z0-9_]+$/", $id) || strlen($id) > 30) || (!filter_Var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255)){

            ?>

                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'ID/Email 형식 오류',
                        footer: 'ID와 Email 형식이 올바르지 않습니다. 회원가입 페이지에서 제공하는 <b>ID Check</b>와 <b>Email Check</b> 기능을 통해 먼저 유효성을 검사하고 오세요.'
                    }).then((result) => {
                        location.href = './signup.php';
                    })
                </script>

            <?php
            
            die();

        }

        $userIPAddress    = $_SERVER['REMOTE_ADDR'];
        $password         = password_hash($password, PASSWORD_DEFAULT);         // 패스워드는 안전하게 hash 처리하도록 한다.
        $datetime         = date("Y-m-d H:i:s");
        
        // 유저가 실제로 있는지 검증
        $query = "SELECT * FROM member WHERE id = :idInput or email = :emailInput";
        $stmt  = $db->prepare($query);
        
        $stmt->bindParam(':idInput', $id, PDO::PARAM_STR); 
        $stmt->bindParam(':emailInput', $email, PDO::PARAM_STR); 

        $stmt->execute();

        $isRegistererDuplicated = $stmt->fetchAll(PDO::FETCH_NUM);

        if(empty($isRegistererDuplicated)) {

            // 중복된 유저 없음, 회원가입 가능!

            // 기본값으로 설정된 부분은 여기서 굳이 따로 두지 않음.
            //
            // 기본값 목록
            //      exp               = 1000
            //      expTransactionQty = 0
            //      guestbookQty      = 0
            //      lastLoginTime     = NULL (로그인시 반영됨)
            //      lastLoginIP       = NULL (로그인시 반영됨)
            //

            $query = "INSERT INTO member (id, nickname, password, email, registrationTime, registrationIP) 
                      VALUES (:idInput, :nicknameInput, :passwordInput, :emailInput, :registrationTime, :registrationIP)";
            $stmt = $db->prepare($query);

            $stmt->bindParam(':idInput', $id, PDO::PARAM_STR);
            $stmt->bindParam(':nicknameInput', $nickname, PDO::PARAM_STR);
            $stmt->bindParam(':passwordInput', $password, PDO::PARAM_STR);
            $stmt->bindParam(':emailInput', $email, PDO::PARAM_STR);
            $stmt->bindParam(':registrationTime', $datetime, PDO::PARAM_STR);
            $stmt->bindParam(':registrationIP', $userIPAddress, PDO::PARAM_STR);

            
            try {

                $db->beginTransaction();
                $stmt->execute();
                $db->commit();

                // 여기까지 잘 완료되면, 회원가입 성공
                ?>

                    <script>
                        Swal.fire({
                            icon : 'success',
                            title : '반갑습니다!',
                            text : '회원가입이 완료되었습니다.',
                            footer : '로그인하여 서비스를 이용하실 수 있습니다.'
                        }).then((result) => {
                            location.href = "../../index.php";
                        })
                    </script>
    
                <?php

            } catch(PDOException $PDOerr) {

                die($PDOerr->getMessage());

            } 


        } else {

            ?>

                <script>
                    Swal.fire({
                        icon: 'error',
                        title: '중복된 유저 있음!',
                        footer: '억지로 중복된 유저 가입을 시도하지 마세요! 입력하신 ID 또는 Email 주소로 등록된 계정이 이미 존재합니다.'
                    }).then((result) => {
                        location.href = "./signup.php";
                    })
                </script>

            <?php

        }


    } else {

        ?>

            <script>
                
                // reCAPTCHA 인증에 실패함
                Swal.fire({
                    icon: 'error',
                    title: 'Are you a robot?',
                    footer: 'reCAPTCHA를 성공적으로 통과하셔야 해요!'
                }).then((result) => {
                    location.href = "./signup.php";
                })

            </script>

        <?php

    }
    
 
?>