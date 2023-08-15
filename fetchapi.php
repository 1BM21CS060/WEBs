<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "awaiz2";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
}

$sql = "SELECT * FROM aw3";
$result = mysqli_query($conn, $sql);

$reviews = array();
while ($row = mysqli_fetch_assoc($result)) {
    $reviews[] = $row;
}

mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($reviews);
?>
