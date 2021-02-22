<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>

<?php confirm_Login(); ?>
  

<!DOCTYPE html>
<html>
    <head>
        <title>Admin Dashboard</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css"> <!-- link bootstrap css-->
        <script src="js/jquery.min.js"></script> <!-- link jquery -->
        <script src="js/bootstrap.min.js"></script> <!-- link bootrasp js -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"> <!-- font awesome -->

        <link rel="stylesheet" href="css/adminstyles.css"> <!-- link custom css -->
    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#"> <img src="images/mylogo2.png" alt="logo" width="200"> </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> <!-- Toggler -->

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto navBarItems" style="font-size: 20px;">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="Blog.php">Blog</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#">Contact</a>
                    </li><li class="nav-item ">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                </ul>

                <form class="form-inline my-2 my-lg-0" action="Blog.php">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="Search">
                    <button class="btn btn-primary my-2 my-sm-0" type="submit" name="SearchButton">Search</button>
                </form>
            </div> <!-- ID: navbarSupportedContent -->
        </nav>
        <div style="background-color: #122173; height: 10px;"></div>

        <div class="container-fluid">
        	<div class="row">
        		<div class="col-md-3 col-xl-2 sideBar">
                    <br><br>
        			<!-- <h1 style="color: #FFD700;">Hey!</h1> -->
        			<ul  class="nav nav-pills flex-column side_menu">
        				<li class="nav-item active"><a href="dashboard.php" class="nav-link"><i class="fas fa-th"></i>&nbsp; Dashboard</a></li>
        				<li class="nav-item"><a href="addNewPost.php" class="nav-link"><i class="fas fa-list-alt"></i>&nbsp; Add New Post</a></li>
        				<li class="nav-item"><a href="categories.php" class="nav-link"><i class="fas fa-tags"></i>&nbsp; Categories</a></li>
        				<li class="nav-item"><a href="admins.php" class="nav-link"><i class="fas fa-user"></i>&nbsp; Manage Admins</a></li>
        				<li class="nav-item">
                            <a href="comments.php" class="nav-link"><i class="fas fa-comment"></i>&nbsp; Comments
                                <!-- For Total Non-Approved post count -->
                                <?php
                                        $Connection;
                                        $QueryTotalUnApproved = "SELECT COUNT(*) AS nappr FROM comments WHERE status='OFF'";
                                        $ExecuteTotalUnApproved = mysqli_query($Connection, $QueryTotalUnApproved);
                                        
                                        $Value =mysqli_fetch_array($ExecuteTotalUnApproved);

                                        $rows = $Value['nappr'];

                                        if ($rows > 0) {

                                        
                                    ?>
                                    <span class="float-right badge badge-warning"><?php echo $rows;?></span>
                                <?php } ?> <!-- For Total Non-Approved post count -->
                            </a>
                        </li>
        				<li class="nav-item"><a href="Blog.php?Page=1" class="nav-link" target="_blank"><i class="fas fa-rss-square"></i>&nbsp; Live Blog</a></li>
        				<li class="nav-item"><a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i>&nbsp; Logout</a></li>
        			</ul>
        		</div> <!-- sideBar -->
        		<div class="col-md-9 col-xl-10 mainBar"><!-- Main Area -->
                    <div><?php echo Message(); echo SuccessMessage(); ?> </div>

        			<h1>Admin Dashboard</h1>

                    <div>
                        <table class="table table-striped table-hover table-responsive table-bordered">
                            <tr class="table-primary">
                                <th>No</th>
                                <th>Post Title</th>
                                <th>Date & Time</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Banner</th>
                                <th>Comments</th>
                                <th></th>
                                <th></th>
                                <th>Details</th>
                            </tr>
                            <?php 
                            global $Connection;

                            $viewQuery = "SELECT * FROM admin_panel ORDER BY id desc";
                            $Execute = mysqli_query($Connection, $viewQuery);

                            $SrNo = 0; /*start the number at 0 then increase*/
                            while ($DataRows = mysqli_fetch_array($Execute)) {
                                $PostId = $DataRows["id"];
                                $DateTime = $DataRows["datetime"];
                                $Title = $DataRows["title"];
                                $Category = $DataRows["category"];
                                $Admin = $DataRows["author"];
                                $Image = $DataRows["image"];
                                $Post = $DataRows["post"];
                                $SrNo++; /*increament*/
                            
                            ?>
                            <tr>
                                <td> <?php echo $SrNo; ?> </td> <!-- echo SrNo here| Not PostID -->
                                <td style="color: blue;"> 
                                    <?php 
                                        if (strlen($Title) > 20) {
                                            $Title = substr($Title, 0, 20).'..';
                                        }
                                        echo $Title; 
                                    ?> 
                                </td>
                                <td> 
                                    <?php
                                        if (strlen($DateTime) > 16) {
                                            $DateTime = substr($DateTime, 0, 16).'..';
                                        } 
                                        echo $DateTime; 
                                    ?> 
                                </td>
                                <td>
                                    <?php
                                        if (strlen($Admin) > 12) {
                                            $Admin = substr($Admin, 0, 12).'..';
                                        }
                                        echo $Admin; 
                                    ?> 
                                </td>
                                <td>
                                    <?php
                                        if (strlen($Category) > 8) {
                                            $Category = substr($Category, 0, 8).'..';
                                        } 
                                        echo $Category; 
                                    ?> 
                                </td>
                                <td> <img width="170px" height="100px" src="Upload/<?php echo $Image; ?> "></td>
                                <td>
                                    <!-- For Approved post count -->
                                    <?php
                                        $Connection;
                                        $QueryApproved = "SELECT COUNT(*) AS appr FROM comments WHERE admin_panel_id='$PostId' AND status='ON'";
                                        $ExecuteApproved = mysqli_query($Connection, $QueryApproved);
                                        
                                        $Value =mysqli_fetch_array($ExecuteApproved);

                                        $rows = $Value['appr'];

                                        if ($rows > 0) {

                                        
                                    ?>
                                    <span class="float-right badge badge-success"><?php echo $rows;?></span>
                                <?php } ?> <!-- For Approved post count -->

                                <!-- For Non-Approved post count -->
                                <?php
                                        $Connection;
                                        $QueryUnApproved = "SELECT COUNT(*) AS nappr FROM comments WHERE admin_panel_id='$PostId' AND status='OFF'";
                                        $ExecuteUnApproved = mysqli_query($Connection, $QueryUnApproved);
                                        
                                        $Value =mysqli_fetch_array($ExecuteUnApproved);

                                        $rows = $Value['nappr'];

                                        if ($rows > 0) {

                                        
                                    ?>
                                    <span class="float-left badge badge-danger"><?php echo $rows;?></span>
                                <?php } ?> <!-- For Non-Approved post count -->
                                    
                                </td> <!-- Comments -->
                                <td>
                                    <a href="editPost.php?Edit=<?php echo $PostId; ?>">
                                        <span class="btn btn-warning">Edit</span>
                                    </a>
                                </td>
                                <th>    
                                    <a href="deletePost.php?Delete=<?php echo $PostId; ?>">
                                        <span class="btn btn-danger">Delete</span>
                                    </a>
                                </td>
                                <td> 
                                    <a target="_blank" href="fullPost.php?id=<?php echo $PostId; ?>">
                                        <span class="btn btn-primary">Live Preview</span>
                                    </a> 
                                </td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                
        		</div> <!-- Main Area Ends -->
        	</div> <!-- row -->
        </div> <!-- container-fluid -->

        <?php include("include/Footer.php"); ?> <!-- include footer -->
    </body>
</html>
