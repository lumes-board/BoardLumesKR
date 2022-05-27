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
    
    $query = "SELECT * FROM board ORDER BY idx DESC LIMIT 50";
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
      

    // table content
    foreach($boardData as $rows) {
        
        $messageID          = $rows['idx'];
        $writerID           = addslashes(htmlspecialchars($rows['id']));
        $writerMessage      = addslashes(htmlspecialchars($rows['message']));
        $messageDate        = $rows['date'];
        $writerIP           = $rows['ip'];

            echo '<tr>';
                echo '<th scope="row" style="text-align: center;">' . $messageID . '</th>';
                echo '<td style="text-align: center;">' . $writerID . '</td>';
                echo '<td style="word-break: break-all">' . $writerMessage . '</td>';
                echo '<td style="text-align: center;">' . $messageDate . '</td>';
            echo '</tr>';

    }

        echo '</tbody>';
    echo '</table>';

?>