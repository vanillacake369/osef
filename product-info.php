<?php
    require_once "dbcon.php";
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
                    ?>
                    
                    <div class="doc_detail_bottom">                    
                        <button>바로구매</button>
                    </div>
                </div>
            </div>
        </div>
</section>
<div class="section">
   댓글 <br>
    <?php
        $stmt = $conn -> prepare("
        SELECT * FROM comment AS noreply LEFT JOIN
	        (SELECT 
		        comment_id AS reply_comment_id,
		        p_id AS reply_p_id,
		        s_id AS reply_s_id,
		        member_id AS reply_member_id,
		        detail AS reply_detail,
		        upload AS reply_upload,
		        deleteDate AS reply_deleteDate,
		        reply_id AS reply_reply_id
		    FROM comment WHERE p_id = ?) as reply 
		    ON noreply.comment_id=reply.reply_reply_id 
            where noreply.p_id = ? AND noreply.reply_id IS NULL
        "); 
        $stmt -> bind_param("ii", $_POST["productId"], $_POST["productId"]);
        $stmt -> execute();
        $result = $stmt -> get_result();
        $prevCommentId = null;
        while($row = $result -> fetch_assoc()){            
            if($prevCommentId==$row["comment_id"]){
                echo ("&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ".$row["reply_member_id"]." <br>");
                echo ("&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ".$row["reply_detail"]." <br>");
            }else{
                echo ($row["member_id"]." <br>");
                echo ($row["detail"]." <br>");
                if(isset($row["reply_member_id"])){
                    echo ("&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ".$row["reply_member_id"]." <br>");                    
                    echo ("&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ".$row["reply_detail"]." <br>");
                }
                $prevCommentId = $row["comment_id"];
            }
        }
    ?>
    <form>
        댓글입력: <input type="text" name="commnetInput">
        <button type="submit">댓글 저장</submit>

    </form>
</div>
<?php
    $stmt->close();
    $conn->close();
?>
</body>
<?= include("footer.html"); ?>
</html>
