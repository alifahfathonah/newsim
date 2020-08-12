<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Download Certificate</title>
  <link rel="stylesheet" href="<?= base_url('assets/inspinia/css/') ?>normalize.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/inspinia/css/') ?>paper.css">
  <style>
    body {
      font-family: georgia, garamond, serif;
      font-size: 16px;
    }

    * {
      -webkit-print-color-adjust: exact !important;
      /* Chrome, Safari */
      color-adjust: exact !important;
      /*Firefox*/
    }

    @page {
      size: A4 landscape
    }

    .bg-sertifikat {
      width: 297mm;
      height: 209mm;
    }

    div {
      text-align: center;
    }

    div.no_sertifikat {
      margin-top: 240px;
      font-size: 17px;
    }

    div.diberikan {
      margin-top: 20px;
      font-size: 17px;
    }

    div.nama_asprak {
      font-family: "Monotype Corsiva";
      font-style: italic;
      font-weight: bold;
      margin-top: 30px;
      font-size: 40px;
    }

    div.sebagai {
      margin-top: 30px;
      font-size: 17px;
    }

    div.nama_mk {
      font-size: 17px;
      font-weight: bold;
    }

    div.tahun_ajaran {
      font-size: 17px;
    }

    div.tahun_cetak {
      margin-top: 50px;
      font-size: 17px;
    }

    div.kaur {
      font-size: 17px;
    }

    div.ttd {
      position: relative;
      max-height: 80px;
    }

    div.cap {
      position: absolute;
      margin-top: -95px;
      max-height: 100px;
      left: 465px;
      opacity: 0.65;
    }

    div.nama_kaur {
      font-size: 17px;
      text-decoration: underline;
    }

    div.nip_kaur {
      font-size: 17px;
    }
  </style>
  <script type="text/javascript">
    function printthis() {
      window.print();
    }
  </script>
</head>

<body class="A4 landscape" oncontextmenu="return false" onload="printthis()">
  <section class="sheet" style="background-image: url('<?= base_url('assets/img/template/sertifikat_asprak.png') ?>'); width: 297mm; height: 209mm;">
    <?php
    $tmp_tahun            = explode('-', $no_sertifikat->tgl_generate);
    $tahun_cetak          = $tmp_tahun[0];
    $tmp_cetak_sertifikat = explode(' ', $no_sertifikat->tgl_cetak);
    $cetak_sertifikat     = tanggal_indonesia($tmp_cetak_sertifikat[0]);
    $tmp = explode('-', $ta);
    if ($tmp[1] == '1') {
      $semester = 'Ganjil';
      $periode  = $tmp[0] . '/' . ($tmp[0] + 1);
    } elseif ($tmp[1] == '2') {
      $semester = 'Genap';
      $periode  = $tmp[0] . '/' . ($tmp[0] + 1);
    }
    if ($keanggotaan == 'Anggota') {
      $keanggotaan = null;
    } elseif ($keanggotaan == 'Koordinator') {
      $keanggotaan = 'Koordinator';
    }
    ?>
    <div class="no_sertifikat">
      No : CF.<?= $no_sertifikat->no_sertifikat ?>/AKD.7/IT-D3LAB/<?= $tahun_cetak ?>
    </div>
    <div class="diberikan">
      Diberikan kepada :
    </div>
    <div class="nama_asprak">
      <?= $nama_asprak ?>
    </div>
    <div class="sebagai">
      sebagai
    </div>
    <div class="nama_mk">
      <?= $keanggotaan ?> Asisten Praktikum <?= $nama_mk ?>
    </div>
    <div class="tahun_ajaran">
      pada Semester <?= $semester ?> TA <?= $periode ?>
    </div>
    <div class="tahun_cetak">
      Bandung, <?= $cetak_sertifikat ?>
    </div>
    <div class="kaur">
      Ka.Ur. Lab/Bengkel/Studio Fakultas Ilmu Terapan
    </div>
    <div class="ttd">
      <img src="<?= base_url('assets/img/template/kaur.png') ?>" height="80px">
      <div class="cap">
        <img src="<?= base_url('assets/img/template/stempel.png') ?>" height="100px">
      </div>
    </div>
    <div class="nama_kaur">
      Devie Ryana Suchendra, S.T., M.T.
    </div>
    <div class="nip_kaur">
      14850047
    </div>
  </section>
  <script type="text/javascript">
    document.onkeydown = function(e) {
      if (e.ctrlKey && (e.keyCode === 85 || e.keyCode === 117) || e.keyCode === 123) {
        return false;
      } else {
        return true;
      }
    };
  </script>
</body>

</html>