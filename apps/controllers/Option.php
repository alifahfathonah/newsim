<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Option extends CI_Controller
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
      'jumlah_pinjam_alat'  => $this->m->hitungPeminjamanAlat()->row()->pinjamalat
    );
  }

  public function index()
  {
    $data           = $this->data;
    $data['title']  = 'Setting | SIM Laboratorium';
    $data['periode']  = $this->m->daftarPeriode()->result();
    $data['tarif']    = $this->m->daftarTarif()->result();
    view('laboran/header', $data);
    view('laboran/option', $data);
    view('laboran/footer');
  }
}
