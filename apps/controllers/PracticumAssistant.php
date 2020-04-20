<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PracticumAssistant extends CI_Controller
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
    $data['title']  = 'Practicum Assistant | SIM Laboratorium';
    view('dosen/header', $data);
    view('dosen/practicum_assistant', $data);
    view('dosen/footer');
  }
}
