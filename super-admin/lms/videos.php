<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../settings.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function debug_log($message) {
    file_put_contents('video_debug.log', date('[Y-m-d H:i:s] ') . $message . PHP_EOL, FILE_APPEND);
}

// Extract YouTube video ID
function getYouTubeVideoId($url) {
    $parts = parse_url($url);
    if (!isset($parts['host'])) return null;

    $host = $parts['host'];
    $path = $parts['path'] ?? '';
    $query = $parts['query'] ?? '';

    if (strpos($host, 'youtu.be') !== false) {
        $id = ltrim($path, '/');
        return explode('?', $id)[0];
    }

    if (strpos($host, 'youtube.com') !== false) {
        if (preg_match('#/(embed|v)/([^/?]+)#', $path, $matches)) {
            return $matches[2];
        }
        parse_str($query, $query_params);
        if (isset($query_params['v'])) return $query_params['v'];
    }

    return null;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['action'])) {
            $user_id = $_SESSION['user_id'] ?? null;

            if ($_POST['action'] === 'add_video') {
                if (empty($_POST['title'])) throw new Exception("Title is required");
                if (empty($_POST['youtube_url'])) throw new Exception("YouTube URL is required");

                $title = $_POST['title'];
                $youtube_url = $_POST['youtube_url'];
                $video_id = getYouTubeVideoId($youtube_url);

                if (!$video_id) throw new Exception("Invalid YouTube URL format");

                $thumbnail = "https://img.youtube.com/vi/$video_id/maxresdefault.jpg";
                $status = $_POST['status'] ?? 'draft';
                $subject = $_POST['subject'] ?? null;
                $class = $_POST['class'] ?? null;
                $description = $_POST['description'] ?? null;
                $folder_id = $_POST['folder_id'] ?? null;

                // Insert into videos table
                $stmt = $pdo->prepare("INSERT INTO videos (title, youtube_url, subject, class, added_by, status, description, thumbnail, folder_id) 
                                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$title, $youtube_url, $subject, $class, $user_id, $status, $description, $thumbnail, $folder_id]);

                $video_record_id = $pdo->lastInsertId();

                // Insert into files table so it shows in file-manager
                $virtual_file_path = "https://www.youtube.com/watch?v=" . $video_id;
                $stmt = $pdo->prepare("INSERT INTO files (title, file_name, file_path, type, size, folder, uploaded_by, permission) 
                                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $title,
                    $video_id . '.youtube', // fake extension for display
                    $virtual_file_path,
                    'video',
                    0,
                    $folder_id,
                    $user_id,
                    'public'
                ]);

                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Video added successfully!'
                ];

            } elseif ($_POST['action'] === 'update_video') {
                if (empty($_POST['id']) || empty($_POST['title'])) throw new Exception("Required fields missing");

                $stmt = $pdo->prepare("UPDATE videos SET title = ?, subject = ?, class = ?, status = ?, description = ?, folder_id = ? WHERE id = ?");
                $stmt->execute([
                    $_POST['title'],
                    $_POST['subject'] ?? null,
                    $_POST['class'] ?? null,
                    $_POST['status'] ?? 'draft',
                    $_POST['description'] ?? null,
                    $_POST['folder_id'] ?? null,
                    $_POST['id']
                ]);

                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Video updated successfully!'
                ];

            } elseif ($_POST['action'] === 'delete_video') {
                if (empty($_POST['id'])) throw new Exception("Video ID missing");

                $stmt = $pdo->prepare("SELECT youtube_url FROM videos WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $video = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($video) {
                    $video_id = getYouTubeVideoId($video['youtube_url']);
                    $virtual_file_path = "https://www.youtube.com/watch?v=" . $video_id;

                    // Delete from file manager (files table)
                    $stmt = $pdo->prepare("DELETE FROM files WHERE file_path = ?");
                    $stmt->execute([$virtual_file_path]);
                }

                // Delete from videos
                $stmt = $pdo->prepare("DELETE FROM videos WHERE id = ?");
                $stmt->execute([$_POST['id']]);

                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Video deleted successfully!'
                ];
            }

            header("Location: videos.php");
            exit();

        }
    } catch (Exception $e) {
        debug_log("Error: " . $e->getMessage());
        $_SESSION['toast'] = [
            'type' => 'danger',
            'message' => $e->getMessage()
        ];
        header("Location: videos.php");
        exit();
    }
}

// Get video stats and data
try {
    $total_videos = $pdo->query("SELECT COUNT(*) FROM videos")->fetchColumn();
    $total_views = $pdo->query("SELECT SUM(views) FROM videos")->fetchColumn() ?? 0;
    $published_videos = $pdo->query("SELECT COUNT(*) FROM videos WHERE status = 'published'")->fetchColumn();

    // Get videos with folder names
    $videos = $pdo->query("
        SELECT v.*, f.name as folder_name 
        FROM videos v 
        LEFT JOIN folders f ON v.folder_id = f.id 
        ORDER BY v.created_at DESC
    ")->fetchAll(PDO::FETCH_ASSOC);
    
    $classes = $pdo->query("SELECT DISTINCT class FROM videos WHERE class IS NOT NULL ORDER BY class")->fetchAll(PDO::FETCH_COLUMN);
    $subjects = $pdo->query("SELECT DISTINCT subject FROM videos WHERE subject IS NOT NULL ORDER BY subject")->fetchAll(PDO::FETCH_COLUMN);
    
    // Get all folders for dropdowns
    $folders = $pdo->query("SELECT id, name FROM folders ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    debug_log("DB Error: " . $e->getMessage());
    $total_videos = 0;
    $total_views = 0;
    $published_videos = 0;
    $videos = [];
    $classes = [];
    $subjects = [];
    $folders = [];
}
?>

<!-- Loading spinner -->
<div class="spinner-container" id="loadingSpinner">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<!-- Navigation -->
<?php include('./lms-header.php'); ?>
<div class="wrapper">
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row align-items-center mb-4">
                        <div class="col">
                            <h2 class="h5 page-title">Video Management</h2>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addVideoModal">
                                <i class="fe fe-plus mr-2"></i>Add Video
                            </button>
                        </div>
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card shadow video-card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <p class="mb-0 text-muted">Total Videos</p>
                                            <h3 class="mb-0"><?= number_format($total_videos) ?></h3>
                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="fe fe-film fe-32 text-primary"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card shadow video-card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <p class="mb-0 text-muted">Total Views</p>
                                            <h3 class="mb-0"><?= number_format($total_views) ?></h3>
                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="fe fe-eye fe-32 text-warning"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card shadow video-card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <p class="mb-0 text-muted">Published</p>
                                            <h3 class="mb-0"><?= number_format($published_videos) ?></h3>
                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="fe fe-check-circle fe-32 text-success"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Videos Table -->
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="card shadow">
                                <div class="card-header">
                                    <strong class="card-title">Videos</strong>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($videos)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="videoTable">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Subject</th>
                                                        <th>Class</th>
                                                        <th>Folder</th>
                                                        <th>Views</th>
                                                        <th>Status</th>
                                                        <th>Added</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($videos as $video): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="video-thumbnail mr-3" style="background-image: url('<?= htmlspecialchars($video['thumbnail']) ?>'); width: 120px;">
                                                                        <i class="fe fe-play text-white" style="font-size: 2rem; display: flex; height: 100%; align-items: center; justify-content: center; background: rgba(0,0,0,0.3);"></i>
                                                                    </div>
                                                                    <div>
                                                                        <strong><?= htmlspecialchars($video['title']) ?></strong>
                                                                        <?php if (!empty($video['description'])): ?>
                                                                            <p class="text-muted small mb-0"><?= htmlspecialchars(substr($video['description'], 0, 50)) ?>...</p>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><?= htmlspecialchars($video['subject'] ?? 'N/A') ?></td>
                                                            <td><?= htmlspecialchars($video['class'] ?? 'N/A') ?></td>
                                                            <td><?= htmlspecialchars($video['folder_name'] ?? 'N/A') ?></td>
                                                            <td><?= number_format($video['views']) ?></td>
                                                            <td>
                                                                <span class="badge badge-<?= $video['status'] == 'published' ? 'success' : 'secondary' ?>">
                                                                    <?= ucfirst($video['status']) ?>
                                                                </span>
                                                            </td>
                                                            <td><?= date('M j, Y', strtotime($video['created_at'])) ?></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-outline-primary play-video" 
                                                                    data-youtube="<?= htmlspecialchars($video['youtube_url']) ?>"
                                                                    data-title="<?= htmlspecialchars($video['title']) ?>"
                                                                    data-id="<?= $video['id'] ?>">
                                                                    <i class="fe fe-play"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-outline-secondary edit-video" 
                                                                    data-id="<?= $video['id'] ?>"
                                                                    data-title="<?= htmlspecialchars($video['title']) ?>"
                                                                    data-subject="<?= htmlspecialchars($video['subject'] ?? '') ?>"
                                                                    data-class="<?= htmlspecialchars($video['class'] ?? '') ?>"
                                                                    data-status="<?= $video['status'] ?>"
                                                                    data-description="<?= htmlspecialchars($video['description'] ?? '') ?>"
                                                                    data-youtube="<?= htmlspecialchars($video['youtube_url']) ?>"
                                                                    data-folder_id="<?= $video['folder_id'] ?? '' ?>">
                                                                    <i class="fe fe-edit-2"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-outline-danger delete-video" 
                                                                    data-id="<?= $video['id'] ?>"
                                                                    data-title="<?= htmlspecialchars($video['title']) ?>">
                                                                    <i class="fe fe-trash-2"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            No videos found. Add your first video using the button above.
                                        </div>
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

<!-- Add Video Modal -->
<div class="modal fade" id="addVideoModal" tabindex="-1" role="dialog" aria-labelledby="addVideoModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVideoModalLabel">Add New Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addVideoForm" method="post">
                <input type="hidden" name="action" value="add_video">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="videoTitle">Title *</label>
                                <input type="text" class="form-control" id="videoTitle" name="title" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="videoYoutube">YouTube URL *</label>
                                <input type="url" class="form-control" id="videoYoutube" name="youtube_url" 
                                    placeholder="https://www.youtube.com/watch?v=..." required>
                                <small class="text-muted">Paste the full YouTube URL</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="videoFolder">Folder</label>
                                <select class="form-control" id="videoFolder" name="folder_id">
                                    <option value="">-- Select Folder --</option>
                                    <?php foreach ($folders as $folder): ?>
                                        <option value="<?= $folder['id'] ?>"><?= htmlspecialchars($folder['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="videoSubject">Subject</label>
                                <input type="text" class="form-control" id="videoSubject" name="subject" list="subjectList">
                                <datalist id="subjectList">
                                    <?php foreach ($subjects as $subject): ?>
                                        <option value="<?= htmlspecialchars($subject) ?>">
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="videoClass">Class</label>
                                <input type="text" class="form-control" id="videoClass" name="class" list="classList">
                                <datalist id="classList">
                                    <?php foreach ($classes as $class): ?>
                                        <option value="<?= htmlspecialchars($class) ?>">
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            
                            <div class="form-group">
                                <label for="videoStatus">Status</label>
                                <select class="form-control" id="videoStatus" name="status">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="videoDescription">Description</label>
                                <textarea class="form-control" id="videoDescription" name="description" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="submit-btn-text">Add Video</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Video Modal -->
<div class="modal fade" id="editVideoModal" tabindex="-1" role="dialog" aria-labelledby="editVideoModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVideoModalLabel">Edit Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editVideoForm" method="post">
                <input type="hidden" name="action" value="update_video">
                <input type="hidden" name="id" id="editVideoId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editVideoTitle">Title *</label>
                                <input type="text" class="form-control" id="editVideoTitle" name="title" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="editVideoYoutube">YouTube URL</label>
                                <input type="url" class="form-control" id="editVideoYoutube" name="youtube_url" readonly>
                                <small class="text-muted">YouTube URL cannot be changed</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="editVideoFolder">Folder</label>
                                <select class="form-control" id="editVideoFolder" name="folder_id">
                                    <option value="">-- Select Folder --</option>
                                    <?php foreach ($folders as $folder): ?>
                                        <option value="<?= $folder['id'] ?>"><?= htmlspecialchars($folder['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="editVideoSubject">Subject</label>
                                <input type="text" class="form-control" id="editVideoSubject" name="subject" list="subjectList">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editVideoClass">Class</label>
                                <input type="text" class="form-control" id="editVideoClass" name="class" list="classList">
                            </div>
                            
                            <div class="form-group">
                                <label for="editVideoStatus">Status</label>
                                <select class="form-control" id="editVideoStatus" name="status">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="editVideoDescription">Description</label>
                                <textarea class="form-control" id="editVideoDescription" name="description" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="submit-btn-text">Save Changes</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Video Modal -->
<div class="modal fade" id="deleteVideoModal" tabindex="-1" role="dialog" aria-labelledby="deleteVideoModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteVideoModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteVideoForm" method="post">
                <input type="hidden" name="action" value="delete_video">
                <input type="hidden" name="id" id="deleteVideoId">
                <div class="modal-body">
                    <p>Are you sure you want to delete the video "<strong id="deleteVideoTitle"></strong>"?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <span class="submit-btn-text">Delete Permanently</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Video Player Modal -->
<div class="modal fade" id="videoPlayerModal" tabindex="-1" role="dialog" aria-labelledby="videoPlayerModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoPlayerModalLabel">Video Player</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="video-player-container">
                    <iframe id="youtubePlayer" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="../js/jquery.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/simplebar.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#videoTable').DataTable({
        order: [[6, 'desc']], // Updated to account for new folder column
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search videos..."
        }
    });

    // Show toast notifications
    <?php if (isset($_SESSION['toast'])): ?>
        new Noty({
            type: '<?= $_SESSION['toast']['type'] ?>',
            text: '<?= $_SESSION['toast']['message'] ?>',
            timeout: 3000,
            progressBar: true,
            layout: 'topRight'
        }).show();
        <?php unset($_SESSION['toast']); ?>
    <?php endif; ?>

    // Play video
    $(document).on('click', '.play-video', function() {
        const youtubeUrl = $(this).data('youtube');
        const videoTitle = $(this).data('title');
        const videoId = $(this).data('id');
        
        // Extract YouTube video ID
        let videoIdFromUrl = '';
        if (youtubeUrl.includes('youtube.com/watch?v=')) {
            videoIdFromUrl = youtubeUrl.split('v=')[1].split('&')[0];
        } else if (youtubeUrl.includes('youtu.be/')) {
            videoIdFromUrl = youtubeUrl.split('youtu.be/')[1].split('?')[0];
        }
        
        if (videoIdFromUrl) {
            // Update view count
            $.post('update_video_stats.php', {
                video_id: videoId,
                action: 'view'
            }).fail(function(xhr, status, error) {
                console.error('Failed to update view count:', error);
            });
            
            // Set up player
            $('#videoPlayerModalLabel').text(videoTitle);
            $('#youtubePlayer').attr('src', `https://www.youtube.com/embed/${videoIdFromUrl}?autoplay=1`);
            $('#videoPlayerModal').modal('show');
        } else {
            alert('Invalid YouTube URL');
        }
    });
    
    // Close video player when modal is hidden
    $('#videoPlayerModal').on('hidden.bs.modal', function() {
        $('#youtubePlayer').attr('src', '');
    });

    // Edit video
    $(document).on('click', '.edit-video', function() {
        $('#editVideoId').val($(this).data('id'));
        $('#editVideoTitle').val($(this).data('title'));
        $('#editVideoSubject').val($(this).data('subject'));
        $('#editVideoClass').val($(this).data('class'));
        $('#editVideoStatus').val($(this).data('status'));
        $('#editVideoDescription').val($(this).data('description'));
        $('#editVideoYoutube').val($(this).data('youtube'));
        $('#editVideoFolder').val($(this).data('folder_id'));
        
        $('#editVideoModal').modal('show');
    });

    // Delete video
    $(document).on('click', '.delete-video', function() {
        $('#deleteVideoId').val($(this).data('id'));
        $('#deleteVideoTitle').text($(this).data('title'));
        $('#deleteVideoModal').modal('show');
    });

    // Form submissions with loading states
    $('#addVideoForm, #editVideoForm, #deleteVideoForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const spinner = submitBtn.find('.spinner-border');
        const btnText = submitBtn.find('.submit-btn-text');
        
        // Show loading state
        btnText.addClass('d-none');
        spinner.removeClass('d-none');
        submitBtn.prop('disabled', true);
        $('#loadingSpinner').addClass('show');
        
        $.ajax({
            url: '',
            type: 'POST',
            data: form.serialize(),
            success: function() {
                window.location.reload();
            },
            error: function(xhr, status, error) {
                // Reset button states
                btnText.removeClass('d-none');
                spinner.addClass('d-none');
                submitBtn.prop('disabled', false);
                $('#loadingSpinner').removeClass('show');
                
                new Noty({
                    type: 'error',
                    text: 'Error: ' + error,
                    timeout: 5000,
                    progressBar: true,
                    layout: 'topRight'
                }).show();
                
                console.error('AJAX Error:', error, xhr.responseText);
            }
        });
    });
});
</script>

<?php include('./lms-footer.php'); ?>