<!DOCTYPE html>
<html lang="en">

<!--ADD HEADER-->
<?php include_once "header.html"; ?>
<!--CHECK SESSION-->
<?php include_once "check-session.php"?>

<body>
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
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    require_once "dbcon.php";
                    $id = $_SESSION['id'];
                    //$product_query = "SELECT * FROM product WHERE member_id = '$id'";
                    $product_query = "SELECT * FROM product LEFT JOIN file ON product.id= file.p_id WHERE member_id='{$_SESSION['id']}' AND close=1 AND deleteDate IS NULL GROUP BY (id)";
                    $result = mysqli_query($conn, $product_query);
                    if($result->num_rows == 0){
                        echo <<< ZERO_PRODUCT
                            <tr>
                                <td colspan = '11'><h4>등록하신 제품이 없습니다.</h4></td>
                            </tr>
                        ZERO_PRODUCT;
                    }while($row = mysqli_fetch_array($result)){
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
                            VIEW_PRODUCT;
                    }
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    
    <!-- add default footer -->
    <?php include_once "footer.html" ?>

</body>
</html>