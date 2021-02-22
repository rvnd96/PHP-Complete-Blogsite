<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>

<?php confirm_Login(); ?>

<?php  
if(isset($_POST['Submit'])) {
    $Username = mysqli_real_escape_string($Connection, $_POST["Username"]);
    $Password = mysqli_real_escape_string($Connection, $_POST["Password"]);
    $ConfirmPassword = mysqli_real_escape_string($Connection, $_POST["ConfirmPassword"]);

    date_default_timezone_set("Asia/Colombo");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
    $DateTime;
    $Admin = $_SESSION["Username"];
    if(empty($Username) || empty($Password) || empty($ConfirmPassword)) {
        $_SESSION["ErrorMessage"] = "All fields must be filled out.";
        Redirect_to("admins.php");
    } elseif (strlen($Password) < 4) {
        $_SESSION["ErrorMessage"] = "Password must be at least 4 characters.";
        Redirect_to("admins.php");
    }elseif ($Password !== $ConfirmPassword) {
        $_SESSION["ErrorMessage"] = "Passwords must be matched!";
        Redirect_to("admins.php");
    } else { /*getting the DB connection and insert into the database*/
        global $Connection;

        $insertQuery = "INSERT INTO registration(datetime, username, password, addedby) VALUES ('$DateTime', '$Username', '$Password', '$Admin')";
        $Execute = mysqli_query($Connection, $insertQuery);

        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Admin added successfully!";
            Redirect_to("admins.php");
        } else {
            $_SESSION["ErrorMessage"] = "Admin not added.";
            Redirect_to("admins.php");
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin</title>
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
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="SearchButton">Search</button>
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
        				<li class="nav-item active"><a href="admins.php" class="nav-link"><i class="fas fa-user"></i>&nbsp; Manage Admins</a></li>
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
        		<div class="col-md-9 col-xl-10 mainBar">
        			<h1>Manage Admin Access</h1>
                    <?php echo Message(); echo SuccessMessage(); ?>
                    <div>
                        <form action="admins.php" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <label for="username"><span class="fieldInfo">Username:</span></label>
                                    <input class="form-control" type="text" name="Username" id="username" placeholder="User Name">
                                </div>
                                <div class="form-group">
                                    <label for="password"><span class="fieldInfo">Password:</span></label>
                                    <input class="form-control" type="password" name="Password" id="password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="confirmpassword"><span class="fieldInfo">Confirm Password:</span></label>
                                    <input class="form-control" type="password" name="ConfirmPassword" id="confirmpassword" placeholder="Confirm Password">
                                </div>
                                <br>
                                <input class="btn btn-primary btn-block" type="submit" name="Submit" value="Add New Admin">
                                <br>
                            </fieldset>
                        </form>
                    </div>
                    <div class="table table-responsive">
                        <table class="table table-hover table-active table-striped">
                            <tr class="table-success">
                                <th>No.</th>
                                <th>Date & Time</th>
                                <th>Admin User Name</th>
                                <th>Added by</th>
                                <th>Action</th>
                            </tr>
                             <?php  
                                global $Connection;

                                $viewQuery = "SELECT * FROM registration ORDER BY id desc";
                                $Execute = mysqli_query($Connection, $viewQuery);

                                $SrNo = 0; /*start the number at 0 then increase*/
                                while ($DataRows = mysqli_fetch_array($Execute)) {
                                    $Id = $DataRows["id"];
                                    $DateTime = $DataRows["datetime"];
                                    $Username = $DataRows["username"];
                                    $AddedBy = $DataRows["addedby"];
                                    $SrNo++;
                             ?>
                             <tr>
                                 <td> <?php echo $SrNo;  ?> </td>
                                 <td> <?php echo $DateTime;  ?> </td>
                                 <td> <?php echo $Username;  ?> </td>
                                 <td> <?php echo $AddedBy;  ?> </td>
                                 <td> <a href="deleteAdmin.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a> </td>
                             </tr>
                         <?php } ?>
                        </table>
                    </div>
        		</div> <!-- mainBar -->
        	</div> <!-- row -->
        </div> <!-- container-fluid -->

        <?php include("include/Footer.php"); ?> <!-- include footer -->
    </body>
</html>
