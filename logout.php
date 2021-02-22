<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>

<?php

$_SESSION["User_id"] = null;

session_destroy();
Redirect_to("login.php");
 
?>