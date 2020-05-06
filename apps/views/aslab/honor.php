      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Honor<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover dataTables" width="100%">
                    <thead>
                      <tr>
                        <th width="7%">No</th>
                        <th>Hour</th>
                        <th>Nominal</th>
                        <th>Periode</th>
                        <th>Withdraw Option</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($data as $d) {
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $d->jam ?> Hours</td>
                          <td style="text-align: right">Rp <?= number_format($d->nominal, 0, '', '.') ?></td>
                          <td><?= $d->bulan ?></td>
                          <td><?= $d->opsi_pengambilan ?></td>
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