      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Edit Borrowing Laboratory<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="ibox">
              <div class="ibox-content">
                <form method="post" action="<?= base_url('Borrowing/EditBorrowingLaboratory/' . uri('3')) ?>">
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Borrower</label>
                        <input type="text" name="nama_peminjam" id="nama_peminjam" placeholder="Input Name Borrower" class="form-control" value="<?= $detail->namaPeminjam ?>" required>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">NIP/NIM</label>
                        <input type="text" name="ni_peminjam" id="ni_peminjam" placeholder="Input NIP Lecture/NIM Student" class="form-control" value="<?= $detail->nipnik ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Phone Number</label>
                        <input type="text" name="notelp_peminjam" id="notelp_peminjam" placeholder="Input Phone Number Borrower" class="form-control" value="<?= $detail->noTelp ?>" required>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Laboratory</label>
                        <select name="lab_peminjam" id="lab_peminjam" class="form-control laboratorium">
                          <option></option>
                          <?php
                          foreach ($lab as $l) {
                            if ($l->idLab == $detail->idLab) {
                              echo '<option value="' . $l->idLab . '" selected>' . $l->namaLab . '</option>';
                            } else {
                              echo '<option value="' . $l->idLab . '">' . $l->namaLab . '</option>';
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group" id="tanggal_pinjam">
                        <label class="font-bold">Borrow Date</label>
                        <div class="input-group date">
                          <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </span>
                          <?php
                          $tgl_pinjam = explode('-', $detail->tglPinjam);
                          $tmp        = array($tgl_pinjam[1], $tgl_pinjam[2], $tgl_pinjam[0]);
                          $tgl_pinjam = implode('/', $tmp);
                          ?>
                          <input type="text" name="tgl_pinjam" id="tgl_pinjam" class="form-control" value="<?= $tgl_pinjam ?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group" id="tanggal_pinjam">
                        <label class="font-bold">Due Date</label>
                        <div class="input-group date">
                          <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </span>
                          <?php
                          $tgl_kembali  = explode('-', $detail->tglKembali);
                          $tmp          = array($tgl_kembali[1], $tgl_kembali[2], $tgl_kembali[0]);
                          $tgl_kembali  = implode('/', $tmp);
                          ?>
                          <input type="text" name="tgl_kembali" id="tgl_kembali" class="form-control" value="<?= $tgl_kembali ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Reason</label>
                        <textarea name="alasan_peminjam" id="alasan_peminjam" class="form-control" placeholder="Input Reason"><?= $detail->alasan ?></textarea>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Notes</label>
                        <textarea name="catatan_peminjam" id="catatan_peminjam" class="form-control" placeholder="Input Notes"><?= $detail->catatan ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label class="font-bold">Status</label>
                        <div class="row">
                          <div class="col-md-4 col-sm-6">
                            <div class="i-checks">
                              <label>
                                <input type="radio" name="status_peminjaman" id="status_peminjaman" value="Ada" <?php if ($detail->status == 'Ada') echo 'checked'; ?> required> <i></i> Ada
                              </label>
                            </div>
                          </div>
                          <div class="col-md-4 col-sm-6">
                            <div class="i-checks">
                              <label>
                                <input type="radio" name="status_peminjaman" id="status_peminjaman" value="Dipinjam" <?php if ($detail->status == 'Dipinjam') echo 'checked'; ?> required> <i></i> Dipinjam
                              </label>
                            </div>
                          </div>
                          <div class="col-md-4 col-sm-6">
                            <div class="i-checks">
                              <label>
                                <input type="radio" name="status_peminjaman" id="status_peminjaman" value="Selesai" <?php if ($detail->status == 'Selesai') echo 'checked'; ?> required> <i></i> Selesai
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group" style="margin-top: 20px">
                        <div class="row">
                          <div class="col-md-4 col-sm-4" style="margin-bottom: 5px">
                            <button type="submit" class="btn btn-primary btn-sm btn-block">Save</button>
                          </div>
                          <div class="col-md-4 col-sm-4" style="margin-bottom: 5px">
                            <button type="reset" class="btn btn-warning btn-sm btn-block">Reset</button>
                          </div>
                          <div class="col-md-4 col-sm-4" style="margin-bottom: 5px">
                            <a href="<?= base_url('Borrowing/Laboratory') ?>"><button type="button" class="btn btn-danger btn-sm btn-block">Cancel</button></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">

                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>