<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sistem Informasi Manajemen (SIM) Laboratorium, Fakultas Ilmu Terapan, Telkom University">
  <meta name="author" content="Alit Yuniargan Eskaluspita, Bayu Setya Ajie Perdana Putra, Fajri Ardiansyah">
  <title><?= $title ?></title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>" />
  <link href="<?= base_url('assets/inspinia/') ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/animate.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/style.css" rel="stylesheet">
  <style>
    html,
    body {
      height: 100%;
      margin: 0 2% 0 2%;
      background: url('<?= base_url("assets/img/") ?>IMG_1602.jpg') no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }
  </style>
</head>

<body>
  <div class="h-100 row align-items-center animated fadeInDown">
    <div class="col">
      <div class="row">
        <div class="col-sm-12 col-md-4 offset-md-4">
          <?php
          if (flashdata('msg')) {
            echo flashdata('msg');
          }
          ?>
          <div class="ibox-content" style="background-color: rgba(255,255,255,0.8)">
            <center><img src=" <?= base_url('assets/img/') ?>logo.png" height="70px" style="margin-bottom: 20px">
            </center>
            <h3 style="text-align: center; margin-bottom: 20px">Reset Password</h3>
            <form class="m-t" role="form" method="post" action="<?= base_url('Auth/ResetPasswordUser') ?>">
              <div class="form-group">
                <input type="text" name="username" id="username" value="<?= userdata('reset_password_akun') ?>" style="display: none">
                <input type="password" name="password_user" id="password_user" class="form-control" placeholder="New Password" required>
              </div>
              <div class="form-group">
                <input type="password" name="repeat_password" id="repeat_password" class="form-control" placeholder="Repeat Password" required>
              </div>
              <button type="submit" name="submit" id="submit" class="btn btn-primary block full-width m-b">Send</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= base_url('assets/inspinia/') ?>js/jquery-3.1.1.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/bootstrap.min.js"></script>
</body>

</html>