      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">History Login</h2>
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
                        <th width="5%">No</th>
                        <th width="27%">Time</th>
                        <th width="13%">IP</th>
                        <th>Location</th>
                        <th>Browser</th>
                        <th>Platform</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($data as $d) {
                        $tmp      = explode(' ', $d->tanggal_login);
                        $tanggal  = $tmp[0];
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= tanggalInggris($tanggal) . ' ' . $tmp[1] ?></td>
                          <td><?= $d->ip ?></td>
                          <td><?= $d->kota . ', ' . $d->provinsi ?></td>
                          <td><?= $d->browser ?></td>
                          <td><?= $d->platform ?></td>
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