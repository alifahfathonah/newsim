<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laboran extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (userdata('login') != 'laboran') {
      redirect();
    }
  }

  public function Dashboard()
  {
    $data['title']      = 'Dashboard | SIM Laboratorium';
    $data['komplain'] = $this->laboran->grafikKomplain()->result();
    $data['pengumuman'] = $this->laboran->daftarPengumuman()->result();
    view('laboran/header', $data);
    view('laboran/dashboard', $data);
    view('laboran/footer');
  }

  public function SaveAnnouncement()
  {
    set_rules('nama_pengumuman', 'Name Announcement', 'required|trim');
    set_rules('tanggal_pengumuman', 'Date', 'required|trim');
    set_rules('isi_pengumuman', 'Content of Announcement', 'required|trim');
    set_rules('tipe_pengumuman', 'Type Announcement', 'required|trim');
    if (validation_run() == false) {
      redirect('Laboran/Dashboard');
    } else {
      $nama_pengumuman    = input('nama_pengumuman');
      $tanggal_pengumuman = input('tanggal_pengumuman');
      $isi_pengumuman     = input('isi_pengumuman');
      $tipe_pengumuman    = input('tipe_pengumuman');
      $pisah_tanggal      = explode('/', $tanggal_pengumuman);
      $urut_tanggal       = array($pisah_tanggal[2], $pisah_tanggal[0], $pisah_tanggal[1]);
      $tanggal_pengumuman = implode('-', $urut_tanggal);
      $input              = array(
        'tglPengumuman'   => $tanggal_pengumuman,
        'namaPengumuman'  => $nama_pengumuman,
        'isiPengumuman'   => $isi_pengumuman,
        'tipePengumuman'  => $tipe_pengumuman
      );
      $this->laboran->insertData('pengumuman', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Announcement Successfully Publish</div>');
      redirect('Laboran/Dashboard');
    }
  }

  public function DeleteAnnouncement($id)
  {
    $this->laboran->deleteData('pengumuman', 'idPengumuman', $id);
    redirect('Laboran/Dashboard');
  }

  public function ajaxPengumuman()
  {
    $hasil  = '';
    $id     = input('id');
    $cek    = $this->db->get_where('pengumuman', array('idPengumuman' => $id))->row();
    if ($cek == true) {
      $hasil .= $cek->namaPengumuman;
    }
    echo $hasil;
  }
}
