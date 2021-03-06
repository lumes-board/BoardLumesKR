<?php
    session_start();
    header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>루메스 보드</title>
        <link rel="stylesheet" href="./css/index.css">
        <link rel="stylesheet" href="./css/navbar.css">
        <link rel="stylesheet" href="./css/font.css">
        <link rel="shortcut icon" href="./favicon/favicon.ico">

        <!-- CDN 관련 자료들을 한번에 관리 -->
        <?php include('./common/resource.html') ?>


    </head>

    <body>

        <!-- 네비게이션 바 -->
        <?php include("navbar.php"); ?>

        <!-- 보드(게시판) -->
        <?php include("board/writeMessages.php"); ?>
        <?php include("board/showMessages.php"); ?>
        <script src="./board/js/urlify.js"></script>

        <?php if(isset($_SESSION['id'])){ ?>
            <!-- session이 있을 경우 필요한 파일 -->
            <script src="./board/js/hotkeyToSendMessage.js"></script>
        <?php } ?>
        

    </body>

</html>