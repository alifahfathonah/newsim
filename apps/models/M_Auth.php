<?php

class M_Auth extends CI_Model
{

  function insertData($tabel, $input)
  {
    $this->db->insert($tabel, $input);
  }

  function cekUser($where)
  {
    return $this->db->get_where('users', $where);
  }

  function cekUsername($username)
  {
    $this->db->select('count(username) jumlah');
    $this->db->from('users');
    $this->db->where('username', $username);
    return $this->db->get();
  }

  function daftarAslab($periode)
  {
    $this->db->select('aslab.idAslab, aslab.nim, aslab.namaLengkap');
    $this->db->from('aslab');
    $this->db->join('users', 'aslab.idAslab = users.idAslab', 'left outer');
    $this->db->where('users.idAslab', null);
    $this->db->where('aslab.tahunAjaran', $periode);
    $this->db->order_by('aslab.namaLengkap', 'asc');
    return $this->db->get();
  }

  function daftarAsprak()
  {
    $this->db->select('asprak.nim');
    $this->db->from('asprak');
    $this->db->join('users', 'asprak.nim = users.nimAsprak', 'left outer');
    $this->db->where('users.nimAsprak', null);
    $this->db->order_by('asprak.nim', 'asc');
    return $this->db->get();
  }
}
