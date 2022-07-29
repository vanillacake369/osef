<?php

// DB CONNECTION
require_once "dbcon.php";

// DELETE PRODUCT
if (isset($_POST['docs-delete-btn'])) {
    // GET PRODUCT ID
    $docs_id = $_POST['docs_id'];
    if(isset($docs_id)){
        $delete_query = "UPDATE sell_info SET deleteDate=CURDATE() where id = '$docs_id'";
        if(mysqli_query($conn, $delete_query)){
            echo '<script>alert("문서 삭제가 완료되었습니다.");';
            echo 'window.location.href = "member-docs-info.php";';
            echo '</script>';
        }
    }
    mysqli_close($conn);
}
?>