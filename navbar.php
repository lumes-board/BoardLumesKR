<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <a class="navbar-brand" href="/index.php">๐ board.lumes.kr</a>

        <!-- ๋ฉ๋ด ๊ณ ๋ฅด๊ธฐ -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="http://lumes.kr">LUMES.KR๋ก ๋์๊ฐ๊ธฐ</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        ๋ ์์๋ณด๊ธฐ
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" target="_blank"
                                href="https://github.com/lumes-board/BoardLumesKR">๐ Github</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                            <li><a class="dropdown-item" target="_blank" href="https://blog.naver.com/agerio100">๐ ๊ฐ๋ฐ์ ๋ธ๋ก๊ทธ</a>
                        </li>
                            <li><a class="dropdown-item" target="_blank" href="https://twitter.com/LUM1N1OUS">๐ข ๊ฐ๋ฐ์ ํธ์ํฐ</a>
                        </li>
                        </li>
                            <li><a class="dropdown-item" target="_blank" href="#">โจ Hall of Fame</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="http://cvs.lumes.kr" tabindex="-1" aria-disabled="true">(๋๋ฅผ ์ ์๋
                        ๋ฒํผ!)</a>
                </li>
            </ul>
        </div>
        <!-- ๋ฉ๋ด ๊ณ ๋ฅด๊ธฐ ๋ -->

        <?php 
        
            if(isset($_SESSION['id'])) {

                require(dirname(__FILE__) . "/common/dbconnection.php");

                // ๊ฒฝํ์น(exp)์ ๋ํ ๋ด์ฉ์ ์ธ์๊ณผ ๋ฐ์ดํฐ๋ฒ ์ด์ค ๊ฐ ์ฐจ์ด๋ก๋ถํฐ ๋ฐ์ํ๋
                // ์ค๋ฅ๋ฅผ ์์ ๊ธฐ ์ํด ๋ฌด์กฐ๊ฑด DB์์ ๋ฐ์ดํฐ๋ฅผ ๊ทธ๋๊ทธ๋ ๋ฐ์์์ ์ฌ์ฉ
                header('Content-Type: text/html; charset=utf-8');

                $query = "SELECT registrationExp + loginExp + boardExp FROM exp where id = :id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR); 

                $stmt->execute();

                $exp = $stmt->fetch(PDO::FETCH_NUM);
                $exp = $exp[0];

                // ---------------------------------------------------------- //

                $query = "SELECT * FROM member where id = :id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR); 
                $stmt->execute();

                $userInformation = $stmt->fetchAll();
                $userInformation = $userInformation[0];

                // ์ค๊ฐ์ ๊ณ์  ์ ์ง๋นํ ๊ฒฝ์ฐ
                if($userInformation['password'] === "redacted") {

                    ?>

                        <script>

                            Swal.fire({
                                icon: 'error',
                                title: '๊ณ์  ์๊ตฌ ์ ์ง ์๋ฆผ',
                                text: '',
                                footer: '์ฌ๊ฐํ ์์ค์ ์๋น์ค ์ ์ฑ ์๋ฐ์ด ํ์ธ๋์ด ๊ณ์ ์ด ์๊ตฌ ์ ์ง๋์์ต๋๋ค.'
                            }).then((result) => {
                                location.href = "./id/logout/logoutProcess.php";
                            });

                        </script>

                    <?php

                    die();

                }
            
        ?>

        <div id="buttons-for-logged-user">

            <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" id="exp"
                data-placement="bottom" title="์ฑ๊ณต์ ์ผ๋ก ๋ก๊ทธ์ธํ์จ์ด์!">
                ๊ฒฝํ์น : <?php echo number_format($exp); ?> EXP
            </button>
            <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" id="loggeduser"
                data-placement="bottom" title="์ฑ๊ณต์ ์ผ๋ก ๋ก๊ทธ์ธํ์จ์ด์!">
                <?php echo $_SESSION['id'] ?>๋
            </button>
            <a role="button" class="btn btn-primary" href="/id/mypage/mypage.php">
                ๋ง์ดํ์ด์ง
            </a>
            <button type="button" class="btn btn-danger" id="logout" data-container="body" data-toggle="popover"
                data-placement="bottom" title="์ธ์์ ํ๊ธฐํฉ๋๋ค.">
                ๋ก๊ทธ์์
            </button>

        </div>

        <script src="/js/navbar_toast.js"></script>

        <?php

            } else {

        ?>

        <!-- ๋ฒํผ -->
        <button class="btn btn-success navbar-button" type="button" onclick="location.href='/id/signup/signup.php'">ํ์๊ฐ์</button>
        <button class="btn btn-primary navbar-button" type="button" onclick="location.href='/id/login/login.php'">๋ก๊ทธ์ธ</button>
        <!-- ๋ฒํผ ๋ -->

        <?php

            }

        ?>

    </div>
</nav>