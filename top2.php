<html>
<head>
</head>
<body>
<?php
session_start();
if(!empty($_SESSION))
{
    session_regenerate_id(TRUE);
}


//验证安全性
$ckuseragent=@md5($_SERVER['HTTP_ACCEPT_CHARSET'].$_SERVER['HTTP_ACCEPT_ENCODING'].$_SERVER['HTTP_ACCEPT_LANGUAGE'].$_SERVER['HTTP_USER_AGENT']);
if(empty($_SESSION))
{
$_SESSION['KEY']=$ckuseragent;

}
else if($_SESSION['KEY']!=$ckuseragent)
{
$_SESSION=array();

session_destroy();


}

?>
<a href="exit.php">注销</a>
</body>
</html>