<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BAP extends CI_Controller
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
    $data['title']  = 'BAP | SIM Laboratorium';
    view('dosen/header', $data);
    view('dosen/bap', $data);
    view('dosen/footer');
  }

  public function Approved()
  {
    $data           = $this->data;
    $data['title']  = 'BAP Approved | SIM Laboratorium';
    view('dosen/header', $data);
    view('dosen/bap_approved', $data);
    view('dosen/footer');
  }

  public function ViewPresence($id)
  {
    $data     = $this->data;
    $honor    = $this->db->where('substring(sha1(id_honor), 8, 7) = "' . $id . '"')->get('honor')->row();
    $periode  = $this->db->get_where('periode', array('id_periode' => $honor->id_periode))->row();
    // $between  = '"' . date('Y') . '-' . $periode->rentang_awal . '" and "' . date('Y') . '-' . $periode->rentang_akhir . '"';
    $between  = '"2020-01-01" and "2020-07-01"';
    $bap      = $this->m->previewBAPAsprak($honor->nim_asprak, $honor->id_daftar_mk, $between)->result();
    $asprak   = $this->db->get_where('asprak', array('nim_asprak' => $honor->nim_asprak))->row();
    $prodi    = $this->m->tampilProdiBAP($honor->id_daftar_mk)->row();
    $data['title']    = 'View Presence | SIM Laboratorium';
    $data['bap']      = $bap;
    $data['asprak']   = $asprak;
    $data['periode']  = $periode;
    $data['prodi']    = $prodi;
    $data['total']    = $honor;
    view('dosen/header', $data);
    view('dosen/view_presence', $data);
    view('dosen/footer', $data);
  }

  public function ApprovePresence()
  {
    $id = $_POST['id'];
    $cek_data = $this->db->where('substring(sha1(id_presensi_asprak), 8, 7) = "' . $id . '"')->get('presensi_asprak')->row();
    if ($cek_data) {
      $input  = array('approve_absen' => '2');
      $this->db->where('substring(sha1(id_presensi_asprak), 8, 7) = "' . $id . '"')->update('presensi_asprak', $input);
      echo 'true';
    }
  }

  public function PendingPresence()
  {
    $id = $_POST['id'];
    $cek_data = $this->db->where('substring(sha1(id_presensi_asprak), 8, 7) = "' . $id . '"')->get('presensi_asprak')->row();
    if ($cek_data) {
      $input  = array('approve_absen' => '0');
      $this->db->where('substring(sha1(id_presensi_asprak), 8, 7) = "' . $id . '"')->update('presensi_asprak', $input);
      echo 'true';
    }
  }

  public function DeletePresence()
  {
    $id = $_POST['id'];
    $cek_data = $this->db->where('substring(sha1(id_presensi_asprak), 8, 7) = "' . $id . '"')->get('presensi_asprak')->row();
    if ($cek_data) {
      $this->db->where('substring(sha1(id_presensi_asprak), 8, 7) = "' . $id . '"')->delete('presensi_asprak');
      echo 'true';
    }
  }

  public function PreviewBAP($id)
  {
    $honor  = $this->db->where('substring(sha1(id_honor), 8, 7) = "' . $id . '"')->get('honor')->row();
    $periode  = $this->db->get_where('periode', array('id_periode' => $honor->id_periode))->row();
    $between  = '"' . date('Y') . '-' . $periode->rentang_awal . '" and "' . date('Y') . '-' . $periode->rentang_akhir . '"';
    $bap    = $this->m->previewBAPAsprak($honor->nim_asprak, $honor->id_daftar_mk, $between)->result();
    $asprak = $this->db->get_where('asprak', array('nim_asprak' => $honor->nim_asprak))->row();
    $prodi  = $this->m->tampilProdiBAP($honor->id_daftar_mk)->row();
    $data['title']    = $periode->id_periode . '_' . $prodi->kode_mk . '_' . $asprak->nim_asprak;
    $data['bap']      = $bap;
    $data['asprak']   = $asprak;
    $data['periode']  = $periode;
    $data['prodi']    = $prodi;
    $data['total']    = $honor;
    $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
    $html = view('dosen/print_bap_baru', $data, true);
    $mpdf->WriteHTML($html);
    $mpdf->Output();
  }

  public function ApproveBAP($id)
  {
    $honor  = $this->db->where('substring(sha1(id_honor), 20, 9) = "' . $id . '"')->get('honor')->row();
    if ($honor == true) {
      $between  = '"2020-01-01" and "2020-07-01"';
      $bap    = $this->m->previewBAPAsprak($honor->nim_asprak, $honor->id_daftar_mk, $between)->result();
      $durasi = $this->m->hitungDurasiBAP($honor->nim_asprak, $honor->id_daftar_mk, $between)->row();
      $input  = array(
        'hari'            => $durasi->hari,
        'jam'             => $durasi->durasi,
        'nominal'         => $durasi->durasi * 10000,
        'tanggal_approve' => date('Y-m-d'),
        'approve_dosen'   => '1'
      );
      $this->m->updateData('honor', $input, 'id_honor', $honor->id_honor);
      $periode  = $this->db->get_where('periode', array('id_periode' => $honor->id_periode))->row();
      $between  = '"2020-01-01" and "2020-07-01"';
      $bap    = $this->m->previewBAPAsprak_($honor->nim_asprak, $honor->id_daftar_mk, $between)->result();
      $total  = $this->m->totalBAPAsprak_($honor->nim_asprak, $honor->id_daftar_mk, $between)->row();
      $asprak = $this->db->get_where('asprak', array('nim_asprak' => $honor->nim_asprak))->row();
      $prodi  = $this->m->tampilProdiBAP($honor->id_daftar_mk)->row();
      $dosen  = $this->db->get_where('dosen', array('id_dosen' => $honor->id_dosen))->row();

      $tanggal_bap = $this->db->select('tanggal_approve')->from('honor')->where('nim_asprak', $honor->nim_asprak)->where('id_daftar_mk', $honor->id_daftar_mk)->where('id_dosen', $dosen->id_dosen)->where('id_dosen is not null')->where('tanggal_approve is not null')->get()->row();
      if ($tanggal_bap == true) {
        $tanggal_bap = $tanggal_bap->tanggal_approve;
      } else {
        $tanggal_bap = 'xx';
      }
      $data['title']    = $periode->id_periode . '_' . $prodi->kode_mk . '_' . $asprak->nim_asprak;
      $data['bap']      = $bap;
      $data['asprak']   = $asprak;
      // $data['periode']  = $periode;
      $data['prodi']    = $prodi;
      $data['total']    = $total;
      $data['dosen']    = $dosen;
      $data['tanggal']  = $tanggal_bap;
      view('laboran/generate_bap', $data);
      $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
      $html = view('laboran/generate_bap', $data, true);
      $mpdf->WriteHTML($html);
      $mpdf->Output('assets/bap/' . $data['title'] . '.pdf', 'F');
      set_flashdata('msg', '<div class="alert alert-success msg">BAP successfully accepted</div>');
      redirect('BAP');
      // print_r($bap);
      // echo '<hr>';
      // print_r($periode);
    } else {
      echo 'salah';
    }
  }
}
