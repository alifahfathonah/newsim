<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laboratory extends CI_Controller
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

  public function Practicum()
  {
    $data           = $this->data;
    $data['title']  = 'Practicum Laboratory | SIM Laboratorium';
    $data['data']   = $this->m->daftarLabPraktikum()->result();
    if (userdata('login') == 'laboran') {
      view('laboran/header', $data);
      view('laboran/practicum_laboratory', $data);
      view('laboran/footer');
    } elseif (userdata('login') == 'aslab') {
      view('aslab/header', $data);
      view('aslab/practicum_laboratory', $data);
      view('aslab/footer');
    }
  }

  public function ViewLaboratory()
  {
    $id                 = uri('3');
    $data               = $this->data;
    $periode            = $this->db->get('optionsim')->row()->tahunAjaran;
    $data['data']       = $this->m->detailLaboratorium($id)->row();
    $data['aslab']      = $this->m->pjAslab($id, $periode)->result();
    $data['inventaris'] = $this->m->daftarInventarisLab($id)->result();
    $data['title']      = $data['data']->namaLab . ' Laboratory | SIM Laboratorium';
    if (userdata('login') == 'laboran') {
      view('laboran/header', $data);
      view('laboran/view_laboratory', $data);
      view('laboran/footer');
    } elseif (userdata('login') == 'aslab') {
      view('aslab/header', $data);
      view('aslab/view_laboratory', $data);
      view('aslab/footer');
    }
  }

  public function SavePracticumLaboratory()
  {
    set_rules('nama_lab', 'Name Laboratory', 'required|trim');
    set_rules('pic_lab', 'PIC', 'required|trim');
    set_rules('kode_ruang', 'Room', 'required|trim');
    set_rules('lokasi_lab', 'Location', 'required|trim');
    if (validation_run() == false) {
      redirect('Laboratory/Practicum');
    } else {
      $nama_lab   = input('nama_lab');
      $pic_lab    = input('pic_lab');
      $kode_ruang = input('kode_ruang');
      $lokasi_lab = input('lokasi_lab');
      $input      = array(
        'namaLab'     => $nama_lab,
        'kodeRuang'   => $kode_ruang,
        'lokasiLab'   => $lokasi_lab,
        'pembinaLab'  => $pic_lab,
        'tipeLab'     => 'Practicum Lab'
      );
      $nama_file = rand(10, 99) . '-' . str_replace(' ', '_', $_FILES['foto_lab']['name']);
      $config['upload_path']    = 'assets/img/lab/';
      $config['allowed_types']  = 'gif|jpg|jpeg|png';
      $config['max_size']       = 1024 * 10;
      $config['file_name']      = $nama_file;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('foto_lab')) {
        $input['gambarLab']     = $config['upload_path'] . '' . $nama_file;
      }
      $this->m->insertData('laboratorium', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Practicum Laboratory Successfully Saved</div>');
      redirect('Laboratory/Practicum');
    }
  }

  public function EditPracticumLaboratory()
  {
    set_rules('nama_lab', 'Name Laboratory', 'required|trim');
    set_rules('pic_lab', 'PIC', 'required|trim');
    set_rules('kode_ruang', 'Room', 'required|trim');
    // set_rules('lokasi_lab', 'Location', 'required|trim');
    if (validation_run() == false) {
      redirect('Laboratory/Practicum');
    } else {
      $id_lab     = input('id_lab');
      $nama_lab   = input('nama_lab');
      $pic_lab    = input('pic_lab');
      $kode_ruang = input('kode_ruang');
      // $lokasi_lab = input('lokasi_lab');
      $input      = array(
        'namaLab'     => $nama_lab,
        'kodeRuang'   => $kode_ruang,
        // 'lokasiLab'   => $lokasi_lab,
        'pembinaLab'  => $pic_lab,
        'tipeLab'     => 'Practicum Lab'
      );
      $nama_file = rand(10, 99) . '-' . str_replace(' ', '_', $_FILES['foto_lab']['name']);
      $config['upload_path']    = 'assets/img/lab/';
      $config['allowed_types']  = 'gif|jpg|jpeg|png';
      $config['max_size']       = 1024 * 10;
      $config['file_name']      = $nama_file;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('foto_lab')) {
        $input['gambarLab']     = $config['upload_path'] . '' . $nama_file;
      }
      $this->m->updateData('laboratorium', $input, 'idLab', $id_lab);
      set_flashdata('msg', '<div class="alert alert-success msg">Practicum Laboratory Successfully Updated</div>');
      redirect('Laboratory/Practicum');
    }
  }

  public function Research()
  {
    $data           = $this->data;
    $data['title']  = 'Research Laboratory | SIM Laboratorium';
    $data['data']   = $this->m->daftarLabRiset()->result();
    if (userdata('login') == 'laboran') {
      view('laboran/header', $data);
      view('laboran/research_laboratory', $data);
      view('laboran/footer');
    } elseif (userdata('login') == 'aslab') {
      view('aslab/header', $data);
      view('aslab/research_laboratory', $data);
      view('aslab/footer');
    }
  }

  public function SaveResearchLaboratory()
  {
    set_rules('nama_lab', 'Name Laboratory', 'required|trim');
    set_rules('pic_lab', 'PIC', 'required|trim');
    set_rules('kode_ruang', 'Room', 'required|trim');
    set_rules('lokasi_lab', 'Location', 'required|trim');
    if (validation_run() == false) {
      redirect('Laboratory/Research');
    } else {
      $nama_lab   = input('nama_lab');
      $pic_lab    = input('pic_lab');
      $kode_ruang = input('kode_ruang');
      $lokasi_lab = input('lokasi_lab');
      $input      = array(
        'namaLab'     => $nama_lab,
        'kodeRuang'   => $kode_ruang,
        'lokasiLab'   => $lokasi_lab,
        'pembinaLab'  => $pic_lab,
        'tipeLab'     => 'Research Lab'
      );
      $nama_file = rand(10, 99) . '-' . str_replace(' ', '_', $_FILES['foto_lab']['name']);
      $config['upload_path']    = 'assets/img/lab/';
      $config['allowed_types']  = 'gif|jpg|jpeg|png';
      $config['max_size']       = 1024 * 10;
      $config['file_name']      = $nama_file;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('foto_lab')) {
        $input['gambarLab']     = $config['upload_path'] . '' . $nama_file;
      }
      $this->m->insertData('laboratorium', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Research Laboratory Successfully Saved</div>');
      redirect('Laboratory/Research');
    }
  }

  public function EditResearchLaboratory()
  {
    set_rules('nama_lab', 'Name Laboratory', 'required|trim');
    set_rules('pic_lab', 'PIC', 'required|trim');
    set_rules('kode_ruang', 'Room', 'required|trim');
    // set_rules('lokasi_lab', 'Location', 'required|trim');
    if (validation_run() == false) {
      redirect('Laboratory/Research');
    } else {
      $id_lab     = input('id_lab');
      $nama_lab   = input('nama_lab');
      $pic_lab    = input('pic_lab');
      $kode_ruang = input('kode_ruang');
      // $lokasi_lab = input('lokasi_lab');
      $input      = array(
        'namaLab'     => $nama_lab,
        'kodeRuang'   => $kode_ruang,
        // 'lokasiLab'   => $lokasi_lab,
        'pembinaLab'  => $pic_lab,
        'tipeLab'     => 'Research Lab'
      );
      $nama_file = rand(10, 99) . '-' . str_replace(' ', '_', $_FILES['foto_lab']['name']);
      $config['upload_path']    = 'assets/img/lab/';
      $config['allowed_types']  = 'gif|jpg|jpeg|png';
      $config['max_size']       = 1024 * 10;
      $config['file_name']      = $nama_file;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('foto_lab')) {
        $input['gambarLab']     = $config['upload_path'] . '' . $nama_file;
      }
      $this->m->updateData('laboratorium', $input, 'idLab', $id_lab);
      set_flashdata('msg', '<div class="alert alert-success msg">Research Laboratory Successfully Updated</div>');
      redirect('Laboratory/Research');
    }
  }

  public function DeleteLaboratory($id)
  {
    if (userdata('login') == 'laboran') {
      $this->m->deleteData('laboratorium', 'idLab', $id);
      redirect('Laboratory/Practicum');
    }
  }

  public function ajaxNamaLab()
  {
    $hasil  = '';
    $id     = input('id');
    $cek    = $this->db->get_where('laboratorium', array('idLab' => $id))->row();
    if ($cek == true) {
      $hasil .= $cek->namaLab;
    }
    echo $hasil;
  }
}
