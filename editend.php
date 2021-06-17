<?php
include 'conn/conn.php';
include 'top.php'; 
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connectionid
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 

$id=mysqli_real_escape_string($conn,$_POST["id"]);
$price=htmlspecialchars(mysqli_real_escape_string($conn,$_POST["price"]));
$title=htmlspecialchars(mysqli_real_escape_string($conn,$_POST["title"]));
$content=htmlspecialchars(mysqli_real_escape_string($conn,$_POST["content"])); 
$img=htmlspecialchars(mysqli_real_escape_string($conn,$_POST["img"])); 
$topimgs=htmlspecialchars(mysqli_real_escape_string($conn,$_POST["topimgs"]));
$topimgm=htmlspecialchars(mysqli_real_escape_string($conn,$_POST["topimgm"]));
$topimgb=htmlspecialchars(mysqli_real_escape_string($conn,$_POST["topimgb"]));
$refer=mysqli_real_escape_string($conn,$_POST["refefrer"]);



 
$sql = "UPDATE spider set title='".$title."', img='".$img."', price='".$price."', content='".$content."',topimgs='".$topimgs."',topimgm='".$topimgm."',topimgb='".$topimgb."' where id=".$id;
//print($sql)
$result = $conn->query($sql);
 mysqli_close($conn);
#echo $sql;
header('Location: '.$refer);

#echo "<script>href.location='".$refer."';</script>";     # 返回以前的地方
?>