</main> <!-- main -->
    </div> <!-- .wrapper -->

    <!-- new Modal-->
    <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="newModalLabel">Filter Invoices</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="newForm" method="post" action="">
            <div class="modal-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <?php
                    $sessionsQuery = "SELECT DISTINCT session FROM fees_invoices ORDER BY session DESC";
                    $sessionsStmt = $pdo->prepare($sessionsQuery);
                    $sessionsStmt->execute();
                    $sessions = $sessionsStmt->fetchAll(PDO::FETCH_COLUMN);
                    ?>
                  <label for="session">Academic Year</label>
                  <select class="custom-select" id="session" name="session" required>
                    <option selected disabled>Select</option>
                    <?php foreach ($sessions as $sess): ?>
                      <option value="<?= $sess ?>"><?= $sess ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label for="term">Term</label>
                  <select class="custom-select" id="term" name="term" required>
                    <option selected value="4">Full Year</option>
                    <option value="1">First Term</option>
                    <option value="2">Second Term</option>
                    <option value="3">Third Term</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn mb-2 btn-primary w-100">Filter</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/moment.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/simplebar.min.js"></script>
    <script src='../js/daterangepicker.js'></script>
    <script src='../js/jquery.stickOnScroll.js'></script>
    <script src="../js/tinycolor-min.js"></script>
    <script src="../js/config.js"></script>
    <script src='../js/jquery.dataTables.min.js'></script>
    <script src='../js/dataTables.bootstrap4.min.js'></script>
    <script>
      $('#dataTable-1').DataTable({
        autoWidth: true,
        "lengthMenu": [
          [16, 32, 64, -1],
          [16, 32, 64, "All"]
        ]
      });
    </script>
    <script src="../js/apps.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'UA-56159088-1');
    </script>
  </body>
</html>