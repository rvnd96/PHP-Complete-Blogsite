<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php
if (isset($_GET["id"])) {
	$Connection;

	$idFromURL = $_GET["id"];

	$Query = "DELETE FROM category WHERE id='$idFromURL'";
	$Execute = mysqli_query($Connection, $Query);

	if ($Execute) {
		$_SESSION["SuccessMessage"] = "Category Deleted successfully!";
        Redirect_to("categories.php");
	} else {
        $_SESSION["ErrorMessage"] = "Something wrong with deleting. Try again.";
        Redirect_to("categories.php");
    }
}  
?>