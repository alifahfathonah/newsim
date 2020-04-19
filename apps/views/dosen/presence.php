      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <?php
          $nama_asprak = $this->db->get_where('asprak', array('nim_asprak' => userdata('nim')))->row();
          ?>
          <h2 style="text-align: center"><?= $nama_asprak->nama_asprak ?>'s Presence</h2>
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
            <div class="row">
              <div class="col-md-2 col-sm-2" style="margin-bottom: 5px">
                <a href="<?= base_url('Asprak/AddPresence') ?>">
                  <button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Presence</button>
                </a>
              </div>
            </div>
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover dataTables">
                    <thead>
                      <tr>
                        <th width="7%">No</th>
                        <th width="25%">Date</th>
                        <th width="5%">Start</th>
                        <th width="5%">End</th>
                        <th>Courses</th>
                        <th width="10%">Class</th>
                        <th>Modul</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($data as $d) {
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= tanggal_inggris($d->tanggal) ?></td>
                          <td><?= $d->masuk ?></td>
                          <td><?= $d->selesai ?></td>
                          <td><?= $d->nama_mk ?></td>
                          <td><?= $d->kelas ?></td>
                          <td><?= $d->modul ?></td>
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