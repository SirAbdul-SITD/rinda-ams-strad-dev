<?php
require("settings.php");

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        $class = $data['class'];
        $subject = $data['subject'];
        $topic = $data['topic'];
        $subtopic = $data['subtopic'];

        // Check if the entry already exists in the database
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM curriculum_contents WHERE class = :class AND subject = :subject AND topic = :topic AND subtopic = :subtopic");
        $stmt->bindParam(':class', $class, PDO::PARAM_STR);
        $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindParam(':topic', $topic, PDO::PARAM_STR);
        $stmt->bindParam(':subtopic', $subtopic, PDO::PARAM_STR);
        $stmt->execute();
        
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Entry already exists, return success
            $response = ['response' => 'success', 'message' => 'Entry already exists'];
            echo json_encode($response);
        } else {
            // Entry doesn't exist, proceed with the API call
            $userMessage = "Generate detailed content for this: " . $subtopic . " under this topic:" . $topic;

            $data = json_encode([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        "role" => "system",
                        "content" => "You're a class teacher responsible for generating detailed topic content in easy explanations providing examples where needed for easy understanding of " . $class . " pupils",
                    ],
                    [
                        'role' => 'user',
                        'content' => $userMessage,
                    ],
                ],
            ]);

            $ch = curl_init('https://api.openai.com/v1/chat/completions');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $api_key,
            ]);

            $api_response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo 'cURL error: ' . curl_error($ch);
            } else {
                $content = $api_response['choices'][0]['message']['content'];

                $stmt = $pdo->prepare("INSERT INTO curriculum_contents (class, subject, topic, subtopic, content) VALUES (:class, :subject, :topic, :subtopic, :content)");
                $stmt->bindParam(':class', $class, PDO::PARAM_STR);
                $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
                $stmt->bindParam(':topic', $topic, PDO::PARAM_STR);
                $stmt->bindParam(':subtopic', $subtopic, PDO::PARAM_STR);
                $stmt->bindParam(':content', $content, PDO::PARAM_STR);
                $stmt->execute();

                $response = ['response' => 'success', 'message' => 'Subject data created and added successfully'];
                echo json_encode($response);
            }

            curl_close($ch);
        }
    }
} catch (PDOException $e) {
    $response = ['response' => 'error', 'message' => $e->getMessage()];
    echo json_encode($response);
} catch (Exception $e) {
    $response = ['response' => 'error', 'message' => $e->getMessage()];
    echo json_encode($response);
}
?>
