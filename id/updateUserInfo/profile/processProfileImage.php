<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>프로필 사진 변경하기</title>
        <link rel="stylesheet" href="../../../css/font.css">
        <link rel="shortcut icon" href="../../../favicon/favicon.ico">

        <link rel="stylesheet" href="./css/uploadProfilePicture.css">

        <?php include('../../../common/resource.html'); ?>

        <!-- <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.11/dist/cropper.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.11/dist/cropper.css" rel="stylesheet"> -->


    </head>

    <body>

    </body>

</html>

<style>
    #cropperjs {
        display: block;
        max-width: 100%;
    }

    #preview {
        width: 200px;
        height: 200px;
        margin-bottom: 10px;
        border-radius: 100%;
    }

</style>

<?php

    session_start();
    header('Content-Type: text/html; charset=utf-8');

    if(!isset($_FILES)) {

        ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: ':/',
                    footer: '파일이 업로드되지 않았습니다.'
                }).then((result) => {
                    location.href = "./uploadProfilePicture.php";
                })
            </script>
        <?php       

        die();

    }

    $tempFile = $_FILES['profileImage']['tmp_name'];

    $fileTypeExtension = explode("/", $_FILES['profileImage']['type']);
    $fileType = $fileTypeExtension[0];
    $fileExtension = $fileTypeExtension[1];

    $isExtensionAllowable = false;


    switch($fileExtension){
        case 'jpeg':
        case 'jpg':
        case 'gif':
        case 'bmp':
        case 'png':
            $isExtensionAllowable = true;
            break;
        
        default:
            ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: '형식 오류',
                        footer: '사진 파일(jpeg, jpg, gif, bmp, png)만 업로드 가능합니다.'
                    }).then((result) => {
                        location.href = "./uploadProfilePicture.php";
                    })
                </script>
            <?php

            exit;
            die();
    }

    if($fileType === "image"){

        if($isExtensionAllowable === true) {

            // 허용하는 종류의 파일만 업로드를 허가함
            try {

                $savePath = "../../../asset/userdata/profilePicture/{$_SESSION['id']}.png";
                move_uploaded_file($tempFile, $savePath);

                // cropper.js? (future plan)
                ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: '사진 업로드 완료',
                        footer: '프로필 사진이 성공적으로 갱신되었습니다.',
                        imageUrl: '<?php echo $savePath ?>',
                        imageHeight: 400,
                    }).then((result) => {
                        window.close();
                    })
                </script>
            <?php

            } catch (Exception $err) {
                die($err -> getMessage());
            }

        } 

    } else {
        
        ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '이미지 파일 아님',
                    footer: '이미지 파일만 올려주세요.'
                }).then((result) => {
                    location.href = "./uploadProfilePicture.php";
                })
            </script>
        <?php
    }

?>