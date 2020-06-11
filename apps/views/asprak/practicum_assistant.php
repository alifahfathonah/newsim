      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">List of Practicum Assistant</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <?php
          $jumlah_mk    = $this->db->select('count(id_daftar_asprak) jumlah')->from('daftarasprak')->where('nim_asprak', userdata('nim'))->group_by('nim_asprak')->get()->row()->jumlah;
          $id_daftar_mk = $this->db->select('id_daftar_mk')->from('daftarasprak')->where('nim_asprak', userdata('nim'))->get()->result_array();
          if ($jumlah_mk > 0) {
            for ($i = 0; $i < $jumlah_mk; $i++) {
              $nama_mk = $this->db->select('daftar_mk.kode_mk, matakuliah.nama_mk, tahun_ajaran.ta')->from('daftar_mk')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->join('tahun_ajaran', 'daftar_mk.id_ta = tahun_ajaran.id_ta')->where('daftar_mk.id_daftar_mk', $id_daftar_mk[$i]['id_daftar_mk'])->get()->row();
          ?>
              <div class="col-md-12 col-sm-12">
                <div class="ibox">
                  <a class="collapse-link">
                    <div class="ibox-title">
                      <h5>
                        <?php
                        $semester = substr($nama_mk->ta, -1);
                        $tahun = substr($nama_mk->ta, 0, 4);
                        $tmp_tahun = $tahun + 1;
                        if ($semester == '1') {
                          $semester = 'Odd';
                        } elseif ($semester == '2') {
                          $semester = 'Even';
                        }
                        $tahun = $tahun . '/' . $tmp_tahun;
                        ?>
                        TA <?= $tahun . ' ' . $semester . '<br>' . $nama_mk->kode_mk . ' - ' . $nama_mk->nama_mk ?>
                      </h5>
                    </div>
                  </a>
                  <div class="ibox-content">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th width="7%">No</th>
                            <th width="25%">NIM</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Contact</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $daftar_asprak = $this->db->select('asprak.nim_asprak, asprak.nama_asprak, daftarasprak.posisi, asprak.kontak_asprak')->from('daftarasprak')->join('asprak', 'daftarasprak.nim_asprak = asprak.nim_asprak')->where('daftarasprak.id_daftar_mk', $id_daftar_mk[$i]['id_daftar_mk'])->order_by('asprak.nim_asprak', 'asc')->get()->result();
                          $no = 1;
                          foreach ($daftar_asprak as $d) {
                          ?>
                            <tr>
                              <td><?= $no++ ?></td>
                              <td><?= $d->nim_asprak ?></td>
                              <td><?= $d->nama_asprak ?></td>
                              <td>
                                <?php
                                if ($d->posisi == '0') {
                                  echo 'Member';
                                } elseif ($d->posisi == '1') {
                                  echo 'Coordinator';
                                }
                                ?>
                              </td>
                              <td><?= $d->kontak_asprak ?></td>
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
          <?php
            }
          }
          ?>
        </div>
      </div>