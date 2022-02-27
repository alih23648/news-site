<?php include "header.php";

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                  <?php
                  include_once "config.php";
                  $limit=6;
                  // $page=$_GET['page'];
                  if (isset($_GET['page'])){
                      $page=$_GET['page'];
                  }else{
                      $page=1;
                  }
                  $offset=($page-1) * $limit;

                  if ($_SESSION['role']=='1'){
                  $sql ="select * from `post` `p`
                    left join `category` `c` ON p.category=c.category_id
                    left join `user` `u` ON p.author=u.user_id 
                    ORDER BY p.post_id DESC limit {$offset}, {$limit} ";
                  }elseif($_SESSION['role']=='0'){
                      $sql ="select * from `post` `p`
                    left join `category` `c` ON p.category=c.category_id
                    left join `user` `u` ON p.author=u.user_id 
                    WHERE p.author={$_SESSION['user_id']}
                    ORDER BY p.post_id DESC limit {$offset}, {$limit} ";


                  }


                  $result=mysqli_query($conn, $sql) or die("Query failed");

                  if(mysqli_num_rows($result)>0){
                  ?>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                      <?php



                      while($row=mysqli_fetch_assoc($result)){

                      ?>
                          <tr>
                              <td class='id'><?php echo $row['post_id']; ?></td>
                              <td><?php echo  $row['title']; ?></td>
                              <td><?php echo  $row['category_name']; ?></td>
                              <td><?php echo  $row['post_date']; ?></td>
                              <td><?php echo  $row[	'username']; ?></td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $row['post_id']; ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $row["post_id"]; ?>&catid=<?php echo $row['category_id'];  ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr> <?php }  ?>
                                                </tbody>
                  </table>
                   <?php }
                  else{
                      echo "<h3> No Record Found.</h3>";
                  }
                       $sql= "select * from post";
                       $result=mysqli_query($conn, $sql);
                       if(mysqli_num_rows($result)>0){
                        $total_record = mysqli_num_rows($result);

                        $total_page=ceil($total_record/$limit);
                       echo "<ul class='pagination admin-pagination'>";
                       if ($page>1) {
                         echo '<li><a href="post.php?page='.($page-1).'" > previos </a>  </li>';
                       }
                          for ($i=1; $i<=$total_page; $i++){
                            if ($i==$page) {
                              $active='active';
                            }
                            else{
                              $active= "";
                            }

                             echo '<li class="'.$active.'"><a href="post.php?page='.$i.'">'.$i.'</a></li>';
                              }
                              if ($total_page>$page) {
                               echo '<li><a href="post.php?page='.($page+1).'" > Next </a>  </li>' ;
                                                          }
                              echo "</ul>";
                       }



                     ?>
              </div>
          </div>
      </div>
  </div>
<?php include_once 'footer.php'; ?>
