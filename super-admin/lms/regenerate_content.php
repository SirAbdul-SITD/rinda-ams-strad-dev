<?php
require("../settings.php");
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$response = ['success' => false, 'message' => '', 'content' => ''];

try {
    $required = ['class', 'subject', 'topic', 'subtopic'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    $class = $_POST['class'];
    $subject = $_POST['subject'];
    $topic = $_POST['topic'];
    $subtopic = $_POST['subtopic'];

    // Generate new content
    $userMessage = "Generate comprehensive lesson content for $class students about:\n\nTopic: $topic\nSubtopic: $subtopic\n\n" .
                 "Include detailed explanations, examples, activities, and assessments.";

    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            [
                "role" => "system",
                "content" => "You're an expert teacher creating detailed lesson content for $class students."
            ],
            [
                'role' => 'user',
                'content' => $userMessage
            ]
        ]
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.cloudflare.com/client/v4/accounts/d1e60664f7c51233c8e7a57dfac06c45/ai/run/@cf/meta/llama-3-8b-instruct",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 600,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer uR7zBKWFD1nyU63AWTvry6wNBFkJfRkCfz8LnuBf",
            "Content-Type: application/json"
        ],
    ]);

    $apiResponse = curl_exec($curl);
    
    if (curl_errno($curl)) {
        throw new Exception('API Error: ' . curl_error($curl));
    }

    $responseData = json_decode($apiResponse, true);
    
    if (!isset($responseData['result']['response'])) {
        throw new Exception('Invalid API response format');
    }

    $content = $responseData['result']['response'];

    // Update database
    $stmt = $pdo->prepare("UPDATE curriculum_contents SET content = :content WHERE class = :class AND subject = :subject AND topic = :topic AND subtopic = :subtopic");
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':class', $class, PDO::PARAM_STR);
    $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
    $stmt->bindParam(':topic', $topic, PDO::PARAM_STR);
    $stmt->bindParam(':subtopic', $subtopic, PDO::PARAM_STR);
    $stmt->execute();

    $response = [
        'success' => true,
        'message' => 'Content regenerated successfully',
        'content' => $content
    ];

    curl_close($curl);
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);
?>