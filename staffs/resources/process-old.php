<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// Get the message from the HTML input
$message = $_POST['message'] ?? '';

$requestData = [
    "stream" => true,
    "max_tokens" => 2048,
    "messages" => [
        [
            "role" => "system",
            "content" => "You are a helpful assistant. provide your response in plain text with no formatting or line breaks"
        ],
        [
            "role" => "user",
            "content" => $message
        ]
    ]
];

// Initialize curl session
$curl = curl_init();

// Set curl options
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.cloudflare.com/client/v4/accounts/d1e60664f7c51233c8e7a57dfac06c45/ai/run/@cf/meta/llama-3-8b-instruct",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 300,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($requestData),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer uR7zBKWFD1nyU63AWTvry6wNBFkJfRkCfz8LnuBf",
        "Content-Type: application/json"
    ],
]);

// Function to send SSE message
function sendSseMessage($data) {
    echo $data;
    ob_flush();
    flush();
}

// Execute curl request
$response = curl_exec($curl);
$err = curl_error($curl);

// Close curl session
curl_close($curl);

// Check for curl errors
if ($err) {
    sendSseMessage("cURL Error: $err");
} else {
    // Parse JSON response
    $responseData = json_decode($response, true);

    // Check if response contains the "response" field
    if (isset($responseData['result']['response'])) {
        // Extract the "response" data
        $responseData = trim($responseData['result']['response']);

        // echo json_encode($responseData);
        // Send the response as SSE message
        sendSseMessage(json_encode($responseData));
    }
}

?>
