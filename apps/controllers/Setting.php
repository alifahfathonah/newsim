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
    if (userdata('login') == 'aslab') {
      echo 'hai';
    } elseif (userdata('login') == 'dosen') {
      set_rules('nip_dosen', 'NIP', 'required|trim');
      set_rules('nama_dosen', 'Name', 'required|trim');
      if (validation_run() == false) {
        $data           = $this->data;
        $data['title']  = 'Setting | SIM Laboratorium';
        $data['akun']   = $this->m->akunDosen(userdata('id'))->row();
        view('dosen/header', $data);
        view('dosen/setting', $data);
        view('dosen/footer');
      } else {
        $nip_dosen  = input('nip_dosen');
        $nama_dosen = input('nama_dosen');
        $no_telp    = input('no_telp');
        $input      = array(
          'nip_dosen'   => $nip_dosen,
          'nama_dosen'  => $nama_dosen
        );
        if ($no_telp != null) {
          $input['no_telp'] = $no_telp;
        }
        $id_dosen   = $this->db->get_where('users', array('idUser' => userdata('id')))->row()->id_dosen;
        $cek_data   = $this->db->get_where('dosen', array('id_dosen' => $id_dosen))->row();
        $tmp  = explode('/', $_FILES['file_ttd']['type']);
        $ekstensi_file  = $tmp[1];
        $nama_file  = substr(md5($_FILES['file_ttd']['name']), 10, 7);
        $nama_file  = $nama_file . '.' . $ekstensi_file;
        $config['upload_path']    = 'assets/signature/dosen/';
        $config['allowed_types']  = 'gif|jpg|jpeg|png';
        $config['max_size']       = 1024 * 10;
        $config['file_name']      = $nama_file;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file_ttd')) {
          if ($cek_data->ttd_dosen) {
            unlink($cek_data->ttd_dosen);
          }
          $input['ttd_dosen']     = $config['upload_path'] . '' . $nama_file;
        }
        $this->m->updateData('dosen', $input, 'id_dosen', $id_dosen);
        $username_dosen   = input('username_dosen');
        $password_lama    = input('password_lama');
        $password_baru    = input('password_baru');
        $konfirm_password = input('konfirm_password');
        if ($password_lama == null) {
          set_flashdata('msg', '<div class="alert alert-success msg">Data successfully updated.</div>');
        } else {
          $cek_password = $this->db->get_where('users', array('username' => $username_dosen))->row()->password;
          if ($cek_password == sha1($password_lama)) {
            if ($password_baru == $konfirm_password) {
              $input  = array('password' => sha1($password_baru));
              $this->db->where('username', $username_dosen)->update('users', $input);
              set_flashdata('msg', '<div class="alert alert-success msg">Your password successfully updated.</div>');
            } else {
              set_flashdata('msg', '<div class="alert alert-danger">New password and confirm password not match. Please try again.</div>');
            }
          } else {
            set_flashdata('msg', '<div class="alert alert-danger">Old password not match. Please try again.</div>');
          }
        }
        redirect('Setting');
      }
    }
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
