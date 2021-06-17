<?php
$id=$_GET["id"];
session_start();
if(!empty($_SESSION))
{
    session_regenerate_id(TRUE);
}
if(empty($_SESSION))
{
    header('Location: '."/admin/login.html");
    
}
//返回JSON
if($_POST){
	echo json_encode(upload($_FILES,$id));
}

//上传文件函数
function upload($file,$id){
    //构建上传子目录
    $timeDir = $id;
    //文件存储位置
    $uploadDir = dirname(__FILE__).'/images/'.$timeDir;
    $url =  './images/'.$timeDir."/";
    //定义文件名
    $time = date("Ymd") ."_".date("His") . floor(intval(microtime() )* 100);
    //自动创建目录
    if(!is_dir($uploadDir))
    {
        mkdir($uploadDir,0777,true);
    }
    //原文件名
    $fileName = urldecode($file['upload']['name']);
    //上传临时目录文件名
    $tmpName = $file['upload']['tmp_name'];
    //取文件扩展名jpg,gif,bmp,png
    $path_parts = pathinfo($fileName);
    $ext = $path_parts["extension"];
    $ext = strtolower($ext);//jpg,png,gif,bmp

    //只允许上传图片类型的文件
    if($ext == "jpg"
        || $ext == "jpeg"
        || $ext == "png"
        || $ext == "gif"
        || $ext == "bmp")
    {
        //文件名
        $saveFileName = $time . '.' . $ext;
        //保存路径
        $savePath = $uploadDir . "/" . $saveFileName;

        $mimetype = exif_imagetype($tmpName);
        if ($mimetype == IMAGETYPE_GIF || $mimetype == IMAGETYPE_JPEG || $mimetype == IMAGETYPE_PNG || $mimetype == IMAGETYPE_BMP)
        {     

            //echo "是图片";        //另存为新文件名称
            if (!move_uploaded_file($tmpName,$savePath))
            {
                exit;
            }
        }

        //构建返回数组
        $data = [
            "uploaded" => true,
            "fileName" => $saveFileName,
            "url" => $url.$saveFileName
        ];
    }

    return $data;
}
