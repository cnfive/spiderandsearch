<?php include 'conn/conn.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="30" >
    <style>
<!--
div#buttom{
    width:200px;
    height:100px;
    border:1px solid red;
    
    
}
body table{
    text-align:center;
    margin:0px auto;
}
li{
    
list-style:none;
    float:right;
}
-->

</style>
    <script src="js/jquery.min.js">
</script>
<script>    
$(document).ready(function(){
   var checked = [];
  
   $("#selectAll").click(function(){    
   
         
     
     $("input[name='check']").each(function(){
        $(this).attr("checked",true);   
        
      });
    });
   $("#delete").click(function(){    
   
         
     
     $("input[name='check']:checked").each(function(){
      
       
        checked.push($(this).val());
        
      });
     //  alert(checked)
     $.post("delete.php",
        {
        list_id:checked,
        
        },
    function(data,status){
        alert("数据: \n" + data + "\n状态: " + status);
        $("input[name='check']:checked").each(function(){
      
       
           $(this).parent().parent().remove();
        
      });
    }); 
         
         
    });
 
    
    
     $("#move").click(function(){    
   
         
     
     $("input[name='check']:checked").each(function(){
      
       
        checked.push($(this).val());
        
      });
     //  alert(checked)
     $.post("move.php",
        {
        list_id:checked,
        
        },
    function(data,status){
      //  alert("数据: \n" + data + "\n状态: " + status);
        $("input[name='check']:checked").each(function(){
      
       
           $(this).parent().parent().remove();
        
      });
    }); 
         
         
    });
 
    
    
    
    
    
    
    
    
    
  
});
</script>
    <title>分页</title>
<?php

session_start();
if(!empty($_SESSION))
{
    session_regenerate_id(TRUE);
}
if(empty($_SESSION))
{
    header('Location: '."/admin/login.html");
    
}

//echo  $servername.$username;
//分页的函数
function news($pageNum = 1, $pageSize = 10,$servername, $username,$password,$dbname)
{
    $array = array();
    $coon = mysqli_connect($servername, $username,$password);
    mysqli_select_db($coon, $dbname);
    mysqli_set_charset($coon, "utf8");
    // limit为约束显示多少条信息，后面有两个参数，第一个为从第几个开始，第二个为长度
    $rs = "select * from spider where tag IS NOT NULL order by id desc limit " . (($pageNum - 1) * $pageSize) . "," . $pageSize;
    $r = mysqli_query($coon, $rs);
    while ($obj = mysqli_fetch_object($r)) {
        $array[] = $obj;
    }
    mysqli_close($coon,$dbname);
    return $array;
}
 
//显示总页数的函数
function allNews($servername, $username,$password,$dbname)
{
    $coon = mysqli_connect($servername, $username,$password);
    mysqli_select_db($coon, $dbname);
    mysqli_set_charset($coon, "utf8");
    $rs = "select count(*) num from spider  where tag IS NOT NULL"; //可以显示出总页数
    $r = mysqli_query($coon, $rs);
    $obj = mysqli_fetch_object($r);
    mysqli_close($coon,$dbname);
    return $obj->num;
}
 
    @$allNum = allNews($servername, $username,$password,$dbname);
    @$pageSize = 10; //约定没页显示几条信息
    @$pageNum = empty($_GET["pageNum"])?1:$_GET["pageNum"];
    @$endPage = ceil($allNum/$pageSize); //总页数
    @$array = news($pageNum,$pageSize,$servername, $username,$password,$dbname);
    ?>
</head>
<body>
        <?php include 'top.php'; ?>
<table border="1" style="text-align: center" cellpadding="0">
    <tr>
        <td> </td>
        <td>id</td>
        <td>产品</td>
        <td>图</td>
        <td>店铺</td>
        <td>价格</td> <td>原址</td>
                <td>日期</td>
        <td>编辑</td>
                
    </tr>
    <?php
    foreach($array as $key=>$values){
        echo "<tr>";
  
        echo "<td><input type='checkbox' value='{$values->id}' name='check'></td>";
        echo "<td>{$values->id}</td>";
        echo "<td style='width:250px;'><a href='show.php?id={$values->id}'  target='_blank'>{$values->title}</a></td>";
        echo "<td><img src='{$values->img}'</td>";
        echo "<td>{$values->store}</td>";
        echo "<td>{$values->price}</td>";
        echo "<td><a href='{$values->url}' target='_blank'>原址</a></td>";
        echo "<td>{$values->date2}</td>";
        echo "<td><a href='edit.php?id={$values->id}' target='_self'>编辑</a></td>";
        echo "</tr>";
    }
    ?>
</table>
<div style="margin-top:20px;text-align:center;padding:5px;">
    <a href="?pageNum=1">首页</a>
    <a href="?pageNum=<?php echo $pageNum==1?1:($pageNum-1)?>">上一页</a>
    <a href="?pageNum=<?php echo $pageNum==$endPage?$endPage:($pageNum+1)?>">下一页</a>
    <a href="?pageNum=<?php echo $endPage?>">尾页</a>
 <input type="button" id="delete" value="删除"> <input type="button" id="move" value="移动">
        <input type="button" value="全选" class="btn" id="selectAll"> 


  

</div>
 <div class="bottom"></div>
</body>
</html>