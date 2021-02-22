<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>

<?php  
if(isset($_POST['Submit'])) {
    $Name = mysqli_real_escape_string($Connection, $_POST["Name"]);
    $Email = mysqli_real_escape_string($Connection, $_POST["Email"]);
    $Comment = mysqli_real_escape_string($Connection, $_POST["Comment"]);

    date_default_timezone_set("Asia/Colombo");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
    $DateTime;
    $PostId = $_GET['id'];
    /*$Admin = "Ravindu Madushan";
    $Image = $_FILES["Image"]["name"];
    $Target = "Upload/".basename($_FILES["Image"]["name"]);*/

    if(empty($Name) || empty($Email) || empty($Comment)) {
        $_SESSION["ErrorMessage"] = "All fileds are required.";

    } elseif (strlen($Comment) > 500) {
        $_SESSION["ErrorMessage"] = "Only 500 characters are allowed";

    } else { /*getting the DB connection and insert into the database*/
        global $Connection;
        $PostIDFromURL = $_GET["id"];
        $Query = "INSERT INTO  comments (datetime, name, email, comment, approvedby, status, admin_panel_id) 
                VALUES ('$DateTime', '$Name', '$Email', '$Comment', 'Pending', 'OFF', '$PostIDFromURL')";
        $Execute = mysqli_query($Connection, $Query);

        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Comment submitted successfully!";
            Redirect_to("fullPost.php?id=$PostId");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong. Comment not added. Try again.";
            Redirect_to("fullPost.php?id=$PostId");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Full Blog Post</title>

	<link rel="stylesheet" href="css/bootstrap.min.css"> <!-- link bootstrap css-->
    <script src="js/jquery.min.js"></script> <!-- link jquery -->
    <script src="js/bootstrap.min.js"></script> <!-- link bootrasp js -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"> <!-- font awesome -->

    <link rel="stylesheet" href="css/adminstyles.css"> <!-- link custom css -->
    <link rel="stylesheet" href="css/publicstyles.css"> <!-- link custom css -->

    <style>
        .comment-info {
            color: #365899;
            font-size: 1.1em;
            font-weight: bold;
            padding-top: 10px;
        }
        .comment {
            margin-top: -2px;
            padding-bottom: 10px;
            font-size: 1.1em;
        }
    </style>
    
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

    <div class="container">
    	<div class="blog-header">
    		<h1>The Complete Responsive CMS Blog</h1>
    		<p class="lead">The complete blog using PHP by Ravindu Madushan.</p>
    	</div> <!-- blog-header -->
        <?php echo Message(); echo SuccessMessage(); ?> <!-- Session Message -->
    	<div class="row">
    		<div class="col-sm-8">
    			<?php  
	    			global $Connection;

	    			if (isset($_GET["SearchButton"])) { /*Search */
	    				$Search = $_GET["Search"];
	    				$viewQuery = "SELECT * FROM admin_panel WHERE 
	    							 datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%' ORDER BY id desc";
	    			} else {
	    				/*Full Post*/
	    				$PostIdFromURL = $_GET['id'];

		                $viewQuery = "SELECT * FROM admin_panel WHERE id = '$PostIdFromURL' ORDER BY id desc";}

		                $Execute = mysqli_query($Connection, $viewQuery);

		                while ($DataRows = mysqli_fetch_array($Execute)) {
		                    $PostId = $DataRows["id"];
		                    $DateTime = $DataRows["datetime"];
		                    $Title = $DataRows["title"];
		                    $Category = $DataRows["category"];
		                    $Admin = $DataRows["author"];
		                    $Image = $DataRows["image"];
		                    $Post = $DataRows["post"];
		                			?>
    			<div class="blogpost img-thumbnail">
    				<img class="figure-img" width="100%" src="Upload/<?php echo $Image; ?>" alt="thumbnail">
    				<div class="figure-caption">
    					<h1 id="heading"><?php echo htmlentities($Title); ?></h1>
    					<p class="description">Category: <?php echo htmlentities($Category); ?> | Published on: <?php echo htmlentities($DateTime); ?></p>
    					<p class="post">
    						<?php
    							/*if (strlen($Post) > 150) {
    								$Post = substr($Post, 0, 150).'...';
    							}*/
    							echo nl2br($Post); 
    						?>
    					</p>
    				</div> <!-- caption -->
    				<a href="Blog.php"><span class="btn btn-outline-success float-right">&laquo; Go Back
    				</span></a>
    			</div> <!-- thumbnail -->
    		<?php } ?>

            <hr>
            <span class="fieldInfo">Public comments:</span> <br> <br>

            <?php  
                $Connection;
                $PostIdForComment = $_GET['id'];
                $ExtractingCommentQuery = "SELECT * FROM comments WHERE admin_panel_id='$PostIdForComment' AND status = 'ON'";
                $Execute = mysqli_query($Connection, $ExtractingCommentQuery);

                while ($DataRows = mysqli_fetch_array($Execute)) {
                    $CommentDate = $DataRows['datetime'];
                    $CommenterName = $DataRows['name'];
                    $CommentByUser = $DataRows['comment'];
                
            ?>
            <div style="background-color: #f4f4f4">
                <img class="float-left" src="images/comment.png" width="100" height="100" style="margin-left: 10px; margin-top: 10px; ">
                <p class="comment-info" style="margin-left: 120px;"> <?php echo $CommenterName; ?> </p>
                <p class="description" style="margin-left: 120px;"> <?php echo $CommentDate; ?> </p>
                <p class="comment" style="margin-left: 120px;"> <?php echo nl2br($CommentByUser); ?> </p>
            </div>
            <hr>
        <?php } ?>

            <span class="fieldInfo"><u>Add a public comment:</u></span> <br> <br>

            <!-- Adding Comment Section Form -->
            <div>
                <form action="fullPost.php?id=<?php echo $PostId; ?>" method="POST" enctype="multipart/form-data">
                    <fieldset>

                        <div class="form-group">
                            <label for="name"><span class="fieldInfo">Name:</span></label>
                            <input class="form-control" type="text" name="Name" id="name" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <label for="email"><span class="fieldInfo">Email:</span></label>
                            <input class="form-control" type="email" name="Email" id="email" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label for="commentarea"><span class="fieldInfo">Comment:</span></label>
                            <textarea name="Comment" id="commentarea" class="form-control" placeholder="Your Comment"></textarea>
                        </div>

                        <br>
                        <input class="btn btn-primary" type="submit" name="Submit" value="Submit Your Comment">
                        <br><br>
                        
                    </fieldset>
                </form>
            </div>
            <!-- Adding Comment Section Form | End -->
    		</div> <!-- main bar -->

    		<!-- side bar Starts-->
            <div class="offset-1 col-sm-3">
                <h2>About me</h2>
                <img class="myimg img-fluid rounded-circle " src="images/myself.jpeg" alt="about me">
                <p>I am graduated from Sri Lanka Institute of Information Technology (SLIIT) with a Bsc degree in Information Technology Specilized in Information Technology.
                I am currently practicing as Full-Stack web developer. This is my biggest PHP project so far. </p>

                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <h4 class="card-title card-danger">Category</h4>
                    </div>
                    <div class="card-body bg-light">
                        <?php
                        $Connection;

                        $ViewQuery = "SELECT * FROM category ORDER BY id desc";
                        $Execute = mysqli_query($Connection, $ViewQuery);

                        while ($DataRows = mysqli_fetch_array($Execute)) {
                            $Id = $DataRows['id'];
                            $Category = $DataRows['name'];
                        ?>
                        <a href="Blog.php?Category=<?php echo $Category; ?>">
                            <span id="heading"> <?php echo $Category. "<br>"; ?> </span>
                        </a>
                    <?php } ?>
                    </div>
                    <div class="card-footer bg-secondary">
                        
                    </div>
                </div> <!-- card for categories -->
                <br>
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <h4 class="card-title card-danger">Recent Posts</h4>
                    </div>
                    <div class="card-body bg-light">
                        <?php
                        $Connection;
                        $viewQuery = "SELECT * FROM admin_panel ORDER BY id desc LIMIT 0,4";  
                        $Execute = mysqli_query($Connection, $viewQuery);

                        while ($DataRows = mysqli_fetch_array($Execute)) {
                            $Id = $DataRows['id'];
                            $Title = $DataRows['title'];
                            $DateTime = $DataRows['datetime'];
                            $Image = $DataRows['image'];
                            if (strlen($DateTime) > 11) {
                                $DateTime = substr($DateTime, 0,11);
                            }
                        ?>
                        <div>
                            <img class="float-left" style="margin-top: 10px; margin-left: 10px;" width="70" height="70" src="Upload/<?php echo htmlentities($Image); ?>" alt="">
                            <a href="fullPost.php?id=<?php echo $Id; ?>"><p  id="heading"  style="margin-left: 90px;"><?php echo htmlentities($Title); ?></p></a>
                            <p class="description" style="margin-left: 90px;"><?php echo htmlentities($DateTime); ?></p>
                            <hr>
                        </div>
                    <?php } ?>
                    </div>
                    <div class="card-footer bg-secondary">
                        
                    </div>
                </div> <!-- card for recent posts -->
                <br>
            </div> <!-- side bar -->
    	</div> <!-- row -->
    </div> <!-- container -->

    <?php include("include/Footer.php"); ?> <!-- include footer -->
</body>
</html>