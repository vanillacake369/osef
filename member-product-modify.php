<?php
    if(isset($_POST['submit'])){
        // DB CONNECTION
        require_once "dbcon.php";

        // GET PRODUCT INFO
        $product_id = $_POST["product_id"];
        $model = $_POST["model"];
        $maker = $_POST["maker"];
        $category = $_POST["category"];
        $makeDate = $_POST["makeDate"];
        $startDate = $_POST["startDate"];
        $endDate = $_POST["endDate"];
        $address = $_POST["address"];
        $detail = $_POST["detail"];
        $price = $_POST["price"];
        // CHECK FORMAT & GET IMG FILE
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
        
        // SAVE IMG
        for( $i = 0; $i<$fileNumCount;$i++){
            $fileDir = $_FILES['imgFile']['tmp_name'][$i]; //경로명포함 파일명
            $filename = $_FILES['imgFile']['name'][$i]; //순수파일명
            //add id end of name
            $splitFilename = explode(".",$filename);      
            $filename = "";
            for($j=0;$j<count($splitFilename)-1;$j++){
                $filename .= $splitFilename[$j];
            }
            $filename .= $uploadId.".".$splitFilename[count($splitFilename)-1];$resFile = "./uploadFile/".$filename;        
            $imageUpload = move_uploaded_file($fileDir, $resFile);
            array_push($imgArray,$resFile);
            if($imageUpload == true){
                echo "파일이 정상적으로 업로드 되었습니다. <br>";
            }else{
                die ("파일 업로드에 실패하였습니다.");
            }        
        }
        
        // UPDATE QUERY
        $update_product_query = "UPDATE product SET model='$model',maker='$maker',category='$category',make_year='$makeDate',start_date='$startDate',end_date='$endDate',place='$address',detail='$detail',price='$price' WHERE id = '$product_id'";
        if($result = mysqli_query($conn, $update_product_query)){ // UPDATE SUCCESS
            echo '<script type="text/javascript">';
            echo 'alert("농기기 정보 수정 완료!!");';
            echo 'window.location.href = "member-product-info.php";';
            echo '</script>';
        }else{ // DB CONNECTION FAIL
            $fp = fopen('database_error_log.txt','w');
            $db_err = mysqli_connect_error();
            fwrite($fp,$db_err);
            fclose($fp);
            exit();
        }
        $sql="insert into file(p_id,link) VALUE ";
        for($i=0;$i<$fileNumCount-1;$i++){
            $sql.="('".$uploadId."','".$imgArray[$i]."'),";        
        }
        $sql.="('".$uploadId."','".$imgArray[$i]."');";
        $conn->query($sql);

    }
?>