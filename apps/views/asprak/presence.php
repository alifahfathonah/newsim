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
                        <th width="20%">Date</th>
                        <th width="5%">Start</th>
                        <th width="5%">End</th>
                        <th>Courses</th>
                        <th width="10%">Class</th>
                        <th>Modul</th>
                        <th width="7%">Action</th>
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
                          <td style="text-align: center">
                            <div class="tooltip-demo">
                              <?php
                              if ($d->approve_absen == '0') {
                              ?>
                                <a href="<?= base_url('Asprak/EditPresence/' . substr(sha1($d->id_presensi_asprak), 7, 7)) ?>">
                                  <button class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit your presence"><i class="fa fa-edit"></i></button>
                                </a>
                              <?php
                              } elseif ($d->approve_absen == '1') {
                              ?>
                                <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" title="Your presence approved by lecture"><i class="fa fa-check"></i></button>
                              <?php
                              }
                              ?>
                            </div>
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