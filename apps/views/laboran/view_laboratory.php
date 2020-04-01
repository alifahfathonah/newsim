      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center"><?= $data->namaLab ?> Laboratory<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="ibox">
              <?php
              if ($data->gambarLab) {
                echo '<img src="' . base_url($data->gambarLab) . '" height="300px" width="100%">';
              } else {
                echo '<img src="' . base_url('assets/img/blank.jpg') . '" height="300px" width="100%">';
              }
              ?>
            </div>
          </div>
          <div class="col-md-6 col-sm-12">
            <div class="ibox">
              <div class="ibox-title">
                <h5><?= $data->namaLab ?> Laboratory</h5>
              </div>
              <div class="ibox-content">
                <table width="100%">
                  <tr>
                    <td width="40%" style="font-weight: bold; text-align: right; padding-right: 5%">Lecture in Charge</td>
                    <td width="40%" style="text-align: left"><?= $data->pembinaLab ?></td>
                  </tr>
                  <tr>
                    <td width="40%" style="font-weight: bold; text-align: right; padding-right: 5%">Location</td>
                    <td width="40%" style="text-align: left"><?= $data->lokasiLab ?></td>
                  </tr>
                  <tr>
                    <td width="40%" style="font-weight: bold; text-align: right; padding-right: 5%">Type of Laboratory</td>
                    <td width="40%" style="text-align: left"><?= $data->tipeLab ?></td>
                  </tr>
                  <?php
                  if ($data->tipeLab == 'Practicum Lab') {
                  ?>
                    <tr>
                      <td width="40%" style="font-weight: bold; text-align: right; padding-right: 5%">Aslab In Charge</td>
                      <td width="40%" style="text-align: left">
                        <?php
                        foreach ($aslab as $a) {
                          echo $a->namaLengkap . '<br>';
                        }
                        ?>
                      </td>
                    </tr>
                  <?php
                  }
                  ?>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="ibox">
              <div class="ibox-title">
                <h5>List Equipment</h5>
              </div>
              <div class="ibox-content">
                <table class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Equipment</th>
                      <th>Qty</th>
                      <th>Condition</th>
                      <th>Notes</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    foreach ($inventaris as $i) {
                    ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $i->namaAlat ?></td>
                        <td><?= $i->jumlah ?></td>
                        <td><?= $i->kondisi ?></td>
                        <td><?= $i->catatan ?></td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- <div class="col-md-6 col-sm-12">
            <div class="ibox">
              <div class="ibox-title">
                <h5>Track Equipment</h5>
              </div>
              <div class="ibox-content">
                <table class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Equipment</th>
                      <th>Qty</th>
                      <th>Condition</th>
                      <th>Notes</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    foreach ($inventaris as $i) {
                    ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $i->namaAlat ?></td>
                        <td><?= $i->jumlah ?></td>
                        <td><?= $i->kondisi ?></td>
                        <td><?= $i->catatan ?></td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div> -->
        </div>
      </div>