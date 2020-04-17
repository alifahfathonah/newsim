<!DOCTYPE html>
<html>

<head>
  <title></title>
  <!-- <script type="text/javascript">
    function printthis() {
      window.print();
    }
  </script> -->
  <style>
    body {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
      background-color: #FAFAFA;
      font: 12pt "Tahoma";
    }

    .page {
      width: 210mm;
      min-height: 297mm;
      padding: 20mm;

      border: 1px #D3D3D3 solid;
      border-radius: 5px;
      background: white;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    @page {
      size: A4;
      margin: 0;
    }

    @media print {
      body {
        -webkit-print-color-adjust: exact;
      }
    }
  </style>
</head>

<body onload="printthis()" oncontextmenu="return false">
  <div class="page">
    <table width="100%">
      <tr>
        <td style="font-family: Arial; font-size: 14px;" width="40%" valign="top" colspan="2"><b>BERITA ACARA PEKERJAAN DAN KEHADIRAN<br>ASISTEN PRAKTIKUM</b></td>
        <td width="30%" rowspan="8" valign="top">
          <div align="right">
            <img src="<?= base_url('assets/img/logo_tass.png') ?>" height="70px" width="250px">
            <p style="font-family: Arial; font-size: 12px;"><b>Laboratoria<br>Fakultas Ilmu Terapan</b></p>
          </div>
        </td>
      </tr>
      <tr style="font-family: Arial; font-size: 12px;">
        <td width="10%"><b><br>NAMA</b></td>
        <td><br><b>: <?= $user->nama_asprak ?></b></td>
      </tr>
      <tr style="font-family: Arial; font-size: 12px;">
        <td><b>NIM</b></td>
        <td><b>: <?= $user->nim_asprak ?></b></td>
      </tr>
      <tr style="font-family: Arial; font-size: 12px;">
        <td><b>BULAN</b></td>
        <td><b>: <?= $bulan ?></b></td>
      </tr>
      <tr style="font-family: Arial; font-size: 12px;">
        <td><b>PRODI</b></td>
        <td><b>: <?= $mk_prodi->strata . ' ' . $mk_prodi->nama_prodi ?></b></td>
      </tr>
      <tr style="font-family: Arial; font-size: 12px;">
        <td><b>MK / KODE MK</b></td>
        <td><b>: <?= $mk_prodi->nama_mk . ' / ' . $mk_prodi->kode_mk ?></b></td>
      </tr>
      <tr style="font-family: Arial; font-size: 12px;">
        <td><b>TAHUN</b></td>
        <td><b>: <?= date('Y') ?></b></td>
      </tr>
      <tr style="font-family: Arial; font-size: 12px;">
        <td><b>TOTAL JAM</b></td>
        <td><b>: <?= $durasi->durasi ?></b></td>
      </tr>
    </table>
    <br>
    <table border="1" width="100%" style="border-collapse: collapse; border: 1px solid black;">
      <tr style="text-align: center; background: #333333; font-weight: bold; color: white;">
        <td width="15%">Tanggal</td>
        <td width="10%">Jam Masuk</td>
        <td width="10%">Jam Keluar</td>
        <td width="10%">Jumlah Jam</td>
        <td colspan="2">Modul Praktikum</td>
        <td width="10%">Paraf Asprak</td>
      </tr>
      <?php
      $ttd_asprak         = '<img src="' . base_url($ttd_asprak) . '" style="max-height: 40px">';
      $ttd_dosen          = '<img src="' . base_url($koordinator->ttd_dosen) . '" style="max-height: 50px">';
      foreach ($bap as $b) {
        $tanggal_indonesia  = tanggal_indonesia($b->tanggal);
        $gambar_praktikum   = '<img src="' . base_url($b->screenshot) . '" style="max-height: 90px">';
      ?>
        <tr>
          <td style="text-align: center"><?= $tanggal_indonesia ?></td>
          <td style="text-align: center"><?= $b->jam_masuk ?></td>
          <td style="text-align: center"><?= $b->jam_selesai ?></td>
          <td style="text-align: center"><?= $b->durasi ?></td>
          <td style="padding: 5px 5px 5px 5px"><?= $b->modul ?></td>
          <td width="23%" style="text-align: center; padding: 5px 5px 5px 5px"><?= $gambar_praktikum ?></td>
          <td style="text-align: center"><?= $ttd_asprak ?></td>
        </tr>
      <?php
      }
      ?>
    </table>
    <p style="text-align: right; font-family: Arial; font-size: 12px">
      Bandung, <?= $tanggal_sekarang ?>
      <br>Koordinator Mata Kuliah<br><br>
      <?= $ttd_dosen ?><br><br>
      <?= $koordinator->nama_dosen ?>
    </p>
  </div>
</body>
<script type="text/javascript">
  document.onkeydown = function(e) {
    if (e.ctrlKey && (e.keyCode === 85 || e.keyCode === 117) || e.keyCode === 123) {
      return false;
    } else {
      return true;
    }
  };
</script>

</html>