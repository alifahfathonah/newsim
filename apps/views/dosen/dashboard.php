      <div class="wrapper wrapper-content animated fadeInDown">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox ">
              <div id="ibox-content">
                <h2 style="text-align: center">Announcement</h2>
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