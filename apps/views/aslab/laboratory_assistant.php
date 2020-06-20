      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Laboratory Assistant<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <div class="col-md-4 offset-md-4" style="margin-bottom: 5px">
                <select class="form-control periode_aslab" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                  <option></option>
                  <option value="<?= base_url('LaboratoryAssistant/index/2016/2017') ?>">2016/2017</option>
                  <option value="<?= base_url('LaboratoryAssistant/index/2017/2018') ?>">2017/2018</option>
                  <option value="<?= base_url('LaboratoryAssistant/index/2018/2019') ?>">2018/2019</option>
                  <option value="<?= base_url('LaboratoryAssistant/index/2019/2020') ?>">2019/2020</option>
                  <option value="<?= base_url('LaboratoryAssistant/index/2020/2021') ?>">2020/2021</option>
                </select>
              </div>
            </div>
            <div class="row">
              <?php
              foreach ($data as $d) {
              ?>
                <div class="col-md-3">
                  <div class=" contact-box center-version" style="height: 400px; margin-bottom: 10px">
                    <a href="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . substr(sha1($d->idAslab), 6, 4)) ?>">
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