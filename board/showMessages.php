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
    
    // $query = "SELECT * FROM board ORDER BY idx DESC LIMIT 50";
    $query = "SELECT board.*, member.role, member.nickname
                FROM board, member 
                    WHERE board.id = member.id 
                        ORDER BY board.idx 
                        DESC LIMIT 50";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $boardData = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

?>