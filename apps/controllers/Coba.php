<?php

class Coba extends CI_Controller
{

  function index()
  {
    // view('asprak/print_bap');
    $bulan_indo     = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $matapraktikum  = input('matapraktikum');
    $bulan          = input('bulan');
    $periode        = $this->a->daftarPeriode()->result();
    $tmp            = explode('|', $bulan);
    $rentang_periode  = $tmp[0];
    $nim_asprak         = $this->db->where('idUser', userdata('id'))->get('users')->row();
    $cek_data_matkul    = $this->db->select('daftar_mk.id_daftar_mk, matakuliah.id_mk, matakuliah.kode_mk, matakuliah.nama_mk, prodi.strata, prodi.kode_prodi, prodi.nama_prodi')->from('daftar_mk')->join('prodi', 'daftar_mk.kode_prodi = prodi.kode_prodi')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('daftar_mk.id_daftar_mk', $matapraktikum)->get()->row();
    $data['nama_bulan'] = $bulan_indo[$tmp[1]];
    foreach ($periode as $p) {
      if ($p->bulan == $tmp[2]) {
        $id_mk          = $cek_data_matkul->id_mk;
        $kode_mk        = $cek_data_matkul->kode_mk;
        $cek_data_user  = $this->db->select('asprak.nim_asprak, asprak.nama_asprak')->from('users')->join('asprak', 'users.nimAsprak = asprak.nim_asprak')->where('users.idUser', userdata('id'))->get()->row();
        $nim_asprak     = $cek_data_user->nim_asprak;
        $durasi         = $this->db->select('sum(presensi_asprak.durasi) durasi, count(presensi_asprak.asprak_masuk) hari')->from('presensi_asprak')->join('jadwal_asprak', 'presensi_asprak.id_jadwal_asprak = jadwal_asprak.id_jadwal_asprak')->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->where('jadwal_lab.id_mk', $id_mk)->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $rentang_periode)->where('presensi_asprak.nim_asprak', $nim_asprak)->order_by('presensi_asprak.asprak_masuk')->get()->row();
        $ambil_bap      = $this->db->select('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") jam_masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") jam_selesai, presensi_asprak.durasi, presensi_asprak.modul, presensi_asprak.screenshot')->from('presensi_asprak')->join('jadwal_asprak', 'presensi_asprak.id_jadwal_asprak = jadwal_asprak.id_jadwal_asprak')->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->where('jadwal_lab.id_mk', $id_mk)->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $rentang_periode)->where('presensi_asprak.nim_asprak', $nim_asprak)->order_by('presensi_asprak.asprak_masuk', 'asc')->get()->result();
        $ttd                      = $this->db->get_where('asprak', array('nim_asprak' => $nim_asprak))->row()->ttd_asprak;
        $koordinator_mk           = $this->db->select('dosen.nama_dosen, dosen.ttd_dosen, daftar_mk.koordinator_mk')->from('daftar_mk')->join('dosen', 'daftar_mk.koordinator_mk = dosen.id_dosen')->where('daftar_mk.kode_mk', $kode_mk)->get()->row();
        $data['user']             = $cek_data_user;
        $data['bulan']            = $bulan_indo[$tmp[1]];
        $data['mk_prodi']         = $cek_data_matkul;
        $data['durasi']           = $durasi;
        $data['bap']              = $ambil_bap;
        $data['ttd_asprak']       = $ttd;
        $data['tanggal_sekarang'] = tanggal_indonesia(date('Y-m-d'));
        $data['koordinator']      = $koordinator_mk;
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
        $html = view('asprak/print_bap_baru', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        // $honor_asprak = $this->db->where('status', '1')->get('tarif')->row();
        // $where  = array(
        //   'id_daftar_mk'    => $cek_data_matkul->id_daftar_mk,
        //   'id_periode'      => $p->id_periode,
        //   'nim_asprak'      => $nim_asprak,
        //   'id_dosen'        => $koordinator_mk->koordinator_mk,
        // );
        // $cek_submit = $this->db->get_where('honor', $where)->row();

        // $input  = array(
        //   'hari'            => $durasi->hari,
        //   'jam'             => $durasi->durasi,
        //   'nominal'         => $durasi->durasi * $honor_asprak->tarif_honor,
        //   'tanggal_submit'  => date('Y-m-d'),
        //   'status'          => 0,
        //   'id_daftar_mk'    => $cek_data_matkul->id_daftar_mk,
        //   'id_periode'      => $p->id_periode,
        //   'nim_asprak'      => $nim_asprak,
        //   'id_dosen'        => $koordinator_mk->koordinator_mk,
        //   'approve_dosen'   => 0
        // );
        // $this->db->insert('honor', $input);
        // set_flashdata('msg', '<div class="alert alert-success msg">Your BAP successfully submited</div>');
        // redirect('Asprak/BAP');

      }
    }
  }

  public function PK()
  {
    view('laboran/pk');
  }

  public function simpanPK()
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
        $no_pk  = '02-' . substr($row[0], 3);
        $input  = array(
          'no_pk'       => $no_pk,
          'kode_prodi'  => $row[1],
          'id_ta'       => $row[2],
          'id_periode'  => $row[3],
          'total'       => $row[4],
          'status_pk'   => $row[5],
          'pembuat'     => $row[6]
        );
        $this->db->insert('pk', $input);
        // print_r($input);
      }
      fclose($handle);
    }
  }
}
