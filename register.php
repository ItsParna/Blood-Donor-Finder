<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_donor_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data and sanitize it
$name = $_POST['name'] ?? '';
$blood_group = $_POST['blood_group'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$district = $_POST['district'] ?? '';
$city = $_POST['city'] ?? '';
$state = $_POST['state'] ?? '';
$country = $_POST['country'] ?? '';
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO donors (name, blood_group, phone, email, district, city, state, country, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $name, $blood_group, $phone, $email, $district, $city, $state, $country, $password);

// Execute the statement
if ($stmt->execute()) {
    // Redirect to search page after successful registration
    header("Location: search.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
