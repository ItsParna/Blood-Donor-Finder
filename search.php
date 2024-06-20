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

// Get search parameters
$blood_group = $_GET['blood_group'] ?? '';
$city = $_GET['city'] ?? '';
$state = $_GET['state'] ?? '';
$country = $_GET['country'] ?? '';

// Base query
$sql = "SELECT * FROM donors WHERE blood_group = ?";
$params = [$blood_group];
$types = "s";

// Add conditions dynamically
if (!empty($city)) {
    $sql .= " AND city = ?";
    $params[] = $city;
    $types .= "s";
}
if (!empty($state)) {
    $sql .= " AND state = ?";
    $params[] = $state;
    $types .= "s";
}
if (!empty($country)) {
    $sql .= " AND country = ?";
    $params[] = $country;
    $types .= "s";
}

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='search-result'>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($row["name"]) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($row["email"]) . "</p>";
        echo "<p><strong>Phone:</strong> " . htmlspecialchars($row["phone"]) . "</p>";
        echo "<p><strong>Blood Group:</strong> " . htmlspecialchars($row["blood_group"]) . "</p>";
        echo "<p><strong>City:</strong> " . htmlspecialchars($row["city"]) . "</p>";
        echo "<p><strong>State:</strong> " . htmlspecialchars($row["state"]) . "</p>";
        echo "<p><strong>Country:</strong> " . htmlspecialchars($row["country"]) . "</p>";
        echo "</div>";
    }
} else {
    echo "<div id='search-results'><p>No donors found.</p></div>";
}

$stmt->close();
$conn->close();
?>
