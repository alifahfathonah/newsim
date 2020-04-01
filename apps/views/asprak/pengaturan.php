      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Pengaturan</h2>
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
                <form method="post" action="<?= base_url('Asprak/Pengaturan') ?>">
                  <table width="100%">
                    <tbody>
                      <tr>
                        <td colspan="3" style="padding-bottom: 20px">
                          <button type="button" class="btn btn-success btn-block" style="text-align: left" disabled>Informasi Pribadi</button>
                        </td>
                      </tr>
                      <tr>
                        <td width="15%">NIM</td>
                        <td width="2%">:</td>
                        <td style="padding-bottom: 5px">
                          <input type="text" name="nim_asprak" id="nim_asprak" class="form-control" value="<?= $profil->nim_asprak ?>" readonly>
                        </td>
                      </tr>
                      <tr>
                        <td>Nama Lengkap</td>
                        <td>:</td>
                        <td style="padding-bottom: 5px">
                          <input type="text" name="nama_asprak" id="nama_asprak" class="form-control" value="<?= $profil->nama_asprak ?>">
                        </td>
                      </tr>
                      <tr>
                        <td>Nomor Telepon</td>
                        <td>:</td>
                        <td style="padding-bottom: 5px">
                          <input type="text" name="kontak_asprak" id="kontak_asprak" class="form-control" value="<?= $profil->kontak_asprak ?>">
                        </td>
                      </tr>
                      <tr>
                        <td>Nama Bank</td>
                        <td>:</td>
                        <td style="padding-bottom: 5px">
                          <select name="bank_asprak" id="bank_asprak" class="nama_bank form-control">
                            <option></option>
                            <?php
                            foreach ($bank as $b) {
                              if ($b->id_bank == $profil->id_bank) {
                                echo '<option value="' . $b->id_bank . '" selected>' . $b->nama_bank . '</option>';
                              } else {
                                echo '<option value="' . $b->id_bank . '">' . $b->nama_bank . '</option>';
                              }
                            }
                            ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Nomor Rekening</td>
                        <td>:</td>
                        <td style="padding-bottom: 5px">
                          <input type="text" name="norek_asprak" id="norek_asprak" class="form-control" value="<?= $profil->norek_asprak ?>">
                        </td>
                      </tr>
                      <tr>
                        <td>LinkAja</td>
                        <td>:</td>
                        <td style="padding-bottom: 5px">
                          <input type="text" name="linkaja_asprak" id="linkaja_asprak" class="form-control" value="<?= $profil->linkaja_asprak ?>">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3" style="padding: 20px 0 20px 0">
                          <button type="button" class="btn btn-success btn-block" style="text-align: left" disabled>Pengaturan Akun</button>
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
                        <td>Password Lama</td>
                        <td>:</td>
                        <td style="padding-bottom: 5px">
                          <input type="password" name="password_lama" id="password_lama" class="form-control">
                        </td>
                      </tr>
                      <tr>
                        <td>Password Baru</td>
                        <td>:</td>
                        <td style="padding-bottom: 5px">
                          <input type="password" name="password_baru" id="password_baru" class="form-control">
                        </td>
                      </tr>
                      <tr>
                        <td>Konfirmasi Password</td>
                        <td>:</td>
                        <td style="padding-bottom: 5px">
                          <input type="password" name="konfirm_password" id="konfirm_password" class="form-control">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3">
                          <div class="form-group" style="margin-top: 20px">
                            <div class="row">
                              <div class="col-md-1 col-sm-2">
                                <button type="submit" class="btn btn-primary btn-sm btn-block">Save</button>
                              </div>
                              <div class="col-md-1 col-sm-4">
                                <button type="reset" class="btn btn-warning btn-sm btn-block">Reset</button>
                              </div>
                              <div class="col-md-1 col-sm-4">
                                <button type="button" class="btn btn-danger btn-sm btn-block">Cancel</button>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>