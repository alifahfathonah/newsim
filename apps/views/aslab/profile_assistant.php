      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center"><?= $profil->namaLengkap ?>'s Profile<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row m-b-lg m-t-lg" style="background: url('<?= base_url('assets/img/23065.jpg') ?>'); background-position: center; height: auto; color: white">
          <div class="col-md-9 col-sm-12" style="margin: 20px 0 20px 0">
            <div class="profile-image">
              <?php
              if ($profil->fotoAslab == null) {
                $foto = base_url('assets/img/person-flat.png');
              } else {
                $foto = base_url($profil->fotoAslab);
              }
              $laboratorium = '';
              foreach ($pj as $p) {
                if ($p->idAslab == uri('3')) {
                  $laboratorium .= '- ' . $p->namaLab . '<br>';
                }
              }
              ?>
              <img src="<?= $foto ?>" class="rounded-circle circle-border m-b-md" alt="profile">
            </div>
            <div class="profile-info">
              <div>
                <div>
                  <h2 class="no-margins"><?= $profil->namaLengkap ?></h2>
                  <h4><?= $profil->nim ?> | <i class="fa fa-phone-square"></i> <?= $profil->noTelp ?></h4>
                  <table>
                    <tr>
                      <td style="padding-right: 20px" width="50%"><small>Aslab in Charge:</small></td>
                      <td><small>Specialist:</small></td>
                    </tr>
                    <tr>
                      <td style="padding-right: 20px" width="50%"><small><?= $laboratorium ?></small></td>
                      <td valign="top"><small><?= $profil->spesialisAslab ?></small></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 offset-md-4" style="margin-bottom: 5px">
            <select class="form-control periode" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
              <option></option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3')) ?>">All Periode</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/January') ?>">January</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/February') ?>">February</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/March') ?>">March</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/April') ?>">April</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/May') ?>">May</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/June') ?>">June</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/July') ?>">July</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/August') ?>">August</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/September') ?>">September</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/October') ?>">October</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/November') ?>">November</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/December') ?>">December</option>
            </select>
          </div>
        </div>
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
                  <table class="table table-striped table-bordered table-hover kegiatan_aslab">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th width="25%">Date</th>
                        <th width="5%">In</th>
                        <th width="5%">Out</th>
                        <th>Activities</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($kegiatan as $k) {
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= tanggalInggris($k->aslabMasuk) ?></td>
                          <td style="text-align: center"><?= $k->masuk ?></td>
                          <td style="text-align: center"><?= $k->keluar ?></td>
                          <td><?= $k->jurnal ?></td>
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