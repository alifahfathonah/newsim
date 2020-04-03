<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaboratoryAssistant extends CI_Controller
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
    $data     = $this->data;
    $tahun1   = uri('3');
    $tahun2   = uri('4');
    $periode  = $this->db->get('optionsim')->row()->tahunAjaran;
    if ($tahun1 == null && $tahun2 == null) {
      $data['data'] = $this->m->daftarAslab($periode)->result();
    } else {
      $periode = $tahun1 . '/' . $tahun2;
      $data['data'] = $this->m->daftarAslab($periode)->result();
    }
    $data['pj']     = $this->m->daftarPJAslab()->result();
    $data['lab']   = $this->m->daftarLabPraktikum()->result();
    $data['title']  = 'Laboratory Assistant | SIM Laboratorium';
    if (userdata('login') == 'laboran') {
      view('laboran/header', $data);
      view('laboran/laboratory_assistant', $data);
      view('laboran/footer');
    } elseif (userdata('login') == 'aslab') {
      view('aslab/header', $data);
      view('aslab/laboratory_assistant', $data);
      view('aslab/footer');
    }
  }

  public function ProfileAssistant()
  {
    $data           = $this->data;
    $id_aslab       = uri('3');
    $bulan          = uri('4');
    $periode_aslab  = $this->db->where('substring(sha1(idAslab), 7, 4) = "' . $id_aslab . '"')->get('aslab')->row()->tahunAjaran;
    $tahun          = explode('/', $periode_aslab);
    if ($bulan) {
      if ($bulan == 'January') {
        $where  = 'aslabMasuk >= "' . $tahun[0] . '-12-21" and aslabMasuk <= "' . $tahun[1] . '-01-21"';
      } elseif ($bulan == 'February') {
        $where  = 'aslabMasuk >= "' . $tahun[1] . '-01-21" and aslabMasuk <= "' . $tahun[1] . '-02-21"';
      } elseif ($bulan == 'March') {
        $where  = 'aslabMasuk >= "' . $tahun[1] . '-02-21" and aslabMasuk <= "' . $tahun[1] . '-03-21"';
      } elseif ($bulan == 'April') {
        $where  = 'aslabMasuk >= "' . $tahun[1] . '-03-21" and aslabMasuk <= "' . $tahun[1] . '-04-21"';
      } elseif ($bulan == 'May') {
        $where  = 'aslabMasuk >= "' . $tahun[1] . '-04-21" and aslabMasuk <= "' . $tahun[1] . '-05-21"';
      } elseif ($bulan == 'June') {
        $where  = 'aslabMasuk >= "' . $tahun[1] . '-05-21" and aslabMasuk <= "' . $tahun[1] . '-06-21"';
      } elseif ($bulan == 'July') {
        $where  = 'aslabMasuk >= "' . $tahun[1] . '-06-21" and aslabMasuk <= "' . $tahun[1] . '-07-21"';
      } elseif ($bulan == 'August') {
        $where  = 'aslabMasuk >= "' . $tahun[0] . '-07-21" and aslabMasuk <= "' . $tahun[0] . '-08-21"';
      } elseif ($bulan == 'September') {
        $where  = 'aslabMasuk >= "' . $tahun[0] . '-08-21" and aslabMasuk <= "' . $tahun[0] . '-09-21"';
      } elseif ($bulan == 'October') {
        $where  = 'aslabMasuk >= "' . $tahun[0] . '-09-21" and aslabMasuk <= "' . $tahun[0] . '-10-21"';
      } elseif ($bulan == 'November') {
        $where  = 'aslabMasuk >= "' . $tahun[0] . '-10-21" and aslabMasuk <= "' . $tahun[0] . '-11-21"';
      } elseif ($bulan == 'December') {
        $where  = 'aslabMasuk >= "' . $tahun[0] . '-11-21" and aslabMasuk <= "' . $tahun[0] . '-12-21"';
      }
      $data['kegiatan'] = $this->m->kegiatanAslabBulan($id_aslab, $where)->result();
    } else {
      $data['kegiatan'] = $this->m->kegiatanAslab($id_aslab)->result();
    }
    $data['profil'] = $this->m->detailAslab($id_aslab)->row();
    $data['pj']     = $this->m->detailPJAslab($id_aslab)->result();
    $data['lab']    = $this->m->daftarLabPraktikum()->result();
    $data['title']  = $data['profil']->namaLengkap . "'s Profile | SIM Laboratorium";
    if (userdata('login') == 'laboran') {
      view('laboran/header', $data);
      view('laboran/profile_assistant', $data);
      view('laboran/footer');
    } elseif (userdata('login') == 'aslab') {
      view('aslab/header', $data);
      view('aslab/profile_assistant', $data);
      view('aslab/footer');
    }
  }

  public function SaveLaboratoryAssistant()
  {
    set_rules('nama_aslab', 'Name', 'required|trim');
    set_rules('nim_aslab', 'NIM', 'required|trim');
    if (validation_run() == false) {
      redirect('LaboratoryAssistant');
    } else {
      $nama_aslab       = input('nama_aslab');
      $nim_aslab        = input('nim_aslab');
      $telp_aslab       = input('telp_aslab');
      $spesialis_aslab  = input('spesialis_aslab');
      $rfid_aslab       = input('rfid_aslab');
      $pj_lab           = input('pj_lab');
      $periode          = $this->db->get('optionsim')->row()->tahunAjaran;
      $input            = array(
        'nim'             => $nim_aslab,
        'namaLengkap'     => $nama_aslab,
        'noTelp'          => $telp_aslab,
        'spesialisAslab'  => $spesialis_aslab,
        'tahunAjaran'     => $periode,
        'rfid'            => $rfid_aslab
      );
      $nama_file = rand(10, 99) . '-' . str_replace(' ', '_', $_FILES['foto_aslab']['name']);
      $config['upload_path']    = 'assets/img/aslab/';
      $config['allowed_types']  = 'gif|jpg|jpeg|png';
      $config['max_size']       = 1024 * 10;
      $config['file_name']      = $nama_file;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('foto_aslab')) {
        $input['fotoAslab'] = $config['upload_path'] . '' . $nama_file;
      }
      $this->m->insertData('aslab', $input);
      $id_aslab = $this->db->get_where('aslab', $input)->row()->idAslab;
      for ($i = 0; $i < count($pj_lab); $i++) {
        $input  = array(
          'idLab'   => $pj_lab[$i],
          'idAslab' => $id_aslab
        );
        $this->m->insertData('asistenlab', $input);
      }
      set_flashdata('msg', '<div class="alert alert-success msg">Assistant Laboratory Successfully Saved</div>');
      redirect('LaboratoryAssistant');
    }
  }

  public function EditLaboratoryAssistant()
  {
    set_rules('nama_aslab', 'Name', 'required|trim');
    set_rules('nim_aslab', 'NIM', 'required|trim');
    if (validation_run() == false) {
      redirect('LaboratoryAssistant');
    } else {
      $id_aslab         = input('id_aslab');
      $nama_aslab       = input('nama_aslab');
      $nim_aslab        = input('nim_aslab');
      $telp_aslab       = input('telp_aslab');
      $spesialis_aslab  = input('spesialis_aslab');
      $rfid_aslab       = input('rfid_aslab');
      $pj_lab           = input('pj_lab');
      $aslab_bulan      = input('aslab_bulan');
      $input            = array(
        'nim'             => $nim_aslab,
        'namaLengkap'     => $nama_aslab,
        'noTelp'          => $telp_aslab,
        'spesialisAslab'  => $spesialis_aslab,
        'rfid'            => $rfid_aslab,
        'aslabOfTheMonth' => $aslab_bulan
      );
      $nama_file = rand(10, 99) . '-' . str_replace(' ', '_', $_FILES['foto_aslab']['name']);
      $config['upload_path']    = 'assets/img/aslab/';
      $config['allowed_types']  = 'gif|jpg|jpeg|png';
      $config['max_size']       = 1024 * 10;
      $config['file_name']      = $nama_file;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('foto_aslab')) {
        $input['fotoAslab'] = $config['upload_path'] . '' . $nama_file;
      }
      $this->m->updateData('aslab', $input, 'idAslab', $id_aslab);
      $this->m->deleteData('asistenlab', 'idAslab', $id_aslab);
      for ($i = 0; $i < count($pj_lab); $i++) {
        $input  = array(
          'idLab'   => $pj_lab[$i],
          'idAslab' => $id_aslab
        );
        $this->m->insertData('asistenlab', $input);
      }
      set_flashdata('msg', '<div class="alert alert-success msg">Assistant Laboratory Successfully Updated</div>');
      redirect('LaboratoryAssistant');
    }
  }

  public function JournalAssistant()
  {
    $data           = $this->data;
    $data['title']  = 'Journal Assistant | SIM Laboratorium';
    if (userdata('login') == 'laboran') {
      view('laboran/header', $data);
      view('laboran/journal_assistant', $data);
      view('laboran/footer');
    } else {
      redirect();
    }
  }

  public function ajaxKegiatanAslab()
  {
    $hasil  = array();
    $tampil = array();
    $periode  = $this->db->get('optionsim')->row()->tahunAjaran;
    $data     = $this->db->select('date_format(jurnalaslab.aslabMasuk, "%Y-%m-%d") hari, date_format(jurnalaslab.aslabMasuk, "%H:%i") masuk, if (jurnalaslab.aslabKeluar, date_format(jurnalaslab.aslabKeluar, "%H:%i"), "-") keluar, jurnalaslab.jurnal, aslab.namaLengkap')->from('jurnalaslab')->join('aslab', 'jurnalaslab.idAslab = aslab.idAslab')->where('aslab.tahunAjaran', $periode)->order_by('jurnalaslab.aslabMasuk', 'desc')->get()->result();
    $no     = 1;
    foreach ($data as $d) {
      $hasil[]  = array(
        'no'        => $no++,
        'tanggal'   => tanggalInggris($d->hari),
        'nama'      => $d->namaLengkap,
        'aktivitas' => $d->jurnal
      );
    }
    $tampil = array('data' => $hasil);
    echo json_encode($tampil);
  }
}
