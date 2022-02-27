<?php 
 include_once 'config.php';

 $userid= $_GET['id'];

 $sql="Delete from user where user_id = $userid";
 //exit($sql);
 $result=mysqli_query($conn, $sql);
if($result){
	 header("location:{$hostname}/admin/users.php");
} else{
echo "<p style= 'color:red;'> Data Cannot not delete.</p>";
}
mysqli_close($conn);
  ?>