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
            break;
          } elseif ($l->kodeRuang != $row[2]) {
            $id_lab = '-';
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
      }
      fclose($handle);
    }
  }

  public function uploadDaftarMK()
  {
    view('Laboran/daftar_mk_csv');
  }

  public function simpanDaftarMKCSV()
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
        $cek_data = $this->db->select('*')->from('daftar_mk')->where('kode_mk', $row[2])->get()->row();
        if (!$cek_data) {
          $input  = array(
            'id_ta'       => $row[0],
            'kode_prodi'  => $row[3],
            'kode_mk'     => $row[2]
          );
          $this->db->insert('daftar_mk', $input);
        }
      }
      fclose($handle);
    }
    redirect('Schedule');
  }

  public function uploadJadwalAsprak()
  {
    view('Laboran/jadwal_asprak_csv');
  }

  public function simpanJadwalAsprakCSV()
  {
    $file = $_FILES['file_csv']['tmp_name'];
    $ekstensi_file  = explode('.', $_FILES['file_csv']['name']);
    if (strtolower(end($ekstensi_file)) === 'csv' && $_FILES['file_csv']['size'] > 0) {
      $handle = fopen($file, 'r');
      $i = 0;
      $tmp_kode_mk    = '';
      $tmp_kelas      = '';
      $tmp_dosen      = '';
      $tmp_hari       = '';
      $tmp_jam_mulai  = '';
      while (($row = fgetcsv($handle, 2048))) {
        $i++;
        if ($i == 1) {
          continue;
        }
        // cek kode mk
        if ($row[1] == '') {
          $kode_mk = $tmp_kode_mk;
        } else {
          $tmp_kode_mk = $row[1];
          $kode_mk      = $row[1];
        }
        // cek kelas
        if ($row[2] == '') {
          $kelas  = $tmp_kelas;
        } else {
          $tmp_kelas  = $row[2];
          $kelas      = $row[2];
        }
        //cek kode dosen
        if ($row[3] == '') {
          $dosen  = $tmp_dosen;
        } else {
          $tmp_dosen  = $row[3];
          $dosen      = $row[3];
        }
        //cek hari
        if ($row[4] == '') {
          $hari = $tmp_hari;
        } else {
          $tmp_hari = $row[4];
          $hari     = $row[4];
        }
        //cek jam masuk
        if ($row[5] == '') {
          $jam_masuk  = $tmp_jam_mulai;
        } else {
          $tmp_row        = str_replace('.', ':', $row[5]);
          $tmp_jam_mulai  = $tmp_row;
          $jam_masuk      = $tmp_row;
        }
        if ($hari == 'SENIN') {
          $hari_ke = 1;
        } elseif ($hari == 'SELASA') {
          $hari_ke = 2;
        } elseif ($hari == 'RABU') {
          $hari_ke = 3;
        } elseif ($hari == 'KAMIS') {
          $hari_ke = 4;
        } elseif ($hari == 'JUMAT') {
          $hari_ke = 5;
        } elseif ($hari == 'SABTU') {
          $hari_ke = 6;
        }
        $id_mk  = $this->db->select('id_mk')->from('matakuliah')->where('kode_mk', $kode_mk)->get()->row()->id_mk;
        $id_jadwal_lab  = $this->db->select('id_jadwal_lab')->from('jadwal_lab')->where('date_format(jam_masuk, "%H:%i") = "' . $jam_masuk . '"')->where('kelas', $kelas)->where('kode_dosen', $dosen)->where('hari_ke', $hari_ke)->where('id_mk', $id_mk)->get()->row();
        if ($id_jadwal_lab == true) {
          $id_jadwal_lab = $id_jadwal_lab->id_jadwal_lab;
        } else {
          $id_jadwal_lab = '-';
        }
        $jadwal_asprak  = array(
          'nim_asprak'    => $row[0],
          'id_jadwal_lab' => $id_jadwal_lab
        );
        // print_r($jadwal_asprak);
        // echo '<br>';
        $this->db->insert('jadwal_asprak', $jadwal_asprak);
        $id_daftar_mk = $this->db->select('id_daftar_mk')->from('daftar_mk')->where('kode_mk', $kode_mk)->get()->row()->id_daftar_mk;
        $cek_daftar_asprak = $this->db->select('nim_asprak')->from('daftarasprak')->where('nim_asprak', $row[0])->where('id_daftar_mk', $id_daftar_mk)->get()->row();
        if (!$cek_daftar_asprak) {
          $daftarasprak = array(
            'nim_asprak'    => $row[0],
            'id_daftar_mk'  => $id_daftar_mk
          );
          // print_r($daftarasprak);
          // echo '<hr>';
          $this->db->insert('daftarasprak', $daftarasprak);
        }
      }
      fclose($handle);
    }
    redirect('Schedule');
  }

  public function uploadNIPDosen()
  {
    view('Laboran/nip_dosen_csv');
  }

  public function simpanNIPDosen()
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
        $cek_data = $this->db->get_where('dosen', array('nip_dosen' => $row[1], 'kode_dosen' => $row[0]))->row();
        if (!$cek_data) {
          $input  = array(
            'kode_dosen'  => $row[0],
            'nip_dosen'   => $row[1],
            'nama_dosen'  => ucwords(strtolower($row[2]))
          );
          $this->db->insert('dosen', $input);
        }
      }
      fclose($handle);
    }
    redirect('Schedule');
  }

  public function ImportBAP()
  {
    view('laboran/import_bap_bermasalah');
  }

  public function ImportBAPBermasalah()
  {
    $file = $_FILES['file_csv']['tmp_name'];
    $ekstensi_file  = explode('.', $_FILES['file_csv']['name']);
    if (strtolower(end($ekstensi_file)) === 'csv' && $_FILES['file_csv']['size'] > 0) {
      $handle = fopen($file, 'r');
      $i = 0;
      $tmp_nim      = '';
      $nim          = '';
      $tmp_kode_mk  = '';
      $kode_mk      = '';
      while (($row = fgetcsv($handle, 2048))) {
        $i++;
        if ($i == 1) {
          continue;
        }
        if ($row[0] != null) {
          $nim  = $row[0];
          $tmp_nim  = $row[0];
        } else {
          $nim  = $tmp_nim;
        }
        if ($row[4] != null) {
          $kode_mk      = str_replace(' ', '', $row[4]);
          $tmp_kode_mk  = str_replace(' ', '', $row[4]);
        } else {
          $kode_mk      = $tmp_kode_mk;
        }
        $tanggal        = $row[5];
        $jam_masuk      = str_replace('.', ':', $row[6]);
        $jam_selesai    = str_replace('.', ':', $row[7]);
        $asprak_masuk   = $tanggal . ' ' . $jam_masuk;
        $asprak_selesai = $tanggal . ' ' . $jam_selesai;
        $start          = date_create($asprak_masuk);
        $end            = date_create($asprak_selesai);
        $diff           = date_diff($end, $start);
        //print_r($row[0]);
        $hari_ke      = date('N', strtotime($tanggal));
        $honor        = $this->db->where('status', '1')->get('tarif')->row();
        $id_mk        = $this->db->where('kode_mk', $kode_mk)->get('matakuliah')->row();
        $cek_jadwal_lab = $this->db->where('hari_ke', $hari_ke)->where('id_mk', $id_mk->id_mk)->get('jadwal_lab')->row();
        $input          = array(
          'asprak_masuk'    => $asprak_masuk,
          'asprak_selesai'  => $asprak_selesai,
          'durasi'          => $diff->h,
          'honor'           => $diff->h * $honor->tarif_honor,
          'modul'           => $row[8],
          'screenshot'      => 'Praktikum Onsite',
          'approve_absen'   => '2',
          'nim_asprak'      => $nim,
          'id_jadwal_lab'   => $cek_jadwal_lab->id_jadwal_lab
        );
        $this->db->insert('presensi_asprak', $input);
      }
      fclose($handle);
    }
  }

  public function GenerateBAPMei()
  {
    set_rules('kode_mk', 'Kode MK', 'required|trim');
    if (validation_run() == false) {
      view('laboran/generate_bap_mei');
    } else {
      $kode_mk = input('kode_mk');
      //$nim     = input('nim');
      $cek_daftar_mk = $this->db->where('kode_mk', $kode_mk)->get('daftar_mk')->row();
      if ($cek_daftar_mk == true) {
        //$prodi  = $this->db->where('kode_prodi', $cek_daftar_mk->kode_prodi)->get('prodi')->row();
        $prodi  = $this->db->select('prodi.strata, prodi.nama_prodi, matakuliah.nama_mk, matakuliah.kode_mk')->from('daftar_mk')->join('prodi', 'daftar_mk.kode_prodi = prodi.kode_prodi')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('matakuliah.kode_mk', $kode_mk)->where('prodi.kode_prodi', $cek_daftar_mk->kode_prodi)->get()->row();
        $dosen  = $this->db->where('id_dosen', $cek_daftar_mk->koordinator_mk)->get('dosen')->row();
        // $cek_daftar_asprak = $this->db->where('id_daftar_mk', $cek_daftar_mk->id_daftar_mk)->where('nim_asprak', $nim)->get('daftarasprak')->result();
        $cek_daftar_asprak = $this->db->where('id_daftar_mk', $cek_daftar_mk->id_daftar_mk)->get('daftarasprak')->result();
        if ($cek_daftar_asprak == true) {
          foreach ($cek_daftar_asprak as $da) {
            $profil_asprak  = $this->db->where('nim_asprak', $da->nim_asprak)->get('asprak')->row();
            $bap = $this->db->select('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") selesai, presensi_asprak.durasi, presensi_asprak.modul, presensi_asprak.screenshot, asprak.ttd_asprak')->from('presensi_asprak')->join('jadwal_lab', 'presensi_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk')->join('daftar_mk', 'matakuliah.kode_mk = daftar_mk.kode_mk')->join('asprak', 'presensi_asprak.nim_asprak = asprak.nim_asprak')->where('daftar_mk.kode_mk', $kode_mk)->where('daftar_mk.koordinator_mk', $dosen->id_dosen)->where('presensi_asprak.nim_asprak', $da->nim_asprak)->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between "2020-01-01" and "2020-07-01"')->order_by('presensi_asprak.asprak_masuk', 'asc')->get()->result();
            $total_jam = $this->db->select('sum(presensi_asprak.durasi) jam, count(presensi_asprak.id_presensi_asprak) hari')->from('presensi_asprak')->join('jadwal_lab', 'presensi_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk')->join('daftar_mk', 'matakuliah.kode_mk = daftar_mk.kode_mk')->join('asprak', 'presensi_asprak.nim_asprak = asprak.nim_asprak')->where('daftar_mk.kode_mk', $kode_mk)->where('daftar_mk.koordinator_mk', $dosen->id_dosen)->where('presensi_asprak.nim_asprak', $da->nim_asprak)->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between "2020-01-01" and "2020-07-01"')->get()->row();
            $tanggal_bap = $this->db->select('tanggal_approve')->from('honor')->where('nim_asprak', $da->nim_asprak)->where('id_daftar_mk', $cek_daftar_mk->id_daftar_mk)->where('id_dosen', $dosen->id_dosen)->where('id_dosen is not null')->where('tanggal_approve is not null')->get()->row();
            $tanggal_submit = $this->db->select('tanggal_submit')->from('honor')->where('nim_asprak', $da->nim_asprak)->where('id_daftar_mk', $cek_daftar_mk->id_daftar_mk)->where('id_dosen', $dosen->id_dosen)->where('id_dosen is not null')->where('tanggal_approve is not null')->get()->row();
            $approve_dosen = $this->db->select('approve_dosen')->from('honor')->where('nim_asprak', $da->nim_asprak)->where('id_daftar_mk', $cek_daftar_mk->id_daftar_mk)->where('id_dosen', $dosen->id_dosen)->where('id_dosen is not null')->where('tanggal_approve is not null')->get()->row();
            if ($tanggal_bap == true) {
              $tanggal_bap = $tanggal_bap->tanggal_approve;
            } else {
              $tanggal_bap = 'xx';
            }
            if ($tanggal_submit == true) {
              $tanggal_submit = $tanggal_submit->tanggal_submit;
            } else {
              $tanggal_submit = 'xx';
            }
            if ($approve_dosen == true) {
              $approve_dosen  = $approve_dosen->approve_dosen;
            } else {
              $approve_dosen  = '0';
            }
            if ($bap == true) {
              $data['title']  = 'B4-2_' . $prodi->kode_mk . '_' . $profil_asprak->nim_asprak;
              $data['asprak'] = $profil_asprak;
              $data['prodi']  = $prodi;
              $data['dosen']  = $dosen;
              $data['bap']    = $bap;
              $data['total']  = $total_jam;
              $data['tanggal']  = $tanggal_bap;
              view('laboran/generate_bap', $data);
              // $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
              // $html = view('laboran/generate_bap', $data, true);
              // $mpdf->WriteHTML($html);
              // $mpdf->Output('assets/bap/' . $data['title'] . '.pdf', 'F');
              $input  = array(
                'hari'            => $total_jam->hari,
                'jam'             => $total_jam->jam,
                'nominal'         => $total_jam->jam * 10000,
                'tanggal_submit'  => $tanggal_submit,
                'status'          => '0',
                'id_daftar_mk'    => $cek_daftar_mk->id_daftar_mk,
                'id_periode'      => 'B4-2',
                'nim_asprak'      => $profil_asprak->nim_asprak,
                'id_dosen'        => $dosen->id_dosen,
                'approve_dosen'   => $approve_dosen,
                'tanggal_approve' => $tanggal_bap,
                'file_bap'        => 'assets/bap/' . $data['title'] . '.pdf'
              );
              //$this->db->insert('honor', $input);
            }
          }
        }
      }
    }
  }

  public function GenerateBAPMei_()
  {
    $daftar_asprak = $this->db->get('asprak')->result();
    foreach ($daftar_asprak as $da) {
      // if ($da->nim_asprak == '1501188418') {
      $profil_asprak  = $this->db->where('nim_asprak', $da->nim_asprak)->get('asprak')->row();
      $daftar_mk      = $this->db->where('nim_asprak', $da->nim_asprak)->get('daftarasprak')->result();
      foreach ($daftar_mk as $dmk) {
        $prodi = $this->db->select('prodi.strata, prodi.nama_prodi, matakuliah.nama_mk, matakuliah.kode_mk')->from('daftar_mk')->join('prodi', 'daftar_mk.kode_prodi = prodi.kode_prodi')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('daftar_mk.id_daftar_mk', $dmk->id_daftar_mk)->get()->row();
        $dosen = $this->db->select('dosen.id_dosen, dosen.nama_dosen, dosen.kode_dosen, dosen.ttd_dosen')->from('daftar_mk')->join('dosen', 'daftar_mk.koordinator_mk = dosen.id_dosen')->where('daftar_mk.id_daftar_mk', $dmk->id_daftar_mk)->where('daftar_mk.koordinator_mk is not null')->get()->row();
        if ($dosen == true) {
          $bap   = $this->db->select('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") selesai, presensi_asprak.durasi, presensi_asprak.honor, presensi_asprak.modul, presensi_asprak.screenshot, presensi_asprak.approve_absen, presensi_asprak.id_jadwal_asprak, presensi_asprak.nim_asprak, presensi_asprak.id_jadwal_lab, asprak.ttd_asprak')->from('presensi_asprak')->join('jadwal_lab', 'presensi_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->join('asprak', 'presensi_asprak.nim_asprak = asprak.nim_asprak')->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk')->join('daftar_mk', 'matakuliah.kode_mk = daftar_mk.kode_mk')->where('presensi_asprak.nim_asprak', $da->nim_asprak)->where('presensi_asprak.asprak_masuk >= "2020-03-16"')->where('daftar_mk.koordinator_mk', $dosen->id_dosen)->order_by('presensi_asprak.asprak_masuk', 'asc')->get()->result();
          $total_jam  = $this->db->select('sum(presensi_asprak.durasi) jam, count(presensi_asprak.id_presensi_asprak) hari')->from('presensi_asprak')->join('jadwal_lab', 'presensi_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->join('asprak', 'presensi_asprak.nim_asprak = asprak.nim_asprak')->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk')->join('daftar_mk', 'matakuliah.kode_mk = daftar_mk.kode_mk')->where('presensi_asprak.nim_asprak', $da->nim_asprak)->where('presensi_asprak.asprak_masuk >= "2020-03-16"')->where('daftar_mk.koordinator_mk', $dosen->id_dosen)->order_by('presensi_asprak.asprak_masuk', 'asc')->get()->row();
          $tanggal_bap = $this->db->select('tanggal_approve')->from('honor')->where('nim_asprak', $da->nim_asprak)->where('id_daftar_mk', $dmk->id_daftar_mk)->where('id_dosen', $dosen->id_dosen)->where('id_dosen is not null')->get()->row();
          if ($bap == true) {
            // $data['title']  = 'Generate BAP Mei';
            $data['title']    = 'B4-2_' . $prodi->kode_mk . '_' . $profil_asprak->nim_asprak;
            $data['asprak'] = $profil_asprak;
            $data['prodi']  = $prodi;
            $data['dosen']  = $dosen;
            $data['bap']    = $bap;
            $data['total']  = $total_jam;
            $data['tanggal']  = $tanggal_bap;
            view('laboran/generate_bap', $data);
            $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
            $html = view('laboran/generate_bap', $data, true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('assets/bap/' . $data['title'] . '.pdf', 'F');
            $cek_bap = $this->db->where('tanggal_submit is not null')->where('no_pk is null')->where('nim_asprak', $da->nim_asprak)->get('honor')->result();
            $tanggal_submit = $this->db->where('tanggal_submit is not null')->where('no_pk is null')->where('nim_asprak', $da->nim_asprak)->get('honor')->row();
            $tarif    = $this->db->where('status', '1')->get('tarif')->row();
            // $this->db->where('tanggal_submit is not null')->where('no_pk is null')->where('nim_asprak', $da->nim_asprak)->delete('honor');
            if ($cek_bap == true) {
              $input  = array(
                'hari'            => $total_jam->hari,
                'jam'             => $total_jam->jam,
                'nominal'         => $total_jam->jam * $tarif->tarif_honor,
                'tanggal_submit'  => $tanggal_submit->tanggal_submit,
                'status'          => '0',
                'id_daftar_mk'    => $dmk->id_daftar_mk,
                'id_periode'      => 'B4-2',
                'nim_asprak'      => $da->nim_asprak,
                'id_dosen'        => $dosen->id_dosen,
                'approve_dosen'   => $tanggal_submit->approve_dosen,
                'tanggal_approve' => $tanggal_submit->tanggal_approve,
                'file_bap'        => 'assets/bap/' . $data['title'] . '.pdf'
              );
              $this->db->insert('honor', $input);
            }
          }
        }
      }
      // $presensi_asprak = $this->db->where('nim_asprak', $da->nim_asprak)->order_by('asprak_masuk', 'asc')->get('presensi_asprak')->result();

      // print_r($data['asprak']);
      //}
    }
  }
}
