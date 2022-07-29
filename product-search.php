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

<body>        

<?php
    include_once("header.html"); 

    //현재 페이지탐색
    if(!isset($_COOKIE["productPageCookie"])) {
        setcookie("productPageCookie","1",time()+(600),"/") ; //86400=1day
        $currentPage = 1;
      } else {
        $currentPage = $_COOKIE["productPageCookie"];
      }
      
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
    echo("<div class=\"section\">");
    if($result!=NULL){        
        echo("<div class=\"board__list\" >");
        echo ("<table border=\"1\" class=\"board__list__table\" style=\"width: 100%;\" >");    
        echo("<th>대표이미지</th><th>모델</th><th>등록자</th><th>카테고리</th><th>등록일</th>");
        while($row = $result -> fetch_assoc()){
            echo("<form method=\"post\" action=\"product-info.php\" enctype=\"multipart/form-data\">"); 
            echo("<tr>");
            echo("<td> <img src=\"".$row['link']."\" height=\"100px\"> </td>");
            echo("<td style=\"width: 40%;\" ><input type=\"submit\" value=\"".$row['model']."\" /></td>");
            echo("<td>".$row['member_name']."</td>");
            echo("<td>".$korCategory[array_search($row['category'], $engCategory)]."</td>");
            echo("<td>".$row['upload']."</td>");        
            echo("<input type=\"hidden\" name=\"productId\" value=\"".$row['id']."\" >");
            echo("</tr> </form>");                     
        }  
        echo("</table></div>");
    }else{
        echo("<h2>검색결과가 없습니다</h2>");
    }
    $stmt->close();
    $conn->close();    
    
    //--------------------------------------------페이지
    $showingPage=4; //앞뒤로 보여지는 페이지 수
    echo("<div class=\"section\">");
    echo("<p style=\"display:inline-block\">페이지</p>"); 
    echo("<form method=\"post\">");
    echo("<table border=\"1\"> <tr>");
    if (($currentPage-$showingPage)<=1){
        for($i=1;$i<$currentPage;$i++){
            echo("<td onclick=\"refresh(".$i.")\" style=\"width:60px; cursor:pointer\">".$i."</td>");  
        }
    }else{
        echo("<td  onclick=\"refresh(".($currentPage-$showingPage-1).")\" style=\"width:60px; cursor:pointer\" > ... </td>");
        for($i=$currentPage-$showingPage;$i<$currentPage;$i++){
            echo("<td onclick=\"refresh(".$i.")\" style=\"width:60px; cursor:pointer\">".$i."</td>");  
        }
    }

    echo("<td style=\" width:60px; background-color: aqua;\">".$currentPage."</td>");

    if(($currentPage+$showingPage)>=$totalPageNum){
        for($i=$currentPage+1;$i<=$totalPageNum;$i++){
            echo("<td onclick=\"refresh(".$i.")\" style=\" width:60px; cursor:pointer\">".$i."</td>");  
        }
    }else{
        for($i=$currentPage+1;$i<=($currentPage+$showingPage);$i++){
            echo("<td onclick=\"refresh(".$i.")\" style=\"width:60px; cursor:pointer\">".$i."</td>");              
        }
        echo("<td  onclick=\"refresh(".($currentPage+$showingPage+1).")\" style=\"width:60px; cursor:pointer\" > ... </td>");
    }
    echo("</tr> </table> </form> </div>");  
    //--------------------------------------------검색 
?>

<form name = "ProductForm" method="post" action="product-search-submit.php" enctype="multipart/form-data" > 
    <table style="width:100%;  border: 1px solid #444444;">
        <tr>
        <td style="width:60%;">
        <p style="display: inline-block; ">카테고리</p>
            <select style="display: inline-block; width:50%; border:1;  border: 1px solid #444444; margin-top:5px;" name="category" >
                <option value="all">전체</option>
                <option value="etc">기타</option>
                <option value="tractor">트랙터</option>
                <option value="combine">콤바인</option>
                <option value="rice_transplanter">이양기</option>
                <option value="rotary">로터리</option>
                <option value="livestock_machinery">축산기계</option>
                <option value="forklift">포크레인</option>
            </select>
            <br>
            <p style="display: inline-block;">모델명</p>
            <input type="text" name="searchWord"  class="searchInput" style="display: inline-block; width:50%;"/> <br>
        </td>
        <td>
            일단위: <input type="date" name="dDate" /> <br>
            기간단위: 대여시작일 <input type="date" name="sDate" />
            대여종료일 <input type="date" name="eDate" /> <br>
            <input type="submit" value="모델 검색" class="searchSubmit" name="submit">
        </td>
        </tr>
    </table>
</form>
</div>
<?php include_once("footer.html"); ?>
<script>
function refresh(page) {
  document.cookie = ("productPageCookie ="+page);
  location.reload();
}
</script>
</body>
</html>