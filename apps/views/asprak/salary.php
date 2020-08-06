      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Salary</h2>
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
                          <form method="post" action="<?= base_url('Asprak/TakeSalary') ?>">
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
                                  $cek_akun = $this->db->where('nim_asprak', userdata('nim'))->get('asprak')->row();
                                  if ($cek_akun == true) {
                                    if ($cek_akun->norek_asprak != null || $cek_akun->norek_asprak != '') {
                                      echo '<div class="radio">
                                      <input type="radio" name="pilihan" id="transfer" value="Transfer">
                                      <label for="transfer">Bank Transfer</label>
                                    </div>';
                                    }
                                    if ($cek_akun->linkaja_asprak != null || $cek_akun->linkaja_asprak != '') {
                                      echo '<div class="radio">
                                      <input type="radio" name="pilihan" id="linkaja" value="LinkAja">
                                      <label for="linkaja">Linkaja</label>
                                    </div>';
                                    }
                                    if (($cek_akun->norek_asprak == null || $cek_akun->norek_asprak == '') && ($cek_akun->linkaja_asprak == null || $cek_akun->linkaja_asprak == '')) {
                                      echo '<h4>Please complete your profile</h4>';
                                    }
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
                        <th width="30%">Subject</th>
                        <th width="10%">Year</th>
                        <th width="16%">Periode</th>
                        <th width="12%">Amount</th>
                        <th width="12%">Status</th>
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
                          <td><?= $d->kode_mk . ' - ' . $d->nama_mk ?></td>
                          <td><?= $d->ta ?></td>
                          <td><?= $d->bulan . ' ' . $d->tahun ?></td>
                          <td style="text-align: right">Rp <?= number_format($d->nominal, 0, '', '.') ?></td>
                          <td>Untaken</td>
                          <td style="text-align: center">
                            <div class="checkbox checkbox-primary">
                              <input type="checkbox" name="honor" id="honor<?= $no ?>" value="<?= $d->nominal . '|' . $d->id_honor ?>" class="honor">
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
                        <th width="30%">Subject</th>
                        <th width="10%">Year</th>
                        <th width="16%">Periode</th>
                        <th width="12%">Amount</th>
                        <th width="12%">Status</th>
                        <th>Payment Method</th>
                        <th>Evidence of Transfer</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($honor as $d) {
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $d->kode_mk . ' - ' . $d->nama_mk ?></td>
                          <td><?= $d->ta ?></td>
                          <td><?= $d->bulan . ' ' . $d->tahun ?></td>
                          <td style="text-align: right">Rp <?= number_format($d->nominal, 0, '', '.') ?></td>
                          <td>
                            <?php
                            if ($d->status == '1') {
                              echo 'Requested';
                            } elseif ($d->status == '2') {
                              echo 'Taken';
                            }
                            ?>
                          </td>
                          <td><?= $d->opsi_pengambilan ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($d->status == '1') {
                              echo '<button class="btn btn-sm btn-danger" disabled><i class="fa fa-ban"></i></button>';
                            } elseif ($d->status == '2') {
                              if ($d->opsi_pengambilan != 'Cash') {
                                echo '<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#bukti' . $d->id_honor . '"><i class="fa fa-eye"></i></button>';
                            ?>
                                <div class="modal inmodal fade" id="bukti<?= $d->id_honor ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                        <h4 class="modal-title">Evidence of Transfer</h4>
                                      </div>
                                      <div class="modal-body">
                                        <img src="<?= base_url($d->bukti_transfer) ?>" height="350px">
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            <?php
                              }
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