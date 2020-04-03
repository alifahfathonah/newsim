      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Research Laboratory<br>School of Applied Science School's Laboratory</h2>
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
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahLab"><i class="fa fa-plus"></i> Add Research Laboratory</button>
                <div class="modal inmodal fade" id="tambahLab" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Add Practicum Laboratory</h4>
                      </div>
                      <form method="post" action="<?= base_url('Laboratory/SaveResearchLaboratory') ?>" enctype="multipart/form-data">
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">Name Laboratory</label>
                                <input type="text" name="nama_lab" id="nama_lab" class="form-control" placeholder="Example: Database, Data Mining, Accounting" required>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">PIC</label>
                                <input type="text" name="pic_lab" id="pic_lab" class="form-control" placeholder="Input PIC Name" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">Room</label>
                                <input type="text" name="kode_ruang" id="kode_ruang" class="form-control" placeholder="Example: B1, B2, B5" required>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">Picture</label>
                                <div class="custom-file">
                                  <input type="file" name="foto_lab" id="foto_lab" class="custom-file-input" accept="image/*">
                                  <label for="logo" class="custom-file-label">Choose file...</label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">Location</label>
                                <div class="row">
                                  <div class="col-md-2 col-sm-6">
                                    <div class="i-checks">
                                      <label>
                                        <input type="radio" name="lokasi_lab" id="lokasi_lab" value="Lantai 1" required> <i></i> Lantai 1
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-2 col-sm-6">
                                    <div class="i-checks">
                                      <label>
                                        <input type="radio" name="lokasi_lab" id="lokasi_lab" value="Lantai 2" required> <i></i> Lantai 2
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-2 col-sm-6">
                                    <div class="i-checks">
                                      <label>
                                        <input type="radio" name="lokasi_lab" id="lokasi_lab" value="Lantai 3" required> <i></i> Lantai 3
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-2 col-sm-6">
                                    <div class="i-checks">
                                      <label>
                                        <input type="radio" name="lokasi_lab" id="lokasi_lab" value="Lantai 4" required> <i></i> Lantai 4
                                      </label>
                                    </div>
                                  </div>
                                </div>
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
                        <th>Laboratory</th>
                        <th>Location</th>
                        <th>Room</th>
                        <th>PIC</th>
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
                          <td>
                            <a href="<?= base_url('Laboratory/ViewLaboratory/' . substr(sha1($d->idLab), 6, 4)) ?>" style="color: #333"><?= $d->namaLab ?></a>
                          </td>
                          <td><?= $d->lokasiLab ?></td>
                          <td><?= $d->kodeRuang ?></td>
                          <td><?= $d->pembinaLab ?></td>
                          <td style="text-align: center">
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editLab<?= $d->idLab ?>"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="hapus_lab(<?= $d->idLab ?>)"><i class="fa fa-trash"></i></button>
                          </td>
                        </tr>
                        <div class="modal inmodal fade" id="editLab<?= $d->idLab ?>" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Edit Practicum Laboratory</h4>
                              </div>
                              <form method="post" action="<?= base_url('Laboratory/EditResearchLaboratory') ?>" enctype="multipart/form-data">
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                      <div class="form-group">
                                        <label class="font-bold">Name Laboratory</label>
                                        <input type="text" name="id_lab" id="id_lab" value="<?= $d->idLab ?>" style="display: none">
                                        <input type="text" name="nama_lab" id="nama_lab" class="form-control" placeholder="Example: Database, Data Mining, Accounting" value="<?= $d->namaLab ?>" required>
                                      </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                      <div class="form-group">
                                        <label class="font-bold">PIC</label>
                                        <input type="text" name="pic_lab" id="pic_lab" class="form-control" placeholder="Input PIC Name" value="<?= $d->pembinaLab ?>" required>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                      <div class="form-group">
                                        <label class="font-bold">Room</label>
                                        <input type="text" name="kode_ruang" id="kode_ruang" class="form-control" placeholder="Example: B1, B2, B5" value="<?= $d->kodeRuang ?>" required>
                                      </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                      <div class="form-group">
                                        <label class="font-bold">Picture</label>
                                        <div class="custom-file">
                                          <input type="file" name="foto_lab" id="foto_lab" class="custom-file-input" accept="image/*">
                                          <label for="logo" class="custom-file-label">Choose file...</label>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                      <div class="form-group">
                                        <label class="font-bold">Location</label>
                                        <div class="row">
                                          <div class="col-md-2 col-sm-6">
                                            <div class="i-checks">
                                              <label>
                                                <input type="radio" name="lokasi_lab" id="lokasi_lab" value="Lantai 1" <?php if ($d->lokasiLab == 'Lantai 1') echo 'checked'; ?> required> <i></i> Lantai 1
                                              </label>
                                            </div>
                                          </div>
                                          <div class="col-md-2 col-sm-6">
                                            <div class="i-checks">
                                              <label>
                                                <input type="radio" name="lokasi_lab" id="lokasi_lab" value="Lantai 2" <?php if ($d->lokasiLab == 'Lantai 2') echo 'checked'; ?> required> <i></i> Lantai 2
                                              </label>
                                            </div>
                                          </div>
                                          <div class="col-md-2 col-sm-6">
                                            <div class="i-checks">
                                              <label>
                                                <input type="radio" name="lokasi_lab" id="lokasi_lab" value="Lantai 3" <?php if ($d->lokasiLab == 'Lantai 3') echo 'checked'; ?> required> <i></i> Lantai 3
                                              </label>
                                            </div>
                                          </div>
                                          <div class="col-md-2 col-sm-6">
                                            <div class="i-checks">
                                              <label>
                                                <input type="radio" name="lokasi_lab" id="lokasi_lab" value="Lantai 4" <?php if ($d->lokasiLab == 'Lantai 4') echo 'checked'; ?> required> <i></i> Lantai 4
                                              </label>
                                            </div>
                                          </div>
                                        </div>
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
        function hapus_lab(id) {
          $.ajax({
            url: '<?= base_url('Laboratory/ajaxNamaLab') ?>',
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
                  text: response + ' Laboratory been deleted',
                  timer: 1500,
                  type: 'success',
                  showConfirmButton: false
                }, function() {
                  window.location.href = '<?= base_url('Laboratory/DeleteLaboratory/') ?>' + id;
                });
              });
            }
          });
        }
      </script>