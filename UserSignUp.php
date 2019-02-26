<?php
$obj = json_decode(file_get_contents('php://input'), true);
require 'databaseConnection.php';

$email = $obj["email"];
$password = $obj["password"];

if($email !== NULL && $password !== NULL){
	$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "select email , password from user_login where email='".$email."'";
	$sql_result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($sql_result) > 0) {
		$result = ["result"=>"already"];
	} else {
		$sql = "INSERT INTO user_login (email, password) VALUES ('$email', '$password')";
		if (mysqli_query($conn, $sql)) {
			$result = ["result"=>"true"];
		} else {
		   $result = ["result"=>"false"];
		}
	}
	
} else {
	$result = ["result"=>"null"];
}

echo json_encode($result);
?>
