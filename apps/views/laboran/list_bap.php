      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">BAP<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="row" style="margin-bottom: 5px">
              <div class="col-md-1">
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#printBAP"><i class="fa fa-print"></i> Print BAP</button>
                <div class="modal inmodal" id="printBAP" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content animated bounceInRight">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Modal title</h4>
                      </div>
                      <form>
                        <div class="modal-body">
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label font-bold">Courses</label>
                            <div class="col-sm-10">
                              <select name="matkul" id="matkul" class="matkul form-control">
                                <option></option>
                                <?php
                                $matkul = $this->db->order_by('kode_mk')->get('matakuliah')->result();
                                foreach ($matkul as $m) {
                                  // echo '<option value="' . $p->kode_prodi . '">' . $p->strata . ' ' . $p->nama_prodi . '</option>';
                                  echo '<option>' . $m->kode_mk . ' - ' . $m->nama_mk . '</option>';
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
                                <?php
                                $periode_asprak = $this->db->where('asprak', '1')->order_by('angka_bulan')->get('periode')->result();
                                foreach ($periode_asprak as $pa) {
                                  echo '<option value="' . $pa->angka_bulan . '">' . bulanPanjang($pa->angka_bulan) . '</option>';
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Print</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-5 offset-md-1">
                <select name="matakuliah" class="form-control daftar_mk">
                  <option></option>
                  <?php
                  $matakuliah = $this->db->order_by('kode_mk', 'asc')->get('matakuliah')->result();
                  foreach ($matakuliah as $m) {
                    echo '<option value="' . $m->id_mk . '">' . $m->kode_mk . ' | ' . $m->nama_mk . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-3">
                <select name="periode" class="form-control periode">
                  <option>
                    <?php
                    $periode = $this->db->where('asprak', '1')->order_by('angka_bulan')->get('periode')->result();
                    foreach ($periode as $p) {
                      echo '<option value="' . $p->id_periode . '">' . $p->id_periode . ' | ' . bulanPanjang($p->angka_bulan) . '</option>';
                    }
                    ?>
                  </option>
                </select>
              </div>
              <div class="col-md-1">
                <button type="submit" class="btn btn-primary btn-sm col-sm-12"><i class="fa fa-filter"></i> Filter</button>
              </div>
            </div>
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover bap" width="100%">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Name</th>
                        <th>Courses</th>
                        <th>Approved</th>
                        <th>Periode</th>
                        <th>Year</th>
                        <th width="10%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>