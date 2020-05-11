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
                    <div class="row">
                      <div class="col-md-12">
                        <div>
                          <canvas id="lineChart" height="70"></canvas>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="margin-bottom: 15px">
                      <div class="col-md-2">
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addSubmission"><i class="fa fa-plus"></i></button>
                        <div class="modal inmodal fade" id="addSubmission" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title">Add Submission</h4>
                              </div>
                              <form method="post" action="<?= base_url('Finance/AddSubmission') ?>" enctype="multipart/form-data">
                                <div class="modal-body">
                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-bold">Type</label>
                                    <div class="col-sm-10">
                                      <select name="tipe_submission" id="tipe_submission" class="type_submission form-control">
                                        <option></option>
                                        <option value="01">Pertanggungan Umum</option>
                                        <option value="02">Honor Aslab</option>
                                        <option value="03">Honor Asprak</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-bold">Major</label>
                                    <div class="col-sm-10">
                                      <select name="prodi" id="prodi" class="prodi form-control">
                                        <option></option>
                                        <?php
                                        foreach ($prodi as $p) {
                                          echo '<option value="' . $p->kode_prodi . '">' . $p->strata . ' ' . $p->nama_prodi . '</option>';
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-bold">Year</label>
                                    <div class="col-sm-10">
                                      <select name="ta" id="ta" class="ta form-control">
                                        <option></option>
                                        <?php
                                        foreach ($tahun_ajaran as $t) {
                                          echo '<option value="' . $t->id_ta . '">' . $t->ta . '</option>';
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-bold">Period</label>
                                    <div class="col-sm-10">
                                      <select name="periode" id="periode" class="periode form-control">
                                        <option></option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-bold">Laboran</label>
                                    <div class="col-sm-10">
                                      <select name="pembuat" id="pembuat" class="pembuat form-control">
                                        <option></option>
                                        <?php
                                        foreach ($laboran as $l) {
                                          echo '<option value="' . $l->id_laboran . '">' . $l->nama_laboran . '</option>';
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-bold">File</label>
                                    <div class="col-sm-10">
                                      <div class="custom-file">
                                        <input type="file" name="file_csv" id="logo" class="custom-file-input">
                                        <label for="logo" class="custom-file-label">Choose file...</label>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover submission" width="100%">
                            <thead>
                              <tr>
                                <th>No PK</th>
                                <th>Information</th>
                                <th>Nominal</th>
                                <th>Date of Filing</th>
                                <th>Date Obtained</th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              foreach ($submission as $s) {
                                if ($s->kode_pk == '01') {
                                  $informasi = 'Pertanggungan Umum ' . $s->kode_prodi . ' - ' . $s->bulan;
                                } elseif ($s->kode_pk == '02') {
                                  $informasi = 'Honor Aslab ' . $s->kode_prodi . ' - ' . $s->bulan;
                                } elseif ($s->kode_pk == '03') {
                                  $informasi = 'Honor Asprak ' . $s->kode_prodi . ' - ' . $s->bulan;
                                }
                                if ($s->status_pk == '1') {
                                  $status = 'On Process';
                                } elseif ($s->status_pk == '2') {
                                  $status = 'Revision';
                                } elseif ($s->status_pk == '3') {
                                  $status = 'Done';
                                }
                              ?>
                                <tr>
                                  <td><?= $s->no_pk ?></td>
                                  <td><?= $informasi ?></td>
                                  <td style="text-align: right">Rp <?= number_format($s->total, 0, '', '.') ?></td>
                                  <td><?= $s->tanggal_pengajuan ?></td>
                                  <td><?= $s->tanggal_cair ?></td>
                                  <td><?= $status ?></td>
                                  <td><?= $s->status_pk ?></td>
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
                                      <?php
                                      if ($a->status == '1') {
                                        echo '<button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#upload_bukti' . $a->id_honor . '"><i class="fa fa-edit"></i></button>';
                                      ?>
                                        <div class="modal inmodal fade" id="upload_bukti<?= $a->id_honor ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title">Upload Evidence of Transfer</h4>
                                              </div>
                                              <form method="post" action="<?= base_url('Finance/UploadEvidence') ?>" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                  <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                      <div class="form-group">
                                                        <label class="font-bold">NIM</label>
                                                        <br>
                                                        <label><?= $a->nim_asprak ?></label>
                                                        <input type="text" name="id_honor" id="id_honor" value="<?= $a->id_honor ?>" style="display: none">
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                      <div class="form-group">
                                                        <label class="font-bold">Name</label>
                                                        <br>
                                                        <label><?= $a->nama_asprak ?></label>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                      <div class="form-group">
                                                        <label class="font-bold">Periode</label>
                                                        <br>
                                                        <label><?= $a->bulan ?></label>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                      <div class="form-group">
                                                        <label class="font-bold">Amount</label>
                                                        <br>
                                                        <label>Rp <?= number_format($a->nominal, 0, '', '.') ?></label>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                      <div class="form-group">
                                                        <label class="font-bold">Evidence of Transfer</label>
                                                        <div class="custom-file">
                                                          <input id="logo" type="file" class="custom-file-input" name="bukti_transfer" accept="image/*">
                                                          <label for="logo" class="custom-file-label">Choose file...</label>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                  <button type="submit" class="btn btn-primary">Upload</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      <?php
                                      }
                                      ?>
                                      <!-- <div id="btn_approve_honor<?= substr(sha1($a->id_honor), 7, 7) ?>">
                                        <?php
                                        if ($a->status == '1') {
                                        ?>
                                          <button class="btn btn-warning btn-sm" onclick="approve_honor('<?= substr(sha1($a->id_honor), 7, 7) ?>')"><i class="fa fa-check"></i></button>
                                        <?php
                                        } elseif ($a->status == '2') {
                                        ?>
                                          <button class="btn btn-success btn-sm" disabled><i class="fa fa-check"></i></button>
                                        <?php
                                        }
                                        ?>
                                      </div> -->
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
                          <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover asprak" width="100%">
                              <thead>
                                <tr>
                                  <th>No</th>
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
                                foreach ($withdraw_aslab as $w) {
                                ?>
                                  <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $w->nim ?></td>
                                    <td><?= $w->namaLengkap ?></td>
                                    <td><?= $w->bulan ?></td>
                                    <td style="text-align: right">Rp <?= number_format($w->nominal, 0, '', '.') ?></td>
                                    <td><?= $w->opsi_pengambilan ?></td>
                                    <td style="text-align: center"><button class="btn btn-sm btn-info" disabled><i class="fa fa-check"></i></button></td>
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
              </div>
            </div>
          </div>
        </div>
      </div>