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
                        <th>가격</th>
                        <th>판매수</th>
                        <th>업로드일</th>
                        <th>수정</th>
                        <th>삭제</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // DB CONNECTION
                    require_once "dbcon.php";

                    // GET DOCS INFO
                    $id = $_SESSION['id'];
                    $product_query = "SELECT * FROM sell_info LEFT JOIN file ON sell_info.id= file.s_id where member_id='{$_SESSION['id']}' AND deleteDate IS NULL GROUP BY (id)";
                    $result = mysqli_query($conn, $product_query);

                    // UPLOAD INFO
                    if($result->num_rows == 0){
                        echo <<< ZERO_DOCS
                            <tr>
                                <td colspan = '8'><h4>등록하신 문서가 없습니다.</h4></td>
                            </tr>
                        ZERO_DOCS;
                    }while($row = mysqli_fetch_array($result)){
                            echo <<< VIEW_DOCS
                            <tr>
                                <td>{$row['id']}</td>
                                <td>{$row['title']}</td> 
                                <td>{$row['detail']}</td>
                                <td>{$row['price']}</td>
                                <td>{$row['sellnum']}</td>
                                <td>{$row['upload']}</td>
                                <td>
                                    <form id="docs-modify-form" action="member-docs-modify-form.php" method="POST">
                                        <input type="hidden" name="docs_id" value={$row['id']}></input>
                                        <button class="btn-primary edit" type="submit" name="docs-modify-btn">수정</button>
                                    </form>
                                </td>
                                <td>
                                    <form id="docs-delete-form" action="member-docs-delete.php" method="POST" onsubmit="return confirm_delete()">
                                        <input type="hidden" name="docs_id" value={$row['id']}></input>
                                        <button class="btn-primary delete" type="submit" name="docs-delete-btn">삭제</button>
                                    </form>
                                </td>
                            </tr>
                            VIEW_DOCS;
                    }

                    // DB CLOSE
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
            if (!window.confirm("정말로 등록하신 농업기술 문서를 삭제하시겠습니까?")) {
                window.alert("농업기술 문서 삭제가 취소되었습니다.");
                window.location.reload();
                return false;
            }
        }
    </script>

    <!-- add default footer -->
    <?php include_once "footer.html" ?>

</body>
</html>