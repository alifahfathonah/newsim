<?php

class M_Laboran extends CI_Model
{

  function insertData($tabel, $data)
  {
    $this->db->insert($tabel, $data);
  }

  function updateData($tabel, $data, $where, $nilai)
  {
    $this->db->where($where, $nilai);
    $this->db->update($tabel, $data);
  }

  function deleteData($tabel, $where, $nilai)
  {
    $this->db->where($where, $nilai);
    $this->db->delete($tabel);
  }

  function grafikKomplain()
  {
    $this->db->select('date_format(tglKomplain, "%b") bulan, count(idKomplain) jumlah');
    $this->db->from('komplain');
    $this->db->where('year(tglKomplain) = year(curdate())');
    $this->db->group_by('date_format(tglKomplain, "%b")');
    $this->db->order_by('tglKomplain', 'asc');
    return $this->db->get();
  }

  function daftarPengumuman()
  {
    $this->db->select('*');
    $this->db->from('pengumuman');
    $this->db->order_by('tglPengumuman', 'desc');
    $this->db->limit('7');
    return $this->db->get();
  }
}
