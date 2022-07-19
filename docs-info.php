<?php
    $servername = "localhost";
    $DBname = "root";
    $DBpassword = "1234";
    $conn = new mysqli($servername,$DBname,$DBpassword,"farm");
    $conn -> set_charset('utf8mb4');
    $stmt = $conn -> prepare("SELECT * FROM sell_info where id = ?"); 
    $stmt -> bind_param("i", $_POST["docId"]);
    $stmt -> execute();
    $result = $stmt -> get_result();
    $row = $result -> fetch_assoc();
    include("header.html")
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
<h1><?= $row["title"];?></h1>
<h2> 저자: <?=$row["member_name"];?> </h2>
<h2> 등록일: <?=$row["upload"];?> </h2>
<h2> 가격: <?=$row["price"];?> </h2>
<h3> 상세내용 : <?=$row["detail"];?></h3>
<button>구매 버튼 </button>

</body>
<?= include("footer.html"); ?>
</html>
