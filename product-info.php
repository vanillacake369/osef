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
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin="crossorigin">
    <link
        href="https://fonts.googleapis.com/css2?family=Gugi&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/7395e48b31.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link rel="stylesheet" href="style.css">
    <title>억새풀</title>
</head>
<!-- section product detail -->
<section id="product" class="section">
    <div class="section_container">
        <div class="product_title">
            <h1><?= $productRow["model"];?></h1>
        </div>

        <div class="swiper-container">
            <div class="swiper-inner">
                <!-- navigation - 좌우 이동버튼(좌) -->
                <button type="button" class="swiper-prev swiper-navi">
                    < <span class="btn-text"></span>
                </button>

                <!-- 슬라이더 -->
                <div class="swiper">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <?php
                                $stmt = $conn -> prepare("SELECT * FROM file where p_id = ?"); 
                                $stmt -> bind_param("i", $_POST["productId"]);
                                $stmt -> execute();
                                $result = $stmt -> get_result(); 

                                while($row = $result -> fetch_assoc()){
                                    echo(" 
                                    <div class=\"swiper-slide\">
                                        <img src=\"".$row["link"]."\" class=\"product_preview\">
                                    </div>
                                    ");
                                }                            
                        ?>
                    </div>
                </div>

                <!-- navigation - 좌우 이동버튼(우) -->
                <button type="button" class="swiper-next swiper-navi">
                    >
                    <span class="btn-text"></span>
                </button>
            </div>

            <!-- pagination - 페이지 버튼 -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<div class="section_container">
    <hr class="hr_gray">
</div>

<section id="detail" class="section">
    <div class="section_container">
        <div class="product_wrap">
            <div class="product_left">
                <div class="product_title">
                    <h1><?= $productRow["model"];?></h1>
                </div>
                <hr class="hr_gray">
                <div class="product_detail">
                    <h3><i class="fas fa-wrench product_icon"></i>장비정보</h3>
                    <p>제조사:
                        <?=$productRow["maker"];?></p>
                    <p>제조년:
                        <?=$productRow["make_year"];?></p>
                </div>
                <hr class="hr_gray">
                <div class="product_detail">
                <h3><i class="fas fa-map-marked-alt product_icon"></i>임대정보</h3>
                    <p>대여가능기간:
                        <?=$productRow["start_date"];?>
                        ~
                        <?=$productRow["end_date"];?></p>
                    <p>대여주소:
                        <?=$productRow["place"];?></p>
                </div>
                <hr class="hr_gray">
                <div class="product_detail">
                    <h3><i class="far fa-address-card product_icon"></i>대여인정보</h3>
                    <p>대여인:
                        <?=$productRow["member_name"];?></p>
                    <p>대여인 연락처:
                        <?=$productRow["member_phone"];?></p>
                    <p>등록일:
                        <?=$productRow["upload"];?></p>
                </div>
                <hr class="hr_gray">
                <div class="product_detail">
                    <h3><i class="fas fa-info-circle product_icon"></i>상세내용</h3>
                    <p><?=$productRow["detail"];?></p>
                </div>
            </div>
            <div class="product_right">
                <div class="product_box">
                    <div class="product_title">
                        <h2>가격</h2>
                        <p><?=$productRow["price"];?>
                            /박</p>
                    </div>
                    <button class="btn_gray">예약하기</button>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="section_container">
    <hr class="hr_gray">
</div>

<!-- section -->
<section id="product_comment" class="section">
    <div class="section_container">
        <div class="product_title">
            <h2><i class="far fa-comments product_icon"></i>댓글</h2>
        </div>

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
                echo ("
                <div class=\"product_comment\">
                <div class=\"comment\">
                    <p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;".$row["reply_member_id"]."</p>
                    <p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;".$row["reply_detail"]."</p>
                </div>
                </div>            
                <hr class=\"hr_gray\">                 
                ");                
            }else{
                echo ("
                    <div class=\"product_comment\">
                    <div class=\"comment\">
                        <p>".$row["member_id"]."</p>
                        <p>".$row["detail"]."</p>
                    </div>
                    </div>            
                    <hr class=\"hr_gray\">                 
                ");    
                if(isset($row["reply_member_id"])){
                    echo ("
                        <div class=\"product_comment\">
                        <div class=\"comment\">
                        <p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;".$row["reply_member_id"]."</p>
                        <p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;".$row["reply_detail"]."</p>
                    </div>
                    </div>            
                    <hr class=\"hr_gray\">                 
                    ");  
                }
                $prevCommentId = $row["comment_id"];
            }
        }
    ?>

        <form
            action="product-comment-upload.php"
            method="POST"
            class="comment_form flex">
            <input type="hidden" name="productId" value="<?= $_POST["productId"]?>">
            <h3>댓글 입력 :</h3>
            <div class="input_row" style="width:50%; margin: 0 5px 0 20px;">
                <input type="text" class="input_text" name="commnetInput" require="require">
            </div>
            <button type="submit" class="btn_white">저장</submit>
        </form>
    </div>
</section>

</div>
<?php
    $stmt->close();
    $conn->close();
?>
</body>
<?= include("footer.html"); ?>