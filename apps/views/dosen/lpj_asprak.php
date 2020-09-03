      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">LPJ Asprak</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover dataTables">
                    <thead>
                      <tr>
                        <th width="7%">No</th>
                        <th>Courses</th>
                        <th width="10%">Periode</th>
                        <th width="10%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 0;
                      foreach ($daftar_lpj as $d) {
                        $no++;
                        $data_mk = $this->db->where('kode_mk', $d->kode_mk)->get('matakuliah')->row();
                        $data_ta = $this->db->where('id_ta', $d->id_ta)->get('tahun_ajaran')->row();
                        $data_laporan = $this->db->where('id_daftar_mk', $d->id_daftar_mk)->get('laporan_praktikum')->row();
                      ?>
                      <tr>
                        <td><?=$no?></td>
                        <td><?=$data_mk->kode_mk .' - '. $data_mk->nama_mk?></td>
                        <td><?=$data_ta->ta?></td>
                        <td style="text-align: center;">
                          <form method="post" action="<?= base_url('Practicum/ReadReport') ?>" target="_blank">
                            <input type="text" name="id_laporan_praktikum" value="<?= $data_laporan->id_laporan_praktikum ?>" style="display: none;">
                            <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></button>
                          </form>
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
          foreach ($daftar_lpj as $d) {
            $nama_mk  = $this->db->select('kode_mk, nama_mk')->from('matakuliah')->where('kode_mk', $d->kode_mk)->get()->row();
          ?>
          <?php
          }
          ?>
        </div>
      </div>