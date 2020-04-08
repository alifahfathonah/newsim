<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Complaint extends CI_Controller
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
    $data           = $this->data;
    $data['title']  = 'Complaint | SIM Laboratorium';
    $data['data']   = $this->m->daftarKomplain()->result();
    if (userdata('login') == 'laboran') {
      view('laboran/header', $data);
      view('laboran/complaint', $data);
      view('laboran/footer');
    } elseif (userdata('login') == 'aslab') {
      view('aslab/header', $data);
      view('aslab/complaint', $data);
      view('aslab/footer');
    }
  }

  public function AddComplaint()
  {
    set_rules('tgl_komplain', 'Date', 'required|trim');
    set_rules('informer_komplain', 'Informer', 'required|trim');
    if (validation_run() == false) {
      if (userdata('login') == 'laboran') {
        $data           = $this->data;
        $data['title']  = 'Add Complaint | SIM Laboratorium';
        $data['lab']    = $this->m->daftarLaboratorium()->result();
        view('laboran/header', $data);
        view('laboran/add_complaint', $data);
        view('laboran/footer');
      } elseif (userdata('login') == 'aslab') {
        $data           = $this->data;
        $data['title']  = 'Add Complaint | SIM Laboratorium';
        $data['lab']    = $this->m->daftarLaboratorium()->result();
        view('aslab/header', $data);
        view('aslab/add_complaint', $data);
        view('aslab/footer');
      } else {
        redirect();
      }
    } else {
      $tgl_komplain       = input('tgl_komplain');
      $informer_komplain  = input('informer_komplain');
      $jenis_informan     = input('jenis_informan');
      $lab_komplain       = input('lab_komplain');
      $nama_alat          = input('nama_alat');
      $solusi_komplain    = input('solusi_komplain');
      $diselesaikan_oleh  = input('diselesaikan_oleh');
      $komplain           = input('komplain');
      $tmp                = explode('/', $tgl_komplain);
      $urut_tanggal       = array($tmp[2], $tmp[0], $tmp[1]);
      $tgl_komplain       = implode('-', $urut_tanggal);
      $input              = array(
        'namaAlat'        => $nama_alat,
        'tglKomplain'     => $tgl_komplain,
        'namaInforman'    => $informer_komplain,
        'jenisInforman'   => $jenis_informan,
        'catatanKomplain' => $komplain,
        'idLab'           => $lab_komplain,
        'statusKomplain'  => 0
      );
      $this->m->insertData('komplain', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Complaint Successfully Saved</div>');
      redirect('Complaint');
    }
  }

  public function EditComplaint($id)
  {
    set_rules('tgl_komplain', 'Date', 'required|trim');
    set_rules('informer_komplain', 'Informer', 'required|trim');
    if (validation_run() == false) {
      if (userdata('login') == 'laboran') {
        $data           = $this->data;
        $data['title']  = 'Edit Complaint | SIM Laboratorium';
        $data['lab']    = $this->m->daftarLaboratorium()->result();
        $data['data']   = $this->m->detailKomplain($id)->row();
        view('laboran/header', $data);
        view('laboran/edit_complaint', $data);
        view('laboran/footer');
      } elseif (userdata('login') == 'aslab') {
        $data           = $this->data;
        $data['title']  = 'Edit Complaint | SIM Laboratorium';
        $data['lab']    = $this->m->daftarLaboratorium()->result();
        $data['data']   = $this->m->detailKomplain($id)->row();
        view('aslab/header', $data);
        view('aslab/edit_complaint', $data);
        view('aslab/footer');
      } else {
        redirect();
      }
    } else {
      $tgl_komplain       = input('tgl_komplain');
      $tgl_diatasi        = input('tgl_diatasi');
      $informer_komplain  = input('informer_komplain');
      $jenis_informan     = input('jenis_informan');
      $lab_komplain       = input('lab_komplain');
      $nama_alat          = input('nama_alat');
      $solusi_komplain    = input('solusi_komplain');
      $diselesaikan_oleh  = input('diselesaikan_oleh');
      $komplain           = input('komplain');
      $tmp                = explode('/', $tgl_komplain);
      $urut_tanggal       = array($tmp[2], $tmp[0], $tmp[1]);
      $tgl_komplain       = implode('-', $urut_tanggal);
      $input              = array(
        'namaAlat'        => $nama_alat,
        'tglKomplain'     => $tgl_komplain,
        'namaInforman'    => $informer_komplain,
        'jenisInforman'   => $jenis_informan,
        'catatanKomplain' => $komplain,
        'idLab'           => $lab_komplain,
        'solusi'          => $solusi_komplain,
        'diperbaikiOleh'  => $diselesaikan_oleh
      );
      if ($tgl_diatasi != null) {
        $tmp                      = explode('/', $tgl_diatasi);
        $urut_tanggal             = array($tmp[2], $tmp[0], $tmp[1]);
        $tgl_diatasi              = implode('-', $urut_tanggal);
        $input['tglDiatasi']      = $tgl_diatasi;
        $input['statusKomplain']  = 1;
      }
      $this->db->where('substring(sha1(idKomplain), 7, 4) = "' . $id . '"')->update('komplain', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Complaint Successfully Updated</div>');
      redirect('Complaint');
    }
  }
}
