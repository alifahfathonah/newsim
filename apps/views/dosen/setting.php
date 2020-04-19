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
                  <h2 class="no-margins"><?= $profil->nama_dosen ?></h2>
                  <h4><?= $profil->nip_dosen ?></h4>
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
                    <form method="post" action="<?= base_url('Setting') ?>" enctype="multipart/form-data">
                      <div class="table-responsive">
                        <table width="98%">
                          <tbody>
                            <tr>
                              <td colspan="3" style="padding-bottom: 20px">
                                <button type="button" class="btn btn-success btn-block" style="text-align: left" disabled>Personal Information</button>
                              </td>
                            </tr>
                            <tr>
                              <td width="15%">NIP</td>
                              <td width="2%">:</td>
                              <td style="padding-bottom: 5px">
                                <input type="text" name="nip_dosen" id="nip_dosen" class="form-control" value="<?= $profil->nip_dosen ?>">
                              </td>
                            </tr>
                            <tr>
                              <td>Name</td>
                              <td>:</td>
                              <td style="padding-bottom: 5px">
                                <input type="text" name="nama_dosen" id="nama_dosen" class="form-control" value="<?= $profil->nama_dosen ?>">
                              </td>
                            </tr>
                            <tr>
                              <td>Phone Number</td>
                              <td>:</td>
                              <td style="padding-bottom: 5px">
                                <input type="text" name="no_telp" id="no_telp" class="form-control" value="<?= $profil->no_telp ?>">
                              </td>
                            </tr>
                            <tr>
                              <td>Digital Signature</td>
                              <td>:</td>
                              <td style="padding-bottom: 5px">
                                <div class="form-group row form-inline" style="margin-top: 20px">
                                  <div class="radio">
                                    <input type="radio" name="ttd" id="upload" class="form-control" onclick="javascript:opsi_ttd()">
                                    <label for="upload">Upload image</label>
                                  </div>
                                  <div class="radio">
                                    <input type="radio" name="ttd" id="draw" class="form-control" onclick="javascript:opsi_ttd()">
                                    <label for="draw">Put signature here</label>
                                  </div>
                                </div>
                                <div class="row" id="tampil_field_upload" style="display: none">
                                  <div class="col-md-6 col-sm-6">
                                    <h2 class="tag-ingo">Upload your signature below,</h2>
                                    <div class="custom-file">
                                      <input id="logo" type="file" name="file_ttd" class="custom-file-input" accept="image/*">
                                      <label for="logo" class="custom-file-label">Choose file...</label>
                                    </div>
                                  </div>
                                </div>
                                <div class="row" id="tampil_field_draw" style="display: none">
                                  <div class="col-md-6 col-sm-6">
                                    <div id="signArea">
                                      <h2 class="tag-ingo">Put signature below,</h2>
                                      <div class="sig sigWrapper" style="height:auto;">
                                        <div class="typed"></div>
                                        <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                                      </div>
                                    </div>
                                    <div style="margin-top: 5px">
                                      <button type="button" class="btn btn-success btn-sm" id="btnSaveSign">Save Sign</button>
                                      <button type="button" class="btn btn-warning btn-sm btnClearSign" id="btnClearSign">Clear Sign</button>
                                    </div>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Your Signature</td>
                              <td>:</td>
                              <td style="padding-bottom: 5px">
                                <?php
                                if ($profil->ttd_dosen) {
                                  echo '<img src="' . base_url($profil->ttd_dosen) . '" height="100px" width="300px">';
                                }
                                ?>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="padding: 20px 0 20px 0">
                                <button type="button" class="btn btn-success btn-block" style="text-align: left" disabled>Account</button>
                              </td>
                            </tr>
                            <tr>
                              <td>Username</td>
                              <td>:</td>
                              <td style="padding-bottom: 5px">
                                <input type="text" name="username_asprak" id="username_asprak" class="form-control" value="<?= $akun->username ?>" readonly>
                              </td>
                            </tr>
                            <tr>
                              <td>Old Password</td>
                              <td>:</td>
                              <td style="padding-bottom: 5px">
                                <input type="password" name="password_lama" id="password_lama" class="form-control">
                              </td>
                            </tr>
                            <tr>
                              <td>New Password</td>
                              <td>:</td>
                              <td style="padding-bottom: 5px">
                                <input type="password" name="password_baru" id="password_baru" class="form-control">
                              </td>
                            </tr>
                            <tr>
                              <td>Repeat Password</td>
                              <td>:</td>
                              <td style="padding-bottom: 5px">
                                <input type="password" name="konfirm_password" id="konfirm_password" class="form-control">
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="padding-top: 10px">
                                <p>
                                  <button type="submit" class="btn btn-primary btn-sm col-md-1">Save</button>
                                  <button type="reset" class="btn btn-warning btn-sm col-md-1">Reset</button>
                                  <button type="button" class="btn btn-danger btn-sm col-md-1">Cancel</button>
                                </p>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>