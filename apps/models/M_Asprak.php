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

  function akunAsprak($nim)
  {
    return $this->db->get_where('users', array('nimAsprak' => $nim));
  }

  function jadwalAsprak($nim)
  {
    // $this->db->select('jadwal_asprak.nim_asprak, concat(matakuliah.kode_mk, "\n", matakuliah.nama_mk, "\n", jadwal_lab.kelas, " / ", jadwal_lab.kode_dosen, "\n", laboratorium.namaLab, " Laboratory (", laboratorium.kodeRuang, ")") title, jadwal_lab.jam_masuk start, jadwal_lab.jam_selesai end, jadwal_lab.hari_ke');
    // $this->db->from('jadwal_asprak');
    // $this->db->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    // $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    // $this->db->join('laboratorium', 'jadwal_lab.id_lab = laboratorium.idLab');
    // $this->db->where('jadwal_asprak.nim_asprak', $nim);
    $this->db->select('jadwal_asprak.nim_asprak, concat(matakuliah.kode_mk, "\n", matakuliah.nama_mk, "\n", jadwal_lab.kelas, " / ", jadwal_lab.kode_dosen) title, jadwal_lab.jam_masuk start, jadwal_lab.jam_selesai end, jadwal_lab.hari_ke');
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
    $this->db->select('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") selesai, presensi_asprak.modul, jadwal_lab.kelas, matakuliah.nama_mk');
    $this->db->from('presensi_asprak');
    $this->db->join('jadwal_lab', 'presensi_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->where('nim_asprak', $nim);
    $this->db->order_by('asprak_masuk', 'desc');
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

  function daftarBank()
  {
    return $this->db->get('bank');
  }

  function cekPassword($username)
  {
    return $this->db->get_where('users', array('username' => $username));
  }
}
