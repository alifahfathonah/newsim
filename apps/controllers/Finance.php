<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Finance extends CI_Controller
{

  var $data;

  public function __construct()
  {
    parent::__construct();
    if (userdata('login') != 'laboran') {
      redirect();
    }
    $id_laboran = $this->db->get_where('users', array('idUser' => userdata('id')))->row()->id_laboran;
    $this->data = array(
      'profil'              => $this->m->profilLaboran($id_laboran)->row(),
      'jumlah_komplain'     => $this->m->hitungKomplain()->row()->komplain,
      'jumlah_pinjam_lab'   => $this->m->hitungPeminjamanLab()->row()->pinjamlab,
      'jumlah_pinjam_alat'  => $this->m->hitungPeminjamanAlat()->row()->pinjamalat,
      'laporan_asprak'      => $this->db->select('count(id_laporan_praktikum) jumlah')->from('laporan_praktikum')->where('status_laporan', '0')->get()->row()->jumlah,
      'honor_asprak'        => $this->db->select('count(id_honor) jumlah')->from('honor')->where('status', '1')->get()->row()->jumlah
    );
  }

  public function Honor()
  {
    $data           = $this->data;
    $data['title']  = 'Honor | SIM Laboratorium';
    $data['withdraw_asprak']  = $this->m->daftarPengambilanHonorAsprak()->result();
    view('laboran/header', $data);
    view('laboran/honor', $data);
    view('laboran/footer');
  }

  public function ApproveHonor()
  {
    $id = $_POST['id'];
    $cek_data = $this->db->where('substring(sha1(id_honor), 8, 7) = "' . $id . '"')->get('honor')->row();
    if ($cek_data) {
      $input  = array('status' => '2');
      $this->db->where('substring(sha1(id_honor), 8, 7) = "' . $id . '"')->update('honor', $input);
      echo 'true';
    }
  }
}
