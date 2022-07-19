<?php // START OF PHP

// DB CONNECTION
require_once "dbcon.php";

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

include_once "login.html";

?> 