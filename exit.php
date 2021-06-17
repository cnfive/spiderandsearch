<?php
//$refer=$_SERVER['HTTP_REFERER']; 
session_start();
if(!empty($_SESSION["name"]))
{
  session_unset();
  session_destroy();

    
  header('Location: '."login.html");
}
?>