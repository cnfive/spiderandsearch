<?php
include '../conn/conn.php';
date_default_timezone_set("PRC"); //设置默认时区

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connectionid
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
//$id=mysqli_real_escape_string($conn,$_GET["id"]);
$name=trim($_POST["uname"]);
$password=md5(sha1(trim($_POST["upassword"])));
$datetime=date("Y-m-d G:i:s");
$sql = "insert into user  (name, password,createdate) values ('".$name."','".$password."','".$datetime."')";
$result = $conn->query($sql);


echo $sql;

echo $result;


?>