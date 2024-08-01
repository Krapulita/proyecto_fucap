<?php
// Database connection
$host = 'localhost';
$dbname = 'reservations';
$user = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service = $_POST['service'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Insert the reservation into the database
    $stmt = $conn->prepare("INSERT INTO reservations (service_id, date, time, name, email, phone)
                            SELECT id, :date, :time, :name, :email, :phone
                            FROM services
                            WHERE name = :service");
    $stmt->bindParam(':service', $service);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->execute();

    // Redirect to the success page
    header('Location: success.html');
    exit;
}

// Fetch the services from the database
$stmt = $conn->prepare("SELECT * FROM services");
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the HTML with the services
include 'index.html';
?>