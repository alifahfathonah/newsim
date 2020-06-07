<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Practicum extends CI_Controller
{

  var $data;

  public function __construct()
  {
    parent::__construct();
    if (userdata('login') != 'laboran') {
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

  public function Courses()
  {
    $data           = $this->data;
    $data['title']  = 'Courses | SIM Laboratorium';
    $data['data']   = $this->m->daftarMataKuliah()->result();
    view('laboran/header', $data);
    view('laboran/courses', $data);
    view('laboran/footer');
  }

  public function SaveCourses()
  {
    set_rules('kode_mk', 'Courses Code', 'required|trim');
    set_rules('nama_mk', 'Courses Name', 'required|trim');
    set_rules('sks_mk', 'SKS', 'required|trim');
    if (validation_run() == false) {
      redirect('Laboran/Courses');
    } else {
      $kode_mk  = input('kode_mk');
      $nama_mk  = input('nama_mk');
      $sks_mk   = input('sks_mk');
      $input    = array(
        'kode_mk' => $kode_mk,
        'nama_mk' => $nama_mk,
        'sks'     => $sks_mk
      );
      $this->m->insertData('matakuliah', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Courses Successfully Saved</div>');
      redirect('Practicum/Courses');
    }
  }

  public function EditCourses()
  {
    set_rules('id_mk', 'ID MK', 'required|trim');
    set_rules('kode_mk', 'Courses Code', 'required|trim');
    set_rules('nama_mk', 'Courses Name', 'required|trim');
    set_rules('sks_mk', 'SKS', 'required|trim');
    if (validation_run() == false) {
      redirect('Laboran/Courses');
    } else {
      $id_mk    = input('id_mk');
      $kode_mk  = input('kode_mk');
      $nama_mk  = input('nama_mk');
      $sks_mk   = input('sks_mk');
      $input    = array(
        'kode_mk' => $kode_mk,
        'nama_mk' => $nama_mk,
        'sks'     => $sks_mk
      );
      $this->m->updateData('matakuliah', $input, 'id_mk', $id_mk);
      set_flashdata('msg', '<div class="alert alert-success msg">Courses Successfully Updated</div>');
      redirect('Practicum/Courses');
    }
  }

  public function DeleteCourses($id)
  {
    if (userdata('login') == 'laboran') {
      $this->m->deleteData('matakuliah', 'id_mk', $id);
      redirect('Practicum/Courses');
    } else {
      redirect();
    }
  }

  public function PracticumAssistant()
  {
    $data           = $this->data;
    $data['title']  = 'Practicum Assistant | SIM Laboratorium';
    $data['data']   = $this->m->daftarAsprak()->result();
    view('laboran/header', $data);
    view('laboran/practicum_assistant', $data);
    view('laboran/footer');
  }

  public function PresenceAsprak()
  {
    $data           = $this->data;
    $data['title']  = 'Presence Practicum Assistant | SIM Laboratorium';
    $data['data']   = $this->m->daftarAbsenAsprak()->result();
    view('laboran/header', $data);
    view('laboran/presence_asprak', $data);
    view('laboran/footer');
  }

  public function EditPresenceAsprak()
  {
    $id_presensi  = input('id_presensi');
    $modul        = input('modul');
    $input        = array('modul' => $modul);
    $screenshot               = rand(10, 99) . '-' . str_replace(' ', '_', $_FILES['screenshot']['name']);
    $config['upload_path']    = 'assets/screenshot/';
    $config['allowed_types']  = 'jpeg|jpg|png|gif';
    $config['max_size']       = 1024 * 100;
    $config['file_name']      = $screenshot;
    $this->load->library('upload', $config);
    if ($this->upload->do_upload('screenshot')) {
      $input['screenshot']     = $config['upload_path'] . '' . $screenshot;
    }
    if (!empty($_FILES['video'])) {
      $target_folder  = 'assets/video/';
      $nama_file      = rand(10, 99) . '-' . str_replace(' ', '_', $_FILES['video']['name']);
      $upload_file    = $target_folder . $nama_file;
      $input['video'] = $upload_file;
      move_uploaded_file($_FILES['video']['tmp_name'], $upload_file);
    }
    $this->m->updateData('presensi_asprak', $input, 'id_presensi_asprak', $id_presensi);
    set_flashdata('msg', '<div class="alert alert-success msg">Presence Practicum Assistant Successfully Updated</div>');
    redirect('Practicum/PresenceAsprak');
  }

  public function AddAsprakCSV()
  {
    if (empty($_FILES['file']['name'])) {
      redirect('Practicum/PracticumAssistant');
    } else {
      $file = $_FILES['file']['tmp_name'];
      $ekstensi_file  = explode('.', $_FILES['file']['name']);
      if (strtolower(end($ekstensi_file)) === 'csv' && $_FILES['file']['size'] > 0) {
        $handle = fopen($file, 'r');
        $i = 0;
        $sama = array();
        while (($row = fgetcsv($handle, 2048))) {
          $i++;
          if ($i == 1) {
            continue;
          }
          $input = array(
            'nim_asprak'  => $row[0],
            'nama_asprak' => $row[1]
          );
          $cek_data = $this->db->get_where('asprak', array('nim_asprak' => $row[0]))->row();
          if ($cek_data) {
            array_push($sama, $input);
          } else {
            $this->db->insert('asprak', $input);
          }
        }
        fclose($handle);
      }
      set_flashdata('msg', '<div class="alert alert-success msg">Practicum Assistant Successfully Saved</div>');
      redirect('Practicum/PracticumAssistant');
    }
  }

  public function ajaxMataKuliah()
  {
    $hasil  = '';
    $id     = input('id');
    $cek    = $this->db->get_where('matakuliah', array('id_mk' => $id))->row();
    if ($cek == true) {
      $hasil .= $cek->kode_mk . ' ' . $cek->nama_mk;
    }
    echo $hasil;
  }

  public function AsprakSchedule()
  {
    #
  }

  public function BAP()
  {
    $data           = $this->data;
    $data['title']  = 'BAP | SIM Laboratorium';
    $data['data']   = $this->m->daftarAbsenAsprak()->result();
    view('laboran/header', $data);
    view('laboran/list_bap', $data);
    view('laboran/footer');
  }

  public function ajaxBAP()
  {
    $hasil  = array();
    $tampil = array();
    $id_lab = uri('3');
    if ($id_lab == true) {
      $data = $this->db->select('alatlab.idAlat, alatlab.barcode, alatlab.namaAlat, laboratorium.namaLab, alatlab.jumlah, alatlab.kondisi, alatlab.spesifikasi')->from('alatlab')->join('laboratorium', 'alatlab.idLab = laboratorium.idLab')->where('substring(sha1(alatlab.idLab), 7, 4) = "' . $id_lab . '"')->order_by('alatlab.barcode')->get()->result();
    } else {
      $data = $this->db->select('asprak.nim_asprak, asprak.nama_asprak, matakuliah.kode_mk, matakuliah.nama_mk, periode.bulan, tahun_ajaran.ta, honor.file_bap, honor.approve_dosen')->from('honor')->join('daftar_mk', 'honor.id_daftar_mk = daftar_mk.id_daftar_mk')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->join('tahun_ajaran', 'daftar_mk.id_ta = tahun_ajaran.id_ta')->join('periode', 'honor.id_periode = periode.id_periode')->join('asprak', 'honor.nim_asprak = asprak.nim_asprak')->order_by('honor.id_honor', 'desc')->get()->result();
    }
    $no     = 1;
    foreach ($data as $d) {
      if ($d->approve_dosen == '0') {
        $approved = 'Not Yet Approved';
      } elseif ($d->approve_dosen == '1') {
        $approved = 'Approved';
      }
      $hasil[]  = array(
        'no'          => $no++,
        'nim_asprak'  => $d->nim_asprak,
        'nama_asprak' => $d->nama_asprak,
        'matakuliah'  => $d->kode_mk . ' - ' . $d->nama_mk,
        'approve'     => $approved,
        'periode'     => $d->bulan,
        'tahun'       => $d->ta,
        'action'      => '<center><a href="' . base_url($d->file_bap) . '" target="_blank"><button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button></a></center>'
      );
    }
    $tampil = array('data' => $hasil);
    echo json_encode($tampil);
  }

  public function Report()
  {
    set_rules('tahun_ajaran', 'Year', 'required|trim');
    set_rules('daftar_mk', 'Courses', 'required|trim');
    $data           = $this->data;
    $data['title']  = 'Practicum Report | SIM Laboratorium';
    $data['ta']     = $this->db->get_where('tahun_ajaran')->result();
    $data['mk']     = $this->db->get_where('matakuliah')->result();
    if (validation_run() == false) {
      $data['data']   = $this->m->daftarLaporanAsprak()->result();
    } else {
      $tahun_ajaran = input('tahun_ajaran');
      $daftar_mk    = input('daftar_mk');
      if ($daftar_mk != 'All') {
        $data['data'] = $this->m->daftarLaporanAsprak_Tahun_MK($tahun_ajaran, $daftar_mk)->result();
      } elseif ($daftar_mk == 'All') {
        $data['data'] = $this->m->daftarLaporanAsprak_Tahun($tahun_ajaran)->result();
      }
    }
    view('laboran/header', $data);
    view('laboran/practicum_report', $data);
    view('laboran/footer');
  }

  public function EditReport()
  {
    set_rules('id_laporan_praktikum', 'ID Practicum Report', 'required|trim');
    if (validation_run() == false) {
      redirect('Practicum/Report');
    } else {
      $id_laporan_praktikum = input('id_laporan_praktikum');
      $catatan_revisi       = input('catatan_revisi');
      $status               = input('status');
      $input  = array(
        'catatan_revisi'  => $catatan_revisi,
        'status_laporan'  => $status
      );
      $this->m->updateData('laporan_praktikum', $input, 'id_laporan_praktikum', $id_laporan_praktikum);
      set_flashdata('msg', '<div class="alert alert-success msg">Data Successfully Saved</div>');
      redirect('Practicum/Report');
    }
  }
}
