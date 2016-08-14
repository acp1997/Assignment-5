<?php

require 'core.inc.php';

// log info
if( isset($_SESSION["userId"]) && $_SESSION["userId"]> 0 ){
	//header('Location: home.php');
}else{
	header('Location: login.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style_home.css">
	<!-- <style type="text/css"></style> -->

</head>
<body>

<div id="head"  style=" padding:100px; ">
	<div class="p">Registeration Complete!</div>
	<div class="a"><a href="admin.php">Continue...</a></div>
</div>


</body>
</html>