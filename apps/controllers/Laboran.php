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

  public function Schedule()
  {
    $data['title']  = 'Schedule | SIM Laboratorium';
    $data['id_lab'] = uri('3');
    $data['data']   = $this->laboran->daftarLabPraktikum()->result();
    view('laboran/header', $data);
    view('laboran/schedule', $data);
    view('laboran/footer');
  }

  public function ajaxJadwal()
  {
    $hasil  = array();
    $id_lab = uri('3');
    if ($id_lab) {
      $data = $this->laboran->jadwalPerLab($id_lab)->result();
    } else {
      $data = $this->laboran->jadwalLab()->result();
    }
    foreach ($data as $d) {
      $tmp['title']           = $d->title;
      $tmp['start']           = $d->start;
      $tmp['end']             = $d->end;
      $tmp['dow']             = $d->hari_ke;
      $tmp['backgroundColor'] = $d->color;
      array_push($hasil, $tmp);
    }
    echo json_encode($hasil);
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
        echo '<hr>';
      }
      fclose($handle);
    }
  }
}
