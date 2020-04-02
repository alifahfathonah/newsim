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

  public function UpdateAnnouncement($id)
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
      $this->laboran->updateData('pengumuman', $input, 'idPengumuman', $id);
      set_flashdata('msg', '<div class="alert alert-success msg">Announcement Successfully Updated</div>');
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

  public function StockLists()
  {
    $data['title']  = 'Stock Lists | SIM Laboratorium';
    $data['id_lab'] = uri('3');
    $data['lab']    = $this->laboran->daftarLaboratorium()->result();
    view('laboran/header', $data);
    view('laboran/stock_lists', $data);
    view('laboran/footer');
  }

  public function AddStockList()
  {
    set_rules('barcode_inventaris', 'Barcode', 'required|trim');
    set_rules('nama_inventaris', 'Name Stock List', 'required|trim');
    set_rules('lab_inventaris', 'Laboratorium', 'required|trim');
    set_rules('jumlah_inventaris', 'Qty', 'required|trim');
    set_rules('catatan_inventaris', 'Note', 'required|trim');
    set_rules('spesifikasi_inventaris', 'Specification', 'required|trim');
    set_rules('kondisi_inventaris', 'Condition', 'required|trim');
    if (validation_run() == false) {
      $data['title']  = 'Add Stock List | SIM Laboratorium';
      $data['lab']    = $this->laboran->daftarLaboratorium()->result();
      view('laboran/header', $data);
      view('laboran/add_stock_list', $data);
      view('laboran/footer');
    } else {
      $barcode_inventaris     = input('barcode_inventaris');
      $nama_inventaris        = input('nama_inventaris');
      $lab_inventaris         = input('lab_inventaris');
      $jumlah_inventaris      = input('jumlah_inventaris');
      $catatan_inventaris     = input('catatan_inventaris');
      $spesifikasi_inventaris = input('spesifikasi_inventaris');
      $kondisi_inventaris     = input('kondisi_inventaris');
      $input                  = array(
        'barcode'         => $barcode_inventaris,
        'namaAlat'        => $nama_inventaris,
        'jumlah'          => $jumlah_inventaris,
        'jumlahTersedia'  => $jumlah_inventaris,
        'kondisi'         => $kondisi_inventaris,
        'spesifikasi'     => $spesifikasi_inventaris,
        'catatan'         => $catatan_inventaris,
        'idLab'           => $lab_inventaris
      );
      $this->laboran->insertData('alatlab', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Stock List Successfully Saved</div>');
      redirect('Laboran/StockLists');
    }
  }

  public function EditStockList()
  {
    set_rules('barcode_inventaris', 'Barcode', 'required|trim');
    set_rules('nama_inventaris', 'Name Stock List', 'required|trim');
    set_rules('lab_inventaris', 'Laboratorium', 'required|trim');
    set_rules('jumlah_inventaris', 'Qty', 'required|trim');
    set_rules('catatan_inventaris', 'Note', 'required|trim');
    set_rules('spesifikasi_inventaris', 'Specification', 'required|trim');
    set_rules('kondisi_inventaris', 'Condition', 'required|trim');
    if (validation_run() == false) {
      $id             = uri('3');
      $data['title']  = 'Edit Stock List | SIM Laboratorium';
      $data['lab']    = $this->laboran->daftarLaboratorium()->result();
      $data['data']   = $this->laboran->dataStockList($id)->row();
      view('laboran/header', $data);
      view('laboran/edit_stock_list', $data);
      view('laboran/footer');
    } else {
      $id_alat                = input('id_alat');
      $barcode_inventaris     = input('barcode_inventaris');
      $nama_inventaris        = input('nama_inventaris');
      $lab_inventaris         = input('lab_inventaris');
      $jumlah_inventaris      = input('jumlah_inventaris');
      $catatan_inventaris     = input('catatan_inventaris');
      $spesifikasi_inventaris = input('spesifikasi_inventaris');
      $kondisi_inventaris     = input('kondisi_inventaris');
      $input                  = array(
        'barcode'         => $barcode_inventaris,
        'namaAlat'        => $nama_inventaris,
        'jumlah'          => $jumlah_inventaris,
        'jumlahTersedia'  => $jumlah_inventaris,
        'kondisi'         => $kondisi_inventaris,
        'spesifikasi'     => $spesifikasi_inventaris,
        'catatan'         => $catatan_inventaris,
        'idLab'           => $lab_inventaris
      );
      $this->laboran->updateData('alatlab', $input, 'idAlat', $id_alat);
      set_flashdata('msg', '<div class="alert alert-success msg">Stock List Successfully Updated</div>');
      redirect('Laboran/StockLists');
    }
  }

  public function DeleteStockList($id)
  {
    $this->laboran->deleteData('alatlab', 'idAlat', $id);
    redirect('Laboran/StockLists');
  }

  public function ajaxStockLists()
  {
    $hasil  = array();
    $tampil = array();
    $id_lab = uri('3');
    if ($id_lab == true) {
      $data = $this->db->select('alatlab.idAlat, alatlab.barcode, alatlab.namaAlat, laboratorium.namaLab, alatlab.jumlah, alatlab.kondisi, alatlab.spesifikasi')->from('alatlab')->join('laboratorium', 'alatlab.idLab = laboratorium.idLab')->where('substring(sha1(alatlab.idLab), 7, 4) = "' . $id_lab . '"')->order_by('alatlab.barcode')->get()->result();
    } else {
      $data = $this->db->select('alatlab.idAlat, alatlab.barcode, alatlab.namaAlat, laboratorium.namaLab, alatlab.jumlah, alatlab.kondisi, alatlab.spesifikasi')->from('alatlab')->join('laboratorium', 'alatlab.idLab = laboratorium.idLab')->order_by('alatlab.barcode')->get()->result();
    }
    $no     = 1;
    foreach ($data as $d) {
      $hasil[]  = array(
        'no'            => $no++,
        'barcode'       => $d->barcode,
        'tools'         => $d->namaAlat,
        'lab'           => $d->namaLab,
        'qty'           => $d->jumlah,
        'condition'     => $d->kondisi,
        'spesification' => $d->spesifikasi,
        'action'        => '<center><a href="' . base_url('Laboran/EditStockList/' . substr(sha1($d->idAlat), 6, 4)) . '"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button></a><button class="btn btn-danger btn-sm" style="margin-left: 5px" onclick="hapus_inventaris(' . $d->idAlat . ')"><i class="fa fa-trash"></i></button></center>'
      );
    }
    $tampil = array('data' => $hasil);
    echo json_encode($tampil);
  }

  public function ajaxNamaStockList()
  {
    $hasil  = '';
    $id     = input('id');
    $cek    = $this->db->get_where('alatlab', array('idAlat' => $id))->row();
    if ($cek == true) {
      $hasil .= $cek->namaAlat . ' (' . $cek->barcode . ')';
    }
    echo $hasil;
  }

  public function PracticumLaboratory()
  {
    $data['title']  = 'Practicum Laboratory | SIM Laboratorium';
    $data['data']   = $this->laboran->daftarLabPraktikum()->result();
    view('laboran/header', $data);
    view('laboran/practicum_laboratory', $data);
    view('laboran/footer');
  }

  public function SavePracticumLaboratory()
  {
    set_rules('nama_lab', 'Name Laboratory', 'required|trim');
    set_rules('pic_lab', 'PIC', 'required|trim');
    set_rules('kode_ruang', 'Room', 'required|trim');
    set_rules('lokasi_lab', 'Location', 'required|trim');
    if (validation_run() == false) {
      redirect('Laboran/PracticumLaboratory');
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
      $this->laboran->insertData('laboratorium', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Practicum Laboratory Successfully Saved</div>');
      redirect('Laboran/PracticumLaboratory');
    }
  }

  public function EditPracticumLaboratory()
  {
    set_rules('nama_lab', 'Name Laboratory', 'required|trim');
    set_rules('pic_lab', 'PIC', 'required|trim');
    set_rules('kode_ruang', 'Room', 'required|trim');
    // set_rules('lokasi_lab', 'Location', 'required|trim');
    if (validation_run() == false) {
      redirect('Laboran/PracticumLaboratory');
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
      $this->laboran->updateData('laboratorium', $input, 'idLab', $id_lab);
      set_flashdata('msg', '<div class="alert alert-success msg">Practicum Laboratory Successfully Updated</div>');
      redirect('Laboran/PracticumLaboratory');
    }
  }

  public function ViewLaboratory()
  {
    $id                 = uri('3');
    $periode            = $this->db->get('optionsim')->row()->tahunAjaran;
    $data['data']       = $this->laboran->detailLaboratorium($id)->row();
    $data['aslab']      = $this->laboran->pjAslab($id, $periode)->result();
    $data['inventaris'] = $this->laboran->daftarInventarisLab($id)->result();
    $data['title']      = $data['data']->namaLab . ' Laboratory | SIM Laboratorium';
    view('laboran/header', $data);
    view('laboran/view_laboratory', $data);
    view('laboran/footer');
  }

  public function DeleteLaboratory($id)
  {
    $this->laboran->deleteData('laboratorium', 'idLab', $id);
    redirect('Laboran/PracticumLaboratory');
  }

  public function ResearchLaboratory()
  {
    $data['title']  = 'Research Laboratory | SIM Laboratorium';
    $data['data']   = $this->laboran->daftarLabRiset()->result();
    view('laboran/header', $data);
    view('laboran/research_laboratory', $data);
    view('laboran/footer');
  }

  public function SaveResearchLaboratory()
  {
    set_rules('nama_lab', 'Name Laboratory', 'required|trim');
    set_rules('pic_lab', 'PIC', 'required|trim');
    set_rules('kode_ruang', 'Room', 'required|trim');
    set_rules('lokasi_lab', 'Location', 'required|trim');
    if (validation_run() == false) {
      redirect('Laboran/PracticumLaboratory');
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
      $this->laboran->insertData('laboratorium', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Research Laboratory Successfully Saved</div>');
      redirect('Laboran/ResearchLaboratory');
    }
  }

  public function EditResearchLaboratory()
  {
    set_rules('nama_lab', 'Name Laboratory', 'required|trim');
    set_rules('pic_lab', 'PIC', 'required|trim');
    set_rules('kode_ruang', 'Room', 'required|trim');
    // set_rules('lokasi_lab', 'Location', 'required|trim');
    if (validation_run() == false) {
      redirect('Laboran/PracticumLaboratory');
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
      $this->laboran->updateData('laboratorium', $input, 'idLab', $id_lab);
      set_flashdata('msg', '<div class="alert alert-success msg">Research Laboratory Successfully Updated</div>');
      redirect('Laboran/ResearchLaboratory');
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
