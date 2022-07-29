<?php
    // DB CONNECTION
    require_once "dbcon.php";

    // GET DOCS INFO
    $docs_id = $_POST["docs_id"];
    $title = $_POST["title"];
    $detail = $_POST["detail"];
    $price = $_POST["price"];

    // CHECK FORMAT & GET DOCS FILE
    $fileDir = $_FILES['pdfFile']['tmp_name'];
    $fileTypeExt = explode(".",$_FILES['pdfFile']['name']);
    $fileType = $fileTypeExt[1];
    switch($fileType){
        case 'txt':
        case 'ppt':
        case 'pptx':
        case 'pdf':
            break;
 
        default:
        echo "<script>alert(\"txt, ppt, pptx, pdf파일 외에는 입력이 불가합니다.\");";
        echo "history.go(-1);</script>";
            break;
    }

    // DELETE USER'S PRIOR DOC
    // DELETE FILE FROM SERVER STORAGE
    $docs_link_query = "SELECT * FROM file where s_id = {'$docs_id'}";
    $result = mysqli_query($conn,$docs_link_query);
    if($result){
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $docsArray = explode(".",$row['link']);
            $docsMask = $docsArray[2];
            array_map('unlink', glob("C:/xampp/htdocs/osef/uploadFile/*".$docsMask));
        }
    }
    // DELETE FILE FROM DB
    $delete_link_query = "DELETE FROM file WHERE s_id = {'$docs_id'}";
    mysqli_query($conn,$delete_link_query);
   
    // SAVE DOCS INTO SERVER LOCAL STORAGE
    $fileDir = $_FILES['pdfFile']['tmp_name'];
    $filename = $_FILES['pdfFile']['name'];
    $splitFilename = explode(".",$filename);    
    $filename = "";
    for($j=0;$j<count($splitFilename)-1;$j++){
        $filename .= $splitFilename[$j];
    }
    $filename .= $docs_id.".".$splitFilename[count($splitFilename)-1];
    $resFile = "./uploadFile/".$filename;        
    $docsUpdate = move_uploaded_file($fileDir, $resFile);

    // UPDATE DOCS PATH
    $insert_docs_query = "INSERT INTO file(s_id,link) VALUE ('$docs_id','$resFile');";
    $insert_docs_result = mysqli_query($conn, $insert_docs_query);
    // UPDATE QUERY
    $update_product_query = "UPDATE sell_info SET title='$title',detail='$detail',price='$price' WHERE id='$docs_id'";
    $update_product_result = mysqli_query($conn, $update_product_query);

    // QUERY VERIFICATION
    if($insert_docs_result != NULL && $update_product_result != NULL){ // UPDATE SUCCESS
        echo '<script type="text/javascript">';
        echo 'alert("문서 정보 수정 완료!!");';
        echo 'window.location.href = "member-docs-info.php";';
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
        exit();
    }
?>