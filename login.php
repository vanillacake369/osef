<?php // START OF PHP

session_start();
var_dump($_SESSION);

// DB CONNECTION
require_once "dbcon.php";

// START SESSION
session_start();

// CHECK AND GET ID&PASSWORD
$id =  isset($_POST['id']) ? $_POST['id'] : '';
$password = isset($_POST['pw']) ? $_POST['pw'] : '';

// IF SUBMIT HAS DONE
if (isset($_POST['login'])) {
    // GET MEMBER BY USER INPUT
    $select_query = "SELECT * FROM member WHERE id = '$id'";

    if($result = mysqli_query($conn, $select_query)){
        // GET PRIOR SALT PW BY INPUT
        $row = mysqli_fetch_assoc($result);
        $datetime = $row['datetime'];
        $latest = $row['latest'];
        $login_count = $row['login_count'];
        $password = getSaltString($datetime, $latest, $login_count, $password);

        // IF DB&INPUT MATCH
        if ($row['id'] === $id && $row['password'] === $password) {
            
            // UPDATE PASSWORD USING DYNAMIC SALT
            // new salt password
            $datetime = $latest;
            $latest = date("Y-m-d").' '.date('H:i:s');
            $login_count = $login_count + 1;
            $ip = $_SERVER['REMOTE_ADDR'];
            $password = $_POST['pw'];
            $password = getSaltString($datetime, $latest, $login_count, $password);          
            // update query
            $update_pw_query = "UPDATE member SET datetime = '$datetime', latest = '$latest', login_count = '$login_count', password = '$password', ip = '$ip' WHERE id='$id'";
            if($result = mysqli_query($conn, $update_pw_query)){
                // START SESSION & INPUT ID INTO SESSION
                session_start();
                $_SESSION['id'] = $row['id'];
                // GO TO HOME
                header("Location: index.php");
            }else{   // UPDATE FAIL
                echo '<script>alert("Server has failed to update password :( ")';
                echo 'window.location.href = "login.php";';
                echo '</script>';
            }            
        } else { // WRONG INPUT
            echo '<script>alert("Unvalid Id & Password. Please try again. :( ")';
            echo 'window.location.href = "login.php";';
            echo '</script>';
        }
    }else{ // USER INPUT UNVALID
        echo '<script>alert("Please fill Id & Password.")';
        echo 'window.location.href = "login.php";';
        echo '</script>';
    }
}


// DYNAMIC SALT
function getSaltString($datetime, $latest, $login_count, $password)
{
    $mod = unpack("I", $password)[1] % 24;
    $arr = [$datetime, $latest, $login_count, $password];
    for ($i = 0; $i < count($arr); $i++) {
        for ($j = 0; $j < count($arr); $j++) {
            for ($k = 0; $k < count($arr); $k++) {
                if ($i == $j || $j == $k || $k == $i) {
                    continue;
                }
                $saltString[] = $arr[$i] . $arr[$j] . $arr[$k];
            }
        }
    }
    return hash('sha256', "$saltString[$mod]");
}
?> 


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gugi&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/7395e48b31.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>억새풀</title>
</head>

<body>
    <!-- navbar -->
    <nav id="navbar">
        <div class="navbar_logo">
            <i class="fas fa-seedling"></i>
            <a href="index.php">억새풀</a>
        </div>
        <ul class="navbar_list">
            <li><a href="rent.html">임대신청</a></li>
            <li>자료실</li>
            <li><a href="introduce.html">회사소개</a></li>
            <li><a href="lend.html">기계등록</a></li>
        </ul>
        <ul class="navbar_list_login">
            <li><a href="mypage.php">마이페이지</a></li>
            <li><a href="login.php">로그인</a></li>
        </ul>
        <button class="navbar_toggle_btn">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <!-- login -->
    <section id="login" class="section">
        <div class="section_container">
            <div class="navbar_logo" style="font-size: 35px;">
                <i class="fas fa-seedling"></i>
                <a href="index.php">억새풀</a>
            </div>
            <form action="" method="post">
                <div class="login_pannel">
                    <div class="login_pannel_inner">
                        <div class="id_pw_wrap">
                            <div class="input_row" id="id_line">
                                <input type="text" id="id" class="input_text" name="id" placeholder="아이디">
                            </div>
                            <div class="input_row">
                                <input type="password" id="pw" class="input_text" name="pw" placeholder="비밀번호">
                            </div>
                        </div>
                        <div class="keep">
                        </div>
                        <button type="submit" class="btn_login" name="login">
                            <span class="btn_text">로그인</span>
                        </button>
                    </div>
                </div>
            </form>
            <div class="login_find">
                <span><a href="#" class="login_find_menu">아이디 찾기</a></span>
                <span><a href="#" class="login_find_menu">비밀번호 찾기</a></span>
                <span><a href="signup.php" class="login_find_menu">회원가입</a></span>
            </div>
        </div>
    </section>

    <!-- footer -->
    <footer id="footer">
        <div class="footer_logo">
            <div class="navbar_logo">
                <i class="fas fa-seedling"></i>
                <a href="index.php">억새풀</a>
            </div>
        </div>
        <div class="footer_text">
            <p class="footer_text_p">36729 경상북도 안동시 경동로 1375 (송천동) 국립안동대학교 공대1호관 413호 NGN연구실</p>
            <p class="footer_text_p">TEL : 010-9548-1369 / E-MAIL : w1683111@naver.com</p>
            <p class="footer_text_p">COPYRIGHT (C)2022 억새풀. ALL RIGHTS RESERVED.</p>
        </div>
    </footer>
</body>

</html>