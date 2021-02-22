<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php
if (isset($_GET["id"])) {
	$Connection;

	$idFromURL = $_GET["id"];

	$Query = "UPDATE comments SET status='OFF' WHERE id='$idFromURL'";
	$Execute = mysqli_query($Connection, $Query);

	if ($Execute) {
		$_SESSION["SuccessMessage"] = "Comment Dis-approved successfully!";
        Redirect_to("comments.php");
	} else {
        $_SESSION["ErrorMessage"] = "Something went wrong. Try again.";
        Redirect_to("comments.php");
    }
}  
?>