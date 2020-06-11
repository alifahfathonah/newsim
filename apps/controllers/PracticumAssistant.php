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
    set_rules('mk', 'Courses', 'required|trim');
    set_rules('tahun', 'Year', 'required|trim');
    if (validation_run() == false) {
      $data               = $this->data;
      $data['title']      = 'Practicum Assistant | SIM Laboratorium';
      $id_dosen           = $this->db->get_where('users', array('idUser' => userdata('id')))->row();
      $id_ta              = $this->db->get_where('tahun_ajaran', array('status' => '1'))->row()->id_ta;
      $daftar_mk          = $this->db->select('id_daftar_mk, kode_mk')->from('daftar_mk')->where('id_ta', $id_ta)->where('koordinator_mk', $id_dosen->id_dosen)->get()->result();
      $data['daftar_mk']  = $daftar_mk;
      view('dosen/header', $data);
      view('dosen/practicum_assistant', $data);
      view('dosen/footer');
    } else {
      $mk     = input('mk');
      $tahun  = input('tahun');
      $data               = $this->data;
      $data['title']      = 'Practicum Assistant | SIM Laboratorium';
      $id_dosen           = $this->db->get_where('users', array('idUser' => userdata('id')))->row();
      $daftar_mk          = $this->db->select('id_daftar_mk, kode_mk')->from('daftar_mk')->where('id_ta', $tahun)->where('koordinator_mk', $id_dosen->id_dosen)->where('kode_mk', $mk)->get()->result();
      $data['daftar_mk']  = $daftar_mk;
      view('dosen/header', $data);
      view('dosen/practicum_assistant', $data);
      view('dosen/footer');
    }
  }
}
