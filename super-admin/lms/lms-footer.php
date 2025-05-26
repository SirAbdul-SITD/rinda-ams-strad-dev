<!-- Modal Notifications -->
<div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog"
    aria-labelledby="defaultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="defaultModalLabel">Notifications</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="list-group list-group-flush my-n3">
            <div class="list-group-item bg-transparent">
              <div class="row align-items-center">
                <div class="col text-center">
                  <small><strong>You're well up to date</strong></small>
                  <div class="my-0 text-muted small">No notifications available</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" disabled>Clear All</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Shortcut -->
  <div class="modal fade modal-shortcut modal-slide" tabindex="-1" role="dialog"
    aria-labelledby="defaultModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="defaultModalLabel">Control Panel</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body px-5">
          <div class="row align-items-center">
            <div class="col-6 text-center">
              <div class="squircle bg-success justify-content-center">
                <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
              </div>
              <p class="text-success">Dashboard</p>
            </div>
            <div class="col-6 text-center con-item">
              <a href="../academiics/" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-user-plus fe-32 align-self-center text-white"></i>
                </div>
                <p class="text-secondary control-panel-text">Academics</p>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-6 text-center con-item">
              <a href="../lms" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-trello fe-32 align-self-center text-white"></i>
                </div>
                <p class="text-secondary control-panel-text">E-Learning</p>
              </a>
            </div>
            <div class="col-6 text-center con-item">
              <a href="../messages" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-mail fe-32 align-self-center text-white"></i>
                </div>
                <p class="text-secondary control-panel-text">Messages</p>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-6 text-center con-item">
              <a href="../shop" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-shopping-bag fe-32 align-self-center text-white"></i>
                </div>
                <p class="text-secondary control-panel-text">Shop</p>
              </a>
            </div>
            <div class="col-6 text-center con-item">
              <a href="../hr/" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center text-white">
                  <i class="fe fe-users fe-32 align-self-center"></i>
                </div>
                <p class="text-secondary control-panel-text">HR</p>
              </a>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-6 text-center con-item">
              <a href="../assessments" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-check-circle fe-32 align-self-center text-white"></i>
                </div>
                <p class="text-secondary control-panel-text">Assessments</p>
              </a>
            </div>
            <div class="col-6 text-center">
              <a href="#" style="text-decoration: none;">
                <div class="squircle bg-secondary justify-content-center">
                  <i class="fe fe-settings fe-32 align-self-center text-muted"></i>
                </div>
                <p class="text-muted">Settings</p>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- 
  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script> -->
  <script src="../js/moment.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/simplebar.min.js"></script>
  <script src="../js/daterangepicker.js"></script>
  <script src="../js/jquery.stickOnScroll.js"></script>
  <script src="../js/tinycolor-min.js"></script>
  <script src="../js/config.js"></script>
  <script src="../js/chart.min.js"></script>
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap4.min.js"></script>
  <script src="../js/apps.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
// Get the video and audio data from PHP
const videoData = <?php echo json_encode($video_data); ?>;
const audioData = <?php echo json_encode($audio_data); ?>;

// Extract the dates, views, and plays for the chart
const labels = videoData.map(item => item.date);
const videoViews = videoData.map(item => item.total_views);
const audioPlays = audioData.map(item => item.total_plays);

// Create the chart
const ctx = document.getElementById('activityChart').getContext('2d');
const activityChart = new Chart(ctx, {
  type: 'line', // You can change this to 'bar', 'pie', etc.
  data: {
    labels: labels, // Dates
    datasets: [{
        label: 'Video Views',
        data: videoViews, // Video views data
        borderColor: 'rgba(75, 192, 192, 1)',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        fill: true,
        tension: 0.4
      },
      {
        label: 'Audio Plays',
        data: audioPlays, // Audio plays data
        borderColor: 'rgba(153, 102, 255, 1)',
        backgroundColor: 'rgba(153, 102, 255, 0.2)',
        fill: true,
        tension: 0.4
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: {
        beginAtZero: true
      }
    },
    plugins: {
      legend: {
        position: 'top',
      },
      tooltip: {
        mode: 'index',
        intersect: false,
      }
    }
  }
});
</script>

  <script>
    // Video/Audio Activity Chart
    document.addEventListener("DOMContentLoaded", function() {
      var ctx = document.getElementById('activityChart').getContext('2d');
      
      // Fetch data via AJAX
      $.ajax({
        url: 'get-content-stats.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
          var activityChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: data.labels,
              datasets: [
                {
                  label: 'Video Views',
                  data: data.video_views,
                  backgroundColor: 'rgba(54, 162, 235, 0.7)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1
                },
                {
                  label: 'Audio Plays',
                  data: data.audio_plays,
                  backgroundColor: 'rgba(255, 159, 64, 0.7)',
                  borderColor: 'rgba(255, 159, 64, 1)',
                  borderWidth: 1
                }
              ]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                y: {
                  beginAtZero: true,
                  ticks: {
                    callback: function(value) {
                      return value;
                    }
                  }
                }
              },
              plugins: {
                legend: {
                  position: 'top',
                },
                tooltip: {
                  mode: 'index',
                  intersect: false,
                }
              },
              interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
              }
            }
          });
        },
        error: function() {
          // Fallback data if AJAX fails
          var fallbackData = {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            video_views: [120, 190, 150, 220],
            audio_plays: [80, 110, 95, 130]
          };
          
          var activityChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: fallbackData.labels,
              datasets: [
                {
                  label: 'Video Views',
                  data: fallbackData.video_views,
                  backgroundColor: 'rgba(54, 162, 235, 0.7)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1
                },
                {
                  label: 'Audio Plays',
                  data: fallbackData.audio_plays,
                  backgroundColor: 'rgba(255, 159, 64, 0.7)',
                  borderColor: 'rgba(255, 159, 64, 1)',
                  borderWidth: 1
                }
              ]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                y: {
                  beginAtZero: true,
                  ticks: {
                    callback: function(value) {
                     
                  return value;
                }
              }
            }
          },
          plugins: {
            legend: {
              position: 'top',
            },
            tooltip: {
              mode: 'index',
              intersect: false,
            }
          },
          interaction: {
            mode: 'nearest',
            axis: 'x',
            intersect: false
          }
        }
      });
      
   
    });
  </script>
</body>
</html>