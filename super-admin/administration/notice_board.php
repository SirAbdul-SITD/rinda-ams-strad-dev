<?php
require_once '../settings.php';

// Helper function to safely escape HTML
function safe_html($str, $default = '') {
    if ($str === null || $str === '') {
        return $default;
    }
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// Helper function to format date
function format_date($date) {
    return $date ? date('M j, Y', strtotime($date)) : '';
}

// Function to get notices for a specific user type
function getNotices($pdo, $userType) {
    try {
        $stmt = $pdo->prepare("SELECT n.*, ac.event_type, ac.start_time, ac.end_time, ac.all_day, ac.is_online, ac.meeting_link, ac.location 
                              FROM notices n 
                              LEFT JOIN academic_calendar ac ON n.event_id = ac.id 
                              WHERE n." . $userType . " = 1 
                              AND n.start_date <= CURDATE() 
                              AND (n.end_date IS NULL OR n.end_date >= CURDATE())
                              ORDER BY n.date_posted DESC");
        $stmt->execute();
        $notices = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Ensure all fields have at least empty string values
        foreach ($notices as &$notice) {
            $notice['title'] = $notice['title'] ?? '';
            $notice['content'] = $notice['content'] ?? '';
            $notice['event_type'] = $notice['event_type'] ?? '';
            $notice['start_time'] = $notice['start_time'] ?? '';
            $notice['end_time'] = $notice['end_time'] ?? '';
            $notice['meeting_link'] = $notice['meeting_link'] ?? '';
            $notice['location'] = $notice['location'] ?? '';
        }
        
        return $notices;
    } catch (PDOException $e) {
        error_log("Error fetching notices: " . $e->getMessage());
        return [];
    }
}

// Get notices for different user types
$studentNotices = getNotices($pdo, 'students');
$parentNotices = getNotices($pdo, 'parents');
$staffNotices = getNotices($pdo, 'staffs');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Notice Board</title>
    <link rel="stylesheet" href="../css/simplebar.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/feather.css">
    <link rel="stylesheet" href="../css/app-light.css" id="lightTheme">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .notice-card {
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
            margin-bottom: 1rem;
            background-color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .notice-header {
            padding: 1rem;
            border-bottom: 1px solid #e3e6f0;
            background-color: #f8f9fc;
        }
        .notice-body {
            padding: 1rem;
        }
        .notice-footer {
            padding: 0.75rem 1rem;
            border-top: 1px solid #e3e6f0;
            background-color: #f8f9fc;
            font-size: 0.875rem;
            color: #858796;
        }
        .notice-date {
            font-weight: 600;
            color: #4e73df;
        }
        .notice-type {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            margin: 0.25rem;
            background-color: #e3f2fd;
            color: #1976d2;
            border-radius: 0.25rem;
            font-size: 0.75rem;
        }
        .notice-time {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }
        .notice-location {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }
        .notice-link {
            font-size: 0.875rem;
            color: #4e73df;
            margin-top: 0.5rem;
            word-break: break-all;
        }
    </style>
</head>
<body class="vertical light">
    <div class="wrapper">
        <?php require_once('admin-header.php'); ?>
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-12 my-4">
                                <div class="row align-items-center mb-4">
                                    <div class="col">
                                        <h2 class="page-title">Notice Board</h2>
                                    </div>
                                </div>

                                <!-- Student Notices -->
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <h3 class="card-title">Student Notices</h3>
                                    </div>
                                    <div class="card-body">
                                        <?php if (empty($studentNotices)): ?>
                                            <p class="text-muted">No notices available for students.</p>
                                        <?php else: ?>
                                            <?php foreach ($studentNotices as $notice): ?>
                                                <div class="notice-card">
                                                    <div class="notice-header">
                                                        <h4 class="mb-0"><?= safe_html($notice['title'], 'Event') ?></h4>
                                                        <?php if (!empty($notice['event_type'])): ?>
                                                            <span class="notice-type"><?= safe_html(ucfirst($notice['event_type'])) ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="notice-body">
                                                        <?= nl2br(safe_html($notice['content'], 'No content available')) ?>
                                                        
                                                        <?php if (!$notice['all_day'] && !empty($notice['start_time'])): ?>
                                                            <div class="notice-time">
                                                                <i class="fe fe-clock"></i> 
                                                                <?= safe_html($notice['start_time']) ?>
                                                                <?php if (!empty($notice['end_time'])): ?>
                                                                    - <?= safe_html($notice['end_time']) ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php if ($notice['is_online'] && !empty($notice['meeting_link'])): ?>
                                                            <div class="notice-link">
                                                                <i class="fe fe-video"></i> 
                                                                <a href="<?= safe_html($notice['meeting_link']) ?>" target="_blank">
                                                                    Join Meeting
                                                                </a>
                                                            </div>
                                                        <?php elseif (!empty($notice['location'])): ?>
                                                            <div class="notice-location">
                                                                <i class="fe fe-map-pin"></i> 
                                                                <?= safe_html($notice['location']) ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="notice-footer">
                                                        <span class="notice-date">
                                                            <?= format_date($notice['start_date']) ?>
                                                            <?php if (!empty($notice['end_date'])): ?>
                                                                - <?= format_date($notice['end_date']) ?>
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Parent Notices -->
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <h3 class="card-title">Parent Notices</h3>
                                    </div>
                                    <div class="card-body">
                                        <?php if (empty($parentNotices)): ?>
                                            <p class="text-muted">No notices available for parents.</p>
                                        <?php else: ?>
                                            <?php foreach ($parentNotices as $notice): ?>
                                                <div class="notice-card">
                                                    <div class="notice-header">
                                                        <h4 class="mb-0"><?= safe_html($notice['title'], 'Event') ?></h4>
                                                        <?php if (!empty($notice['event_type'])): ?>
                                                            <span class="notice-type"><?= safe_html(ucfirst($notice['event_type'])) ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="notice-body">
                                                        <?= nl2br(safe_html($notice['content'], 'No content available')) ?>
                                                        
                                                        <?php if (!$notice['all_day'] && !empty($notice['start_time'])): ?>
                                                            <div class="notice-time">
                                                                <i class="fe fe-clock"></i> 
                                                                <?= safe_html($notice['start_time']) ?>
                                                                <?php if (!empty($notice['end_time'])): ?>
                                                                    - <?= safe_html($notice['end_time']) ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php if ($notice['is_online'] && !empty($notice['meeting_link'])): ?>
                                                            <div class="notice-link">
                                                                <i class="fe fe-video"></i> 
                                                                <a href="<?= safe_html($notice['meeting_link']) ?>" target="_blank">
                                                                    Join Meeting
                                                                </a>
                                                            </div>
                                                        <?php elseif (!empty($notice['location'])): ?>
                                                            <div class="notice-location">
                                                                <i class="fe fe-map-pin"></i> 
                                                                <?= safe_html($notice['location']) ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="notice-footer">
                                                        <span class="notice-date">
                                                            <?= format_date($notice['start_date']) ?>
                                                            <?php if (!empty($notice['end_date'])): ?>
                                                                - <?= format_date($notice['end_date']) ?>
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Staff Notices -->
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <h3 class="card-title">Staff Notices</h3>
                                    </div>
                                    <div class="card-body">
                                        <?php if (empty($staffNotices)): ?>
                                            <p class="text-muted">No notices available for staff.</p>
                                        <?php else: ?>
                                            <?php foreach ($staffNotices as $notice): ?>
                                                <div class="notice-card">
                                                    <div class="notice-header">
                                                        <h4 class="mb-0"><?= safe_html($notice['title'], 'Event') ?></h4>
                                                        <?php if (!empty($notice['event_type'])): ?>
                                                            <span class="notice-type"><?= safe_html(ucfirst($notice['event_type'])) ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="notice-body">
                                                        <?= nl2br(safe_html($notice['content'], 'No content available')) ?>
                                                        
                                                        <?php if (!$notice['all_day'] && !empty($notice['start_time'])): ?>
                                                            <div class="notice-time">
                                                                <i class="fe fe-clock"></i> 
                                                                <?= safe_html($notice['start_time']) ?>
                                                                <?php if (!empty($notice['end_time'])): ?>
                                                                    - <?= safe_html($notice['end_time']) ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php if ($notice['is_online'] && !empty($notice['meeting_link'])): ?>
                                                            <div class="notice-link">
                                                                <i class="fe fe-video"></i> 
                                                                <a href="<?= safe_html($notice['meeting_link']) ?>" target="_blank">
                                                                    Join Meeting
                                                                </a>
                                                            </div>
                                                        <?php elseif (!empty($notice['location'])): ?>
                                                            <div class="notice-location">
                                                                <i class="fe fe-map-pin"></i> 
                                                                <?= safe_html($notice['location']) ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="notice-footer">
                                                        <span class="notice-date">
                                                            <?= format_date($notice['start_date']) ?>
                                                            <?php if (!empty($notice['end_date'])): ?>
                                                                - <?= format_date($notice['end_date']) ?>
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require_once('admin-footer.php'); ?>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/simplebar.min.js"></script>
    <script src="../js/moment.min.js"></script>
    <script src="../js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
</html> 