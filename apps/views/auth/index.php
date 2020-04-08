<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>" />
  <link href="<?= base_url('assets/inspinia/') ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/animate.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/style.css" rel="stylesheet">
  <style>
    body {
      background: url('<?= base_url("assets/img/") ?>IMG_1602.jpg') no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }
  </style>
</head>

<body class="gray-bg">
  <div class="loginColumns animated fadeInDown">
    <div class="row">
      <div class="col-sm-12 col-md-6 offset-md-6">
        <?php
        if (flashdata('msg')) {
          echo flashdata('msg');
        }
        ?>
        <div class="ibox-content" style="background-color: rgba(255,255,255,0.8)">
          <center><img src=" <?= base_url('assets/img/') ?>logo.png" height="70px">
          </center>
          <form class="m-t" role="form" method="post" action="<?= base_url('Auth') ?>">
            <div class="form-group">
              <input type="text" name="username_user" id="username_user" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
              <input type="password" name="password_user" id="password_user" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
          </form>
          <a href="<?= base_url('Auth/ForgotPassword') ?>"><small>Forgot Password?</small></a>
          <p class="text-muted text-center">
            <small>Do not have an account? Register Here as:</small>
          </p>
          <div class="row">
            <div class="col-sm-12 col-md-6" style="margin-bottom: 5px">
              <a href="<?= base_url('Auth/RegisterStaff') ?>" style="color: inherit">
                <button class="btn btn-sm btn-white btn-block">Staff Laboratory</button>
              </a>
            </div>
            <div class="col-sm-12 col-md-6" style="margin-bottom: 5px">
              <a href="<?= base_url('Auth/RegisterLecture') ?>" style="color: inherit">
                <button class="btn btn-sm btn-white btn-block">Lecture</button>
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-6" style="margin-bottom: 5px">
              <a href="<?= base_url('Auth/RegisterAslab') ?>" style="color: inherit">
                <button type="button" class="btn btn-sm btn-white btn-block">Laboratory Assistant</button>
              </a>
            </div>
            <div class="col-sm-12 col-md-6" style="margin-bottom: 5px">
              <a href="<?= base_url('Auth/RegisterAsprak') ?>" style="color: inherit">
                <button class="btn btn-sm btn-white btn-block">Practicum Assistant</button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= base_url('assets/inspinia/') ?>js/jquery-3.1.1.min.js"></script>
  <script>
    window.setTimeout(function() {
      $(".msg").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 3500);
  </script>
</body>

</html>