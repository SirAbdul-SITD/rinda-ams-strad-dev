<?php

require 'settings.php';

// OpenAI API endpoint
$api_url = 'https://api.openai.com/v1/chat/completions';


// Data to be sent in the request
$data = array(
    "model" => "gpt-3.5-turbo",
    "messages" => array(
        array(
            "role" => "system",
            "content" => "You are a helpful assistant."
        ),
        array(
            "role" => "user",
            "content" => "Who won the world series in 2020?"
        ),
        array(
            "role" => "assistant",
            "content" => "The Los Angeles Dodgers won the World Series in 2020."
        ),
        array(
            "role" => "user",
            "content" => "Where was it played?"
        )
    )
);

// Convert data to JSON format
$post_data = json_encode($data);

// Initialize cURL session
$curl = curl_init();

// Set cURL options
curl_setopt_array($curl, array(
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $post_data,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ),
));

// Execute the request and get the response
$response = curl_exec($curl);

// Check for errors
if (curl_errno($curl)) {
    echo 'Error: ' . curl_error($curl);
}

// Close cURL session
curl_close($curl);

// Output the response
echo $response;

?>
