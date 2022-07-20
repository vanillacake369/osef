<?php
    $servername = "localhost";
    $DBname = "root";
    $DBpassword = "1234";
    $conn = new mysqli($servername,$DBname,$DBpassword,"farm");
    $conn -> set_charset('utf8mb4');
    $stmt = $conn -> prepare("SELECT * FROM product where id = ?"); 
    $stmt -> bind_param("i", $_POST["productId"]);
    $stmt -> execute();
    $result = $stmt -> get_result();
    $productRow = $result -> fetch_assoc();    
    include("header.html")
?>


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

<!-- section document detail -->
<section  id="document" class="section">
        <div class="section_container">
            <div class="doc_title">
                <h1><?= $productRow["model"];?></h1> 
            </div>
            <hr>
            <div class="doc_wrap">
                <div class="doc_detail">
                    <div class="doc_detail_top">
                        <p>대여인: <?=$productRow["member_name"];?></p>
                        <p>대여인 연락처: <?=$productRow["member_name"];?></p>
                        <p>등록일: <?=$productRow["upload"];?></p>
                    </div>
                    <?php if($productRow["close"]){
                        echo("<h1> 대여 완료 </h1>");
                    }
                    ?>
                    <h3 class="doc_contents">제조사 : <?=$productRow["maker"];?></h3>
                    <h3 class="doc_contents">제조년 : <?=$productRow["make_year"];?></h3>

                    <h2 class="doc_price">가격: <?=$productRow["price"];?></h2>
                    
                    <h3 class="doc_contents">대여가능기간 : <?=$productRow["start_date"];?> ~ <?=$productRow["end_date"];?></h3>
                    <h3 class="doc_contents">대여주소 : <?=$productRow["place"];?></h3>

                    <h3 class="doc_contents">상세내용 : <?=$productRow["detail"];?></h3>
                    <?php
                        $stmt = $conn -> prepare("SELECT * FROM file where p_id = ?"); 
                        $stmt -> bind_param("i", $_POST["productId"]);
                        $stmt -> execute();
                        $result = $stmt -> get_result(); 

                        while($row = $result -> fetch_assoc()){
                            echo(" <img src=\"".$row["link"]."\" width=\"1000\"> ");
                        }
                        $stmt->close();
                        $conn->close();    
                    ?>

                    <div class="doc_detail_bottom">                    
                        <button>바로구매</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<?= include("footer.html"); ?>
</html>
