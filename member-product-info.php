<?php include_once "check-session.php"?>

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

<style>
    .myproduct-table{
        border-collapse : collapse;
        font-size: 0.9em;
        min-width: 400px;
    }
</style>

<body>
    <!-- add default header -->
    <?php include_once "header.html" ?>

    <!-- add default profile -->
    <?php include_once "member-profile.php" ?>

    <!-- begin product info section -->
    <section>
        <div>
            <table class="myproduct-table">
                <thead>
                    <tr>
                        <th>No</th> <!-- id -->
                        <th>상품이미지</th>
                        <th>기종 및 형식명</th>
                        <th>제조사</th>
                        <th>농기구 종류</th>
                        <th>제조년식</th>
                        <th>임대 시작일</th>
                        <th>임대 종료일</th>
                        <th>대여장소</th>
                        <th>등록일</th>
                        <th>가격</th>
                        <!-- <th scope="col">우선순위</th> // priority : 우선순위 "클릭 시 해당 농기계 페이지로 이동--> 
                        <!-- <th scope="col">상세내용</th> // priority : 상세내용 "클릭 시 해당 농기계 페이지로 이동--> 
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <!-- <td><img src="C:/Users/admin/Documents/Personal/profile/vanilla.png" alt="Vanilla Image" width="500" height="500"></td> -->
                        <td>
    <img class="fit-picture"
     src="https://www.yanmar.com/ltc/kr/agri/img/d3da6c6016/img_index_01.jpg"
     alt="Grapefruit slice atop a pile of other slices"></td>
                        <td>기종 및 형식명</td>
                        <td>제조사</td>
                        <td>농기구 종류</td>
                        <td>제조년식</td>
                        <td>임대 시작일</td>
                        <td>임대 종료일</td>
                        <td>대여장소</td>
                        <td>등록일</td>
                        <td>가격</td>
                        <td><button class="btn_back small" type="button" onclick="member-product-modify.php">수정하기</button></td>
                        <td><button class="btn_withe small" type="button" onclick="member-product-delete.php">삭제하기</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    <!-- add default footer -->
    <?php include_once "footer.html" ?>

</body>
</html>