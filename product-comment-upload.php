<?php
    session_start();
    if(!isset($_SESSION['id'])) {
        echo "<script> alert(\"로그인이 필요합니다\"); </script>";
    }else{       
        require_once("dbcon.php");
        $sql="INSERT INTO comment (p_id, member_id, detail) VALUES (?,?,?);";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("iss",$_POST["productId"],$_SESSION['id'],$_POST["commnetInput"]);            
        $stmt -> execute();
    }    
?>
<html>
<body>
    <form action="product-info.php" method="POST">
        <input type="hidden" name="productId" value="<?= $_POST["productId"]?>">
        <button type="submit" id="autoSubmit" value="true"> </submit>
    </form>
    <script>
        document.getElementById("autoSubmit").click();
    </script>
</body>
</html>