<?php
session_start();
include_once  "config.php";

if(isset($_FILES['fileToUpload']))
{
    $error= array();
    $file_name=$_FILES['fileToUpload']['name'];
    $file_size=$_FILES['fileToUpload']['size'];
    $file_temp=$_FILES['fileToUpload']['tmp_name'];
    $file_type=$_FILES['fileToUpload']['type'];
    $exp = explode('.',$file_name);
    $file_ext = end($exp);

    $extensions= array("jpeg" ,"jpg", "png");
    if (in_array($file_ext, $extensions)===false){
        $error[]= "this files extensions not allowed, Please choose jpeg, jpg, png.";
}
if ($file_size > 2097152 || $file_size == 0){
    $error[]="File size is 2Mb are lower.";
}
if (empty($error)== true){
 move_uploaded_file($file_temp, "upload/".$file_name);
}else{
    print_r($error);
    die();
}
}
$tittle= mysqli_real_escape_string($conn, $_POST['post_title']);
$description= mysqli_real_escape_string($conn, $_POST['postdesc']);
$category= mysqli_real_escape_string($conn, $_POST['category']);
$date= date("d M, Y");
$autor= $_SESSION['user_id'];

$sql="INSERT into post(title,description,category,post_date,author,post_img)
values('{$tittle}','{$description}','{$category}','{$date}','{$autor}','{$file_name}');";

$sql.="update category set post= post +1 where category_id='{$category}'";

if (mysqli_multi_query($conn, $sql)){
    header("location: {$hostname}/admin/post.php");

}else{
    echo "<div class='alert alert-danger'> Query Filed </div>";
}
?>