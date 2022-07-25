<?php
session_start();
include_once "check-session.php";
//function upload(){
    //---------------------------------img file conform--------
    $username='root';
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
    
    $id = $_SESSION["id"];
    require_once "dbcon.php";

    $sql="SELECT phone, email, name from member where ID = ?";
    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("s",$id);            
    $stmt -> execute();
    $result = $stmt -> get_result();

    $name=$phone=$email="";

    if ($row = $result->fetch_assoc()) {
        $name=$row["name"];
        $phone=$row["phone"];
        $email=$row["email"];
    } else {
        echo "멤버 정보 확인할수 없음";
    }


    //---------------------------------upload DB--------

    $sql = "insert into product(category,start_date,end_date,detail,member_id,member_phone,member_email,member_name,place,price,maker,make_year,model)
        VALUE ( '".$_POST['category']."','".$_POST['startDate']."','".$_POST['endDate']."','".$_POST['detail']."','".$id."','".$phone."','".$email
        ."','".$name."','".$_POST['adress']."','".$_POST['price']."','".$_POST['maker']."','".$_POST['makeDate']."','".$_POST['model']."') RETURNING id;";

        $sql="INSERT INTO product(category,start_date,end_date,detail,member_id,member_phone,member_email,member_name,place,price,maker,make_year,model)
        VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?) RETURNING id;";
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param("sssssssssisss", $_POST['category'],$_POST['startDate'],$_POST['endDate'],$_POST['detail'],$id,$phone,$email,$name,$_POST['adress'],$_POST['price'],$_POST['maker'],$_POST['makeDate'],$_POST['model']);            
        $stmt -> execute();
        $result = $stmt -> get_result();

    if ($row = $result->fetch_assoc()) {        
        $uploadId=$row["id"];
    } else {
        echo "UPLOAD ERROR: ".$conn->error;
    }

    //---------------------------------save image file--------
    

    for( $i = 0; $i<$fileNumCount;$i++){
        $fileDir = $_FILES['imgFile']['tmp_name'][$i]; //경로명포함 파일명
        
        $filename = $_FILES['imgFile']['name'][$i]; //순수파일명
        
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

    $sql="insert into file(p_id,link) VALUE ";
    for($i=0;$i<$fileNumCount-1;$i++){
        $sql.="('".$uploadId."','".$imgArray[$i]."'),";        
    }
    $sql.="('".$uploadId."','".$imgArray[$i]."');";
    $conn->query($sql);
    $stmt->close();
    $conn->close();

    echo "<script>alert(\"등록되었습니다\");";
    echo "location.href= \"index.php\";</script>";
?>