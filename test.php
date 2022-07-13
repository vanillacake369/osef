<?php
    $filename = "asd.eee.mp4";
    $uploadId = "5";
      $splitFilename = explode(".",$filename);      
      $filename = "";
      for($i=0;$i<count($splitFilename)-1;$i++){
          $filename .= $splitFilename[$i];
      }
      $filename .= $uploadId.".".$splitFilename[count($splitFilename)-1];
      echo  $filename;
?>