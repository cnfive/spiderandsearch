<?php
include 'conn/conn.php';
// $id=$_GET["id"];

$refer=$_SERVER['HTTP_REFERER']; 
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connectionid
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
$id=mysqli_real_escape_string($conn,$_GET["id"]);
$sql = "SELECT * FROM spider where id=".$id;
$result = $conn->query($sql);
 
?>
<html>
<head>
<style>
  .ck-editor__editable {
   min-height: 500px;
   }
 </style>   
    
</head>
   <body> <?php include 'top.php'; ?>
    <form method="post" action="editend.php"> 
   
 

<?php
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
    //    echo  $row["title"]. "<br>";
    //    echo  "<img src=".$row["img"]."><br>";
    //    echo  $row["price"]. "<br>";
    //    echo  $row["content"]. "<br>";
       ?>
           <input type="text" name="id" value="<?php echo $id;?>" id="uploadid"   style="display:none;">
        名字: <input type="text" name="title" value="<?php echo $row["title"];?>">
   <br>标题图:<img src="<?php echo htmlspecialchars_decode($row["img"]);  ?>" id="imgtitle">
   <br><input type="hidden"  name="img"  id="imgtitleurl" value="<?php echo htmlspecialchars_decode($row["img"]);  ?>" ><br>
   价格: <input type="text" name="price" value="<?php echo $row["price"];?>"><br>
       <input type="hidden" name="refefrer" value="<?php echo $refer;?>">><br>
 
   橱窗图：<textarea  name="topimgb" id="topimgb" cols="30" rows="10" ><?php echo  $row["topimgb"];?></textarea>
<textarea  name="topimgm" id="topimgm" cols="30" rows="10" ><?php echo  $row["topimgm"];?></textarea>
       <textarea  name="topimgs" id="topimgs" cols="30" rows="10" ><?php echo  $row["topimgs"];?></textarea>
   <br>
   产品描述: <textarea  name="content" id="content" cols="30" rows="10" ><?php echo  $row["content"];?></textarea>
       <br>
<?php 
        }
       
} else {
    echo "0 结果";
}
$conn->close();
?><input type="submit" name="submit" value="Submit"> 
    </form>
<script src="ckeditor/ckeditor.js"></script>
<script src="translations/zh-cn.js"></script>

<script>
var id=document.getElementById("uploadid");
var url=("upload.php?id="+id.value).toString();
var url2=("upload2.php?id="+id.value).toString();
//alert(url);
var theEditor;
    ClassicEditor
    .create( document.querySelector( '#content' ),{
        language:'zh-cn',//需要引入语言文件
        ckfinder: {
            uploadUrl: url,
        }
    })
    .then(function(editor){
        theEditor  = editor;
    }).catch(function(error){
        console.error(error);
});

    ClassicEditor
    .create( document.querySelector( '#topimgs' ),{
        language:'zh-cn',//需要引入语言文件
        ckfinder: {
            uploadUrl: url,
        }
    })
    .then(function(editor){
        theEditor  = editor;
    }).catch(function(error){
        console.error(error);
});
    ClassicEditor
    .create( document.querySelector( '#topimgm' ),{
        language:'zh-cn',//需要引入语言文件
        ckfinder: {
            uploadUrl: url,
        }
    })
    .then(function(editor){
        theEditor  = editor;
    }).catch(function(error){
        console.error(error);
});
    ClassicEditor
    .create( document.querySelector( '#topimgb' ),{
        language:'zh-cn',//需要引入语言文件
        ckfinder: {
            uploadUrl: url,
        }
    })
    .then(function(editor){
        theEditor  = editor;
    }).catch(function(error){
        console.error(error);
});
document.oncontextmenu=function(e){
   var e=e||window.event;
   var tg=e.target||e.srcElement;
   //alert("你点击的标签名称为："+tg.src);
    document.getElementById("imgtitleurl").setAttribute('value',tg.src);
    document.getElementById("imgtitle").setAttribute('src',tg.src)
} 
  
</script>
</body></html>
