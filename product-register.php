<?php
    session_start();
    $_SESSION["id"];

    $_GET["maker"];
    $_GET["category"];
    $_GET["makeDate"];
    $_GET["startDate"];
    $_GET["endDate"];
    $_GET["adress"];
    $_GET["detail"];
    $_GET["imgFile"];

    $sql="insert into product(category,start_date,end_date,detail,member_id,member_phone,member_email,member_name,place,price,maker,make_year,model) VALUE ( ";
?>