<!DOCTYPE html>
<html lang="en">
<?php
//현재 페이지탐색
    if(!isset($_COOKIE["productPageCookie"])) {
        setcookie("productPageCookie","1",time()+(600),"/") ; //86400=1day
        $currentPage = 1;
    } else {
        $currentPage = $_COOKIE["productPageCookie"];
    }
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
        <link rel="stylesheet" href="style.css">
        <script src="modal.js" defer="defer"></script>
        <title>억새풀</title>
    </head>

    <body>
        <?php include_once("header.html"); ?>
        <section id="product" class="">
            <div class="section_container">
                <ul class="product_list">
                <li onclick="location.href='product-search.php'">
                            <p>전체</p>
                    </li>
                    <li onclick="document.forms['tractorForm'].submit();">
                        <form
                            name="tractorForm"
                            method="post"
                            action="product-search-submit.php"
                            enctype="multipart/form-data">
                            <input type="hidden" name="category" value="tractor">
                            <input type="hidden" name="searchWord"/>
                            <input type="hidden" name="sDate"/>
                            <input type="hidden" name="eDate"/>
                            <p>트렉터</p>
                        </form>
                    </li>

                    <li onclick="document.forms['combineForm'].submit();">
                        <form
                            name="combineForm"
                            method="post"
                            action="product-search-submit.php"
                            enctype="multipart/form-data">
                            <input type="hidden" name="category" value="combine">
                            <input type="hidden" name="searchWord"/>
                            <input type="hidden" name="sDate"/>
                            <input type="hidden" name="eDate"/>
                            <p>콤바인</p>
                        </form>
                    </li>
                    <li onclick="document.forms['rice_transplanter Form'].submit();">
                        <form
                            name="rice_transplanter Form"
                            method="post"
                            action="product-search-submit.php"
                            enctype="multipart/form-data">
                            <input type="hidden" name="category" value="rice_transplanter">
                            <input type="hidden" name="searchWord"/>
                            <input type="hidden" name="sDate"/>
                            <input type="hidden" name="eDate"/>
                            <p>이양기</p>
                        </form>
                    </li>
                    <li onclick="document.forms['rotaryForm'].submit();">
                        <form
                            name="rotaryForm"
                            method="post"
                            action="product-search-submit.php"
                            enctype="multipart/form-data">
                            <input type="hidden" name="category" value="rotary">
                            <input type="hidden" name="searchWord"/>
                            <input type="hidden" name="sDate"/>
                            <input type="hidden" name="eDate"/>
                            <p>로터리</p>
                        </form>
                    </li>

                    <li onclick="document.forms['livestock_machineryForm'].submit();">
                        <form
                            name="livestock_machineryForm"
                            method="post"
                            action="product-search-submit.php"
                            enctype="multipart/form-data">
                            <input type="hidden" name="category" value="livestock_machinery">
                            <input type="hidden" name="searchWord"/>
                            <input type="hidden" name="sDate"/>
                            <input type="hidden" name="eDate"/>
                            <p>축산기계</p>
                        </form>
                    </li>
                    <li onclick="document.forms['forkliftForm'].submit();">
                        <form
                            name="forkliftForm"
                            method="post"
                            action="product-search-submit.php"
                            enctype="multipart/form-data">
                            <input type="hidden" name="category" value="forklift">
                            <input type="hidden" name="searchWord"/>
                            <input type="hidden" name="sDate"/>
                            <input type="hidden" name="eDate"/>
                            <p>포크레인</p>
                        </form>
                    </li>
                    <li onclick="document.forms['etcForm'].submit();">
                        <form
                            name="etcForm"
                            method="post"
                            action="product-search-submit.php"
                            enctype="multipart/form-data">
                            <input type="hidden" name="category" value="etc">
                            <input type="hidden" name="searchWord"/>
                            <input type="hidden" name="sDate"/>
                            <input type="hidden" name="eDate"/>
                            <p>기타</p>
                        </form>
                    </li>

                    <li>
                        <button class="openBtn">필터</button>
                        <div id="modal" class="hidden">
                            <div class="modal_bg"></div>
                            <div class="modalBox">
                                <form
                                    name="ProductForm"
                                    method="post"
                                    action="product-search-submit.php"
                                    enctype="multipart/form-data">
                                    <div class="flex">
                                        <p>모델명</p>
                                        <div class="input_row" style="width: 40%; margin: 30px;">
                                            <input
                                                type="text"
                                                name="searchWord"
                                                class="input_text"
                                                placeholder="모델명을 입력해주세요">
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <p>종류</p>
                                        <select
                                            class="input_row"
                                            style="width: 40%; margin: 30px; margin-left: 40px;"
                                            name="category">
                                            <option value="all">전체</option>
                                            <option value="etc">기타</option>
                                            <option value="tractor">트랙터</option>
                                            <option value="combine">콤바인</option>
                                            <option value="rice_transplanter">이양기</option>
                                            <option value="rotary">로터리</option>
                                            <option value="livestock_machinery">축산기계</option>
                                            <option value="forklift">포크레인</option>
                                        </select>
                                    </div>

                                    <div class="flex">
                                        <p>시작일</p>
                                        <div class="input_row" style="width: 40%; margin: 30px;">
                                            <input type="date" name="sDate" class="input_text" placeholder="">
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <p>종료일</p>
                                        <div class="input_row" style="width: 40%; margin: 30px;">
                                            <input type="date" name="eDate" class="input_text" placeholder="">
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <button type="button" class="lend_answer_back" style="margin: 30px;">
                                            <p>닫기</p>
                                        </button>
                                        <button
                                            type="submit"
                                            class="lend_answer_back"
                                            value="모델 검색"
                                            style="margin: 30px;">
                                            <p>검색</p>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
    <?php   
    
    require_once "dbcon.php";

    //전체 페이지수
    $stmt = $conn -> prepare("SELECT COUNT(*) AS \"num\" FROM product where deleteDate IS NULL"); 
    $stmt -> execute();
    $result = $stmt -> get_result();
    $row = $result -> fetch_assoc();
    $totalPageNum = ceil($row['num']/20);
    
    $stmt = $conn -> prepare("SELECT * FROM product LEFT JOIN file ON product.id= file.p_id where deleteDate IS NULL GROUP BY (id) ORDER BY upload DESC LIMIT ?,20;");
    $stmt -> bind_param("i",$page);
    $page = ($currentPage-1)*20;
    $stmt -> execute();
    $result = $stmt -> get_result();

    $engCategory=['tractor','combine','rice_transplanter','rotary','livestock_machinery','forklift','etc','all'];
    $korCategory=['트랙터','콤바인','이양기','로터리','축산기계','포크레인','기타','전체'];
    
    //--------------------------------------------게시물    
    

    if($result!=NULL){    
        echo("
        <section id=\"product_item\" class=\"\">
        <div class=\"section\"> 
        <div class=\"product_item_wrap\">
        ");
        $n=0;
        while($row = $result -> fetch_assoc()){
            $n++;            
            echo("
            <div class=\"product_list_item\" onclick=\" document.forms['productID".$row['id']."'].submit();\">
            <form method=\"post\" action=\"product-info.php\" enctype=\"multipart/form-data\" name=\"productID".$row['id']."\">
                <input type=\"hidden\" name=\"productId\" value=\"".$row['id']."\" >
                <img src=\"".$row['link']."\" class=\"product_list_item_img\">
                <div class=\"product_item_detail\">
                    <h3>".$row['model']."</h3>
                    <p>".$korCategory[array_search($row['category'], $engCategory)]."</p>
                    <p>".$row['place']."</p>
                    <p>".$row['start_date']."~".$row['end_date']."</p>
                    <h3>".$row['price']." /박</h3>
                </div>
                </form>
            </div>
            
            ");                    
        }  
        echo("</div></div></section>");
    }
    $stmt->close();
    $conn->close();
    
    //--------------------------------------------페이지
    $showingPage=4; //앞뒤로 보여지는 페이지 수
    echo("<div class=\"section\">");
    echo("<form method=\"post\">");
    echo("<table style=\" display:inline-block; text-align: center;\"> <tr>");
    if (($currentPage-$showingPage)<=1){
        for($i=1;$i<$currentPage;$i++){
            echo("<td class=\"page_table\" onclick=\"refresh(".$i.")\">".$i."</td>");  
        }
    }else{
        echo("<td class=\"page_table\" onclick=\"refresh(".($currentPage-$showingPage-1).")\"> ... </td>");
        for($i=$currentPage-$showingPage;$i<$currentPage;$i++){
            echo("<td class=\"page_table\" onclick=\"refresh(".$i.")\">".$i."</td>");  
        }
    }

    echo("<td class=\"page_table_currentPage\" >".$currentPage."</td>");

    if(($currentPage+$showingPage)>=$totalPageNum){
        for($i=$currentPage+1;$i<=$totalPageNum;$i++){
            echo("<td class=\"page_table\" onclick=\"refresh(".$i.")\">".$i."</td>");  
        }
    }else{
        for($i=$currentPage+1;$i<=($currentPage+$showingPage);$i++){
            echo("<td class=\"page_table\" onclick=\"refresh(".$i.")\">".$i."</td>");              
        }
        echo("<td class=\"page_table\" onclick=\"refresh(".($currentPage+$showingPage+1).")\"> ... </td>");
    }
    echo("</tr> </table> </form> </div>");      
?>
    </div>
    <?php include_once("footer.html"); ?>
    <script>
        function refresh(page) {
            document.cookie = ("productPageCookie =" + page);
            location.reload();
        }
    </script>
</body>
</html>