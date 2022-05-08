<?php
   session_start();
   header('Content-Type: text/html; charset=utf-8');
   header("Pragma: no-cache");
   header("Cache-Control: no-store, no-cache, must-revalidate"); 
?>

<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>루메스 보드 마이페이지</title>
        <link rel="stylesheet" href="../../css/font.css">
        <link rel="stylesheet" href="./css/mypage.css">
        <link rel="shortcut icon" href="../../favicon/favicon.ico">

        <?php include('../../common/resource.html'); ?>

    </head>

    <body>
        
        <?php include('../../navbar.php'); ?>

        <?php 

            // 유저 정보 테이블에 사용될 정보를 가져오기
            $query = "SELECT * FROM member WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR); 
            
            $stmt->execute();

            $userInfoData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $email                  = $userInfoData[0]["email"];
            $nickname               = $userInfoData[0]["nickname"];
            $exp                    = $userInfoData[0]["exp"];
            $expTransactionQty      = $userInfoData[0]["expTransactionQty"];
            $guestbookQty           = $userInfoData[0]["guestbookQty"];

        ?>

        <!-- 유저 정보 테이블 -->
        <table class="table text-center" id="userInfoTable">
            <thead>
                <tr class="table-dark">
                    <th>ID</th>
                    <th>이메일</th>
                    <th>닉네임</th>
                    <th>보유경험치</th>
                    <th>경험치송금량</th>
                    <th>작성한 게시글</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b><?php echo $_SESSION['id'] ?><b></td>
                    <td><?php echo $email ?></td>
                    <td><?php echo $nickname ?></td>
                    <td><?php echo number_format($exp) ?> <span style="color: gray; ">EXP</span></td>
                    <td><?php echo number_format($expTransactionQty) ?> <span style="color: gray; ">EXP</span></td>
                    <td><?php echo number_format($guestbookQty) ?> <span style="color: gray; ">개</span></td>
                </tr>
            </tbody>
        </table>
        <!-- 유저 정보 테이블 끝 -->

    </body>

</html>