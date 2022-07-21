<?php

// DB CONNECTION
require_once "dbcon.php";


echo 'POST 실패';
var_dump($_POST);

// SUBMIT SUCCESS 
if (isset($_POST['delete-btn'])) {
    echo 'POST 성공';
    var_dump($_POST);

    // GET SESSION KEY
    session_start();
    if(isset($_SESSION['id'])){
        $id = $_SESSION['id'];
        // DELETE MEMBER
        $delete_query = "DELETE FROM member where id = '$id'";
        if(mysqli_query($conn, $delete_query)){
            echo '<script>alert("계정 삭제가 완료되었습니다.");';
            echo 'window.location.href = "index.php";';
            echo '</script>';
            session_start();
            session_destroy();
        }
    }
}
?>