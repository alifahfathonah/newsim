<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $title ?></title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>" />
  <link href="<?= base_url('assets/inspinia/') ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/dataTables/datatables.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/datapicker/datepicker3.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/select2/select2.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/iCheck/custom.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/animate.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/style.css" rel="stylesheet">
</head>

<body>
  <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
          <li class="nav-header">
            <div class="dropdown profile-element">
              <img alt="image" class="rounded-circle" src="<?= base_url('assets/img/person-flat.png') ?>" height="48px" width="48px" />
              <a data-toggle="dropdown" class="dropdown-toggle" href="<?= base_url('assets/inspinia/') ?>#">
                <span class="block m-t-xs font-bold"><?= $profil->nama_asprak ?></span>
                <span class="text-muted text-xs block"><?= userdata('jabatan') ?></span>
              </a>
            </div>
            <div class="logo-element">
              <img alt="image" class="rounded-circle" src="<?= base_url('assets/') ?>img/favicon.png" height="50px" height="50px">
            </div>
          </li>
          <?php
          if (uri('2') == 'Dashboard') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Asprak/Dashboard') ?>">
            <i class="fa fa-dashboard"></i>
            <span class="nav-label">Dashboard</span>
          </a>
          </li>
          <li>
            <a href="<?= base_url('Laboran/Schedule') ?>">
              <i class="fa fa-calendar"></i>
              <span class="nav-label">Jadwal</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url('Laboran/Schedule') ?>">
              <i class="fa fa-users"></i>
              <span class="nav-label">Asisten Praktikum</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url('Laboran/Complaint') ?>">
              <i class="fa fa-line-chart"></i>
              <span class="nav-label">Presensi</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url('Laboran/Option') ?>">
              <i class="fa fa-print"></i>
              <span class="nav-label">BAP</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url('Laboran/Option') ?>">
              <i class="fa fa-money"></i>
              <span class="nav-label">Gaji & TAK</span>
            </a>
          </li>
          <?php
          if (uri('2') == 'Pengaturan') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Asprak/Pengaturan') ?>">
            <i class="fa fa-gear"></i>
            <span class="nav-label">Pengaturan</span>
          </a>
          </li>
          <!-- <li>
            <a href="<?= base_url('Laboran/Option') ?>">
              <i class="fa fa-print"></i>
              <span class="nav-label">BAP</span>
            </a>
          </li> -->
        </ul>
      </div>
    </nav>
    <div id="page-wrapper" class="gray-bg dashbard-1">
      <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
          <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#">
              <i class="fa fa-bars"></i>
            </a>
          </div>
          <ul class="nav navbar-top-links navbar-right">
            <li>
              <a href="<?= base_url('Auth/Logout') ?>">
                <i class="fa fa-sign-out"></i> Log out
              </a>
            </li>
          </ul>
        </nav>
      </div>