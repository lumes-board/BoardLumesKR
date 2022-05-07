<?php

    // MYSQL 데이터베이스 로그인 및 DB 이름 정보를 한 파일에 통합해서 관리


    $servername = "localhost";
    $dbusername = "luminous";
    $dbpassword = "luceatx0926@@";
    $dbname     = "luminous";

    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

    if ($conn -> connect_error) {

        die("Connection failed: " . $conn -> connect_error);
    
    }

?>