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

  function cekNIM($nim)
  {
    $this->db->select('count(nim_asprak) jumlah');
    $this->db->from('daftarasprak');
    $this->db->where('nim_asprak', $nim);
    return $this->db->get();
  }

  function registerAsprak($nim)
  {
    $this->db->select('count(nimAsprak) jumlah');
    $this->db->from('users');
    $this->db->where('nimAsprak', $nim);
    return $this->db->get();
  }

  function cekUsername($username)
  {
    $this->db->select('count(username) jumlah');
    $this->db->from('users');
    $this->db->where('username', $username);
    return $this->db->get();
  }

  function cekEmail($email)
  {
    $this->db->select('count(email) jumlah');
    $this->db->from('users');
    $this->db->where('email', $email);
    return $this->db->get();
  }

  function daftarStaffLaboran()
  {
    $this->db->select('laboran.id_laboran, laboran.nip_laboran');
    $this->db->from('laboran');
    $this->db->join('users', 'laboran.id_laboran = users.id_laboran', 'left outer');
    $this->db->where('users.id_laboran', null);
    $this->db->order_by('laboran.nip_laboran', 'asc');
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
    $this->db->select('asprak.nim_asprak');
    $this->db->from('asprak');
    $this->db->join('users', 'asprak.nim_asprak = users.nimAsprak', 'left outer');
    $this->db->where('users.nimAsprak', null);
    $this->db->order_by('asprak.nim_asprak', 'asc');
    return $this->db->get();
  }
}
