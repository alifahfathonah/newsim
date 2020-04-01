      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Courses<br>School of Applied Science School's Laboratory</h2>
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
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahMK"><i class="fa fa-plus"></i> Add Courses</button>
                <div class="modal inmodal fade" id="tambahMK" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Add Courses</h4>
                      </div>
                      <form method="post" action="<?= base_url('Laboran/SaveCourses') ?>">
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">Courses Code</label>
                                <input type="text" name="kode_mk" id="kode_mk" class="form-control" placeholder="Example: DAH1A1, DCH1A3, DPH1E4" required>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">Courses Name</label>
                                <input type="text" name="nama_mk" id="nama_mk" class="form-control" placeholder="Input Courses Name" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">SKS</label>
                                <input type="text" name="sks_mk" id="sks_mk" class="form-control" placeholder="Input SKS Courses" onkeypress="return hanya_angka(event)" required>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover daftar_lab" width="100%">
                    <thead>
                      <tr>
                        <th width="7%">No</th>
                        <th>Code</th>
                        <th>Name Courses</th>
                        <th>SKS</th>
                        <th width="10%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($data as $d) {
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $d->kode_mk ?></td>
                          <td><?= $d->nama_mk ?></td>
                          <td><?= $d->sks ?></td>
                          <td style="text-align: center">
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editMK<?= $d->id_mk ?>"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="hapus_matakuliah(<?= $d->id_mk ?>)"><i class="fa fa-trash"></i></button>
                          </td>
                        </tr>
                        <div class="modal inmodal fade" id="editMK<?= $d->id_mk ?>" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Edit Courses</h4>
                              </div>
                              <form method="post" action="<?= base_url('Laboran/EditCourses') ?>">
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                      <div class="form-group">
                                        <label class="font-bold">Courses Code</label>
                                        <input type="text" name="id_mk" id="id_mk" value="<?= $d->id_mk ?>" style="display: none">
                                        <input type="text" name="kode_mk" id="kode_mk" class="form-control" placeholder="Example: DAH1A1, DCH1A3, DPH1E4" value="<?= $d->kode_mk ?>" required>
                                      </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                      <div class="form-group">
                                        <label class="font-bold">Courses Name</label>
                                        <input type="text" name="nama_mk" id="nama_mk" class="form-control" placeholder="Input Courses Name" value="<?= $d->nama_mk ?>" required>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                      <div class="form-group">
                                        <label class="font-bold">SKS</label>
                                        <input type="text" name="sks_mk" id="sks_mk" class="form-control" placeholder="Input SKS Courses" value="<?= $d->sks ?>" onkeypress="return hanya_angka(event)" required>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
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
        function hanya_angka(event) {
          var angka = (event.which) ? event.which : event.keyCode
          if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
            return false;
          return true;
        }

        function hapus_matakuliah(id) {
          $.ajax({
            url: '<?= base_url('Laboran/ajaxMataKuliah') ?>',
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
                  text: 'Courses been deleted',
                  timer: 1500,
                  type: 'success',
                  showConfirmButton: false
                }, function() {
                  window.location.href = '<?= base_url('Laboran/DeleteCourses/') ?>' + id;
                });
              });
            }
          });
        }
      </script>