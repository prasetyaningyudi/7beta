<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {
	private $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('auth');		
		$this->load->helper('url');			
		$this->load->database();
		$this->load->model('role_model');
		$this->load->model('menu_model');
		$this->data['menu'] = $this->menu_model->get_menu($this->session->userdata('ROLE_ID'));
		$this->data['sub_menu'] = $this->menu_model->get_sub_menu($this->session->userdata('ROLE_ID'));			
		$this->data['error'] = array();
		$this->data['title'] = 'Role';
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
		$r_nama = '';
		$r_status = '';

		//var_dump($_POST['nama']);
		if(isset($_POST['submit'])){
			if (isset($_POST['nama'])) {
				if ($_POST['nama'] != '' or $_POST['nama'] != null) {
					$filters[] = "ROLE_NAME LIKE '%" . $_POST['nama'] . "%'";
					$r_nama = $_POST['nama'];
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
		
		$data = $this->role_model->get($filters, $limit);
		$total_data = count($this->role_model->get($filters));
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
						(object) array( 'classes' => ' align-left ', 'value' => $value->ROLE_NAME ),
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
				(object) array ('colspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'role name'),			
				(object) array ('rowspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'status'),			
			)		
		);
			
		$fields = array();
		$fields[] = (object) array(
			'type' 			=> 'text',
			'label' 		=> 'Role name',
			'placeholder' 	=> 'Role name',
			'name' 			=> 'nama',
			'value' 		=> $r_nama,
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
			'deletable'	=> false,
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
			if($_POST['name'] == ''){
				$error_info[] = 'Role Name can not be null';
				$error_status = true;
			}
			
			$filters = array();
			$filters[] = "ROLE_NAME = '".$_POST['name']."'";
			$data = $this->role_model->get($filters);
			
			if(!empty($data)){
				$error_info[] = 'Role Name must be unique';
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
				$this->data['insert'] = array(
						'ROLE_NAME' => $_POST['name'],
					);
					
				//var_dump($this->data['insert']);die;
				$result = $this->role_model->insert($this->data['insert']);
				echo json_encode($result);				
			}
		}else{
			
			$fields = array();
			$fields[] = (object) array(
				'type' 			=> 'text',
				'label' 		=> 'Name',
				'name' 			=> 'name',
				'placeholder'	=> 'role name',
				'value' 		=> '',
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
			//validation
			$error_info = array();
			$error_status = false;
			if($_POST['name'] == ''){
				$error_info[] = 'Role Name can not be null';
				$error_status = true;
			}
			
			$filters = array();
			$filters[] = "ROLE_NAME = '".$_POST['name']."'";
			$data = $this->role_model->get($filters);
			
			if(!empty($data)){
				$error_info[] = 'Role Name must be unique';
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
				$this->data['update'] = array(
						'ROLE_NAME' => $_POST['name'],
					);
					
				//var_dump($this->data['insert']);die;
				$result = $this->role_model->update($this->data['update'], $_POST['id']);
				echo json_encode($result);			
			}			
		}else{
			$r_id = '';
			$r_nama = '';
			
			$filter = array();
			$filter[] = "ID = ". $_POST['id'];
			$this->data['result'] = $this->role_model->get($filter);
			//var_dump($this->data['result']);
			foreach($this->data['result'] as $value){
				$r_id 	= $value->ID;
				$r_nama = $value->ROLE_NAME;
			}
			
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
				'label' 		=> 'Name',
				'name' 			=> 'name',
				'placeholder'	=> 'role name',
				'value' 		=> $r_nama,
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
			
			$result = $this->role_model->get($filters);
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
				
			$result = $this->role_model->update($this->data['update'], $_POST['id']);
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
		$result = $this->role_model->delete($this->data['delete']);
		echo json_encode($result);		
	}
	
}

