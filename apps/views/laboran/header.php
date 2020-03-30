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
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/datapicker/datepicker3.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/iCheck/custom.css" rel="stylesheet">
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
              <img alt="image" class="rounded-circle" src="<?= base_url('assets/') ?>img/302383.jpg" height="48px" width="48px" />
              <a data-toggle="dropdown" class="dropdown-toggle" href="<?= base_url('assets/inspinia/') ?>#">
                <span class="block m-t-xs font-bold"><?= userdata('nama') ?></span>
                <span class="text-muted text-xs block"><?= userdata('jabatan') ?></span>
              </a>
            </div>
            <div class="logo-element">
              <img alt="image" class="rounded-circle" src="<?= base_url('assets/') ?>img/favicon.png" height="50px" height="50px">
            </div>
          </li>
          <li>
            <a href="<?= base_url('Laboran/Dashboard') ?>">
              <i class="fa fa-dashboard"></i>
              <span class="nav-label">Dashboard</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-barcode"></i>
              <span class="nav-label">Stock Opname</span>
              <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse">
              <li>
                <a href="<?= base_url('Laboran/StockLists') ?>">Stock Lists</a>
              </li>
              <li>
                <a href="<?= base_url('Laboran/AdditionalStock') ?>">Additional Stock</a>
              </li>
              <li>
                <a href="<?= base_url('Laboran/ReductionStock') ?>">Reduction Stock</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-bank"></i>
              <span class="nav-label">Laboratory</span>
              <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse">
              <li>
                <a href="<?= base_url('Laboran/PracticumLaboratory') ?>">Practicum Laboratory</a>
              </li>
              <li>
                <a href="<?= base_url('Laboran/ResearchLaboratory') ?>">Research Laboratory</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-users"></i>
              <span class="nav-label">Practicum</span>
              <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse">
              <li>
                <a href="<?= base_url('Laboran/Courses') ?>">Courses</a>
              </li>
              <li>
                <a href="<?= base_url('Laboran/PracticumAssistant') ?>">Practicum Assistant</a>
              </li>
              <li>
                <a href="<?= base_url('Laboran/PresenceAsprak') ?>">Presence Asprak</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-users"></i>
              <span class="nav-label">Laboratory Assistant</span>
              <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse">
              <li>
                <a href="<?= base_url('Laboran/LaboratoryAssistant') ?>">Profile Assistant</a>
              </li>
              <li>
                <a href="<?= base_url('Laboran/JournalAssistant') ?>">Journal Assistant</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="<?= base_url('Laboran/Schedule') ?>">
              <i class="fa fa-calendar"></i>
              <span class="nav-label">Schedule</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-legal"></i>
              <span class="nav-label">Borrowing</span>
              <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse">
              <li>
                <a href="<?= base_url('Laboran/BorrowingEquipment') ?>">Equipment</a>
              </li>
              <li>
                <a href="<?= base_url('Laboran/BorrowingLaboratory') ?>">Laboratory</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="<?= base_url('Laboran/Complaint') ?>">
              <i class="fa fa-thumbs-down"></i>
              <span class="nav-label">Complaint</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url('Laboran/Option') ?>">
              <i class="fa fa-gears"></i>
              <span class="nav-label">Option SIMLAB</span>
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
            <li class="dropdown">
              <a class="dropdown-toggle count-info" data-toggle="dropdown" href="<?= base_url('assets/inspinia/') ?>#">
                <i class="fa fa-bell"></i> <span class="label label-primary">8</span>
              </a>
              <ul class="dropdown-menu dropdown-alerts">
                <li>
                  <a href="<?= base_url('Laboran/Complaint') ?>" class="dropdown-item">
                    <div>
                      <i class="fa fa-thumbs-down fa-fw"></i> You have 16 complaint(s)
                    </div>
                  </a>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                  <a href="<?= base_url('assets/inspinia/') ?>profile.html" class="dropdown-item">
                    <div>
                      <i class="fa fa-hdd-o fa-fw"></i> You have 3 borrowing equipment(s)
                    </div>
                  </a>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                  <a href="<?= base_url('assets/inspinia/') ?>grid_options.html" class="dropdown-item">
                    <div>
                      <i class="fa fa-hotel fa-fw"></i> You have 3 borrowing laboratory(s)
                    </div>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <a href="<?= base_url('Auth/Logout') ?>">
                <i class="fa fa-sign-out"></i> Log out
              </a>
            </li>
          </ul>
        </nav>
      </div>