<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>

<?php  

function Redirect_to($New_Location) {
	header("location:".$New_Location);
    exit;
}

function Login_attempt($Username, $Password) {
	global $Connection;

	$Query = "SELECT * FROM registration WHERE username='$Username' AND password='$Password' ";

	$Execute =  mysqli_query($Connection, $Query);

	if ($Admin = mysqli_fetch_array($Execute)) {
		return $Admin;
	} else {
		return null;
	}
}

function Login() {
	if (isset($_SESSION["User_id"])) {
		return true;
	}
}

function confirm_Login() {
	 if (!Login()) {
	 	$_SESSION["ErrorMessage"] = "Login Required!";
	 	Redirect_to("login.php");
	 }
}

?>