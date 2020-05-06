<style type="text/css">
  .header-bap {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 12px;
    font-weight: bold;
  }

  .table-isi {
    border-collapse: collapse;
    border: 1px solid black;

  }

  .thead-isi {
    font-family: Arial;
    font-size: 12px;
    font-weight: bold;
    background-color: #333333;
    color: white;
    text-align: center;
  }

  .isi-bap {
    font-family: Arial;
    font-size: 12px;
    text-align: center;
  }

  .modul-bap {
    font-family: Arial;
    font-size: 12px;
    padding: 5px 5px 5px 5px;
  }

  .img-dosen {
    position: relative;
    z-index: 1;
    top: 0px;
  }

  .p-dosen {
    position: absolute;
    font-family: Arial;
    font-size: 9px;
    text-align: left;
    color: black;
    padding-left: 605px;
    padding-top: 35px;
    z-index: 2;
    width: 10%;
  }
</style>
<table width="100%" class="header-bap">
  <tr>
    <td width="70%" valign="top" colspan="2">BERITA ACARA PEKERJAAN DAN KEHADIRAN<br>ASISTEN PRAKTIKUM</td>
    <td style="text-align: right" width="30%" rowspan="9" valign="top">
      <div align="right">
        <img src="<?= base_url('assets/img/logo_tass.png') ?>" height="53px">
        Unit Laboratorium/Bengkel/Studio<br>Fakultas Ilmu Terapan
      </div>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="15%">NAMA</td>
    <td>: <?= $user->nama_asprak ?></td>
  </tr>
  <tr>
    <td>NIM</td>
    <td>: <?= $user->nim_asprak ?></td>
  </tr>
  <tr>
    <td><b>BULAN</b></td>
    <td>: <?= $bulan ?></td>
  </tr>
  <tr>
    <td>PRODI</td>
    <td>: <?= $mk_prodi->strata . ' ' . $mk_prodi->nama_prodi ?></td>
  </tr>
  <tr>
    <td>MK / KODE MK</td>
    <td>: <?= $mk_prodi->nama_mk . ' / ' . $mk_prodi->kode_mk ?></td>
  </tr>
  <tr>
    <td>TAHUN</td>
    <td>: <?= date('Y') ?></td>
  </tr>
  <tr>
    <td>TOTAL JAM</td>
    <td>: <?= $durasi->durasi ?></td>
  </tr>
</table>
<br>
<table border="1" width="100%" class="table-isi">
  <tr>
    <td class="thead-isi" width="15%">Tanggal</td>
    <td class="thead-isi" width="9%">Jam Masuk</td>
    <td class="thead-isi" width="9%">Jam Keluar</td>
    <td class="thead-isi" width="9%">Jumlah Jam</td>
    <td class="thead-isi" width="45%" colspan="2">Modul Praktikum</td>
    <td class="thead-isi" width="13%">Paraf Asprak</td>
  </tr>
  <?php
  $ttd_asprak         = '<center><img src="' . base_url($ttd_asprak) . '" style="height: 30px"></center>';
  $ttd_dosen          = '<img src="' . base_url($koordinator->ttd_dosen) . '" style="height: 55px" class="img-dosen">';
  foreach ($bap as $b) {
    $tanggal_indonesia  = tanggal_indonesia($b->tanggal);
    $gambar_praktikum   = '<img src="' . base_url($b->screenshot) . '" style="height: 80px; padding: 5px 5px 5px 5px">';
  ?>
    <tr>
      <td class="isi-bap" width="15%"><?= $tanggal_indonesia ?></td>
      <td class="isi-bap" width="9%"><?= $b->jam_masuk ?></td>
      <td class="isi-bap" width="9%"><?= $b->jam_selesai ?></td>
      <td class="isi-bap" width="9%"><?= $b->durasi ?></td>
      <td class="modul-bap" width="22%"><?= $b->modul ?></td>
      <td style="text-align: center" width="23%"><?= $gambar_praktikum ?></td>
      <td width="13%"><?= $ttd_asprak ?></td>
    </tr>
  <?php
  }
  ?>
</table>
<br>
<table width="100%" style="text-align: right; font-family: Arial; font-size: 12px">
  <tr>
    <td>Bandung, <?= $tanggal_sekarang ?></td>
  </tr>
  <tr>
    <td>Koordinator Mata Kuliah</td>
  </tr>
  <tr>
    <td>
      <div>
        <?= $ttd_dosen ?>
        <p class="p-dosen">Bayu Setya Ajie Perdana Putra<br><?= tanggal_indonesia(date('Y-m-d')) ?></p>
      </div>
    </td>
  </tr>
  <tr>
    <td>Bayu Setya Ajie Perdana Putra, Amd.Kom., S.Kom.</td>
  </tr>
</table>
</body>

</html>