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
    $this->db->select('jadwal_asprak.nim_asprak, concat(matakuliah.kode_mk, "\n", matakuliah.nama_mk, "\n", jadwal_lab.kelas, " / ", jadwal_lab.kode_dosen, "\n", laboratorium.namaLab, " Laboratory (", laboratorium.kodeRuang, ")") title, jadwal_lab.jam_masuk start, jadwal_lab.jam_selesai end, jadwal_lab.hari_ke');
    $this->db->from('jadwal_asprak');
    $this->db->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->join('laboratorium', 'jadwal_lab.id_lab = laboratorium.idLab');
    $this->db->where('jadwal_asprak.nim_asprak', $nim);
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
