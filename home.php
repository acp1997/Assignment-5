<?php

require 'core.inc.php';
require 'connect.inc.php';


//checking whether admin access 
if( isset($_SESSION["admin"]) && $_SESSION["admin"] == 1 ){
	//admin access

	//admin --> userId from req_userId
	$userId = $_SESSION["req_userId"];

}else{
	//not admin access

	//whether verified user or not
	if( isset($_SESSION["userId"]) && $_SESSION["userId"]> 0 ){

		//non admin user --> userId from userId
		$userId = $_SESSION["userId"];

	}else{
		header('Location: login.php');
	}
	
}



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
		<div class="p">Welcome <?php echo $name; ?>.</div>
		<div class="a"><a href="logout.php">Log Out</a></div>
		<div class="a"><a href='admin.php'>Admin Page</a></div>
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
			<button id="insert" onclick="insert()">Insert</button>
			<button id="edit" onclick="edit()">Edit</button>
			<button id="delete" onclick="del()">Delete</button>
			</div>

			<div id="inp">
			<form>
				<input type="text" name="rollno" placeholder="Roll No" maxlength="10" required 
				pattern="[a-zA-Z0-9]{1,}"></input></br>
				<input type="text" name="name" placeholder="Name" maxlength="30" required 
				pattern="[a-zA-Z ]{1,}"></input></br>	
			</form>
			</div>

			<div id="msg"></div>

		</div>

	</div>

</body>
</html>


<script type="text/javascript">
		
	var table_s = $("#stud");
	var sel_roll;
		
	$(document).ready(function(){
	
		refresh();
		$(document).on('change', 'input:radio[name="select"]', function(){
        	var value = $("input:checked[name='select']").val();
			sel_roll = value;
 		}) ;

	});



	function refresh(){

		table_s.empty();
		$.post("studlist.php",{action: '0',userId: '<?php echo $userId ?>'},function(result){
			table_s.append(result);
		});
	}



	function insert(){
		var nadd = $('input:text[name="name"]');
		var name = nadd.val();
		var radd = $('input:text[name="rollno"]');
		var rollno = radd.val();

		if(name == '' || name == null || rollno == '' || rollno == null){
			$('#msg').text('You need to fill out the information');

		}else if( !nadd[0].checkValidity() ){
			
			$('#msg').text('Name: Max 30 char.(alphabets and numbers only)');
			nadd.val("");

		}else if( !radd[0].checkValidity() ){

			$('#msg').text('Roll No: Max 10 char. No spaces allowed(alphabets and numbers only)');
			radd.val("");

		}else{
			$.post("studlist.php",
				{action: '1', name: name, rollno: rollno, userId: '<?php echo $userId ?>'},
				function(msg){

					if( msg == 'Data Inserted' ){
						refresh();
						$('input:text[name="name"]').val("");
						$('input:text[name="rollno"]').val("");
						$('#msg').text(msg);
					}else{
						$('#msg').text(msg);
					}

				});
		}
	

	}



	function edit(){
		var nadd = $('input:text[name="name"]');
		var name = nadd.val();
		var radd = $('input:text[name="rollno"]');
		var rollno = radd.val();

		if(name == '' || name == null || rollno == '' || rollno == null){
			$('#msg').text('You need to fill out the information');

		}else if( !nadd[0].checkValidity() ){
			
			$('#msg').text('Name: Max 30 char.(alphabets and numbers only)');
			nadd.val("");

		}else if( !radd[0].checkValidity() ){

			$('#msg').text('Roll No: Max 10 char. No spaces allowed(alphabets and numbers only)');
			radd.val("");

		}else if(sel_roll == '' || sel_roll == null){
			$('#msg').text('Select one of the enteries first.');
		}else{
			$.post("studlist.php",
				{action: '2', name: name, rollno: rollno,sel_rollno: sel_roll, userId: '<?php echo $userId ?>'},
				function(msg){

					if( msg == 'Data Edited' ){
						refresh();
						$('input:text[name="name"]').val("");
						$('input:text[name="rollno"]').val("");
						$('#msg').text(msg);
					}else{
						$('#msg').text(msg);
					}

				});
		}

	}


	function del(){

		if(sel_roll == '' || sel_roll == null){
			$('#msg').text('Select one of the enteries first.');
		}else{
			$.post("studlist.php",
				{action: '3',sel_rollno: sel_roll, userId: '<?php echo $userId ?>'},
				function(msg){

					if( msg == 'Data Deleted' ){
						refresh();
						$('#msg').text(msg);
					}else{
						$('#msg').text(msg);
					}

				});
		}

	}


</script>
