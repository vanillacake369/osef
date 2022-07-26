<?php
    // DB CONNECTION
    require_once "dbcon.php";

    // GET PRODUCT INFO
    $product_id = $_POST["product_id"];
    $model = $_POST["model"];
    $maker = $_POST["maker"];
    $category = $_POST["category"];
    $makeDate = $_POST["makeDate"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $address = $_POST["address"];
    $detail = $_POST["detail"];
    $price = $_POST["price"];

    // UPDATE QUERY
    $update_product_query = "UPDATE product SET model='$model',maker='$maker',category='$category',make_year='$makeDate',start_date='$startDate',end_date='$endDate',place='$address',detail='$detail',price='$price' WHERE id = '$product_id'";
    if($result = mysqli_query($conn, $update_product_query)){ // UPDATE SUCCESS
        echo '<script type="text/javascript">';
        echo 'alert("농기기 정보 수정 완료!!");';
        echo 'window.location.href = "member-product-info.php";';
        echo '</script>';
    }else{ // DB CONNECTION FAIL
        $fp = fopen('database_error_log.txt','w');
        $db_err = mysqli_connect_error();
        fwrite($fp,$db_err);
        fclose($fp);
        exit();
    }
?>