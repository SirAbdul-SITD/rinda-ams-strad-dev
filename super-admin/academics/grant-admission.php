<?php

require_once '../settings.php'; // Make sure settings.php contains your PDO connection

// Initialize response array
$response = ['success' => false, 'message' => ''];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
    // Start transaction
    $pdo->beginTransaction();

    $ref = $_POST['ref'];
    $name = $_POST['name'];
    $class = $_POST['class'];
    $gender = $_POST['gender'];
    $status = 'Admitted';
    $email = $_POST['email'];


    $query = "SELECT a.class_id, a.status, c.section_id FROM applications a INNER JOIN classes c ON a.class_id = c.id WHERE ref = :ref";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':ref', $ref, PDO::PARAM_STR);
    $stmt->execute();
    $admission_exist = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admission_exist['status'] === $status) {
      throw new Exception("Student Already Granted Admission", 1);
    }

    if ($gender === 'Male') {
      $pronounB = 'HE';
      $pronoun = 'his';
    } else {
      $pronounB = 'SHE';
      $pronoun = 'her';
    }

    // Get the last admission number
    $sqlCheckAdmission = "SELECT admission_no FROM `students` ORDER BY `id` DESC LIMIT 1";
    $stmtCheckAdmission = $pdo->prepare($sqlCheckAdmission);
    $stmtCheckAdmission->execute();
    $existingAdmissions = $stmtCheckAdmission->fetch(PDO::FETCH_ASSOC);

    $last_admission_no = $existingAdmissions ? $existingAdmissions['admission_no'] : "GHA/2017/0000";

    // Generate new admission number
    $prefix = "GHA/2017/";
    $numeric_part = substr($last_admission_no, strlen($prefix)); // Get the numeric part
    $numeric_part = (int) $numeric_part + 1; // Increment
    $numeric_part = str_pad($numeric_part, 4, '0', STR_PAD_LEFT); // Pad with leading zeros
    $admission_no = $prefix . $numeric_part;

    // Prepare the SQL query
    $sql = "
        INSERT INTO students (
            admission_no, session, term, firstName, lastName, gender, dob, class_id, address, state, country, bloodGroup, 
            likes, dislikes, allergies, disorder, health_info, join_date,
            pickup_name1, pickup_relationship1, pickup_number1, 
            pickup_name2, pickup_relationship2, pickup_number2, 
            pickup_name3, pickup_relationship3, pickup_number3
        )
        SELECT 
            :admission, :session, :term, student_firstName, student_lastName, student_gender, student_dob, class_id, student_address, student_state, student_country, student_bloodGroup,
            student_likes, student_dislikes, student_allergies, student_learning_disorder, student_health_info, apply_datetime,
            pickup_name1, pickup_relationship1, pickup_number1, 
            pickup_name2, pickup_relationship2, pickup_number2, 
            pickup_name3, pickup_relationship3, pickup_number3
        FROM 
            applications WHERE ref = :ref LIMIT 1";

    // Prepare the statement
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':admission', $admission_no, PDO::PARAM_STR);
    $stmt->bindParam(':session', $curr_session, PDO::PARAM_STR);
    $stmt->bindParam(':term', $term, PDO::PARAM_INT);
    $stmt->bindParam(':ref', $ref, PDO::PARAM_STR);

    // Execute the query
    if ($stmt->execute()) {
      if ($stmt->rowCount() > 0) {
        $studentId = $pdo->lastInsertId();
        // Update application status
        $insertQuery = "UPDATE `applications` SET `status` = :status, `modified_by` = :modified_by WHERE `ref` = :ref";
        $insertQ = $pdo->prepare($insertQuery);
        $insertQ->bindParam(':ref', $ref, PDO::PARAM_STR);
        $insertQ->bindParam(':status', $status, PDO::PARAM_STR);
        $insertQ->bindParam(':modified_by', $user_id, PDO::PARAM_INT);

        if ($insertQ->execute()) {
          // Send email
          $subject = "Admission Granted";
          $message = "
                    <!DOCTYPE html>
                    <html lang='en'>
                    <head>
                        <meta charset='UTF-8' />
                        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                        <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f4;
                            color: #333;
                        }
                        .container {
                            background-color: #ffffff;
                            padding: 20px;
                            margin: 20px auto;
                            border-radius: 8px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            max-width: 600px;
                        }
                        .header {
                            text-align: center;
                            padding-bottom: 20px;
                            border-bottom: 1px solid #dddddd;
                        }
                        .content {
                            margin-top: 20px;
                        }
                        .content p {
                            line-height: 1.6;
                        }
                        .footer {
                            margin-top: 30px;
                            padding-top: 20px;
                            border-top: 1px solid #dddddd;
                            text-align: center;
                            font-size: 0.9em;
                            color: #666666;
                        }
                        </style>
                    </head>
                    <body>
                    <div class='container'>
                        <div class='header'>
                            <h2>Acceptance Letter</h2>
                        </div>
                        <div class='content'>
                            <p>Assalamu Alaikum</p>
                            <p>
                            On behalf of Grit Hall Academy, I am pleased to inform you that your ward, $name, has been given a space as a pupil at our school ON PROBATION, PROVIDED THAT $pronounB FULFILLS ALL REQUIREMENTS FOR THE CLASS AT THE END OF THE SESSION.
                            </p>
                            <p>
                            Based on $pronoun age and the assessment done, your ward is considered for placement into the $class class for the $curr_session $term_name of the $curr_session academic session, BI'ITHNILLAH.
                            </p>
                            <p>
                            Kindly meet the Administrative Officer for other necessary procedures before the school's resumption on the 16th of September, 2024.
                            </p>
                            <p>
                            We look forward to your ward having a beneficial and successful stay with us at GRIT HALL ACADEMY.
                            </p>
                            <p>
                            Bismillah, to great heights together, In Shaa Allah.
                            </p>
                            <p>
                            Please accept my congratulations.
                            </p>
                        </div>
                        <div class='footer'>
                            <p>Yours faithfully,</p>
                            <p>Z. A BANKOLE</p>
                            <p>GHA HEAD OF SCHOOL</p>
                        </div>
                    </div>
                    </body>
                    </html>";

          // Additional headers
          $headers = 'From: Grithall Academy <noreply@strad.africa>' . "\r\n";
          $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

          // Send email
          mail($email, $subject, $message, $headers);



          if ($admission_exist['section_id'] != 3) {
            $query = "SELECT 
            s.id, 
            s.class_id, 
            CONCAT(s.firstName, ' ', s.lastName) AS full_name, 
            f.id AS fee_id, 
            f.type,
            f.first_term, 
            f.second_term, 
            f.third_term, 
            f.annual 
          FROM students s 
          INNER JOIN compulsory_fees f ON s.class_id = f.class_id 
          WHERE s.status = 1 AND s.id = :sid";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':sid', $studentId, PDO::PARAM_STR);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($students as $student) {
              $student_id = $student['id'];
              $student_name = $student['full_name'];
              $class_id = $student['class_id'];
              $fee_id = $student['fee_id'];
              $fee_type = $student['type'];
              $first_term = $student['first_term'];
              $second_term = $student['second_term'];
              $third_term = $student['third_term'];
              $annual = $student['annual'];

              // $invoice_ref = 'GHA_inv' . time();

              $terms = [$first_term, $second_term, $third_term];
              $validity = 'Per Term';

              foreach ($terms as $index => $term) {
                $amount = $term;

                $payment_term = $index + 1;

                $invoice_ref = 'GHA_inv' . time();

                $insertQuery = "INSERT INTO fees_invoices (fee_id, invoice_ref, student_id, class_id, type, amount, validity, session, term) 
            VALUES (:fee_id, :invoice_ref, :student_id, :class_id, :type, :amount, :validity, :session, :term)";
                $insertQ = $pdo->prepare($insertQuery);
                $insertQ->bindParam(':invoice_ref', $invoice_ref, PDO::PARAM_STR);
                $insertQ->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                $insertQ->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                $insertQ->bindParam(':type', $fee_type, PDO::PARAM_STR);
                $insertQ->bindParam(':amount', $amount);
                $insertQ->bindParam(':validity', $validity, PDO::PARAM_STR);
                $insertQ->bindParam(':session', $curr_session, PDO::PARAM_STR);
                $insertQ->bindParam(':term', $payment_term, PDO::PARAM_INT);
                $insertQ->bindParam(':fee_id', $fee_id, PDO::PARAM_INT);
                $insertQ->execute();
              }
            }
          }






          // Commit transaction
          $pdo->commit();

          $response = ['success' => true, 'message' => 'New student admitted successfully.'];
        } else {
          // Rollback on failure to update
          $pdo->rollBack();
          $response = ['success' => false, 'message' => 'Failed to update application status.'];
        }
      } else {
        // Rollback if no rows were inserted
        $pdo->rollBack();
        $response = ['success' => false, 'message' => 'No rows were inserted.'];
      }
    } else {
      // Rollback on failure to insert
      $pdo->rollBack();
      $response = ['success' => false, 'message' => 'Failed to insert student.'];
    }
  } catch (Exception $e) {
    // Rollback transaction on exception
    $pdo->rollBack();
    $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
  }
} else {
  // If the request method is not POST, return an error response
  $response = ['success' => false, 'message' => 'Invalid request method.'];
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
