<?php
include 'conn/conn.php';
session_start();
if(!empty($_SESSION))
{
    session_regenerate_id(TRUE);
}
if(empty($_SESSION))
{
    header('Location: '."/admin/login.html");
    
}
//$list_id=mysqli_real_escape_string($conn,$_POST["list_id"]);

$list_id=$_POST["list_id"];

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connectionid
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
foreach ($list_id as $id)
{
    $id_q=mysqli_real_escape_string($conn,$id);
    
    //$sql = "select * FROM spider where id=".$id_q;
    $datetime=date("Y-m-d G:i:s");
    $sql="insert into  product (title, titleimg,price,content,topimgs,topimgm,topimgb,url,categoryid,spiderid,store,date) select title,img,price,content,topimgs,topimgm,topimgb,url,categoryid,id,store, '".$datetime."' from spider where id=".$id_q;
    $result = $conn->query($sql);
    
   
     //  $sql = "insert into  product (title,titleimg,price) values ('".$title."','".$titleimg."','".$price."')";
    $result = $conn->query($sql);
    $sql = "delete FROM spider where id=".$id_q;
    $result = $conn->query($sql);
        
    
   
    
    
    
    
  
   

}
echo "1";   
 
$conn->close();  
    ?>