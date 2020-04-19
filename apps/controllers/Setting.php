<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
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
    $data['title']  = 'Setting | SIM Laboratorium';
    $data['akun']   = $this->m->akunDosen(userdata('id'))->row();
    view('dosen/header', $data);
    view('dosen/setting', $data);
    view('dosen/footer');
  }

  public function SaveSignature()
  {
    $result = array();
    $image_data = base64_decode($_POST['img_data']);
    $file_name  = substr(md5(rand(10, 99)), 10, 7);
    $id_dosen   = $this->db->get_where('users', array('idUser' => userdata('id')))->row()->id_dosen;
    $cek_data   = $this->db->get_where('dosen', array('id_dosen' => $id_dosen))->row();
    if ($cek_data->ttd_dosen) {
      unlink($cek_data->ttd_dosen);
    }
    $save_file  = 'assets/signature/dosen/' . $file_name . '.png';
    $input      = array('ttd_dosen' => $save_file);
    $this->db->where('id_dosen', $id_dosen)->update('dosen', $input);
    file_put_contents($save_file, $image_data);
    $result['status'] = 1;
    $result['file_name'] = $save_file;
    echo json_encode($result);
  }
}
