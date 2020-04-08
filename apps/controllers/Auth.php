<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    require APPPATH . 'libraries/phpmailer/src/Exception.php';
    require APPPATH . 'libraries/phpmailer/src/PHPMailer.php';
    require APPPATH . 'libraries/phpmailer/src/SMTP.php';
    $update = array('status' => 'Selesai');
    $this->db->where('tglKembali < date_add(now(), interval -1 day)')->update('peminjamanlab', $update);
    $this->db->where('tglKembali < date_add(now(), interval -1 day)')->update('peminjamanalat', $update);
  }

  public function index()
  {
    if (userdata('login') == 'laboran') {
      redirect('Dashboard');
    } elseif (userdata('login') == 'aslab') {
      redirect('Dashboard');
    } elseif (userdata('login') == 'asprak') {
      redirect('Asprak/Dashboard');
    } elseif (userdata('login') == 'grant') {
      #
    } elseif (userdata('login') == 'magang') {
      #
    } else {
      set_rules('username_user', 'Username', 'required|trim');
      set_rules('password_user', 'Password', 'required|trim');
      if (validation_run() == false) {
        $data['title']  = 'SIM Laboratorium | Telkom University';
        view('auth/index', $data);
      } else {
        $username = input('username_user');
        $password = sha1(input('password_user'));
        $where    = array('username' => $username, 'password' => $password);
        $cekData  = $this->auth->cekUser($where)->row();
        $geolocation  = $this->geolocation('114.142.169.36');
        // $geolocation  = $this->geolocation($this->cekIP());
        if ($cekData) {
          $history = array(
            'ip'            => $this->cekIP(),
            'browser'       => $this->cekUserAgent(),
            'platform'      => $this->agent->platform(),
            'username'      => $username,
            'tanggal_login' => date('Y-m-d H:i:s'),
            'kota'          => $geolocation['city'],
            'provinsi'      => $geolocation['region']
          );
          $this->auth->insertData('history_login', $history);
          if ($cekData->jenisAkses == 'laboran') {
            if ($cekData->username == 'superadmin') {
              $session = array(
                'login'     => $cekData->jenisAkses,
                'id'        => $cekData->idUser,
                'username'  => $cekData->username,
                'nama'      => 'Staff Laboratory',
                'jabatan'   => $cekData->jabatan
              );
            } else {
              $data_laboran = $this->db->get_where('laboran', array('id_laboran' => $cekData->id_laboran))->row();
              $session = array(
                'login'     => $cekData->jenisAkses,
                'id'        => $cekData->idUser,
                'username'  => $cekData->username,
                'jabatan'   => $cekData->jabatan
              );
            }
            set_userdata($session);
            redirect('Dashboard');
          } elseif ($cekData->jenisAkses == 'aslab') {
            $session = array(
              'login'     => $cekData->jenisAkses,
              'id'        => $cekData->idUser,
              'username'  => $cekData->username,
              'id_aslab'  => $cekData->idAslab,
              'jabatan'   => $cekData->jabatan
            );
            set_userdata($session);
            redirect('Dashboard');
          } elseif ($cekData->jenisAkses == 'asprak') {
            $session = array(
              'login'     => $cekData->jenisAkses,
              'id'        => $cekData->idUser,
              'username'  => $cekData->username,
              'nim'       => $cekData->nimAsprak,
              'jabatan'   => $cekData->jabatan
            );
            set_userdata($session);
            redirect('Asprak/Dashboard');
          } elseif ($cekData->jenisAkses == 'magang') {
            echo 4;
          } elseif ($cekData->jenisAkses == 'grant') {
            echo 5;
          }
        } else {
          set_flashdata('msg', '<div class="alert alert-danger">Incorrect Username or Password</div>');
          redirect('Auth');
        }
      }
    }
  }

  public function RegisterAslab()
  {
    set_rules('nim_user', 'NIM', 'required|trim');
    set_rules('username_user', 'Username', 'required|trim');
    set_rules('password_user', 'Password', 'required|trim');
    if (validation_run() == false) {
      $data['title']  = 'Laboratory Assistant | SIM Laboratorium';
      $data['data']   = $this->auth->daftarAslab('2019/2020')->result();
      view('auth/register_aslab', $data);
    } else {
      $nim_user       = input('nim_user');
      $username_user  = input('username_user');
      $password_user  = sha1(input('password_user'));
      $input          = array(
        'username'    => $username_user,
        'password'    => $password_user,
        'idAslab'     => $nim_user,
        'jenisAkses'  => 'aslab',
        'status'      => '1'
      );
      $this->auth->insertData('users', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Thank you for register. Now you can login using your account.</div>');
      redirect();
    }
  }

  public function RegisterAsprak()
  {
    set_rules('nim_user', 'NIM', 'required|trim');
    set_rules('username_user', 'Username', 'required|trim');
    set_rules('password_user', 'Password', 'required|trim');
    if (validation_run() == false) {
      $data['title']  = 'Register Practicum Assistant | SIM Laboratorium';
      $data['data']   = $this->auth->daftarAsprak()->result();
      view('auth/register_asprak', $data);
    } else {
      $nim_user       = input('nim_user');
      $username_user  = input('username_user');
      $password_user  = sha1(input('password_user'));
      $input          = array(
        'username'    => $username_user,
        'password'    => $password_user,
        'nimAsprak'   => $nim_user,
        'jenisAkses'  => 'asprak',
        'jabatan'     => 'Asisten Praktikum',
        'status'      => '1'
      );
      $this->auth->insertData('users', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Thank you for register. Now you can login using your account.</div>');
      redirect();
    }
  }

  public function RegisterLecture()
  {
    set_rules('nip_user', 'NIP', 'required|trim');
    set_rules('nama_user', 'Nama', 'required|trim');
    set_rules('username_user', 'Username', 'required|trim');
    set_rules('password_user', 'Password', 'required|trim');
    if (validation_run() == false) {
      $data['title']  = 'Register Lecture | SIM Laboratorium';
      view('auth/register_dosen', $data);
    } else {
      $nip_user       = input('nip_user');
      $nama_user      = input('nama_user');
      $username_user  = input('username_user');
      $password_user  = sha1(input('password_user'));
      $input          = array(
        'username'    => $username_user,
        'password'    => $password_user,
        'nipDosen'    => $nip_user,
        'jenisAkses'  => 'dosen',
        'jabatan'     => 'Lecture',
        'status'      => '0'
      );
      $this->auth->insertData('users', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Thank you for register. Now you can login using your account.</div>');
      redirect();
    }
  }

  public function RegisterStaff()
  {
    set_rules('nip_laboran', 'NIP', 'required|trim');
    set_rules('username_user', 'Username', 'required|trim');
    set_rules('password_user', 'Password', 'required|trim');
    if (validation_run() == false) {
      $data['title']  = 'Register Staff Laboratory | SIM Laboratorium';
      $data['data']   = $this->auth->daftarStaffLaboran()->result();
      view('auth/register_staff', $data);
    } else {
      $nip_laboran    = input('nip_laboran');
      $username_user  = input('username_user');
      $password_user  = sha1(input('password_user'));
      $input          = array(
        'username'    => $username_user,
        'password'    => $password_user,
        'id_laboran'  => $nip_laboran,
        'jenisAkses'  => 'laboran',
        'jabatan'     => 'Staff Laboratory',
        'status'      => '1'
      );
      $this->auth->insertData('users', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Thank you for register. Now you can login using your account.</div>');
      redirect();
    }
  }

  public function ajaxCekUsername()
  {
    if (!empty($_POST['username'])) {
      $cek_username = $this->auth->cekUsername($_POST['username'])->row()->jumlah;
      if ($cek_username > 0) {
        echo 'Username <b>' . $_POST['username'] . ' </b>already exist';
      } else {
        echo 'null';
      }
    }
  }

  public function email()
  {
    $response = false;
    $mail             = new PHPMailer();
    $mail->isSMTP();
    $mail->Host       = 'simlabfit.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'admin@simlabfit.com';
    $mail->Password   = 'superlab5f1t';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('admin@simlabfit.com', 'SIM Laboratorium FIT');
    $mail->addReplyTo('admin@simlabfit.com', '');
    $mail->addAddress('bsapp.1207@gmail.com');
    $mail->Subject    = 'Reset Your SIM Laboratorium Password';
    $mail->isHTML(true);
    $data['nama'] = 'Bayu Setya Ajie Perdana Putra';
    $isi = view('auth/email', $data, true);
    $mailContent  = $isi;
    $mail->Body = $mailContent;
    if (!$mail->send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
      echo 'Message has been sent';
    }
  }

  private function cekIP()
  {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
  }

  private function cekUserAgent()
  {
    if ($this->agent->is_browser()) {
      $agent = $this->agent->browser() . ' ' . $this->agent->version();
    } elseif ($this->agent->is_robot()) {
      $agent = $this->agent->robot();
    } elseif ($this->agent->is_mobile()) {
      $agent = $this->agent->mobile();
    } else {
      $agent = 'Unidentified User Agent';
    }
    return $agent;
  }

  private function geolocation($ip)
  {
    $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
    $details = json_decode($json, true);
    return $details;
  }

  public function Logout()
  {
    $this->session->sess_destroy();
    redirect();
  }
}
