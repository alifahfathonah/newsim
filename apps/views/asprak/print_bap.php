<style>
  .pembungkus {
    position: relative;
  }

  .img {
    border: 5px dotted aqua;
  }
</style>
<table width="100%">
  <tr>
    <td style="font-family: Arial; font-size: 9px;" width="70%" valign="top" colspan="2"><b>BERITA ACARA PEKERJAAN DAN KEHADIRAN<br>ASISTEN PRAKTIKUM</b></td>
    <td width="30%" rowspan="8" valign="top">
      <div align="right">
        <img src="<?= base_url('assets/img/logo_tass.png') ?>" height="70px" width="250px">
        <p style="font-family: Arial; font-size: 9px;"><b>Laboratoria<br>Fakultas Ilmu Terapan</b></p>
      </div>
    </td>
  </tr>
  <tr style="font-family: Arial; font-size: 9px;">
    <td width="15%"><b><br>NAMA</b></td>
    <td><b><br>: <?= $user->nama_asprak ?></b></td>
  </tr>
  <tr style="font-family: Arial; font-size: 9px;">
    <td><b>NIM</b></td>
    <td><b>: <?= $user->nim_asprak ?></b></td>
  </tr>
  <tr style="font-family: Arial; font-size: 9px;">
    <td><b>BULAN</b></td>
    <td><b>: <?= $bulan ?></b></td>
  </tr>
  <tr style="font-family: Arial; font-size: 9px;">
    <td><b>PRODI</b></td>
    <td><b>: <?= $mk_prodi->strata . ' ' . $mk_prodi->nama_prodi ?></b></td>
  </tr>
  <tr style="font-family: Arial; font-size: 9px;">
    <td><b>MK / KODE MK</b></td>
    <td><b>: <?= $mk_prodi->nama_mk . ' / ' . $mk_prodi->kode_mk ?></b></td>
  </tr>
  <tr style="font-family: Arial; font-size: 9px;">
    <td><b>TAHUN</b></td>
    <td><b>: <?= date('Y') ?></b></td>
  </tr>
  <tr style="font-family: Arial; font-size: 9px;">
    <td><b>TOTAL JAM</b></td>
    <td><b>: <?= $durasi->durasi ?></b></td>
  </tr>
</table>
<br>
<!-- <table border="1" width="100%" style="font-family: Arial; font-size: 9px; border-collapse: collapse; border: 1px solid black">
      <tr style="text-align: center; background-color: #333333; color: white; font-weight: bold">
        <td width="15%">Tanggal</td>
        <td width="8%">Jam Masuk</td>
        <td width="8%">Jam Keluar</td>
        <td width="9%">Jumlah Jam</td>
        <td width="48%" colspan="2">Modul Praktikum</td>
        <td width="12%">Paraf Asprak</td>
      </tr>
      <?php
      $ttd_asprak         = '<center><img src="' . base_url($ttd_asprak) . '" style="height: 20px"></center>';
      $ttd_dosen          = '<img src="' . base_url($koordinator->ttd_dosen) . '" style="height: 40px" class="img">';
      foreach ($bap as $b) {
        $tanggal_indonesia  = tanggal_indonesia($b->tanggal);
        $gambar_praktikum   = '<img src="' . base_url($b->screenshot) . '" style="height: 60px">';
      ?>
        <tr>
          <td style="text-align: center"><?= $tanggal_indonesia ?></td>
          <td style="text-align: center"><?= $b->jam_masuk ?></td>
          <td style="text-align: center"><?= $b->jam_selesai ?></td>
          <td style="text-align: center"><?= $b->durasi ?></td>
          <td style="padding: 5px 5px 5px 5px"><?= $b->modul ?></td>
          <td class="img-table" style="text-align: center"><?= $gambar_praktikum ?></td>
          <td><?= $ttd_asprak ?></td>
        </tr>
      <?php
      }
      ?>
    </table> -->
<br><br>
<p style="text-align: right; font-family: Arial; font-size: 9px">
  Bandung, <?= $tanggal_sekarang ?><br>
  Koordinator Mata Kuliah
</p>
<div class="pembungkus">
  <?= $ttd_dosen ?>
</div>
<!-- <p style="text-align: right; font-family: Arial; font-size: 9px">
      Bandung, <?= $tanggal_sekarang ?>
      <br>Koordinator Mata Kuliah<br><br>
      <?= $ttd_dosen ?><br><br>
      <?= $koordinator->nama_dosen ?>
    </p> -->
</body>

</html>