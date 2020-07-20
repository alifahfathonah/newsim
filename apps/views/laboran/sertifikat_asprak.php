      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Certificate Practicum Assistant<br>School of Applied Science School's Laboratory</h2>
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
            <form method="post" action="<?= base_url('Practicum/Certificate') ?>">
              <div class="row" style="margin-bottom: 5px">
                <div class="col-md-2 col-sm-2 offset-md-2">
                  <select name="tahun_ajaran" id="tahun_ajaran" class="tahun_ajaran form-control" required>
                    <option></option>
                    <?php
                    $ta_aktif = $this->db->where('status', 1)->get('tahun_ajaran')->row()->id_ta;
                    foreach ($ta as $t) {
                      if ($ta_aktif == $t->id_ta) {
                        echo '<option value="' . $t->id_ta . '" selected>' . $t->ta . '</option>';
                      } else {
                        echo '<option value="' . $t->id_ta . '">' . $t->ta . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-5 col-sm-5">
                  <select name="prodi" id="prodi" class="prodi form-control" required>
                    <option></option>
                    <?php
                    foreach ($prodi as $p) {
                      echo '<option value="' . $p->kode_prodi . '">' . $p->strata . ' ' . $p->nama_prodi . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-1 col-sm-2">
                  <button style="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Apply</button>
                </div>
              </div>
            </form>
            <hr style="color: solid #ccc">
            <div class="ibox">
              <?php
              if (isset($daftar_mk)) {
                foreach ($daftar_mk as $dmk) {
                  $daftar_asprak = $this->db->select('asprak.nim_asprak, asprak.nama_asprak, daftarasprak.posisi')->from('daftarasprak')->join('asprak', 'daftarasprak.nim_asprak = asprak.nim_asprak')->where('daftarasprak.id_daftar_mk', $dmk->id_daftar_mk)->order_by('asprak.nama_asprak')->get()->result();
              ?>
                  <div class="ibox collapsed">
                    <div class="ibox-title collapse-link" style="background-color: #ff7675; color: white;">
                      <h5><?= $dmk->kode_mk . ' - ' . $dmk->nama_mk ?></h5>
                    </div>
                    <div class="ibox-content">
                      <table width="100%" style="margin-bottom: 10px;">
                        <?php
                        $style_check  = null;
                        $style_pencil = null;
                        $style_cross  = null;
                        $cek_laporan  = $this->db->where('id_daftar_mk', $dmk->id_daftar_mk)->get('laporan_praktikum')->row();
                        if ($cek_laporan == true) {
                          if ($cek_laporan->status_laporan == 0) {
                            $style_pencil = 'color: orange';
                          } elseif ($cek_laporan->status_laporan == 2) {
                            $style_check = 'color: green';
                          }
                        } else {
                          //$status_laporan = 0;
                          $style_cross = 'color: red';
                        }
                        ?>
                        <tr>
                          <td width="20%">
                            <h4>Laporan Praktikum</h4>
                          </td>
                          <td width="4%" style="text-align: center; <?= $style_check ?>"><i class="fa fa-check fa-2x"></i></td>
                          <td width="4%" style="text-align: center; <?= $style_pencil ?>"><i class="fa fa-pencil fa-2x"></i></td>
                          <td width="4%" style="text-align: center; <?= $style_cross ?>"><i class="fa fa-close fa-2x"></i></td>
                          <td width="4%" style="text-align: center;"><i class="fa fa-file fa-2x"></i></td>
                          <td width="56%"></td>
                          <td width="4%" style="text-align: center; color: green"><a href="<?= base_url('Practicum/DetailCertificate/' . substr(sha1($dmk->id_daftar_mk), 7, 5)) ?>"><i class="fa fa-eye fa-2x"></i></a></td>
                          <?php
                          if ($cek_laporan->status_laporan == 2) {
                            echo '<td width="4%" style="text-align: center; color: green;"><i class="fa fa-check-circle fa-2x"></i></td>';
                          } else {
                            echo '<td width="4%" style="text-align: center;"><i class="fa fa-check-circle fa-2x"></i></td>';
                          }
                          ?>
                        </tr>
                      </table>
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>No Cert</th>
                            <th>NIM</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Total</th>
                            <th>Standar</th>
                            <th>Percent</th>
                            <th>Val</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          foreach ($daftar_asprak as $da) {
                          ?>
                            <tr>
                              <td></td>
                              <td><?= $da->nim_asprak ?></td>
                              <td><?= $da->nama_asprak ?></td>
                              <td><?= $da->posisi ?></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                          <?php
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
              <?php
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>