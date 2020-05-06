      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">List of Practicum Assistant</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <?php
          $id_dosen   = $this->db->get_where('users', array('idUser' => userdata('id')))->row();
          $id_ta      = $this->db->get_where('tahun_ajaran', array('status' => '1'))->row()->id_ta;
          $daftar_mk  = $this->db->select('id_daftar_mk, kode_mk')->from('daftar_mk')->where('id_ta', $id_ta)->where('koordinator_mk', $id_dosen->id_dosen)->get()->result();
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
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $daftar_asprak = $this->db->select('asprak.nim_asprak, asprak.nama_asprak, asprak.kontak_asprak, asprak.email_asprak')->from('daftarasprak')->join('asprak', 'daftarasprak.nim_asprak = asprak.nim_asprak')->where('daftarasprak.id_daftar_mk', $d->id_daftar_mk)->order_by('asprak.nim_asprak', 'asc')->get()->result();
                        $no = 1;
                        foreach ($daftar_asprak as $d) {
                        ?>
                          <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $d->nim_asprak ?></td>
                            <td><?= $d->nama_asprak ?></td>
                            <td><?= $d->kontak_asprak ?></td>
                            <td><?= $d->email_asprak ?></td>
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