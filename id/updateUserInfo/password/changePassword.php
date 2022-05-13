<?php

    session_start();
    header('Content-Type: text/html; charset=utf-8');

?>

<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>비밀번호 변경하기</title>
        <link rel="stylesheet" href="../../../css/font.css">
        <link rel="shortcut icon" href="../../../favicon/favicon.ico">

    </head>

    <body>

        <?php include('../../../common/resource.html'); ?>

        <script>
            Swal.fire({
                title: '📝 비밀번호 변경',
                html: `<input type="password" id="currentPassword" class="swal2-input" placeholder="현재 비밀번호">
                       <input type="password" id="newPassword1" class="swal2-input" placeholder="새 비밀번호...">
                       <input type="password" id="newPassword2" class="swal2-input" placeholder="새 비밀번호(재입력)...">`,
                confirmButtonText: '변경하기',
                allowOutsideClick: false,
                allowEscapeKey: false,
                focusConfirm: false,
                preConfirm: () => {
                    const currentPassword = Swal.getPopup().querySelector('#currentPassword').value;
                    const newPassword1 = Swal.getPopup().querySelector('#newPassword1').value;
                    const newPassword2 = Swal.getPopup().querySelector('#newPassword2').value;
                    return {
                        currentPassword : currentPassword,
                        newPassword1 : newPassword1,
                        newPassword2 : newPassword2
                    }
                }
            }).then((result) => {

                location.href = "./changePasswordProcess.php?currentPassword=" + result.value.currentPassword + "&newPassword1=" + result.value.newPassword1 + "&newPassword2=" + result.value.newPassword2;

            })

        </script>

    </body>

</html>