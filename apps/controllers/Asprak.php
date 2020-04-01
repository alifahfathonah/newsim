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
    $data['komplain'] = $this->laboran->grafikKomplain()->result();
    $data['pengumuman'] = $this->laboran->daftarPengumuman()->result();
    view('asprak/header', $data);
    view('asprak/dashboard', $data);
    view('asprak/footer');
  }

  public function Pengaturan()
  {
    set_rules('nim_asprak', 'NIM', 'required|trim');
    if (validation_run() == false) {
      $data           = $this->data;
      $data['title']  = 'Pengaturan | SIM Laboratorium';
      $data['akun']   = $this->asprak->akunAsprak(userdata('nim'))->row();
      $data['bank']   = $this->asprak->daftarBank()->result();
      view('asprak/header', $data);
      view('asprak/pengaturan', $data);
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
        set_flashdata('msg', '<div class="alert alert-success msg">Data sukses diperbarui</div>');
      } else {
        $cek_password = $this->asprak->cekPassword($username_asprak)->row()->password;
        if ($cek_password == sha1($password_lama)) {
          if ($password_baru == $konfirm_password) {
            $input  = array('password' => sha1($password_baru));
            $this->asprak->updateData('users', $input, 'username', $username_asprak);
            set_flashdata('msg', '<div class="alert alert-success msg">Password Anda sukses diperbarui</div>');
          } else {
            set_flashdata('msg', '<div class="alert alert-danger">Password baru dengan konfirmasi password tidak cocok. Silahkan coba lagi.</div>');
          }
        } else {
          set_flashdata('msg', '<div class="alert alert-danger">Password lama tidak cocok. Silahkan coba lagi.</div>');
        }
      }
      redirect('Asprak/Pengaturan');
    }
  }
}
