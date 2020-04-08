      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Borrowing Equipment<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover peminjaman" width="100%">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Borrower</th>
                        <th>Equipment</th>
                        <th>Reason</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Notes</th>
                        <th>Status</th>
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
                          <td><?= $d->namaAlat ?></td>
                          <td><?= $d->alasan ?></td>
                          <td><?= tanggalInggris($d->tglPinjam) ?></td>
                          <td><?= tanggalInggris($d->tglKembali) ?></td>
                          <td><?= $d->catatan ?></td>
                          <td><?= $d->status ?></td>
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