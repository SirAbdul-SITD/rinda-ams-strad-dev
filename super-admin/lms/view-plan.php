<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('../settings.php');

// Check if user is logged in

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Get user details from session
$user_id = $_SESSION['user_id'];
$full_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Guest';
$account_type = $_SESSION['account_type'];
$gender = $_SESSION['gender'] ?? 'Male';

// Check required parameters
if (!isset($_GET['subtopic']) || !isset($_GET['class']) || !isset($_GET['subject']) || !isset($_GET['topic'])) {
    die("Missing required parameters");
}

$class = $_GET['class'];
$subject = $_GET['subject'];
$topic = $_GET['topic'];
$subtopic = $_GET['subtopic'];

// Initialize variables
$plan = '';
$content = '';
$is_new_generation = false;
$plan_id = null;

try {
    // Check if plan exists in database
    $stmt = $pdo->prepare("SELECT * FROM curriculum_plans WHERE class = :class AND subject = :subject AND topic = :topic AND subtopic = :subtopic ORDER BY updated_at DESC LIMIT 1");
    $stmt->bindParam(':class', $class, PDO::PARAM_STR);
    $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
    $stmt->bindParam(':topic', $topic, PDO::PARAM_STR);
    $stmt->bindParam(':subtopic', $subtopic, PDO::PARAM_STR);
    $stmt->execute();

    $planRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($planRow) {
        $plan = $planRow['plan'];
        $plan_id = $planRow['id'];
    } else {
        $is_new_generation = true;
        // Generate a new plan since none exists
        $userMessage = "Generate a comprehensive lesson plan for $class students on: $topic - $subtopic. 

        Structure with these sections:
        1. Lesson Objectives (3-5 clear outcomes)
        2. Introduction (engaging starter activity)
        3. Main Content (detailed breakdown with examples)
        4. Activities (student-centered tasks)
        5. Assessment (how learning will be checked)
        6. Conclusion (summary and reflection)
        7. Homework/Extension (if applicable)

        Format with HTML tags (<h3> for section headers, <ul>/<li> for lists, <table> for timelines). 
        Make it age-appropriate for $class students.";

        // Generate plan via API
        $data = json_encode([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    "role" => "system",
                    "content" => "You're an expert curriculum designer creating detailed lesson plans. Use clear, structured HTML formatting with tables where appropriate.",
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
            CURLOPT_TIMEOUT => 600,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer uR7zBKWFD1nyU63AWTvry6wNBFkJfRkCfz8LnuBf",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        
        if (curl_errno($curl)) {
            throw new Exception('cURL error: ' . curl_error($curl));
        }

        $responseData = json_decode($response, true);
        $plan = $responseData['result']['response'] ?? '<div class="alert alert-warning">Failed to generate plan. Please try again.</div>';

        // Save generated plan to database
        $stmt = $pdo->prepare("INSERT INTO curriculum_plans (class, subject, topic, subtopic, plan, created_by, created_at) 
                              VALUES (:class, :subject, :topic, :subtopic, :plan, :user_id, NOW())");
        $stmt->bindParam(':class', $class, PDO::PARAM_STR);
        $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindParam(':topic', $topic, PDO::PARAM_STR);
        $stmt->bindParam(':subtopic', $subtopic, PDO::PARAM_STR);
        $stmt->bindParam(':plan', $plan, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $plan_id = $pdo->lastInsertId();

        curl_close($curl);
    }
} catch (Exception $e) {
    $plan = '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Lesson Plan - <?= htmlspecialchars("$subject: $topic") ?></title>
  <!-- CSS Files -->
  <link rel="stylesheet" href="../css/simplebar.css">
  <link href="../overpass-font.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/feather.css">
  <link rel="stylesheet" href="../css/select2.css">
  <link rel="stylesheet" href="../css/quill.snow.css">
  <link rel="stylesheet" href="../css/app-light.css" id="lightTheme">
  <style>
    .card {
      border-radius: 8px;
    }
    .alert-auto-close {
      animation: fadeOut 5s forwards;
      animation-delay: 3s;
    }
    @keyframes fadeOut {
      to { opacity: 0; display: none; }
    }
    .plan-container {
      min-height: 500px;
      border: 1px solid #dee2e6;
      border-radius: 4px;
      padding: 20px;
      background: white;
    }
    .plan-container table {
      width: 100%;
      border-collapse: collapse;
      margin: 15px 0;
    }
    .plan-container table, .plan-container th, .plan-container td {
      border: 1px solid #dee2e6;
    }
    .plan-container th, .plan-container td {
      padding: 10px;
      text-align: left;
    }
    .plan-container th {
      background-color: #f8f9fa;
    }
    #editor {
      height: 500px;
    }
  </style>
</head>

<body class="vertical light">
  <div class="wrapper">
    <!-- Your existing header/navigation code remains the same -->
   <?php include('./lms-header.php'); ?>
    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12">
            <h2 class="page-title">Lesson Plan Generator</h2>
            
            <?php if ($is_new_generation): ?>
            <div class="alert alert-success alert-auto-close">
              <i class="fe fe-check-circle mr-2"></i> New curriculum plan generated successfully!
            </div>
            <?php endif; ?>

            <div class="row mb-4">
              <div class="col-md-12">
                <div class="card shadow">
                  <div class="card-header">
                    <h4 class="card-title mb-0">
                      <?= htmlspecialchars("$subject - $topic - $subtopic") ?>
                      <span class="badge badge-primary float-right"><?= htmlspecialchars($class) ?></span>
                    </h4>
                  </div>
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <button id="regenerateBtn" class="btn btn-outline-secondary">
                          <i class="fe fe-refresh-cw mr-2"></i>Regenerate Plan
                        </button>
                      </div>
                      <div class="col-md-6 text-right">
                        <button id="exportPdfBtn" class="btn btn-outline-danger mr-2">
                          <i class="fe fe-download mr-2"></i>Export PDF
                        </button>
                        <button id="exportDocBtn" class="btn btn-outline-primary">
                          <i class="fe fe-download mr-2"></i>Export Word
                        </button>
                      </div>
                    </div>
                    
                    <!-- Editor container -->
                    <div id="editor" class="plan-container">
                      <?= $plan ?>
                    </div>
                    
                    <div class="row mt-3">
                      <div class="col-md-6">
                        <button id="saveDraftBtn" class="btn btn-outline-primary">
                          <i class="fe fe-save mr-2"></i>Save Draft
                        </button>
                      </div>
                      <div class="col-md-6 text-right">
                        <button id="saveFinalBtn" class="btn btn-primary">
                          <i class="fe fe-check-circle mr-2"></i>Save Final Version
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Scripts -->
  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/quill.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
  
  <script>
    // Initialize Quill editor
    var quill = new Quill('#editor', {
      modules: {
        toolbar: [
          [{ 'header': [1, 2, 3, false] }],
          ['bold', 'italic', 'underline'],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          ['link', 'image'],
          ['clean']
        ]
      },
      theme: 'snow'
    });

    // Set the initial content
    quill.clipboard.dangerouslyPasteHTML(`<?= addslashes($plan) ?>`);

    // Save draft functionality
    $('#saveDraftBtn').click(function() {
      savePlan('draft');
    });

    // Save final version functionality
    $('#saveFinalBtn').click(function() {
      savePlan('final');
    });

    // Regenerate plan functionality
    $('#regenerateBtn').click(function() {
      if(confirm('Are you sure you want to regenerate this plan? Your current edits will be lost.')) {
        regeneratePlan();
      }
    });

    // Export to PDF
    $('#exportPdfBtn').click(function() {
      exportToPDF();
    });

    // Export to Word
    $('#exportDocBtn').click(function() {
      exportToWord();
    });

    function savePlan(status) {
    var content = quill.root.innerHTML;
    var plainText = quill.getText();
    
    if(plainText.trim().length < 50) {
        alert('Please add more content before saving. The plan seems too short.');
        return;
    }
    
    // Show loading state
    var $saveBtn = status === 'draft' ? $('#saveDraftBtn') : $('#saveFinalBtn');
    $saveBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

    $.ajax({
        url: 'save_curriculum_plan.php',
        type: 'POST',
        dataType: 'json', // Explicitly expect JSON
        data: {
            plan_id: <?= $plan_id ? $plan_id : 'null' ?>,
            class: '<?= $class ?>',
            subject: '<?= $subject ?>',
            topic: '<?= $topic ?>',
            subtopic: '<?= $subtopic ?>',
            content: content,
            status: status
        },
        success: function(data) {
            if (data.success) {
                alert(data.message);
                if (data.plan_id && <?= $plan_id ? 'false' : 'true' ?>) {
                    // Update the URL with the new plan_id if this was a new save
                    window.location.search += '&saved=1&plan_id=' + data.plan_id;
                }
            } else {
                alert('Error: ' + (data.message || 'Unknown error occurred'));
            }
        },
        error: function(xhr, status, error) {
            try {
                // Try to parse the response if it's JSON
                var response = JSON.parse(xhr.responseText);
                alert('Error: ' + (response.message || error));
            } catch(e) {
                // If not JSON, show raw response for debugging
                console.error('Full error response:', xhr.responseText);
                alert('Error saving plan. Please check console for details.');
            }
        },
        complete: function() {
            // Reset button states
            $('#saveDraftBtn').html('<i class="fe fe-save mr-2"></i>Save Draft');
            $('#saveFinalBtn').html('<i class="fe fe-check-circle mr-2"></i>Save Final Version');
            $saveBtn.prop('disabled', false);
        }
    });
}

    function regeneratePlan() {
    $.ajax({
        url: 'regenerate_curriculum_plan.php',
        type: 'POST',
        dataType: 'json', // Explicitly expect JSON
        data: {
            class: '<?= $class ?>',
            subject: '<?= $subject ?>',
            topic: '<?= $topic ?>',
            subtopic: '<?= $subtopic ?>',
            current_content: quill.root.innerHTML
        },
        beforeSend: function() {
            $('#regenerateBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Regenerating...');
        },
        success: function(data) {
            if (data.success) {
                quill.setContents([]); // Clear editor
                quill.clipboard.dangerouslyPasteHTML(data.new_plan);
                alert(data.message);
            } else {
                alert('Error: ' + data.message);
            }
        },
        error: function(xhr, status, error) {
            try {
                // Try to parse the response if it's JSON
                var response = JSON.parse(xhr.responseText);
                alert('Error: ' + (response.message || error));
            } catch(e) {
                // If not JSON, show raw response for debugging
                console.error(xhr.responseText);
                alert('Error regenerating plan. Please check console for details.');
            }
        },
        complete: function() {
            $('#regenerateBtn').html('<i class="fe fe-refresh-cw mr-2"></i>Regenerate Plan').prop('disabled', false);
        }
    });
}

    function exportToPDF() {
      const { jsPDF } = window.jspdf;
      
      // Get the HTML content
      const content = quill.root.innerHTML;
      
      // Create a temporary div for PDF generation
      const tempDiv = document.createElement('div');
      tempDiv.style.padding = '20px';
      tempDiv.style.width = '800px';
      tempDiv.innerHTML = `
        <h1 style="text-align:center"><?= $subject ?> Lesson Plan</h1>
        <h3 style="text-align:center"><?= $topic ?> - <?= $subtopic ?></h3>
        <p><strong>Class:</strong> <?= $class ?></p>
        <p><strong>Date:</strong> ${new Date().toLocaleDateString()}</p>
        <hr>
        ${content}
      `;
      
      document.body.appendChild(tempDiv);
      
      html2canvas(tempDiv, {
        scale: 2,
        logging: true,
        useCORS: true
      }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('p', 'mm', 'a4');
        const imgWidth = 190;
        const imgHeight = canvas.height * imgWidth / canvas.width;
        
        pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
        pdf.save('LessonPlan_<?= $subject ?>_<?= $topic ?>.pdf');
        
        document.body.removeChild(tempDiv);
      });
    }

    function exportToWord() {
      const content = quill.root.innerHTML;
      const blob = new Blob([`
        <html>
        <head>
          <meta charset="UTF-8">
          <title><?= $subject ?> Lesson Plan</title>
          <style>
            body { font-family: Arial, sans-serif; margin: 2cm; }
            h1, h2, h3 { color: #2c3e50; }
            table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
            table, th, td { border: 1px solid #ddd; }
            th, td { padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
          </style>
        </head>
        <body>
          <h1><?= $subject ?> Lesson Plan</h1>
          <h3><?= $topic ?> - <?= $subtopic ?></h3>
          <p><strong>Class:</strong> <?= $class ?></p>
          <p><strong>Date:</strong> ${new Date().toLocaleDateString()}</p>
          <hr>
          ${content}
        </body>
        </html>
      `], { type: 'application/msword' });
      
      saveAs(blob, 'LessonPlan_<?= $subject ?>_<?= $topic ?>.doc');
    }

    // Show success message if redirected after save
    <?php if(isset($_GET['saved'])): ?>
      setTimeout(() => {
        alert('Curriculum plan saved successfully!');
      }, 500);
    <?php endif; ?>
  </script>
</body>
</html>
<?php include('./lms-footer.php'); ?>