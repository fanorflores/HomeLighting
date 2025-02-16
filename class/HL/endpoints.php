<?php
// Define the secret word
$secret_word = 'homelightnin';

// Function to validate the hash
function validate_hash($hash, $secret_word)
{
    return hash('sha256', $secret_word) === $hash;
}

// Function to record the activation time in the database
function record_activation_time($data)
{
    $host = 'localhost';
    $db = 'hlcubassyncapi';
    $user = 'root';
    $pass = '';

    // Create connection
    $conn = new mysqli($host, $user, $pass, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $activation_time = date('Y-m-d H:i:s');
    $sql = "INSERT INTO activations (activation_time,data) VALUES ('$activation_time', '" . json_encode($data) . "')";

    if ($conn->query($sql) === TRUE) {
        echo "Activation time recorded successfully";
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
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
$url = "http://localhost/HomeLighting/class/HL/endpoints.php?hash=" . $valid_hash;
$response = file_get_contents($url);
echo $response;*/