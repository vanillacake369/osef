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
                        <th style="text-align:center">수정</th>
                        <th style="text-align:center">삭제</th>
                        <!-- <th scope="col">우선순위</th> // priority : 우선순위 "클릭 시 해당 농기계 페이지로 이동--> 
                        <!-- <th scope="col">상세내용</th> // priority : 상세내용 "클릭 시 해당 농기계 페이지로 이동-->
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    require_once "dbcon.php";
                    $id = $_SESSION['id'];
                    //$product_query = "SELECT * FROM product WHERE member_id = '$id'";
                    $product_query = "SELECT * FROM product LEFT JOIN file ON product.id= file.p_id where member_id='{$_SESSION['id']}' AND deleteDate IS NULL GROUP BY (id)";
                    $result = mysqli_query($conn, $product_query);
                    if($result->num_rows == 0){
                        echo <<< ZERO_PRODUCT
                            <tr>
                                <td colspan = '13'><h4>등록하신 제품이 없습니다.</h4></td>
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
                                <td>
                                    <form id="product-modify-form" action="member-product-modify-form.php" method="POST">
                                        <input type="hidden" name="product_id" value={$row['id']}></input>
                                        <button class="btn-primary edit" type="submit" name="product-modify-btn">수정</button>
                                    </form>
                                </td>
                                <td>
                                    <form id="product-delete-form" action="member-product-delete.php" method="POST" onsubmit="return confirm_delete()">
                                        <input type="hidden" name="product_id" value={$row['id']}></input>
                                        <button class="btn-primary delete" type="submit" name="product-delete-btn">삭제</button>
                                    </form>
                                </td>
                            </tr>
                            VIEW_PRODUCT;
                    }
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <script type="text/javascript">
        document.getElementById('member-delete-form').onsubmit = function(){
            return confirm_delete();
        }
        function confirm_delete() {
            if (!window.confirm("정말로 등록하신 농기기를 삭제하시겠습니까?")) {
                window.alert("농기기 삭제가 취소되었습니다.");
                window.location.reload();
                return false;
            }
        }
    </script>

    <!-- add default footer -->
    <?php include_once "footer.html" ?>

</body>
</html>