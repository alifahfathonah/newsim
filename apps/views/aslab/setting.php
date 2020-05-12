      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Setting<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
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
                              <td width="15%">NIM</td>
                              <td width="2%">:</td>
                              <td style="padding-bottom: 5px">
                                <input type="text" name="nim_aslab" id="nim_aslab" class="form-control" value="<?= $profil_aslab->nim ?>">
                              </td>
                            </tr>
                            <tr>
                              <td>Name</td>
                              <td>:</td>
                              <td style="padding-bottom: 5px">
                                <input type="text" name="nama_aslab" id="nama_aslab" class="form-control" value="<?= $profil_aslab->namaLengkap ?>">
                              </td>
                            </tr>
                            <tr>
                              <td>Phone Number</td>
                              <td>:</td>
                              <td style="padding-bottom: 5px">
                                <input type="text" name="no_telp" id="no_telp" class="form-control" value="<?= $profil_aslab->noTelp ?>">
                              </td>
                            </tr>
                            <tr>
                              <td>Bank Mandiri Account</td>
                              <td>:</td>
                              <td style="padding-bottom: 5px">
                                <input type="text" name="norek" id="norek" class="form-control" value="<?= $profil_aslab->norek ?>">
                              </td>
                            </tr>
                            <tr>
                              <td>Account Name</td>
                              <td>:</td>
                              <td style="padding-bottom: 5px">
                                <input type="text" name="nama_rekening" id="nama_rekening" class="form-control" value="<?= $profil_aslab->nama_rekening ?>">
                              </td>
                            </tr>
                            <tr>
                              <td>LinkAja</td>
                              <td>:</td>
                              <td style="padding-bottom: 5px">
                                <input type="text" name="linkaja" id="linkaja" class="form-control" value="<?= $profil_aslab->linkaja ?>">
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
                                <input type="text" name="username" id="username" class="form-control" value="<?= $akun->username ?>" readonly>
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