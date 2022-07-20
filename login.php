<?php // START OF PHP

// GET ID&PASSWORD
$id =  isset($_POST['id']) ? $_POST['id'] : '';
$password = isset($_POST['pw']) ? $_POST['pw'] : '';

var_dump($_POST);

// IF SUBMIT HAS DONE
if (isset($_POST['login'])) {
    if(empty($id) || empty($password)){ // CHECK ID&PASSWORD VALIDATION
        echo '<script type="text/javascript">';
        echo 'alert("You have to insert both id & password!");';  
        echo 'window.location.href = "login.html"'; 
        echo '</script>';
        exit();
    }else{
        // DB CONNECTION
        require_once "dbcon.php";

        // GET MEMBER BY USER INPUT
        $select_query = "SELECT * FROM member WHERE id = '$id'";
        if($result = mysqli_query($conn, $select_query)){
            $row = mysqli_fetch_assoc($result);
            if(!isset($row)){ // UNREGISTERED USER
                echo '<script type="text/javascript">';
                echo 'alert("You have to sign up first!");';  
                echo 'window.location.href = "signup.html"'; 
                echo '</script>';
                exit();
            }else{ // REGISTERED USER
                // GET PRIOR SALT PW BY INPUT
                $datetime = $row['datetime'];
                $latest = $row['latest'];
                $login_count = $row['login_count'];
                $password = getSaltString($datetime, $latest, $login_count, $password);

                // IF DB&INPUT MATCH
                if ($row['id'] === $id && $row['password'] === $password) {
                    // UPDATE DYNAMIC SALT PASSWORD
                    $datetime = $latest;
                    $latest = date("Y-m-d").' '.date('H:i:s');
                    $login_count = $login_count + 1;
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $password = $_POST['pw'];
                    $password = getSaltString($datetime, $latest, $login_count, $password);
                    $update_pw_query = "UPDATE member SET datetime = '$datetime', latest = '$latest', login_count = '$login_count', password = '$password', ip = '$ip' WHERE id='$id'";
                    if($result = mysqli_query($conn, $update_pw_query)){
                        // START SESSION & INPUT ID INTO SESSION
                        session_start();
                        $_SESSION['id'] = $row['id'];
                        // GO TO HOME
                        header("Location: index.php");
                    }else{ // SERVER ERROR
                        echo '<script type="text/javascript">';
                        echo 'alert("Server has encouterd error. :(")';
                        echo 'window.location.href = "signup.html";';
                        echo '</script>'; 
                        exit();
                    }            
                } else { // WRONG INPUT
                    echo '<script type="text/javascript">';
                    echo 'alert("Unvalid Id & Password. Please try again. :( ")';
                    echo 'window.location.href = "login.html"';
                    echo '</script>';
                    exit();
                }
            }
        }else{ // SERVER ERROR
            echo '<script type="text/javascript">';
            echo 'alert("Server has encouterd error. :(")';
            echo 'window.location.href = "signup.html";';
            echo '</script>'; 
            exit();
        }
    }
}else{ // SERVER ERROR
    echo '<script type="text/javascript">';
    echo 'alert("Server has encouterd error. :(")';
    echo 'window.location.href = "signup.html";';
    echo '</script>'; 
    exit();
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