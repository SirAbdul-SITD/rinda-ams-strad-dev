<?php
require("settings.php");

if (isset($_GET['subtopic'])) {

    $class = $_GET['class'];
    $subject = $_GET['subject'];
    $topic = $_GET['topic'];
    $subtopic = $_GET['subtopic'];

    // Check if the entry already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM curriculum_contents WHERE class = :class AND subject = :subject AND topic = :topic AND subtopic = :subtopic AND content IS NOT NULL");
    $stmt->bindParam(':class', $class, PDO::PARAM_STR);
    $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
    $stmt->bindParam(':topic', $topic, PDO::PARAM_STR);
    $stmt->bindParam(':subtopic', $subtopic, PDO::PARAM_STR);
    $stmt->execute();

    $contentRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($contentRow) {
        // Entry exists, extract content and return success
        $content = $contentRow['content'];
    } else {

      // Check if the entry already exists in the database
      $stmt = $pdo->prepare("SELECT * FROM curriculum_plans WHERE class = :class AND subject = :subject AND topic = :topic AND subtopic = :subtopic AND plan IS NOT NULL");
      $stmt->bindParam(':class', $class, PDO::PARAM_STR);
      $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
      $stmt->bindParam(':topic', $topic, PDO::PARAM_STR);
      $stmt->bindParam(':subtopic', $subtopic, PDO::PARAM_STR);
      $stmt->execute();
  
      $planRow = $stmt->fetch(PDO::FETCH_ASSOC);
  
      if ($planRow) {
          // Entry exists, extract plan and return success
          $plan = $planRow['plan'];
              // Entry doesn't exist, proceed with the API call
              $userMessage = "Generate detailed lesson content for this plan:" . $plan .". To teach" . $class ." students";
          } else {
            // Entry doesn't exist, proceed with the API call
              $userMessage = "Generate detailed lesson content for this subtopic: " . $subtopic . ". Under  this topic: " . $subtopic . ". To teach" . $class ." students";
          }
    
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

        }

        curl_close($ch);
    }
}

?>


