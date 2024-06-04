<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "root"; // MAMP utilise "root" comme mot de passe par défaut
$dbname = "Projet";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'get_coach') {
    $sql = "SELECT * FROM coach";
    $result = $conn->query($sql);
    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    echo json_encode($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'send_email') {
    $data = json_decode(file_get_contents('php://input'), true);
    $to = 'rayudaoudi@gmail.com'; // Remplacez par l'email du coach
    $subject = 'Contact avec le coach';
    $message = $data['message'];
    $headers = 'From: ' . $data['from_name'] . ' <' . $data['from_email'] . '>';

    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['status' => 'Email sent']);
    } else {
        echo json_encode(['status' => 'Failed to send email']);
    }
    exit;
}

$conn->close();
?>
