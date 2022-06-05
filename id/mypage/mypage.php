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

        <!-- chart -->
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
            $expTransactionQty      = $userInfoData[0]["expTransactionQty"];
            $guestbookQty           = $userInfoData[0]["guestbookQty"];

            // ---------------------------------------------- //
            // 경험치는 따로 가져오기
            $query = "SELECT * FROM exp where id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR); 
            
            $stmt->execute();

            $exp = $stmt->fetch(PDO::FETCH_ASSOC);
            $registrationExp = $exp["registrationExp"];
            $loginExp        = $exp["loginExp"];
            $boardExp        = $exp["boardExp"];
            $exp             = $registrationExp + $loginExp + $boardExp;
            // $exp = $exp[0];

        ?>

        <div class="mypageImages">
            <div class="mypageBackgroundImageCover">
                <img src="/asset/images/defaultMypageBackgroundImage/defaultBG.jpg">
            </div>
            <div class="mypageUserProfileImageCover" id="mypageUserProfileImageCover">
                <!-- 유저 프로필 사진 -->
                <?php

                    $profileImagePath = "../../asset/userdata/profilePicture/{$_SESSION['id']}.png";
                    if(file($profileImagePath)){
                        // 유저가 설정한 프로필 사진이 있음
                        echo '<img src="' . $profileImagePath . '" id="mypageUserProfileImage">';
                    }else{
                        // 유저가 설정한 프로필 사진이 없음 --> default 사진 적용
                        echo '<img src="/asset/images/defaultMypageProfileImage/defaultProfile.png" id="mypageUserProfileImage">';
                    }

                ?>
                <h5 class="profileImageOverlay" onclick="window.open('/id/updateUserInfo/profile/uploadProfilePicture.php')">
                    클릭해 프로필 <br>
                    사진 변경
                </h5>
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
                <!-- <button class="changeUserInfoButton" role="button" onclick="window.open('/id/updateUserInfo/profile/changeProfilePicture.php')">프로필 사진 변경</button> -->
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
            <div class="userExpChart">
                <canvas id="userExpChartByJS"></canvas>
            </div>
            <div class="userExpTable">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align: center;">항목</th>
                            <th scope="col" style="text-align: center;">EXP</th>
                            <th scope="col" style="text-align: center;">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row"  style="text-align: center; color:#AD5600;">회원가입</th>
                            <td style="text-align: right;"><?php echo number_format($registrationExp) ?></td>
                            <td style="text-align: right;"><?php echo round(($registrationExp / $exp) * 100, 2) ?>%</td>
                        </tr>
                        <tr>
                            <th scope="row"  style="text-align: center; color:#FF0062;">로그인</th>
                            <td style="text-align: right;"><?php echo number_format($loginExp) ?></td>
                            <td style="text-align: right;"><?php echo round(($loginExp / $exp) * 100, 2) ?>%</td>
                        </tr>
                        <tr>
                            <th scope="row"  style="text-align: center; color:#009EE5;">게시판 글쓰기</th>
                            <td style="text-align: right;"><?php echo number_format($boardExp) ?></td>
                            <td style="text-align: right;"><?php echo round(($boardExp / $exp) * 100, 2) ?>%</td>
                        </tr>
                        <tr>
                            <th scope="row"  style="text-align: center;">총합</th>
                            <td style="text-align: right; font-weight: bold;"><?php echo number_format($exp) ?></td>
                            <td style="text-align: right;">100.00%</td>
                        </tr>
                    </tbody>
                </table>
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
            data: [
                <?php echo $registrationExp ?>, 
                <?php echo $loginExp ?>,
                <?php echo $boardExp ?>
            ],
            backgroundColor: [
                '#AD5600',
                '#FF0062',
                '#009EE5'
            ],
            hoverOffset: 4
        }],
    };
    
    let userExpChart = new Chart(context, {
            type: 'doughnut',
            data: data
        });
</script>