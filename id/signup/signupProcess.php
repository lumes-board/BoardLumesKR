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
    
    require("../../common/reCAPTCHA/verify_reCAPTCHA_server.php");
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

            // 이메일 부분 테스트 시 SMTP 서버가 되는 곳에서 할 것.
            // **note**
            //  특정 mail 서비스에서 한글이 깨지는 문제가 발생함. 
            //  major한 서비스에서는 안 깨지는 걸로 봐서 별 문제는 아닌 것으로 간주됨.

            $registrationHash = md5(rand(0,500000000000000000));            // 계정 활성화용 해시
            $isActivated = "FALSE";                                         // 계정 상태, 기본은 비활성화되었으며, 따로 활성화 절차를 거쳐야 이용이 가능함.

            if($_SERVER['REMOTE_ADDR'] == "::1") {
                // for local test
                // id/verification/signupVerifier.php
                $emailVerificationURL = "localhost/id/verification/signupVerifier.php?userID=" . $id . "&userEmail=" . $email . "&verifyID=" . $registrationHash;
            } else {
                // for actual test
                $emailVerificationURL = "http://board.lumes.kr/id/verification/signupVerifier.php?userID=" . $id . "&userEmail=" . $email . "&verifyID=" . $registrationHash;
            }

            $query = "INSERT INTO member (id, nickname, password, email, registrationTime, registrationIP, registrationHash, isActivated) 
                      VALUES (:idInput, :nicknameInput, :passwordInput, :emailInput, :registrationTime, :registrationIP, :registrationHash, :isActivated)";
            $stmt = $db->prepare($query);

            $stmt->bindParam(':idInput', $id, PDO::PARAM_STR);
            $stmt->bindParam(':nicknameInput', $nickname, PDO::PARAM_STR);
            $stmt->bindParam(':passwordInput', $password, PDO::PARAM_STR);
            $stmt->bindParam(':emailInput', $email, PDO::PARAM_STR);
            $stmt->bindParam(':registrationTime', $datetime, PDO::PARAM_STR);
            $stmt->bindParam(':registrationIP', $userIPAddress, PDO::PARAM_STR);
            $stmt->bindParam(':registrationHash', $registrationHash, PDO::PARAM_STR);
            $stmt->bindParam(':isActivated', $isActivated, PDO::PARAM_STR);

            
            try {

                $db->beginTransaction();
                $stmt->execute();
                $db->commit();

                // 이메일 인증하기

                $emailReceiver = $email;

                $emailSubject  = "[board.lumes.kr] 회원가입 인증 확인 이메일";
                $emailSubject  = '=?UTF-8?B?'.base64_encode($emailSubject).'?='; 

                $emailContents = '<p>board.lumes.kr에 회원가입 하신 것을 환영합니다.</p><br>';
                $emailContents .= '<p>거의 다 왔습니다! 아래 인증 메일 코드를 이용해 회원가입을 완료해 주시기 바랍니다.</p><br>';
                $emailContents .= '<p>아래 링크를 클릭하여 인증하시면 바로 인증 절차가 진행됩니다.</p><br>';
                $emailContents .= '<a href="'.$emailVerificationURL.'"><b>'.$emailVerificationURL.'</b></a><br>';

                $emailHeader = "From:noreply@lumes.kr\r\n";
                $emailHeader .= "Content-Type: text/html;\r\n";


                mail($emailReceiver, $emailSubject, $emailContents, $emailHeader);


                // 여기까지 잘 완료되면, 회원가입 성공. 단, 이메일 인증이 요구될 것임.

                ?>

                <script>
                    Swal.fire({
                        icon: 'success',
                        title: '확인 이메일 전송됨',
                        footer: '이메일이 전송되었습니다. 이메일 인증을 실시하여 회원가입을 완료하고 로그인해 서비스를 이용하세요.'
                    }).then((result) => {
                        location.href = './signup.php';
                    })
                </script>

        <?php

            } catch(PDOException $PDOerr) {

                die($PDOerr->getMessage());
 
            } catch(Exception $ANYerr) {

                die($ANYerr);

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