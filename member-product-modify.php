<?php
    if(isset($_POST['submit'])){
        // CONNECT DB
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
        $fileNumCount = count($_FILES['imgFile']['name']);
        $imgArray = array();

        // CHECK FORMAT & GET IMG FILE
        for( $i=0; $i<$fileNumCount; $i++){   
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

        // DELETE USER'S PRIOR IMAGES
        if($fileNumCount > 0){
            // DELETE FILE FROM SERVER STORAGE
            $image_link_query = "SELECT * FROM file where p_id =  {'$product_id'}";
            $result = mysqli_query($conn,$image_link_query);
            if($result){
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){    
                        $imgArray = explode(".",$row['link']);
                        $imgMask = $imgArray[2];
                        array_map('unlink', glob("C:/xampp/htdocs/osef/uploadFile/*".$imgMask));
                    }
                }
            }
            // DELETE FILE FROM DB
            $delete_link_query = "DELETE FROM file WHERE p_id = {'$product_id'} ";
            mysqli_query($conn,$delete_link_query);
        }
        
        // SAVE IMG INTO SERVER LOCAL STORAGE
        for( $i = 0; $i<$fileNumCount;$i++){
            $fileDir = $_FILES['imgFile']['tmp_name'][$i]; //경로명포함 파일명
            $filename = $_FILES['imgFile']['name'][$i]; //순수파일명
            //add id end of name
            $splitFilename = explode(".",$filename);      
            $filename = "";
            for($j=0;$j<count($splitFilename)-1;$j++){
                $filename .= $splitFilename[$j];
            }
            $filename .= $product_id.".".$splitFilename[count($splitFilename)-1];
            $resFile = "./uploadFile/".$filename;        
            $imageUpload = move_uploaded_file($fileDir, $resFile);
            array_push($imgArray,$resFile);
        }
        
        // UPDATE IMAGE PATH
        $insert_img_query="insert into file(p_id,link) VALUE ";
        for($i=0;$i<$fileNumCount-1;$i++){
            $insert_img_query.="('".$product_id."','".$imgArray[$i]."'),";        
        }
        $insert_img_query.="('".$product_id."','".$imgArray[$i]."');";
        $insert_img_result = mysqli_query($conn, $insert_img_query);
        // UPDATE INFO
        $update_product_query = "UPDATE product SET model='$model',maker='$maker',category='$category',make_year='$makeDate',start_date='$startDate',end_date='$endDate',place='$address',detail='$detail',price='$price' WHERE id = '$product_id'";
        $update_product_result = mysqli_query($conn, $update_product_query);
        
        // QUERY VERIFICATION
        if($insert_img_result != NULL && $update_product_result != NULL ){
            echo '<script type="text/javascript">';
            echo 'alert("기기 정보 수정이 완료되었습니다.");';
            echo 'window.location.href = "member-product-info.php";';
            echo '</script>';
        }else{ // DB QUERY FAIL
            echo '<script type="text/javascript">';
            echo 'alert("예기치 않은 오류가 발생했습니다. 나중에 다시 시도하세요.");';
            echo 'window.location.reload()";';
            echo '</script>';
            $fp = fopen('database_error_log.txt','w');
            $db_err = mysqli_error($conn);
            fwrite($fp,$db_err);
            fclose($fp);
        }

        // CLOSE CONNECTION
        mysqli_close($conn);
    }
?>