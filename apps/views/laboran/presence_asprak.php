<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-12">
    <h2 style="text-align: center">Presence Practicum Assistant<br>School of Applied Science School's Laboratory</h2>
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
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover courses" width="100%">
              <thead>
                <tr>
                  <th width="7%">No</th>
                  <th>Date</th>
                  <th>Start</th>
                  <th>End</th>
                  <th>Name Asprak</th>
                  <th>Courses</th>
                  <th>Class</th>
                  <th>Lecturer Code</th>
                  <th>Status Approve Presence</th>
                  <th>Modul</th>
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
                    <td><?= tanggal_inggris2($d->tanggal) ?></td>
                    <td><?= $d->jam_masuk ?></td>
                    <td><?= $d->jam_selesai ?></td>
                    <td><?= $d->nama_asprak ?></td>
                    <td><?= $d->kode_mk . ' | ' . $d->nama_mk ?></td>
                    <td><?= $d->kelas ?></td>
                    <td><?= $d->kode_dosen ?></td>
                    <td>
                      <?php
                      if ($d->approve_absen == '0') {
                        echo 'Must be edit from Asprak';
                      } elseif ($d->approve_absen == '1') {
                        echo 'Waiting to approve';
                      } elseif ($d->approve_absen == '2') {
                        echo 'Approve';
                      }
                      ?>
                    </td>
                    <td><?= $d->modul ?></td>
                    <td style="text-align: center">
                      <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit<?= $d->id_presensi_asprak ?>"><i class="fa fa-edit"></i></button>
                      <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    </td>
                    <div class="modal inmodal fade" id="edit<?= $d->id_presensi_asprak ?>" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Edit Presence Practicum Laboratory</h4>
                          </div>
                          <form method="post" action="<?= base_url('Practicum/EditPresenceAsprak') ?>" enctype="multipart/form-data">
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label class="font-bold">Date</label>
                                    <input type="text" name="id_presensi" id="id_presensi" value="<?= $d->id_presensi_asprak ?>" style="display: none">
                                    <input type="text" value="<?= tanggal_inggris2($d->tanggal) ?>" class="form-control" readonly>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group">
                                    <label class="font-bold">Start</label>
                                    <input type="text" value="<?= $d->jam_masuk ?>" class="form-control" readonly>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group">
                                    <label class="font-bold">End</label>
                                    <input type="text" value="<?= $d->jam_selesai ?>" class="form-control" readonly>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label class="font-bold">Courses</label>
                                    <input type="text" value="<?= $d->kode_mk . ' | ' . $d->nama_mk ?>" class="form-control" readonly>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group">
                                    <label class="font-bold">Class</label>
                                    <input type="text" value="<?= $d->kelas ?>" class="form-control" readonly>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group">
                                    <label class="font-bold">Lecturer</label>
                                    <input type="text" value="<?= $d->kode_dosen ?>" class="form-control" readonly>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label class="font-bold">Modul</label>
                                    <input type="text" name="modul" id="modul" value="<?= $d->modul ?>" class="form-control">
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group">
                                    <label class="font-bold">Screenshot</label>
                                    <input type="file" accept="image/*" name="screenshot" id="screenshot" class="form-control">
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group">
                                    <label class="font-bold">Video</label>
                                    <input type="file" accept="video/*" name="video" id="video" class="form-control">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Update</button>
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