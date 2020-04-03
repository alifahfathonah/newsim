      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Stock Lists<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <?php
            if (flashdata('msg')) {
              echo flashdata('msg');
            }
            ?>
            <div class="row">
              <div class="col-md-2 col-sm-2" style="margin-bottom: 5px">
                <a href="<?= base_url('StockLists/AddStockList') ?>">
                  <button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Stock List</button>
                </a>
              </div>
              <div class="col-md-4 offset-md-2" style="margin-bottom: 5px">
                <select class="form-control laboratorium" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                  <option></option>
                  <option value="<?= base_url('StockLists') ?>">All Laboratory</option>
                  <?php
                  foreach ($lab as $l) {
                    echo '<option value="' . base_url('StockLists/index/' . substr(sha1($l->idLab), 6, 4)) . '">' . $l->namaLab . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover stock_lists" width="100%">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Barcode</th>
                        <th>Tools</th>
                        <th>Laboratory</th>
                        <th>Qty</th>
                        <th>Condition</th>
                        <th>Specification</th>
                        <th width="10%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
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