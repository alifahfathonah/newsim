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
    $honor  = $this->db->where('substring(sha1(id_honor), 8, 7) = "' . $id . '"')->get('honor')->row();
    if ($honor == true) {
      $input  = array(
        'tanggal_approve' => date('Y-m-d'),
        'approve_dosen'   => '1'
      );
      $this->m->updateData('honor', $input, 'id_honor', $honor->id_honor);
      $periode  = $this->db->get_where('periode', array('id_periode' => $honor->id_periode))->row();
      $between  = '"' . date('Y') . '-' . $periode->rentang_awal . '" and "' . date('Y') . '-' . $periode->rentang_akhir . '"';
      $bap    = $this->m->previewBAPAsprak($honor->nim_asprak, $honor->id_daftar_mk, $between)->result();
      $asprak = $this->db->get_where('asprak', array('nim_asprak' => $honor->nim_asprak))->row();
      $prodi  = $this->m->tampilProdiBAP($honor->id_daftar_mk)->row();
      $dosen  = $this->db->get_where('dosen', array('id_dosen' => $honor->id_dosen))->row();
      $data['title']    = $periode->id_periode . '_' . $prodi->kode_mk . '_' . $asprak->nim_asprak;
      $data['bap']      = $bap;
      $data['asprak']   = $asprak;
      $data['periode']  = $periode;
      $data['prodi']    = $prodi;
      $data['total']    = $honor;
      $data['dosen']    = $dosen;
      $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
      $html = view('dosen/print_bap', $data, true);
      $mpdf->WriteHTML($html);
      $mpdf->Output('assets/pdf/' . $data['title'] . '.pdf', 'F');
      set_flashdata('msg', '<div class="alert alert-success msg">BAP successfully accepted</div>');
      redirect('BAP');
    } else {
      echo 'salah';
    }
  }
}
