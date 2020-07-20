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
      $data['proses'] = $this->m->honorAslabProses(userdata('id_aslab'))->result();
      $data['selesai'] = $this->m->honorAslabSelesai(userdata('id_aslab'))->result();
      view('aslab/header', $data);
      view('aslab/honor', $data);
      view('aslab/footer');
    }
  }

  public function ajaxSubmission()
  {
    $hasil  = array();
    $tampil = array();
    $submission = $this->m->daftarPertanggungan()->result();
    foreach ($submission as $s) {
      if ($s->kode_pk == '01') {
        $informasi = 'Pertanggungan Umum ' . $s->kode_prodi . ' - ' . $s->bulan;
      } elseif ($s->kode_pk == '02') {
        $informasi = 'Honor Aslab ' . $s->kode_prodi . ' - ' . $s->bulan;
      } elseif ($s->kode_pk == '03') {
        $informasi = 'Honor Asprak ' . $s->kode_prodi . ' - ' . $s->bulan;
      }
      if ($s->status_pk == '1') {
        $status = 'On Process';
      } elseif ($s->status_pk == '2') {
        $status = 'Revision';
      } elseif ($s->status_pk == '3') {
        $status = 'Done';
      }
      $hasil[]  = array(
        'no_pk'         => $s->no_pk,
        'informasi'     => $informasi,
        'total'         => 'Rp ' . number_format($s->total, 0, '', '.'),
        'tgl_pengajuan' => $s->tanggal_pengajuan,
        'tgl_cair'      => $s->tanggal_cair,
        'status'        => $status,
        'action'        => 'Under Maintenance'
      );
    }
    $tampil = array('data' => $hasil);
    echo json_encode($tampil);
  }

  public function ajaxSalaryAsprak()
  {
    $no     = 1;
    $hasil  = array();
    $tampil = array();
    $asprak = $this->m->daftarPengambilanHonorAsprak()->result();
    foreach ($asprak as $a) {
      if ($a->status == '1') {
        $status_ambil = 'Ready To Take';
      } elseif ($a->status == '2') {
        $status_ambil = 'Taken';
      } elseif (($a->status == '0' || $a->status == null) && ($a->no_pk == null || $a->no_pk == '')) {
        $status_ambil = 'Not Yet Submitted To Finance';
      } elseif (($a->status == '0' || $a->status == null) && $a->no_pk != '') {
        $status_ambil = 'Untaken';
      }
      $aksi = '<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detail' . $a->id_honor . '"><i class="fa fa-eye"></i></button>&nbsp;';
      if ($a->status == '1') {
        $aksi .= '<button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#upload_bukti' . $a->id_honor . '"><i class="fa fa-edit"></i></button>';
        $aksi .= '<div class="modal inmodal fade" id="upload_bukti' . $a->id_honor . '" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><h4 class="modal-title">Upload Evidence of Transfer</h4></div><form method="post" action="' . base_url('Finance/UploadEvidence') . '" enctype="multipart/form-data"><div class="modal-body"><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label class="font-bold">NIM</label><br><label>' . $a->nim_asprak . '</label><input type="text" name="id_honor" id="id_honor" value="' . $a->id_honor . '" style="display: none"></div></div><div class="col-md-6 col-sm-12"><div class="form-group"><label class="font-bold">Name</label><br><label>' . $a->nama_asprak . '</label></div></div></div><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label class="font-bold">Periode</label><br><label>' . $a->bulan . '</label></div></div><div class="col-md-6 col-sm-12"><div class="form-group"><label class="font-bold">Amount</label><br><label>Rp ' . number_format($a->nominal, 0, '', '.') . '</label></div></div></div><div class="row"><div class="col-md-12 col-sm-12"><div class="form-group"><label class="font-bold">Evidence of Transfer</label><input type="file" class="form-control" name="bukti_transfer" accept="image/*"></div></div></div></div><div class="modal-footer"><button type="button" class="btn btn-white" data-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Upload</button></div></form></div></div></div>';
      } elseif ($a->status == '2') {
        $aksi .= '<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#bukti_transfer_asprak' . $a->id_honor . '"><i class="fa fa-file"></i></button><div class="modal inmodal" id="bukti_transfer_asprak' . $a->id_honor . '" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content animated bounceInRight"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><h4 class="modal-title">Evidence of Transfer</h4></div><div class="modal-body"><img src="' . base_url($a->bukti_transfer) . '"></div><div class="modal-footer"><button type="button" class="btn btn-white" data-dismiss="modal">Close</button></div></div></div></div>';
      }
      $aksi .= '<div class="modal inmodal fade" id="detail' . $a->id_honor . '" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><h4 class="modal-title">Detail Withdraw</h4></div><div class="modal-body"><div class="form-group row"><label class="col-md-5 col-sm-6 col-form-label">NIM</label><label class="col-md-5 col-sm-6 col-form-label">' . $a->nim_asprak . '</label></div><div class="form-group row"><label class="col-md-5 col-sm-6 col-form-label">Name</label><label class="col-md-5 col-sm-6 col-form-label">' . $a->nama_asprak . '</label></div><div class="form-group row"><label class="col-md-5 col-sm-6 col-form-label">Amount</label><label class="col-md-5 col-sm-6 col-form-label">Rp ' . number_format($a->nominal, 0, '', '.') . '</label></div><div class="form-group row"><label class="col-md-5 col-sm-6 col-form-label">Withdraw Option</label><label class="col-md-5 col-sm-6 col-form-label">' . $a->opsi_pengambilan . '</label></div><div class="form-group row"><label class="col-md-5 col-sm-6 col-form-label">Bank Account Number</label><label class="col-md-5 col-sm-6 col-form-label">' . $a->norek_asprak . ' - ' . $a->nama_rekening . '</label></div><div class="form-group row"><label class="col-md-5 col-sm-6 col-form-label">LinkAja</label><label class="col-md-5 col-sm-6 col-form-label">' . $a->linkaja_asprak . '</label></div></div><div class="modal-footer"><button type="button" class="btn btn-white" data-dismiss="modal">Close</button></div></div></div></div>';
      $hasil[]  = array(
        'no'      => $no++,
        'kode_mk' => $a->kode_mk,
        'nama_mk' => $a->nama_mk,
        'nim'     => $a->nim_asprak,
        'nama'    => $a->nama_asprak,
        'periode' => $a->bulan,
        'jumlah'  => 'Rp ' . number_format($a->nominal, 0, '', '.'),
        'opsi'    => $a->opsi_pengambilan,
        'status'  => $status_ambil,
        'action'  => $aksi,
      );
    }
    $tampil = array('data' => $hasil);
    echo json_encode($tampil);
  }

  public function TakeSalary()
  {
    set_rules('pilihan', 'Option', 'required|trim');
    if (validation_run() == false) {
      redirect('Finance/Honor');
    } else {
      $id_honor = input('id_honor');
      $pilihan  = input('pilihan');
      $tmp      = explode('|', $id_honor);
      for ($i = 1; $i < count($tmp); $i++) {
        $input  = array('opsi_pengambilan' => $pilihan, 'status_honor' => '2', 'tanggal_diambil' => date('Y-m-d'));
        $this->db->where('id_honor_aslab', $tmp[$i])->update('honor_aslab', $input);
      }
      set_flashdata('msg', '<div class="alert alert-success msg">Your BAP successfully submited</div>');
      redirect('Finance/Honor');
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

  public function UploadEvidenceAslab()
  {
    set_rules('id_honor_aslab', 'ID Honor', 'required|trim');
    if (validation_run() == false) {
      redirect('Finance/Honor');
    } else {
      $id_honor = input('id_honor_aslab');
      $input    = array('status_honor' => '3');
      $nama_file = rand(10, 99) . '-' . str_replace(' ', '_', $_FILES['bukti_transfer']['name']);
      $config['upload_path']    = 'assets/img/bukti_transfer/';
      $config['allowed_types']  = 'gif|jpg|jpeg|png';
      $config['max_size']       = 1024 * 10;
      $config['file_name']      = $nama_file;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('bukti_transfer')) {
        $input['bukti_transfer'] = $config['upload_path'] . '' . $nama_file;
      }
      $this->db->where('id_honor_aslab', $id_honor)->update('honor_aslab', $input);
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

  public function DaftarBayar()
  {
    $prodi    = input('prodi');
    $ta       = input('ta');
    $periode  = input('periode');
    $periode  = bulan_panjang($periode);
    $periode  = $this->db->select('id_periode')->from('periode')->where('bulan', $periode)->where('asprak', '1')->get()->row()->id_periode;
    $daftar_mk  = $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('kode_prodi', $prodi)->where('id_ta', $ta)->order_by('matakuliah.nama_mk')->get('daftar_mk')->result();
    $prodi  = $this->db->where('kode_prodi', $prodi)->get('prodi')->row()->nama_prodi;
    $data['title']      = 'Honor Asprak ' . $prodi;
    $data['daftar_mk']  = $daftar_mk;
    $data['periode']    = $periode;
    $data['prodi']      = $prodi;
    //view('laboran/daftar_bayar_baru', $data);
    $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
    $html = view('laboran/daftar_bayar_baru', $data, true);
    $mpdf->WriteHTML($html);
    $mpdf->Output();
  }
}
