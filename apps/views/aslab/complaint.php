      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Complaint<br>School of Applied Science School's Laboratory</h2>
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
                <a href="<?= base_url('Complaint/AddComplaint') ?>">
                  <button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Complaint</button>
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
                        <th>Date</th>
                        <th>Laboratory</th>
                        <th>Equipment</th>
                        <th>Informer</th>
                        <th>Complaints</th>
                        <th>Solution</th>
                        <th>Done Date</th>
                        <th>Done by</th>
                        <th width="5%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($data as $d) {
                        if ($d->tglDiatasi == null) {
                          $tgl_diatasi = '<center>-</center>';
                        } else {
                          $tgl_diatasi = tanggalInggris($d->tglDiatasi);
                        }
                        if ($d->diperbaikiOleh == null) {
                          $diperbaiki = '<center>-</center>';
                        } else {
                          $diperbaiki = $d->diperbaikiOleh;
                        }
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= tanggalInggris($d->tglKomplain) ?></td>
                          <td><?= $d->namaLab ?></td>
                          <td><?= $d->namaAlat ?></td>
                          <td><?= $d->jenisInforman ?></td>
                          <td><?= $d->catatanKomplain ?></td>
                          <td><?= $d->solusi ?></td>
                          <td><?= $tgl_diatasi ?></td>
                          <td><?= $diperbaiki ?></td>
                          <td style="text-align: center; vertical-align: middle">
                            <a href="<?= base_url('Complaint/EditComplaint/' . substr(sha1($d->idKomplain), 6, 4)) ?>"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button></a>
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