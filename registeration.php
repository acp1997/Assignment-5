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


$name = $username = $dep = "";


if( $_SERVER['REQUEST_METHOD'] == 'POST'){


	// validating input
	if( strlen($_POST["name"])>30 || empty($_POST["name"]) ||
		strlen($_POST["username"])>15 || empty($_POST["username"]) ||
		strlen($_POST["dep"])>15 || empty($_POST["dep"]) ||
		strlen($_POST["password"])>15 || empty($_POST["password"])
	){
		die('registeration: Input Error . Please start again');
	}else;
	
	$name = sanitize($_POST["name"]);
	$username = sanitize($_POST["username"]);
	$password = sanitize($_POST["password"]);
	$dep = sanitize($_POST["dep"]);



	//checking availibilty of uname

	

	//preparing statement1
	$query1 = "SELECT * FROM user WHERE uname=?";
	if( !$stmt1 = mysqli_prepare($conn, $query1) )
		die('registeration:Error in preparing stmt1');
	else;

	//binding parameters for stmt1
	mysqli_stmt_bind_param($stmt1, "s", $username);


	//executing stmt1
	if(  mysqli_stmt_execute($stmt1) ){

		//storing result
		mysqli_stmt_store_result($stmt1);

		$no_of_rows = mysqli_stmt_num_rows($stmt1);
		

		if( $no_of_row == 0 ){

			//inserting details


			//preparing statement2
			$query2 = "INSERT INTO user(name, uname, pass, dep, admin) VALUES (?, ?, ?, ?, '0')";
			if( !$stmt2 = mysqli_prepare($conn, $query2) )
				die('registeration:Error in preparing stmt2');
			else;

			//binding parameters for stmt2
			mysqli_stmt_bind_param($stmt2, "ssss", $name, $username, $password, $dep);

		
			//executing stmt2
			if( mysqli_stmt_execute($stmt2) ){

				//closing stmt2
				mysqli_stmt_close($stmt2);


				//fetching id for home page


				//preparing stmt1:2
				$query1 = "SELECT id, admin FROM user WHERE uname=?";
				if( !$stmt1 = mysqli_prepare($conn, $query1) )
					die('registeration:Error in preparing stmt1:2');
				else;

				//binding parameters for stmt1:2
				mysqli_stmt_bind_param($stmt1, "s", $username);


				//executing stmt1:2
				if( mysqli_stmt_execute($stmt1) ){

					//binding result param
					mysqli_stmt_bind_result($stmt1,$userId,$admin);

					//fetching result
					mysqli_stmt_fetch($stmt1);
					
					$_SESSION['userId'] = $userId;
					$_SESSION['admin'] = $admin;
					header('Location: regCom.php');

				}else{
					header('Location: login.php');
				}
				

			}else{
				die('regiseration:Error in executing stmt2 ');
			}

		}else{
			echo "Username already in use";
			$username = "";
		}

	}else{
		die('registration:Error in executing stmt1');
	}

}

?>

<!DOCTYPE html>
<html>
<head>

	<title>Register now </title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.2.min.js"></script> -->
	<link rel="stylesheet" type="text/css" href="style_reg.css">
	<style type="text/css"></style>

</head>

<body>
<div id="page">

	<div id="head">
		<h1>Register Here</h1>
	</div>	

	<div id="body">

		<form action="<?php echo $currentFile; ?>" method="POST">
		
		<div class="boxes">
			<label class="tag">Name *</label>
			<input type="text" name="name" maxlength="30" required 
			value="<?php echo $name;?>" pattern="[a-zA-Z ]{1,}" 
			onchange="state('Name should 0-30 character long.[alphabet only]',this)"/>
			<br/>
		</div>

		<div class="boxes">
			<label class="tag">Department *</label>
			<input type="input" name="dep" maxlength="15" required 
			value="<?php echo $dep;?>" pattern="[a-zA-Z ]{3,}" 
			onchange="state('Department should be 3-15 char long.[alphabet only]', this)"/>
			<br/>
		</div>
		
		<div class="boxes">
			<label class="tag">Username *</label>
			<input type="text" name="username" maxlength="15" required 
			value="<?php echo $username;?>"	pattern="[a-zA-Z0-9_]{3,}" 
			onchange="state('Username should be 3-15 char long.No spaces allowed.[alphabet and number only]', this)" />
			<br/>
		</div>
		
		<div class="boxes">
			<label class="tag">Password *</label>
			<input type="password" id="pass1" name="password" maxlength="15" required pattern="[a-zA-Z0-9]{3,}" 
			onchange="state('Password should be 3-15 char long.No spaces allowed.[alphabet and number only]', this)"/>
			<br/>
		</div>	

		<div class="boxes">
			<label class="tag">Re-type Password *</label>
			<input type="password" id="pass2" name="password2" maxlength="15" required
			onkeyup ="check()" />
			<br/>
		</div>

		<input type="submit">

		<p>Already registered?</p>
		<a href="login.php">Log In</a>

		</form>
	</div>
		
</div>
</body>

<script type="text/javascript">
	
	//onkeyup(pass2)
	function check()
	{
		var pass1, pass2 ;
		pass1 = document.getElementById("pass1");
		pass2 = document.getElementById("pass2");

		if( pass1.value == pass2.value ){
			pass2.setCustomValidity("");
		}else{
			pass2.setCustomValidity("Password does not match");
		}
	}

	function state(err_msg, add)
	{
		//console.log(err_msg);
		if( add.checkValidity() ){
			add.setCustomValidity("");
		}else{
			add.setCustomValidity(err_msg);
		}
	}

</script>
</html>