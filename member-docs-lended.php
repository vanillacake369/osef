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
                        <th>문서 제목</th>
                        <th>문서 내용</th>
                        <th>구매 가격</th>
                        <th>업로드일</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // DB CONN
                    require_once "dbcon.php";

                    // SELL INFO QUERY
                    $id = $_SESSION['id'];
                    $docs_count = 0;
                    $product_query = "SELECT * FROM info_buy_list LEFT JOIN sell_info ON sell_info.id = info_buy_list.sell_info_id 
                    WHERE info_buy_list.member_id='{$_SESSION['id']}' AND deleteDate IS NULL GROUP BY (info_buy_list.id)";
                    $result = mysqli_query($conn, $product_query);
                    
                    // SHOW TABLE
                    if($result->num_rows == 0){
                        echo <<< ZERO_PRODUCT
                            <tr>
                                <td colspan = '5'><h4>구매하신 문서가 없습니다.</h4></td>
                            </tr>
                        ZERO_PRODUCT;
                    }else{
                        while($row = mysqli_fetch_array($result)){
                            $docs_count += 1;
                            echo <<< VIEW_PRODUCT
                            <tr>
                                <td>$docs_count</td>
                                <td>{$row['title']}</td> 
                                <td>{$row['detail']}</td>
                                <td>{$row['price']}</td>
                                <td>{$row['upload']}</td>
                            VIEW_PRODUCT;
                        }
                    }
                    // CLOSE DB CONNECTION
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