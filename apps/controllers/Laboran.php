<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laboran extends CI_Controller
{

  var $data;

  public function __construct()
  {
    parent::__construct();
    if (userdata('login') != 'laboran') {
      redirect();
    }
    $this->db->query("update peminjamanlab set status = 'Selesai' where tglKembali < date_add(now(), interval -1 day)");
    $this->db->query("update peminjamanalat set status = 'Selesai' where tglKembali < date_add(now(), interval -1 day)");
    // $this->data = array(
    //   'komplain'        => 
    //   'peminjaman_alat'
    //   'peminjaman_lab'
    // );
  }

  public function Courses()
  {
    $data['title']  = 'Courses | SIM Laboratorium';
    $data['data']   = $this->laboran->daftarMataKuliah()->result();
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
      $this->laboran->insertData('matakuliah', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Courses Successfully Saved</div>');
      redirect('Laboran/Courses');
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
      $this->laboran->updateData('matakuliah', $input, 'id_mk', $id_mk);
      set_flashdata('msg', '<div class="alert alert-success msg">Courses Successfully Updated</div>');
      redirect('Laboran/Courses');
    }
  }

  public function DeleteCourses($id)
  {
    $this->laboran->deleteData('matakuliah', 'id_mk', $id);
    redirect('Laboran/Courses');
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

  public function LaboratoryAssistant()
  {
    $tahun1   = uri('3');
    $tahun2   = uri('4');
    $periode  = $this->db->get('optionsim')->row()->tahunAjaran;
    if ($tahun1 == null && $tahun2 == null) {
      $data['data'] = $this->laboran->daftarAslab($periode)->result();
    } else {
      $periode = $tahun1 . '/' . $tahun2;
      $data['data'] = $this->laboran->daftarAslab($periode)->result();
    }
    $data['pj']     = $this->laboran->daftarPJAslab()->result();
    $data['lab']   = $this->laboran->daftarLabPraktikum()->result();
    $data['title']  = 'Laboratory Assistant | SIM Laboratorium';
    view('laboran/header', $data);
    view('laboran/laboratory_assistant', $data);
    view('laboran/footer');
  }

  public function JournalAssistant()
  {
    $data['title']  = 'Journal Assistant | SIM Laboratorium';
    view('laboran/header', $data);
    view('laboran/journal_assistant', $data);
    view('laboran/footer');
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

  public function ProfileAssistant()
  {
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
      $data['kegiatan'] = $this->laboran->kegiatanAslabBulan($id_aslab, $where)->result();
    } else {
      $data['kegiatan'] = $this->laboran->kegiatanAslab($id_aslab)->result();
    }
    $data['profil'] = $this->laboran->detailAslab($id_aslab)->row();
    $data['pj']     = $this->laboran->detailPJAslab($id_aslab)->result();
    $data['lab']    = $this->laboran->daftarLabPraktikum()->result();
    $data['title']  = $data['profil']->namaLengkap . "'s Profile | SIM Laboratorium";
    view('laboran/header', $data);
    view('laboran/profile_assistant', $data);
    view('laboran/footer');
  }

  public function SaveLaboratoryAssistant()
  {
    set_rules('nama_aslab', 'Name', 'required|trim');
    set_rules('nim_aslab', 'NIM', 'required|trim');
    if (validation_run() == false) {
      redirect('Laboran/LaboratoryAssistant');
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
      $this->laboran->insertData('aslab', $input);
      $id_aslab = $this->db->get_where('aslab', $input)->row()->idAslab;
      for ($i = 0; $i < count($pj_lab); $i++) {
        $input  = array(
          'idLab'   => $pj_lab[$i],
          'idAslab' => $id_aslab
        );
        $this->laboran->insertData('asistenlab', $input);
      }
      set_flashdata('msg', '<div class="alert alert-success msg">Assistant Laboratory Successfully Saved</div>');
      redirect('Laboran/LaboratoryAssistant');
    }
  }

  public function EditLaboratoryAssistant()
  {
    set_rules('nama_aslab', 'Name', 'required|trim');
    set_rules('nim_aslab', 'NIM', 'required|trim');
    if (validation_run() == false) {
      redirect('Laboran/LaboratoryAssistant');
    } else {
      $id_aslab         = input('id_aslab');
      $nama_aslab       = input('nama_aslab');
      $nim_aslab        = input('nim_aslab');
      $telp_aslab       = input('telp_aslab');
      $spesialis_aslab  = input('spesialis_aslab');
      $rfid_aslab       = input('rfid_aslab');
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
      $this->laboran->updateData('aslab', $input, 'idAslab', $id_aslab);
      set_flashdata('msg', '<div class="alert alert-success msg">Assistant Laboratory Successfully Updated</div>');
      redirect('Laboran/LaboratoryAssistant');
    }
  }

  public function Schedule()
  {
    $data['title']  = 'Schedule | SIM Laboratorium';
    $data['id_lab'] = uri('3');
    $data['data']   = $this->laboran->daftarLabPraktikum()->result();
    view('laboran/header', $data);
    view('laboran/schedule', $data);
    view('laboran/footer');
  }

  public function ajaxJadwal()
  {
    $hasil  = array();
    $id_lab = uri('3');
    if ($id_lab) {
      $data = $this->laboran->jadwalPerLab($id_lab)->result();
    } else {
      $data = $this->laboran->jadwalLab()->result();
    }
    foreach ($data as $d) {
      $tmp['title']           = $d->title;
      $tmp['start']           = $d->start;
      $tmp['end']             = $d->end;
      $tmp['dow']             = $d->hari_ke;
      $tmp['backgroundColor'] = $d->color;
      array_push($hasil, $tmp);
    }
    echo json_encode($hasil);
  }

  public function uploadJadwalCSV()
  {
    view('Laboran/csv');
  }

  public function simpanJadwalCSV()
  {
    $file = $_FILES['file_csv']['tmp_name'];
    $ekstensi_file  = explode('.', $_FILES['file_csv']['name']);
    if (strtolower(end($ekstensi_file)) === 'csv' && $_FILES['file_csv']['size'] > 0) {
      $handle = fopen($file, 'r');
      $i = 0;
      while (($row = fgetcsv($handle, 2048))) {
        $i++;
        if ($i == 1) {
          continue;
        }
        if ($row[0] == 'SENIN') {
          $tanggal  = '2016-08-22';
          $hari     = 1;
        } elseif ($row[0] == 'SELASA') {
          $tanggal = '2016-08-23';
          $hari     = 2;
        } elseif ($row[0] == 'RABU') {
          $tanggal = '2016-08-24';
          $hari     = 3;
        } elseif ($row[0] == 'KAMIS') {
          $tanggal = '2016-08-25';
          $hari     = 4;
        } elseif ($row[0] == 'JUMAT') {
          $tanggal = '2016-08-26';
          $hari     = 5;
        } elseif ($row[0] == 'SABTU') {
          $tanggal = '2016-08-27';
          $hari     = 6;
        }
        $shift        = explode(' - ', $row[1]);
        $jam_masuk    = $shift[0];
        $jam_selesai  = $shift[1];
        //
        $matakuliah = $this->db->get('matakuliah')->result();
        foreach ($matakuliah as $m) {
          if ($m->kode_mk == $row[3]) {
            $id_mk  = $m->id_mk;
          }
        }
        $lab  = $this->db->get('laboratorium')->result();
        foreach ($lab as $l) {
          if ($l->kodeRuang == $row[2]) {
            $id_lab = $l->idLab;
          }
        }
        $kode_prodi = substr($row[4], 2, 2);
        $prodi      = $this->db->get('prodi')->result();
        foreach ($prodi as $p) {
          if ($p->kode_prodi == $kode_prodi) {
            $id_prodi = $p->id_prodi;
          }
        }
        //
        $input = array(
          'jam_masuk'   => $tanggal . ' ' . $jam_masuk,
          'jam_selesai' => $tanggal . ' ' . $jam_selesai,
          'kelas'       => $row[4],
          'kode_dosen'  => $row[5],
          'hari_ke'     => $hari,
          'id_mk'       => $id_mk,
          'id_lab'      => $id_lab,
          'id_prodi'    => $id_prodi
        );
        $this->db->insert('jadwal_lab', $input);
        echo '<hr>';
      }
      fclose($handle);
    }
  }
}
