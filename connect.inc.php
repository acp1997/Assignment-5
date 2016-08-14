<?php

//connecting to database


//local server values
/*
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ass5_database";
*/

//000webhost server values  (change for ass5)

$servername = "mysql1.000webhost.com";
$username = "a7747927_acp2";
$password = "acp1997";
$dbname = "a7747927_ass5";


// Create connection
$conn = @mysqli_connect($servername, $username, $password, $dbname) or die("Connection Error");
///echo "Connected successfully";

?>