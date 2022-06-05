<?php

    session_start();
    header('Content-Type: text/html; charset=utf-8');

?>

<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>프로필 사진 변경하기</title>
        <link rel="stylesheet" href="../../../css/font.css">
        <link rel="shortcut icon" href="../../../favicon/favicon.ico">

        <link rel="stylesheet" href="./css/uploadProfilePicture.css">


    </head>

    <?php include('../../../common/resource.html'); ?>

    <body>

        <div id="content">

            <h3 id="title">프로필 사진 변경</h3>
            
            <!-- go to <method="POST" action="processProfileImage.php"> -->
            <form id="profileImageUploadForm" enctype="multipart/form-data" style="text-align: center;" onsubmit="return false;"> 

                <label for="formFile" class="form-label">이미지 파일을 올려보세요.</label>
                <input type="file" class="form-control" id="userSubmittedProfileImage" name="profileImage">
                <button class="button-30" role="button" id="profileImageUploadFormSubmitButton">제출</button>

            </form>
            <script src="./js/checkFile.js"></script>

        </div>

    </body>

</html>