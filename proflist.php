<?php
require 'core.inc.php';
require 'connect.inc.php';
require 'sna.inc.php';

if( $_SERVER['REQUEST_METHOD'] == 'POST'){

	//authenticating access
	if( isset($_POST['action']) ){
		$action = $_POST['action'];
	}else{
		die('Server(studlist): Undefined Request');
	}

	//rettriving sel_id

	if( isset($_POST['sel_id']) ){
		$sel_id = sanitize($_POST["sel_id"]);
	}else;



if($action == 0){

	$query = "SELECT name, dep, id FROM user ORDER BY name";

	if( $query_run = mysqli_query($conn, $query) ){

		$data = "<tr>
					<th>Select</th>
					<th>S.No</th>
					<th>Name</th>
					<th>Department</th>
					<th>Prof_id</th>
				</tr>";
		$no_of_rows = mysqli_num_rows($query_run);
		if( $no_of_rows > 0){

			//{$result = mysqli_fetch_all($query_run);}

			$rbs = '<input type="radio" name="select" value="';
			$rbe = '"></input>';

			for( $i=0; /*{$i < $no_of_rows}*/$result = mysqli_fetch_array($query_run) ; $i++ ){
				$data .= "<tr>" ;

				//appending input button with value = 'id'
				$data .= "<td>".$rbs.$result[2].$rbe."</td>";
				//appending S.no
				$data .= "<td>".($i+1)."</td>";
				//appending name, dep, id
				for($j=0; $j < 3; $j++){
					$data .= "<td>".$result[$j]."</td>";
				}

				$data .= "</tr>" ;
			}

		}else{
			$data .= "<tr>" ;

			for($j=0; $j<5; $j++){
				$data .= "<td>-</td>";
			}
			
			$data .= "</tr>" ;
		}
			
		echo $data;


	}else{
		die('Server(studlist):Error executing query');
	}

}else if($action == 1){

	$_SESSION['req_userId'] = $sel_id;

}else{
	die('Server(studlist):Unrecognised Request');
}


}else{
	die('Server(studlist):Unathourised Access');
}

?>