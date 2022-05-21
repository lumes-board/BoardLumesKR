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

        <form action="./processMessage.php" method="POST" id="writeMessagesForm">

            <input class="form-control" id="writer" type="text" value="@<?php echo $_SESSION['id'] ?>"readonly>

            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" id="textLengthProgressBar"
                            role="progressbar" aria-valuenow="75" aria-valuemin="0" 
                            aria-valuemax="100"></div>
            </div>

            <div class="form-floating">
                <textarea class="form-control" id="messageContent" 
                          placeholder="메시지를 남겨보세요... (~1,500 바이트)" id="floatingTextarea"
                          style="height: 100px"></textarea>
                <label for="floatingTextarea">메시지를 남겨보세요...</label>
            </div>
            
            
            <button type="button" class="btn btn-primary float-end" style="margin-top: 10px;">메시지 등록하기</button>
            

            <button type="button" id="textLengthStatus" class="btn btn-secondary">
                <span id="textLengthCounter">0 / 1,500 Bytes</span>
            </button>
                        
        </form>

        <?php } else { ?>


        <!-- 로그인을 하지 않아 글을 적을 수 없음 -->
        <form action="" method="" id="writeMessagesForm">

            <input class="form-control" id="writer" type="text" value="@[ANONYMOUS]" readonly>


            <div class="form-floating">
                <textarea class="form-control" id="messageContent" 
                          placeholder="로그인을 한 사용자만 글을 남길 수 있어요." id="floatingTextarea"
                          style="height: 100px" readonly></textarea>
                <label for="floatingTextarea">로그인을 한 사용자만 글을 남길 수 있어요.</label>
            </div>
                        
        </form>


        <?php } ?>

        <script src="./board/js/countmessageText.js"></script>


    </body>

</html>