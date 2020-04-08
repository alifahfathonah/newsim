<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HistoryLogin extends CI_Controller
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
    $data['title']  = 'History Login | SIM Laboratorium';
    $username = $this->db->get_where('users', array('idUser' => userdata('id')))->row()->username;
    $data['data']   = $this->db->order_by('tanggal_login', 'desc')->get_where('history_login', array('username' => $username))->result();
    if (userdata('login') == 'laboran') {
      view('laboran/header', $data);
      view('laboran/history_login', $data);
      view('laboran/footer');
    } elseif (userdata('login') == 'aslab') {
      view('aslab/header', $data);
      view('aslab/history_login', $data);
      view('aslab/footer');
    }
  }
}
