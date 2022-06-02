<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>루메스 보드 회원가입 진행</title>
        <link rel="shortcut icon" href="../../favicon/favicon.ico">
        <link rel="stylesheet" href="./css/sendSingupVerificationEmail.css">
    </head>

    <body>

<?php

    session_start();

    $id    = $_GET['id'];
    $email = $_GET['email'];

    require("../../common/dbconnection.php");
    include('../../common/resource.html');

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

    try {

        // 인증 정보를 등록함.
        $query = "UPDATE member 
                SET registrationHash = :registrationHash
                    WHERE id = :id AND email = :email";
        $stmt = $db->prepare($query);

        $stmt->bindParam(':registrationHash', $registrationHash, PDO::PARAM_STR); 
        $stmt->bindParam(':id', $id, PDO::PARAM_STR); 
        $stmt->bindParam(':email', $email, PDO::PARAM_STR); 

        $stmt->execute();

    } catch(PDOException $PDOerr){

        die($PDOerr -> getMessage());

    }

    // 이메일 전송 부분
    function sendVerificationEmail($email, $emailVerificationURL) {
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

        ?>

            <script>
                const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true
                    })
                    Toast.fire({
                        icon: 'success',
                        title: '인증 이메일을 보냈습니다.'
                    })
            </script>

        <?php
    }

    // 최초 1회는 이메일을 보냄
    sendVerificationEmail($email, $emailVerificationURL);

?>

        <p id="notification" align="center">
            <b><?php echo $email ?></b> 주소로 이메일이 보내졌습니다. 메일함을 확인해 보세요. <br>
            만일 이메일이 보이지 않는다면 입력하신 이메일 주소 스팸메일함 등을 확인해 보시거나, 재전송을 시도해 보세요. <br>
            <b>이메일 인증이 완료될 때까지 계정은 인증 성공 시점까지 활성화되지 않고, 이용 역시 불가능합니다.</b> <br>
            이메일 인증이 완료되지 않은 경우, 추후 해당 이메일 주소로 다시 계정을 생성하실 수 있습니다.<br>
            이메일 인증이 완료된 경우 이 탭을 닫으셔도 좋습니다.
        <p>

        <form method="POST" id="submitForm" style=" text-align: center;">
            <!-- 새로고침을 하면서 이메일을 재전송함 -->
            <button type="submit" class="button-82-pushable" 
                    value="resendVerificationEmail" id="submitButton" role="button" style=" display: inline-block;">
                <span class="button-82-shadow"></span>
                <span class="button-82-edge"></span>
                <span class="button-82-front text">
                    <i class="bi bi-envelope-fill"></i> 이메일 재전송하기
                </span>
            </button>

            <button type="button" class="button-82-pushable" 
                    id="goToLoginPage" onclick="location.href='/id/login/login.php'" role="button" style=" display: inline-block;">
                <span class="button-82-shadow"></span>
                <span class="button-82-edge"></span>
                <span class="button-82-front text">
                    <i class="bi bi-door-open-fill"></i> 로그인 창으로 이동
                </span>
            </button>
            
        </form>

    </body>

</html>