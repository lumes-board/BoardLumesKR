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

        <?php

            require("../../../common/dbconnection.php");
            include('../../../common/resource.html');

        ?> 

        <?php

            $currentPassword = $_GET['currentPassword'];
            $newPassword1    = $_GET['newPassword1'];
            $newPassword2    = $_GET['newPassword2'];

            
            if(strlen($newPassword1) > 255 || strlen($newPassword2) > 255) {

                // 새로운 비밀번호 길이가 제한(255바이트)를 초과하는가?
                ?>
                    <script>

                        Swal.fire({
                            icon: 'error',
                            title: '비밀번호 길이 초과',
                            footer: '새로운 비밀번호는 255글자를 초과할 수 없습니다.'
                        }).then((result) => {
                            location.href = "./changePassword.php";
                        })

                    </script>
                <?php

            } elseif($newPassword1 != $newPassword2) {

                // 새로운 비밀번호 두 개(확인용 포함)가 서로 같은가?
                ?>
                    <script>

                        Swal.fire({
                            icon: 'error',
                            title: '새 비밀번호가 서로 다름',
                            footer: '새로운 비밀번호를 두 번 정확히 동일하게 입력했는지 다시 한번 확인해 주세요.'
                        }).then((result) => {
                            location.href = "./changePassword.php";
                        })

                    </script>
                <?php

            } elseif ($currentPassword === "" || $newPassword1 === "" || $newPassword2 === "") {

                // 새로운 비밀번호 두 개(확인용 포함)가 서로 같은가?
                ?>
                    <script>

                        Swal.fire({
                            icon: 'error',
                            title: '뭔가 허전하군요...',
                            footer: '비밀번호를 바꾸기 위하여, 이전 단계에서 모든 정보를 입력했는지 확인하세요!'
                        }).then((result) => {
                            location.href = "./changePassword.php";
                        })

                    </script>
                <?php

            } else {

            
                try {

                    $id              = $_SESSION['id'];
                    $renewedPassword = password_hash($newPassword1, PASSWORD_DEFAULT);

                    $query = "UPDATE member SET password = :renewedPassword WHERE id = :id";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':renewedPassword', $renewedPassword, PDO::PARAM_STR); 
                    $stmt->bindParam(':id', $id, PDO::PARAM_STR);

                    $stmt->execute();

                    // 여기까지 잘 수행된 경우 비밀번호 업데이트가 잘 된 것

                    ?>

                        <script>

                            Swal.fire({
                                icon: 'success',
                                title: '성공',
                                text: '비밀번호가 변경되었습니다.',
                                footer: '다음 로그인부터는 변경된 비밀번호로 로그인하세요.'
                            }).then((result) => {
                                
                                window.close();

                            })

                        </script>

                    <?php 

                } catch (PDOException $PDOerr) {

                    die($PDOerr);

                }

            }

        ?>

    </body>

</html>