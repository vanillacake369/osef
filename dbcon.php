<?php
    $servername='localhost';
    $username='root';
    $password='1234';
    $dbname = "farm";
    $conn=mysqli_connect($servername,$username,$password,"$dbname");
    if(!$conn){
        die('Could not Connect MySql Server:' .mysql_error());
    }
    $conn -> set_charset('utf8mb4');
?>