<?php
    header('Content-Type: text/html; charset=utf-8');
?>

<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ID 유효성 검사</title>
        <link rel="shortcut icon" href="../../favicon/favicon.ico">
    </head>

</html>

<?php 


    include('../../common/resource.html');
    require('../../common/dbconnection.php');

    $id = $_GET['id'];

    if (!preg_match("/^[a-z0-9_]+$/", $id) && strlen($id) <= 30) {

        // ID가 영어소문자, 숫자, 그리고 언더바(_)로만 이루어졌는지,
        // 그리고 ID의 길이가 30바이트 이하인지 확인하고, 그렇지 못한 경우 경고 출력

        ?>

            <script>
                Swal.fire({
                    icon: 'error',
                    title: '잘못된 ID',
                    text: '만드신 ID가 정해진 기준을 충족시키지 못합니다.',
                    footer: 'ID는 반드시 1글자 이상의 영어 대소문자, 숫자, 그리고 언더바(_)로만 이루어져야 하며, 30바이트를 초과할 수 없습니다.'
                }).then((result) => {
                    location.href = "./signup.php";
                })
                
            </script>

        <?php

    } else {

        $query = "SELECT * FROM member WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $id);

        $stmt->execute();

        $IDExistence = mysqli_fetch_array($stmt->get_result());

        if($IDExistence === NULL) {
            
            // ID가 유일하므로, 사용이 가능함
            ?>

                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Look Good!',
                        text: '해당 ID는 사용가능합니다.',
                    }).then((result) => {
                        location.href = "./signup.php";
                    })
                </script>

            <?php

        } else {
            
            // ID를 누군가가 쓰고 있으므로, 사용 불가.
            ?>

                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Already taken...',
                        text: '해당 ID는 누가 사용중입니다.',
                        footer: '다른 고유한 ID를 만들어 보세요!'
                    }).then((result) => {
                        location.href = "./signup.php";
                    })
                </script>

            <?php

        }

        $stmt->close();
        $conn->close();


    }
    
?>