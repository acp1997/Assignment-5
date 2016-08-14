<?php

require 'core.inc.php';
require 'connect.inc.php';
require 'sna.inc.php';

// log info
if( isset($_SESSION["userId"]) && $_SESSION["userId"]> 0 ){
	header('Location: admin.php');
}else{
	//header('Location: login.php');
}


$err_msg = "";


if( $_SERVER['REQUEST_METHOD'] == 'POST' )
{

	// validating input 

	$uname = sanitize($_POST["uname"]);
	$pass = sanitize($_POST["pass"]);



	//preaping statement
	$query = "SELECT id, admin FROM user WHERE uname=? AND pass=?";
	if( !$stmt = mysqli_prepare($conn , $query) )
		die('login:Error preparing stmt');
	else;

	//binding parameters
	mysqli_stmt_bind_param($stmt, "ss", $uname, $pass);



	//runnning query

	if( mysqli_stmt_execute($stmt)	)
	{
		//action based on no of results
		

		//storing result
		mysqli_stmt_store_result($stmt);

		$no_of_rows = mysqli_stmt_num_rows($stmt);



		if( $no_of_rows==0 ){
			$err_msg = " Invalid username/password ";
		}else if( $no_of_rows==1 ){
			
			//binding result param
			mysqli_stmt_bind_result($stmt,$userId,$admin);

			//fetching result
			mysqli_stmt_fetch($stmt);

			$_SESSION['userId'] = $userId;
			$_SESSION['admin'] = $admin;
			include 'close.inc.php';
			header('Location: admin.php');
		
		}else{
			die('login:Error in database');
		}


	}else{
		die('login:Error in executing stmt');
	}

}else;


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.2.min.js"></script> -->
	<link rel="stylesheet" type="text/css" href="style_login.css">
	<style type="text/css"></style>

</head>
<body>

	<div id="header">
		<p>Welcome to IIT-KGP's Student Database</p>
	</div>


		<div id="form">

			<div id="form_head">
				<p>Log In</p>
			</div>

			<form action="<?php echo $currentFile;?>" method="POST">

				<?php echo $err_msg; ?></br>
			
				<input type="text" name="uname" required 
				placeholder="Username" ></input><br/>

				<input type="password" name="pass" required
				placeholder="Password" ></input><br/>
			
				<input type="submit"></input>
			
				<a href="registeration.php">Register</a>
			
			</form>		
	
		</div>



</body>
</html>