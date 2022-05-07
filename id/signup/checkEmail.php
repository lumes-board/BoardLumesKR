<?php
    header('Content-Type: text/html; charset=utf-8');
?>

<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>이메일 유효성 검사</title>
        <link rel="shortcut icon" href="../../favicon/favicon.ico">
    </head>

</html>

<?php 


    include('../../common/resource.html');
    require('../../common/dbconnection.php');

    $email = $_GET['email'];

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
                    location.href = "./signup.php";
                })
                
            </script>

        <?php

    } else {

        $query = "SELECT * FROM member WHERE email = :emailInput";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':emailInput', $email, PDO::PARAM_STR); 
        
        $stmt->execute();

        $EmailExistence = $stmt->fetchAll(PDO::FETCH_NUM);

        if(empty($EmailExistence)) {

            // 이메일이 유일하므로, 사용이 가능함
            ?>

                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Look Good!',
                        text: '해당 Email 주소는 사용가능합니다.',
                    }).then((result) => {
                        location.href = "./signup.php";
                    })
                </script>

            <?php

        } else {

            // 다른 누군가가 이미 해당 이메일 주소를 사용하고 있으므로, 사용이 불가함.
            ?>

                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Already taken...',
                        text: '해당 Email 주소는 누가 사용중입니다.',
                        footer: '이미 등록된 계정이 있지 않은지 생각해보시거나, 다른 Email 주소를 사용해 주세요.'
                    }).then((result) => {
                        location.href = "./signup.php";
                    })
                </script>

            <?php

        }

    }

?>