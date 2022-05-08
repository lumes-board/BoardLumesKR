<?php

    session_start();
    header('Content-Type: text/html; charset=utf-8');

?>

<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>이메일 변경하기</title>
        <link rel="stylesheet" href="../../../css/font.css">
        <link rel="shortcut icon" href="../../../favicon/favicon.ico">

    </head>

    <body>

        <?php include('../../../common/resource.html'); ?>

        <script>
            Swal.fire({
                title: '📧 이메일 주소 변경',
                html: '<input type="email" id="email" class="swal2-input" placeholder="새로운 이메일 주소...">',
                confirmButtonText: '변경하기',
                allowOutsideClick: false,
                allowEscapeKey: false,
                focusConfirm: false,
                preConfirm: () => {
                    const email = Swal.getPopup().querySelector('#email').value
                    return {
                        email: email
                    }
                }
            }).then((result) => {

                location.href = "./changeEmailProcess.php?email=" + result.value.email;

            })

        </script>

    </body>

</html>