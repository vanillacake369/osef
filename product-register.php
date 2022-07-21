<?php
//function upload(){
    //---------------------------------img file conform--------

    $fileNumCount = count($_FILES['imgFile']['name']);
    $imgArray = array();

    for( $i = 0; $i<$fileNumCount;$i++){        
        $fileDir = $_FILES['imgFile']['tmp_name'][$i];
        $fileTypeExt = explode("/",$_FILES['imgFile']['type'][$i]);

        $fileType = $fileTypeExt[0];

        $fileExt = $fileTypeExt[1];

        switch($fileExt){
            case 'jpeg':
            case 'jpg':
            case 'gif':
            case 'bmp':
            case 'png':
                break;
     
            default:
                die ("이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다."); 
                exit;
                break;
        }
        
        if($fileType != 'image'){
            die ("이미지 파일이 아닙니다");
        }
    }

    //---------------------------------get uploader info--------
    //session_start();
    //$id = $_SESSION["id"];
    $id = "admin";

    $servername = "localhost";
    $DBname = "root";
    $DBpassword = "1234";
    
    $conn = new mysqli($servername, $DBname, $DBpassword, "farm");
    $conn -> set_charset('utf8mb4');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
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

    $sql = "insert into product(category,start_date,end_date,detail,member_id,member_phone,member_email,member_name,place,price,maker,make_year,model)
        VALUE ( '".$_POST['category']."','".$_POST['startDate']."','".$_POST['endDate']."','".$_POST['detail']."','".$id."','".$phone."','".$email
        ."','".$name."','".$_POST['adress']."','".$_POST['price']."','".$_POST['maker']."','".$_POST['makeDate']."','".$_POST['model']."') RETURNING id;";

    $conn = new mysqli($servername, $DBname, $DBpassword, "farm");
    $conn -> set_charset('utf8mb4');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $uploadId=$row["id"];
    } else {
        echo "UPLOAD ERROR: ".$conn->error;
    }
    $conn->close();

    //---------------------------------save image file--------
    

    for( $i = 0; $i<$fileNumCount;$i++){
        $fileDir = $_FILES['imgFile']['tmp_name'][$i];
        
        $filename = $_FILES['imgFile']['name'][$i];
        
        //add id end of name
        $splitFilename = explode(".",$filename);      
        $filename = "";
        for($j=0;$j<count($splitFilename)-1;$j++){
            $filename .= $splitFilename[$j];
        }
        $filename .= $uploadId.".".$splitFilename[count($splitFilename)-1];
        

        $resFile = "./uploadFile/".$filename;        
        $imageUpload = move_uploaded_file($fileDir, $resFile);
        
        array_push($imgArray,$resFile);
                
        if($imageUpload == true){
            echo "파일이 정상적으로 업로드 되었습니다. <br>";
        }else{
            die ("파일 업로드에 실패하였습니다.");
        }        
    }   

    $conn = new mysqli($servername, $DBname, $DBpassword, "farm");
    $conn -> set_charset('utf8mb4');
    for($i=0;$i<$fileNumCount;$i++){
        $sql="insert into file(p_id,link) VALUE ('".$uploadId."','".$imgArray[$i]."');";
        $conn->query($sql);
    }

    $conn->close();

    echo "<script>alert(\"등록되었습니다\");";
    echo "location.href= \"index.php\";</script>";
//}
//include_once("header.html");
//include_once("product-register.html");
//include_once("footer.html");
// if(isset($_POST['submit'])){
//     upload();
// }
?>