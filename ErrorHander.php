<?php 
     function DreamcoilErrorHandler($errno, $errstr,$error_file,$error_line) {
        echo "<b>Error:</b> [$errno] $errstr - $error_file:$error_line";
        echo "<br />";
        echo "Terminating Dreamcoil Framework";
          
        die();
   }
?>
