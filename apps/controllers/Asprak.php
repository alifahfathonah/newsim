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

  public function BAP()
  {
    $data           = $this->data;
    $data['title']  = 'BAP | SIM Laboratorium';
    $data['mk']     = $this->a->daftarMKAsprak(userdata('nim'))->result();
    view('asprak/header', $data);
    view('asprak/bap', $data);
    view('asprak/footer');
  }

  public function ajaxBAP()
  {
    $data                       = $this->data;
    $nim_asprak = userdata('nim');
    $bulan_indo                 = $bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $id_mk                      = input('idMK');
    $ambil                      = input('bulan');
    $tmp                        = explode("|", $ambil);
    $bulan                      = $tmp[0];
    $namaBulan                  = $bulan_indo[$tmp[1]];
    $ambil_mk                   = $this->db->select('matakuliah.kode_mk, matakuliah.nama_mk, prodi.strata, prodi.kode_prodi, prodi.nama_prodi')->from('daftar_mk')->join('prodi', 'daftar_mk.kode_prodi = prodi.kode_prodi')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('matakuliah.id_mk', $id_mk)->get()->row();
    $durasi                     = $this->db->select('sum(presensi_asprak.durasi) durasi')->from('presensi_asprak')->join('jadwal_asprak', 'presensi_asprak.id_jadwal_asprak = jadwal_asprak.id_jadwal_asprak')->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->where('jadwal_lab.id_mk', $id_mk)->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $bulan)->where('presensi_asprak.nim_asprak', $nim_asprak)->order_by('presensi_asprak.asprak_masuk')->get()->row();
    $output                     = '<table width="100%">
                                    <tr>
                                      <td style="font-family: Arial; font-size: 14px;" width="40%" valign="top" colspan="2"><b>BERITA ACARA PEKERJAAN DAN KEHADIRAN<br>ASISTEN PRAKTIKUM</b></td>
                                      <td width="30%" rowspan="8" valign="top">
                                        <div align="right">
                                          <img src="' . base_url() . 'assets/img/logo_tass.png" height="70px" width="250px">
                                          <p style="font-family: Arial; font-size: 12px;"><b>Laboratoria<br>Fakultas Ilmu Terapan</b></p>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td width="10%"><b><br>NAMA</b></td>
                                      <td><br><b>: ' . $data['profil']->nama_asprak . '</b></td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>NIM</b></td>
                                      <td><b>: ' . userdata('nim') . '</b></td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>BULAN</b></td>
                                      <td><b>: ' . $namaBulan . '</b></td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>PRODI</b></td>
                                      <td><b>: ' . $ambil_mk->strata . ' ' . $ambil_mk->nama_prodi . '</b></td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>MK / KODE MK</b></td>
                                      <td><b>: ' . $ambil_mk->nama_mk . ' / ' . $ambil_mk->kode_mk . '</b></td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>TAHUN</b></td>
                                      <td><b>: ' . date("Y") . '</b></td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>TOTAL JAM</b></td>
                                      <td><b>: ' . $durasi->durasi . '</b></td>
                                    </tr>
                                  </table>
                                  <br>
                                  <table border="1" width="100%" style="border-collapse: collapse; border: 1px solid black;">
                                    <tr style="text-align: center; background: #333333; font-weight: bold; color: white;">
                                      <td width="15%">Tanggal</td>
                                      <td width="10%">Jam Masuk</td>
                                      <td width="10%">Jam Keluar</td>
                                      <td width="10%">Jumlah Jam</td>
                                      <td colspan="2">Modul Praktikum</td>
                                      <td width="10%">Paraf Asprak</td>
                                    </tr>';
    if ($bulan != '') {
      $ambil_bap  = $this->db->select('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") jam_masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") jam_selesai, presensi_asprak.durasi, presensi_asprak.modul, presensi_asprak.screenshot')->from('presensi_asprak')->join('jadwal_asprak', 'presensi_asprak.id_jadwal_asprak = jadwal_asprak.id_jadwal_asprak')->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->where('jadwal_lab.id_mk', $id_mk)->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $bulan)->where('presensi_asprak.nim_asprak', $nim_asprak)->order_by('presensi_asprak.asprak_masuk', 'asc')->get()->result();
    }
    $ttd          = $this->db->get_where('asprak', array('nim_asprak' => $nim_asprak))->row()->ttd_asprak;
    foreach ($ambil_bap as $a) {
      $tanggal_indonesia  = tanggal_indonesia($a->tanggal);
      $gambar_praktikum   = '<img src="' . base_url($a->screenshot) . '" style="max-height: 100px">';
      $ttd_asprak         = '<img src="' . base_url($ttd) . '" style="max-height: 50px">';
      $output             .= '<tr>
                                <td style="text-align: center">' . $tanggal_indonesia . '</td>
                                <td style="text-align: center">' . $a->jam_masuk . '</td>
                                <td style="text-align: center">' . $a->jam_selesai . '</td>
                                <td style="text-align: center">' . $a->durasi . '</td>
                                <td>' . $a->modul . '</td>
                                <td width="23%" style="text-align: center">' . $gambar_praktikum . '</td>
                                <td style="text-align: center">' . $ttd_asprak . '</td>
                              </tr>';
    }
    $output                     .= '</table><br>
                                  <p style="text-align: right; font-family: Arial; font-size: 12px">
                                  Bandung, ';
    $output                     .= date('d') . " " . bulan_panjang(date('n')) . " " . date('Y') . '<br>Koordinator Mata Kuliah<br><br><br><br><br><u>';
    for ($i = 0; $i < 68; $i++) {
      $output                   .= '&nbsp';
    }
    $output .= '</u></p>';
    echo $output;
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
      $this->a->updateData('asprak', $input, 'nim_asprak', $nim_asprak);
      $username_asprak  = input('username_asprak');
      $password_lama    = input('password_lama');
      $password_baru    = input('password_baru');
      $konfirm_password = input('konfirm_password');
      if ($password_lama == null) {
        set_flashdata('msg', '<div class="alert alert-success msg">Data successfully updated.</div>');
      } else {
        $cek_password = $this->a->cekPassword($username_asprak)->row()->password;
        if ($cek_password == sha1($password_lama)) {
          if ($password_baru == $konfirm_password) {
            $input  = array('password' => sha1($password_baru));
            $this->a->updateData('users', $input, 'username', $username_asprak);
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

  public function HistoryLogin()
  {
    $data           = $this->data;
    $data['title']  = 'History Login | SIM Laboratorium';
    $username = $this->db->get_where('users', array('idUser' => userdata('id')))->row()->username;
    $data['data']   = $this->db->order_by('tanggal_login', 'desc')->get_where('history_login', array('username' => $username))->result();
    view('asprak/header', $data);
    view('asprak/history_login', $data);
    view('asprak/footer');
  }
}
