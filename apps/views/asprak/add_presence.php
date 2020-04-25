      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Add Presence</h2>
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
            <div class="ibox">
              <div class="ibox-content">
                <form method="post" action="<?= base_url('Asprak/AddPresence') ?>" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Schedule</label>
                        <select name="jadwal_asprak" id="jadwal_asprak" class="form-control jadwal">
                          <option></option>
                          <?php
                          foreach ($jadwal as $j) {
                          ?>
                            <option value="<?= $j->id_jadwal_asprak ?>"><?= hariInggris($j->hari_ke) . ' ' . $j->masuk . ' - ' . $j->selesai . ', ' . $j->kode_mk . ' - ' . $j->nama_mk ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-3">
                      <div class="form-group" id="tanggal">
                        <label class="font-bold">Date</label>
                        <div class="input-group date">
                          <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </span>
                          <input type="text" name="tgl_asprak" id="tgl_asprak" class="form-control" value="<?= date('m/d/Y') ?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-3">
                      <div class="form-group">
                        <label class="font-bold">Start</label>
                        <div class="input-group clockpicker" data-autoclose="true">
                          <input type="text" name="jam_masuk" id="jam_masuk" class="form-control">
                          <span class="input-group-addon">
                            <span class="fa fa-clock-o"></span>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-3">
                      <div class="form-group">
                        <label class="font-bold">End</label>
                        <div class="input-group clockpicker" data-autoclose="true">
                          <input type="text" name="jam_selesai" id="jam_selesai" class="form-control">
                          <span class="input-group-addon">
                            <span class="fa fa-clock-o"></span>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Practicum Modul</label>
                        <input type="text" name="modul_praktikum" id="modul_praktikum" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Screenshot</label>
                        <div class="custom-file">
                          <input type="file" name="screenshot_praktikum" id="screenshot_praktikum" accept="image/*" class="custom-file-input">
                          <label for="logo" class="custom-file-label">Choose file...</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Video</label>
                        <!-- <input type="text" name="link_youtube" id="link_youtube" class="form-control" placeholder="Input Link Youtube"> -->
                        <div class="custom-file">
                          <input type="file" name="video_praktikum" id="video_praktikum" accept="video/*" class="custom-file-input">
                          <label for="logo" class="custom-file-label">Choose file...</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 offset-md-6 col-sm-6">
                      <div class="form-group" style="margin-top: 30px">
                        <div class="row">
                          <div class="col-md-4 col-sm-4" style="margin-bottom: 5px">
                            <button type="submit" class="btn btn-primary btn-sm btn-block">Save</button>
                          </div>
                          <div class="col-md-4 col-sm-4" style="margin-bottom: 5px">
                            <button type="reset" class="btn btn-warning btn-sm btn-block">Reset</button>
                          </div>
                          <div class="col-md-4 col-sm-4" style="margin-bottom: 5px">
                            <a href="<?= base_url('Asprak/Presence') ?>">
                              <button type="button" class="btn btn-danger btn-sm btn-block">Cancel</button>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>