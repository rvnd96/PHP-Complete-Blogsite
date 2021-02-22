<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Blog</title>

	<link rel="stylesheet" href="css/bootstrap.min.css"> <!-- link bootstrap css-->
    <script src="js/jquery.min.js"></script> <!-- link jquery -->
    <script src="js/bootstrap.min.js"></script> <!-- link bootrasp js -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"> <!-- font awesome -->

    <link rel="stylesheet" href="css/adminstyles.css"> <!-- link custom css -->
    <link rel="stylesheet" href="css/publicstyles.css"> <!-- link custom css -->
    
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
    	<div class="row">
    		<div class="col-sm-8">
    			<?php  
	    			global $Connection;

	    			if (isset($_GET["SearchButton"])) { /*Search */
	    				$Search = $_GET["Search"];
	    				$viewQuery = "SELECT * FROM admin_panel WHERE 
	    							 datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%' ORDER BY id desc";

	    			} elseif (isset($_GET["Category"])) { /*Side bar category selection*/
                        $Category = $_GET["Category"];
                        $viewQuery = "SELECT * FROM admin_panel WHERE category='$Category' ORDER BY id desc";

                    } elseif (isset($_GET["Page"])) { /*Query when Pagination bar is active. i.e Blog.php?Page=4 */
                        $Page = $_GET["Page"];

                        if ($Page <= 0) {
                            $ShowPostFrom=0;
                        } else {
                            $ShowPostFrom = ($Page*5)-5;
                        }

                        $viewQuery = "SELECT * FROM admin_panel ORDER BY id desc LIMIT $ShowPostFrom,5 ";

                    } else {
                        /*DEFAULT Query for blog*/
		                $viewQuery = "SELECT * FROM admin_panel ORDER BY id desc";}

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
    					<p class="description">Category: <?php echo htmlentities($Category); ?> | Published on: <?php echo htmlentities($DateTime); ?>
                            <!-- For viewing Approved post count -->
                            <?php
                                $Connection;
                                $QueryApproved = "SELECT COUNT(*) AS appr FROM comments WHERE admin_panel_id='$PostId' AND status='ON'";
                                $ExecuteApproved = mysqli_query($Connection, $QueryApproved);
                                
                                $Value =mysqli_fetch_array($ExecuteApproved);

                                $rows = $Value['appr'];

                                if ($rows > 0) {

                                        
                            ?>
                                <span class="float-right badge badge-info">Comments: <?php echo $rows;?></span>
                            <?php } ?> <!-- For Approved post count -->
                        </p>
    					<p class="post">
    						<?php
    							if (strlen($Post) > 150) {
    								$Post = substr($Post, 0, 150).'...';
    							}
    							echo htmlentities($Post); 
    						?>
    					</p>
    				</div> <!-- caption -->
    				<a href="fullPost.php?id=<?php echo $PostId; ?>"><span class="btn btn-outline-info float-right">Read More &rsaquo;&rsaquo;
    				</span></a>
    			</div> <!-- thumbnail -->
    		<?php } ?>

            <!-- Pagination Button Set -->
            <nav>
                <ul class="pagination pagination-lg float-left">
                    <!-- For Forward Button -->
                    <?php
                        if (isset($Page)) {
                            if ($Page>1) {
                    ?>
                        <li class="page-item"><a class="page-link" href="Blog.php?Page=<?php echo $Page-1; ?>"> &laquo; </a></li>
                        <?php
                            } 
                        } 
                        ?><!-- For Forward Button -->
            <?php  
                global $Connection;
                $QueryPagination="SELECT COUNT(*) AS cpp FROM admin_panel";
                $ExucutePagination = mysqli_query($Connection, $QueryPagination);
                $Value =mysqli_fetch_array($ExucutePagination);
                $rows = $Value['cpp'];
                $PostsPagination = $rows/5;
                $PostsPagination = ceil($PostsPagination); /*bring the value to interger, cannot get float value*/

                for ($i=1; $i<=$PostsPagination; $i++) {
                    if (isset($Page)) {
                        if ($i==$Page) {
            ?>
                    <li class="active page-item"><a class="page-link" href="Blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php 
                    } else { ?> 
                        <li class="page-item"><a class="page-link" href="Blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php
                        } /*else*/
                    } /*isset($Page)*/
                } /*for loop*/ 
                        ?>
                        <!-- For Back Button -->
                        <?php
                        if (isset($Page)) {
                            if ($Page+1 <= $PostsPagination) {
                    ?>
                        <li class="page-item"><a class="page-link" href="Blog.php?Page=<?php echo $Page+1; ?>"> &raquo; </a></li>
                        <?php
                            } 
                        } 
                        ?>
                        <!-- For Back Button Ends -->
                </ul>
            </nav>
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
