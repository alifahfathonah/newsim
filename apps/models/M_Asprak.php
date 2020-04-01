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

  function akunAsprak($nim)
  {
    return $this->db->get_where('users', array('nimAsprak' => $nim));
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
