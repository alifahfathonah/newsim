<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Finance extends CI_Controller
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

  public function Honor()
  {
    $data           = $this->data;
    $data['title']  = 'Honor | SIM Laboratorium';
    if (userdata('login') == 'laboran') {
      $data['prodi']            = $this->m->daftarProdi()->result();
      $data['tahun_ajaran']     = $this->m->daftarPeriode()->result();
      $data['laboran']          = $this->m->daftarLaboran()->result();
      $data['submission']       = $this->m->daftarPertanggungan()->result();
      $data['withdraw_asprak']  = $this->m->daftarPengambilanHonorAsprak()->result();
      $data['withdraw_aslab']   = $this->m->daftarPengambilanHonorAslab()->result();
      view('laboran/header', $data);
      view('laboran/honor', $data);
      view('laboran/footer');
    } elseif (userdata('login') == 'aslab') {
      $data['data'] = $this->m->daftarHonorAslab(userdata('id_aslab'))->result();
      view('aslab/header', $data);
      view('aslab/honor', $data);
      view('aslab/footer');
    }
  }

  public function AddSubmission()
  {
    set_rules('tipe_submission', 'Type', 'required|trim');
    if (validation_run() == false) {
      redirect('Finance/Honor');
    } else {
      $tipe_submission  = input('tipe_submission');
      $prodi            = input('prodi');
      $ta               = input('ta');
      $periode          = input('periode');
      $pembuat          = input('pembuat');
      $ambil_tahun      = $this->db->where('id_ta', $ta)->get('tahun_ajaran')->row()->ta;
      $split_tahun      = explode('-', $ambil_tahun);
      if ($split_tahun[1] == '1') {
        $tahun = $split_tahun[0];
      } elseif ($split_tahun[1] == '2') {
        $tahun = $split_tahun[0] + 1;
      }
      $no_pk            = $tipe_submission . '-' . substr($tahun, -2) . '.' . $periode;
      $cek_counter      = $this->db->like('no_pk', $no_pk)->order_by('no_pk', 'desc')->get('pk')->row();
      if ($cek_counter) {
        $ambil_counter  = substr($cek_counter->no_pk, -2);
        $counter        = $ambil_counter + 1;
        if (strlen($counter) == 1) {
          $counter = '0' . $counter;
        } else {
          $counter = $counter;
        }
        $no_pk  = $no_pk . '.' . $counter;
      } else {
        $no_pk  = $no_pk . '.01';
      }
      $input  = array(
        'no_pk'       => $no_pk,
        'kode_prodi'  => $prodi,
        'id_ta'       => $ta,
        'status_pk'   => '0',
        'pembuat'     => $pembuat
      );
      $total = 0;
      if ($tipe_submission == '02' || $tipe_submission == '01') {
        $id_periode = $this->db->where('aslab', '1')->where('bulan', bulan_panjang($periode))->get('periode')->row()->id_periode;
        $input['id_periode']  = $id_periode;
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
            $tarif  = $this->db->where('status', '1')->get('tarif')->row()->tarif_honor;
            $total  = $total + ((float) $row[1] * $tarif);
            //permanen
            // $aslab  = array(
            //   'jam'           => (float) $row[1],
            //   'nominal'       => (float) $row[1] * $tarif,
            //   'status_honor'  => 0,
            //   'id_periode'    => $id_periode,
            //   'id_ta'         => $ta
            // );
            //input data dulu
            $id_aslab = $this->db->where('nim', $row[0])->limit(1)->order_by('idAslab', 'desc')->get('aslab')->row()->idAslab;
            $aslab  = array(
              'jam'               => (float) $row[1],
              'nominal'           => (float) $row[1] * $tarif,
              'status_honor'      => 3,
              'opsi_pengambilan'  => 'Cash',
              'tanggal_diambil'   => '2018-07-31',
              'id_periode'        => $id_periode,
              'id_ta'             => $ta,
              'id_aslab'          => $id_aslab,
              'no_pk'             => $no_pk
            );
            $this->m->insertData('honor_aslab', $aslab);
          }
          fclose($handle);
        }
        $input['total'] = $total;
      } elseif ($tipe_submission == '03') {
        $id_periode = $this->db->where('asprak', '1')->where('bulan', bulan_panjang($periode))->get('periode')->row()->id_periode;
        $input['id_periode']  = $id_periode;
      }
      $this->m->insertData('pk', $input);
      redirect('Finance/Honor');
    }
  }

  public function HonorAslab()
  {
    set_rules('id_honor_aslab', 'ID Honor Aslab', 'required|trim');
    if (validation_run() == false) {
      redirect('Finance/Honor');
    } else {
      $id_honor_aslab = input('id_honor_aslab');
      $pilihan        = input('pilihan');
      $input          = array('status_honor' => '2', 'opsi_pengambilan' => $pilihan);
      $this->db->where('id_honor_aslab', $id_honor_aslab)->update('honor_aslab', $input);
      redirect('Finance/Honor');
    }
  }

  public function UploadEvidence()
  {
    set_rules('id_honor', 'ID Honor', 'required|trim');
    if (validation_run() == false) {
      redirect('Finance/Honor');
    } else {
      $id_honor = input('id_honor');
      $input    = array('status' => '2');
      $nama_file = rand(10, 99) . '-' . str_replace(' ', '_', $_FILES['bukti_transfer']['name']);
      $config['upload_path']    = 'assets/img/bukti_transfer/';
      $config['allowed_types']  = 'gif|jpg|jpeg|png';
      $config['max_size']       = 1024 * 10;
      $config['file_name']      = $nama_file;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('bukti_transfer')) {
        $input['bukti_transfer'] = $config['upload_path'] . '' . $nama_file;
      }
      $this->db->where('id_honor', $id_honor)->update('honor', $input);
      redirect('Finance/Honor');
    }
  }

  public function ApproveHonor()
  {
    $id = $_POST['id'];
    $cek_data = $this->db->where('substring(sha1(id_honor), 8, 7) = "' . $id . '"')->get('honor')->row();
    if ($cek_data) {
      $input  = array('status' => '2');
      $this->db->where('substring(sha1(id_honor), 8, 7) = "' . $id . '"')->update('honor', $input);
      echo 'true';
    }
  }
}
