<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>

<?php confirm_Login(); ?>

<?php  
if(isset($_POST['Submit'])) {
    $Title = mysqli_real_escape_string($Connection, $_POST["Title"]);
    $Category = mysqli_real_escape_string($Connection, $_POST["Category"]);
    $Post = mysqli_real_escape_string($Connection, $_POST["Post"]);

    date_default_timezone_set("Asia/Colombo");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
    $DateTime;
    $Admin = $_SESSION["Username"];
    $Image = $_FILES["Image"]["name"];
    $Target = "Upload/".basename($_FILES["Image"]["name"]);

    if(empty($Title)) {
        $_SESSION["ErrorMessage"] = "Title can't be empty.";
        Redirect_to("addNewPost.php");

    } elseif (strlen($Title) < 2) {
        $_SESSION["ErrorMessage"] = "Title should be al least 2 charactors.";
        Redirect_to("addNewPost.php");

    } else { /*getting the DB connection and insert into the database*/
        global $Connection;
        $EditFromURL = $_GET['Edit'];

        $updateQuery = "UPDATE admin_panel SET datetime='$DateTime', title='$Title', category='$Category', author='$Admin', image='$Image', post='$Post' WHERE id='$EditFromURL' ";
        $Execute = mysqli_query($Connection, $updateQuery);

        move_uploaded_file($_FILES["Image"]["tmp_name"] , $Target);

        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Post Updated successfully!";
            Redirect_to("dashboard.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong. Post not updated. Try again.";
            Redirect_to("dashboard.php");
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Post</title>
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
                    <!-- <h1 style="color: #FFD700;">Hey!</h1> -->
        			<ul  class="nav nav-pills flex-column side_menu">
        				<li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="fas fa-th"></i>&nbsp; Dashboard</a></li>
        				<li class="nav-item active"><a href="addNewPost.php" class="nav-link"><i class="fas fa-list-alt"></i>&nbsp; Add New Post</a></li>
        				<li class="nav-item "><a href="categories.php" class="nav-link"><i class="fas fa-tags"></i>&nbsp; Categories</a></li>
        				<li class="nav-item"><a href="admins.php" class="nav-link"><i class="fas fa-user"></i>&nbsp; Manage Admins</a></li>
        				<li class="nav-item"><a href="comments.php" class="nav-link"><i class="fas fa-comment"></i>&nbsp; Comments</a></li>
        				<li class="nav-item"><a href="Blog.php?Page=1" class="nav-link" target="_blank"><i class="fas fa-rss-square"></i>&nbsp; Live Blog</a></li>
        				<li class="nav-item"><a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i>&nbsp; Logout</a></li>
        			</ul>
        		</div> <!-- sideBar -->
        		<div class="col-md-9 col-xl-10 mainBar">
        			<h1>Update Post</h1>
                    <?php echo Message(); echo SuccessMessage(); ?>
                    <div>
                        <!-- Update -->
                        <?php  
                            $Connection;
                            $SearchQueryParameter = $_GET['Edit'];
                            $getQuery = "SELECT * FROM admin_panel WHERE id='$SearchQueryParameter' ";
                            $ExecuteQuery = mysqli_query($Connection, $getQuery);

                            while ($DataRows = mysqli_fetch_array($ExecuteQuery)) {
                                $TitleToBeUpdated = $DataRows['title'];
                                $CategoryToBeUpdated = $DataRows['category'];
                                $ImageToBeUpdated = $DataRows['image'];
                                $PostToBeUpdated = $DataRows['post'];
                            }
                        ?>
                        <form action="editPost.php?Edit=<?php echo $SearchQueryParameter; ?>" method="POST" enctype="multipart/form-data">
                            <fieldset>

                                <div class="form-group">
                                    <label for="title"><span class="fieldInfo">Title:</span></label>
                                    <input value="<?php echo $TitleToBeUpdated; ?>" class="form-control" type="text" name="Title" id="title" placeholder="Title">
                                </div>

                                <div class="form-group">
                                    <span class="fieldInfo">Existing Category: </span>
                                    <?php echo $CategoryToBeUpdated; ?> <br>
                                    <label for="categoryselect"><span class="fieldInfo">Category:</span></label>
                                    <select class="form-control" name="Category" id="categoryselect">
                                    	<option disabled="disabled"> --select-- </option>
                                    	<?php  
			                                global $Connection;

			                                $viewQuery = "SELECT * FROM category ORDER BY datetime desc";
			                                $Execute = mysqli_query($Connection, $viewQuery);

			                                
			                                while ($DataRows = mysqli_fetch_array($Execute)) {
			                                    $Id = $DataRows["id"];
			                                    $CategoryName = $DataRows["name"];
			                            ?>

			                            <option> <?php echo $CategoryName; ?> </option>
			                        <?php } /*while end*/ ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <span class="fieldInfo">Existing Image: </span>
                                    <img src="Upload/<?php echo $ImageToBeUpdated; ?>" width="170px" height="70px">
                                    <label for="imageselect"><span class="fieldInfo">Select Image:</span></label>
                                    <input type="file" class="form-control" name="Image" id="imageselect">
                                </div>

                                <div class="form-group">
                                    <label for="postarea"><span class="fieldInfo">Post:</span></label>
                                    <textarea  name="Post" id="postarea" class="form-control"><?php echo $PostToBeUpdated; ?></textarea>
                                </div>

                                <br>
                                <input class="btn btn-primary btn-block" type="submit" name="Submit" value="Update Post">
                                <br>
                                
                            </fieldset>
                        </form>
                    </div>
                    <!-- <div class="table table-responsive">
                        <table class="table table-hover table-active table-striped">
                            <tr class="table-primary">
                                <th>No.</th>
                                <th>Date & Time</th>
                                <th>Category Name</th>
                                <th>Creator Name</th>
                            </tr> -->
                             <?php  
                                /*global $Connection;

                                $viewQuery = "SELECT * FROM category ORDER BY datetime desc";
                                $Execute = mysqli_query($Connection, $viewQuery);

                                $SrNo = 0;
                                while ($DataRows = mysqli_fetch_array($Execute)) {
                                    $Id = $DataRows["id"];
                                    $DateTime = $DataRows["datetime"];
                                    $CategoryName = $DataRows["name"];
                                    $CreatorName = $DataRows["creatorname"];
                                    $SrNo++;*/
                             ?>
                             <!-- <tr>
                                 <td> <?php /*echo $SrNo; */ ?> </td>
                                 <td> <?php /*echo $DateTime;  */ ?> </td>
                                 <td> <?php /*echo $CategoryName; */ ?> </td>
                                 <td> <?php /*echo $CreatorName; */ ?> </td>
                             </tr> -->
                         <?php /*} */ ?>
                       <!--  </table>
                    </div> --> <!-- table div -->
        		</div> <!-- mainBar -->
        	</div> <!-- row -->
        </div> <!-- container-fluid -->

        <?php include("include/Footer.php"); ?> <!-- include footer -->
    </body>
</html>
