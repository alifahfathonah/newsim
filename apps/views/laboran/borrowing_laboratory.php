      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Borrowing Laboratory<br>School of Applied Science School's Laboratory</h2>
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
                <a href="<?= base_url('Borrowing/AddBorrowingLaboratory') ?>">
                  <button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Borrowing Laboratory</button>
                </a>
              </div>
            </div>
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover peminjaman" width="100%">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Borrower</th>
                        <th>Laboratory</th>
                        <th>Reason</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Notes</th>
                        <th>Status</th>
                        <th width="5%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($data as $d) {
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $d->namaPeminjam ?></td>
                          <td><?= $d->namaLab ?></td>
                          <td><?= $d->alasan ?></td>
                          <td><?= tanggalInggris($d->tglPinjam) ?></td>
                          <td><?= tanggalInggris($d->tglKembali) ?></td>
                          <td><?= $d->catatan ?></td>
                          <td><?= $d->status ?></td>
                          <td style="text-align: center; vertical-align: middle">
                            <a href="<?= base_url('Borrowing/EditBorrowingLaboratory/' . substr(sha1($d->idPinjamLab), 6, 4)) ?>"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button></a>
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