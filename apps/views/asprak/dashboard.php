<div class="wrapper wrapper-content animated fadeInDown">
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Graph Complain in <?= date('Y') ?></h5>
        </div>
        <div class="ibox-content">
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div>
                <canvas id="grafik_komplain" height="80"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Laboratory Activity in <?= date('Y') ?></h5>
        </div>
        <div class="ibox-content">
          <div class="row">
            <div class="col-6">
              <small class="stats-label">Complaint Not Resolved</small>
              <h4>236 321.80</h4>
            </div>
            <div class="col-6">
              <small class="stats-label">Complaint Resolved</small>
              <h4>46.11%</h4>
            </div>
          </div>
        </div>
        <div class="ibox-content">
          <div class="row">
            <div class="col-6">
              <small class="stats-label">Borrowing Not Finished</small>
              <h4>643 321.10</h4>
            </div>
            <div class="col-6">
              <small class="stats-label">Borrowing Finished</small>
              <h4>92.43%</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <?php
      if (flashdata('msg')) {
        echo flashdata('msg');
      }
      ?>
      <div class="ibox ">
        <div class="p-md">
          <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahPengumuman"><i class="fa fa-plus"></i> Add Announcement</button>
          <div class="modal inmodal fade" id="tambahPengumuman" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Add Announcement</h4>
                </div>
                <form method="post" action="<?= base_url('Laboran/SaveAnnouncement') ?>">
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <label class="font-bold">Name Announcement</label>
                          <input type="text" name="nama_pengumuman" id="nama_pengumuman" class="form-control" placeholder="Example: Rapat Asisten Laboratorium, Sharing Knowledge PLC" required>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group" id="date_picker">
                          <label class="font-bold">Date</label>
                          <div class="input-group date">
                            <span class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" name="tanggal_pengumuman" id="tanggal_pengumuman" class="form-control" value="<?= date('m/d/Y') ?>" required>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <label class="font-bold">Content of Announcement</label>
                          <textarea name="isi_pengumuman" id="isi_pengumuman" class="form-control" rows="3"></textarea required>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                          <label class="font-bold">Type Announcement</label>
                          <div class="row">
                            <div class="col-md-6 col-sm-6">
                              <div class="i-checks">
                                <label>
                                  <input type="radio" name="tipe_pengumuman" id="tipe_pengumuman" value="Meeting" required> <i></i> Meeting
                                </label>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                              <div class="i-checks">
                                <label>
                                  <input type="radio" name="tipe_pengumuman" id="tipe_pengumuman" value="Sharing Knowledge" required> <i></i> Sharing Knowledge
                                </label>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                              <div class="i-checks">
                                <label>
                                  <input type="radio" name="tipe_pengumuman" id="tipe_pengumuman" value="General" required> <i></i> General
                                </label>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                              <div class="i-checks">
                                <label>
                                  <input type="radio" name="tipe_pengumuman" id="tipe_pengumuman" value="Practicum Assistant" required> <i></i> Practicum Assistant
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
        <div id="ibox-content">
          <div id="vertical-timeline" class="vertical-container light-timeline">
            <?php
            foreach ($pengumuman as $p) {
            ?>
              <div class="vertical-timeline-block">
                <?php
                if ($p->tipePengumuman == 'Meeting') {
                  echo '<div class="vertical-timeline-icon navy-bg"><i class="fa fa-briefcase"></i></div>';
                } elseif ($p->tipePengumuman == 'Sharing Knowledge') {
                  echo '<div class="vertical-timeline-icon blue-bg"><i class="fa fa-share-alt"></i></div>';
                } elseif ($p->tipePengumuman == 'General') {
                  echo '<div class="vertical-timeline-icon yellow-bg"><i class="fa fa-bullhorn"></i></div>';
                } elseif ($p->tipePengumuman == 'Practicum Assistant') {
                  echo '<div class="vertical-timeline-icon red-bg"><i class="fa fa-users"></i></div>';
                }
                ?>
                <div class="vertical-timeline-content">
                  <h2><?= $p->namaPengumuman ?></h2>
                  <p><?= $p->isiPengumuman ?></p>
                  <button class="btn btn-sm btn-danger" style="margin-left: 5px" onclick="hapus_pengumuman(<?= $p->idPengumuman ?>)"><i class="fa fa-trash"></i></button>
                  <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editPengumuman<?= $p->idPengumuman ?>"><i class="fa fa-edit"></i></button>
                  <span class="vertical-date">
                    <?= tanggal_inggris($p->tglPengumuman) ?>
                  </span>
                </div>
              </div>
              <div class="modal inmodal fade" id="editPengumuman<?= $p->idPengumuman ?>" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Edit Announcement</h4>
                  </div>
                  <form method="post" action="<?= base_url('Laboran/UpdateAnnouncement/' . $p->idPengumuman) ?>">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label class="font-bold">Name Announcement</label>
                            <input type="text" name="nama_pengumuman" id="nama_pengumuman" class="form-control" placeholder="Example: Rapat Asisten Laboratorium, Sharing Knowledge PLC" value="<?= $p->namaPengumuman ?>" required>
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group" id="date_picker">
                            <label class="font-bold">Date</label>
                            <div class="input-group date">
                              <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </span>
                              <?php
                              $tanggal_pengumuman = $p->tglPengumuman;
                              $pisah_tanggal      = explode('-', $tanggal_pengumuman);
                              $urut_tanggal       = array($pisah_tanggal[1], $pisah_tanggal[2], $pisah_tanggal[0]);
                              $tanggal_pengumuman = implode('/', $urut_tanggal);
                              ?>
                              <input type="text" name="tanggal_pengumuman" id="tanggal_pengumuman" class="form-control" value="<?= $tanggal_pengumuman ?>" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label class="font-bold">Content of Announcement</label>
                            <textarea name="isi_pengumuman" id="isi_pengumuman" class="form-control" rows="3"><?= $p->isiPengumuman ?></textarea required>
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label class="font-bold">Type Announcement</label>
                            <div class="row">
                              <div class="col-md-6 col-sm-6">
                                <div class="i-checks">
                                  <label>
                                    <input type="radio" name="tipe_pengumuman" id="tipe_pengumuman" value="Meeting" <?php if ($p->tipePengumuman == 'Meeting') echo 'checked'; ?> required> <i></i> Meeting
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-6 col-sm-6">
                                <div class="i-checks">
                                  <label>
                                    <input type="radio" name="tipe_pengumuman" id="tipe_pengumuman" value="Sharing Knowledge" <?php if ($p->tipePengumuman == 'Sharing Knowledge') echo 'checked'; ?> required> <i></i> Sharing Knowledge
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-6 col-sm-6">
                                <div class="i-checks">
                                  <label>
                                    <input type="radio" name="tipe_pengumuman" id="tipe_pengumuman" value="General" <?php if ($p->tipePengumuman == 'General') echo 'checked'; ?> required> <i></i> General
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-6 col-sm-6">
                                <div class="i-checks">
                                  <label>
                                    <input type="radio" name="tipe_pengumuman" id="tipe_pengumuman" value="Practicum Assistant" <?php if ($p->tipePengumuman == 'Practicum Assistant') echo 'checked'; ?> required> <i></i> Practicum Assistant
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
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function hapus_pengumuman(id) {
    $.ajax({
      url: '<?= base_url('Laboran/ajaxPengumuman') ?>',
      method: 'post',
      data: {
        id: id
      },
      success: function(response) {
        swal({
          title: 'Are you sure?',
          text: 'Do you want to delete "'+response+'"',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
          closeOnConfirm: false
        }, function() {
          swal({
            title: 'Deleted!',
            text: 'Your announcement has been deleted',
            timer: 1500,
            type: 'success',
            showConfirmButton: false
          }, function() {
            window.location.href = '<?= base_url('Laboran/DeleteAnnouncement/') ?>'+id;
          });
        });
      }
    });
  }
</script>