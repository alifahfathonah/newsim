<html>

<head>
  <title><?= $title ?></title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>" />
  <style type="text/css">
    body {
      font-family: Tahoma, Verdana, Segoe, sans-serif;
      font-size: 10px;
    }

    .table-isi {
      border-collapse: collapse;
      border: 1px solid black;

    }

    .thead-isi {
      font-weight: bold;
      background-color: #333333;
      color: white;
      text-align: center;
    }

    .isi-bap {
      text-align: center;
    }

    .modul-bap {
      padding: 5px 5px 5px 5px;
    }

    .img-dosen {
      position: relative;
      z-index: 1;
      top: 0px;
    }

    .p-dosen {
      position: absolute;
      font-family: Tahoma, Verdana, Segoe, sans-serif;
      font-size: 8px;
      text-align: left;
      color: black;
      padding-left: 615px;
      padding-top: 45px;
      z-index: 2;
      width: 10%;
    }

    .p-dosen1 {
      position: absolute;
      text-align: left;
      padding-left: 579px;
      padding-top: 35px;
      z-index: 2;
      width: 7%;
      opacity: 0.5;
    }
  </style>
</head>

<body>
  <table width="100%" style="font-weight: bold">
    <tr>
      <td width="70%" valign="top" colspan="2">BERITA ACARA PEKERJAAN DAN KEHADIRAN<br>ASISTEN PRAKTIKUM</td>
      <td style="text-align: right" width="30%" rowspan="9" valign="top">
        <div align="right">
          <img src="<?= base_url('assets/img/logo_tass.png') ?>" height="60px">
          <br><br>
          <p>Unit Laboratorium/Bengkel/Studio<br>Fakultas Ilmu Terapan</p>
        </div>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="15%">NAMA</td>
      <td>: <?= $asprak->nama_asprak ?></td>
    </tr>
    <tr>
      <td>NIM</td>
      <td>: <?= $asprak->nim_asprak ?></td>
    </tr>
    <tr>
      <td><b>BULAN</b></td>
      <td>: <?= $periode->bulan ?></td>
    </tr>
    <tr>
      <td>PRODI</td>
      <td>: <?= $prodi->strata . ' ' . $prodi->nama_prodi ?></td>
    </tr>
    <tr>
      <td>MK / KODE MK</td>
      <td>: <?= $prodi->nama_mk . ' / ' . $prodi->kode_mk ?></td>
    </tr>
    <tr>
      <td>TAHUN</td>
      <td>: <?= date('Y') ?></td>
    </tr>
    <tr>
      <td>TOTAL JAM</td>
      <td>: <?= $total->jam ?></td>
    </tr>
  </table>
  <br>
  <table border="1" width="100%" class="table-isi">
    <thead>
      <tr>
        <td class="thead-isi" width="15%">Tanggal</td>
        <td class="thead-isi" width="8%">Jam Masuk</td>
        <td class="thead-isi" width="8%">Jam Keluar</td>
        <td class="thead-isi" width="8%">Jumlah Jam</td>
        <td class="thead-isi" width="45%" colspan="2">Modul Praktikum</td>
        <td class="thead-isi" width="13%">Paraf Asprak</td>
      </tr>
    </thead>
    <tbody>
      <?php
      // $ttd_asprak         = '<center><img src="' . base_url($bap->ttd_asprak) . '" style="height: 30px"></center>';
      // $ttd_dosen          = '<img src="' . base_url($koordinator->ttd_dosen) . '" style="height: 60px" class="img-dosen">';
      foreach ($bap as $b) {
        $tanggal_indonesia  = tanggal_indonesia($b->tanggal);
        $gambar_praktikum   = '<img src="' . base_url($b->screenshot) . '" style="height: 60px; padding: 5px 5px 5px 5px">';
        $ttd_asprak         = '<center><img src="' . base_url($b->ttd_asprak) . '" style="height: 30px"></center>';
      ?>
        <tr>
          <td class="isi-bap"><?= $tanggal_indonesia ?></td>
          <td class="isi-bap"><?= $b->masuk ?></td>
          <td class="isi-bap"><?= $b->selesai ?></td>
          <td class="isi-bap"><?= $b->durasi ?></td>
          <td class="modul-bap" width="22%"><?= $b->modul ?></td>
          <td style="text-align: center" width="23%"><?= $gambar_praktikum ?></td>
          <td width="13%"><?= $ttd_asprak ?></td>
        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
  <!-- <br>
  <table width="100%" style="text-align: right">
    <tr>
      <td>Bandung, <?= tanggal_indonesia(date('Y-m-d')) ?></td>
    </tr>
    <tr>
      <td>Koordinator Mata Kuliah</td>
    </tr>
    <tr>
      <td>
        <div>
          <?= $ttd_dosen ?>
          <p class="p-dosen1">
            <img src="<?= base_url('assets/img/favicon.png') ?>" style="opacity: 0.3">
          </p>
          <p class="p-dosen">Bayu Setya Ajie Perdana Putra<br><?= tanggal_indonesia(date('Y-m-d')) ?></p>
        </div>
      </td>
    </tr>
    <tr>
      <td>Bayu Setya Ajie Perdana Putra, Amd.Kom., S.Kom.</td>
    </tr>
  </table> -->
</body>

</html>