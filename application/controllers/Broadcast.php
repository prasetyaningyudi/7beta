<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Broadcast extends CI_Controller {
	private $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('auth');		
		$this->load->helper('url');			
		$this->load->database();
		$this->load->model('broadcast_model');
		$this->load->model('menu_model');
		$this->data['menu'] = $this->menu_model->get_menu($this->session->userdata('ROLE_ID'));
		$this->data['sub_menu'] = $this->menu_model->get_sub_menu($this->session->userdata('ROLE_ID'));			
		$this->data['error'] = array();
		$this->data['title'] = 'Broadcast';
	}

	public function index(){
		if($this->auth->get_permission($this->session->userdata('ROLE_NAME'), __CLASS__ , __FUNCTION__ ) == false){
			redirect ('authentication/unauthorized');
		}			
		$this->data['subtitle'] = 'List';
		$this->data['class'] = __CLASS__;
		$this->load->view('section_header', $this->data);
		$this->load->view('section_nav');
		$this->load->view('main_index');	
		$this->load->view('section_footer');			
	}
	
	public function list(){
		if($this->auth->get_permission($this->session->userdata('ROLE_NAME'), __CLASS__ , __FUNCTION__ ) == false){
			redirect ('authentication/unauthorized');
		}				
		$filters = array();
		$limit = array('10', '0');
		$r_title = '';
		$r_body = '';
		$r_status = '';
		$r_credential = '';

		//var_dump($_POST['nama']);
		if(isset($_POST['submit'])){
			if (isset($_POST['title'])) {
				if ($_POST['title'] != '' or $_POST['title'] != null) {
					$filters[] = "TITLE LIKE '%" . $_POST['title'] . "%'";
					$r_title = $_POST['title'];
				}
			}
			if (isset($_POST['body'])) {
				if ($_POST['body'] != '' or $_POST['body'] != null) {
					$filters[] = "BODY LIKE '%" . $_POST['body'] . "%'";
					$r_body = $_POST['body'];
				}
			}	
			if (isset($_POST['credential'])) {
				if ($_POST['credential'] != '' or $_POST['credential'] != null) {
					$filters[] = "CREDENTIAL = '" . $_POST['credential'] . "'";
					$r_credential = $_POST['credential'];
				}
			}			
			if (isset($_POST['status'])) {
				if ($_POST['status'] != '' or $_POST['status'] != null) {
					$filters[] = "STATUS = '" . $_POST['status'] . "'";
					$r_status = $_POST['status'];
				}
			}
			if (isset($_POST['offset'])) {
				if ($_POST['offset'] != '' or $_POST['offset'] != null) {
					$limit[1] = $_POST['offset'];
				}
			}			
		}
		
		$data = $this->broadcast_model->get($filters, $limit);
		$total_data = count($this->broadcast_model->get($filters));
		$limit[] = $total_data;

		$no_body = 0;
		$body= array();
		if(isset($data)){
            if (empty($data)) {
                $body[$no_body] = array(
                    (object) array ('colspan' => 100, 'classes' => ' empty bold align-center', 'value' => 'No Data')
                );
			} else {
				foreach ($data as $value) {
					$body[$no_body] = array(
						(object) array( 'classes' => ' hidden ', 'value' => $value->ID ),
						(object) array( 'classes' => ' bold align-left ', 'value' => $no_body+1 ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->TITLE ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->BODY ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->TYPE ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->CREDENTIAL ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->STATUS ),
					);
					$no_body++;
				}
			}
        } else {
            $body[$no_body] = array(
                (object) array ('colspan' => 100, 'classes' => ' empty bold align-center', 'value' => 'Filter First')
            );
        }
		
		$header = array(
			array (
				(object) array ('rowspan' => 1, 'classes' => 'bold align-left capitalize', 'value' => 'No'),
				(object) array ('colspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'Title'),			
				(object) array ('colspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'Body'),			
				(object) array ('colspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'Type'),			
				(object) array ('colspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'Credential'),			
				(object) array ('rowspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'status'),		
			)		
		);
			
		$credential = array();
		$credential[] = (object) array('label'=>'all', 'value'=>'all');
		$credential[] = (object) array('label'=>'user', 'value'=>'user');
		$credential[] = (object) array('label'=>'guest', 'value'=>'guest');			
			
		$fields = array();
		$fields[] = (object) array(
			'type' 			=> 'text',
			'label' 		=> 'Title',
			'placeholder' 	=> 'Input Title like',
			'name' 			=> 'title',
			'value' 		=> $r_title,
			'classes' 		=> '',
		);
		$fields[] = (object) array(
			'type' 			=> 'textarea',
			'label' 		=> 'Body',
			'placeholder' 	=> 'Input body like',
			'name' 			=> 'body',
			'value' 		=> $r_body,
			'classes' 		=> '',
		);	
		$fields[] = (object) array(
			'type' 			=> 'select',
			'label' 		=> 'Credential',
			'placeholder' 	=> '--Select Credential--',
			'name' 			=> 'credential',
			'value' 		=> $r_credential,
			'options' 		=> $credential,
			'classes' 		=> '',
		);			
		$fields[] = (object) array(
			'type' 			=> 'text',
			'label' 		=> 'Status',
			'name' 			=> 'status',
			'placeholder'	=> 'Input status',
			'value' 		=> $r_status,
			'classes' 		=> '',
		);		
	

		$this->data['list'] = (object) array (
			'type'  	=> 'table',
			'insertable'=> true,
			'editable'	=> true,
			'deletable'	=> true,
			'statusable'=> true,
			'classes'  	=> 'striped bordered hover',
			'pagination'=> $limit,
			'filters'  	=> $fields,
			'header'  	=> $header,
			'body'  	=> $body,
			'footer'  	=> null,
		);		
		echo json_encode($this->data['list']);
	}
	
	public function insert(){
		if($this->auth->get_permission($this->session->userdata('ROLE_NAME'), __CLASS__ , __FUNCTION__ ) == false){
			redirect ('authentication/unauthorized');
		}				
		if(isset($_POST['submit'])){
			//validation
			$error_info = array();
			$error_status = false;
			if($_POST['title'] == ''){
				$error_info[] = 'Title can not be null';
				$error_status = true;
			}			
			if($_POST['body'] == ''){
				$error_info[] = 'Body can not be null';
				$error_status = true;
			}
			if(strlen($_POST['body']) > 1000){
				$error_info[] = 'Body content too long, more than 1000 characters';
				$error_status = true;
			}
			if($_POST['credential'] == ''){
				$error_info[] = 'Credential can not be null';
				$error_status = true;
			}
			
			if($error_status == true){
				$this->data['error'] = (object) array (
					'type'  	=> 'error',
					'status'	=> $error_status,
					'info'	=> $error_info,
				);				
				echo json_encode($this->data['error']);
			}else{
				if($_POST['types'] == ''){
					$this->data['insert'] = array(
						'TITLE' => $_POST['title'],
						'BODY' => $_POST['body'],
						'CREDENTIAL' => $_POST['credential'],
						'USER_ID' => $this->session->userdata('ID'),
					);
				}else{
					$this->data['insert'] = array(
						'TITLE' => $_POST['title'],
						'BODY' => $_POST['body'],
						'CREDENTIAL' => $_POST['credential'],
						'TYPE' => $_POST['types'],
						'USER_ID' => $this->session->userdata('ID'),
					);
				}
				//var_dump($this->data['insert']);die;
				$result = $this->broadcast_model->insert($this->data['insert']);
				echo json_encode($result);				
			}
		}else{
			$types = array();
			$types[] = (object) array('label'=>'primary', 'value'=>'primary');
			$types[] = (object) array('label'=>'secondary', 'value'=>'secondary');
			$types[] = (object) array('label'=>'success', 'value'=>'success');
			$types[] = (object) array('label'=>'danger', 'value'=>'danger');
			$types[] = (object) array('label'=>'warning', 'value'=>'warning');
			$types[] = (object) array('label'=>'info', 'value'=>'info');
			$types[] = (object) array('label'=>'light', 'value'=>'light');
			$types[] = (object) array('label'=>'dark', 'value'=>'dark');
			
			$credential = array();
			$credential[] = (object) array('label'=>'all', 'value'=>'all');
			$credential[] = (object) array('label'=>'user', 'value'=>'user');
			$credential[] = (object) array('label'=>'guest', 'value'=>'guest');
			
			$fields = array();
			$fields[] = (object) array(
				'type' 			=> 'text',
				'label' 		=> 'Title',
				'placeholder' 	=> 'Input Title like',
				'name' 			=> 'title',
				'value' 		=> '',
				'classes' 		=> '',
			);
			$fields[] = (object) array(
				'type' 			=> 'textarea',
				'label' 		=> 'Body',
				'placeholder' 	=> 'Input body like',
				'name' 			=> 'body',
				'value' 		=> '',
				'classes' 		=> '',
			);			
			$fields[] = (object) array(
				'type' 			=> 'select',
				'label' 		=> 'Type',
				'placeholder' 	=> '--Select Type--',
				'name' 			=> 'types',
				'value' 		=> '',
				'options' 		=> $types,
				'classes' 		=> '',
			);	
			$fields[] = (object) array(
				'type' 			=> 'select',
				'label' 		=> 'Credential',
				'placeholder' 	=> '--Select Credential--',
				'name' 			=> 'credential',
				'value' 		=> '',
				'options' 		=> $credential,
				'classes' 		=> '',
			);				
			$this->data['insert'] = (object) array (
				'type'  	=> 'modal',
				'classes'  	=> '',
				'fields'  	=> $fields,
			);	
			echo json_encode($this->data['insert']);				
		}
	}
	
	public function update(){
		if($this->auth->get_permission($this->session->userdata('ROLE_NAME'), __CLASS__ , __FUNCTION__ ) == false){
			redirect ('authentication/unauthorized');
		}				
		if(isset($_POST['submit'])){
			$error_info = array();
			$error_status = false;
			if($_POST['title'] == ''){
				$error_info[] = 'Title can not be null';
				$error_status = true;
			}			
			if($_POST['body'] == ''){
				$error_info[] = 'Body can not be null';
				$error_status = true;
			}
			if(strlen($_POST['body']) > 1000){
				$error_info[] = 'Body content too long, more than 1000 characters';
				$error_status = true;
			}
			if($_POST['credential'] == ''){
				$error_info[] = 'Credential can not be null';
				$error_status = true;
			}
			
			if($error_status == true){
				$this->data['error'] = (object) array (
					'type'  	=> 'error',
					'status'	=> $error_status,
					'info'	=> $error_info,
				);				
				echo json_encode($this->data['error']);
			}else{
				if($_POST['types'] == ''){
					$this->data['update'] = array(
						'TITLE' => $_POST['title'],
						'BODY' => $_POST['body'],
						'CREDENTIAL' => $_POST['credential'],
						'USER_ID' => $this->session->userdata('ID'),
					);
				}else{
					$this->data['update'] = array(
						'TITLE' => $_POST['title'],
						'BODY' => $_POST['body'],
						'CREDENTIAL' => $_POST['credential'],
						'TYPE' => $_POST['types'],
						'USER_ID' => $this->session->userdata('ID'),
					);
				}
					
				//var_dump($this->data['insert']);die;
				$result = $this->broadcast_model->update($this->data['update'], $_POST['id']);
				echo json_encode($result);			
			}			
		}else{
			$r_id = '';
			$r_title = '';
			$r_body = '';
			$r_types = '';
			$r_credential = '';
			
			$filter = array();
			$filter[] = "ID = ". $_POST['id'];
			$this->data['result'] = $this->broadcast_model->get($filter);
			//var_dump($this->data['result']);
			foreach($this->data['result'] as $value){
				$r_id 	= $value->ID;
				$r_title = $value->TITLE;
				$r_body = $value->BODY;
				$r_types = $value->TYPE;
				$r_credential = $value->CREDENTIAL;
			}
			
			$types = array();
			$types[] = (object) array('label'=>'primary', 'value'=>'primary');
			$types[] = (object) array('label'=>'secondary', 'value'=>'secondary');
			$types[] = (object) array('label'=>'success', 'value'=>'success');
			$types[] = (object) array('label'=>'danger', 'value'=>'danger');
			$types[] = (object) array('label'=>'warning', 'value'=>'warning');
			$types[] = (object) array('label'=>'info', 'value'=>'info');
			$types[] = (object) array('label'=>'light', 'value'=>'light');
			$types[] = (object) array('label'=>'dark', 'value'=>'dark');

			$credential = array();
			$credential[] = (object) array('label'=>'all', 'value'=>'all');
			$credential[] = (object) array('label'=>'user', 'value'=>'user');
			$credential[] = (object) array('label'=>'guest', 'value'=>'guest');			
			
			$fields = array();
			$fields[] = (object) array(
				'type' 		=> 'hidden',
				'label' 	=> 'id',
				'name' 		=> 'id',
				'value' 	=> $r_id,
				'classes' 	=> '',
			);			
			$fields[] = (object) array(
				'type' 			=> 'text',
				'label' 		=> 'Title',
				'placeholder' 	=> 'Input Title like',
				'name' 			=> 'title',
				'value' 		=> $r_title,
				'classes' 		=> '',
			);
			$fields[] = (object) array(
				'type' 			=> 'textarea',
				'label' 		=> 'Body',
				'placeholder' 	=> 'Input body like',
				'name' 			=> 'body',
				'value' 		=> $r_body,
				'classes' 		=> '',
			);			
			$fields[] = (object) array(
				'type' 			=> 'select',
				'label' 		=> 'Type',
				'placeholder' 	=> '--Select Type--',
				'name' 			=> 'types',
				'value' 		=> $r_types,
				'options' 		=> $types,
				'classes' 		=> '',
			);	
			$fields[] = (object) array(
				'type' 			=> 'select',
				'label' 		=> 'Credential',
				'placeholder' 	=> '--Select Credential--',
				'name' 			=> 'credential',
				'value' 		=> $r_credential,
				'options' 		=> $credential,
				'classes' 		=> '',
			);	
			
			$this->data['insert'] = (object) array (
				'type'  	=> 'modal',
				'classes'  	=> '',
				'fields'  	=> $fields,
			);	
			echo json_encode($this->data['insert']);
		}
	}
	
	public function update_status(){
		if($this->auth->get_permission($this->session->userdata('ROLE_NAME'), __CLASS__ , __FUNCTION__ ) == false){
			redirect ('authentication/unauthorized');
		}		
		if(isset($_POST['id']) and $_POST['id'] != null){
			$filters = array();
			$filters[] = "ID = ". $_POST['id'];
			
			$result = $this->broadcast_model->get($filters);
			if($result != null){
				foreach($result as $item){
					$status = $item->STATUS;
				}
				if($status == '1'){
					$new_status = '0';
				}else if($status == '0'){
					$new_status = '1';
				}
			}
			
			$this->data['update'] = array(
					'STATUS' => $new_status,
				);	
				
			$result = $this->broadcast_model->update($this->data['update'], $_POST['id']);
			echo json_encode($result);	
		}
	}
	
	public function delete(){
		if($this->auth->get_permission($this->session->userdata('ROLE_NAME'), __CLASS__ , __FUNCTION__ ) == false){
			redirect ('authentication/unauthorized');
		}				
		$this->data['delete'] = array(
				'ID' => $_POST['id'],
			);		
		$result = $this->broadcast_model->delete($this->data['delete']);
		echo json_encode($result);		
	}
	
}

