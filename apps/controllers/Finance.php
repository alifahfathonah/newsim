<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Finance extends CI_Controller
{

  var $data;

  public function __construct()
  {
    parent::__construct();
    if (userdata('login') != 'laboran' && userdata('login') != 'aslab') {
      redirect();
    }
    $id_laboran = $this->db->get_where('users', array('idUser' => userdata('id')))->row()->id_laboran;
    $this->data = array(
      'profil'              => $this->m->profilLaboran($id_laboran)->row(),
      'jumlah_komplain'     => $this->m->hitungKomplain()->row()->komplain,
      'jumlah_pinjam_lab'   => $this->m->hitungPeminjamanLab()->row()->pinjamlab,
      'jumlah_pinjam_alat'  => $this->m->hitungPeminjamanAlat()->row()->pinjamalat,
      'laporan_asprak'      => $this->db->select('count(id_laporan_praktikum) jumlah')->from('laporan_praktikum')->where('status_laporan', '0')->get()->row()->jumlah,
      'honor_asprak'        => $this->db->select('count(id_honor) jumlah')->from('honor')->where('status', '1')->get()->row()->jumlah,
      'honor_aslab'         => $this->db->select('count(id_honor_aslab) jumlah')->from('honor_aslab')->where('status_honor', '2')->get()->row()->jumlah
    );
  }

  public function Honor()
  {
    $data           = $this->data;
    $data['title']  = 'Honor | SIM Laboratorium';
    if (userdata('login') == 'laboran') {
      $data['withdraw_asprak']  = $this->m->daftarPengambilanHonorAsprak()->result();
      $data['withdraw_aslab']   = $this->m->daftarPengambilanHonorAslab()->result();
      view('laboran/header', $data);
      view('laboran/honor', $data);
      view('laboran/footer');
    } elseif (userdata('login') == 'aslab') {
      $data['data'] = $this->m->daftarHonorAslab(userdata('id_aslab'))->result();
      view('aslab/header', $data);
      view('aslab/honor', $data);
      view('aslab/footer');
    }
  }

  public function HonorAslab()
  {
    set_rules('id_honor_aslab', 'ID Honor Aslab', 'required|trim');
    if (validation_run() == false) {
      redirect('Finance/Honor');
    } else {
      $id_honor_aslab = input('id_honor_aslab');
      $pilihan        = input('pilihan');
      $input          = array('status_honor' => '2', 'opsi_pengambilan' => $pilihan);
      $this->db->where('id_honor_aslab', $id_honor_aslab)->update('honor_aslab', $input);
      redirect('Finance/Honor');
    }
  }

  public function ApproveHonor()
  {
    $id = $_POST['id'];
    $cek_data = $this->db->where('substring(sha1(id_honor), 8, 7) = "' . $id . '"')->get('honor')->row();
    if ($cek_data) {
      $input  = array('status' => '2');
      $this->db->where('substring(sha1(id_honor), 8, 7) = "' . $id . '"')->update('honor', $input);
      echo 'true';
    }
  }
}
