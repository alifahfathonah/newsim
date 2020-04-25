<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Schedule extends CI_Controller
{

  var $data;

  public function __construct()
  {
    parent::__construct();
    if (userdata('login') != 'laboran' && userdata('login') != 'aslab') {
      redirect();
    }
    $id_laboran = $this->db->get_where('users', array('idUser' => userdata('id')))->row()->id_laboran;
    $this->data = array(
      'profil'              => $this->m->profilLaboran($id_laboran)->row(),
      'jumlah_komplain'     => $this->m->hitungKomplain()->row()->komplain,
      'jumlah_pinjam_lab'   => $this->m->hitungPeminjamanLab()->row()->pinjamlab,
      'jumlah_pinjam_alat'  => $this->m->hitungPeminjamanAlat()->row()->pinjamalat,
      'laporan_asprak'      => $this->db->select('count(id_laporan_praktikum) jumlah')->from('laporan_praktikum')->where('status_laporan', '0')->get()->row()->jumlah
    );
  }

  public function index()
  {
    $data           = $this->data;
    $data['title']  = 'Schedule | SIM Laboratorium';
    $data['id_lab'] = uri('3');
    $data['data']   = $this->m->daftarLabPraktikum()->result();
    if (userdata('login') == 'laboran') {
      view('laboran/header', $data);
      view('laboran/schedule', $data);
      view('laboran/footer');
    } elseif (userdata('login') == 'aslab') {
      view('aslab/header', $data);
      view('aslab/schedule', $data);
      view('aslab/footer');
    }
  }

  public function ajaxJadwal()
  {
    $hasil  = array();
    $id_lab = uri('3');
    if ($id_lab) {
      $data = $this->m->jadwalPerLab($id_lab)->result();
    } else {
      $data = $this->m->jadwalLab()->result();
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
}
