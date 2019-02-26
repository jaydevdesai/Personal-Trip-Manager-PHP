<?php
$obj = json_decode(file_get_contents('php://input'), true);

require 'databaseConnection.php';

$email = $obj["email"];

// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "select * from trip_details where email='$email' ORDER BY `start_date` DESC";
$sql_result = mysqli_query($conn, $sql);
if (($size = mysqli_num_rows($sql_result)) >= 1) {
	$return_arr = array();
	while ($row = mysqli_fetch_array($sql_result, MYSQLI_ASSOC)) {
		$row_array['tripId'] = $row['trip_id'];
		$row_array['tripName'] = $row['trip_name'];
		$row_array['placeName'] = $row['place_name'];
		$row_array['startDate'] = $row['start_date'];
		$row_array['endDate'] = $row['end_date'];
		array_push($return_arr,$row_array);
	}
    $result = ["result"=>"true","size"=>$size,"details"=>$return_arr];
} else {
   $result = ["result"=>"null"];
}
echo json_encode($result);


?>
