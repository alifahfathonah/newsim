      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Edit Complaint<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="ibox">
              <div class="ibox-content">
                <form method="post" action="<?= base_url('Complaint/EditComplaint/' . uri('3')) ?>">
                  <div class="row">
                    <div class="col-md-3 col-sm-6">
                      <div class="form-group" id="tanggal_komplain">
                        <label class="font-bold">Complaint Date</label>
                        <div class="input-group date">
                          <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </span>
                          <?php
                          $tgl_komplain = explode('-', $data->tglKomplain);
                          $tmp          = array($tgl_komplain[1], $tgl_komplain[2], $tgl_komplain[0]);
                          $tgl_komplain = implode('/', $tmp);
                          ?>
                          <input type="text" name="tgl_komplain" id="tgl_komplain" class="form-control" value="<?= $tgl_komplain ?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                      <div class="form-group" id="tanggal_komplain">
                        <label class="font-bold">Solved Date</label>
                        <div class="input-group date">
                          <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </span>
                          <?php
                          if ($data->tglDiatasi == null) {
                            $tgl_diatasi = '';
                          } else {
                            $tgl_diatasi  = explode('-', $data->tglDiatasi);
                            $tmp          = array($tgl_diatasi[1], $tgl_diatasi[2], $tgl_komplain[0]);
                            $tgl_diatasi  = implode('/', $tmp);
                          }
                          ?>
                          <input type="text" name="tgl_diatasi" id="tgl_diatasi" class="form-control" value="<?= $tgl_diatasi ?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Informer</label>
                        <input type="text" name="informer_komplain" id="informer_komplain" placeholder="Input Informer Name" class="form-control" value="<?= $data->namaInforman ?>" required>
                      </div>
                    </div>
                    <div class="col-md-6 offset-md-6 col-sm-6">
                      <div class="col-sm-10">
                        <label class="checkbox-inline i-checks" style="padding-right: 20px;">
                          <input type="radio" name="jenis_informan" id="jenis_informan" value="Student" <?php if ($data->jenisInforman == 'Student') echo 'checked'; ?>> Student
                        </label>
                        <label class="checkbox-inline i-checks" style="padding-right: 20px;">
                          <input type="radio" name="jenis_informan" id="jenis_informan" value="Asprak" <?php if ($data->jenisInforman == 'Asprak') echo 'checked'; ?>> Asprak
                        </label>
                        <label class="checkbox-inline i-checks" style="padding-right: 20px;">
                          <input type="radio" name="jenis_informan" id="jenis_informan" value="Lecture" <?php if ($data->jenisInforman == 'Lecture') echo 'checked'; ?>> Lecture
                        </label>
                        <label class="checkbox-inline i-checks" style="padding-right: 20px;">
                          <input type="radio" name="jenis_informan" id="jenis_informan" value="Aslab" <?php if ($data->jenisInforman == 'Aslab') echo 'checked'; ?>> Aslab
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Laboratory</label>
                        <select name="lab_komplain" id="lab_komplain" class="form-control laboratorium">
                          <option></option>
                          <?php
                          foreach ($lab as $l) {
                            if ($l->idLab == $data->idLab) {
                              echo '<option value="' . $l->idLab . '" selected>' . $l->namaLab . '</option>';
                            } else {
                              echo '<option value="' . $l->idLab . '">' . $l->namaLab . '</option>';
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Equipment</label>
                        <input type="text" name="nama_alat" id="nama_alat" class="form-control" placeholder="Input Name Equipment" value="<?= $data->namaAlat ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Solution</label>
                        <input type="text" name="solusi_komplain" id="solusi_komplain" class="form-control" placeholder="Input Solution" value="<?= $data->solusi ?>">
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Done By</label>
                        <input type="text" name="diselesaikan_oleh" id="diselesaikan_oleh" class="form-control" placeholder="Input Name" value="<?= $data->diperbaikiOleh ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Complaint</label>
                        <textarea name="komplain" id="komplain" class="form-control" placeholder="Input Complaint"><?= $data->catatanKomplain ?></textarea>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group" style="margin-top: 30px">
                        <div class="row">
                          <div class="col-md-4 col-sm-4" style="margin-bottom: 5px">
                            <button type="submit" class="btn btn-primary btn-sm btn-block">Save</button>
                          </div>
                          <div class="col-md-4 col-sm-4" style="margin-bottom: 5px">
                            <button type="reset" class="btn btn-warning btn-sm btn-block">Reset</button>
                          </div>
                          <div class="col-md-4 col-sm-4" style="margin-bottom: 5px">
                            <a href="<?= base_url('Complaint') ?>"><button type="button" class="btn btn-danger btn-sm btn-block">Cancel</button></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>