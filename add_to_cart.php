<?php
// Database configuration
$host = 'laazth';
$username = 'laazth';
$password = 'coleeyves';
$dbname = 'lalamons_db';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$input = json_decode(file_get_contents("php://input"), true);
$productId = $input['productId'];

// Assume a session or some mechanism to track the user
$userId = $_SESSION['user_id'];

// Add product to user's cart
$sql = "INSERT INTO cart (user_id, product_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $productId);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Product added to cart successfully.']);
} else {
    echo json_encode(['message' => 'Failed to add product to cart.']);
}

$stmt->close();
$conn->close();
?>
