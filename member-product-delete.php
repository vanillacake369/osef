<?php

// DB CONNECTION
require_once "dbcon.php";

// DELETE PRODUCT
if (isset($_POST['product-delete-btn'])) {
    // GET PRODUCT ID
    $product_id = $_POST['product_id'];
    if(isset($product_id)){
        //$delete_query = "DELETE FROM product where id = '$product_id'";
        $delete_query = "UPDATE product SET deleteDate=CURDATE() where id = '$product_id'";
        if(mysqli_query($conn, $delete_query)){
            echo '<script>alert("기기 삭제가 완료되었습니다.");';
            echo 'window.location.href = "member-product-info.php";';
            echo '</script>';
        }
    }
    mysqli_close($conn);
}
?>