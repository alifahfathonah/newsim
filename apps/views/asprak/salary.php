      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Salary</h2>
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
                        <th width="7%">No</th>
                        <th>Subject</th>
                        <th>Periode</th>
                        <th width="12%">Amount</th>
                        <th width="12%">Status</th>
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
                          <td><?= $d->kode_mk . ' - ' . $d->nama_mk ?></td>
                          <td><?= $d->bulan . ' ' . $d->tahun ?></td>
                          <td style="text-align: right">Rp <?= number_format($d->nominal, 0, '', '.') ?></td>
                          <td>Untaken</td>
                          <td><?= $d->nominal ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                  <h2 style="text-align: right" id="total_honor">Rp 0</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>