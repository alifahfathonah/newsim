      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">BAP<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="row" style="margin-bottom: 5px">
              <div class="col-md-6 offset-md-1">
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
                    $periode = $this->db->where('asprak', '1')->order_by('id_periode')->get('periode')->result();
                    foreach ($periode as $p) {
                      echo '<option value="' . $p->id_periode . '">' . $p->id_periode . ' | ' . $p->bulan . '</option>';
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