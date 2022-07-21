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
    $cookieSearchWorld = str_replace(" ", "_",$_POST["searchWord"]);
    if(!isset($_COOKIE["productPageCookie".$cookieSearchWorld])) {
        setcookie("productPageCookie".$cookieSearchWorld,"1",time()+(600),"/") ; //86400=1day
        $currentPage = 1;
      } else {
        $currentPage = $_COOKIE["productPageCookie".$cookieSearchWorld];
      }

    $servername = "localhost";
    $DBname = "root";
    $DBpassword = "1234";    

    $conn = new mysqli($servername,$DBname,$DBpassword,"farm");
    $conn -> set_charset('utf8mb4');
    //전체 페이지수
    $search =  $_POST["searchWord"];
    $search="%$search%";
    
    $sqlcount = 0;
    $sql1 ="SELECT COUNT(*) AS \"num\" FROM product where ";
    $sql2 ="SELECT * FROM product LEFT JOIN file ON product.id= file.p_id where ";
    if($_POST["category"]!="all"){
        $sql1 .= "category = \"".$_POST["category"]."\" AND ";
        $sql2 .= "category = \"".$_POST["category"]."\" AND ";
    }
    if($_POST["dDate"] != null){
        $sql1 .= "start_date < str_to_date('".$_POST["dDate"]."', '%Y-%m-%d') AND end_date > str_to_date('".$_POST["dDate"]."', '%Y-%m-%d')";
        $sql2 .= "start_date < str_to_date('".$_POST["dDate"]."', '%Y-%m-%d') AND end_date > str_to_date('".$_POST["dDate"]."', '%Y-%m-%d')";
    }
    if($_POST["sDate"] != null){
        $sql1 .= "start_date < str_to_date('".$_POST["sDate"]."', '%Y-%m-%d') AND end_date > str_to_date('".$_POST["eDate"]."', '%Y-%m-%d')";
        $sql2 .= "start_date < str_to_date('".$_POST["sDate"]."', '%Y-%m-%d') AND end_date > str_to_date('".$_POST["eDate"]."', '%Y-%m-%d')";
    }
    
    
    $sql1 .= "model LIKE ? AND deleteDate IS NULL";
    $sql2 .= "model LIKE ? AND deleteDate IS NULL GROUP BY (id) LIMIT ?,20";

    $stmt = $conn -> prepare($sql1);
    
    $stmt -> bind_param("s", $search);
    $stmt -> execute();
    $result = $stmt -> get_result();
    $row = $result -> fetch_assoc();
    $totalPageNum = ceil($row['num']/20);

    $stmt = $conn -> prepare($sql2);    
    $stmt -> bind_param("si", $search, $page);
    $page = ($currentPage-1)*20;
    $stmt -> execute();
    $result = $stmt -> get_result();   
    echo("<div class=\"section\">"); 
    echo ("<h1 > \"".$_POST["searchWord"]."\" 검색결과 </h1>");
    //--------------------------------------------게시물    
   
    if($result!=NULL){        
        echo("<div class=\"board__list\" >");
        echo ("<table border=\"1\" class=\"board__list__table\" style=\"width: 100%;\" >");    
        echo("<th>대표이미지</th><th>모델</th><th>등록자</th><th>등록일</th>");
        while($row = $result -> fetch_assoc()){
            echo("<form method=\"post\" action=\"product-info.php\" enctype=\"multipart/form-data\">"); 
            echo("<tr>");
            echo("<td> <img src=\"".$row['link']."\" height=\"100px\"> </td>");
            echo("<td style=\"width: 40%;\" ><input type=\"submit\" value=\"".$row['model']."\" /></td>");
            echo("<td>".$row['member_name']."</td>");
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
    echo("<form method=\"post\" >");
    echo("<p style=\"display:inline-block\">페이지</p>"); 
    echo("<table border=\"1\" style=\" display:inline-block; text-align: center;\"  > <tr>");
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
?>
<form name = "ProductForm" method="post" action="product-search-submit.php" enctype="multipart/form-data" > 
    <p style="display: inline-block;">카테고리</p>
    <select style="display: inline-block; width:100px; border:1;" name="category" >
        <option value="all">전체</option>
        <option value="etc">기타</option>
        <option value="tractor">트랙터</option>
        <option value="combine">콤바인</option>
        <option value="rice transplanter">이양기</option>
        <option value="rotary">로터리</option>
        <option value="livestock machinery">축산기계</option>
        <option value="forklift">포크레인</option>
    </select>
    <br>
    <p style="display: inline-block;">모델명</p>
    <input type="text" name="searchWord" required class="searchInput" style="display: inline-block;"/> <br>
    대여당일 <input type="date" name="Date" /> <br>
    대여시작일 <input type="date" name="Date" /> <br>
    대여종료일 <input type="date" name="Date" /> <br>
    <input type="submit" value="모델 검색" class="searchSubmit" name="submit">
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