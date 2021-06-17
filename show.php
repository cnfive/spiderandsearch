<?php
include 'conn/conn.php';
include 'top.php'; 

 
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
$id=mysqli_real_escape_string($conn,$_GET["id"]);
// Check connectionid
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
 
$sql = "SELECT * FROM spider where id=".$id;
$result = $conn->query($sql);
 
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        echo  htmlspecialchars_decode($row["title"]). "<br>";
        echo  "<img src=".htmlspecialchars_decode($row["img"])."><br>";
        echo  htmlspecialchars_decode($row["price"]). "<br>";
        echo  htmlspecialchars_decode($row["topimgs"]). "<br>";
        echo  htmlspecialchars_decode($row["content"]). "<br>";
    }
} else {
    echo "0 结果";
}
$conn->close();
?>