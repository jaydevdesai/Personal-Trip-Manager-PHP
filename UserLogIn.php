<?php
$obj = json_decode(file_get_contents('php://input'), true);
require 'databaseConnection.php';

$email = $obj["email"];
$password = $obj["password"];

// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "select email , password from user_login where email='".$email."' and password = '".$password."'";
$sql_result = mysqli_query($conn, $sql);
if (mysqli_num_rows($sql_result) == 1) {
    $result = ["result"=>"true"];
} else {
   $result = ["result"=>"false"];
}
echo json_encode($result);


?>
