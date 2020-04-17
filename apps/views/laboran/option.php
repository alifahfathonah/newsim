      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Option SIM Laboratorium<br>School of Applied Science School's Laboratory</h2>
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
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <form method="post" action="<?= base_url('Option') ?>">
                      <div class="table-responsive">
                        <table width="98%">
                          <tbody>
                            <tr>
                              <td colspan="3" style="padding-bottom: 20px">
                                <button type="button" class="btn btn-success btn-block" style="text-align: left" disabled>Periode</button>
                              </td>
                            </tr>
                            <tr>
                              <td width="22%">Periode & Semester</td>
                              <td width="2%">:</td>
                              <td style="padding-bottom: 5px">
                                <select name="periode" id="periode" class="periode form-control">
                                  <option></option>
                                  <?php
                                  foreach ($periode as $p) {
                                    if ($p->status == '1') {
                                      echo '<option value="' . $p->id_ta . '" selected>' . $p->ta . '</option>';
                                    } else {
                                      echo '<option value="' . $p->id_ta . '">' . $p->ta . '</option>';
                                    }
                                  }
                                  ?>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="padding: 20px 0 20px 0">
                                <button type="button" class="btn btn-success btn-block" style="text-align: left" disabled>Finance</button>
                              </td>
                            </tr>
                            <tr>
                              <td>Honor Practicum Assistant</td>
                              <td>:</td>
                              <td style="padding-bottom: 5px">
                                <select name="tarif" id="tarif" class="tarif form-control">
                                  <option></option>
                                  <?php
                                  foreach ($tarif as $t) {
                                    if ($t->status == '1') {
                                      echo '<option value="' . $t->id_tarif . '" selected>Rp ' . number_format($t->tarif_honor, 0, ',', '.') . '</option>';
                                    } else {
                                      echo '<option value="' . $t->id_tarif . '">Rp ' . number_format($t->tarif_honor, 0, ',', '.') . '</option>';
                                    }
                                  }
                                  ?>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="padding: 20px 0 20px 0">
                                <button type="button" class="btn btn-success btn-block" style="text-align: left" disabled>Position</button>
                              </td>
                            </tr>
                            <tr>
                              <td>Ka.Ur. Laboratorium/Bengkel/Studio</td>
                              <td>:</td>
                              <td style="padding-bottom: 5px">

                              </td>
                            </tr>
                            <tr>
                              <td colspan="3">
                                <div class="form-group" style="margin-top: 20px">
                                  <div class="row">
                                    <div class="col-md-1 col-sm-2">
                                      <button type="submit" class="btn btn-primary btn-sm btn-block">Save</button>
                                    </div>
                                    <div class="col-md-1 col-sm-4">
                                      <button type="reset" class="btn btn-warning btn-sm btn-block">Reset</button>
                                    </div>
                                    <div class="col-md-1 col-sm-4">
                                      <button type="button" class="btn btn-danger btn-sm btn-block">Cancel</button>
                                    </div>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>