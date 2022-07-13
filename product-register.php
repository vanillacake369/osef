<?php
    //---------------------------------get uploader info
    session_start();
    //$id = $_SESSION["id"];
    $id = "admin";


    // $servername = "localhost";
    // $DBname = "root";
    // $DBpassword = "1234";
    
    // $conn = new mysqli($servername, $DBname, $DBpassword, "farm");
    // $conn -> set_charset('utf8mb4');

    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }

    // $sql = "SELECT phone, email, name from member where ID = '".$id."';";
    // $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     $row = $result->fetch_assoc();
    //     $name=$row["name"];
    //     $phone=$row["phone"];
    //     $email=$row["email"];
    // } else {
    //     echo "멤버 정보 확인할수 없음";
    // }
    // $conn->close();
    

    //---------------------------------save image file--------
    $total_count = count($_FILES['imgFile']['name']);
    for( $i = 0; $i<$total_count;$i++){
        $fileDir = $_FILES['imgFile']['tmp_name'][$i];
        $fileTypeExt = explode("/",$_FILES['imgFile']['type'][$i]);

        $fileType = $fileTypeExt[0];

        $fileExt = $fileTypeExt[1];
        $extStatus = false;

        switch($fileExt){
            case 'jpeg':
            case 'jpg':
            case 'gif':
            case 'bmp':
            case 'png':
                $extStatus = true;
                break;
        
            default:
                echo "이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다."; 
                exit;
                break;
        }
    
        if($fileType == 'image'){
            if($extStatus){
                $resFile = "./uploadImg/{$_FILES['imgFile']['name'][$i]}";
                $imageUpload = move_uploaded_file($fileDir, $resFile);
            
                if($imageUpload == true){
                    echo "파일이 정상적으로 업로드 되었습니다. <br>";
                    echo "<img src='{$resFile}' width='100' />";
                }else{
                    echo "파일 업로드에 실패하였습니다.";
                }
            }
            else {
                echo "파일 확장자는 jpg, bmp, gif, png 이어야 합니다.";
                exit;
            }	
        }
        else {
            echo "이미지 파일이 아닙니다.";
            exit;
        }
    }







    $sql = "insert into product(category,start_date,end_date,detail,member_id,member_phone,member_email,member_name,place,price,maker,make_year,model)
        VALUE ( '".$_POST['category']."','".$_POST['startDate']."','".$_POST['endDate']."','".$_POST['detail']."','".$id."','".$phone."','".$email
        ."','".$name."','".$_POST['adress']."','".$_POST['price']."','".$_POST['maker']."','".$_POST['makeDate']."','".$_POST['model'].");";
    echo $sql;
?>