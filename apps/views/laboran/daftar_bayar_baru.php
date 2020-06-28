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
  <?php
  $cek_periode = $this->db->where('id_periode', $periode)->get('periode')->row();
  ?>
  <table width="100%" style="font-weight: bold; text-align: center">
    <tr>
      <td>DAFTAR BAYAR PERKULIAHAN PRAKTIKUM</td>
    </tr>
    <tr>
      <td>PRODI <?= strtoupper($prodi) ?></td>
    </tr>
    <tr>
      <td>FAKULTAS ILMU TERAPAN UNIVERSITAS TELKOM</td>
    </tr>
    <tr>
      <td>PERIODE: <?= $cek_periode->rentang . ' ' . date('Y') ?></td>
    </tr>
  </table>
  <br>
  <table border="1" width="100%" class="table-isi">
    <thead>
      <tr>
        <td class="thead-isi" width="4%">NO</td>
        <td class="thead-isi" width="10%">NIM</td>
        <td class="thead-isi" width="20%">NAMA</td>
        <td class="thead-isi" width="28%">MATA KULIAH</td>
        <td class="thead-isi" width="6%">&#x3A3; HARI</td>
        <td class="thead-isi" width="6%">&#x3A3; JAM</td>
        <td class="thead-isi" width="8%">TARIF PER JAM</td>
        <td class="thead-isi" width="11%">JUMLAH DIBAYAR</td>
        <td class="thead-isi" width="7%">TANDA TANGAN</td>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 0;
      $total_hari = 0;
      $total_jam  = 0;
      $total_dibayar  = 0;
      $tmp_hari = 0;
      $tmp_jam = 0;
      $tmp_dibayar = 0;
      $jumlah_row = 0;
      $tarif  = $this->db->where('status', '1')->get('tarif')->row()->tarif_honor;
      foreach ($daftar_mk as $d) {
        // $daftar_honor = $this->db->where('id_periode', $periode)->where('id_daftar_mk', $d->id_daftar_mk)->where('approve_dosen', '1')->get('honor')->result();
        $daftar_honor = $this->db->select('asprak.nim_asprak, asprak.nama_asprak, matakuliah.nama_mk, honor.hari, honor.jam, asprak.ttd_asprak')->from('honor')->join('asprak', 'honor.nim_asprak = asprak.nim_asprak')->join('daftar_mk', 'honor.id_daftar_mk = daftar_mk.id_daftar_mk')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('honor.id_daftar_mk', $d->id_daftar_mk)->where('honor.id_periode', $periode)->where('honor.approve_dosen', '1')->order_by('asprak.nama_asprak', 'asc')->get()->result();
        foreach ($daftar_honor as $dh) {
          $jumlah_row++;
        }
      }
      ?>
      <?php
      foreach ($daftar_mk as $d) {
        // $daftar_honor = $this->db->where('id_periode', $periode)->where('id_daftar_mk', $d->id_daftar_mk)->where('approve_dosen', '1')->get('honor')->result();
        $daftar_honor = $this->db->select('asprak.nim_asprak, asprak.nama_asprak, matakuliah.nama_mk, honor.hari, honor.jam, asprak.ttd_asprak')->from('honor')->join('asprak', 'honor.nim_asprak = asprak.nim_asprak')->join('daftar_mk', 'honor.id_daftar_mk = daftar_mk.id_daftar_mk')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('honor.id_daftar_mk', $d->id_daftar_mk)->where('honor.id_periode', $periode)->where('honor.approve_dosen', '1')->order_by('asprak.nama_asprak', 'asc')->get()->result();
        foreach ($daftar_honor as $dh) {
          $no++;
          if ($no >= 1 && $no <= 36) {
            $total_hari = $total_hari + $dh->hari;
            $total_jam  = $total_jam + $dh->jam;
            $total_dibayar  = $total_dibayar + ($dh->jam * $tarif);
      ?>
            <tr>
              <td style="text-align: center"><?= $no ?></td>
              <td style="text-align: center"><?= $dh->nim_asprak ?></td>
              <td style="padding-left: 3px; padding-right: 3px"><?= $dh->nama_asprak ?></td>
              <td style="padding-left: 3px; padding-right: 3px"><?= $dh->nama_mk ?></td>
              <td style="text-align: center"><?= $dh->hari ?></td>
              <td style="text-align: center"><?= $dh->jam ?></td>
              <td style="text-align: right; padding-left: 3px; padding-right: 3px"><?= number_format($tarif, 0, '.', ',') ?></td>
              <td style="text-align: right; padding-left: 3px; padding-right: 3px"><?= number_format(($dh->jam * $tarif), 0, '.', ',') ?></td>
              <td style="text-align: center; padding-left: 10px"><img src="<?= base_url($dh->ttd_asprak) ?>" style="height: 18px"></td>
            </tr>
          <?php
          } elseif ($no == 37 || $no == 79) {
            echo '</tbody></table>';
            echo '<br><br><br><br><br><br><br><br><br><br>';
            echo '<table border="1" width="100%" class="table-isi"><thead><tr><td class="thead-isi" width="4%">NO</td><td class="thead-isi" width="10%">NIM</td><td class="thead-isi" width="20%">NAMA</td><td class="thead-isi" width="28%">MATA KULIAH</td><td class="thead-isi" width="6%">&#x3A3; HARI</td><td class="thead-isi" width="6%">&#x3A3; JAM</td><td class="thead-isi" width="8%">TARIF PER JAM</td><td class="thead-isi" width="11%">JUMLAH DIBAYAR</td><td class="thead-isi" width="7%">TANDA TANGAN</td></tr></thead><tbody>';
          ?>
            <tr>
              <td style="text-align: center"><?= $no ?></td>
              <td style="text-align: center"><?= $dh->nim_asprak ?></td>
              <td style="padding-left: 3px; padding-right: 3px"><?= $dh->nama_asprak ?></td>
              <td style="padding-left: 3px; padding-right: 3px"><?= $dh->nama_mk ?></td>
              <td style="text-align: center"><?= $dh->hari ?></td>
              <td style="text-align: center"><?= $dh->jam ?></td>
              <td style="text-align: right; padding-left: 3px; padding-right: 3px"><?= number_format($tarif, 0, '.', ',') ?></td>
              <td style="text-align: right; padding-left: 3px; padding-right: 3px"><?= number_format(($dh->jam * $tarif), 0, '.', ',') ?></td>
              <td style="text-align: center; padding-left: 10px"><img src="<?= base_url($dh->ttd_asprak) ?>" style="height: 18px"></td>
            </tr>
          <?php
          } elseif ($no > 37) {
          ?>
            <tr>
              <td style="text-align: center"><?= $no ?></td>
              <td style="text-align: center"><?= $dh->nim_asprak ?></td>
              <td style="padding-left: 3px; padding-right: 3px"><?= $dh->nama_asprak ?></td>
              <td style="padding-left: 3px; padding-right: 3px"><?= $dh->nama_mk ?></td>
              <td style="text-align: center"><?= $dh->hari ?></td>
              <td style="text-align: center"><?= $dh->jam ?></td>
              <td style="text-align: right; padding-left: 3px; padding-right: 3px"><?= number_format($tarif, 0, '.', ',') ?></td>
              <td style="text-align: right; padding-left: 3px; padding-right: 3px"><?= number_format(($dh->jam * $tarif), 0, '.', ',') ?></td>
              <td style="text-align: center; padding-left: 10px"><img src="<?= base_url($dh->ttd_asprak) ?>" style="height: 18px"></td>
            </tr>
      <?php
          }
        }
      }
      ?>
      <tr>
        <td colspan="4" style="font-weight: bold; text-align: center">Total</td>
        <td style="font-weight: bold; text-align: center; padding-left: 3px; padding-right: 3px"><?= $total_hari ?></td>
        <td style="font-weight: bold; text-align: center; padding-left: 3px; padding-right: 3px"><?= $total_jam ?></td>
        <td style="font-weight: bold; text-align: center; padding-left: 3px; padding-right: 3px"></td>
        <td style="font-weight: bold; text-align: right; padding-left: 3px; padding-right: 3px"><?= number_format($total_dibayar, 0, '.', ',') ?></td>
        <td style="font-weight: bold; text-align: center; padding-left: 3px; padding-right: 3px"></td>
      </tr>
    </tbody>
  </table>
  <br><br><br>
  <table width="100%" style="text-align: right">
    <tr>
      <td colspan="3">&nbsp;</td>
      <td width="30%" style="text-align: center">Bandung, <?= tanggal_indonesia(date('Y-m-d')) ?></td>
    </tr>
    <tr>
      <td colspan="2" width="40%" style="text-align: center">Mengetahui,</td>
      <td width="30%" style="text-align: center">Menyetujui,</td>
      <td width="30%" style="text-align: center">Pembuat Daftar,</td>
    </tr>
    <?php
    for ($i = 0; $i <= 3; $i++) {
      echo '<tr><td colspan="4">&nbsp;</td></tr>';
    }
    ?>
    <tr>
      <td colspan="2" width="40%" style="text-align: center">Devie Ryana Suchendra</td>
      <td width="30%" style="text-align: center">Agus Pratondo</td>
      <td width="30%" style="text-align: center">Alit Yuniargan Eskaluspita</td>
    </tr>
  </table>
</body>

</html>