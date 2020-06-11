      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">List of Practicum Assistant</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <form method="post" action="<?= base_url('PracticumAssistant') ?>">
          <div class="row" style="margin-bottom: 5px">
            <div class="col-md-5 offset-md-2">
              <select name="mk" class="mk form-control">
                <option></option>
                <?php
                $mk  = $this->db->order_by('kode_mk', 'asc')->get('matakuliah')->result();
                foreach ($mk as $dmk) {
                  echo '<option value="' . $dmk->kode_mk . '">' . $dmk->kode_mk . ' - ' . $dmk->nama_mk . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-md-2">
              <select name="tahun" class="tahun form-control">
                <option></option>
                <?php
                $tahun_ajaran = $this->db->get('tahun_ajaran')->result();
                foreach ($tahun_ajaran as $ta) {
                  $tahun    = substr($ta->ta, 0, 4);
                  $semester = substr($ta->ta, -1);
                  if ($semester == '1') {
                    $inggris = 'Odd';
                  } elseif ($semester == '2') {
                    $inggris = 'Even';
                  }
                  $tahun  = $tahun . '/' . ($tahun + 1);
                  echo '<option value="' . $ta->id_ta . '">' . $tahun . ' ' . $inggris . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-filter"></i> Filter</button>
            </div>
          </div>
        </form>
        <div class="row">
          <?php
          foreach ($daftar_mk as $d) {
            $nama_mk  = $this->db->select('kode_mk, nama_mk')->from('matakuliah')->where('kode_mk', $d->kode_mk)->get()->row();
          ?>
            <div class="col-md-12 col-sm-12">
              <div class="ibox">
                <div class="ibox-title">
                  <h5><?= $nama_mk->kode_mk . ' - ' . $nama_mk->nama_mk ?></h5>
                  <div class="ibox-tools">
                    <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                    </a>
                  </div>
                </div>
                <div class="ibox-content">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables">
                      <thead>
                        <tr>
                          <th width="7%">No</th>
                          <th width="25%">NIM</th>
                          <th>Name</th>
                          <th>Phone Number</th>
                          <th>Email</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $daftar_asprak = $this->db->select('asprak.nim_asprak, asprak.nama_asprak, asprak.kontak_asprak, asprak.email_asprak, daftarasprak.posisi')->from('daftarasprak')->join('asprak', 'daftarasprak.nim_asprak = asprak.nim_asprak')->where('daftarasprak.id_daftar_mk', $d->id_daftar_mk)->order_by('asprak.nim_asprak', 'asc')->get()->result();
                        $no = 1;
                        foreach ($daftar_asprak as $d) {
                        ?>
                          <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $d->nim_asprak ?></td>
                            <td><?= $d->nama_asprak ?></td>
                            <td><?= $d->kontak_asprak ?></td>
                            <td><?= $d->email_asprak ?></td>
                            <td>
                              <?php
                              if ($d->posisi == '0') {
                                echo 'Member';
                              } elseif ($d->posisi == '1') {
                                echo 'Coordinator';
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
          <?php
          }
          ?>
        </div>
      </div>