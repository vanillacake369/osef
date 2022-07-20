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
    session_start();
    //$id = $_SESSION["id"];
    $id = "admin";

    $servername = "localhost";
    $DBname = "root";
    $DBpassword = "1234";
    
    $conn = new mysqli($servername, $DBname, $DBpassword, "farm");
    $conn -> set_charset('utf8mb4');

    if ($conn->connect_error) {
        echo "<script>alert(\"Connection failed: " . $conn->connect_error."\")";
        echo "history.go(-1);</script>";
    }

    $sql = "SELECT phone, email, name from member where ID = '".$id."';";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name=$row["name"];
        $phone=$row["phone"];
        $email=$row["email"];
    } else {
        echo "멤버 정보 확인할수 없음";
    }
    $conn->close();    

    //---------------------------------upload DB--------

    $sql = "insert into sell_info(title, detail, price, member_id, member_phone, member_email, member_name)
        VALUE ( '".$_POST['title']."','".$_POST['detail']."','".$_POST['price']."','".$id."','".$phone."','".$email
        ."','".$name."') RETURNING id;";

    $conn = new mysqli($servername, $DBname, $DBpassword, "farm");
    $conn -> set_charset('utf8mb4');
    
    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
        echo "history.go(-1);</script>";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $uploadId=$row["id"];
    } else {
        echo "UPLOAD ERROR: ".$conn->error;
        echo "Connection failed: " . $conn->connect_error;
        echo "history.go(-1);</script>";
    }
    $conn->close();

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

    

    $conn = new mysqli($servername, $DBname, $DBpassword, "farm");
    $conn -> set_charset('utf8mb4');
    $sql="insert into file(s_id,link) VALUE ('".$uploadId."','".$resFile."');";
    $conn->query($sql);

    $conn->close();

    echo "<script>alert(\"등록되었습니다\");";
    echo "location.href(\"./index.php\");</script>";
}
include_once("header.html");
include_once("docs-register.html");
include_once("footer.html");

?>