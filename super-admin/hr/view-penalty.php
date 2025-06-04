<?php
require_once '../settings.php';

// Validate penalty ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid penalty ID');
}

$penalty_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

try {
    // Fetch penalty details with staff and department information
    $query = "SELECT p.*, s.first_name, s.last_name, s.email, d.department 
              FROM penalties p 
              JOIN staffs s ON p.staff_id = s.id 
              LEFT JOIN departments d ON s.department_id = d.id 
              WHERE p.id = ?";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$penalty_id]);
    $penalty = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$penalty) {
        die('Penalty not found');
    }
} catch (PDOException $e) {
    die('Error fetching penalty details: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>View Penalty | Rinda AMS</title>
    <link rel="stylesheet" href="../css/simplebar.css">
    <link href="overpass-font.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/feather.css">
    <link rel="stylesheet" href="../css/app-light.css" id="lightTheme">
    <style>
        .card {
            border-radius: 8px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-active {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        .status-pending {
            background-color: #fff3e0;
            color: #ef6c00;
        }
        .status-resolved {
            background-color: #e3f2fd;
            color: #1565c0;
        }
    </style>
</head>
<body class="vertical light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Penalty Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted">Employee</h6>
                                <p class="mb-0"><?= htmlspecialchars($penalty['first_name'] . ' ' . $penalty['last_name']) ?></p>
                                <small class="text-muted"><?= htmlspecialchars($penalty['email']) ?></small>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Department</h6>
                                <p class="mb-0"><?= htmlspecialchars($penalty['department'] ?? 'N/A') ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted">Penalty Type</h6>
                                <p class="mb-0"><?= ucfirst(htmlspecialchars($penalty['type'])) ?></p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Amount</h6>
                                <p class="mb-0">$<?= number_format($penalty['amount'], 2) ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted">Date</h6>
                                <p class="mb-0"><?= date('F d, Y', strtotime($penalty['date'])) ?></p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Status</h6>
                                <span class="status-badge status-<?= $penalty['status'] ?>">
                                    <?= ucfirst($penalty['status']) ?>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-muted">Description</h6>
                                <p class="mb-0"><?= nl2br(htmlspecialchars($penalty['description'])) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary" onclick="window.close()">Close</button>
                        <?php if ($penalty['status'] === 'pending'): ?>
                        <button type="button" class="btn btn-success" onclick="resolvePenalty(<?= $penalty_id ?>)">Resolve Penalty</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script>
        function resolvePenalty(id) {
            if (confirm('Are you sure you want to resolve this penalty?')) {
                $.ajax({
                    url: 'resolve-penalty.php',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Error resolving penalty');
                    }
                });
            }
        }
    </script>
</body>
</html> 