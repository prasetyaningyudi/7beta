<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	private $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->library('session');	
		$this->load->library('auth');		
		$this->load->helper('url');			
		$this->load->database();
		$this->load->model('user_model');
		$this->load->model('role_model');
		$this->load->model('menu_model');
		$this->data['menu'] = $this->menu_model->get_menu();
		$this->data['sub_menu'] = $this->menu_model->get_sub_menu();		
		$this->data['error'] = array();
		$this->data['title'] = 'Home';
	}

	public function index(){	
		$this->data['subtitle'] = 'List';
		$this->data['class'] = __CLASS__;
		$this->load->view('section_header', $this->data);
		$this->load->view('section_nav');
		$this->load->view('main_index');	
		$this->load->view('section_footer');
	}
	
	public function delete(){
		if($this->auth->getPermission($this->session->userdata('ROLE_NAME'), __CLASS__ , __FUNCTION__ ) == false){
			redirect ('home');
		}

	}
	
}

