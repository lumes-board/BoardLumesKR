<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <a class="navbar-brand" href="./index.php">📟 board.lumes.kr</a>

        <!-- 메뉴 고르기 -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="http://lumes.kr">LUMES.KR로 돌아가기</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        더 알아보기
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" target="_blank"
                                href="https://github.com/lumes-board/BoardLumesKR">📜 Github</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                            <li><a class="dropdown-item" target="_blank" href="https://blog.naver.com/agerio100">📘 개발자 블로그</a>
                        </li>
                            <li><a class="dropdown-item" target="_blank" href="https://twitter.com/LUM1N1OUS">📢 개발자 트위터</a>
                        </li>
                        </li>
                            <li><a class="dropdown-item" target="_blank" href="#">✨ Hall of Fame</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="http://cvs.lumes.kr" tabindex="-1" aria-disabled="true">(누를 수 없는
                        버튼!)</a>
                </li>
            </ul>
        </div>
        <!-- 메뉴 고르기 끝 -->

        <?php 
        
            if(isset($_SESSION)) {

                require("./common/dbconnection.php");

                // 경험치(exp)에 대한 내용은 세션과 데이터베이스 간 차이로부터 발생하는
                // 오류를 없애기 위해 무조건 DB에서 데이터를 그때그때 받아와서 사용
                header('Content-Type: text/html; charset=utf-8');

                $query = "SELECT * FROM member where id = :id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR); 

                $stmt->execute();

                $userInformation = $stmt->fetchAll();
                $userInformation = $userInformation[0];

                $exp = $userInformation['exp'];

                // 중간에 계정 정지당한 경우
                if($userInformation['password'] === "redacted") {

                    ?>

                        <script>

                            Swal.fire({
                                icon: 'error',
                                title: '계정 영구 정지 알림',
                                text: '',
                                footer: '심각한 수준의 서비스 정책 위반이 확인되어 계정이 영구 정지되었습니다.'
                            }).then((result) => {
                                location.href = "./logout/logoutProcess.php";
                            });

                        </script>

                    <?php

                    die();

                }
            
        ?>

        <div id="buttons-for-logged-user">

            <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" id="exp"
                data-placement="bottom" title="성공적으로 로그인하셨어요!">
                경험치 : <?php echo number_format($exp); ?> EXP
            </button>
            <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" id="loggeduser"
                data-placement="bottom" title="성공적으로 로그인하셨어요!">
                <?php echo $_SESSION['id'] ?>님
            </button>
            <!-- <a role="button" class="btn btn-primary" href="/mypage/mypage.php">
                마이페이지
            </a> -->
            <!-- 마이페이지는 차후에 구현하도록 하자. -->
            <button type="button" class="btn btn-danger" id="logout" data-container="body" data-toggle="popover"
                data-placement="bottom" title="세션을 파기합니다.">
                로그아웃
            </button>

        </div>

        <script src="./js/navbar_toast.js"></script>

        <?php

            } else {

        ?>

        <!-- 버튼 -->
        <button class="btn btn-success navbar-button" type="button" onclick="location.href='./id/signup/signup.php'">회원가입</button>
        <button class="btn btn-primary navbar-button" type="button" onclick="location.href='./id/login/login.php'">로그인</button>
        <!-- 버튼 끝 -->

        <?php

            }

        ?>

    </div>
</nav>