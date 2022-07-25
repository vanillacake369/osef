<!DOCTYPE html>
<html lang="en">

<?php include_once "header.html"; ?>

<?php include_once "check-session.php"?>

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
                        <th style="text-align:center">수정</th>
                        <th style="text-align:center">삭제</th>
                        <!-- <th scope="col">우선순위</th> // priority : 우선순위 "클릭 시 해당 농기계 페이지로 이동--> 
                        <!-- <th scope="col">상세내용</th> // priority : 상세내용 "클릭 시 해당 농기계 페이지로 이동-->
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    include "dbcon.php";
                    $id = $_SESSION['id'];
                    //$product_query = "SELECT * FROM product WHERE member_id = '$id'";
                    $product_query = "SELECT * FROM product LEFT JOIN file ON product.id= file.p_id where member_id='{$_SESSION['id']}' AND deleteDate IS NULL";
                    $result = mysqli_query($conn, $product_query);
                    while($row = mysqli_fetch_array($result)){
                        echo <<< VIEW_PRODUCT
                        <tr>
                            <td>{$row['id']}</td>
                            <td><img class="product-img" src="{$row['link']}"></td>
                            <td>{$row['model']}</td> 
                            <td>{$row['maker']}</td>
                            <td>{$row['category']}</td>
                            <td>{$row['make_year']}</td>
                            <td>{$row['start_date']}</td>
                            <td>{$row['end_date']}</td>
                            <td>{$row['place']}</td>
                            <td>{$row['upload']}</td>
                            <td>{$row['price']}</td>
                            <td><button class="btn-primary edit" type="button" onclick="member-product-modify.php">수정</button></td>
                            <td><button class="btn-primary delete" type="button" onclick="member-product-delete.php">삭제</button></td>
                        </tr>
                        VIEW_PRODUCT;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- add default footer -->
    <?php include_once "footer.html" ?>

</body>
</html>