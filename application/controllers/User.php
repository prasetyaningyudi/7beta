<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
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
		$this->data['menu'] = $this->menu_model->get_menu($this->session->userdata('ROLE_ID'));
		$this->data['sub_menu'] = $this->menu_model->get_sub_menu($this->session->userdata('ROLE_ID'));		
		$this->data['error'] = array();
		$this->data['title'] = 'User';
	}

	public function index(){
		var_dump($this->auth->get_permission($this->session->userdata('ROLE_NAME'), __CLASS__ , __FUNCTION__ ));
/* 		if($this->auth->getPermission($this->session->userdata('ROLE_NAME'), __CLASS__ , __FUNCTION__ ) == false){
			redirect ('home');
		} */
		$this->data['subtitle'] = 'List';
		$this->data['class'] = __CLASS__;
		$this->load->view('section_header', $this->data);
		$this->load->view('section_nav');
		$this->load->view('main_index');	
		$this->load->view('section_footer');			
	}
	
	public function list(){
		if($this->auth->get_permission($this->session->userdata('ROLE_NAME'), __CLASS__ , __FUNCTION__ ) == false){
			redirect ('home');
		}
		$filters = array();
		$limit = array('10', '0');
		$r_username = '';
		$r_role = '';
		$r_alias = '';
		$r_status = '';

		//var_dump($_POST['nama']);
		if(isset($_POST['submit'])){
			if (isset($_POST['username'])) {
				if ($_POST['username'] != '' or $_POST['username'] != null) {
					$filters[] = "A.USERNAME LIKE '%" . $_POST['username'] . "%'";
					$r_username = $_POST['username'];
				}
			}			
			if (isset($_POST['alias'])) {
				if ($_POST['alias'] != '' or $_POST['alias'] != null) {
					$filters[] = "A.USER_ALIAS LIKE '%" . $_POST['alias'] . "%'";
					$r_alias = $_POST['alias'];
				}
			}
			if (isset($_POST['role'])) {
				if ($_POST['role'] != '' or $_POST['role'] != null) {
					$filters[] = "A.ROLE_ID = '" . $_POST['role'] . "'";
					$r_role = $_POST['role'];
				}
			}
			if (isset($_POST['status'])) {
				if ($_POST['status'] != '' or $_POST['status'] != null) {
					$filters[] = "A.STATUS = '" . $_POST['status'] . "'";
					$r_status = $_POST['status'];
				}
			}
			if (isset($_POST['offset'])) {
				if ($_POST['offset'] != '' or $_POST['offset'] != null) {
					$limit[1] = $_POST['offset'];
				}
			}			
		}
		
		$data = $this->user_model->get($filters, $limit);
		$total_data = count($this->user_model->get($filters));
		$limit[] = $total_data;
		
		//var_dump($data);

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
						(object) array( 'classes' => ' align-left ', 'value' => $value->USERNAME ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->USER_ALIAS ),
						(object) array( 'classes' => ' align-center ', 'value' => $value->STATUS ),
						(object) array( 'classes' => ' align-center ', 'value' => $value->ROLE_NAME ),
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
				(object) array ('colspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'username'),					
				(object) array ('rowspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'user alias'),						
				(object) array ('rowspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'status'),			
				(object) array ('rowspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'role'),			
			)		
		);

		$role = array();
		$filter = array();
		$filter[] = "STATUS ='1'";
		$data = $this->role_model->get();
		
		if (empty($data)) {
			//$parent[] = (object) array('label'=>'No Data', 'value'=>'nodata');
		} else {
			foreach ($data as $value) {
				$role[] = (object) array('label'=>$value->ROLE_NAME, 'value'=>$value->ID);
			}
		}	
			
		$fields = array();
		$fields[] = (object) array(
			'type' 			=> 'text',
			'label' 		=> 'Username',
			'placeholder' 	=> 'username',
			'name' 			=> 'username',
			'value' 		=> $r_username,
			'classes' 		=> '',
		);
		$fields[] = (object) array(
			'type' 			=> 'text',
			'label' 		=> 'Alias',
			'placeholder' 	=> 'user alias',
			'name' 			=> 'alias',
			'value' 		=> $r_alias,
			'classes' 		=> '',
		);	
		$fields[] = (object) array(
			'type' 			=> 'text',
			'label' 		=> 'Status',
			'placeholder' 	=> 'user status',
			'name' 			=> 'status',
			'value' 		=> $r_status,
			'classes' 		=> '',
		);			
		$fields[] = (object) array(
			'type' 			=> 'select',
			'label' 		=> 'Role',
			'name' 			=> 'role',
			'placeholder'	=> '--Select Role--',
			'value' 		=> $r_role,
			'options'		=> $role,
			'classes' 		=> '',
		);			
	

		$this->data['list'] = (object) array (
			'type'  	=> 'table',
			'insertable'=> true,
			'editable'	=> true,
			'deletable'	=> true,
			'statusable'=> false,
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
			redirect ('home');
		}		
		if(isset($_POST['submit'])){
			//validation
			$error_info = array();
			$error_status = false;
			if($_POST['username'] == ''){
				$error_info[] = 'Username can not be null';
				$error_status = true;
			}
			if ( preg_match('/\s/', $_POST['username']) )	{
				$error_info[] = 'Username can not contain whitespace';
				$error_status = true;
			}	
			if(strlen ($_POST['username']) < 5){
				$error_info[] = 'Username minimum 5 character';
				$error_status = true;
			}		

			$filter = array();
			$filter[] = "A.USERNAME = '". $_POST['username']."'";
			$data = $this->user_model->get($filter);
			if(!empty($data)){
				$error_info[] = 'Username must be unique';
				$error_status = true;				
			}			
			if($_POST['password'] == ''){
				$error_info[] = 'Password can not be null';
				$error_status = true;
			}
			if ( preg_match('/\s/', $_POST['password']) )	{
				$error_info[] = 'Password can not contain whitespace';
				$error_status = true;
			}			
			if($_POST['password2'] == ''){
				$error_info[] = 'Password 2 can not be null';
				$error_status = true;
			}
			if($_POST['password'] != $_POST['password2']){
				$error_info[] = 'Field Password and Password 2 must be the same';
				$error_status = true;
			}
			if($_POST['role'] == ''){
				$error_info[] = 'Role can not be null';
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
				if($_POST['status'] != '' ){
					$this->data['insert'] = array(
							'USERNAME' => $_POST['username'],
							'PASSWORD' => md5($_POST['password']),
							'USER_ALIAS' => $_POST['alias'],
							'STATUS' => $_POST['status'],
							'ROLE_ID' => $_POST['role'],
						);
				}else{
					$this->data['insert'] = array(
							'USERNAME' => $_POST['username'],
							'PASSWORD' => md5($_POST['password']),
							'USER_ALIAS' => $_POST['alias'],
							'ROLE_ID' => $_POST['role'],
						);					
				}
				//var_dump($this->data['insert']);die;
				$result = $this->user_model->insert($this->data['insert']);
				echo json_encode($result);				
			}
		}else{
			$role = array();
			$filter = array();
			$filter[] = "STATUS ='1'";
			$data = $this->role_model->get($filter);
			
			if (empty($data)) {
				//$parent[] = (object) array('label'=>'No Data', 'value'=>'nodata');
			} else {
				foreach ($data as $value) {
					$role[] = (object) array('label'=>$value->ROLE_NAME, 'value'=>$value->ID);
				}
			}
			
			$status = array();
			$status[] = (object) array('label'=>'ACTIVE', 'value'=>'1');
			$status[] = (object) array('label'=>'INACTIVE', 'value'=>'0');
			$status[] = (object) array('label'=>'NOT CONFIRM', 'value'=>'5');
				
			$fields = array();
			$fields[] = (object) array(
				'type' 			=> 'text',
				'label' 		=> 'Username',
				'placeholder' 	=> 'username',
				'name' 			=> 'username',
				'value' 		=> '',
				'classes' 		=> '',
			);
			$fields[] = (object) array(
				'type' 			=> 'password',
				'label' 		=> 'Password',
				'placeholder' 	=> 'Password',
				'name' 			=> 'password',
				'value' 		=> '',
				'classes' 		=> '',
			);			
			$fields[] = (object) array(
				'type' 			=> 'password',
				'label' 		=> 'Password 2',
				'placeholder' 	=> 'Password 2',
				'name' 			=> 'password2',
				'value' 		=> '',
				'classes' 		=> '',
			);			
			$fields[] = (object) array(
				'type' 			=> 'text',
				'label' 		=> 'Alias',
				'placeholder' 	=> 'user alias',
				'name' 			=> 'alias',
				'value' 		=> '',
				'classes' 		=> '',
			);	
			$fields[] = (object) array(
				'type' 			=> 'select',
				'label' 		=> 'Status',
				'placeholder' 	=> '--Select status--',
				'name' 			=> 'status',
				'value' 		=> '',
				'options'		=> $status,
				'classes' 		=> '',
			);			
			$fields[] = (object) array(
				'type' 			=> 'select',
				'label' 		=> 'Role',
				'name' 			=> 'role',
				'placeholder'	=> '--Select Role--',
				'value' 		=> '',
				'options'		=> $role,
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
		if($this->auth->getPermission($this->session->userdata('ROLE_NAME'), __CLASS__ , __FUNCTION__ ) == false){
			
			redirect ('home');
		}		
		if(isset($_POST['submit'])){
			//validation
			$error_info = array();
			$error_status = false;
			if($_POST['username'] == ''){
				$error_info[] = 'Username can not be null';
				$error_status = true;
			}
			if ( preg_match('/\s/', $_POST['username']) )	{
				$error_info[] = 'Username can not contain whitespace';
				$error_status = true;
			}	
			if(strlen ($_POST['username']) < 5){
				$error_info[] = 'Username minimum 5 character';
				$error_status = true;
			}				
			if($_POST['password'] == ''){
				$error_info[] = 'Password can not be null';
				$error_status = true;
			}
			if ( preg_match('/\s/', $_POST['password']) )	{
				$error_info[] = 'Password can not contain whitespace';
				$error_status = true;
			}			
			if($_POST['password2'] == ''){
				$error_info[] = 'Password 2 can not be null';
				$error_status = true;
			}
			if($_POST['password'] != $_POST['password2']){
				$error_info[] = 'Field Password and Password 2 must be the same';
				$error_status = true;
			}
			if($_POST['role'] == ''){
				$error_info[] = 'Role can not be null';
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
				if($_POST['status'] != '' ){
					$this->data['update'] = array(
							'USERNAME' => $_POST['username'],
							'PASSWORD' => md5($_POST['password']),
							'USER_ALIAS' => $_POST['alias'],
							'STATUS' => $_POST['status'],
							'ROLE_ID' => $_POST['role'],
						);
				}else{
					$this->data['update'] = array(
							'USERNAME' => $_POST['username'],
							'PASSWORD' => md5($_POST['password']),
							'USER_ALIAS' => $_POST['alias'],
							'ROLE_ID' => $_POST['role'],
						);					
				}
				//var_dump($this->data['insert']);die;
				$result = $this->user_model->update($this->data['update'], $_POST['id']);
				echo json_encode($result);				
			}			
		}else{
			$r_username = '';
			$r_password = '';
			$r_password2 = '';
			$r_alias = '';
			$r_status = '';
			$r_role = '';
			
			$filter = array();
			$filter[] = "A.ID = ". $_POST['id'];
			$this->data['result'] = $this->user_model->get($filter);
			//var_dump($this->data['result']);
			foreach($this->data['result'] as $value){
				$r_id 	= $value->ID;
				$r_username = $value->USERNAME;
				$r_password = $value->PASSWORD;
				$r_password2 = $value->PASSWORD;
				$r_alias = $value->USER_ALIAS;
				$r_status = $value->STATUS;
				$r_role = $value->ROLE_ID;
			}
			
			$role = array();
			$filter = array();
			$filter[] = "STATUS ='1'";
			$data = $this->role_model->get($filter);
			
			if (empty($data)) {
				
			} else {
				foreach ($data as $value) {
					$role[] = (object) array('label'=>$value->ROLE_NAME, 'value'=>$value->ID);
				}
			}
			
			$status = array();
			$status[] = (object) array('label'=>'ACTIVE', 'value'=>'1');
			$status[] = (object) array('label'=>'INACTIVE', 'value'=>'0');
			$status[] = (object) array('label'=>'NOT CONFIRM', 'value'=>'5');
				
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
				'label' 		=> 'Username',
				'placeholder' 	=> 'username',
				'name' 			=> 'username',
				'value' 		=> $r_username,
				'classes' 		=> '',
			);
			$fields[] = (object) array(
				'type' 			=> 'password',
				'label' 		=> 'Password',
				'placeholder' 	=> 'Password',
				'name' 			=> 'password',
				'value' 		=> $r_password,
				'classes' 		=> '',
			);			
			$fields[] = (object) array(
				'type' 			=> 'password',
				'label' 		=> 'Password 2',
				'placeholder' 	=> 'Password 2',
				'name' 			=> 'password2',
				'value' 		=> $r_password2,
				'classes' 		=> '',
			);			
			$fields[] = (object) array(
				'type' 			=> 'text',
				'label' 		=> 'Alias',
				'placeholder' 	=> 'user alias',
				'name' 			=> 'alias',
				'value' 		=> $r_alias,
				'classes' 		=> '',
			);	
			$fields[] = (object) array(
				'type' 			=> 'select',
				'label' 		=> 'Status',
				'placeholder' 	=> '--Select status--',
				'name' 			=> 'status',
				'value' 		=> $r_status,
				'options'		=> $status,
				'classes' 		=> '',
			);			
			$fields[] = (object) array(
				'type' 			=> 'select',
				'label' 		=> 'Role',
				'name' 			=> 'role',
				'placeholder'	=> '--Select Role--',
				'value' 		=> $r_role,
				'options'		=> $role,
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
		if($this->auth->getPermission($this->session->userdata('ROLE_NAME'), __CLASS__ , __FUNCTION__ ) == false){
			
			redirect ('home');
		}		
		if(isset($_POST['id']) and $_POST['id'] != null){
			$filters = array();
			$filters[] = "A.ID = ". $_POST['id'];
			
			$result = $this->user_model->get($filters);
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
				
			$result = $this->user_model->update($this->data['update'], $_POST['id']);
			echo json_encode($result);	
		}
	}
	
	public function delete(){
		if($this->auth->getPermission($this->session->userdata('ROLE_NAME'), __CLASS__ , __FUNCTION__ ) == false){
			redirect ('home');
		}
		if(isset($_POST['id']) and $_POST['id'] != null){		
			$this->data['delete'] = array(
					'ID' => $_POST['id'],
				);		
			$result = $this->user_model->delete($this->data['delete']);
			echo json_encode($result);
		}		
	}
	
}

