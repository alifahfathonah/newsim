      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Laboratory Report<br>School of Applied Science School's Laboratory</h2>
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
            <div class="row">
              <div class="col-md-2 col-sm-2" style="margin-bottom: 5px">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal5"><i class="fa fa-plus"></i> Add Laboratory Report</button>
                <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Add Laboratory Report</h4>
                      </div>
                      <form method="post" action="<?= base_url('LaboratoryAssistant/Report') ?>" enctype="multipart/form-data">
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">Laboratory</label>
                                <select name="lab" id="lab" class="laboratorium form-control">
                                  <option></option>
                                  <?php
                                  foreach ($lab as $l) {
                                    echo '<option value="' . $l->idLab . '">' . $l->namaLab . '</option>';
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">File</label>
                                <div class="custom-file">
                                  <input type="file" name="file_laporan" id="file_laporan" accept="application/pdf" class="custom-file-input">
                                  <label for="logo" class="custom-file-label">Choose file...</label>
                                </div>
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
              </div>
            </div>
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover dataTables">
                    <thead>
                      <tr>
                        <th width="7%">No</th>
                        <th width="20%">Date Submit</th>
                        <th>Laboratory</th>
                        <th width="20%">Revision Notes</th>
                        <th width="10%">Status</th>
                        <th width="10%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($data as $d) {
                        if ($d->status_laporan == '0') {
                          $status = 'On Progress';
                        }
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= tanggal_inggris2($d->tanggal_upload) ?></td>
                          <td><?= $d->namaLab ?></td>
                          <td><?= $d->catatan_revisi ?></td>
                          <td><?= $status ?></td>
                          <td style="text-align: center">
                            <a href="<?= base_url($d->nama_file) ?>" target="_blank"><button class="btn btn-sm btn-info"><i class="fa fa-eye"></i></button></a>
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