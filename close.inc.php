<?php

if(isset($stmt)){
	mysqli_stmt_free_result($stmt);
	mysqli_stmt_close($stmt);
}else;

mysqli_close($conn);

?>