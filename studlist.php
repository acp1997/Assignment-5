<?php
require 'core.inc.php';
require 'connect.inc.php';
require 'sna.inc.php';

if( $_SERVER['REQUEST_METHOD'] == 'POST'){

	//authenticating access
	if( isset($_POST['userId']) && isset($_POST['action']) ){
		$userId = $_POST['userId'];
		$action = $_POST['action'];
	}else{
		die('Server(studlist): Undefined Request');
	}

	//rettriving name,rollno
	if( isset($_POST['name']) ){
		$name = sanitize($_POST["name"]);
	}else;

	if( isset($_POST['rollno']) ){
		$rollno = sanitize($_POST["rollno"]);
	}else;

	if( isset($_POST['sel_rollno']) ){
		$sel_rollno = sanitize($_POST["sel_rollno"]);
	}else;



if($action == '0'){
	//show

	$query = "SELECT * FROM stud WHERE id='$userId' ORDER BY rollno";
	if( $query_run = mysqli_query($conn, $query) ){

		$data = "<tr>
					<th>S.No</th>
					<th>Select</th>
					<th>Roll No</th>
					<th>Name</th>
					<th>Prof_id</th>
				</tr>";
		$no_of_rows = mysqli_num_rows($query_run);
		if( $no_of_rows > 0){

			//$result = mysqli_fetch_all($query_run);

			$rbs = '<input type="radio" name="select" value="';
			$rbe = '"></input>';

			//for( $i=0; $i < $no_of_rows; $i++ ){
			$i = 0;
			while( $result = mysqli_fetch_array($query_run) ){	
				$data .= "<tr>" ;

				//appending S.no
				$data .= "<td>".($i+1)."</td>";
				//appending input button with value = 'rollno'
				$data .= "<td>".$rbs.$result[0].$rbe."</td>";
				//appending rollno, name, prof_id
				for($j=0; $j < 3; $j++){
					$data .= "<td>".$result[$j]."</td>";
				}

				$data .= "</tr>" ;
				$i++;
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


}else if($action == '1'){
	//Insert

	$query1 = "SELECT * FROM stud WHERE id='$userId' AND rollno='$rollno'";
	if( $query_run1 = mysqli_query($conn, $query1) ){

		if( !($no_of_rows = mysqli_num_rows($query_run1)) ){

			$query1 = "INSERT INTO stud(rollno, name, id) VALUES ('$rollno', '$name', '$userId')";
			
			if( $query_run1 = mysqli_query($conn, $query1) ){
				echo 'Data Inserted';
			}else{
				die('Server(studlist):Error executing query1:2');
			}


		}else{
			echo 'Student with same Roll No found in your list';
		}


	}else{
		die('Server(studlist):Error executing query1');
	}


	

}else if($action == '2'){
	//edit

	//checking existence of row with rollno to be deleted
	$query2 = "SELECT * FROM stud WHERE id='$userId' AND rollno='$sel_rollno'";
	if( $query_run2 = mysqli_query($conn, $query2) ){

		if( ($no_of_rows = mysqli_num_rows($query_run2))== 1 ){

			//row exist--> checking availability of rollno to be added
			$query2 = "SELECT * FROM stud WHERE id='$userId' AND rollno='$rollno'";
			if( $query_run2 = mysqli_query($conn, $query2) ){

				if( !( $no_of_rows = mysqli_num_rows($query_run2) ) || 
					(  $no_of_rows = mysqli_num_rows($query_run2)== 1  &&  ($rollno == $sel_rollno)  )     
					){

					//updating info			
					$query2 = "UPDATE stud SET rollno='$rollno', name='$name' WHERE id='$userId' AND rollno='$sel_rollno'";
			
					if( $query_run2 = mysqli_query($conn, $query2) ){
						echo 'Data Edited';
					}else{
						die('Server(studlist):Error executing query2:3');
					}

	
				}else{
					echo 'Student with same Roll No found in your list';
				}

			}else{
				die('Server(studlist):Error executing query2:2');
			}


			
		}else{
			echo 'No student found with the requested Roll No';
		}


	}else{
		die('Server(studlist):Error executing query2');
	}


}else if($action == '3'){
	//delete

	$query3 = "SELECT * FROM stud WHERE id='$userId' AND rollno='$sel_rollno'";
	if( $query_run3 = mysqli_query($conn, $query3) ){

		if( ($no_of_rows = mysqli_num_rows($query_run3)) == 1 ){

			$query3 = "DELETE FROM stud WHERE id='$userId' AND rollno='$sel_rollno'";
			
			if( $query_run3 = mysqli_query($conn, $query3) ){
				echo 'Data Deleted';
			}else{
				die('Server(studlist):Error executing query3:2');
			}


		}else{
			echo 'No student found with the requested Roll No';
		}


	}else{
		die('Server(studlist):Error executing query3');
	}




}else{
	die('Server(studlist):Unrecognised Request');
}


}else{
	die('Server(studlist):Unathourised Access');
}

?>