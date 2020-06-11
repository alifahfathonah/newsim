<?php

class M_Asprak extends CI_Model
{

  function updateData($tabel, $data, $where, $nilai)
  {
    $this->db->where($where, $nilai);
    $this->db->update($tabel, $data);
  }

  function profilAsprak($nim)
  {
    return $this->db->get_where('asprak', array('nim_asprak' => $nim));
  }

  function daftarPengumuman()
  {
    $this->db->select('*');
    $this->db->from('pengumuman');
    $this->db->where('tipePengumuman', 'Practicum Assistant');
    $this->db->order_by('tglPengumuman', 'desc');
    $this->db->limit('7');
    return $this->db->get();
  }

  function daftarPengumumanDosen()
  {
    $this->db->select('*');
    $this->db->from('pengumuman');
    $this->db->where('tipePengumuman', 'Lecture');
    $this->db->order_by('tglPengumuman', 'desc');
    $this->db->limit('7');
    return $this->db->get();
  }

  function akunAsprak($nim)
  {
    return $this->db->get_where('users', array('nimAsprak' => $nim));
  }

  function jadwalMKAsprak($nim)
  {
    $this->db->select('jadwal_lab.id_jadwal_lab, concat(matakuliah.kode_mk, "\n", matakuliah.nama_mk, "\n", jadwal_lab.kelas, " / ", jadwal_lab.kode_dosen) title, jadwal_lab.jam_masuk start, jadwal_lab.jam_selesai end, jadwal_lab.hari_ke');
    $this->db->from('jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->join('daftar_mk', 'matakuliah.kode_mk = daftar_mk.kode_mk');
    $this->db->join('daftarasprak', 'daftar_mk.id_daftar_mk = daftarasprak.id_daftar_mk');
    $this->db->where('daftarasprak.nim_asprak', $nim);
    $this->db->where('jadwal_lab.id_jadwal_lab not in (select jadwal_lab.id_jadwal_lab from jadwal_asprak join jadwal_lab on jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab where jadwal_asprak.nim_asprak = ' . $nim . ')');
    return $this->db->get();
  }

  function jadwalAsprak($nim)
  {
    // $this->db->select('jadwal_asprak.nim_asprak, concat(matakuliah.kode_mk, "\n", matakuliah.nama_mk, "\n", jadwal_lab.kelas, " / ", jadwal_lab.kode_dosen, "\n", laboratorium.namaLab, " Laboratory (", laboratorium.kodeRuang, ")") title, jadwal_lab.jam_masuk start, jadwal_lab.jam_selesai end, jadwal_lab.hari_ke');
    // $this->db->from('jadwal_asprak');
    // $this->db->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    // $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    // $this->db->join('laboratorium', 'jadwal_lab.id_lab = laboratorium.idLab');
    // $this->db->where('jadwal_asprak.nim_asprak', $nim);
    $this->db->select('jadwal_asprak.nim_asprak, jadwal_lab.id_jadwal_lab, concat(matakuliah.kode_mk, "\n", matakuliah.nama_mk, "\n", jadwal_lab.kelas, " / ", jadwal_lab.kode_dosen) title, jadwal_lab.jam_masuk start, jadwal_lab.jam_selesai end, jadwal_lab.hari_ke');
    $this->db->from('jadwal_asprak');
    $this->db->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->where('jadwal_asprak.nim_asprak', $nim);
    return $this->db->get();
  }

  function jadwalPresensiAsprak($nim)
  {
    $this->db->select('jadwal_asprak.id_jadwal_asprak, jadwal_lab.id_jadwal_lab, matakuliah.kode_mk, matakuliah.nama_mk, jadwal_lab.hari_ke, date_format(jadwal_lab.jam_masuk, "%H:%i") masuk, date_format(jadwal_lab.jam_selesai, "%H:%i") selesai');
    $this->db->from('jadwal_asprak');
    $this->db->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->where('jadwal_asprak.nim_asprak', $nim);
    $this->db->order_by('jadwal_lab.hari_ke', 'asc');
    return $this->db->get();
  }

  function daftarPresensiAsprak($nim)
  {
    $this->db->select('presensi_asprak.id_presensi_asprak, date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") selesai, presensi_asprak.modul, presensi_asprak.approve_absen, jadwal_lab.kelas, jadwal_lab.kode_dosen, matakuliah.nama_mk');
    $this->db->from('presensi_asprak');
    $this->db->join('jadwal_lab', 'presensi_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->where('nim_asprak', $nim);
    $this->db->order_by('approve_absen', 'asc');
    $this->db->order_by('asprak_masuk', 'desc');
    return $this->db->get();
  }

  function daftarPresensiAsprakPeriode($nim, $between)
  {
    $this->db->select('presensi_asprak.id_presensi_asprak, date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") selesai, presensi_asprak.modul, presensi_asprak.approve_absen, jadwal_lab.kelas, jadwal_lab.kode_dosen, matakuliah.nama_mk');
    $this->db->from('presensi_asprak');
    $this->db->join('jadwal_lab', 'presensi_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->where('nim_asprak', $nim);
    $this->db->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $between);
    $this->db->order_by('approve_absen', 'asc');
    $this->db->order_by('asprak_masuk', 'desc');
    return $this->db->get();
  }

  function dataPresensiAsprak($nim, $id)
  {
    $this->db->select('id_jadwal_asprak, date_format(asprak_masuk, "%m/%d/%Y") tanggal, date_format(asprak_masuk, "%H:%i") masuk, date_format(asprak_selesai, "%H:%i") selesai, modul, video');
    $this->db->from('presensi_asprak');
    $this->db->where('substring(sha1(id_presensi_asprak), 8, 7) = "' . $id . '"');
    $this->db->where('nim_asprak', $nim);
    return $this->db->get();
  }

  function daftarMKAsprak($nim)
  {
    $this->db->select('daftarasprak.id_daftar_mk, prodi.strata, prodi.kode_prodi, matakuliah.id_mk, matakuliah.kode_mk, matakuliah.nama_mk');
    $this->db->from('daftarasprak');
    $this->db->join('daftar_mk', 'daftarasprak.id_daftar_mk = daftar_mk.id_daftar_mk');
    $this->db->join('prodi', 'daftar_mk.kode_prodi = prodi.kode_prodi');
    $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk');
    $this->db->join('tahun_ajaran', 'daftar_mk.id_ta = tahun_ajaran.id_ta');
    $this->db->where('daftarasprak.nim_asprak', $nim);
    $this->db->where('tahun_ajaran.status', '1');
    $this->db->order_by('matakuliah.kode_mk', 'asc');
    return $this->db->get();
  }

  function daftarPeriode()
  {
    return $this->db->get_where('periode', array('asprak' => '1'));
  }

  function daftarHonorAsprak($nim)
  {
    $this->db->select('honor.id_honor, matakuliah.kode_mk, matakuliah.nama_mk, tahun_ajaran.ta, periode.bulan, date_format(honor.tanggal_submit, "%Y") tahun, honor.nominal, honor.status');
    $this->db->from('honor');
    $this->db->join('daftar_mk', 'honor.id_daftar_mk = daftar_mk.id_daftar_mk');
    $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk');
    $this->db->join('periode', 'honor.id_periode = periode.id_periode');
    $this->db->join('tahun_ajaran', 'daftar_mk.id_ta = tahun_ajaran.id_ta');
    $this->db->where('honor.nim_asprak', $nim);
    $this->db->where('honor.status', '0');
    $this->db->where('honor.approve_dosen', '1');
    $this->db->where('honor.no_pk is not null');
    $this->db->order_by('honor.id_honor', 'desc');
    return $this->db->get();
  }

  function daftarHonorAsprakDiambil($nim)
  {
    $this->db->select('honor.id_honor, matakuliah.kode_mk, matakuliah.nama_mk, tahun_ajaran.ta, periode.bulan, date_format(honor.tanggal_submit, "%Y") tahun, honor.nominal, honor.status, honor.opsi_pengambilan, honor.bukti_transfer');
    $this->db->from('honor');
    $this->db->join('daftar_mk', 'honor.id_daftar_mk = daftar_mk.id_daftar_mk');
    $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk');
    $this->db->join('periode', 'honor.id_periode = periode.id_periode');
    $this->db->join('tahun_ajaran', 'daftar_mk.id_ta = tahun_ajaran.id_ta');
    $this->db->where('honor.nim_asprak', $nim);
    $this->db->where('honor.status != 0');
    $this->db->where('honor.approve_dosen', '1');
    $this->db->order_by('honor.id_honor', 'desc');
    return $this->db->get();
  }

  function daftarLaporan($nim)
  {
    $this->db->select('laporan_praktikum.id_laporan_praktikum, laporan_praktikum.id_daftar_mk, date_format(laporan_praktikum.tanggal_upload, "%Y-%m-%d") tanggal, date_format(laporan_praktikum.tanggal_upload, "%H:%i:%s") jam, laporan_praktikum.catatan_revisi, laporan_praktikum.status_laporan, laporan_praktikum.nama_file, matakuliah.kode_mk, matakuliah.nama_mk');
    $this->db->from('laporan_praktikum');
    $this->db->join('daftar_mk', 'laporan_praktikum.id_daftar_mk = daftar_mk.id_daftar_mk');
    $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk');
    $this->db->where('laporan_praktikum.nim_asprak', $nim);
    return $this->db->get();
  }

  function daftarBank()
  {
    return $this->db->get('bank');
  }

  function cekPassword($username)
  {
    return $this->db->get_where('users', array('username' => $username));
  }
}
