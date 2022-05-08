<?php

    session_start();
    header('Content-Type: text/html; charset=utf-8');

?>

<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>닉네임 변경하기</title>
        <link rel="stylesheet" href="../../../css/font.css">
        <link rel="shortcut icon" href="../../../favicon/favicon.ico">

    </head>

    <body>

        <?php include('../../../common/resource.html'); ?>

        <script>
            Swal.fire({
                title: '📝 닉네임 변경',
                html: '<input type="text" id="nickname" class="swal2-input" placeholder="새로운 닉네임...">',
                confirmButtonText: '변경하기',
                allowOutsideClick: false,
                allowEscapeKey: false,
                focusConfirm: false,
                preConfirm: () => {
                    const nickname = Swal.getPopup().querySelector('#nickname').value
                    return {
                        nickname, nickname
                    }
                }
            }).then((result) => {

                location.href = "./changeNicknameProcess.php?nickname=" + result.value.nickname;

            })

        </script>

    </body>

</html>