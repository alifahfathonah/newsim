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
                        <th>Periode</th>
                        <th>Year</th>
                        <th>Hour</th>
                        <th>Nominal</th>
                        <th>Withdraw Option</th>
                        <th>Status Withdraw</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($data as $d) {
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $d->bulan ?></td>
                          <td><?= $d->ta ?></td>
                          <td><?= $d->jam ?> Hours</td>
                          <td style="text-align: right">Rp <?= number_format($d->nominal, 0, '', '.') ?></td>
                          <td><?= $d->opsi_pengambilan ?></td>
                          <td>
                            <?php
                            if ($d->status_honor == '0') {
                              echo 'On Process';
                            } elseif ($d->status_honor == '1') {
                              echo 'Ready to Take';
                            } elseif ($d->status_honor == '2') {
                              echo 'Requested';
                            } elseif ($d->status_honor == '3') {
                              echo 'Taken';
                            }
                            ?>
                          </td>
                          <td style="text-align: center">
                            <?php
                            if ($d->status_honor == '0') {
                              echo '<button class="btn btn-sm btn-warning" disabled><i class="fa fa-ban"></i></button>';
                            } elseif ($d->status_honor == '1') {
                              echo '<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#pilih' . $d->id_honor_aslab . '"><i class="fa fa-hand-lizard-o"></i></button>';
                            } elseif ($d->status_honor == '2') {
                              echo '<button class="btn btn-sm btn-warning" disabled><i class="fa fa-ban"></i></button>';
                            } elseif ($d->status_honor == '3') {
                              echo '<button class="btn btn-sm btn-warning" disabled><i class="fa fa-ban"></i></button>';
                            }
                            ?>
                          </td>
                        </tr>
                        <div class="modal inmodal fade" id="pilih<?= $d->id_honor_aslab ?>" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title">Take Salary</h4>
                              </div>
                              <form method="post" action="<?= base_url('Finance/HonorAslab') ?>">
                                <div class="modal-body" style="font-size: 15px">
                                  <p style="text-align: center">You will receive a salary of Rp <?= number_format($d->nominal, 0, '', '.') ?></p>
                                  <input type="text" name="id_honor_aslab" id="id_honor_aslab" style="display: none" value="<?= $d->id_honor_aslab ?>">
                                  <div class="row" style="text-align: left; font-size: 13px">
                                    <div class="col-md-4 offset-md-5">
                                      <div class="radio">
                                        <input type="radio" name="pilihan" id="cash" value="Cash">
                                        <label for="cash">Cash</label>
                                      </div>
                                      <div class="radio">
                                        <input type="radio" name="pilihan" id="saved" value="Saved">
                                        <label for="saved">Saved</label>
                                      </div>
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