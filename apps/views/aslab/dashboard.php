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
                    <?php
                    if ($komplain_belum != null) {
                      echo '<h4>' . $komplain_belum->komplain_belum . '</h4>';
                    } else {
                      echo '<h4>0</h4>';
                    }
                    ?>
                  </div>
                  <div class="col-6">
                    <small class="stats-label">Complaint Resolved</small>
                    <?php
                    if ($komplain_selesai != null) {
                      echo '<h4>' . $komplain_selesai->komplain_selesai . '</h4>';
                    } else {
                      echo '<h4>0</h4>';
                    }
                    ?>
                  </div>
                </div>
              </div>
              <div class="ibox-content">
                <div class="row">
                  <div class="col-6">
                    <small class="stats-label">Borrowing Not Finished</small>
                    <?php
                    $belum = 0;
                    if ($lab_belum != null) {
                      $belum = $belum + $lab_belum;
                    } else {
                      $belum = $belum + 0;
                    }
                    if ($alat_belum != null) {
                      $belum = $belum + $alat_belum;
                    } else {
                      $belum = $belum + 0;
                    }
                    ?>
                    <h4><?= $belum ?></h4>
                  </div>
                  <div class="col-6">
                    <small class="stats-label">Borrowing Finished</small>
                    <?php
                    $selesai = 0;
                    if ($lab_selesai != null) {
                      $selesai = $selesai + $lab_selesai->lab_selesai;
                    } else {
                      $selesai = $selesai + 0;
                    }
                    if ($alat_selesai != null) {
                      $selesai = $selesai + $alat_selesai->alat_selesai;
                    } else {
                      $selesai = $selesai + 0;
                    }
                    ?>
                    <h4><?= $selesai ?></h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox ">
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
                        <span class="vertical-date">
                          <?= tanggal_inggris($p->tglPengumuman) ?>
                        </span>
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