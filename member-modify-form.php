<!-- Ref : https://www.bootdey.com/snippets/view/bs4-profile-about -->
<?php
    session_start();
    if(!isset($_SESSION['id'])){
        echo '<script>alert("You need to login first");';
        echo 'window.location.href = "login.html";';
        echo '</script>';
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
    <link rel="stylesheet" href="mypage.css">
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
        <ul class="navbar_list">
            <?php
            if(!isset($_SESSION['id'])) {
            echo '<li><a href="login.html">로그인</a></li>';
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

    <!-- profile -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"
                    rel="stylesheet">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="content" class="content content-full-width">
                                <!-- begin profile -->
                                <div class="profile">
                                    <div class="profile-header">
                                        <!-- BEGIN profile-header-cover -->
                                        <div class="profile-header-cover"></div>
                                        <!-- END profile-header-cover -->
                                        <!-- BEGIN profile-header-content -->
                                        <div class="profile-header-content">
                                            <!-- BEGIN profile-header-img -->
                                            <div class="profile-header-img">
                                                <img src="https://www.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png" alt="">
                                            </div>
                                            <!-- END profile-header-img -->
                                            <!-- BEGIN profile-header-info -->
                                            <div class="profile-header-info">
                                                <?php
                                                    $user_id = $_SESSION['id'];
                                                    echo "<h1 class='m-t-10 m-b-5'>$user_id</h1>";
                                                ?>
                                            </div>
                                            <!-- END profile-header-info -->
                                        </div>
                                        <!-- END profile-header-content -->
                                        <!-- BEGIN profile-header-tab -->
                                        <ul class="profile-header-tab nav nav-tabs">
                                            <li class="nav-item"><a href="mypage.php" target="__blank"
                                                    class="nav-link_">정보 확인</a></li>
                                            <li class="nav-item"><a href="member-modify-form.php" target="__blank"
                                                    class="nav-link_ active show">회원정보 변경</a></li>
                                            <li class="nav-item"><a href="#" target="__blank"
                                                    class="nav-link_">등록한 농기계 관리</a></li>
                                            <li class="nav-item"><a href="#" target="__blank"
                                                    class="nav-link_">임대 중인 농기계</a></li>
                                            <li class="nav-item"><a href="#" target="__blank"
                                                    class="nav-link_">등록한 기술문서</a></li>   
                                            <li class="nav-item"><a href="#" target="__blank"
                                                    class="nav-link_">구매한 기술문서</a>
                                            <li class="nav-item"><a href="#" target="__blank"
                                                    class="nav-link_">회원 탈퇴</a></li>
                                        </ul>
                                        <!-- END profile-header-tab -->
                                    </div>
                                </div>
                                <!-- end profile -->
                                <!-- begin profile-content -->
                                <div class="profile-content">
                                    <!-- begin tab-content -->
                                    <div class="tab-content p-0">
                                    <div>
                                        <!-- begin #profile-about tab -->
                                        <div class="tab-pane fade in active show" id="profile-about">
                                            <form action="member-modify.php" method="post">
                                                <!-- #2 PASSWORD VERIFICATION -->
                                                <script>
                                                    var check = function () {
                                                        if (document.getElementById('pw').value ==
                                                            document.getElementById('cpassword').value) {
                                                            document.getElementById('message').style.color = 'green';
                                                            document.getElementById('message').innerHTML = 'matching';
                                                        } else {
                                                            document.getElementById('message').style.color = 'red';
                                                            document.getElementById('message').innerHTML = 'not matching';
                                                        }
                                                    }
                                                </script>
                                                <label>비밀번호<span class="red_dot">*</span></label>
                                                <div class="input_row">
                                                    <input type="password" name="pw" id="pw" class="input_text" value="" minlength="8"
                                                        maxlength="30" required="" onkeyup='check();'>
                                                </div>
                                                <label>비밀번호 재확인<span class="red_dot">*</span></label>
                                                <div class="input_row">
                                                    <input type="password" name="cpassword" id="cpassword" class="input_text" value="" minlength="8"
                                                        maxlength="30" required="" onkeyup='check();'>
                                                </div>
                                                <span id='message'></span>
                                                <span class="text-danger"></span>
                                                <label>이름<span class="red_dot">*</span></label>
                                                <div class="input_row">
                                                    <input type="text" name="name" class="input_text" value="" maxlength="50" required="">
                                                </div>
                                                <label>이메일</label>
                                                <div class="input_row">
                                                    <input type="email" name="email" class="input_text" value="" maxlength="30">
                                                </div>
                                                <label>휴대전화<span class="red_dot">*</span></label>
                                                <div class="input_row">
                                                    <input type="tel" name="phone" class="input_text" value="" maxlength="16"
                                                        pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" required placeholder="010-xxxx-xxxx">
                                                </div>
                                                <label>주소<span class="red_dot">*</span></label>
                                                <div class="input_row">
                                                    <input type="text" name="address" class="input_text" value="" maxlength="128" required=""
                                                        placeholder="~시 ~읍/면/동/리">
                                                </div>
                                                <div class="modify_submit">
                                                    <button type="modify" class="btn_modify" name="modify">
                                                        <span class="btn_text">회원정보 수정</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end #profile-about tab -->
                                    </div>
                                    <!-- end tab-content -->
                                </div>
                                <!-- end profile-content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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