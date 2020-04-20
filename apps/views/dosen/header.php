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
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/toastr/toastr.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/animate.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/style.css" rel="stylesheet">
  <?php
  if (uri('1') == 'PracticumAssistant') {
  ?>
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/dataTables/datatables.min.css" rel="stylesheet">
  <?php
  }
  if (uri('1') == 'Setting') {
  ?>
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/digital-signature/jquery.signaturepad.css" rel="stylesheet">
    <style>
      #signArea {
        width: 304px;
      }

      .tag-ingo {
        font-family: cursive;
        font-size: 12px;
        text-align: left;
        font-style: oblique;
      }
    </style>
  <?php
  }
  if (uri('1') == 'HistoryLogin') {
  ?>
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/dataTables/datatables.min.css" rel="stylesheet">
  <?php
  }
  ?>
</head>

<body>
  <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
          <li class="nav-header">
            <div class="dropdown profile-element">
              <img alt="image" class="rounded-circle" src="<?= base_url('assets/img/person-flat.png') ?>" height="48px" width="48px" />
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="block m-t-xs font-bold"><?= $profil->nama_dosen ?></span>
                <span class="text-muted text-xs block"><?= userdata('jabatan') ?></span>
              </a>
            </div>
            <div class="logo-element">
              <img alt="image" class="rounded-circle" src="<?= base_url('assets/') ?>img/favicon.png" height="50px" height="50px">
            </div>
          </li>
          <?php
          if (uri('1') == 'Dashboard') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Dashboard') ?>">
            <i class="fa fa-dashboard"></i>
            <span class="nav-label">Dashboard</span>
          </a>
          </li>
          <?php
          if (uri('1') == 'PracticumAssistant') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('PracticumAssistant') ?>">
            <i class="fa fa-users"></i>
            <span class="nav-label">Practicum Assistant</span>
          </a>
          </li>
          <?php
          if (uri('1') == 'BAP') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('BAP') ?>">
            <i class="fa fa-book"></i>
            <span class="nav-label">BAP</span>
          </a>
          </li>
          <?php
          if (uri('1') == 'Setting') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Setting') ?>">
            <i class="fa fa-gear"></i>
            <span class="nav-label">Setting</span>
          </a>
          </li>
          <?php
          if (uri('1') == 'HistoryLogin') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('HistoryLogin') ?>">
            <i class="fa fa-history"></i>
            <span class="nav-label">History Login</span>
          </a>
          </li>
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