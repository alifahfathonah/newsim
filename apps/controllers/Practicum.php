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

  public function PrintBAP()
  {
    $matkul = input('matkul');
    $ta     = input('ta');
    $periode  = input('periode');
    $bulan    = $this->db->where('id_periode', $periode)->get('periode')->row();
    $data['bulan']  = $bulan->bulan;
    $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
    $daftar_mk  = $this->db->where('id_ta', $ta)->where('kode_mk', $matkul)->get('daftar_mk')->row();
    if ($daftar_mk == true) {
      $daftar_asprak  = $this->db->distinct()->select('asprak.nim_asprak, asprak.nama_asprak')->from('honor')->join('asprak', 'honor.nim_asprak = asprak.nim_asprak')->join('daftarasprak', 'honor.id_daftar_mk = daftarasprak.id_daftar_mk')->where('honor.id_daftar_mk', $daftar_mk->id_daftar_mk)->where('honor.id_periode', $periode)->order_by('asprak.nama_asprak', 'asc')->get()->result();
      $prodi          = $this->db->select('prodi.strata, prodi.nama_prodi, matakuliah.kode_mk, matakuliah.nama_mk')->from('daftar_mk')->join('prodi', 'daftar_mk.kode_prodi = prodi.kode_prodi')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('daftar_mk.kode_mk', $matkul)->get()->row();
      $jumlah_da = $this->db->distinct()->select('asprak.nim_asprak, asprak.nama_asprak')->from('honor')->join('asprak', 'honor.nim_asprak = asprak.nim_asprak')->join('daftarasprak', 'honor.id_daftar_mk = daftarasprak.id_daftar_mk')->where('honor.id_daftar_mk', $daftar_mk->id_daftar_mk)->where('honor.id_periode', $periode)->order_by('asprak.nama_asprak', 'asc')->get()->num_rows();
      $data['title']  = $periode . ' Full BAP ' . $prodi->kode_mk . ' - ' . $prodi->nama_mk;
      $no = 0;
      foreach ($daftar_asprak as $da) {
        $no++;
        $between  = '"2020-01-01" and "2020-07-01"';
        $bap    = $this->m->previewBAPAsprakLaboran($da->nim_asprak, $daftar_mk->id_daftar_mk, $between)->result();
        $total  = $this->m->totalBAPAsprakLaboran($da->nim_asprak, $daftar_mk->id_daftar_mk, $between)->row();
        $dosen  = $this->db->select('dosen.nama_dosen, dosen.ttd_dosen, honor.tanggal_approve')->from('honor')->join('dosen', 'honor.id_dosen = dosen.id_dosen')->where('honor.id_daftar_mk', $daftar_mk->id_daftar_mk)->where('honor.id_periode', $periode)->where('honor.nim_asprak', $da->nim_asprak)->get()->row();
        $data['nama_asprak']  = $da->nama_asprak;
        $data['nim_asprak']   = $da->nim_asprak;
        $data['prodi']        = $prodi;
        $data['total']        = $total;
        $data['bap']          = $bap;
        $data['dosen']        = $dosen;
        $html = view('laboran/print_bap', $data, true);
        $mpdf->WriteHTML($html);
        if ($no > 0 && $no <= ($jumlah_da - 1)) {
          $mpdf->AddPage();
        }
      }
      $mpdf->Output();
      //view('laboran/print_bap', $data);
    } else {
      echo 'gak';
    }
    // $data           = $this->data;
    // $data['title']  = 'BAP | SIM Laboratorium';
    // $data['data']   = $this->m->daftarAbsenAsprak()->result();
    // view('laboran/print_bap', $data);
    // $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
    // $html = view('laboran/print_bap', $data, true);
    // $mpdf->WriteHTML($html);
    // $mpdf->AddPage();
    // $html = view('laboran/print_bap', $data, true);
    // $mpdf->WriteHTML($html);
    // $mpdf->Output();
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

  public function Certificate()
  {
    set_rules('tahun_ajaran', 'Year', 'required|trim');
    set_rules('prodi', 'Majors', 'required|trim');
    $data           = $this->data;
    $data['title']  = 'Certificate Practicum Assistant | SIM Laboratorium';
    $data['ta']     = $this->db->get_where('tahun_ajaran')->result();
    $data['prodi']  = $this->m->daftarProdi()->result();
    if (validation_run() == true) {
      $id_ta              = input('tahun_ajaran');
      $kode_prodi         = input('prodi');
      $data['daftar_mk']  = $this->db->select('daftar_mk.id_daftar_mk, matakuliah.kode_mk, matakuliah.nama_mk')->from('daftar_mk')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('daftar_mk.id_ta', $id_ta)->where('daftar_mk.kode_prodi', $kode_prodi)->order_by('matakuliah.kode_mk')->get()->result();
    }
    view('laboran/header', $data);
    view('laboran/sertifikat_asprak', $data);
    view('laboran/footer');
  }

  public function DetailCertificate($id_daftar_mk)
  {
    $id_daftar_mk = $this->db->where('substring(sha1(id_daftar_mk), 8, 5) = "' . $id_daftar_mk . '"')->get('daftar_mk')->row();
    if ($id_daftar_mk == true) {
      $data           = $this->data;
      $data['title']  = 'Certificate Practicum Assistant | SIM Laboratorium';
      $data['dmk']    = $id_daftar_mk;
      view('laboran/header', $data);
      view('laboran/detail_sertifikat', $data);
      view('laboran/footer');
    } else {
      redirect('Practicum/Certificate');
    }
  }

  public function GenerateCertificate($id)
  {
    $tgl_generate = date('Y-m-d H:i:s');
    $no_sertifikat = $this->db->select('no_sertifikat')->from('sertifikat')->order_by('no_sertifikat', 'desc')->limit('1')->get()->row();
    if ($no_sertifikat == true) {
      $no_sertifikat = $no_sertifikat->no_sertifikat;
      if (strlen($no_sertifikat) == 1) {
        $no_sertifikat = '000' . $no_sertifikat;
      } elseif (strlen($no_sertifikat) == 2) {
        $no_sertifikat = '00' . $no_sertifikat;
      } elseif (strlen($no_sertifikat) == 3) {
        $no_sertifikat = '0' . $no_sertifikat;
      } elseif (strlen($no_sertifikat) == 4) {
        $no_sertifikat = $no_sertifikat;
      }
    } else {
      $no_sertifikat = '0782';
    }
    $daftar_asprak = $this->db->select('asprak.nim_asprak, asprak.nama_asprak')->from('daftarasprak')->join('asprak', 'daftarasprak.nim_asprak = asprak.nim_asprak')->where('daftarasprak.id_daftar_mk', $id)->order_by('asprak.nama_asprak')->get()->result();
    $sum = 0;
    $counter = 0;
    foreach ($daftar_asprak as $da) {
      $counter++;
      $b1 = $this->db->select('jam')->from('honor')->where('id_daftar_mk', $id)->where('nim_asprak', $da->nim_asprak)->like('id_periode', 'B1')->get()->row();
      $b2 = $this->db->select('jam')->from('honor')->where('id_daftar_mk', $id)->where('nim_asprak', $da->nim_asprak)->like('id_periode', 'B2')->get()->row();
      $b3 = $this->db->select('jam')->from('honor')->where('id_daftar_mk', $id)->where('nim_asprak', $da->nim_asprak)->like('id_periode', 'B3')->get()->row();
      $b4 = $this->db->select('jam')->from('honor')->where('id_daftar_mk', $id)->where('nim_asprak', $da->nim_asprak)->like('id_periode', 'B4')->get()->row();
      if ($b1 == true) {
        $b1 = $b1->jam;
      } else {
        $b1 = 0;
      }
      if ($b2 == true) {
        $b2 = $b2->jam;
      } else {
        $b2 = 0;
      }
      if ($b3 == true) {
        $b3 = $b3->jam;
      } else {
        $b3 = 0;
      }
      if ($b4 == true) {
        $b4 = $b4->jam;
      } else {
        $b4 = 0;
      }
      $total = $b1 + $b2 + $b3 + $b4;
      $sum    = $sum + $total;
    }
    $rata = $sum / $counter;
    $rata2 = floor(($sum / $counter) / 2);
    $sum = 0;
    $counter = 0;
    foreach ($daftar_asprak as $da) {
      $counter++;
      $b1 = $this->db->select('jam')->from('honor')->where('id_daftar_mk', $id)->where('nim_asprak', $da->nim_asprak)->like('id_periode', 'B1')->get()->row();
      $b2 = $this->db->select('jam')->from('honor')->where('id_daftar_mk', $id)->where('nim_asprak', $da->nim_asprak)->like('id_periode', 'B2')->get()->row();
      $b3 = $this->db->select('jam')->from('honor')->where('id_daftar_mk', $id)->where('nim_asprak', $da->nim_asprak)->like('id_periode', 'B3')->get()->row();
      $b4 = $this->db->select('jam')->from('honor')->where('id_daftar_mk', $id)->where('nim_asprak', $da->nim_asprak)->like('id_periode', 'B4')->get()->row();
      if ($b1 == true) {
        $b1 = $b1->jam;
      } else {
        $b1 = 0;
      }
      if ($b2 == true) {
        $b2 = $b2->jam;
      } else {
        $b2 = 0;
      }
      if ($b3 == true) {
        $b3 = $b3->jam;
      } else {
        $b3 = 0;
      }
      if ($b4 == true) {
        $b4 = $b4->jam;
      } else {
        $b4 = 0;
      }
      $total = $b1 + $b2 + $b3 + $b4;
      if ($total < $rata2) {
        $validasi = 'No';
      } else {
        $validasi = 'Yes';
      }
      if ($validasi == 'Yes') {
        $no_sertifikat = $no_sertifikat + 1;
        if (strlen($no_sertifikat) == 1) {
          $no_sertifikat = '000' . $no_sertifikat;
        } elseif (strlen($no_sertifikat) == 2) {
          $no_sertifikat = '00' . $no_sertifikat;
        } elseif (strlen($no_sertifikat) == 3) {
          $no_sertifikat = '0' . $no_sertifikat;
        } elseif (strlen($no_sertifikat) == 4) {
          $no_sertifikat = $no_sertifikat;
        }
        $input = array(
          'no_sertifikat'   => $no_sertifikat,
          'nim_asprak'      => $da->nim_asprak,
          'id_daftar_mk'    => $id,
          'b1'              => $b1,
          'b2'              => $b2,
          'b3'              => $b3,
          'b4'              => $b4,
          'presensi'        => $total,
          'validasi'        => $validasi,
          'tgl_generate'    => $tgl_generate
        );
      } elseif ($validasi == 'No') {
        $input = array(
          'no_sertifikat'   => '-',
          'nim_asprak'      => $da->nim_asprak,
          'id_daftar_mk'    => $id,
          'b1'              => $b1,
          'b2'              => $b2,
          'b3'              => $b3,
          'b4'              => $b4,
          'presensi'        => $total,
          'validasi'        => $validasi,
          'tgl_generate'    => $tgl_generate
        );
      }
      $this->m->insertData('sertifikat', $input);
    }
    redirect('Practicum/Certificate');
  }

  public function PrintCertificate($id_daftar_mk)
  {
    $id_daftar_mk = $this->db->where('substring(sha1(id_daftar_mk), 8, 5) = "' . $id_daftar_mk . '"')->get('daftar_mk')->row();
    if ($id_daftar_mk == true) {
      $tgl_cetak = date('Y-m-d H:i:s');
      $input = array('tgl_cetak' => $tgl_cetak);
      $this->db->where('id_daftar_mk', $id_daftar_mk->id_daftar_mk);
      $this->db->where('validasi', 'Yes');
      $this->db->update('sertifikat', $input);
      redirect('Practicum/Certificate');
    } else {
      redirect('Practicum/Certificate');
    }
  }

  public function ajaxCertificate()
  {
    $hasil  = '';
    $id     = input('id');
    // $id     = '4';
    $cek    = $this->db->select('matakuliah.kode_mk, matakuliah.nama_mk')->from('daftar_mk')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('daftar_mk.id_daftar_mk', $id)->get()->row();
    if ($cek == true) {
      $hasil .= $cek->kode_mk . ' - ' . $cek->nama_mk;
    }
    echo $hasil;
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

  public function ReadReport()
  {
    set_rules('id_laporan_praktikum', 'ID Laporan', 'required|trim');
    if (validation_run() == true) {
      $file_laporan = $this->db->where('id_laporan_praktikum', input('id_laporan_praktikum'))->get('laporan_praktikum')->row();
      $data['file'] = $file_laporan->nama_file;
      view('laboran/read_report', $data);
      //echo input('id_laporan_praktikum');
    } else {
      redirect('Practicum/Report');
    }
  }
  //   $data['title']  = 'Report';
  //   view('laboran/read_report', $data);
  // }

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
