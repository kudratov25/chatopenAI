<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "chat_app";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input
    $user_message = $_POST['message'];

    // Call OpenAI GPT-3.5 API (replace with your actual API endpoint and key)
    $openaiApiKey = '';
    $prompt = $user_message;

    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'user', 'content' => $prompt],
        ],
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\nAuthorization: Bearer $openaiApiKey",
            'method' => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents('https://api.openai.com/v1/chat/completions', false, $context);
    $response = json_decode($response);
    $gpt_answer = $response->choices[0]->message->content;

    // Save chat history to database
    $sql = "INSERT INTO chat_history (user_message, gpt_answer) VALUES ('$user_message', '$gpt_answer')";
    if ($conn->query($sql) === TRUE) {
        // Successfully saved to database
    } else {
        // Error saving to database
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close MySQL connection
    $conn->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode(array('user_message' => $user_message, 'gpt_answer' => $gpt_answer));
    exit;
}
