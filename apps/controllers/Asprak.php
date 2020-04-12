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
      'profil'  => $this->a->profilAsprak(userdata('nim'))->row()
    );
  }

  public function Dashboard()
  {
    $data             = $this->data;
    $data['title']      = 'Dashboard | SIM Laboratorium';
    $data['pengumuman'] = $this->a->daftarPengumuman()->result();
    view('asprak/header', $data);
    view('asprak/dashboard', $data);
    view('asprak/footer');
  }

  public function Schedule()
  {
    $data           = $this->data;
    $data['title']  = 'Schedule | SIM Laboratorium';
    view('asprak/header', $data);
    view('asprak/schedule', $data);
    view('asprak/footer');
  }

  public function ajaxJadwal()
  {
    $hasil  = array();
    $data = $this->a->jadwalAsprak(userdata('nim'))->result();
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

  public function PracticumAssistant()
  {
    $data           = $this->data;
    $data['title']  = 'Practicum Assistant | SIM Laboratorium';
    view('asprak/header', $data);
    view('asprak/practicum_assistant', $data);
    view('asprak/footer');
  }

  public function Presence()
  {
    $data           = $this->data;
    $data['title']  = 'Presence | SIM Laboratorium';
    $data['data']   = $this->a->daftarPresensiAsprak(userdata('nim'))->result();
    view('asprak/header', $data);
    view('asprak/presence', $data);
    view('asprak/footer');
  }

  public function AddPresence()
  {
    set_rules('jadwal_asprak', 'Schedule', 'required|trim');
    set_rules('tgl_asprak', 'Date', 'required|trim');
    set_rules('jam_masuk', 'Start', 'required|trim');
    set_rules('jam_selesai', 'End', 'required|trim');
    set_rules('modul_praktikum', 'Practicum Modul', 'required|trim');
    if (validation_run() == false) {
      $data           = $this->data;
      $data['title']  = 'Add Presence | SIM Laboratorium';
      $data['jadwal'] = $this->a->jadwalPresensiAsprak(userdata('nim'))->result();
      view('asprak/header', $data);
      view('asprak/add_presence', $data);
      view('asprak/footer');
    } else {
      $jadwal_asprak    = input('jadwal_asprak');
      $tgl_asprak       = input('tgl_asprak');
      $jam_masuk        = input('jam_masuk');
      $jam_selesai      = input('jam_selesai');
      $modul_praktikum  = input('modul_praktikum');
      $link_youtube     = input('link_youtube');
      $tmp              = explode('/', $tgl_asprak);
      $urut_tanggal     = array($tmp[2], $tmp[0], $tmp[1]);
      $tanggal          = implode('-', $urut_tanggal);
      $tmp              = explode(':', $jam_masuk);
      $jam_masuk_       = ($tmp[0] * 3600) + ($tmp[1] * 60);
      $tmp              = explode(':', $jam_selesai);
      $jam_selesai_     = ($tmp[0] * 3600) + ($tmp[1] * 60);
      $selisih          = $jam_selesai_ - $jam_masuk_;
      $hitung_durasi    = $selisih / 3600;
      $hitung_durasi    = explode('.', $hitung_durasi);
      $selisih_jam      = $hitung_durasi[0];
      $selisih_menit    = ($selisih % 3600) / 60;
      $honor            = 10000 * $selisih_jam;
      $durasi           = $selisih_jam;
      if ($selisih_menit >= 20 && $selisih_menit <= 30) {
        $honor          = $honor + (10000 / 2);
        $durasi         = $selisih_jam + 0.5;
      } elseif ($selisih_menit >= 40 && $selisih_menit <= 59) {
        $honor          = $honor + 10000;
        $durasi         = $selisih_jam + 1;
      } elseif ($selisih_menit >= 1 && $selisih_menit < 20) {
        $honor          = $honor;
        $durasi         = $selisih_jam;
      } elseif ($selisih_menit > 30 && $selisih_menit < 40) {
        $honor          = $honor + (10000 / 2);
        $durasi         = $selisih_jam + 0.5;
      }
      $cek_presensi     = $this->db->where('date_format(asprak_masuk, "%Y-%m-%d") = "' . $tanggal . '"')->where('id_jadwal_asprak', $jadwal_asprak)->where('nim_asprak', userdata('nim'))->get('presensi_asprak')->row();
      if ($cek_presensi) {
        set_flashdata('msg', '<div class="alert alert-danger">You already presence on that day</div>');
        redirect('Asprak/Presence');
      } else {
        $nama_hari        = date('l', strtotime($tanggal));
        $id_jadwal_lab    = $this->db->get_where('jadwal_asprak', array('id_jadwal_asprak' => $jadwal_asprak))->row()->id_jadwal_lab;
        $cek_jadwal_hari  = $this->db->select('hari_ke')->from('jadwal_lab')->where('id_jadwal_lab', $id_jadwal_lab)->get()->row()->hari_ke;
        $cek_jam_masuk    = $this->db->select('date_format(jam_masuk, "%H:%i") masuk')->from('jadwal_lab')->where('id_jadwal_lab', $id_jadwal_lab)->get()->row()->masuk;
        $cek_jam_selesai  = $this->db->select('date_format(jam_selesai, "%H:%i") selesai')->from('jadwal_lab')->where('id_jadwal_lab', $id_jadwal_lab)->get()->row()->selesai;
        if ($nama_hari != hariInggris($cek_jadwal_hari) || $jam_masuk < $cek_jam_masuk || $jam_selesai > $cek_jam_selesai) {
          echo 'Your presence is not according to the day of practicum or start time before the schedule or end time exceeded the schedule';
          set_flashdata('msg', '<div class="alert alert-danger">Your presence is not according to the day of practicum or start time before the schedule or end time exceeded the schedule</div>');
          redirect('Asprak/AddPresence');
        }
        $input                = array(
          'asprak_masuk'      => $tanggal . ' ' . $jam_masuk,
          'asprak_selesai'    => $tanggal . ' ' . $jam_selesai,
          'durasi'            => $durasi,
          'honor'             => $honor,
          'modul'             => $modul_praktikum,
          'video'             => $link_youtube,
          'id_jadwal_asprak'  => $jadwal_asprak,
          'nim_asprak'        => userdata('nim'),
          'id_jadwal_lab'     => $id_jadwal_lab
        );
        $screenshot               = rand(10, 99) . '-' . str_replace(' ', '_', $_FILES['screenshot_praktikum']['name']);
        $config['upload_path']    = 'assets/screenshot/';
        $config['allowed_types']  = 'jpeg|jpg|png|gif|tiff';
        $config['max_size']       = 1024 * 100;
        $config['file_name']      = $screenshot;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('screenshot_praktikum')) {
          $input['screenshot']     = $config['upload_path'] . '' . $screenshot;
        }
        $this->m->insertData('presensi_asprak', $input);
        set_flashdata('msg', '<div class="alert alert-success msg">Your presence successfully saved</div>');
        redirect('Asprak/Presence');
      }
    }
  }

  public function Setting()
  {
    set_rules('nim_asprak', 'NIM', 'required|trim');
    if (validation_run() == false) {
      $data           = $this->data;
      $data['title']  = 'Setting | SIM Laboratorium';
      $data['akun']   = $this->a->akunAsprak(userdata('nim'))->row();
      $data['bank']   = $this->a->daftarBank()->result();
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
