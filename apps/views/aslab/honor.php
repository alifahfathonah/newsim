      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Salary<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="ibox">
              <div class="ibox-content">
                <div class="row" style="text-align: right">
                  <div class="col-md-2 offset-md-10" style="margin-bottom: 5px">
                    <button type="button" class="btn btn-primary btn-sm" id="cek_alert" data-toggle="modal" data-target="#alert_honor" disabled>
                      <i class="fa fa-hand-lizard-o"></i> Take Salary
                    </button>
                    <div class="modal inmodal fade" id="alert_honor" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Take Salary</h4>
                          </div>
                          <form method="post" action="<?= base_url('Finance/TakeSalary') ?>">
                            <div class="modal-body" style="font-size: 15px">
                              <p style="text-align: center">You will receive a salary of <span id="modal_total_honor"></span></p>
                              <input type="text" name="id_honor" id="id_honor" style="display: none">
                              <div class="row" style="text-align: left; font-size: 13px">
                                <div class="col-md-4 offset-md-5">
                                  <!-- <div class="radio">
                                    <input type="radio" name="pilihan" id="cash" value="Cash">
                                    <label for="cash">Cash</label>
                                  </div> -->
                                  <?php
                                  if ($cek_aslab->norek != null) {
                                  ?>
                                    <div class="radio">
                                      <input type="radio" name="pilihan" id="transfer" value="Transfer">
                                      <label for="transfer">Bank Transfer</label>
                                    </div>
                                  <?php
                                  }
                                  if ($cek_aslab->linkaja != null) {
                                  ?>
                                    <div class="radio">
                                      <input type="radio" name="pilihan" id="linkaja" value="LinkAja">
                                      <label for="linkaja">Linkaja</label>
                                    </div>
                                  <?php
                                  }
                                  ?>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-success">Submit</button>
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th width="7%">No</th>
                        <th>Periode</th>
                        <th>Year</th>
                        <th>Hour</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($proses as $p) {
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $p->bulan ?></td>
                          <td><?= $p->ta ?></td>
                          <td><?= $p->jam ?> Hours</td>
                          <td style="text-align: right">Rp <?= number_format($p->nominal, 0, '', '.') ?></td>
                          <td>
                            <?php
                            if ($p->status_honor == '0') {
                              echo 'On Process';
                            } elseif ($p->status_honor == '1') {
                              echo 'Ready to Take';
                            } elseif ($p->status_honor == '2') {
                              echo 'Requested';
                            }
                            ?>
                          </td>
                          <td style="text-align: center">
                            <div class="checkbox checkbox-primary">
                              <input type="checkbox" name="honor" id="honor<?= $no ?>" value="<?= $p->nominal . '|' . $p->id_honor_aslab ?>" class="honor">
                              <label for="honor<?= $no ?>">&nbsp;</label>
                            </div>
                          </td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                  <h2 style="text-align: right" id="total_honor">Rp 0</h2>
                  <hr style="color: solid #ccc">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th width="7%">No</th>
                        <th>Periode</th>
                        <th>Year</th>
                        <th>Hour</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Withdraw Option</th>
                        <th>View Evidence</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($selesai as $p) {
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $p->bulan ?></td>
                          <td><?= $p->ta ?></td>
                          <td><?= $p->jam ?> Hours</td>
                          <td style="text-align: right">Rp <?= number_format($p->nominal, 0, '', '.') ?></td>
                          <td>
                            <?php
                            if ($p->status_honor == '0') {
                              echo 'On Process';
                            } elseif ($p->status_honor == '1') {
                              echo 'Ready to Take';
                            } elseif ($p->status_honor == '2') {
                              echo 'Requested';
                            } elseif ($p->status_honor == '3') {
                              echo 'Taken';
                            }
                            ?>
                          </td>
                          <td><?= $p->opsi_pengambilan ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($p->opsi_pengambilan == 'Cash') {
                              echo '<button class="btn btn-sm btn-danger" disabled><i class="fa fa-ban"></i></button>';
                            } else {
                            ?>
                              <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#evidence<?= $p->id_honor_aslab ?>"><i class="fa fa-eye"></i></button>
                              <div class="modal inmodal fade" id="evidence<?= $p->id_honor_aslab ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <h4 class="modal-title">Evidence for Salary <?= $p->bulan ?></h4>
                                    </div>
                                    <div class="modal-body">
                                      <img src="<?= base_url($p->bukti_transfer) ?>" height="400px">
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <?php
                            }
                            ?>
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