<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php

                    if(isset($_GET['aid'])){
                        $auth_id=$_GET['aid'];

                    }
                    $sql1= "select * from post join user 
                    ON post.author =user.user_id
                    where post.author= {$auth_id}";
                    $result1=mysqli_query($conn, $sql1) or die("Query Failed:");
                    $row1=mysqli_fetch_assoc($result1);
                    ?>
                    <h2 class="page-heading"><?php echo $row1['first_name']; ?></h2>
                    <div class="post-content">
                        <?php
                        include_once "config.php";
                        $limit=5;
                        // $page=$_GET['page'];
                        if (isset($_GET['page'])){
                            $page=$_GET['page'];
                        }else{
                            $page=1;
                        }
                        $offset=($page-1) * $limit;

                        $sql ="select * from `post` `p`
                    left join `category` `c` ON p.category=c.category_id
                    left join `user` `u` ON p.author=u.user_id 
                    where p.author={$auth_id}
                    ORDER BY p.post_id ASC limit {$offset}, {$limit} ";





                        $result=mysqli_query($conn, $sql) or die("query failed");

                        if(mysqli_num_rows($result)>0){

                            while($row=mysqli_fetch_assoc($result)){


                                ?>

                                <div class="post-content">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a class="post-img" href="single.php?id=<?php echo $row['post_id'];?>"><img src="admin/upload/<?php echo $row['post_img'];?>" alt=""/></a>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="inner-content clearfix">
                                                <h3><a href='single.php?id=<?php echo $row['post_id'];?>'><?php echo $row['title'];?></a></h3>
                                                <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php?cid=<?php echo $row['category'];?>'><?php echo $row['category_name'];?></a>
                                            </span>
                                                    <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php'><?php echo $row['first_name'];?></a>
                                            </span>
                                                    <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $row['post_date'];?>
                                            </span>
                                                </div>
                                                <p class="description">
                                                    <?php echo substr($row['description'], 0 , 120). "...";?>
                                                </p>
                                                <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id'];?>'>read more</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }

                        }

                        ?>
                        <?php

                        if(mysqli_num_rows($result)>0){
                            $total_record = mysqli_num_rows($result1);

                            $total_page=ceil($total_record/$limit);
                            echo "<ul class='pagination admin-pagination'>";
                            if ($page>1) {
                                echo '<li><a href="index.php?aid='.$auth_id.'&page='.($page-1).'" > previos </a>  </li>';
                            }
                            for ($i=1; $i<=$total_page; $i++){
                                if ($i==$page) {
                                    $active='active';
                                }
                                else{
                                    $active= "";
                                }

                                echo '<li class="'.$active.'"><a href="index.php?aid='.$auth_id.'&page='.$i.'">'.$i.'</a></li>';
                            }
                            if ($total_page>$page) {
                                echo '<li><a href="index.php?aid='.$auth_id.'&page='.($page+1).'" > Next </a>  </li>' ;
                            }
                            echo "</ul>";
                        }


                        ?></div>
                    </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
