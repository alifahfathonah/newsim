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
                        <?php
                        $id_aslab = substr(sha1(userdata('id_aslab')), 6, 4);
                        if ($id_aslab == uri(3)) {
                          echo '<th width="5%">Action</th>';
                        }
                        ?>
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
                          <?php
                          $id_aslab = substr(sha1(userdata('id_aslab')), 6, 4);
                          if ($id_aslab == uri(3) && $k->keluar != '-') {
                          ?>
                            <td style="text-align: center">
                              <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editKegiatan<?= $k->idJurnal ?>"><i class="fa fa-edit"></i></button>
                            </td>
                          <?php
                          } elseif ($id_aslab == uri(3) && $k->keluar == '-') {
                            echo '<td style="text-align: center"><button class="btn btn-danger btn-sm" disabled><i class="fa fa-ban"></i></button></td>';
                          }
                          ?>
                        </tr>
                        <div class="modal inmodal fade" id="editKegiatan<?= $k->idJurnal ?>" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title">Edit Your Activity</h4>
                              </div>
                              <form method="post" action="<?= base_url('LaboratoryAssistant/EditActivity') ?>">
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                      <div class="form-group">
                                        <label class="font-bold">Date</label>
                                        <input type="text" name="id_jurnal" id="id_jurnal" value="<?= $k->idJurnal ?>" style="display: none">
                                        <input type="text" class="form-control" value="<?= tanggalInggris($k->aslabMasuk) ?>" readonly>
                                      </div>
                                    </div>
                                    <div class="col-md-2 offset-md-1 col-sm-2">
                                      <div class="form-group">
                                        <label class="font-bold">In</label>
                                        <input type="text" class="form-control" value="<?= $k->masuk ?>" readonly>
                                      </div>
                                    </div>
                                    <div class="col-md-2 offset-md-1 col-sm-2">
                                      <div class="form-group">
                                        <label class="font-bold">Out</label>
                                        <input type="text" class="form-control" value="<?= $k->keluar ?>" readonly>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                      <div class="form-group">
                                        <label class="font-bold">Activities</label>
                                        <textarea name="aktivitas_aslab" id="aktivitas_aslab" class="form-control" rows="5"><?= strip_tags($k->jurnal, '<br />') ?></textarea>
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
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>