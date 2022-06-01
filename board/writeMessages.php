<?php
    // 이미 상위 파일에 되어 있음.
    // session_start();                                     
    // header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE HTML>

    <head>

        <link rel="stylesheet" href="./board/css/writeMessages.css">

    </head>

    <body>

        <?php if(isset($_SESSION['id'])){ ?>

        <!-- 로그인 된 사람만 글을 쓸 수 있음 -->

        <form action="./board/processMessages.php" method="POST" id="writeMessagesForm">

            <input type="hidden" id="g-recaptcha" name="g-recaptcha">

            <input class="form-control" id="writer" type="text" value="@<?php echo $_SESSION['id'] ?>"readonly>

            <div id="tickerNotification">
                <ul id="tickerNotificationRoller">
                    <li>메시지는 <b><kbd>Ctrl</kbd> + <kbd>Enter</kbd></b> 키로 바로 전송하세요.</li>
                    <li><b>URL</b>을 입력하면 링크가 걸립니다.</li>
                    <li><b><a href="https://github.com/lumes-board/BoardLumesKR">Github</a></b>를 통해 기능을 살펴보세요.</li>
                </ul>
            </div>

            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" id="textLengthProgressBar"
                            role="progressbar" aria-valuenow="75" aria-valuemin="0" 
                            aria-valuemax="100"></div>
            </div>

            <div class="form-floating">
                <textarea class="form-control" id="messageContent" name="message"
                          placeholder="메시지를 남겨보세요... (~1,500 바이트)" id="floatingTextarea"
                          onkeypress="sendMessageViaHotkey(event)" style="height: 100px" autofocus></textarea>
                <label for="floatingTextarea">메시지를 남겨보세요...</label>
            </div>
            
            
            <!-- <button type="submit" class="btn btn-primary float-end" id="messageSubmitButton" style="margin-top: 10px;">메시지 등록하기</button> -->
            <button type="submit" class="button-82-pushable" role="button" id="messageSubmitButton" style="margin-top: 10px;">
                <span class="button-82-shadow"></span>
                <span class="button-82-edge"></span>
                <span class="button-82-front text">
                    메시지 등록하기 <i class="bi bi-shift-fill"></i>
                </span>
            </button>

            <button type="button" id="textLengthStatus" class="btn btn-secondary">
                <span id="textLengthCounter"><i class="bi bi-speedometer"></i> 0 / 1,500 Bytes</span>
            </button>
                        
        </form>

        <?php } else { ?>


        <!-- 로그인을 하지 않아 글을 적을 수 없음 -->
        <form action="" method="" id="writeMessagesForm">

            <input class="form-control" id="writer" type="text" value="@[ANONYMOUS]" readonly>

            <input type="hidden" id="g-recaptcha" name="g-recaptcha">

            <div id="tickerNotification">
                <ul id="tickerNotificationRoller">
                    <li>메시지는 <b><kbd>Ctrl</kbd> + <kbd>Enter</kbd></b> 키로 바로 전송하세요.</li>
                    <li><b>URL</b>을 입력하면 링크가 걸립니다.</li>
                    <li><b><a href="https://github.com/lumes-board/BoardLumesKR">Github</a></b>를 통해 기능을 살펴보세요.</li>
                </ul>
            </div>


            <div class="form-floating">
                <textarea class="form-control" id="messageContent" 
                          placeholder="로그인을 한 사용자만 글을 남길 수 있어요." id="floatingTextarea"
                          style="height: 100px" readonly></textarea>
                <label for="floatingTextarea">로그인을 한 사용자만 글을 남길 수 있어요.</label>
            </div>
                        
        </form>


        <?php } ?>

        <script src="./board/js/countMessageText.js"></script>
        <script src="./board/js/tickerNotification.js"></script>

        <?php include("./common/reCAPTCHA/verify_reCAPTCHA_client.html"); ?>


    </body>

</html>