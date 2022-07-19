<?php 
    session_start();
    var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="UTF-8">

<body>
    <!-- navbar -->
    <nav id="navbar">
        <div class="navbar_logo">
            <a href="index.php"><i class="fas fa-seedling"></i> 억새풀</a>
        </div>
        <ul class="navbar_list">
            <li><a href="rent.html">임대신청</a></li>
            <li><a href="lend.html">기계등록</a></li>
            <li><a href="docs-search.php">자료실</a></li>
            <li><a href="docs-register.php">자료등록</a></li>
            <li><a href="introduce.html">회사소개</a></li>
        </ul>
        <ul class="navbar_list">
            <?php
            if(!isset($_SESSION['id'])) {
                echo '<li><a href="login.php">로그인</a></li>';
            }else{
                echo '<li><a href="logout.php">로그아웃</a></li>';
                echo '<li><a href="mypage.php">마이페이지</a></li>';
            }
            ?>
        </ul>
        <button class="navbar_toggle_btn">
            <i class="fas fa-bars"></i>
        </button>
    </nav>
</body>
<script>
    const HIDDEN_CLASSNAME = 'hidden';

    const after = document.querySelectorAll('#afterLogin');
    const before = document.querySelectorAll('#beforeLogin');

    var uid = '<%=(String)session.getAttribute("id")%>';
    if (uid == "null") {
        for (let i = 0; i < before.length; i++) {
            before[i].classList.add(HIDDEN_CLASSNAME);
        }
    } else {
        for (let i = 0; i < after.length; i++) {
            after[i].classList.add(HIDDEN_CLASSNAME);
        }
    }
</script>

</html>