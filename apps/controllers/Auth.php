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
          if ($cekData->status == '1') {
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
              if ($cekData->username == 'superadmin' || $cekData->username == 'edogawa') {
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
              #
            } elseif ($cekData->jenisAkses == 'dosen') {
              #
            } elseif ($cekData->jenisAkses == 'magang') {
              #
            } elseif ($cekData->jenisAkses == 'grant') {
              #
            }
          } elseif ($cekData->status == '2') {
            set_flashdata('msg', '<div class="alert alert-danger">Please check your email to actived your account</div>');
            redirect();
          } elseif ($cekData->status == '0') {
            echo 'non aktif';
          }
          // if ($cekData->jenisAkses == 'laboran') {
          //   
          // } elseif ($cekData->jenisAkses == 'aslab') {
          //   
          // } elseif ($cekData->jenisAkses == 'asprak') {
          //   $session = array(
          //     'login'     => $cekData->jenisAkses,
          //     'id'        => $cekData->idUser,
          //     'username'  => $cekData->username,
          //     'nim'       => $cekData->nimAsprak,
          //     'jabatan'   => $cekData->jabatan
          //   );
          //   set_userdata($session);
          //   redirect('Asprak/Dashboard');
          // } elseif ($cekData->jenisAkses == 'magang') {
          //   echo 4;
          // } elseif ($cekData->jenisAkses == 'grant') {
          //   echo 5;
          // } elseif ($cekData->jenisAkses == 'dosen') {
          //   if ($cekData->status == '1') {
          //     $session = array(
          //       'login'     => $cekData->jenisAkses,
          //       'id'        => $cekData->idUser,
          //       'username'  => $cekData->username,
          //       'id_dosen'  => $cekData->id_dosen,
          //       'jabatan'   => $cekData->jabatan
          //     );
          //     set_userdata($session);
          //     redirect('Dashboard');
          //   } elseif ($cekData->status == '2') {
          //     set_flashdata('msg', '<div class="alert alert-danger">Please check your email for activate.</div>');
          //     redirect('Auth');
          //   } else {
          //     set_flashdata('msg', '<div class="alert alert-danger">Your account deactived.</div>');
          //     redirect('Auth');
          //   }
          // }
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
    set_rules('email_user', 'E-mail', 'required|trim');
    set_rules('password_user', 'Password', 'required|trim');
    if (validation_run() == false) {
      $data['title']  = 'Register Practicum Assistant | SIM Laboratorium';
      $data['data']   = $this->auth->daftarAsprak()->result();
      view('auth/register_asprak', $data);
    } else {
      $nim_user       = input('nim_user');
      $username_user  = input('username_user');
      $email_user     = input('email_user');
      $password_user  = sha1(input('password_user'));
      $input          = array(
        'username'    => $username_user,
        'email'       => $email_user,
        'password'    => $password_user,
        'nimAsprak'   => $nim_user,
        'jenisAkses'  => 'asprak',
        'jabatan'     => 'Practicum Assistant',
        'status'      => '1'
      );
      $where = array(
        'nimAsprak' => $nim_user
      );
      $cek_akun = $this->db->get_where('users', $where)->row();
      $cek_nim  = $this->db->get_where('daftarasprak', array('nim_asprak' => $nim_user))->row();
      if ($cek_nim == true) {
        if ($cek_akun == true) {
          set_flashdata('msg', '<div class="alert alert-danger msg">NIM already used. Please login with your account.</div>');
          redirect('Auth/RegisterAsprak');
        } else {
          $this->auth->insertData('users', $input);
          set_flashdata('msg', '<div class="alert alert-success msg">Thank you for register. Now you can login using your account.</div>');
          redirect();
        }
      } else {
        set_flashdata('msg', '<div class="alert alert-danger msg">NIM ' . $nim_user . ' not registered. Please check again.</div>');
        redirect('Auth/RegisterAsprak');
      }
    }
  }

  public function RegisterLecture()
  {
    set_rules('nip_user', 'NIP', 'required|trim');
    set_rules('email_user', 'Email', 'required|trim');
    set_rules('username_user', 'Username', 'required|trim');
    set_rules('password_user', 'Password', 'required|trim');
    if (validation_run() == false) {
      $data['title']  = 'Register Lecture | SIM Laboratorium';
      view('auth/register_dosen', $data);
    } else {
      $nip_user       = input('nip_user');
      $username_user  = input('username_user');
      $email_user     = input('email_user');
      $password_user  = sha1(input('password_user'));
      $cek_nip        = $this->db->get_where('dosen', array('nip_dosen' => $nip_user))->row();
      $cek_akun       = $this->db->get_where('users', array('id_dosen' => $cek_nip->id_dosen))->row();
      if ($cek_nip) {
        if ($cek_akun) {
          set_flashdata('msg', '<div class="alert alert-danger msg">NIP already used to create account. You can login with your username and password.</div>');
          redirect();
        } else {
          if (preg_match('/telkomuniversity.ac.id/', $email_user)) {
            $input  = array(
              'id_dosen'    => $cek_nip->id_dosen,
              'username'    => $username_user,
              'email'       => $email_user,
              'password'    => $password_user,
              'jenisAkses'  => 'dosen',
              'jabatan'     => 'Lecture',
              'status'      => '2'
            );
            $this->auth->insertData('users', $input);
            $input  = array('email_dosen' => $email_user);
            $this->db->where('nip_dosen', $nip_user)->update('dosen', $input);
            $token  = base64_encode(random_bytes(32));
            $this->email_konfirm_akun($cek_nip->nama_dosen, $email_user, $username_user, $token);
            $waktu  = date('Y-m-d H:i:s');
            $input  = array(
              'email'             => $email_user,
              'username'          => $username_user,
              'nama_user'         => $cek_nip->nama_dosen,
              'token'             => $token,
              'tanggal_pengajuan' => $waktu
            );
            $this->auth->insertData('forgot_password', $input);
            set_flashdata('msg', '<div class="alert alert-success">Thank you for register. Please check your inbox/spam to active your account</div>');
            redirect();
          } else {
            set_flashdata('msg', '<div class="alert alert-danger">Sorry you must use email from Telkom University</div>');
            redirect('Auth/RegisterLecture');
          }
        }
      } else {
        set_flashdata('msg', '<div class="alert alert-danger msg">Sorry your NIP not registered.</div>');
        redirect('Auth/RegisterLecture');
      }
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

  public function ForgotPassword()
  {
    set_rules('email_user', 'Password', 'required|trim');
    if (validation_run() == false) {
      $data['title']  = 'Forgot Password | SIM Laboratorium';
      view('auth/forgot_password', $data);
    } else {
      $email_user     = input('email_user');
      $token          = base64_encode(random_bytes(32));
      $waktu          = date('Y-m-d H:i:s');
      $data           = $this->db->get_where('users', array('email' => $email_user))->row();
      $username_user  = $data->username;
      $nama_user      = '';
      if ($data) {
        if ($data->idAslab) {
          $id         = $data->idAslab;
          $nama_user  = $this->db->get_where('aslab', array('idAslab' => $id))->row()->namaLengkap;
        }
        if ($data->nimAsprak) {
          $id         = $data->nimAsprak;
          $nama_user  = $this->db->get_where('asprak', array('nim_asprak' => $id))->row()->nama_asprak;
        }
        if ($data->nipDosen) {
          echo 'dosen';
        }
        if ($data->id_laboran) {
          $id         = $data->id_laboran;
          $nama_user  = $this->db->get_where('laboran', array('id_laboran' => $id))->row()->nama_laboran;
        }
        $input          = array(
          'email'             => $email_user,
          'username'          => $username_user,
          'nama_user'         => $nama_user,
          'token'             => $token,
          'tanggal_pengajuan' => $waktu
        );
        $this->auth->insertData('forgot_password', $input);
        $this->email_reset_password($nama_user, $email_user, $username_user, $token);
        set_flashdata('msg', '<div class="alert alert-success msg">Please check your email to reset your password</div>');
        redirect('Auth/ForgotPassword');
      } else {
        set_flashdata('msg', '<div class="alert alert-danger msg">E-mail not registered</div>');
        redirect('Auth/ForgotPassword');
      }
    }
  }

  public function ConfirmAccount()
  {
    $username = get('username');
    $token    = get('token');
    $cek_data = $this->db->get_where('users', array('username' => $username))->row();
    if ($cek_data) {
      $cek_token  = $this->db->get_where('forgot_password', array('token' => $token))->row();
      if ($cek_token) {
        $input  = array('status' => '1');
        $this->db->where('username', $username)->update('users', $input);
        $this->db->where('username', $username)->where('token', $token)->delete('forgot_password');
        set_flashdata('msg', '<div class="alert alert-success">Your account successfully active. Now you can login</div>');
        redirect();
      } else {
        set_flashdata('msg', '<div class="alert alert-danger">Token not matched or invalid</div>');
        redirect();
      }
    } else {
      set_flashdata('msg', '<div class="alert alert-danger">Username not registered</div>');
      redirect();
    }
  }

  public function ResetPassword()
  {
    $username = get('username');
    $token    = get('token');
    $cek_data = $this->db->get_where('users', array('username' => $username))->row();
    if ($cek_data) {
      $cek_token  = $this->db->get_where('forgot_password', array('token' => $token))->row();
      if ($cek_token) {
        $session = array('reset_password_akun' => $username);
        set_userdata($session);
        $this->ResetPasswordUser();
      } else {
        set_flashdata('msg', '<div class="alert alert-danger msg">Token not matched or invalid</div>');
        redirect('Auth/ForgotPassword');
      }
    } else {
      set_flashdata('msg', '<div class="alert alert-danger msg">Username not registered</div>');
      redirect('Auth/ForgotPassword');
    }
  }

  public function ResetPasswordUser()
  {
    set_rules('username', 'Username', 'required');
    set_rules('password_user', 'New Password', 'required|trim|matches[repeat_password]');
    set_rules('repeat_password', 'Repeat Password', 'required|trim|matches[password_user]');
    if (validation_run() == false) {
      $data['title']    = 'Reset Password | SIM Laboratorium';
      view('auth/reset_password', $data);
    } else {
      $username       = input('username');
      $password_user  = sha1(input('password_user'));
      $this->db->set('password', $password_user)->where('username', $username)->update('users');
      $this->db->where('username', $username)->delete('forgot_password');
      set_flashdata('msg', '<div class="alert alert-success msg">Your password successfully changed. Now you can login.</div>');
      redirect();
    }
  }

  public function ajaxCekNIM()
  {
    if (!empty($_POST['nim'])) {
      $cek_nim  = $this->auth->cekNIM($_POST['nim'])->row()->jumlah;
      if ($cek_nim > 0) {
        echo 'terdaftar';
      } else {
        echo 'tidak';
      }
    }
  }

  public function ajaxCekUsername()
  {
    if (!empty($_POST['username'])) {
      $cek_username = $this->auth->cekUsername($_POST['username'])->row()->jumlah;
      if ($cek_username > 0) {
        echo 'Username <b>' . $_POST['username'] . '</b> already exist';
      } else {
        echo 'null';
      }
    }
  }

  public function ajaxCekEmail()
  {
    if (!empty($_POST['email'])) {
      $cek_email  = $this->auth->cekEmail($_POST['email'])->row()->jumlah;
      if ($cek_email > 0) {
        echo 'E-mail <b>' . $_POST['email'] . '</b> already used';
      } else {
        echo 'null';
      }
    }
  }

  private function email_konfirm_akun($nama, $email, $username, $token)
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
    $mail->addReplyTo('admin@simlabfit.com', 'SIM Laboratorium FIT');
    $mail->addAddress($email);
    $mail->Subject    = 'Confirm Account SIM Laboratorium FIT';
    $mail->isHTML(true);
    $data['nama']     = $nama;
    $data['username'] = $username;
    $data['token']    = $token;
    $isi = view('auth/email_konfirm_akun', $data, true);
    $mailContent  = $isi;
    $mail->Body = $mailContent;
    if (!$mail->send()) {
      echo 'Message could not be sent.<br>';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
      echo 'Message has been sent';
    }
  }

  private function email_reset_password($nama, $email, $username, $token)
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
    // $mail->addReplyTo('simlabfit@bayusapp.com', '');
    $mail->addAddress($email);
    $mail->Subject    = 'Reset Your SIM Laboratorium Password';
    $mail->isHTML(true);
    $data['nama']     = $nama;
    $data['username'] = $username;
    $data['token']    = $token;
    $isi = view('auth/email_reset_password', $data, true);
    $mailContent  = $isi;
    $mail->Body = $mailContent;
    if (!$mail->send()) {
      echo 'Message could not be sent.<br>';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
      echo 'Message has been sent';
    }
  }

  public function cekView()
  {
    $data['nama'] = 'Bayu Setya Ajie Perdana Putra';
    view('auth/email_reset_password', $data);
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
