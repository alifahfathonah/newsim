      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Practicum Report</h2>
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
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPracticumReport"><i class="fa fa-plus"></i> Add Practicum Report</button>
                <div class="modal inmodal fade" id="addPracticumReport" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Add Practicum Report</h4>
                      </div>
                      <form method="post" action="<?= base_url('Asprak/PracticumReport') ?>" enctype="multipart/form-data">
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                <label class="font-bold">Courses</label>
                                <select name="daftar_mk" id="daftar_mk" class="matkul form-control">
                                  <option></option>
                                  <?php
                                  $jumlah = $this->db->select('count(id_daftar_asprak) jumlah')->from('daftarasprak')->where('nim_asprak', userdata('nim'))->group_by('nim_asprak')->get()->row()->jumlah;
                                  $id_daftar_mk = $this->db->select('id_daftar_mk')->from('daftarasprak')->where('nim_asprak', userdata('nim'))->get()->result_array();
                                  if ($jumlah > 0) {
                                    for ($i = 0; $i < $jumlah; $i++) {
                                      $nama_mk = $this->db->select('daftar_mk.id_daftar_mk, daftar_mk.kode_mk, matakuliah.nama_mk')->from('daftar_mk')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('daftar_mk.id_daftar_mk', $id_daftar_mk[$i]['id_daftar_mk'])->get()->row();
                                  ?>
                                      <option value="<?= $nama_mk->id_daftar_mk ?>"><?= $nama_mk->kode_mk . ' - ' . $nama_mk->nama_mk ?></option>
                                  <?php
                                    }
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
                        <th>Courses</th>
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
                        } elseif ($d->status_laporan == '1') {
                          $status = 'Revision';
                        } elseif ($d->status_laporan == '2') {
                          $status = 'Done';
                        }
                      ?>
                        <tr>
                          <td><?= $no ?></td>
                          <td><?= tanggal_inggris2($d->tanggal) . ' ' . $d->jam ?></td>
                          <td><?= $d->kode_mk . ' - ' . $d->nama_mk ?></td>
                          <td><?= $d->catatan_revisi ?></td>
                          <td><?= $status ?></td>
                          <td style="text-align: center">
                            <a href="<?= base_url($d->nama_file) ?>" target="_blank"><button class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button></a>
                            <?php
                            if ($d->status_laporan == '1') {
                              echo '<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editPracticumReport' . $d->id_laporan_praktikum . '"><i class="fa fa-edit"></i></button>';
                            ?>
                              <div class="modal inmodal fade" id="editPracticumReport<?= $d->id_laporan_praktikum ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                      <h4 class="modal-title">Revision Practicum Report</h4>
                                    </div>
                                    <form method="post" action="<?= base_url('Asprak/RevisionReport') ?>" enctype="multipart/form-data">
                                      <div class="modal-body">
                                        <div class="row">
                                          <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                              <label class="font-bold">File</label>
                                              <input type="text" name="id_laporan" id="id_laporan" value="<?= $d->id_laporan_praktikum ?>" style="display: none">
                                              <input type="text" name="id_daftar_mk" id="id_daftar_mk" value="<?= $d->id_daftar_mk ?>" style="display: none">
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