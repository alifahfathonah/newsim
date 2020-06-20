<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Sistem Informasi Manajemen (SIM) Laboratorium, Fakultas Ilmu Terapan, Telkom University">
  <meta name="author" content="Alit Yuniargan Eskaluspita, Bayu Setya Ajie Perdana Putra, Fajri Ardiansyah">
  <title><?= $title ?></title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>" />
  <link href="<?= base_url('assets/inspinia/') ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/toastr/toastr.min.css" rel="stylesheet">
  <?php
  if (uri('2') == 'Schedule') {
  ?>
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/fullcalendar/fullcalendar.print.css" rel='stylesheet' media='print'>
    <style>
      /* .fc-agendaWeek-view tr {
        height: 0.5px !important;
      }

      .fc-agendaDay-view tr {
        height: 1px;
      } */
      .fc-time-grid .fc-slats td {
        height: 0px;
        border-bottom: 0;
      }
    </style>
  <?php
  }
  ?>
  <link href="<?= base_url('assets/inspinia/') ?>css/animate.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/style.css" rel="stylesheet">
  <?php
  if (uri('2') == 'PracticumAssistant') {
  ?>
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/dataTables/datatables.min.css" rel="stylesheet">
  <?php
  }
  if (uri('2') == 'Presence') {
  ?>
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/select2/select2.min.css" rel="stylesheet">
  <?php
  }
  if (uri('2') == 'AddPresence' || uri('2') == 'EditPresence') {
  ?>
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/datapicker/datepicker3.css" rel="stylesheet">
  <?php
  }
  if (uri('2') == 'BAP') {
  ?>
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/select2/select2.min.css" rel="stylesheet">
  <?php
  }
  if (uri('2') == 'Salary') {
  ?>
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
  <?php
  }
  if (uri('2') == 'PracticumReport') {
  ?>
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <style>
      .select2-dropdown {
        z-index: 10060 !important;
        /*1051;*/
      }

      .select2 {
        width: 100% !important;
      }
    </style>
  <?php
  }
  if (uri('2') == 'Setting') {
  ?>
    <link href="<?= base_url('assets/inspinia/') ?>css/plugins/select2/select2.min.css" rel="stylesheet">
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
  if (uri('2') == 'HistoryLogin') {
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
          <?php
          if (uri('2') == 'Schedule') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Asprak/Schedule') ?>">
            <i class="fa fa-calendar"></i>
            <span class="nav-label">Schedule</span>
          </a>
          </li>
          <?php
          if (uri('2') == 'PracticumAssistant') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Asprak/PracticumAssistant') ?>">
            <i class="fa fa-users"></i>
            <span class="nav-label">Practicum Assistant</span>
          </a>
          </li>
          <?php
          if (uri('2') == 'Presence' || uri('2') == 'AddPresence' || uri('2') == 'EditPresence') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Asprak/Presence') ?>">
            <i class="fa fa-line-chart"></i>
            <span class="nav-label">Presence</span>
          </a>
          </li>
          <?php
          if (uri('2') == 'BAP') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Asprak/BAP') ?>">
            <i class="fa fa-print"></i>
            <span class="nav-label">BAP</span>
          </a>
          </li>
          <?php
          if (uri('2') == 'Salary') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Asprak/Salary') ?>">
            <i class="fa fa-money"></i>
            <span class="nav-label">Salary</span>
          </a>
          </li>
          <?php
          if (uri('2') == 'PracticumReport') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Asprak/PracticumReport') ?>">
            <i class="fa fa-file-text-o"></i>
            <span class="nav-label">LPJ Asprak</span>
          </a>
          </li>
          <?php
          if (uri('2') == 'Setting') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Asprak/Setting') ?>">
            <i class="fa fa-gear"></i>
            <span class="nav-label">Setting</span>
          </a>
          </li>
          <?php
          if (uri('2') == 'HistoryLogin') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Asprak/HistoryLogin') ?>">
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