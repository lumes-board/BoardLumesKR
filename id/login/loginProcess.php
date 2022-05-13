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
        
    require("../../common/reCAPTCHA/verify_reCAPTCHA_server.php");
    require("../../common/dbconnection.php");
    include('../../common/resource.html');

    $reCAPTCHApass = check_reCAPTCHA();

    if($reCAPTCHApass === true) {

        $userid       = stripslashes(htmlspecialchars($_POST['id']));
        $userpassword = stripslashes(htmlspecialchars($_POST['password']));

        $query = "SELECT * FROM member WHERE id = :idInput";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':idInput', $userid, PDO::PARAM_STR); 
        
        $stmt->execute();

        $userExistence = $stmt->fetchAll();

        if(!empty($userExistence)){

            $userInformation = $userExistence[0];

            // 계정이 존재함, 비밀번호를 검증해야함
            $hashedPassword = $userInformation["password"];

            if($hashedPassword === "redacted") {
                // 영구 정지된 계정
                // 영구 정지되면 해시된 패스워드가 있어야 할 자리에는 "redacted"로 대체됨 (관리자가 지정할 수 있음.)
    
                ?>
    
                    <script>
        
                        Swal.fire({
                            icon: 'error',
                            title: '로그인 불가',
                            text: '계정이 영구 정지되었습니다.',
                            footer: '계정 복구 등에 대한 문의가 있으시면 관리자에게 연락하세요.'
                        }).then((result) => {
                            location.href = "./login.php";
                        })
        
                    </script>
    
                <?php

            }

            $passwordVerification = password_verify($userpassword, $hashedPassword);

            if($passwordVerification === true){

                // 로그인 성공 관련 정보를 member 테이블에 기록
                $loginTime = date("Y-m-d H:i:s");
                $loginIP   = $_SERVER['REMOTE_ADDR'];

                $query = "UPDATE member SET lastLoginTime = :loginTime, lastLoginIP = :loginIP WHERE id = :userID";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':loginTime', $loginTime, PDO::PARAM_STR); 
                $stmt->bindParam(':loginIP', $loginIP, PDO::PARAM_STR); 
                $stmt->bindParam(':userID', $userInformation['id'], PDO::PARAM_STR); 

                $stmt->execute();

                // 로그인 성공, 세션에 계정 정보 저장
                session_start();
                $_SESSION['id'] = $userInformation['id'];
                $_SESSION['nickname'] = $userInformation['nickname'];
                $_SESSION['role'] = $userInformation['role'];

                ?> 

                    <script>

                        Swal.fire({
                            title: '반갑습니다!👋',
                            html: '곧 메인 페이지로 이동합니다.',
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                location.href = "../../index.php";
                            } else {
                                location.href = "../../index.php";
                            }
                        })
                
                    </script>

                <?php

            } else {

                    // 비밀번호가 틀린 경우.

                    ?>

                    <script>

                        Swal.fire({
                            icon: 'question',
                            title: '누구세요?',
                            text: '비밀번호가 틀렸습니다.',
                            footer: '단지 실수였기를 바랍니다.'
                        }).then((result) => {
                            location.href = "./login.php";
                        })

                    </script>

                <?php

            }

        } else {

            // 로그인 정보가 잘못됨 없는 계정이거나, ID나 비밀번호가 잘못됨.

            ?>

                <script>

                    Swal.fire({
                        icon: 'error',
                        title: '잘못된 정보',
                        text: '로그인 정보가 없거나 잘못되었습니다.'
                    }).then((result) => {
                        location.href = "./login.php";
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
                    location.href = "./login.php";
                })

            </script>

        <?php

    }

?>