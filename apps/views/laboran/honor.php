      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Honor<br>School of Applied Science School's Laboratory</h2>
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
            <div class="tabs-container">
              <ul class="nav nav-tabs" role="tablist">
                <li><a class="nav-link active" data-toggle="tab" href="#pengajuan"> Submission</a></li>
                <li><a class="nav-link" data-toggle="tab" href="#pengambilan"> Withdraw</a></li>
              </ul>
              <div class="tab-content">
                <div role="tabpanel" id="pengajuan" class="tab-pane active">
                  <div class="panel-body">
                    <h2 style="text-align: center">Under Construction</h2>
                  </div>
                </div>
                <div role="tabpanel" id="pengambilan" class="tab-pane">
                  <div class="panel-body">
                    <ul class="nav nav-tabs" role="tablist">
                      <li><a class="nav-link active" data-toggle="tab" href="#asprak"> Asprak</a></li>
                      <li><a class="nav-link" data-toggle="tab" href="#aslab"> Aslab</a></li>
                    </ul>
                    <div class="tab-content">
                      <div role="tabpanel" id="asprak" class="tab-pane active">
                        <div class="panel-body">
                          <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover asprak" width="100%">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Courses Code</th>
                                  <th>Courses</th>
                                  <th>NIM</th>
                                  <th>Name</th>
                                  <th>Periode</th>
                                  <th>Amount</th>
                                  <th>Withdraw Option</th>
                                  <th>Status</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $no = 1;
                                foreach ($withdraw_asprak as $a) {
                                ?>
                                  <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $a->kode_mk ?></td>
                                    <td><?= $a->nama_mk ?></td>
                                    <td><?= $a->nim_asprak ?></td>
                                    <td><?= $a->nama_asprak ?></td>
                                    <td><?= $a->bulan ?></td>
                                    <td style="text-align: right">Rp <?= number_format($a->nominal, 0, '', '.') ?></td>
                                    <td><?= $a->opsi_pengambilan ?></td>
                                    <td>
                                      <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detail<?= $a->id_honor ?>"><i class="fa fa-eye"></i></button>
                                      <div id="btn_approve_honor<?= substr(sha1($a->id_honor), 7, 7) ?>">
                                        <?php
                                        if ($a->status == '1') {
                                        ?>
                                          <button class="btn btn-success btn-sm" onclick="approve_honor('<?= substr(sha1($a->id_honor), 7, 7) ?>')"><i class="fa fa-check"></i></button>
                                        <?php
                                        } elseif ($a->status == '2') {
                                        ?>
                                          <button class="btn btn-success btn-sm" disabled><i class="fa fa-check"></i></button>
                                        <?php
                                        }
                                        ?>
                                      </div>
                                    </td>
                                  </tr>
                                  <div class="modal inmodal fade" id="detail<?= $a->id_honor ?>" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                          <h4 class="modal-title">Detail Withdraw</h4>
                                        </div>
                                        <div class="modal-body">
                                          <div class="form-group row">
                                            <label class="col-md-5 col-sm-6 col-form-label">NIM</label>
                                            <label class="col-md-5 col-sm-6 col-form-label"><?= $a->nim_asprak ?></label>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-md-5 col-sm-6 col-form-label">Name</label>
                                            <label class="col-md-5 col-sm-6 col-form-label"><?= $a->nama_asprak ?></label>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-md-5 col-sm-6 col-form-label">Amount</label>
                                            <label class="col-md-5 col-sm-6 col-form-label">Rp <?= number_format($a->nominal, 0, '', '.') ?></label>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-md-5 col-sm-6 col-form-label">Withdraw Option</label>
                                            <label class="col-md-5 col-sm-6 col-form-label"><?= $a->opsi_pengambilan ?></label>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-md-5 col-sm-6 col-form-label">Bank Account Number</label>
                                            <label class="col-md-2 col-sm-6 col-form-label"><?= $a->norek_asprak ?></label>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-md-5 col-sm-6 col-form-label">LinkAja</label>
                                            <label class="col-md-2 col-sm-6 col-form-label"><?= $a->linkaja_asprak ?></label>
                                          </div>
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
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div role="tabpanel" id="aslab" class="tab-pane">
                        <div class="panel-body">
                          <h2 style="text-align: center">Under Construction</h2>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>