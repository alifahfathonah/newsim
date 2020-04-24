      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Practicum Report<br>School of Applied Science School's Laboratory</h2>
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
            <form method="post" action="<?= base_url('Practicum/Report') ?>">
              <div class="row" style="margin-bottom: 5px">
                <div class="col-md-2 col-sm-2 offset-md-2">
                  <select name="tahun_ajaran" id="tahun_ajaran" class="tahun_ajaran form-control">
                    <option></option>
                    <?php
                    foreach ($ta as $t) {
                      echo '<option value="' . $t->id_ta . '">' . $t->ta . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-5 col-sm-5">
                  <select name="daftar_mk" id="daftar_mk" class="daftar_mk form-control">
                    <option></option>
                    <?php
                    foreach ($mk as $m) {
                      echo '<option value="' . $m->kode_mk . '">' . $m->kode_mk . ' - ' . $m->nama_mk . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-1 col-sm-2">
                  <button style="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Search</button>
                </div>
              </div>
            </form>
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover daftar_lab" width="100%">
                    <thead>
                      <tr>
                        <th width="7%">No</th>
                        <th width="20%">Date Submit</th>
                        <th>Courses</th>
                        <th width="20%">Revision Notes</th>
                        <th width="10%">Status</th>
                        <th width="10%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($data as $d) {
                        if ($d->status_laporan == '0') {
                          $status = 'On Progress';
                        } elseif ($d->status_laporan == '1') {
                          $status = 'Done';
                        } elseif ($d->status_laporan == '2') {
                          $status = 'Revision';
                        }
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= tanggal_inggris2($d->tanggal) . ' ' . $d->jam ?></td>
                          <td><?= $d->kode_mk . ' - ' . $d->nama_mk ?></td>
                          <td><?= $d->catatan_revisi ?></td>
                          <td><?= $status ?></td>
                          <td style="text-align: center">
                            <a href="<?= base_url($d->nama_file) ?>" target="_blank">
                              <button class="btn btn-success btn-sm"><i class="fa fa-eye"></i></button>
                            </a>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?= substr(sha1($d->id_laporan_praktikum), 7, 7) ?>"><i class="fa fa-edit"></i></button>
                          </td>
                          <div class="modal inmodal fade" id="edit<?= substr(sha1($d->id_laporan_praktikum), 7, 7) ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                  <h4 class="modal-title">Edit Practicum Report</h4>
                                  <h4 class="font-bold"><?= $d->kode_mk . ' - ' . $d->nama_mk ?></h4>
                                </div>
                                <form method="post" action="<?= base_url('Practicum/EditReport') ?>">
                                  <div class="modal-body">
                                    <div class="row">
                                      <div class="col-md-8 col-sm-12">
                                        <div class="form-group">
                                          <label class="font-bold">Revision Notes</label>
                                          <input type="text" name="id_laporan_praktikum" value="<?= $d->id_laporan_praktikum ?>" style="display: none">
                                          <textarea name="catatan_revisi" id="catatan_revisi" class="form-control"></textarea>
                                        </div>
                                      </div>
                                      <div class="col-md-4 col-sm-12">
                                        <label class="font-bold">Status</label>
                                        <div class="form-group row">
                                          <div class="radio">
                                            <input type="radio" name="status" id="radio1" value="1">
                                            <label for="radio1">
                                              Accept
                                            </label>
                                          </div>
                                          <div class="radio">
                                            <input type="radio" name="status" id="radio2" value="2">
                                            <label for="radio2">
                                              Revision
                                            </label>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
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