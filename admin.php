<?php

require 'core.inc.php';
require 'connect.inc.php';


// log info
if( isset($_SESSION["admin"]) && $_SESSION["admin"] == 1 ){
	//header('Location: home.php');
}else{
	header('Location: home.php');
}


$userId = $_SESSION["userId"];
$_SESSION['req_userId'] = $_SESSION["userId"];

$query1 = "SELECT * FROM user WHERE id='$userId'";

if( $query_run = mysqli_query($conn, $query1) ){
	
	$user = mysqli_fetch_assoc($query_run);
	$name = $user['name'];
}else{
	die('home:Error1') ;
}



?>


<!DOCTYPE html>
<html>
<head>
	<title></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script type="text/javascript" src="jquery-3.0.0.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style_home.css">
	<!-- <style type="text/css"></style> -->


</head>
<body>



	<div id="head">
		<div class="p">Welcome <?php echo $name; ?> (Admin).</div>
		<div class="a"><a href="logout.php">Log Out</a></div>
		<div class="a"><a href='home.php'>Home Page</a></div>
	</div>

	<div id="body">
		
		<div id="studTable">
			
			<form>
			<table id="stud">
				
			</table>
			</form>

		</div>

		<div id="tab_op">
			
			<div id="buttons">
			<button id="go" onclick="go()">Veiw/Edit</button>
			</div>

			<div id="msg"></div>

		</div>

	</div>


</body>
</html>

<script type="text/javascript">
		
	var table_p = $("#stud");
	var sel_id;
		
	$(document).ready(function(){
	
		refresh();
		$(document).on('change', 'input:radio[name="select"]', function(){
        	var value = $("input:checked[name='select']").val();
			sel_id = value;
 		}) ;

	});



	function refresh(){

		table_p.empty();
		$.post("proflist.php",{action: 0},function(result){
			table_p.append(result);
		});
	}

	

	function go(){

		if(sel_id == '' || sel_id == null){
			$('#msg').text('Select one of the enteries first.');
		}else{
			$.post("proflist.php", {action: 1, sel_id: sel_id});			
			window.location.href = "home.php";
		}

	}


</script>
