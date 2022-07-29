<!DOCTYPE html>
<html lang="en">

<!--ADD HEADER-->
<?php include_once "header.html"; ?>
<!--CHECK SESSION-->
<?php include_once "check-session.php"?>

<body>
    <!-- add default profile -->
    <?php include_once "member-profile.php" ?>

    <section>
        <form name="docs-modify" method="post" action="member-docs-modify.php" enctype="multipart/form-data">
            <div class = "signup_wrap">
                <p>기기ID</p>
                <?php echo "<p>{$_POST['docs_id']}</p>" ?>
                <?php echo <<<PRODUCT_ID
                <input type="hidden" name="docs_id" value={$_POST['docs_id']}></input> 
                PRODUCT_ID;
                ?>
                <p>문서 제목</p>
                <input type="text" name="title" class="modify" placeholder="문서 제목" required/>
                <p>상세내용</p>
                <textarea row="10" cols="30" name="detail" class="modify" placeholder="상세내용" required></textarea>
                <p>판매가격</p>
                <input type="text" name="price" class="modify" placeholder="임대가격" required/>
                <p>파일 입력 (txt, ppt, pptx, pdf파일 외에는 입력이 불가합니다.) </p>
                <input type="file" name="pdfFile" class="modify" accept=".txt, .ppt, .pptx, .pdf" required />
                <br>
                <button type="submit" class="btn-primary edit">기기 수정</button>
            </div>
        </form>
    </section>

</body>
</html>