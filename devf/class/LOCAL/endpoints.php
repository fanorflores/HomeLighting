<?php
// Define the secret word

$secret_word = 'homelightnin';
//require_once 'conection.php';
require_once("../GC/requisas.php");
//$requisas->createRequest("t_7d7d078c7f811a6d8a8154947601b4");

// Function to validate the hash
function validate_hash($hash, $secret_word)
{
    return hash('sha256', $secret_word) === $hash;
}

// Function to check if an activation with the same cart_key already exists
function activation_exists($cart_key)
{
    echo $cart_key;
    $conn = new HLSynchlcubasSyncAPI();
    $sql = "SELECT COUNT(*) as count FROM activations WHERE JSON_EXTRACT(data, '$.cart_key') = '$cart_key'";
    $result = $conn->getConnection()->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $conn->getConnection()->close();
        return $row['count'] > 0;
    } else {
        $conn->getConnection()->close();
        return false;
    }
}

// Function to record the activation time in the database
function record_activation_time($data)
{
    $c_k = json_decode(json_encode($data))->cart_key;
    $requisas = new RequisasGC();
    $requisas->createRequest($c_k);

    if (activation_exists($c_k)) {
        echo "Activation time already recorded";
        return;
    }

    $conn = new HLSynchlcubasSyncAPI();
    $activation_time = date('Y-m-d H:i:s');
    $sql = "INSERT INTO activations (activation_time,data) VALUES ('$activation_time', '" . json_encode($data) . "')";

    if ($conn->getConnection()->query($sql) === TRUE) {
        echo "Activation time recorded successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->getConnection()->error;
    }

    $conn->getConnection()->close();
}

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['hash']) && validate_hash($_GET['hash'], $secret_word)) {
        record_activation_time($_GET);
    } else {
        echo "Invalid hash";
    }
} else {
    echo "Invalid request method";
}

// Example of how to call the endpoint
// Assuming this script is being accessed via a web browser or HTTP client

/* Generate a valid hash for testing
$valid_hash = '8b6227e6f2474e7e31de32debd3784e27fa4a8db7f55b8b8c9c7629365da411f';

// Call the endpoint with the valid hash
$url = "http://localhost/HomeLighting/class/HL/endpoints.php?hash=8b6227e6f2474e7e31de32debd3784e27fa4a8db7f55b8b8c9c7629365da411f" . $valid_hash;
$response = file_get_contents($url);
echo $response;*/