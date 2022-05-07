<?php

    // MYSQL 데이터베이스 로그인 및 DB 이름 정보를 한 파일에 통합해서 관리
    // PHP Data Object (PDO) 사용

    $servername         = "localhost";
    $dbusername         = "luminous";
    $dbuserpassword     = "luceatx0926@@";
    $dbname             = "luminous";

    $dsn = "mysql:host={$servername};port=3306;dbname={$dbname};charset=utf8";

    try {

        $db = new PDO($dsn, $dbusername, $dbuserpassword);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $PDOerr) {

        die("Connection failed : " . $PDOerr -> getMessage());

    }

?>