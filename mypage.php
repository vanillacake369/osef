<!-- Ref : https://www.bootdey.com/snippets/view/bs4-profile-about -->
<?php
    session_start();
    var_dump($_SESSION);
    if(!isset($_SESSION['id'])){
        var_dump($_SESSION);
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
                                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="">
                                            </div>
                                            <!-- END profile-header-img -->
                                            <!-- BEGIN profile-header-info -->
                                            <div class="profile-header-info">
                                                <?php
                                                    $user_id = $_SESSION['id'];
                                                    echo ("<h4 class='m-t-10 m-b-5'>'$user_id'</h4>");
                                                ?>
                                                <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                                                <a href="#" class="btn btn-xs btn-success">Edit Profile</a>
                                            </div>
                                            <!-- END profile-header-info -->
                                        </div>
                                        <!-- END profile-header-content -->
                                        <!-- BEGIN profile-header-tab -->
                                        <ul class="profile-header-tab nav nav-tabs">
                                            <li class="nav-item"><a href="mypage.php" target="__blank"
                                                    class="nav-link_ active show">정보 확인</a></li>
                                            <li class="nav-item"><a href="#" target="__blank"
                                                    class="nav-link_">회원정보 변경</a></li>
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

                                        <!-- begin #profile-about tab -->
                                        <div class="tab-pane fade in active show" id="profile-about">
                                            <!-- begin table -->
                                            <div class="table-responsive">
                                                <table class="table table-profile">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>
                                                            <?php
                                                                require_once "dbcon.php";
                                                                $user_id = $_SESSION['id'];
                                                                $member_query = "SELECT * FROM member WHERE id = '$user_id'";
                                                                if($result = mysqli_query($conn, $member_query )){
                                                                    $row = mysqli_fetch_assoc($result);
                                                                    $user_name = $row['name'];
                                                                    $user_mobile = $row['phone'];
                                                                    $user_email = $row['email'];
                                                                    $user_address = $row['address'];

                                                                    echo ("<h4 class='m-t-10 m-b-5'>'$user_name'</h4>");
                                                                    echo ("<h4 class='m-t-10 m-b-5'>'$user_mobile'</h4>");
                                                                    echo ("<h4 class='m-t-10 m-b-5'>'$user_email'</h4>");
                                                                    echo ("<h4 class='m-t-10 m-b-5'>'$user_name'</h4>");
                                                                }else{                                          
                                                                    session_destroy();                  
                                                                    echo <<<ALERT
                                                                    <script>alert("Server Disconnected")'
                                                                    window.location.href = "index.php";'
                                                                    '</script>'
                                                                    ALERT;
                                                                }
                                                            ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="field">Mobile</td>
                                                            <td><i class="fa fa-mobile fa-lg m-r-5"></i> +1-(847)-
                                                                367-8924
                                                                <a href="javascript:;" class="m-l-5">Edit</a>
                                                            </td>
                                                        </tr>
                                                        <tr class="divider">
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="field">Number</td>
                                                            <td><a href="javascript:;">Add Number</a></td>
                                                        </tr>
                                                        <tr class="divider">
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="field">E-Mail</td>
                                                            <td>E-Mail</td>
                                                        </tr>
                                                        <tr class="divider">
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="field">Address</td>
                                                            <td>Los Angeles</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="field">Birthdate</td>
                                                            <td>
                                                                <select class="form-control input-inline input-xs"
                                                                    name="day">
                                                                    <option value="04" selected="">04</option>
                                                                </select>
                                                                -
                                                                <select class="form-control input-inline input-xs"
                                                                    name="month">
                                                                    <option value="11" selected="">11</option>
                                                                </select>
                                                                -
                                                                <select class="form-control input-inline input-xs"
                                                                    name="year">
                                                                    <option value="1989" selected="">1989</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="field">Language</td>
                                                            <td>
                                                                <select class="form-control input-inline input-xs"
                                                                    name="language">
                                                                    <option value="" selected="">English</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr class="divider">
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr class="highlight">
                                                            <td class="field">&nbsp;</td>
                                                            <td class="p-t-10 p-b-10">
                                                                <button type="submit"
                                                                    class="btn btn-primary width-150">Update</button>
                                                                <button type="submit"
                                                                    class="btn btn-white btn-white-without-border width-150 m-l-5">Cancel</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- end table -->
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