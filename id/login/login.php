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
        
        <form class="login-form" action="loginProcess.php" method="POST">

            <h1 id="welcomeText">🚀 LOGIN</h1>

            <input type="hidden" id="g-recaptcha" name="g-recaptcha">

            <div class="form-group">
                <label for="text">ID</label>
                <input type="id" class="form-control" id="id" name="id" placeholder="ID를 입력하세요.">
            </div>
            <div class="form-group">
                <label for="password">비밀번호</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="패스워드를 입력하세요! 쉿! 들키지 않게..">
            </div>

            <!-- <button type="submit" id="loginButton" class="btn btn-primary d-flex justify-content-center"><b>로그인!</b></button> -->
            <button type="submit" id="loginButton" class="cybr-btn d-flex justify-content-center">
                LOGIN<span aria-hidden>_</span>
                <span aria-hidden class="cybr-btn__glitch">LOGIN_</span>
                <span aria-hidden class="cybr-btn__tag">GO?</span>
            </button>

        </form>

    </body>

    <?php include("../../common/reCAPTCHA/verify_reCAPTCHA_client.html"); ?>

</html>