<?php
include_once 'config.php';
if(empty($_FILES['new-image']['name'])){
  $file_name=$_POST['old-image'];
}else{
    $error= array();
    $file_name=$_FILES['new-image']['name'];
    $file_size=$_FILES['new-image']['size'];
    $file_temp=$_FILES['new-image']['tmp_name'];
    $file_type=$_FILES['new-image']['type'];
    $file_ext = end(explode('.',$file_name));

    $extensions= array("jpeg" ,"jpg", "png");
    if (in_array($file_ext, $extensions)===false){
        $error[]= "this files extensions not allowed, Please choose jpeg, jpg, png.";
    }
    if ($file_size > 2097152){
        $error[]="File size is 2Mb are lower.";
    }
    if (empty($error)== true){
        move_uploaded_file($file_temp, "upload/".$file_name);
    }else{
        print_r($error);
        die();
    }

}
$sql="Update post set title='{$_POST["post_title"]}' ||
 '',description='{$_POST["postdesc"]}',category='' ||
  '{$_POST["category"]}',post_img='{$file_name}'
where post_id={$_POST['post_id']}";

//die($sql);
$result=mysqli_query($conn, $sql);
if($result){
    header("location:{$hostname}/admin/post.php");
}else{
    echo "query failed";
}