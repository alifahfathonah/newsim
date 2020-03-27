<?php
defined('BASEPATH') or exit('No direct script access allowed');

function view($page, $variable = array(), $output = false)
{
  $CI = &get_instance();
  return $CI->load->view($page, $variable, $output);
}


function set_validation($name_field, $name, $mode)
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
