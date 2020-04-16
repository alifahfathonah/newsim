<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laboran extends CI_Controller
{

  var $data;

  public function __construct()
  {
    parent::__construct();
    if (userdata('login') != 'laboran') {
      redirect();
    }
    $this->db->query("update peminjamanlab set status = 'Selesai' where tglKembali < date_add(now(), interval -1 day)");
    $this->db->query("update peminjamanalat set status = 'Selesai' where tglKembali < date_add(now(), interval -1 day)");
    // $this->data = array(
    //   'komplain'        => 
    //   'peminjaman_alat'
    //   'peminjaman_lab'
    // );
  }

  public function uploadJadwalCSV()
  {
    view('Laboran/csv');
  }

  public function simpanJadwalCSV()
  {
    $file = $_FILES['file_csv']['tmp_name'];
    $ekstensi_file  = explode('.', $_FILES['file_csv']['name']);
    if (strtolower(end($ekstensi_file)) === 'csv' && $_FILES['file_csv']['size'] > 0) {
      $handle = fopen($file, 'r');
      $i = 0;
      while (($row = fgetcsv($handle, 2048))) {
        $i++;
        if ($i == 1) {
          continue;
        }
        if ($row[0] == 'SENIN') {
          $tanggal  = '2016-08-22';
          $hari     = 1;
        } elseif ($row[0] == 'SELASA') {
          $tanggal = '2016-08-23';
          $hari     = 2;
        } elseif ($row[0] == 'RABU') {
          $tanggal = '2016-08-24';
          $hari     = 3;
        } elseif ($row[0] == 'KAMIS') {
          $tanggal = '2016-08-25';
          $hari     = 4;
        } elseif ($row[0] == 'JUMAT') {
          $tanggal = '2016-08-26';
          $hari     = 5;
        } elseif ($row[0] == 'SABTU') {
          $tanggal = '2016-08-27';
          $hari     = 6;
        }
        $shift        = explode(' - ', $row[1]);
        $jam_masuk    = $shift[0];
        $jam_selesai  = $shift[1];
        //
        $matakuliah = $this->db->get('matakuliah')->result();
        foreach ($matakuliah as $m) {
          if ($m->kode_mk == $row[3]) {
            $id_mk  = $m->id_mk;
          }
        }
        $lab  = $this->db->get('laboratorium')->result();
        foreach ($lab as $l) {
          if ($l->kodeRuang == $row[2]) {
            $id_lab = $l->idLab;
            break;
          } elseif ($l->kodeRuang != $row[2]) {
            $id_lab = '-';
          }
        }
        $kode_prodi = substr($row[4], 2, 2);
        $prodi      = $this->db->get('prodi')->result();
        foreach ($prodi as $p) {
          if ($p->kode_prodi == $kode_prodi) {
            $id_prodi = $p->id_prodi;
          }
        }
        //
        $input = array(
          'jam_masuk'   => $tanggal . ' ' . $jam_masuk,
          'jam_selesai' => $tanggal . ' ' . $jam_selesai,
          'kelas'       => $row[4],
          'kode_dosen'  => $row[5],
          'hari_ke'     => $hari,
          'id_mk'       => $id_mk,
          'id_lab'      => $id_lab,
          'id_prodi'    => $id_prodi
        );
        $this->db->insert('jadwal_lab', $input);
      }
      fclose($handle);
    }
  }

  public function uploadDaftarMK()
  {
    view('Laboran/daftar_mk_csv');
  }

  public function simpanDaftarMKCSV()
  {
    $file = $_FILES['file_csv']['tmp_name'];
    $ekstensi_file  = explode('.', $_FILES['file_csv']['name']);
    if (strtolower(end($ekstensi_file)) === 'csv' && $_FILES['file_csv']['size'] > 0) {
      $handle = fopen($file, 'r');
      $i = 0;
      while (($row = fgetcsv($handle, 2048))) {
        $i++;
        if ($i == 1) {
          continue;
        }
        $cek_data = $this->db->select('*')->from('daftar_mk')->where('kode_mk', $row[2])->get()->row();
        if (!$cek_data) {
          $input  = array(
            'id_ta'       => $row[0],
            'kode_prodi'  => $row[3],
            'kode_mk'     => $row[2]
          );
          $this->db->insert('daftar_mk', $input);
        }
      }
      fclose($handle);
    }
    redirect('Schedule');
  }

  public function uploadJadwalAsprak()
  {
    view('Laboran/jadwal_asprak_csv');
  }

  public function simpanJadwalAsprakCSV()
  {
    $file = $_FILES['file_csv']['tmp_name'];
    $ekstensi_file  = explode('.', $_FILES['file_csv']['name']);
    if (strtolower(end($ekstensi_file)) === 'csv' && $_FILES['file_csv']['size'] > 0) {
      $handle = fopen($file, 'r');
      $i = 0;
      $tmp_kode_mk    = '';
      $tmp_kelas      = '';
      $tmp_dosen      = '';
      $tmp_hari       = '';
      $tmp_jam_mulai  = '';
      while (($row = fgetcsv($handle, 2048))) {
        $i++;
        if ($i == 1) {
          continue;
        }
        // cek kode mk
        if ($row[1] == '') {
          $kode_mk = $tmp_kode_mk;
        } else {
          $tmp_kode_mk = $row[1];
          $kode_mk      = $row[1];
        }
        // cek kelas
        if ($row[2] == '') {
          $kelas  = $tmp_kelas;
        } else {
          $tmp_kelas  = $row[2];
          $kelas      = $row[2];
        }
        //cek kode dosen
        if ($row[3] == '') {
          $dosen  = $tmp_dosen;
        } else {
          $tmp_dosen  = $row[3];
          $dosen      = $row[3];
        }
        //cek hari
        if ($row[4] == '') {
          $hari = $tmp_hari;
        } else {
          $tmp_hari = $row[4];
          $hari     = $row[4];
        }
        //cek jam masuk
        if ($row[5] == '') {
          $jam_masuk  = $tmp_jam_mulai;
        } else {
          $tmp_row        = str_replace('.', ':', $row[5]);
          $tmp_jam_mulai  = $tmp_row;
          $jam_masuk      = $tmp_row;
        }
        if ($hari == 'SENIN') {
          $hari_ke = 1;
        } elseif ($hari == 'SELASA') {
          $hari_ke = 2;
        } elseif ($hari == 'RABU') {
          $hari_ke = 3;
        } elseif ($hari == 'KAMIS') {
          $hari_ke = 4;
        } elseif ($hari == 'JUMAT') {
          $hari_ke = 5;
        } elseif ($hari == 'SABTU') {
          $hari_ke = 6;
        }
        $id_mk  = $this->db->select('id_mk')->from('matakuliah')->where('kode_mk', $kode_mk)->get()->row()->id_mk;
        $id_jadwal_lab  = $this->db->select('id_jadwal_lab')->from('jadwal_lab')->where('date_format(jam_masuk, "%H:%i") = "' . $jam_masuk . '"')->where('kelas', $kelas)->where('kode_dosen', $dosen)->where('hari_ke', $hari_ke)->where('id_mk', $id_mk)->get()->row();
        if ($id_jadwal_lab == true) {
          $id_jadwal_lab = $id_jadwal_lab->id_jadwal_lab;
        } else {
          $id_jadwal_lab = '-';
        }
        $jadwal_asprak  = array(
          'nim_asprak'    => $row[0],
          'id_jadwal_lab' => $id_jadwal_lab
        );
        // print_r($jadwal_asprak);
        // echo '<br>';
        $this->db->insert('jadwal_asprak', $jadwal_asprak);
        $id_daftar_mk = $this->db->select('id_daftar_mk')->from('daftar_mk')->where('kode_mk', $kode_mk)->get()->row()->id_daftar_mk;
        $cek_daftar_asprak = $this->db->select('nim_asprak')->from('daftarasprak')->where('nim_asprak', $row[0])->where('id_daftar_mk', $id_daftar_mk)->get()->row();
        if (!$cek_daftar_asprak) {
          $daftarasprak = array(
            'nim_asprak'    => $row[0],
            'id_daftar_mk'  => $id_daftar_mk
          );
          // print_r($daftarasprak);
          // echo '<hr>';
          $this->db->insert('daftarasprak', $daftarasprak);
        }
      }
      fclose($handle);
    }
    redirect('Schedule');
  }
}
