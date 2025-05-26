<?php

// Cloudflare API endpoint
$api_url = 'https://api.cloudflare.com/client/v4/accounts/d1e60664f7c51233c8e7a57dfac06c45/ai/run/@cf/meta/llama-2-7b-chat-int8';

// API token
$api_token = 'CdxR28zn5E_OQX_wCnWd-DO40yOWWuHpZJJ4R6vf';

// Data to be sent in the request
$data = array(
    'messages' => array(
        array(
            'role' => 'system',
            'content' => "You're a class teacher responsible for generating detailed topic content in easy explanations providing examples where needed for easy understanding of Grade 1 pupils"
        ),
        array(
            'role' => 'user',
            'content' => "Generate detailed content for this: fomular method under this topic: quadratic equation. in 200 words"
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
        'Authorization: Bearer ' . $api_token,
        'Content-Type: application/json'
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
