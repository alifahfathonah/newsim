      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Edit Stock List<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="ibox">
              <div class="ibox-content">
                <form method="post" action="<?= base_url('Laboran/EditStockList/') ?>">
                  <input type="text" name="id_alat" id="id_alat" value="<?= $data->idAlat ?>" style="display: none">
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Barcode</label>
                        <input type="text" name="barcode_inventaris" id="barcode_inventaris" placeholder="Input Barcode" class="form-control" value="<?= $data->barcode ?>" required>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Name Stock List</label>
                        <input type="text" name="nama_inventaris" id="nama_inventaris" placeholder="Input Name Stock List" class="form-control" value="<?= $data->namaAlat ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Laboratory</label>
                        <select name="lab_inventaris" id="lab_inventaris" class="form-control laboratorium">
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
                        <label class="font-bold">Qty</label>
                        <input type="text" name="jumlah_inventaris" id="jumlah_inventaris" placeholder="Input Qty" class="touchspin1" value="<?= $data->jumlah ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Note</label>
                        <textarea name="catatan_inventaris" id="catatan_inventaris" class="form-control" rows="3" placeholder="Input Note"><?= $data->catatan ?></textarea>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Specification</label>
                        <textarea name="spesifikasi_inventaris" id="spesifikasi_inventaris" class="form-control" rows="3" placeholder="Input Specification"><?= $data->spesifikasi ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Condition</label>
                        <input type="text" name="kondisi_inventaris" id="kondisi_inventaris" placeholder="Input Condition" class="form-control" value="<?= $data->kondisi ?>" required>
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
                            <a href="<?= base_url('Laboran/StockLists') ?>"><button type="button" class="btn btn-danger btn-sm btn-block">Cancel</button></a>
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