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
                      <div class="vertical-timeline-icon yellow-bg">
                        <i class="fa fa-bullhorn"></i>
                      </div>
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