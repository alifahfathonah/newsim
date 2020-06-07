      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">
            View Presence for <?= $asprak->nama_asprak ?><br>
            <?= $prodi->kode_mk . ' / ' . $prodi->nama_mk ?>
          </h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="ibox">
              <div class="ibox-content">
                <div class="row" style="margin-bottom: 10px">
                  <div class="col-md-4 offset-md-8" id="refresh" style="text-align: right">
                    <?php
                    $approve  = 0;
                    $pending  = 0;
                    $no_action  = 0;
                    $jumlah = 0;
                    foreach ($bap as $b) {
                      if ($b->approve_absen == '1') {
                        $no_action = $no_action + 1;
                      } elseif ($b->approve_absen == '2') {
                        $approve = $approve + 1;
                      } elseif ($b->approve_absen == '0') {
                        $pending = $pending + 1;
                      }
                      $jumlah = $jumlah + 1;
                    }
                    if ($jumlah == $approve) {
                      echo '
                      <a href="' . base_url('BAP/ApproveBAP/' . substr(sha1($total->id_honor), 19, 9)) . '">
                      <button class="btn btn-success btn-sm"><i class="fa fa-check"></i> Approve BAP</button>
                      </a>';
                    } elseif ($pending > 0) {
                      echo '<button class="btn btn-danger btn-sm" disabled><i class="fa fa-check"></i> Waiting to fix their presence</button>';
                    } elseif ($no_action > 0) {
                      echo '<button class="btn btn-danger btn-sm" disabled><i class="fa fa-check"></i> You must approve/not their presence</button>';
                    }
                    ?>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th width="15%">Date</th>
                        <th width="5%">Start</th>
                        <th width="5%">End</th>
                        <th width="20%">Modul</th>
                        <th width="15%">Image</th>
                        <th width="15%">Video</th>
                        <th>Approve/Not</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($bap as $b) {
                        $image = '<a href="' . base_url($b->screenshot) . '" data-toggle="lightbox">
                          <img src="' . base_url($b->screenshot) . '" height="60x">
                        </a>';
                        if ($b->video != '') {
                          $video = '<a data-toggle="modal" data-target="#video' . $b->id_presensi_asprak . '">
                          <img src="' . base_url('assets/img/839.jpg') . '" height="60px">
                        </a>';
                        } else {
                          $video = '-';
                        }
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= tanggal_inggris2($b->tanggal) ?></td>
                          <td><?= $b->masuk ?></td>
                          <td><?= $b->selesai ?></td>
                          <td><?= $b->modul ?></td>
                          <td style="text-align: center"><?= $image ?></td>
                          <td style="text-align: center"><?= $video ?></td>
                          <td style="text-align: center" class="align-middle" id="button<?= substr(sha1($b->id_presensi_asprak), 7, 7) ?>">
                            <?php
                            if ($b->approve_absen == '1') {
                            ?>
                              <button class="btn btn-success btn-sm" onclick="approve('<?= substr(sha1($b->id_presensi_asprak), 7, 7) ?>')" style="margin-bottom: 5px;"><i class="fa fa-check"></i> Approve</button>&nbsp;&nbsp;
                              <button class="btn btn-warning btn-sm" onclick="pending('<?= substr(sha1($b->id_presensi_asprak), 7, 7) ?>')" style="margin-bottom: 5px;"><i class="fa fa-ban"></i> Pending</button>&nbsp;&nbsp;
                              <button class="btn btn-danger btn-sm" onclick="hapus('<?= substr(sha1($b->id_presensi_asprak), 7, 7) ?>')" style="margin-bottom: 5px;"><i class="fa fa-trash"></i> Delete</button>
                            <?php
                            } elseif ($b->approve_absen == '2') {
                              echo '<button class="btn btn-success btn-sm" disabled><i class="fa fa-check"></i> Approved</button>';
                            } elseif ($b->approve_absen == '0') {
                              echo '<button class="btn btn-danger btn-sm" disabled><i class="fa fa-ban"></i> Pending</button>';
                            }
                            ?>
                          </td>
                        </tr>
                        <div class="modal inmodal fade" id="video<?= $b->id_presensi_asprak ?>" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-body">
                                <video controls>
                                  <source src="<?= base_url($b->video) ?>">
                                </video>
                              </div>
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