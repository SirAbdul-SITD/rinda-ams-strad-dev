<?php
// Ensure no output before headers
ob_start();

require('../settings.php');
session_start();

// Set proper headers first
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Initialize response array
$response = [
    'success' => false,
    'message' => '',
    'new_plan' => ''
];

try {
    // Validate required fields
    $required = ['class', 'subject', 'topic', 'subtopic', 'current_content'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    $class = $_POST['class'];
    $subject = $_POST['subject'];
    $topic = $_POST['topic'];
    $subtopic = $_POST['subtopic'];
    $current_content = $_POST['current_content'];

    // Prepare the prompt for AI generation
    $userMessage = "Improve and enhance this lesson plan for $class students on $topic - $subtopic. 

    Current plan:
    $current_content

    Enhancements needed:
    1. Add more detailed explanations
    2. Include practical examples
    3. Suggest engaging activities
    4. Add assessment methods
    5. Ensure proper HTML formatting with tables where appropriate

    Maintain the original structure but make it more comprehensive.";

    // Generate enhanced plan via API
    $data = json_encode([
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            [
                "role" => "system",
                "content" => "You're an expert curriculum designer improving existing lesson plans.",
            ],
            [
                'role' => 'user',
                'content' => $userMessage,
            ],
        ],
    ]);

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.cloudflare.com/client/v4/accounts/d1e60664f7c51233c8e7a57dfac06c45/ai/run/@cf/meta/llama-3-8b-instruct",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer uR7zBKWFD1nyU63AWTvry6wNBFkJfRkCfz8LnuBf",
            "Content-Type: application/json"
        ],
    ]);

    $apiResponse = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);

    if ($error) {
        throw new Exception("API Error: $error");
    }

    $responseData = json_decode($apiResponse, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Invalid API response format");
    }

    if (!isset($responseData['result']['response'])) {
        throw new Exception("API response missing expected data");
    }

    $response = [
        'success' => true,
        'message' => 'Plan regenerated successfully',
        'new_plan' => $responseData['result']['response']
    ];

} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

// Clean any unexpected output
ob_end_clean();
echo json_encode($response);
exit();
?>