<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LPJAsprak extends CI_Controller
{
  
  var $data;

  public function __construct()
  {
    parent::__construct();
    if (userdata('login') != 'laboran' && userdata('login') != 'aslab' && userdata('login') != 'dosen') {
      redirect();
    }
    $id_dosen = $this->db->get_where('users', array('idUser' => userdata('id')))->row()->id_dosen;
    $this->data = array(
      'profil'              => $this->m->profilDosen($id_dosen)->row()
    );
  }

  public function index()
  {
    $data           = $this->data;
    $data['title']  = 'LPJ Asprak | SIM Laboratorium';
    $data['daftar_lpj'] = $this->db->where('koordinator_mk', userdata('id_dosen'))->order_by('id_daftar_mk', 'desc')->get('daftar_mk')->result();
    view('dosen/header', $data);
    view('dosen/lpj_asprak', $data);
    view('dosen/footer');
  }

}