<!-- Ref : https://www.bootdey.com/snippets/view/bs4-profile-about -->
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
    <!-- add default header -->
    <?php include_once "header.html"; ?>
    <?php include_once "check-session.php"; ?>

    <!-- CHECK SESSION -->
    <?php include_once "check-session.php"; ?>

    <!-- add default profile -->
    <?php include_once "member-profile.php"; ?>

    <!-- begin member info section -->
    <section>
        <div class="profile-content">
            <!-- begin tab-content -->
            <div class="tab-content p-0">
                <!-- begin #profile-about tab -->
                <div class="tab-pane fade in active show" id="profile-about">
                    <!-- begin table -->
                    <div class="table-responsive">
                        <table class="table table-profile">
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
                        echo <<< FORM
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>$user_name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="field">Mobile</td>
                                    <td><i class="fa fa-mobile fa-lg m-r-5"></i>$user_mobile
                                    </td>
                                </tr>
                                <tr class="divider">
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td class="field">E-Mail</td>
                                    <td><i class="fa fa-envelope-o fa-lg m-r-5"></i>$user_email</td>
                                </tr>
                                <tr class="divider">
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td class="field">Address</td>
                                    <td><i class="fa fa-map-marker fa-lg m-r-5""></i>$user_address</td>
                                </tr>
                            </tbody>
                        FORM;
                        }else{                                          
                            session_destroy();
                            echo <<<ALERT
                            <script>alert("Server Disconnected")'
                            window.location.href = "index.php";'
                            '</script>'
                            ALERT;
                        }
                        ?>  
                        </table>
                    </div>
                    <!-- end table -->
                </div>
                <!-- end #profile-about tab -->
            </div>
            <!-- end tab-content -->
        </div>
        <!-- end profile-content -->
    </section>                     
    <!-- end member info section -->

    <!-- add default footer -->
    <?php include_once "footer.html"; ?>
    
</body>
</html>