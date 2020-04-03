<?php

class M_Laboran extends CI_Model
{

  function jadwalLab()
  {
    $this->db->select('concat(matakuliah.kode_mk, " | ", matakuliah.nama_mk, " | ", jadwal_lab.kelas, " / ", jadwal_lab.kode_dosen) title, jadwal_lab.jam_masuk start, jadwal_lab.jam_selesai end, jadwal_lab.hari_ke, prodi.color');
    $this->db->from('jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->join('prodi', 'jadwal_lab.id_prodi = prodi.id_prodi');
    return $this->db->get();
  }

  function jadwalPerLab($id)
  {
    $this->db->select('concat(matakuliah.kode_mk, " | ", matakuliah.nama_mk, " | ", jadwal_lab.kelas, " / ", jadwal_lab.kode_dosen) title, jadwal_lab.jam_masuk start, jadwal_lab.jam_selesai end, jadwal_lab.hari_ke, prodi.color');
    $this->db->from('jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->join('prodi', 'jadwal_lab.id_prodi = prodi.id_prodi');
    $this->db->where('substring(sha1(jadwal_lab.id_lab), 7, 4) = "' . $id . '"');
    return $this->db->get();
  }
}
