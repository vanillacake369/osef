<?php
// CONNECT DATABASE
session_start();
var_dump($_SESSION);

require_once "dbcon.php";
$member_exist_error = '';

if (isset($_POST['signup'])) {
    // GET USER INPUT
    $id = $_POST['id'];
    $pw = $_POST['pw'];
    $cpassword = $_POST['cpassword'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $datetime = date('Y-m-d') . ' ' . date('H:i:s');
    $latest = $datetime;
    $login_count = 0;
    $ip = $_SERVER['REMOTE_ADDR'];

    // UPDATE PASSWORD USING DYNAMIC SALT
    $pw = getSaltString($datetime, $latest, $login_count, $pw);

    // VERIFY MEMBER&INPUT_ID
    $member_count_query = "SELECT COUNT(*) as cnt FROM member WHERE id = '$id' ";
    if($result = mysqli_query($conn,$member_count_query)){
        $member_count = mysqli_fetch_assoc($result);
        if ($member_count && (int)$member_count['cnt'] === 1) {
            echo '<script type="text/javascript">'; 
            echo 'alert("Member already exists");'; 
            echo 'window.location.href = "signup.php";';
            echo '</script>';
            exit();
        }
    }else{
        echo "<script>alert('Something Went Wrong :(')";
        echo 'window.location.href = "login.php";';
        echo '</script>';
        exit();
        // echo "Error: ".mysqli_error($conn);
    }

    // INSERT INPUT INTO MEMBER DB
    // id,pw,cpw,name,email,phone,address,datetime,latest,login_count,ip
    $insert = "INSERT INTO member(id, password, datetime, name, email, phone, latest, login_count, IP) VALUES('$id', '$pw', '$datetime', '$name', '$email', '$phone', '$latest', '$login_count', '$ip')";
    if (mysqli_query($conn, $insert)) {
        // show window message & redirect
        echo '<script type="text/javascript">'; 
        echo 'alert("User Registeration Completed!");'; 
        echo 'window.location.href = "login.php";';
        echo '</script>';
        exit();
    } else {
        echo "<script>alert('Something Went Wrong :(')";
        echo 'window.location.href = "login.php";';
        echo '</script>';
        exit();
        // echo "Error: ".mysqli_error($conn);
    }

    // close sql connection
    mysqli_close($conn);
}

// ---- DYNAMIC SALT ---- 
function getSaltString($datetime, $latest, $login_count, $password)
{
    // mod operation
    $mod = unpack("I", $password)[1] % 24; // unsigned integer
    $arr = [$datetime, $latest, $login_count, $password];
    // algorithm
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
    // hash section
    return hash('sha256', "$saltString[$mod]");
}
//  ---- END OF SALT ---- 

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>억새풀</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-offset-2">
                <div class="page-header">
                    <h2>Registration Form in PHP with Validation</h2>
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label>ID</label>
                        <span class="essential" style="color:red">*</span>
                        <input type="text" name="id" class="form-control" value="" maxlength="16" required="">
                        <span>
                        <?php if (isset($member_exist_error)) {
                            echo $member_exist_error;
                        }
                        ?>
                        <span>
                    </div>
                    <!-- #2 PASSWORD VERIFICATION -->
                    <script>
                        var check = function() {
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
                    <div class="form-group">
                        <label>Password</label>
                        <span class="essential" style="color:red">*</span>
                        <input type="password" name="pw" id="pw" class="form-control" value="" minlength="8" maxlength="30" required="" onkeyup='check();'>
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password*</label>
                        <span class="essential" style="color:red">*</span>
                        <input type="password" name="cpassword" id="cpassword" class="form-control" value="" minlength="8" maxlength="30" required="" onkeyup='check();'>
                        <span id='message'></span>
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <span class="essential" style="color:red">*</span>
                        <input type="text" name="name" class="form-control" value="" maxlength="50" required="">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group ">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <span class="essential" style="color:red">*</span>
                        <input type="text" name="phone" class="form-control" value="" maxlength="12" required="">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <span class="essential" style="color:red">*</span>
                        <input type="text" name="address" class="form-control" value="" maxlength="128" required="">
                        <span class="text-danger"></span>
                    </div>
                    <input type="submit" class="btn btn-primary" name="signup" value="submit">
                    Already have a account?<a href="login.php" class="btn btn-default">Login</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>