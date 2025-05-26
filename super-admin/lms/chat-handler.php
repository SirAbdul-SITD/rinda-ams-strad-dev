<?php
require_once('../settings.php'); 

$apiKey = 'mn5l1lNpjZcoLuAUunrUKS8ldIroPLg75jU56HJK';
$input = $_POST['message'] ?? '';
$userId = $_SESSION['user_id'] ?? null;

if (!$input) {
  echo "No input received.";
  exit;
}


$data = [
  "model" => "command-r",
  "message" => $input,
  "temperature" => 0.7,
  "stream" => false
];

$headers = [
  "Authorization: Bearer $apiKey",
  "Content-Type: application/json",
];

$ch = curl_init('https://api.cohere.ai/v1/chat');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
if (curl_errno($ch)) {
  echo "Request Error: " . curl_error($ch);
  exit;
}
curl_close($ch);

$responseData = json_decode($response, true);
if (isset($responseData['text'])) {
    $aiReply = $responseData['text'];
} else {
    file_put_contents('/tmp/debug-log.txt', $response); 
    $aiReply = "⚠️ Sorry, the AI could not generate a response. Please try again.";
}

try {
  $stmt = $pdo->prepare("INSERT INTO ai_chat_history (user_id, message, response) VALUES (?, ?, ?)");
  $stmt->execute([$userId, $input, $aiReply]);
} catch (PDOException $e) {
  error_log("DB Error: " . $e->getMessage());
}

echo trim($aiReply);

file_put_contents("debug-log.txt", $response); 
