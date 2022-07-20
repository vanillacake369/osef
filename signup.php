<?php

// IF SUBMIT HAS DONE
if (isset($_POST['signup'])) {   
    // CONNECT DATABASE
    require_once "dbcon.php";

    // GET USER INPUT
    $id = $_POST['id'];
    $pw = $_POST['pw'];
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
        if($member_count && (int)$member_count['cnt'] === 1){ // UNREGISTERED USER
            echo '<script type="text/javascript">'; 
            echo 'alert("Member already exists");'; 
            echo 'window.location.href = "signup.html";';
            echo '</script>';
            exit();
        }else{ // REGISTERED USER
            // INSERT INPUT INTO MEMBER DB
            // id,pw,name,email,phone,address,datetime,latest,login_count,ip
            $insert = "INSERT INTO member(id, password, datetime, name, email, phone, address, latest, login_count, IP) VALUES('$id', '$pw', '$datetime', '$name', '$email', '$phone', '$address', '$latest', '$login_count', '$ip')";
            if (mysqli_query($conn, $insert)) { // SIGNUP SUCESS
                mysqli_close($conn);
                echo '<script type="text/javascript">'; 
                echo 'alert("User Registeration Completed!");'; 
                echo 'window.location.href = "login.html";';
                echo '</script>';
                exit();
            } else { // DB CONNECTION FAIL
                echo '<script type="text/javascript">';
                echo 'alert("Lost server connection :(");';
                echo 'window.location.href = "login.html";';
                echo '</script>';
                exit();
            }
        }
    }else{ // DB CONNECTION FAIL
        echo '<script type="text/javascript">';
        echo 'alert("Lost server connection :(");';
        echo 'window.location.href = "login.html";';
        echo '</script>';
        exit();
    }
    // CLOSE DB CONNECTION
    mysqli_close($conn);
} else{ // WRONG INPUT
    echo "<script>alert('You've misseed some of the input. Please try again. :( ');";
    echo 'window.location.href = "signup.html";';
    echo '</script>';
    exit();
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