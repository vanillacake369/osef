<?php
    session_start();
    if(!isset($_SESSION['id'])){
        echo '<script>alert("You need to login first");';
        echo 'window.location.href = "login.html";';
        echo '</script>';
    }
?>