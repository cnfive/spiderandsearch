<html>
<head>
</head>
    
<body>
   <ul><li> <form action="s.php"><input type="text" name="q"> <input type="submit" value="搜索"></form></li>
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

?>
<li>
    <?php echo $_SESSION["name"]  ?>
    <a href="admin/exit.php">注销</a></li></ul>
</body>
</html>