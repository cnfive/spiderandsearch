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


//清空文件夹函数和清空文件夹后删除空文件夹函数的处理
function deldir($path){
   //如果是目录则继续
   if(is_dir($path)){
    //扫描一个文件夹内的所有文件夹和文件并返回数组
   $p = scandir($path);
   foreach($p as $val){
    //排除目录中的.和..
    if($val !="." && $val !=".."){
     //如果是目录则递归子目录，继续操作
     if(is_dir($path.$val)){
      //子目录中操作删除文件夹和文件
      deldir($path.$val.'/');
      //目录清空后删除空文件夹
      @rmdir($path.$val.'/');
     }else{
      //如果是文件直接删除
      unlink($path.$val);
     }
    }
   }
  }
  }
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connectionid
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
foreach ($list_id as $id)
{
    $id_q=mysqli_real_escape_string($conn,$id);
    
    $sql = "delete FROM spider where id=".$id_q;
    $result = $conn->query($sql);
    //$path="./".$id."/";
    //$uploadDir = dirname(__FILE__).'/images/'.$id."/";
    
    $currDir = __DIR__;
    $newDir = $currDir."\\images\\".$id."\\";
    deldir($newDir);
    $ret = rmdir($newDir);

}
echo "1";   
 
$conn->close();  
    ?>