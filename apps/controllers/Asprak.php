<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asprak extends CI_Controller
{

  var $data;

  public function __construct()
  {
    parent::__construct();
    if (userdata('login') != 'asprak') {
      redirect();
    }
    $this->data = array(
      'profil'  => $this->asprak->profilAsprak(userdata('nim'))->row()
    );
  }

  public function Dashboard()
  {
    $data             = $this->data;
    $data['title']      = 'Dashboard | SIM Laboratorium';
    // $data['komplain'] = $this->laboran->grafikKomplain()->result();
    $data['pengumuman'] = $this->m->daftarPengumuman()->result();
    view('asprak/header', $data);
    view('asprak/dashboard', $data);
    view('asprak/footer');
  }

  public function Schedule()
  {
    $data             = $this->data;
    $data['title']      = 'Dashboard | SIM Laboratorium';
    // $data['komplain'] = $this->laboran->grafikKomplain()->result();
    // $data['pengumuman'] = $this->laboran->daftarPengumuman()->result();
    view('asprak/header', $data);
    view('asprak/schedule', $data);
    view('asprak/footer');
  }

  public function ajaxJadwal()
  {
    $hasil  = array();
    $data = $this->asprak->jadwalAsprak(userdata('nim'))->result();
    foreach ($data as $d) {
      $tmp['title']           = $d->title;
      $tmp['start']           = $d->start;
      $tmp['end']             = $d->end;
      $tmp['dow']             = $d->hari_ke;
      // $tmp['backgroundColor'] = $d->color;
      array_push($hasil, $tmp);
    }
    echo json_encode($hasil);
  }

  public function Setting()
  {
    set_rules('nim_asprak', 'NIM', 'required|trim');
    if (validation_run() == false) {
      $data           = $this->data;
      $data['title']  = 'Setting | SIM Laboratorium';
      $data['akun']   = $this->asprak->akunAsprak(userdata('nim'))->row();
      $data['bank']   = $this->asprak->daftarBank()->result();
      view('asprak/header', $data);
      view('asprak/setting', $data);
      view('asprak/footer');
    } else {
      $nim_asprak     = input('nim_asprak');
      $nama_asprak    = input('nama_asprak');
      $kontak_asprak  = input('kontak_asprak');
      $bank_asprak    = input('bank_asprak');
      $norek_asprak   = input('norek_asprak');
      $linkaja_asprak = input('linkaja_asprak');
      $input          = array(
        'nama_asprak'     => $nama_asprak,
        'kontak_asprak'   => $kontak_asprak,
        'id_bank'         => $bank_asprak,
        'norek_asprak'    => $norek_asprak,
        'linkaja_asprak'  => $linkaja_asprak
      );
      $this->asprak->updateData('asprak', $input, 'nim_asprak', $nim_asprak);
      $username_asprak  = input('username_asprak');
      $password_lama    = input('password_lama');
      $password_baru    = input('password_baru');
      $konfirm_password = input('konfirm_password');
      if ($password_lama == null) {
        set_flashdata('msg', '<div class="alert alert-success msg">Data successfully updated.</div>');
      } else {
        $cek_password = $this->asprak->cekPassword($username_asprak)->row()->password;
        if ($cek_password == sha1($password_lama)) {
          if ($password_baru == $konfirm_password) {
            $input  = array('password' => sha1($password_baru));
            $this->asprak->updateData('users', $input, 'username', $username_asprak);
            set_flashdata('msg', '<div class="alert alert-success msg">Your password successfully updated.</div>');
          } else {
            set_flashdata('msg', '<div class="alert alert-danger">New password and confirm password not match. Please try again.</div>');
          }
        } else {
          set_flashdata('msg', '<div class="alert alert-danger">Old password not match. Please try again.</div>');
        }
      }
      redirect('Asprak/Setting');
    }
  }

  public function SaveSignature()
  {
    $result = array();
    $image_data = base64_decode($_POST['img_data']);
    $file_name  = $_POST['nim_asprak'];
    $cek_data   = $this->db->get_where('asprak', array('nim_asprak' => $_POST['nim_asprak']))->row();
    if ($cek_data->ttd_asprak) {
      unlink($cek_data->ttd_asprak);
    }
    $save_file  = 'assets/signature/asprak/' . $file_name . '.png';
    $input      = array('ttd_asprak' => $save_file);
    $this->db->where('nim_asprak', $_POST['nim_asprak'])->update('asprak', $input);
    file_put_contents($save_file, $image_data);
    $result['status'] = 1;
    $result['file_name'] = $save_file;
    echo json_encode($result);
  }

  public function DeleteSignature()
  {
    $result = array();
    $nim_asprak = $_POST['nim_asprak'];
    $cek_data   = $this->db->get_where('asprak', array('nim_asprak' => $nim_asprak))->row();
    if ($cek_data->ttd_asprak) {
      unlink($cek_data->ttd_asprak);
    }
    $input      = array('ttd_asprak' => null);
    $this->db->where('nim_asprak', $_POST['nim_asprak'])->update('asprak', $input);
    $result['status'] = 1;
    echo json_encode($result);
  }
}
