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
                      if ($b->approve_absen == '0') {
                        $no_action = $no_action + 1;
                      } elseif ($b->approve_absen == '1') {
                        $approve = $approve + 1;
                      } elseif ($b->approve_absen == '2') {
                        $pending = $pending + 1;
                      }
                      $jumlah = $jumlah + 1;
                    }
                    if ($jumlah == $approve) {
                      echo '<button class="btn btn-success btn-sm"><i class="fa fa-check"></i> Approve BAP</button>';
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
                        <th width="15%">Approve/Not</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($bap as $b) {
                        $image = '<a href="' . base_url($b->screenshot) . '" data-toggle="lightbox">
                          <img src="' . base_url($b->screenshot) . '" height="60x">
                        </a>';
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= tanggal_inggris2($b->tanggal) ?></td>
                          <td><?= $b->masuk ?></td>
                          <td><?= $b->selesai ?></td>
                          <td><?= $b->modul ?></td>
                          <td style="text-align: center"><?= $image ?></td>
                          <td style="text-align: center" class="align-middle" id="button<?= substr(sha1($b->id_presensi_asprak), 7, 7) ?>">
                            <?php
                            if ($b->approve_absen == '0') {
                            ?>
                              <button class="btn btn-success btn-sm" onclick="approve('<?= substr(sha1($b->id_presensi_asprak), 7, 7) ?>')"><i class="fa fa-check"></i> Approve</button>
                              <button class="btn btn-danger btn-sm" onclick="pending('<?= substr(sha1($b->id_presensi_asprak), 7, 7) ?>')"><i class="fa fa-ban"></i> Pending</button>
                            <?php
                            } elseif ($b->approve_absen == '1') {
                              echo '<button class="btn btn-success btn-sm" disabled><i class="fa fa-check"></i> Approved</button>';
                            } elseif ($b->approve_absen == '2') {
                              echo '<button class="btn btn-danger btn-sm" disabled><i class="fa fa-ban"></i> Pending</button>';
                            }
                            ?>
                          </td>
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