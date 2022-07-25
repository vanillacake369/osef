<?php
if(isset($_POST['submit'])){
    $fileDir = $_FILES['pdfFile']['tmp_name'];
    $fileTypeExt = explode("/",$_FILES['pdfFile']['type']);

    $fileType = $fileTypeExt[0];

    $fileExt = $fileTypeExt[1];

    switch($fileExt){
        case 'txt':
        case 'ppt':
        case 'pptx':
        case 'pdf':
            break;
 
        default:
        echo "<script>alert(\"txt, ppt, pptx, pdf파일 외에는 사용이 불가합니다.\");";
        echo "history.go(-1);</script>";
            exit;
            break;
    }

    //---------------------------------get uploader info--------
    
    $id = $_SESSION["id"];
    require_once "dbcon.php";

    $sql = "SELECT phone, email, name from member where ID = '".$id."';";
    $result = $conn->query($sql);

    $sql="SELECT phone, email, name from member where ID = ?";
    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("i",$id);            
    $stmt -> execute();
    $result = $stmt -> get_result();

    if ($row = $result -> fetch_assoc()) {
        $name=$row["name"];
        $phone=$row["phone"];
        $email=$row["email"];
    } else {
        echo "멤버 정보 확인할수 없음";
    }  

    //---------------------------------upload DB--------
    $sql="insert into sell_info(title, detail, price, member_id, member_phone, member_email, member_name)
        VALUE ( ?,?,?,?,?,?,?) RETURNING id;";
    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("ssissss",$_POST['title'],$_POST['detail'],$_POST['price'],$id,$phone,$email,$name);            
    $stmt -> execute();
    $result = $stmt -> get_result();   

    if ($row = $result->fetch_assoc()) {        
        $uploadId=$row["id"];
    } else {
        echo "UPLOAD ERROR: ".$conn->error;
        echo "Connection failed: " . $conn->connect_error;
        echo "history.go(-1);</script>";
    }

    //---------------------------------save image file--------
    
    $fileDir = $_FILES['pdfFile']['tmp_name'];        
    $filename = $_FILES['pdfFile']['name'];
        
        //add id end of name
    $splitFilename = explode(".",$filename);      
    $filename = "";
    for($j=0;$j<count($splitFilename)-1;$j++){
        $filename .= $splitFilename[$j];
    }
    $filename .= $uploadId.".".$splitFilename[count($splitFilename)-1];
        

    $resFile = "./uploadFile/".$filename;        
    $imageUpload = move_uploaded_file($fileDir, $resFile);
                
    if($imageUpload != true){
        echo "<script> alert(\"파일 업로드에 실패하였습니다.\") </script>";
        echo "history.go(-1);</script>";
    }
    
    $sql="INSERT INTO file(s_id,link) VALUE (?,?);";
    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("is",$uploadId,$resFile);            
    $stmt -> execute();
    $result = $stmt -> get_result();

    $stmt->close();
    $conn->close();

    echo "<script>alert(\"등록되었습니다\");";
    echo "location.href= \"index.php\";</script>";
}
include_once("header.html");
include_once("docs-register.html");
include_once("footer.html");

?>