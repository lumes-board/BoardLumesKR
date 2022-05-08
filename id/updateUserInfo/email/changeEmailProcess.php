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

        <?php

            require("../../../common/dbconnection.php");
            include('../../../common/resource.html');

        ?>

        <?php

            $email = $_GET['email'];
            $id    = $_SESSION['id'];

            if(!filter_Var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {

                // 이메일은 이메일의 형식에 부합해야 하며,
                // 255글자를 넘어갈 수 없음.
        
                ?>
        
                    <script>

                        Swal.fire({
                            icon: 'error',
                            title: '잘못된 이메일 주소',
                            text: '이메일 주소가 유효하지 않습니다.',
                            footer: '이메일 주소는 통상적인 이메일 주소의 형식에 부합해야 하며, 255글자를 넘어갈 수 없습니다.'
                        }).then((result) => {
                            
                            location.href = "./changeEmail.php";

                        })
                        
                    </script>
        
                <?php
        
            } else {

                try{

                    $query = "UPDATE member SET email = :email WHERE id = :id";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR); 
                    $stmt->bindParam(':id', $id, PDO::PARAM_STR);

                    $stmt->execute();

                    // 여기까지 잘 수행된 경우 이메일 업데이트가 잘 된 것

                    ?>

                        <script>

                            Swal.fire({
                                icon: 'success',
                                title: '성공',
                                text: '이메일 주소가 변경되었습니다.',
                                footer: '<b><?php echo $_SESSION['id'] ?></b>님의 이메일 주소는 이제 [<b><?php echo $email ?></b>] 입니다.'
                            }).then((result) => {
                                
                                window.close();

                            })

                        </script>

                    <?php

                } catch(PDOException $PDOerr) {

                    die($PDOerr);

                }

            }

        ?>

    </body>

</html>

