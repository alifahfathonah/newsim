      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">BAP</h2>
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
            <?php
            if ($profil->kontak_asprak == null || $profil->ttd_asprak == null || $profil->norek_asprak == null) {
              echo '<div class="alert alert-danger">Please complete your personal information in <b>Setting Menu before submit BAP</b></div>';
            } else {
            ?>
              <form method="post" action="<?= base_url('Asprak/BAP') ?>">
                <div class="row">
                  <div class="col-md-5 offset-md-1 col-sm-5" style="margin-bottom: 5px">
                    <select name="matapraktikum" id="matapraktikum" class="matapraktikum form-control">
                      <option></option>
                      <?php
                      foreach ($mk as $mk) {
                      ?>
                        <option value="<?= $mk->id_daftar_mk ?>"><?= $mk->strata . '' . $mk->kode_prodi . ' | ' . $mk->kode_mk . ' ' . $mk->nama_mk ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-3 col-sm-3" style="margin-bottom: 5px">
                    <select name="bulan" id="bulan" class="periode_bap form-control">
                      <option></option>
                      <option value="'<?= date('Y') ?>-01-01' and '<?= date('Y') ?>-01-20'|1|Januari">January</option>
                      <option value="'<?= date('Y') ?>-01-21' and '<?= date('Y') ?>-02-20'|2|Februari">February</option>
                      <option value="'<?= date('Y') ?>-02-21' and '<?= date('Y') ?>-03-20'|3|Maret">March</option>
                      <option value="'<?= date('Y') ?>-03-21' and '<?= date('Y') ?>-04-20'|4|April">April</option>
                      <option value="'<?= date('Y') ?>-04-21' and '<?= date('Y') ?>-05-20'|5|Mei">May</option>
                      <option value="'<?= date('Y') ?>-05-21' and '<?= date('Y') ?>-06-20'|6|Juni">June</option>
                      <option value="'<?= date('Y') ?>-06-21' and '<?= date('Y') ?>-07-20'|7|Juli">July</option>
                      <option value="'<?= date('Y') ?>-07-21' and '<?= date('Y') ?>-08-20'|8|Agustus">August</option>
                      <option value="'<?= date('Y') ?>-08-21' and '<?= date('Y') ?>-09-20'|9|September">September</option>
                      <option value="'<?= date('Y') ?>-09-21' and '<?= date('Y') ?>-10-20'|10|Oktober">October</option>
                      <option value="'<?= date('Y') ?>-10-21' and '<?= date('Y') ?>-11-20'|11|November">November</option>
                      <option value="'<?= date('Y') ?>-11-21' and '<?= date('Y') ?>-12-20'|12|Desember">December</option>
                    </select>
                  </div>
                  <div class="col-md-3 col-sm-3">
                    <button class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Submit BAP</button>
                  </div>
                </div>
              </form>
              <div class="ibox">
                <input type="text" name="course" id="course" class="form-control" style="display: none;"><input type="text" name="month" id="month" class="form-control" style="display: none;">
                <div class="ibox-content">
                  <div id="tampil"></div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>