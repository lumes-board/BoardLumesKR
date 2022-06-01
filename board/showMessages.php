<html>

    <head>

        <!-- 기본적으로 필요한 resource들은 이 파일이 소속된 /index.html에 전부 연결되어 있음. -->
        <link rel="stylesheet" href="./board/css/showMessages.css">

    </head>

    <body>
        
    </body>

</html>

<?php

    require("./common/dbconnection.php");


    // 페이지네이션(pagination)
    $paginationLimit = 20;

    if(isset($_GET["page"])){
        $page = intval($_GET["page"]);
    } else {
        $page = 1;
    }

    $paginationStart = ($page - 1) * $paginationLimit;

    // 총 페이지 개수 계산하기
    $query = "SELECT count(board.idx)
                FROM board, member
                    WHERE board.id = member.id";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $rowsCount = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $totalPage = intval(ceil($rowsCount[0]['count(board.idx)'] / $paginationLimit));

    // var_dump($rowsCount);
    // var_dump($totalPage);
    // var_dump($paginationStart);
    // var_dump($paginationLimit);

    // $query = "SELECT * FROM board ORDER BY idx DESC LIMIT 50";

    // 데이터 가져오기
    $query = "SELECT board.*, member.role, member.nickname
                FROM board, member 
                    WHERE board.id = member.id 
                        ORDER BY board.idx DESC
                        LIMIT :paginationStart, :paginationLimit";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":paginationStart", $paginationStart, PDO::PARAM_INT);
    $stmt->bindParam(":paginationLimit", $paginationLimit, PDO::PARAM_INT);
    $stmt->execute();

    $boardData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 페이지네이션 선택 바 (유저들이 클릭해서 보는 부분)
    function showPaginationBar($page, $totalPage){
        echo '<div style="margin-top: 60px;" id="messagePaginationBar">';
            echo '<ul class="pagination justify-content-center">';

                echo '<li class="page-item">';
                    echo '<a class="page-link" href="?page=1">맨 처음 페이지</a>';
                echo '</li>';
                
                // previous button
                if($page === 1){
                    // 맨 처음 페이지인 경우 이전 페이지 버튼 사용 불가
                    echo '<li class="page-item disabled">';
                        echo '<a class="page-link" href="#" tabindex="-1">이전 페이지</a>';
                    echo '</li>';
                }else{
                    echo '<li class="page-item">';
                        echo '<a class="page-link" href="?page='.($page - 1).'">이전 페이지</a>';
                    echo '</li>';
                }

                // selection button
                for($pageSequence = $page - 5; $pageSequence <= $page + 5; $pageSequence++){
                    if($pageSequence < 1)
                        continue;
                    if($pageSequence === $page){
                        echo '<li class="page-item active" aria-current="page">';
                            echo '<a class="page-link" href="?page='.$pageSequence.'">'.$pageSequence.'</a>';
                        echo '</li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="?page='.$pageSequence.'">'.$pageSequence.'</a></li>';
                    }
                    if($pageSequence >= $totalPage)
                        break;
                }

                // next button
                if($page === $totalPage){
                    // 맨 마지막 페이지인 경우 다음 페이지 버튼 사용 불가
                    echo '<li class="page-item disabled">';
                        echo '<a class="page-link" href="#" tabindex="-1">다음 페이지</a>';
                    echo '</li>';
                } else {
                    echo '<li class="page-item">';
                        echo '<a class="page-link" href="?page='.($page + 1).'">다음 페이지</a>';
                    echo '</li>';
                }

                echo '<li class="page-item">';
                    echo '<a class="page-link" id="lastpage" href="?page='.($totalPage).'">마지막 페이지</a>';
                echo '</li>';

            echo '</ul>';
        echo '</div>';
    }
        
    
    
    showPaginationBar($page, $totalPage);
    



    echo '<table class="table" id="messageTable">';
        echo '<thead class="table-light">';
            echo '<tr>';
                echo '<th scope="col" style="text-align: center;">#</th>';
                echo '<th scope="col" style="text-align: center;">작성자</th>';
                echo '<th scope="col" style="text-align: center;">메시지 내용</th>';
                echo '<th scope="col" style="text-align: center;">작성일자</th>';
            echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
      

    $column = 0;

    // table content
    foreach($boardData as $rows) {
        
        $messageID          = $rows['idx'];
        $writerID           = addslashes(htmlspecialchars($rows['id']));
        $writerMessage      = $rows['message'];
        $messageDate        = $rows['date'];
        $writerIP           = $rows['ip'];

        $writerRole         = $rows['role'];
        $writerNickname     = $rows['nickname'];

            echo '<tr>';
                echo '<th scope="row" style="text-align: center;">' . $messageID . '</th>';

                // role-based showing
                if($writerRole == "admin") {
                    echo '<td style="text-align: center;">' . '<b>' . $writerID  . '</b>'
                            . '&nbsp;'
                            . '<img class="adminBadge" src="/asset/usericon/verified_icon.png" width="20px" style="display: inline;">'
                            . '</td>';
                } else if($writerRole == "qa") {
                    echo '<td style="text-align: center;">' . '<b>' . $writerID  . '</b>' . '<br>'
                            . '<span class="badge bg-dark">QA' . '&nbsp'
                                . '<span class="bi-check-circle-fill" style="color: mint;"></span>'
                            . '</span>'
                            . '</td>';
                } else {
                    // $writerRole == "user" (as a default)
                    echo '<td style="text-align: center;">' . $writerID . '</td>';
                }
                
                echo '<td style="word-break: break-all" class="boardMessages" id="boardMessageColumn' . $column . '">' . $writerMessage . '</td>';
                echo '<td style="text-align: center; width:130px;">' . $messageDate . '</td>';
            echo '</tr>';

        $column++;

    }

        echo '</tbody>';
    echo '</table>';

    showPaginationBar($page, $totalPage);

?>