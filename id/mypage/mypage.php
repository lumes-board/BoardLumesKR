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

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        <div class="mypageImages">
            <div class="mypageBackgroundImageCover">
                <img src="/asset/images/defaultMypageBackgroundImage/defaultBG.jpg">
            </div>
            <div class="mypageUserProfileImageCover">
                <img src="/asset/images/defaultMypageProfileImage/defaultProfile.png">
            </div>
        </div>

        <div class="userInfoBrief">
            <div class="userID">
                <b>
                    <!-- 참조 구문 연장을 통해 at기호와 ID 붙이기 -->
                    <span class="atMarkID">@ </span><!--
                    --><span><?php echo $_SESSION['id'] ?></span>
                    <!-- 유저 뱃지 -->
                </b>
            </div>
            <div class="userNickname">
                <i class="bi bi-pen-fill"></i>
                <?php echo $nickname ?>
            </div>
            <div class="userEmail">
                <i class="bi bi-envelope"></i>
                <?php echo $email ?>
            </div>
            <div class="btn-group me-2 changeInfoGroup">
                <button class="changeUserInfoButton" role="button" onclick="window.open('/id/updateUserInfo/email/changeEmail.php')">이메일 변경</button>
                <button class="changeUserInfoButton" role="button" onclick="window.open('/id/updateUserInfo/nickname/changeNickname.php')">닉네임 변경</button>
                <button class="changeUserInfoButton" role="button" onclick="window.open('/id/updateUserInfo/password/changePassword.php')">비밀번호 변경</button>
            </div>
        </div>

        <div class="userExpStatus">
            <div class="statTabTitle">
                <i class="bi bi-pie-chart-fill"></i> 경험치
            </div>
            <span class="userExpDigit">
                <?php echo number_format($exp) ?>
            </span>
            <span class="userExpUnit">
                EXP
            </span>
            <div class="userExpChart" >
                <canvas id="userExpChartByJS"></canvas>
            </div>
        </div>

    </body>

</html>

<script>

    let context = document
                .getElementById('userExpChartByJS')
                .getContext('2d');
    
    const data = {
        // labels: [
        //     'Red',
        //     'Blue',
        //     'Yellow'
        // ],
        datasets: [{
            label: '경험치 세트',
            data: [<?php echo $exp ?>, 50, 100],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
        }],
    };
    
    let userExpChart = new Chart(context, {
            type: 'doughnut',
            data: data
        });
</script>