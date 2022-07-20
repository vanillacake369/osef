<?php
session_start();
session_destroy();
header("Location: index.php");
// header('Location: ' . $_SERVER['HTTP_REFERER']);
// -> 이전페이지로 돌아갈 수 있으나 HTTPS 이슈나 보안이슈가 존재함
?>