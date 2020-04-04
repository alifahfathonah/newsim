      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">History Login<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover history_login" width="100%">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Time</th>
                        <th>IP</th>
                        <th>Browser</th>
                        <th>Platform</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($data as $d) {
                        $tmp      = explode(' ', $d->tanggal_login);
                        $tanggal  = $tmp[0];
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= tanggalInggris($tanggal) . ' ' . $tmp[1] ?></td>
                          <td><?= $d->ip ?></td>
                          <td><?= $d->browser ?></td>
                          <td><?= $d->platform ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        function hapus_inventaris(id) {
          $.ajax({
            url: '<?= base_url('StockLists/ajaxNamaStockList') ?>',
            method: 'post',
            data: {
              id: id
            },
            success: function(response) {
              swal({
                title: 'Are you sure?',
                text: 'Do you want to delete "' + response + '"',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                closeOnConfirm: false
              }, function() {
                swal({
                  title: 'Deleted!',
                  text: 'Your stock list has been deleted',
                  timer: 1500,
                  type: 'success',
                  showConfirmButton: false
                }, function() {
                  window.location.href = '<?= base_url('StockLists/DeleteStockList/') ?>' + id;
                });
              });
            }
          });
        }
      </script>