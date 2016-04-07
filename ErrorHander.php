<?php 
function handleError($errno, $errstr,$error_file,$error_line) {
      echo "<b>Error:</b> [$errno] $errstr - $error_file:$error_line";
      echo "<br />";
      echo "Terminating PHP Script";
      
      die();
   }
?>
