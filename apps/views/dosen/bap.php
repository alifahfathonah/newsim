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
            $id_ta        = $this->db->get_where('tahun_ajaran', array('status' => '1'))->row()->id_ta;
            $id_dosen     = $this->db->get_where('users', array('idUser' => userdata('id')))->row()->id_dosen;
            $daftar_mk    = $this->db->get_where('daftar_mk', array('koordinator_mk' => $id_dosen))->result();
            foreach ($daftar_mk as $d) {
              $matakuliah = $this->db->get_where('matakuliah', array('kode_mk' => $d->kode_mk))->row();
            ?>
              <div class="ibox">
                <div class="ibox-title">
                  <h5><?= $matakuliah->kode_mk . ' - ' . $matakuliah->nama_mk ?></h5>
                  <div class="ibox-tools">
                    <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                    </a>
                  </div>
                </div>
                <div class="ibox-content">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="10%">NIM</th>
                          <th>Name</th>
                          <th width="10%">Periode</th>
                          <th width="10%">Status</th>
                          <th width="15%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 1;
                        $bap  = $this->m->daftarBAP($id_dosen, $d->id_daftar_mk)->result();
                        foreach ($bap as $b) {
                        ?>
                          <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $b->nim_asprak ?></td>
                            <td><?= $b->nama_asprak ?></td>
                            <td><?= bulanPanjang($b->bulan) ?></td>
                            <td>Not Approved</td>
                            <td style="text-align: center">
                              <a href="<?= base_url('BAP/ViewPresence/' . substr(sha1($b->id_honor), 7, 7)) ?>">
                                <button class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> See Presence</button>
                              </a>
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
            <?php
            }
            ?>
          </div>
        </div>
      </div>