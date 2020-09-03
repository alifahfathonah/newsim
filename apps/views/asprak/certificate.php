      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Certificate</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th width="30%">Courses</th>
                        <th width="10%">TA</th>
                        <th width="16%">Position</th>
                        <th width="12%">No Cert</th>
                        <th width="12%">Validation</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $nim = userdata('nim');
                      $sertifikat = $this->db->where('nim_asprak', $nim)->get('sertifikat')->result();
                      $no = 1;
                      foreach ($sertifikat as $s) {
                        $d = $this->db->select('matakuliah.kode_mk, matakuliah.nama_mk, tahun_ajaran.ta')->from('daftar_mk')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->join('tahun_ajaran', 'daftar_mk.id_ta = tahun_ajaran.id_ta')->where('daftar_mk.id_daftar_mk', $s->id_daftar_mk)->get()->row();
                        $a = $this->db->where('nim_asprak', $s->nim_asprak)->where('id_daftar_mk', $s->id_daftar_mk)->get('daftarasprak')->row();
                        if ($a->posisi == 'Anggota') {
                          $keanggotaan = 'Member';
                        } elseif ($a->posisi == 'Koordinator') {
                          $keanggotaan = 'Coordinator';
                        }
                        if ($s->tgl_diambil == null) {
                          $status = 'Untaken';
                        } else {
                          $status = 'Taken';
                        }
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $d->kode_mk . ' - ' . $d->nama_mk ?></td>
                          <td><?= $d->ta ?></td>
                          <td><?= $keanggotaan ?></td>
                          <td><?= $s->no_sertifikat ?></td>
                          <td><?= $s->validasi ?></td>
                          <td><?= $status ?></td>
                          <td style="text-align: center;">
                          <?php
                          if ($s->validasi == 'Yes') {
                          ?>
                          <form method="post" action="<?= base_url('Asprak/DownloadCertificate') ?>" target="_blank">
                              <input type="text" name="nim_asprak" id="nim_asprak" value="<?= userdata('nim') ?>" style="display: none;">
                              <input type="text" name="id_daftar_mk" id="id_daftar_mk" value="<?= $s->id_daftar_mk ?>" style="display: none;">
                              <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-download"></i></button>
                            </form>
                          <?php
                          } elseif ($s->validasi == 'No') {
                          ?>
                          <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                          <?php
                          }
                          ?>
                          </td>
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