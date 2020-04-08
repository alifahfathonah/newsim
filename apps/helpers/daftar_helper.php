<?php
defined('BASEPATH') or exit('No direct script access allowed');

function view($page, $variable = array(), $output = false)
{
  $CI = &get_instance();
  return $CI->load->view($page, $variable, $output);
}

function set_rules($name_field, $name, $mode)
{
  $ci = &get_instance();
  return $ci->form_validation->set_rules($name_field, $name, $mode);
}

function validation_run()
{
  $ci = &get_instance();
  return $ci->form_validation->run();
}

function set_flashdata($name, $message)
{
  $ci = &get_instance();
  return $ci->session->set_flashdata($name, $message);
}

function flashdata($name)
{
  $ci = &get_instance();
  return $ci->session->flashdata($name);
}

function input($input)
{
  $ci = &get_instance();
  return $ci->input->post($input, true);
}

function get($input)
{
  $ci = &get_instance();
  return $ci->input->get($input, true);
}

function set_userdata($session)
{
  $ci = &get_instance();
  return $ci->session->set_userdata($session);
}

function userdata($session)
{
  $ci = &get_instance();
  return $ci->session->userdata($session);
}

function uri($segment)
{
  $ci = &get_instance();
  return $ci->uri->segment($segment);
}

if (!function_exists('tanggal_inggris')) {
  function tanggal_inggris($tanggal)
  {
    $nama_hari      = date('l', strtotime($tanggal));
    $pecah_tanggal  = explode('-', $tanggal);
    $tanggal        = $pecah_tanggal[2];
    $bulan          = bulanPendek($pecah_tanggal[1]);
    $tahun          = $pecah_tanggal[0];
    return $nama_hari . ', ' . $tanggal . ' ' . $bulan . ' ' . $tahun;
  }
}

if (!function_exists('tanggalInggris')) {
  function tanggalInggris($tanggal)
  {
    $nama_hari      = date('l', strtotime($tanggal));
    $pecah_tanggal  = explode('-', $tanggal);
    $tanggal        = $pecah_tanggal[2];
    $bulan          = bulanPanjang($pecah_tanggal[1]);
    $tahun          = $pecah_tanggal[0];
    return $nama_hari . ', ' . $tanggal . ' ' . $bulan . ' ' . $tahun;
  }
}

if (!function_exists('bulanPendek')) {
  function bulanPendek($bulan)
  {
    switch ($bulan) {
      case 1:
        return 'Jan';
        break;
      case 2:
        return 'Feb';
        break;
      case 3:
        return 'Mar';
        break;
      case 4:
        return 'Apr';
        break;
      case 5:
        return 'May';
        break;
      case 6:
        return 'Jun';
        break;
      case 7:
        return 'Jul';
        break;
      case 8:
        return 'Aug';
        break;
      case 9:
        return 'Sep';
        break;
      case 10:
        return 'Oct';
        break;
      case 11:
        return 'Nov';
        break;
      case 12:
        return 'Dec';
        break;
    }
  }
}

if (!function_exists('bulanPanjang')) {
  function bulanPanjang($bulan)
  {
    switch ($bulan) {
      case 1:
        return 'January';
        break;
      case 2:
        return 'February';
        break;
      case 3:
        return 'March';
        break;
      case 4:
        return 'April';
        break;
      case 5:
        return 'May';
        break;
      case 6:
        return 'June';
        break;
      case 7:
        return 'July';
        break;
      case 8:
        return 'August';
        break;
      case 9:
        return 'September';
        break;
      case 10:
        return 'October';
        break;
      case 11:
        return 'November';
        break;
      case 12:
        return 'December';
        break;
    }
  }
}
