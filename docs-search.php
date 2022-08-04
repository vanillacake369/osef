<!DOCTYPE html>
<html lang="en">

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
        <title>억새풀</title>
    </head>

    <body>
        <?php include_once("header.html"); ?>
        <section id="" class="section">
            <div class="section_container">
                <div>
                    <div class="doc_title">
                        <h1>자료실</h1>
                        <hr class="hr_darkgray">
                    </div>
                <?php    

    //현재 페이지탐색
    if(!isset($_COOKIE["docsPageCookie"])) {
        setcookie("docsPageCookie","1",time()+(600),"/") ; //86400=1day
        $currentPage = 1;
    } else {
        $currentPage = $_COOKIE["docsPageCookie"];
    }

    require_once "dbcon.php";
    //전체 페이지수
    $stmt = $conn -> prepare("SELECT COUNT(*) AS \"num\" FROM sell_info where deleteDate IS NULL"); 
    $stmt -> execute();
    $result = $stmt -> get_result();
    $row = $result -> fetch_assoc();
    $totalNum=$row['num'];
    $totalPageNum = ceil($totalNum/20);
    
    $stmt = $conn -> prepare("SELECT * FROM sell_info where deleteDate IS NULL ORDER BY upload DESC LIMIT ?,20");
    $stmt -> bind_param("i",$page);
    $page = ($currentPage-1)*20;
    $stmt -> execute();
    $result = $stmt -> get_result();
    //---------------------상단검색
    ?>
                    <div class="search_box">
                        <div class="search_box_page">
                            <p>페이지 :
                                <?= $currentPage ?>/<?=$totalPageNum ?></p>
                            <p>총게시물 :
                                <?= $totalNum ?></p>
                        </div>
                        <div class="search_box_search">
                            <form
                                name="docsForm"
                                method="post"
                                action="docs-search-submit.php"
                                enctype="multipart/form-data">
                                <div class="flex">
                                    <div class="input_row">
                                        <input
                                            type="text"
                                            name="searchWord"
                                            required="required"
                                            class="input_text"
                                            placeholder="제목 입력해 주세요">
                                    </div>
                                    <input type="submit" value="검색" class="btn_white" name="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
    //--------------------------------------------게시물 
    if($result!=NULL){    
        
        while($row = $result -> fetch_assoc()){ 
            echo("
        <div class=\"docs_box\">
                    <h2>제목 : ".$row['title']."</h2>
                    <h4>등록자 : ".$row['member_name']."</h4>
                    <h3>가격 : ".$row['price']."</h3>
        </div>
        ");
        }  
    }else{
        echo("<h2>검색결과가 없습니다</h2>");
    }
    $stmt->close();
    $conn->close();    
    
    //--------------------------------------------페이지
    
    $showingPage=4; //앞뒤로 보여지는 페이지 수
    echo("<div class=\"section\">");
    echo("<form method=\"post\" >");
    echo("<table style=\" display:inline-block; text-align: center;\"  > <tr>");
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

    echo("<td class=\"page_table_currentPage\">".$currentPage."</td>");

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
            </section>
            <form
                name="docsForm"
                method="post"
                action="docs-search-submit.php"
                enctype="multipart/form-data"
                class="section">
                <input type="text" name="searchWord" required="required" class="searchInput"/>
                <input type="submit" value="검색" class="searchSubmit" name="submit">
            </form>
        </div>
        <?php include_once("footer.html"); ?>
        <script>
            function refresh(page) {
                document.cookie = ("<?=" docsPageCookie "?> =" + page);
                location.reload();
            }
        </script>
    </body>
</html>