      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Laboratory Assistant<br>School of Applied Science School's Laboratory</h2>
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
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahAslab"><i class="fa fa-plus"></i> Add Laboratory Assistant</button>
                <div class="modal inmodal fade" id="tambahAslab" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Add Laboratory Assistant</h4>
                      </div>
                      <form method="post" action="<?= base_url('Laboran/SaveLaboratoryAssistant') ?>" enctype="multipart/form-data">
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">Name</label>
                                <input type="text" name="nama_aslab" id="nama_aslab" class="form-control" placeholder="Input Name Assistant" required>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">NIM</label>
                                <input type="text" name="nim_aslab" id="nim_aslab" class="form-control" placeholder="Input NIM Assistant" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">Phone</label>
                                <input type="text" name="telp_aslab" id="telp_aslab" class="form-control" placeholder="Input Phone Number" required>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">Photo</label>
                                <div class="custom-file">
                                  <input type="file" name="foto_aslab" id="foto_aslab" class="custom-file-input">
                                  <label for="logo" class="custom-file-label">Choose file...</label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">Laboratory</label>
                                <select name="pj_lab[]" id="pj_lab" class="form-control laboratorium" multiple>
                                  <option></option>
                                  <?php
                                  foreach ($lab as $l) {
                                    echo '<option value="' . $l->idLab . '">' . $l->namaLab . '</option>';
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">Specialist</label>
                                <input type="text" name="spesialis_aslab" id="spesialis_aslab" class="form-control" placeholder="Input Specialist Assistant" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">RFID Tag</label>
                                <input type="text" name="rfid_aslab" id="rfid_aslab" class="form-control" placeholder="Input RFID Tag" required>
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
              <div class="col-md-4 offset-md-2" style="margin-bottom: 5px">
                <select class="form-control laboratorium" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                  <option></option>
                  <option value="<?= base_url() ?>Laboran/LaboratoryAssistant/2016/2017">2016/2017</option>
                  <option value="<?= base_url() ?>Laboran/LaboratoryAssistant/2017/2018">2017/2018</option>
                  <option value="<?= base_url() ?>Laboran/LaboratoryAssistant/2018/2019">2018/2019</option>
                  <option value="<?= base_url() ?>Laboran/LaboratoryAssistant/2019/2020">2019/2020</option>
                  <option value="<?= base_url() ?>Laboran/LaboratoryAssistant/2020/2021">2020/2021</option>
                </select>
              </div>
            </div>
            <div class="row">
              <?php
              foreach ($data as $d) {
              ?>
                <div class="col-md-3">
                  <div class=" contact-box center-version" style="height: 500px">
                    <a href="<?= base_url('Laboran/ProfileAssistant/' . substr(sha1($d->idAslab), 6, 4)) ?>">
                      <?php
                      if ($d->fotoAslab == null) {
                        $foto = base_url('assets/img/person-flat.png');
                      } else {
                        $foto = base_url($d->fotoAslab);
                      }
                      for ($i = 0; $i < $d->aslabOfTheMonth; $i++) {
                        echo '<img alt="image" src="' . base_url('assets/img/star.png') . '" style="height: 15px; width: 15px">';
                      }
                      $lab = '';
                      foreach ($pj as $p) {
                        if ($p->idAslab == $d->idAslab) {
                          $lab .= $p->namaLab . '<br>';
                        }
                      }
                      ?>
                      <br>
                      <img alt="image" class="rounded-circle" src="<?= $foto ?>">
                      <h3 class="m-b-xs"><strong><?= $d->namaLengkap ?></strong></h3>
                      <div class="font-bold"><?= $d->nim ?></div>
                      <div class="font-bold"><?= $d->noTelp ?></div>
                      <address class="m-t-md">
                        <strong>Laboratory:</strong><br>
                        <?= $lab ?><br>
                        <strong>Specialist:</strong><br>
                        <?= $d->spesialisAslab ?>
                      </address>
                    </a>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
          </div>
        </div>
      </div>
      <script>
        function hapus_inventaris(id) {
          $.ajax({
            url: '<?= base_url('Laboran/ajaxNamaStockList') ?>',
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
                  window.location.href = '<?= base_url('Laboran/DeleteStockList/') ?>' + id;
                });
              });
            }
          });
        }
      </script>