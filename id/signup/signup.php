<?php
    header('Content-Type: text/html; charset=utf-8');
?>

<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>루메스 보드 회원가입</title>
        <link rel="stylesheet" href="../../css/font.css">
        <link rel="stylesheet" href="./css/signup.css">
        <link rel="shortcut icon" href="../../favicon/favicon.ico">

        <?php include('../../common/resource.html'); ?>

        <script src="https://www.google.com/recaptcha/api.js?render=6Ld14s4fAAAAADbIq8oIF47X45r0puf3z44EC69z"></script>


    </head>

    <body>

        <!-- 간단한 상단 바 -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">

                <a class="navbar-brand" href="../../index.php">📟 board.lumes.kr</a>

                <!-- 메뉴 고르기 -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="http://lumes.kr">LUMES.KR로 돌아가기</a>
                        </li>
                    </ul>
                </div>
                <!-- 메뉴 고르기 끝 -->

            </div>
        </nav>
        <!-- 간단한 상단 바 끝 -->

        <!-- 회원가입 폼 -->
        <form class="registration-form" action="signupProcess.php" enctype="multipart/form-data" method="POST">

            <h3 id="welcomeText">WELCOME! 👋</h3>

            <input type="hidden" id="g-recaptcha" name="g-recaptcha">

            <div class="row">
                <div class="col-md-10 form-floating">
                    <input type="text" class="form-control" name="userID" id="userID" placeholder="&nbsp;&nbsp;ID" aria-describedby="userIDHelp">
                    <label for="userID">&nbsp;&nbsp;ID</label>
                    <div id="userIDHelp" class="form-text">~30바이트, ID로는 영어소문자/숫자/언더바(_)만 사용하실 수 있습니다.</div>
                </div>
                <div class="col">
                    <button type="button" id="checkIDValidityButton" class="btn btn-secondary">ID Check</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10 form-floating">
                    <input type="text" class="form-control" name="userNickname" id="userNickname" placeholder="&nbsp;&nbsp;유저 닉네임" aria-describedby="userNicknameHelp">
                    <label for="userNickname">&nbsp;&nbsp;유저 닉네임</label>
                    <div id="userNicknameHelp" class="form-text">~255바이트, 여기서 사용할 닉네임을 만드세요.</div>
                </div>
                <div class="col">
                    <!-- do nothing, just for aligning -->
                </div>
            </div>

            <div class="row">
                <div class="col-md-10 form-floating">
                    <div class="row">
                        <div class="col form-floating">
                            <input type="password" class="form-control" name="userPassword1" id="userPassword1" placeholder="&nbsp;&nbsp;비밀번호">
                            <label for="userPassword1">&nbsp;&nbsp;비밀번호</label>
                        </div>

                        <div class="col form-floating">
                            <input type="password" class="form-control" name="userPassword2" id="userPassword2" placeholder="&nbsp;&nbsp;비밀번호(재입력)">
                            <label for="userPassword2">&nbsp;&nbsp;비밀번호(재입력)</label>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <!-- do nothing, just for aligning -->
                </div>
            </div>


            <div class="row">
                <div class="col-md-10 form-floating">
                    <input type="email" class="form-control" name="userEmail" id="userEmail" placeholder="&nbsp;&nbsp;유저 이메일" aria-describedby="userEmailHelp">
                    <label for="userEmail">&nbsp;&nbsp;이메일 주소</label>
                    <div id="userEmailHelp" class="form-text">나중에 인증 등에 필요할 수 있으니 사용하시는 이메일 주소를 입력하세요.</div>
                </div>
                <div class="col">
                    <button type="button" id="checkEmailValidityButton" class="btn btn-secondary">E-mail Check</button>
                </div>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    나는 <a href="../../common/userLicense.html" target="_blank"><b>취약점 제보 등의 내용을 포함한 모든 사용약관</b></a>을 숙지하고 동의합니다.
                </label>
            </div>

            <button type="button" id="registrationSubmitButton" class="btn btn-primary">가입하기</button>

        </form>
        <!-- 회원가입 폼 끝 -->

        <script src="./signupValidation.js"></script>

        <script>
            grecaptcha.ready(function () {
                grecaptcha.execute('6Ld14s4fAAAAADbIq8oIF47X45r0puf3z44EC69z', {
                    action: 'homepage'
                }).then(function (token) {
                    document.getElementById('g-recaptcha').value = token;
                });
            });
        </script>

    </body>

</html>