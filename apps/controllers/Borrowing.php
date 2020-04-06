<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Borrowing extends CI_Controller
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

  public function Equipment()
  {
    $data           = $this->data;
    $data['title']  = 'Borrowing Equipment | SIM Laboratorium';
    $data['data']   = $this->m->peminjamanAlat()->result();
    if (userdata('login') == 'laboran') {
      view('laboran/header', $data);
      view('laboran/borrowing_equipment', $data);
      view('laboran/footer');
    } elseif (userdata('login') == 'aslab') {
      view('aslab/header', $data);
      view('aslab/schedule', $data);
      view('aslab/footer');
    }
  }

  public function AddBorrowingEquipment()
  {
    set_rules('nama_peminjam', 'Borrower', 'required|trim');
    set_rules('ni_peminjam', 'NIP/NIM', 'required|trim');
    set_rules('notelp_peminjam', 'Phone Number', 'required|trim');
    set_rules('lab_peminjam', 'Laboratory', 'required|trim');
    set_rules('tgl_pinjam', 'Borrow Date', 'required|trim');
    set_rules('tgl_kembali', 'Return Date', 'required|trim');
    set_rules('alat_peminjam', 'Equipment', 'required|trim');
    set_rules('jumlah_pinjam', 'Qty', 'required|trim');
    set_rules('status_peminjaman', 'Status', 'required|trim');
    set_rules('alasan_peminjam', 'Reason', 'required|trim');
    set_rules('catatan_peminjam', 'Notes', 'required|trim');
    if (validation_run() == false) {
      if (userdata('login') == 'laboran') {
        $data           = $this->data;
        $data['title']  = 'Add Borrowing Equipment | SIM Laboratorium';
        $data['data']   = $this->m->peminjamanAlat()->result();
        $data['lab']    = $this->m->daftarLaboratorium()->result();
        $data['alat']   = $this->m->daftarInventaris()->result();
        view('laboran/header', $data);
        view('laboran/add_borrowing_equipment', $data);
        view('laboran/footer');
      } else {
        redirect();
      }
    } else {
      $nama_peminjam      = input('nama_peminjam');
      $ni_peminjam        = input('ni_peminjam');
      $notelp_peminjam    = input('notelp_peminjam');
      $lab_peminjam       = input('lab_peminjam');
      $tgl_pinjam         = input('tgl_pinjam');
      $tgl_kembali        = input('tgl_kembali');
      $alat_peminjam      = input('alat_peminjam');
      $jumlah_pinjam      = input('jumlah_pinjam');
      $status_peminjaman  = input('status_peminjaman');
      $alasan_peminjam    = input('alasan_peminjam');
      $catatan_peminjam   = input('catatan_peminjam');
      $tmp                = explode('/', $tgl_pinjam);
      $urut_tanggal       = array($tmp[2], $tmp[0], $tmp[1]);
      $tgl_pinjam         = implode('-', $urut_tanggal);
      $tmp                = explode('/', $tgl_kembali);
      $urut_tanggal       = array($tmp[2], $tmp[0], $tmp[1]);
      $tgl_kembali        = implode('-', $urut_tanggal);
      $input              = array(
        'namaPeminjam'  => $nama_peminjam,
        'nipnik'        => $ni_peminjam,
        'noTelp'        => $notelp_peminjam,
        'alasan'        => $alasan_peminjam,
        'tglPinjam'     => $tgl_pinjam,
        'tglKembali'    => $tgl_kembali,
        'jumlah'        => $jumlah_pinjam,
        'catatan'       => $catatan_peminjam,
        'status'        => $status_peminjaman,
        'idAlat'        => $alat_peminjam,
        'idLab'         => $lab_peminjam
      );
      $this->m->insertData('peminjamanalat', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Borrowing Equipment Successfully Saved</div>');
      redirect('Borrowing/Equipment');
    }
  }

  public function EditBorrowingEquipment($id)
  {
    set_rules('nama_peminjam', 'Borrower', 'required|trim');
    set_rules('ni_peminjam', 'NIP/NIM', 'required|trim');
    set_rules('notelp_peminjam', 'Phone Number', 'required|trim');
    set_rules('lab_peminjam', 'Laboratory', 'required|trim');
    set_rules('tgl_pinjam', 'Borrow Date', 'required|trim');
    set_rules('tgl_kembali', 'Return Date', 'required|trim');
    set_rules('alat_peminjam', 'Equipment', 'required|trim');
    set_rules('jumlah_pinjam', 'Qty', 'required|trim');
    set_rules('status_peminjaman', 'Status', 'required|trim');
    set_rules('alasan_peminjam', 'Reason', 'required|trim');
    set_rules('catatan_peminjam', 'Notes', 'required|trim');
    if (validation_run() == false) {
      if (userdata('login') == 'laboran') {
        $data           = $this->data;
        $data['title']  = 'Edit Borrowing Equipment | SIM Laboratorium';
        $data['data']   = $this->m->peminjamanAlat()->result();
        $data['lab']    = $this->m->daftarLaboratorium()->result();
        $data['alat']   = $this->m->daftarInventaris()->result();
        $data['detail'] = $this->m->detailPeminjamanAlat(uri('3'))->row();
        view('laboran/header', $data);
        view('laboran/edit_borrowing_equipment', $data);
        view('laboran/footer');
      } else {
        redirect();
      }
    } else {
      $nama_peminjam      = input('nama_peminjam');
      $ni_peminjam        = input('ni_peminjam');
      $notelp_peminjam    = input('notelp_peminjam');
      $lab_peminjam       = input('lab_peminjam');
      $tgl_pinjam         = input('tgl_pinjam');
      $tgl_kembali        = input('tgl_kembali');
      $alat_peminjam      = input('alat_peminjam');
      $jumlah_pinjam      = input('jumlah_pinjam');
      $status_peminjaman  = input('status_peminjaman');
      $alasan_peminjam    = input('alasan_peminjam');
      $catatan_peminjam   = input('catatan_peminjam');
      $tmp                = explode('/', $tgl_pinjam);
      $urut_tanggal       = array($tmp[2], $tmp[0], $tmp[1]);
      $tgl_pinjam         = implode('-', $urut_tanggal);
      $tmp                = explode('/', $tgl_kembali);
      $urut_tanggal       = array($tmp[2], $tmp[0], $tmp[1]);
      $tgl_kembali        = implode('-', $urut_tanggal);
      $input              = array(
        'namaPeminjam'  => $nama_peminjam,
        'nipnik'        => $ni_peminjam,
        'noTelp'        => $notelp_peminjam,
        'alasan'        => $alasan_peminjam,
        'tglPinjam'     => $tgl_pinjam,
        'tglKembali'    => $tgl_kembali,
        'jumlah'        => $jumlah_pinjam,
        'catatan'       => $catatan_peminjam,
        'status'        => $status_peminjaman,
        'idAlat'        => $alat_peminjam,
        'idLab'         => $lab_peminjam
      );
      $this->db->where('substring(sha1(idPinjamAlat), 7, 4) = "' . $id . '"')->update('peminjamanalat', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Borrowing Equipment Successfully Updated</div>');
      redirect('Borrowing/Equipment');
    }
  }

  public function Laboratory()
  {
    $data           = $this->data;
    $data['title']  = 'Borrowing Laboratory | SIM Laboratorium';
    $data['data']   = $this->m->peminjamanLab()->result();
    if (userdata('login') == 'laboran') {
      view('laboran/header', $data);
      view('laboran/borrowing_laboratory', $data);
      view('laboran/footer');
    } elseif (userdata('login') == 'aslab') {
      view('aslab/header', $data);
      view('aslab/schedule', $data);
      view('aslab/footer');
    }
  }

  public function AddBorrowingLaboratory()
  {
    set_rules('nama_peminjam', 'Borrower', 'required|trim');
    set_rules('ni_peminjam', 'NIP/NIM', 'required|trim');
    set_rules('notelp_peminjam', 'Phone Number', 'required|trim');
    set_rules('lab_peminjam', 'Laboratory', 'required|trim');
    set_rules('tgl_pinjam', 'Borrow Date', 'required|trim');
    set_rules('tgl_kembali', 'Return Date', 'required|trim');
    set_rules('status_peminjaman', 'Status', 'required|trim');
    set_rules('alasan_peminjam', 'Reason', 'required|trim');
    set_rules('catatan_peminjam', 'Notes', 'required|trim');
    if (validation_run() == false) {
      if (userdata('login') == 'laboran') {
        $data           = $this->data;
        $data['title']  = 'Add Borrowing Laboratory | SIM Laboratorium';
        $data['data']   = $this->m->peminjamanAlat()->result();
        $data['lab']    = $this->m->daftarLaboratorium()->result();
        $data['alat']   = $this->m->daftarInventaris()->result();
        view('laboran/header', $data);
        view('laboran/add_borrowing_laboratory', $data);
        view('laboran/footer');
      } else {
        redirect();
      }
    } else {
      $nama_peminjam      = input('nama_peminjam');
      $ni_peminjam        = input('ni_peminjam');
      $notelp_peminjam    = input('notelp_peminjam');
      $lab_peminjam       = input('lab_peminjam');
      $tgl_pinjam         = input('tgl_pinjam');
      $tgl_kembali        = input('tgl_kembali');
      $status_peminjaman  = input('status_peminjaman');
      $alasan_peminjam    = input('alasan_peminjam');
      $catatan_peminjam   = input('catatan_peminjam');
      $tmp                = explode('/', $tgl_pinjam);
      $urut_tanggal       = array($tmp[2], $tmp[0], $tmp[1]);
      $tgl_pinjam         = implode('-', $urut_tanggal);
      $tmp                = explode('/', $tgl_kembali);
      $urut_tanggal       = array($tmp[2], $tmp[0], $tmp[1]);
      $tgl_kembali        = implode('-', $urut_tanggal);
      $input              = array(
        'namaPeminjam'  => $nama_peminjam,
        'nipnik'        => $ni_peminjam,
        'noTelp'        => $notelp_peminjam,
        'alasan'        => $alasan_peminjam,
        'tglPinjam'     => $tgl_pinjam,
        'tglKembali'    => $tgl_kembali,
        'catatan'       => $catatan_peminjam,
        'status'        => $status_peminjaman,
        'idLab'         => $lab_peminjam
      );
      $this->m->insertData('peminjamanlab', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Borrowing Laboratory Successfully Saved</div>');
      redirect('Borrowing/Laboratory');
    }
  }

  public function EditBorrowingLaboratory($id)
  {
    set_rules('nama_peminjam', 'Borrower', 'required|trim');
    set_rules('ni_peminjam', 'NIP/NIM', 'required|trim');
    set_rules('notelp_peminjam', 'Phone Number', 'required|trim');
    set_rules('lab_peminjam', 'Laboratory', 'required|trim');
    set_rules('tgl_pinjam', 'Borrow Date', 'required|trim');
    set_rules('tgl_kembali', 'Return Date', 'required|trim');
    set_rules('status_peminjaman', 'Status', 'required|trim');
    set_rules('alasan_peminjam', 'Reason', 'required|trim');
    set_rules('catatan_peminjam', 'Notes', 'required|trim');
    if (validation_run() == false) {
      if (userdata('login') == 'laboran') {
        $data           = $this->data;
        $data['title']  = 'Edit Borrowing Laboratory | SIM Laboratorium';
        $data['lab']    = $this->m->daftarLaboratorium()->result();
        $data['detail'] = $this->m->detailPeminjamanLab(uri('3'))->row();
        view('laboran/header', $data);
        view('laboran/edit_borrowing_laboratory', $data);
        view('laboran/footer');
      } else {
        redirect();
      }
    } else {
      $nama_peminjam      = input('nama_peminjam');
      $ni_peminjam        = input('ni_peminjam');
      $notelp_peminjam    = input('notelp_peminjam');
      $lab_peminjam       = input('lab_peminjam');
      $tgl_pinjam         = input('tgl_pinjam');
      $tgl_kembali        = input('tgl_kembali');
      $status_peminjaman  = input('status_peminjaman');
      $alasan_peminjam    = input('alasan_peminjam');
      $catatan_peminjam   = input('catatan_peminjam');
      $tmp                = explode('/', $tgl_pinjam);
      $urut_tanggal       = array($tmp[2], $tmp[0], $tmp[1]);
      $tgl_pinjam         = implode('-', $urut_tanggal);
      $tmp                = explode('/', $tgl_kembali);
      $urut_tanggal       = array($tmp[2], $tmp[0], $tmp[1]);
      $tgl_kembali        = implode('-', $urut_tanggal);
      $input              = array(
        'namaPeminjam'  => $nama_peminjam,
        'nipnik'        => $ni_peminjam,
        'noTelp'        => $notelp_peminjam,
        'alasan'        => $alasan_peminjam,
        'tglPinjam'     => $tgl_pinjam,
        'tglKembali'    => $tgl_kembali,
        'catatan'       => $catatan_peminjam,
        'status'        => $status_peminjaman,
        'idLab'         => $lab_peminjam
      );
      $this->db->where('substring(sha1(idPinjamLab), 7, 4) = "' . $id . '"')->update('peminjamanlab', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Borrowing Laboratory Successfully Updated</div>');
      redirect('Borrowing/Laboratory');
    }
  }
}
