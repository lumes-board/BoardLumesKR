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

            $nickname = $_GET['nickname'];
            $id       = $_SESSION['id'];

            if(strlen($nickname) > 255) {

                ?>
        
                    <script>

                        Swal.fire({
                            icon: 'error',
                            title: '닉네임 길이 초과',
                            footer: '닉네임 길이는 255 바이트를 초과할 수 없습니다.'
                        }).then((result) => {
                            
                            location.href = "./changeNickname.php";

                        })
                        
                    </script>
        
                <?php

            } else {

                try {

                    $query = "UPDATE member SET nickname = :nickname WHERE id = :id";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':nickname', $nickname, PDO::PARAM_STR); 
                    $stmt->bindParam(':id', $id, PDO::PARAM_STR);

                    $stmt->execute();

                    // 여기까지 잘 수행된 경우 닉네임 업데이트가 잘 된 것

                    ?>

                        <script>

                            Swal.fire({
                                icon: 'success',
                                title: '성공',
                                text: '닉네임이 변경되었습니다.',
                                footer: '<b><?php echo $_SESSION['id'] ?></b>님의 닉네임은 이제 [<b><?php echo $nickname ?></b>] 입니다.'
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