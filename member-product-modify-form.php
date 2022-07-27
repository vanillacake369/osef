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
        <form name="product-modify" method="post" action="member-product-modify.php" enctype="multipart/form-data">
            <div class = "signup_wrap">
                <p>기기ID</p>
                <?php echo "<p>{$_POST['product_id']}</p>" ?>
                <?php echo <<<PRODUCT_ID
                <input type="hidden" name="product_id" value={$_POST['product_id']}></input> 
                PRODUCT_ID;
                ?>
                <p>기종 및 형식명</p>
                <input type="text" name="model" class="modify" placeholder="기종 및 형식명" required/>
                <p>제조사</p>
                <input type="text" name="maker" class="modify" placeholder="제조사" required/>
                <p>농기구 종류</p>
                <select name="category" class="modify category" required>
                    <option value="" disabled selected>농기구종류를 선택해주세요</option>
                    <option value="etc">기타</option>
                    <option value="tractor">트랙터</option>
                    <option value="combine">콤바인</option>
                    <option value="rice transplanter">이양기</option>
                    <option value="rotary">로터리</option>
                    <option value="livestock machinery">축산기계</option>
                    <option value="forklift">포크레인</option>
                </select>
                <p>제조년식</p> <input type="date" name="makeDate" class="modify" placeholder="제조년식" required/>
                <p>시작일</p> <input type="date" name="startDate" class="modify" placeholder="시작일" required/> 
                <p>종료일</p> <input type="date" name="endDate" class="modify" placeholder="종료일" required/> <br>
                <p>임대가능주소</p> <input type="text" name="address" class="modify" placeholder="임대가능주소" required/>
                <p>상세내용</p>
                <textarea row="10" cols="30" name="detail" class="modify" placeholder="상세내용" required></textarea>
                <p>임대가격</p>
                <input type="text" name="price" class="modify" placeholder="임대가격" required/>
                <p>사진 입력 ( jpg, bmp, gif, png외에는 입력이 불가합니다 )</p>
                <input type="file" multiple name="imgFile[]" class="modify" placeholder="사진" accept=".jpg, .bmp, .gif, .png" required/>
                <br>
                <button type="submit" name="submit" class="btn-primary edit">기기 수정</button>
            </div>
        </form>
    </section>

</body>
</html>