      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Setting</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row m-b-lg m-t-lg" style="background: url('<?= base_url('assets/img/23065.jpg') ?>'); background-position: center; height: auto; color: white">
          <div class="col-md-6 col-sm-12" style="margin: 20px 0 20px 0">
            <div class="profile-image">
              <img src="<?= base_url('assets/img/person-flat.png') ?>" class="rounded-circle circle-border m-b-md" alt="profile">
            </div>
            <div class="profile-info">
              <div>
                <div style="margin-top: 20px">
                  <h2 class="no-margins"><?= $profil->nama_asprak ?></h2>
                  <h4><?= $profil->nim_asprak ?></h4>
                </div>
              </div>
            </div>
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
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <div class="table-responsive">
                      <table width="98%">
                        <tbody>
                          <tr>
                            <td colspan="7" style="padding-bottom: 20px">
                              <button type="button" class="btn btn-success btn-block" style="text-align: left" disabled>Personal Information</button>
                            </td>
                          </tr>
                          <tr>
                            <td>NIM</td>
                            <td>:</td>
                            <td colspan="5" style="padding-bottom: 5px">
                              <input type=" text" name="nim_asprak" id="nim_asprak" class="form-control" value="<?= $profil->nim_asprak ?>" readonly>
                            </td>
                          </tr>
                          <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td colspan="5" style="padding-bottom: 5px">
                              <input type="text" name="nama_asprak" id="nama_asprak" class="form-control" value="<?= $profil->nama_asprak ?>">
                            </td>
                          </tr>
                          <tr>
                            <td>Phone Number</td>
                            <td>:</td>
                            <td colspan="5" style="padding-bottom: 5px">
                              <input type="text" name="kontak_asprak" id="kontak_asprak" class="form-control" value="<?= $profil->kontak_asprak ?>">
                            </td>
                          </tr>
                          <tr>
                            <td width="15%">Bank Mandiri Account</td>
                            <td width="2%">:</td>
                            <td width="31%" style="padding-bottom: 5px">
                              <input type="text" name="norek_asprak" id="norek_asprak" class="form-control" data-mask="999-99-9999999-9" value="<?= $profil->norek_asprak ?>" onkeyup="isi_bank()">
                            </td>
                            <td width="2%"></td>
                            <td width="15%">Account Name</td>
                            <td width="2%">:</td>
                            <td width="31%" style="padding-bottom: 5px">
                              <?php
                              if ($profil->norek_asprak == '' || $profil->norek_asprak == null) {
                              ?>
                                <input type="text" name="nama_rekening" id="nama_rekening" class="form-control" value="<?= $profil->nama_rekening ?>" disabled>
                              <?php
                              } elseif ($profil->norek_asprak != '' || $profil->norek_asprak != null) {
                              ?>
                                <input type="text" name="nama_rekening" id="nama_rekening" class="form-control" value="<?= $profil->nama_rekening ?>">
                              <?php
                              }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td>LinkAja</td>
                            <td>:</td>
                            <td style="padding-bottom: 5px">
                              <input type="text" name="linkaja_asprak" id="linkaja_asprak" class="form-control" value="<?= $profil->linkaja_asprak ?>" onkeyup="isi_linkaja()">
                            </td>
                            <td width="2%"></td>
                            <td width="15%">Account Name</td>
                            <td width="2%">:</td>
                            <td width="31%" style="padding-bottom: 5px">
                              <?php
                              if ($profil->linkaja_asprak == '' || $profil->linkaja_asprak == null) {
                              ?>
                                <input type="text" name="nama_linkaja" id="nama_linkaja" class="form-control" value="<?= $profil->nama_linkaja ?>" disabled>
                              <?php
                              } elseif ($profil->linkaja_asprak != '' || $profil->linkaja_asprak != null) {
                              ?>
                                <input type="text" name="nama_linkaja" id="nama_linkaja" class="form-control" value="<?= $profil->nama_linkaja ?>" required>
                              <?php
                              }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td>Digital Signature</td>
                            <td>:</td>
                            <td style="padding-bottom: 5px">
                              <div class="row">
                                <div class="col-md-12 col-sm-12">
                                  <div id="signArea">
                                    <h2 class="tag-ingo">Put signature below,</h2>
                                    <div class="sig sigWrapper" style="height:auto;">
                                      <div class="typed"></div>
                                      <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td width="2%"></td>
                            <td colspan="3" width="31%" style="padding-bottom: 5px">
                              <h2 class="tag-ingo">Your signature</h2>
                              <?php
                              if ($profil->ttd_asprak) {
                                echo '<img src="' . base_url($profil->ttd_asprak) . '">';
                              }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="7" style="padding: 20px 0 20px 0">
                              <button type="button" class="btn btn-success btn-block" style="text-align: left" disabled>Account</button>
                            </td>
                          </tr>
                          <tr>
                            <td>Username</td>
                            <td>:</td>
                            <td colspan="5" style="padding-bottom: 5px">
                              <input type="text" name="username_asprak" id="username_asprak" class="form-control" value="<?= $akun->username ?>" readonly>
                            </td>
                          </tr>
                          <tr>
                            <td>Old Password</td>
                            <td>:</td>
                            <td colspan="5" style="padding-bottom: 5px">
                              <input type="password" name="password_lama" id="password_lama" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>New Password</td>
                            <td>:</td>
                            <td colspan="5" style="padding-bottom: 5px">
                              <input type="password" name="password_baru" id="password_baru" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>Repeat Password</td>
                            <td>:</td>
                            <td colspan="5" style="padding-bottom: 5px">
                              <input type="password" name="konfirm_password" id="konfirm_password" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td colspan="7">
                              <p style="margin-top: 20px">
                                <button type="submit" class="btn btn-primary btn-sm col-md-1" id="send_data">Save</button>
                                <button type="reset" class="btn btn-warning btn-sm col-md-1">Reset</button>
                                <button type="button" class="btn btn-danger btn-sm col-md-1">Cancel</button>
                              </p>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>