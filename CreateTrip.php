<?php
$obj = json_decode(file_get_contents('php://input'), true);
require 'databaseConnection.php';

$email = $obj["email"];
$tripName = $obj["tripName"];
$placeName = $obj["placeName"];
$startDate = $obj["startDate"];
$endDate = $obj["endDate"];

if($email !== NULL && $tripName !== NULL && $placeName !== NULL && $startDate !== NULL && $endDate !== NULL){
	$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$tripId = 0;
	while(true){
		$tripId = $placeName.mt_rand();
		$sql = "select trip_id from trip_details where trip_id='$tripId'";
		$sql_result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($sql_result) == 0) {
			break;
		}
	}
	
	$sql = "INSERT INTO trip_details VALUES ('$email', '$tripId', '$tripName', '$placeName', '$startDate', '$endDate')";
	if (mysqli_query($conn, $sql)) {
		$result = ["result"=>"true"];
	} else {
	   $result = ["result"=>"false"];
	}

	
} else {
	$result = ["result"=>"null"];
}

echo json_encode($result);
?>