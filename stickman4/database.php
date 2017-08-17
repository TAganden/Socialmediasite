<?php
    $dsn = 'mysql:host=localhost;dbname=stickman4db';
    $dbusername = 'stickman4';
    $dbpassword = '=48;NERVE;MARK;usual;class;77=';
    
    //full rights to the stickman database

    try {
        $db = new PDO($dsn, $dbusername, $dbpassword);
    } catch (PDOException $e) {
        $database_error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }
?>