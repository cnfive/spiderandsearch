<?php
include '../conn/conn.php';
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connectionid
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 


if(!(empty($_POST["uname"])) and !(empty($_POST["upassword"])))
{
  $uname=mysqli_real_escape_string($conn,$_POST["uname"]);
  $password=mysqli_real_escape_string($conn,$_POST["upassword"]);
  $password=md5(sha1($password));

  $sql = "select * from user  where name='".$uname."' and password='".$password."'";
  $result = $conn->query($sql);


  echo $sql;

  echo mysqli_num_rows($result);
  if( mysqli_num_rows($result)>0)
  {
      session_start();
      $_SESSION["name"]=$uname;
      header('Location: '."../index.php");
      
      
  }
  mysqli_free_result($result);
}


mysqli_close($conn);
?>