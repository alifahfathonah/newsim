<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

  var $data;

  public function __construct()
  {
    parent::__construct();
    if (userdata('login') != 'laboran' && userdata('login') != 'aslab') {
      redirect();
    }
    $this->data = array(
      'jumlah_komplain'     => $this->m->hitungKomplain()->row()->komplain,
      'jumlah_pinjam_lab'   => $this->m->hitungPeminjamanLab()->row()->pinjamlab,
      'jumlah_pinjam_alat'  => $this->m->hitungPeminjamanAlat()->row()->pinjamalat
    );
  }

  public function index()
  {
    $data                     = $this->data;
    $data['title']            = 'Dashboard | SIM Laboratorium';
    $data['komplain']         = $this->m->grafikKomplain()->result();
    $data['pengumuman']       = $this->m->daftarPengumuman()->result();
    $data['komplain_belum']   = $this->m->hitungKomplainBelumSelesai()->row()->komplain_belum;
    $data['komplain_selesai'] = $this->m->hitungKomplainSelesai()->row()->komplain_selesai;
    $data['lab_belum']        = $this->m->hitungPeminjamanLabBelumSelesai()->row()->lab_belum;
    $data['lab_selesai']      = $this->m->hitungPeminjamanLabSelesai()->row()->lab_selesai;
    $data['alat_belum']       = $this->m->hitungPeminjamanAlatBelumSelesai()->row()->alat_belum;
    $data['alat_selesai']     = $this->m->hitungPeminjamanAlatSelesai()->row()->alat_selesai;
    if (userdata('login') == 'laboran') {
      view('laboran/header', $data);
      view('laboran/dashboard', $data);
      view('laboran/footer');
    } elseif (userdata('login') == 'aslab') {
      view('aslab/header', $data);
      view('aslab/dashboard', $data);
      view('aslab/footer');
    }
  }

  public function SaveAnnouncement()
  {
    set_rules('nama_pengumuman', 'Name Announcement', 'required|trim');
    set_rules('tanggal_pengumuman', 'Date', 'required|trim');
    set_rules('isi_pengumuman', 'Content of Announcement', 'required|trim');
    set_rules('tipe_pengumuman', 'Type Announcement', 'required|trim');
    if (validation_run() == false) {
      redirect('Dashboard');
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
      $this->m->insertData('pengumuman', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Announcement Successfully Publish</div>');
      redirect('Dashboard');
    }
  }

  public function UpdateAnnouncement($id)
  {
    set_rules('nama_pengumuman', 'Name Announcement', 'required|trim');
    set_rules('tanggal_pengumuman', 'Date', 'required|trim');
    set_rules('isi_pengumuman', 'Content of Announcement', 'required|trim');
    set_rules('tipe_pengumuman', 'Type Announcement', 'required|trim');
    if (validation_run() == false) {
      redirect('Dashboard');
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
      $this->m->updateData('pengumuman', $input, 'idPengumuman', $id);
      set_flashdata('msg', '<div class="alert alert-success msg">Announcement Successfully Updated</div>');
      redirect('Dashboard');
    }
  }

  public function DeleteAnnouncement($id)
  {
    if (userdata('login') == 'laboran') {
      $this->m->deleteData('pengumuman', 'idPengumuman', $id);
      redirect('Dashboard');
    } else {
      redirect();
    }
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
