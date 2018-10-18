<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {
	private $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->library('session');		
		$this->load->helper('url');			
		$this->load->database();
		//$this->load->model('pegawai_model');
		$this->data['error'] = array();
		$this->data['title'] = 'Authentication';	
	}
	
	public function login(){
		$this->data['subtitle'] = 'Login';
		$this->data['class'] = __CLASS__;		
		$this->load->view('section_header', $this->data);
		$this->load->view('login');
	}
}
