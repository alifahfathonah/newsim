      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Practicum Laboratory<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover daftar_lab" width="100%">
                    <thead>
                      <tr>
                        <th width="7%">No</th>
                        <th>Laboratory</th>
                        <th>Location</th>
                        <th>Room</th>
                        <th>PIC</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($data as $d) {
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td>
                            <a href="<?= base_url('Laboratory/ViewLaboratory/' . substr(sha1($d->idLab), 6, 4)) ?>" style="color: #333"><?= $d->namaLab ?></a>
                          </td>
                          <td><?= $d->lokasiLab ?></td>
                          <td><?= $d->kodeRuang ?></td>
                          <td><?= $d->pembinaLab ?></td>
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