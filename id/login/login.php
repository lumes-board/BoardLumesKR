<?php
    header('Content-Type: text/html; charset=utf-8');
?>

<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>루메스 보드 로그인</title>
        <link rel="stylesheet" href="../../css/font.css">
        <link rel="stylesheet" href="./css/login.css">
        <link rel="shortcut icon" href="../../favicon/favicon.ico">

        <?php include('../../common/resource.html'); ?>


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
        
        <form class="login-form" id="loginForm" action="loginProcess.php" method="POST">

            <h1 id="welcomeText">Identification <i class="bi bi-fingerprint"></i></h1>

            <input type="hidden" id="g-recaptcha" name="g-recaptcha">

            <label for="text">ID</label>
            <div class="form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">
                        <i class="bi bi-person-fill"></i>
                    </span>
                    <input type="id" class="form-control" id="id" name="id" placeholder="ID를 입력하세요..." 
                            required placeholder="Enter Name"
                            oninvalid="this.setCustomValidity('ID를 반드시 입력해 주세요! ><')"
                            oninput="this.setCustomValidity('')">
                </div>
            </div>

            <label for="password">비밀번호</label>
            <div class="form-group">
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">
                        <i class="bi bi-key-fill"></i>
                    </span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="패스워드를 입력하세요! 쉿! 들키지 않게.."
                            required placeholder="Enter Name"
                            oninvalid="this.setCustomValidity('비밀번호도 꼭 입력해 주세요! >_<')"
                            oninput="this.setCustomValidity('')">
                </div>
            </div>

            <button class="button-82-pushable d-flex justify-content-centers" type="submit" id="loginButton" role="button">
                <span class="button-82-shadow"></span>
                <span class="button-82-edge"></span>
                <span class="button-82-front text">
                    LOGIN
                </span>
            </button>

        </form>

    </body>

    <?php include("../../common/reCAPTCHA/verify_reCAPTCHA_client.html"); ?>

</html>