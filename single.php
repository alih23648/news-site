<?php include 'header.php'; ?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                  <!-- post-container -->
                    <div class="post-container">

                        <?php
                        include_once "config.php";

                        // $page=$_GET['page'];
                        if (isset($_GET['page'])){
                            $page=$_GET['page'];
                        }$post_id= $_GET['id'];
                        $sql ="select * from `post` `p`
                    left join `category` `c` ON p.category=c.category_id
                    left join `user` `u` ON p.author=u.user_id
                        where p.post_id={$post_id}";
                   $result=mysqli_query($conn, $sql) or die("query failed");

                        if(mysqli_num_rows($result)>0){

                            while($row=mysqli_fetch_assoc($result)){
                        ?>

                        <div class="post-content single-post">
                            <h3><?php echo $row['title'];?></h3>
                            <div class="post-information">
                                <span>
                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                    <a href='category.php?cid=<?php echo $row['category'];?>'> <?php echo $row['category_name'];?></a>
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
                            <img class="single-feature-image" src="admin/upload/<?php echo $row['post_img'];?>" alt=""/>
                            <p class="description">

                                <?php echo html_entity_decode($row['description'],ENT_HTML5);?></p>


                        </div>
                         <?php
                        }

                        }

                        ?>
                    </div>
                    <!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
