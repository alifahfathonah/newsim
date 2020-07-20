      <?php
      $prodi = $this->db->where('kode_prodi', $dmk->kode_prodi)->get('prodi')->row();
      $matakuliah = $this->db->where('kode_mk', $dmk->kode_mk)->get('matakuliah')->row();
      $tahun_ajaran = $this->db->where('id_ta', $dmk->id_ta)->get('tahun_ajaran')->row();
      ?>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <h2><?= $prodi->strata . ' ' . $prodi->nama_prodi ?></h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="row">
              <div class="col-md-12">
                <h3 style="font-weight: 100;"><?= $matakuliah->nama_mk ?></h3>
              </div>
              <div class="col-md-12">
                <h3 style="font-weight: 100;"><?= $tahun_ajaran->ta ?></h3>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-sm-12">
            <div class="row">
              <div class="col-md-12">
                <h3 style="font-weight: 100;"><?= $matakuliah->nama_mk ?></h3>
              </div>
              <div class="col-md-12">
                <h3 style="font-weight: 100;"><?= $tahun_ajaran->ta ?></h3>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-12">
            <hr style="color: solid #ccc">
            <div class="ibox">
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
                      <th>B1</th>
                      <th>B2</th>
                      <th>B3</th>
                      <th>B4</th>
                      <th>Total</th>
                      <th>Standar</th>
                      <th>Percent</th>
                      <th>Val</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $daftar_asprak = $this->db->select('asprak.nim_asprak, asprak.nama_asprak, daftarasprak.posisi')->from('daftarasprak')->join('asprak', 'daftarasprak.nim_asprak = asprak.nim_asprak')->where('daftarasprak.id_daftar_mk', $dmk->id_daftar_mk)->order_by('asprak.nama_asprak')->get()->result();
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
          </div>
        </div>
      </div>