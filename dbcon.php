<?php
    $servername='localhost';
    $username='root';
    $password='12341234';
    $dbname = "farm";
    $conn=mysqli_connect($servername,$username,$password,"$dbname");
    if(!$conn){
        die('Could not Connect MySql Server:' .mysql_error());
    }
?>