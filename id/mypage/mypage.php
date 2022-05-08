<?php
   session_start();
   header('Content-Type: text/html; charset=utf-8');
   header("Pragma: no-cache");
   header("Cache-Control: no-store, no-cache, must-revalidate"); 
?>

<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>루메스 보드 마이페이지</title>
        <link rel="stylesheet" href="../../css/font.css">
        <link rel="stylesheet" href="./css/mypage.css">
        <link rel="shortcut icon" href="../../favicon/favicon.ico">

        <?php include('../../common/resource.html'); ?>

    </head>

    <body>
        
        <?php include('../../navbar.php'); ?>

    </body>

</html>