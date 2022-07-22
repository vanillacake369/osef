<?php
// CHECK SESSION
include_once "check-session.php";

// USER INFO MODIFICATION
if (isset($_POST['modify'])) {
    // CONNECT DATABASE
    require_once "dbcon.php";

    // GET USER INPUT
    $id = $_SESSION['id'];
    $pw = $_POST['pw'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $datetime = date('Y-m-d').' '.date('H:i:s');
    $latest = $datetime;
    $ip = $_SERVER['REMOTE_ADDR'];
    $login_count = 0;

    var_dump($_POST['modify']);
    echo "<br>".$login_count."<br>";

    // KEEP LOGIN_COUNT ALIVE
    $member_count_query = "SELECT * FROM member WHERE id = '$id' ";
    if($result = mysqli_query($conn,$member_count_query)){
        $row = mysqli_fetch_assoc($result);
        $login_count = $row['login_count'];
    }else{ // SERVER ERROR
        echo '<script type="text/javascript">';
        echo 'alert("Server has encouterd error. :(");';
        echo 'window.location.href = "signup.html";';
        echo '</script>'; 
        exit();
    }
    // UPDATE PASSWORD USING DYNAMIC SALT
    $pw = getSaltString($datetime, $latest, $login_count, $pw);
    $update_pw_query = "UPDATE member SET datetime = '$datetime', latest = '$latest', login_count = '$login_count', password = '$pw', ip = '$ip' WHERE id='$id'";
    if($result = mysqli_query($conn, $update_pw_query)){
        echo '<script type="text/javascript">';
        echo 'alert("Info Modification Success!!");';
        echo 'window.location.href = "member-modify-form.php";';
        echo '</script>';
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
    echo '<script type="text/javascript">';
    echo 'alert("Submit Failed. Please try again.");';
    echo 'window.location.href = "member-modify-form.php";';
    echo '</script>';
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


