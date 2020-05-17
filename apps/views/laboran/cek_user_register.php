<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Cek User | SIM Laboratorium</title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>" />

  <link href="<?= base_url('assets/inspinia/') ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>font-awesome/css/font-awesome.css" rel="stylesheet">

  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/dataTables/datatables.min.css" rel="stylesheet">

  <link href="<?= base_url('assets/inspinia/') ?>css/animate.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/style.css" rel="stylesheet">

</head>

<body class="top-navigation">

  <div id="wrapper">
    <div id="page-wrapper" class="gray-bg">
      <div class="row border-bottom white-bg">
        <nav class="navbar navbar-expand-lg navbar-static-top" role="navigation">

          <!--</div>-->
          <div class="navbar-collapse collapse" id="navbar">
            <ul class="nav navbar-nav mr-auto">
            </ul>
            <ul class="nav navbar-top-links navbar-right">
              <li>
                <a href="login.html">
                  <i class="fa fa-sign-out"></i> Log out
                </a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
      <div class="wrapper wrapper-content">
        <div class="container">
          <div class="row">
            <div class="col-md-3">
              <div class="ibox">
                <div class="ibox-title">
                  <h5>Asprak Sudah Register</h5>
                </div>
                <div class="ibox-content">
                  <?php
                  $hitung_sudah_daftar = $this->db->select('count(users.idUser) jumlah')->from('users')->join('asprak', 'users.nimAsprak = asprak.nim_asprak')->get()->row()->jumlah;
                  ?>
                  <h1 class="no-margins"><?= $hitung_sudah_daftar ?></h1>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="ibox">
                <div class="ibox-title">
                  <h5>Asprak Belum Register</h5>
                </div>
                <div class="ibox-content">
                  <?php
                  $hitung_belum_daftar = $this->db->select('count(asprak.nim_asprak) jumlah')->from('asprak')->join('users', 'asprak.nim_asprak = users.nimAsprak', 'left')->where('users.nimAsprak', null)->get()->row()->jumlah;
                  ?>
                  <h1 class="no-margins"><?= $hitung_belum_daftar ?></h1>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="ibox">
                <div class="ibox-title">
                  <h5>Dosen Sudah Register</h5>
                </div>
                <div class="ibox-content">
                  <?php
                  $hitung_dosen_sudah_daftar = $this->db->select('count(users.iduser) jumlah')->from('users')->join('dosen', 'users.id_dosen = dosen.id_dosen')->get()->row()->jumlah;
                  ?>
                  <h1 class="no-margins"><?= $hitung_dosen_sudah_daftar ?></h1>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="ibox">
                <div class="ibox-title">
                  <h5>Dosen Belum Register</h5>
                </div>
                <div class="ibox-content">
                  <?php
                  $hitung_dosen_belum_daftar = $this->db->select('count(dosen.id_dosen) jumlah')->from('dosen')->join('users', 'dosen.id_dosen = users.id_dosen', 'left')->where('users.id_dosen', null)->get()->row()->jumlah;
                  ?>
                  <h1 class="no-margins"><?= $hitung_dosen_belum_daftar ?></h1>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="ibox ">
                <div class="ibox-title">
                  <h5>Asprak Sudah Register</h5>
                  <div class="ibox-tools">
                    <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                    </a>
                  </div>
                </div>
                <div class="ibox-content">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover asprak_sudah">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>NIM</th>
                          <th>Nama</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query = $this->db->select('asprak.nim_asprak, asprak.nama_asprak')->from('users')->join('asprak', 'users.nimAsprak = asprak.nim_asprak')->get()->result();
                        $no = 1;
                        foreach ($query as $q) {
                        ?>
                          <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $q->nim_asprak ?></td>
                            <td><?= $q->nama_asprak ?></td>
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
            <div class="col-lg-6">
              <div class="ibox ">
                <div class="ibox-title">
                  <h5>Asprak Belum Register</h5>
                  <div class="ibox-tools">
                    <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                    </a>
                  </div>
                </div>
                <div class="ibox-content">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover asprak_belum">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>NIM</th>
                          <th>Nama</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query = $this->db->select('asprak.nim_asprak, asprak.nama_asprak')->from('asprak')->join('users', 'asprak.nim_asprak = users.nimAsprak', 'left')->where('users.nimAsprak', null)->get()->result();
                        $no = 1;
                        foreach ($query as $q) {
                        ?>
                          <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $q->nim_asprak ?></td>
                            <td><?= $q->nama_asprak ?></td>
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
            <div class="col-lg-6">
              <div class="ibox ">
                <div class="ibox-title">
                  <h5>Dosen Sudah Register</h5>
                  <div class="ibox-tools">
                    <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                    </a>
                  </div>
                </div>
                <div class="ibox-content">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover asprak_sudah">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>NIP</th>
                          <th>Kode Dosen</th>
                          <th>Nama</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query = $this->db->select('dosen.nip_dosen, dosen.kode_dosen, dosen.nama_dosen')->from('users')->join('dosen', 'users.id_dosen = dosen.id_dosen')->get()->result();
                        $no = 1;
                        foreach ($query as $q) {
                        ?>
                          <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $q->nip_dosen ?></td>
                            <td><?= $q->kode_dosen ?></td>
                            <td><?= $q->nama_dosen ?></td>
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
            <div class="col-lg-6">
              <div class="ibox ">
                <div class="ibox-title">
                  <h5>Dosen Belum Register</h5>
                  <div class="ibox-tools">
                    <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                    </a>
                  </div>
                </div>
                <div class="ibox-content">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover asprak_belum">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>NIP</th>
                          <th>Kode Dosen</th>
                          <th>Nama</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query = $this->db->select('dosen.nip_dosen, dosen.kode_dosen, dosen.nama_dosen')->from('dosen')->join('users', 'dosen.id_dosen = users.id_dosen', 'left')->where('users.id_dosen', null)->get()->result();
                        $no = 1;
                        foreach ($query as $q) {
                        ?>
                          <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $q->nip_dosen ?></td>
                            <td><?= $q->kode_dosen ?></td>
                            <td><?= $q->nama_dosen ?></td>
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

      </div>
      <div class="footer">
        <div class="float-right">
          10GB of <strong>250GB</strong> Free.
        </div>
        <div>
          <strong>Copyright</strong> Example Company &copy; 2014-2018
        </div>
      </div>

    </div>
  </div>



  <!-- Mainly scripts -->
  <script src="<?= base_url('assets/inspinia/') ?>js/jquery-3.1.1.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/popper.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/bootstrap.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>

  <!-- Custom and plugin javascript -->
  <script src="<?= base_url('assets/inspinia/') ?>js/inspinia.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/pace/pace.min.js"></script>

  <!-- Page-Level Scripts -->
  <script>
    $(document).ready(function() {
      $('.asprak_sudah').DataTable({
        pageLength: 5,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $('.asprak_belum').DataTable({
        pageLength: 5,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $('.dosen_sudah').DataTable({
        pageLength: 5,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $('.dosen_belum').DataTable({
        pageLength: 5,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });
    });
  </script>

</body>

</html>