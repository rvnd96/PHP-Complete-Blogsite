<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>

<?php confirm_Login(); ?>
  

<!DOCTYPE html>
<html>
    <head>
        <title>Comments Dashboard</title>
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
        			<ul  class="nav nav-pills flex-column side_menu">
        				<li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="fas fa-th"></i>&nbsp; Dashboard</a></li>
        				<li class="nav-item"><a href="addNewPost.php" class="nav-link"><i class="fas fa-list-alt"></i>&nbsp; Add New Post</a></li>
        				<li class="nav-item"><a href="categories.php" class="nav-link"><i class="fas fa-tags"></i>&nbsp; Categories</a></li>
        				<li class="nav-item"><a href="admins.php" class="nav-link"><i class="fas fa-user"></i>&nbsp; Manage Admins</a></li>
        				<li class="nav-item active">
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

                    <!-- Un Approved Comments -->
        			<h1>Un-Approved Comments</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <tr class="table-primary">
                                <th>No.</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Comment</th>
                                <th>Approve</th>
                                <th>Delete</th>
                                <th>Details</th>
                            </tr>
                            <?php
                             $Connection;
                             $Query = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
                             $Execute = mysqli_query($Connection, $Query);
                             $SrNo=0;
                             while ($DataRows = mysqli_fetch_array($Execute)) {
                                $CommentId = $DataRows['id'];
                                $DateTimeOfComment = $DataRows['datetime'];
                                $PersonName = $DataRows['name'];
                                $PersonComment = $DataRows['comment'];
                                $CommentPostId = $DataRows['admin_panel_id'];
                                $SrNo++;
                            /* if (strlen($PersonComment) > 18) {
                                $PersonComment = substr($PersonComment, 0, 18).'...';
                             }*/
                             if (strlen($PersonName) > 10) {
                                $PersonName = substr($PersonName, 0, 10).'..';
                             }
                             if (strlen($DateTimeOfComment) > 20) {
                                $DateTimeOfComment = substr($DateTimeOfComment, 0, 20).'..';
                             }

                            ?>
                            <tr>
                                <td> <?php echo $SrNo; ?> </td>
                                <td style="color: blue;"> <?php echo $PersonName; ?> </td>
                                <td> <?php echo $DateTimeOfComment; ?> </td>
                                <td class="w-25"> <?php echo $PersonComment; ?> </td>
                                <td><a href="approveComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-success">Approve</span></a></td>
                                <td><a href="deleteComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
                                <td><a href="fullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank" ><span class="btn btn-primary">Live Preview</span></a></td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div> <!-- Un Approved Comments -->

                    <!-- Approved Comments -->
                    <h1>Approved Comments</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <tr class="table-success">
                                <th>No.</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Comment</th>
                                <th>Approved By</th>
                                <th>Un-Approve</th>
                                <th>Delete</th>
                                <th>Details</th>
                            </tr>
                            <?php
                             $Connection;
                             $Query = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
                             $Execute = mysqli_query($Connection, $Query);
                             $Admin = "Ravindu Madushan";
                             $SrNo=0;
                             while ($DataRows = mysqli_fetch_array($Execute)) {
                                $CommentId = $DataRows['id'];
                                $DateTimeOfComment = $DataRows['datetime'];
                                $PersonName = $DataRows['name'];
                                $PersonComment = $DataRows['comment'];
                                $ApprovedBy = $DataRows['approvedby'];
                                $CommentPostId = $DataRows['admin_panel_id'];
                                $SrNo++;
                            /*if (strlen($PersonComment) > 18) {
                                $PersonComment = substr($PersonComment, 0, 18).'...';
                             }*/
                             if (strlen($PersonName) > 10) {
                                $PersonName = substr($PersonName, 0, 10).'..';
                             }
                             if (strlen($ApprovedBy) > 10) {
                                $ApprovedBy = substr($ApprovedBy, 0, 10).'..';
                             }
                             /*if (strlen($DateTimeOfComment) > 20) {
                                $DateTimeOfComment = substr($DateTimeOfComment, 0, 20).'..';
                             }*/
                             
                            ?>
                            <tr>
                                <td> <?php echo $SrNo; ?> </td>
                                <td style="color: green;"> <?php echo $PersonName; ?> </td>
                                <td> <?php echo htmlentities($DateTimeOfComment); ?> </td>
                                <td class="w-25"> <?php echo htmlentities($PersonComment); ?> </td>
                                <td > <?php echo htmlentities($ApprovedBy); ?> </td>
                                <td><a href="disApproveComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-warning">Dis-Approve</span></a></td>
                                <td><a href="deleteComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
                                <td><a href="fullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div> <!-- Approved Comments -->
        		</div> <!-- Main Area Ends -->
        	</div> <!-- row -->
        </div> <!-- container-fluid -->

        <?php include("include/Footer.php"); ?> <!-- include footer -->
    </body>
</html>
