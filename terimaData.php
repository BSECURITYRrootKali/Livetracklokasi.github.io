<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gps_tracking_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['lat']) && isset($_POST['lng'])) {
    $latitude = $_POST['lat'];
    $longitude = $_POST['lng'];

    $sql = "INSERT INTO location_data (latitude, longitude) VALUES ('$latitude', '$longitude')";

    if ($conn->query($sql) === TRUE) {
      echo "Location data inserted successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    echo "Latitude and longitude data not received";
  }
} else {
  echo "Invalid request method";
}

$conn->close();
?>
