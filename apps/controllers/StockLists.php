<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StockLists extends CI_Controller
{

  var $data;

  public function __construct()
  {
    parent::__construct();
    if (userdata('login') != 'laboran' && userdata('login') != 'aslab') {
      redirect();
    }
    if (userdata('login') == 'laboran') {
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
    } elseif (userdata('login') == 'aslab') {
      $this->data = array(
        'jumlah_komplain'     => $this->m->hitungKomplain()->row()->komplain,
        'jumlah_pinjam_lab'   => $this->m->hitungPeminjamanLab()->row()->pinjamlab,
        'jumlah_pinjam_alat'  => $this->m->hitungPeminjamanAlat()->row()->pinjamalat,
        'cek_aslab'           => $this->m->profilAslab(userdata('id_aslab'))->row()
      );
    }
  }

  public function index()
  {
    $data           = $this->data;
    $data['title']  = 'Stock Lists | SIM Laboratorium';
    $data['id_lab'] = uri('3');
    $data['lab']    = $this->m->daftarLaboratorium()->result();
    if (userdata('login') == 'laboran') {
      view('laboran/header', $data);
      view('laboran/stock_lists', $data);
      view('laboran/footer');
    } elseif (userdata('login') == 'aslab') {
      view('aslab/header', $data);
      view('aslab/stock_lists', $data);
      view('aslab/footer');
    }
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
      $data           = $this->data;
      $data['title']  = 'Add Stock List | SIM Laboratorium';
      $data['lab']    = $this->m->daftarLaboratorium()->result();
      if (userdata('login') == 'laboran') {
        view('laboran/header', $data);
        view('laboran/add_stock_list', $data);
        view('laboran/footer');
      } elseif (userdata('login') == 'aslab') {
        view('aslab/header', $data);
        view('aslab/add_stock_list', $data);
        view('aslab/footer');
      }
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
      $this->m->insertData('alatlab', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Stock List Successfully Saved</div>');
      redirect('StockLists');
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
      $data           = $this->data;
      $data['title']  = 'Edit Stock List | SIM Laboratorium';
      $data['lab']    = $this->m->daftarLaboratorium()->result();
      $data['data']   = $this->m->dataStockList($id)->row();
      if (userdata('login') == 'laboran') {
        view('laboran/header', $data);
        view('laboran/edit_stock_list', $data);
        view('laboran/footer');
      } elseif (userdata('login') == 'aslab') {
        view('aslab/header', $data);
        view('aslab/edit_stock_list', $data);
        view('aslab/footer');
      }
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
      $this->m->updateData('alatlab', $input, 'idAlat', $id_alat);
      set_flashdata('msg', '<div class="alert alert-success msg">Stock List Successfully Updated</div>');
      redirect('StockLists');
    }
  }

  public function DeleteStockList($id)
  {
    if (userdata('login') == 'laboran') {
      $this->m->deleteData('alatlab', 'idAlat', $id);
      redirect('StockLists');
    } else {
      redirect();
    }
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
      if (userdata('login') == 'laboran') {
        $hasil[]  = array(
          'no'            => $no++,
          'barcode'       => $d->barcode,
          'tools'         => $d->namaAlat,
          'lab'           => $d->namaLab,
          'qty'           => $d->jumlah,
          'condition'     => $d->kondisi,
          'spesification' => $d->spesifikasi,
          'action'        => '<center><a href="' . base_url('StockLists/EditStockList/' . substr(sha1($d->idAlat), 6, 4)) . '"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button></a><button class="btn btn-danger btn-sm" style="margin-left: 5px" onclick="hapus_inventaris(' . $d->idAlat . ')"><i class="fa fa-trash"></i></button></center>'
        );
      } elseif (userdata('login') == 'aslab') {
        $hasil[]  = array(
          'no'            => $no++,
          'barcode'       => $d->barcode,
          'tools'         => $d->namaAlat,
          'lab'           => $d->namaLab,
          'qty'           => $d->jumlah,
          'condition'     => $d->kondisi,
          'spesification' => $d->spesifikasi,
          'action'        => '<center><a href="' . base_url('StockLists/EditStockList/' . substr(sha1($d->idAlat), 6, 4)) . '"><button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button></a></center>'
        );
      }
    }
    $tampil = array('data' => $hasil);
    echo json_encode($tampil);
  }
}
