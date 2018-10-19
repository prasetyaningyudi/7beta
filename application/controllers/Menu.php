<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
	private $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->library('session');		
		$this->load->helper('url');			
		$this->load->database();
		$this->load->model('menu_model');
		$this->data['error'] = array();
		$this->data['title'] = 'Menu';
	}

	public function index(){
		$this->data['subtitle'] = 'List';
		$this->data['class'] = __CLASS__;
		$this->load->view('section_header', $this->data);
		$this->load->view('section_nav');
		$this->load->view('main_index');	
		$this->load->view('section_footer');			
	}
	
	public function list(){
		$filters = array();
		$limit = array('10', '0');
		$r_nama = '';
		$r_parent = '';
		$r_status = '';

		//var_dump($_POST['nama']);
		if(isset($_POST['submit'])){
			if (isset($_POST['nama'])) {
				if ($_POST['nama'] != '' or $_POST['nama'] != null) {
					$filters[] = "A.MENU_NAME LIKE '%" . $_POST['nama'] . "%'";
					$r_nama = $_POST['nama'];
				}
			}
			if (isset($_POST['parent'])) {
				if ($_POST['parent'] != '' or $_POST['parent'] != null) {
					$filters[] = "A.MENU_ID = '" . $_POST['parent'] . "'";
					$r_parent = $_POST['parent'];
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
		
		$data = $this->menu_model->get($filters, $limit);
		$total_data = count($this->menu_model->get($filters));
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
						(object) array( 'classes' => ' align-left ', 'value' => $value->MENU_NAME ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->PERMALINK ),
						(object) array( 'classes' => ' align-left ', 'value' => '<i class="fa fa-'.$value->MENU_ICON.'"></i>' ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->MENU_ORDER ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->BMENU_NAME ),
						(object) array( 'classes' => ' align-center ', 'value' => $value->STATUS ),
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
				(object) array ('colspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'name'),					
				(object) array ('rowspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'permalink'),			
				(object) array ('rowspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'icon'),			
				(object) array ('rowspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'order'),			
				(object) array ('rowspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'parent'),			
				(object) array ('rowspan' => 1, 'classes' => 'bold align-center capitalize', 'value' => 'status'),			
			)		
		);

		$parent = array();
		$data = $this->menu_model->get_parent();
		
		if (empty($data)) {
			//$parent[] = (object) array('label'=>'No Data', 'value'=>'nodata');
		} else {
			foreach ($data as $value) {
				$parent[] = (object) array('label'=>$value->MENU_NAME, 'value'=>$value->ID);
			}
		}	
			
		$fields = array();
		$fields[] = (object) array(
			'type' 			=> 'text',
			'label' 		=> 'Name',
			'placeholder' 	=> 'Menu Name',
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
		$fields[] = (object) array(
			'type' 			=> 'select',
			'label' 		=> 'Parent menu',
			'name' 			=> 'parent',
			'placeholder'	=> '--Select Parent--',
			'value' 		=> $r_parent,
			'options'		=> $parent,
			'classes' 		=> 'required',
		);			
	

		$this->data['list'] = (object) array (
			'type'  	=> 'table',
			'editable'	=> true,
			'deletable'	=> true,
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
		if(isset($_POST['submit'])){
			//validation
			$error_info = array();
			$error_status = false;
			if($_POST['name'] == ''){
				$error_info[] = 'Menu Name can not be null';
				$error_status = true;
			}
			if($_POST['permalink'] == ''){
				$error_info[] = 'Permalink can not be null';
				$error_status = true;
			}
			if($_POST['order'] == ''){
				$error_info[] = 'Menu Order can not be null';
				$error_status = true;
			}
			if(strlen ($_POST['order']) > 2){
				$error_info[] = 'Menu Order maximum 2 digit number';
				$error_status = true;
			}			
			if(is_numeric($_POST['order']) == false){
				$error_info[] = 'Wrong Menu Order format';
				$error_status = true;
			}else{
				if(strpos($_POST['order'], '.') != false){
					$error_info[] = 'Wrong Menu Order format';
					$error_status = true;					
				}
				if (substr($_POST['order'], 0, 1) == '0' || substr($_POST['order'], 0, 2) == '00') {
					$error_info[] = 'Wrong Menu Order format';
					$error_status = true;	
				}
			}
		
			if($error_status == true){
				$this->data['error'] = (object) array (
					'type'  	=> 'error',
					'status'	=> $error_status,
					'info'	=> $error_info,
				);				
				echo json_encode($this->data['error']);
			}else{
				if($_POST['parent'] != ''){
					$filters = array();
					$filters[] = "A.ID = '" . $_POST['parent'] . "'";
					$data = $this->menu_model->get($filters);
					$parent_menu_order = '';
					if (empty($data)) {
						//$parent[] = (object) array('label'=>'No Data', 'value'=>'nodata');
					} else {
						foreach ($data as $value) {
							$parent_menu_order = $value->MENU_ORDER;
						}
					}	
				}
				$order = '';
				if(strlen ($_POST['order']) == 1){
					$order =  '0'.$_POST['order'];
				}else{
					$order =  $_POST['order'];
				}
				
				if($_POST['icon'] == ''){
					if($_POST['parent'] == ''){
						$this->data['insert'] = array(
								'MENU_NAME' => $_POST['name'],
								'PERMALINK' => $_POST['permalink'],
								'MENU_ORDER' => $order,
								'MENU_ID' => null,
							);
					}else{
						$this->data['insert'] = array(
								'MENU_NAME' => $_POST['name'],
								'PERMALINK' => $_POST['permalink'],
								'MENU_ORDER' => $parent_menu_order.$order,
								'MENU_ID' => $_POST['parent'],
							);						
					}
				}else{
					if($_POST['parent'] == ''){
						$this->data['insert'] = array(
								'MENU_NAME' => $_POST['name'],
								'PERMALINK' => $_POST['permalink'],
								'MENU_ICON' => $_POST['icon'],
								'MENU_ORDER' => $order,
								'MENU_ID' => null,
							);
					}else{
						$this->data['insert'] = array(
								'MENU_NAME' => $_POST['name'],
								'PERMALINK' => $_POST['permalink'],
								'MENU_ICON' => $_POST['icon'],
								'MENU_ORDER' => $parent_menu_order.$order,
								'MENU_ID' => $_POST['parent'],
							);						
					}
				}
				//var_dump($this->data['insert']);die;
				$result = $this->menu_model->insert($this->data['insert']);
				echo json_encode($result);				
			}
		}else{
			$parent = array();
			$data = $this->menu_model->get_parent();
			
			if (empty($data)) {
				//$parent[] = (object) array('label'=>'No Data', 'value'=>'nodata');
			} else {
				foreach ($data as $value) {
					$parent[] = (object) array('label'=>$value->MENU_NAME, 'value'=>$value->ID);
				}
			}			
			
			$fields = array();
			$fields[] = (object) array(
				'type' 			=> 'text',
				'label' 		=> 'Name',
				'name' 			=> 'name',
				'placeholder'	=> 'menu name',
				'value' 		=> '',
				'classes' 		=> '',
			);
			$fields[] = (object) array(
				'type' 			=> 'text',
				'label' 		=> 'Permalink',
				'name' 			=> 'permalink',
				'placeholder'	=> 'example : employee, #',
				'value' 		=> '',
				'classes' 		=> '',
			);
			$fields[] = (object) array(
				'type' 			=> 'text',
				'label' 		=> 'Icon',
				'name' 			=> 'icon',
				'placeholder'	=> 'use fontawesome, example : plus, minus',
				'value' 		=> '',
				'classes' 		=> '',
			);
			$fields[] = (object) array(
				'type' 			=> 'text',
				'label' 		=> 'Order',
				'name' 			=> 'order',
				'placeholder'	=> 'please input number (integer) start from 1',
				'value' 		=> '',
				'classes' 		=> '',
			);			
			$fields[] = (object) array(
				'type' 			=> 'select',
				'label' 		=> 'Parent menu',
				'name' 			=> 'parent',
				'placeholder'	=> '--Select Parent--',
				'value' 		=> '',
				'options'		=> $parent,
				'classes' 		=> 'required',
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
		if(isset($_POST['submit'])){
			//validation
			$error_info = array();
			$error_status = false;
			if($_POST['name'] == ''){
				$error_info[] = 'Menu Name can not be null';
				$error_status = true;
			}
			if($_POST['permalink'] == ''){
				$error_info[] = 'Permalink can not be null';
				$error_status = true;
			}
			if($_POST['order'] == ''){
				$error_info[] = 'Menu Order can not be null';
				$error_status = true;
			}
			if(strlen ($_POST['order']) > 2){
				$error_info[] = 'Menu Order maximum 2 digit number';
				$error_status = true;
			}			
			if(is_numeric($_POST['order']) == false){
				$error_info[] = 'Wrong Menu Order format';
				$error_status = true;
			}else{
				if(strpos($_POST['order'], '.') != false){
					$error_info[] = 'Wrong Menu Order format';
					$error_status = true;					
				}
				if (substr($_POST['order'], 0, 1) == '0' || substr($_POST['order'], 0, 2) == '00') {
					$error_info[] = 'Wrong Menu Order format';
					$error_status = true;	
				}
			}
			
			if($error_status == true){
				$this->data['error'] = (object) array (
					'type'  	=> 'error',
					'status'	=> $error_status,
					'info'	=> $error_info,
				);				
				echo json_encode($this->data['error']);
			}else{
				if($_POST['parent'] != ''){
					$filters = array();
					$filters[] = "A.ID = '" . $_POST['parent'] . "'";
					$data = $this->menu_model->get($filters);
					$parent_menu_order = '';
					if (empty($data)) {
						//$parent[] = (object) array('label'=>'No Data', 'value'=>'nodata');
					} else {
						foreach ($data as $value) {
							$parent_menu_order = $value->MENU_ORDER;
						}
					}	
				}
				$order = '';
				if(strlen ($_POST['order']) == 1){
					$order =  '0'.$_POST['order'];
				}else{
					$order =  $_POST['order'];
				}				
				
				if($_POST['icon'] == ''){
					if($_POST['parent'] == ''){
						$this->data['update'] = array(
								'MENU_NAME' => $_POST['name'],
								'PERMALINK' => $_POST['permalink'],
								'MENU_ORDER' => $order,
								'MENU_ID' => null,
							);
					}else{
						$this->data['update'] = array(
								'MENU_NAME' => $_POST['name'],
								'PERMALINK' => $_POST['permalink'],
								'MENU_ORDER' => $parent_menu_order.$order,
								'MENU_ID' => $_POST['parent'],
							);						
					}
				}else{
					if($_POST['parent'] == ''){
						$this->data['update'] = array(
								'MENU_NAME' => $_POST['name'],
								'PERMALINK' => $_POST['permalink'],
								'MENU_ICON' => $_POST['icon'],
								'MENU_ORDER' => $order,
								'MENU_ID' => null,
							);
					}else{
						$this->data['update'] = array(
								'MENU_NAME' => $_POST['name'],
								'PERMALINK' => $_POST['permalink'],
								'MENU_ICON' => $_POST['icon'],
								'MENU_ORDER' => $parent_menu_order.$order,
								'MENU_ID' => $_POST['parent'],
							);						
					}
				}
				$result = $this->menu_model->update($this->data['update'], $_POST['id']);
				echo json_encode($result);				
			}			
		}else{
			$r_nama = '';
			$r_permalink = '';
			$r_icon = '';
			$r_order = '';
			$r_parent = '';
			
			$filter = array();
			$filter[] = "A.ID = ". $_POST['id'];
			$this->data['result'] = $this->menu_model->get($filter);
			//var_dump($this->data['result']);
			foreach($this->data['result'] as $value){
				$r_id 	= $value->ID;
				$r_nama = $value->MENU_NAME;
				$r_permalink = $value->PERMALINK;
				$r_icon = $value->MENU_ICON;
				$r_parent = $value->MENU_ID;
/* 				var_dump(strlen($value->MENU_ORDER));
				var_dump($value->MENU_ORDER); */
				if(strlen($value->MENU_ORDER) == 2){
					$r_order = $value->MENU_ORDER;
					//var_dump(strlen($r_order));
				}else{
					$r_order = substr($value->MENU_ORDER, 2, 2);
					//var_dump($r_order);
				}
				
				//var_dump($r_order);
				
				if(substr($r_order, 0, 1) == '0'){
					$r_order = substr($r_order, 1, 1);
				}
				
				//var_dump($r_order);
			}
			
			$parent = array();
			$data = $this->menu_model->get_parent();
			
			if (empty($data)) {
				//$parent[] = (object) array('label'=>'No Data', 'value'=>'nodata');
			} else {
				foreach ($data as $value) {
					$parent[] = (object) array('label'=>$value->MENU_NAME, 'value'=>$value->ID);
				}
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
				'placeholder'	=> 'menu name',
				'value' 		=> $r_nama,
				'classes' 		=> '',
			);
			$fields[] = (object) array(
				'type' 			=> 'text',
				'label' 		=> 'Permalink',
				'name' 			=> 'permalink',
				'placeholder'	=> 'example : employee, #',
				'value' 		=> $r_permalink,
				'classes' 		=> '',
			);
			$fields[] = (object) array(
				'type' 			=> 'text',
				'label' 		=> 'Icon',
				'name' 			=> 'icon',
				'placeholder'	=> 'use fontawesome, example : plus, minus',
				'value' 		=> $r_icon,
				'classes' 		=> '',
			);
			$fields[] = (object) array(
				'type' 			=> 'text',
				'label' 		=> 'Order',
				'name' 			=> 'order',
				'placeholder'	=> 'please input number (integer) start from 1',
				'value' 		=> $r_order,
				'classes' 		=> '',
			);			
			$fields[] = (object) array(
				'type' 			=> 'select',
				'label' 		=> 'Parent menu',
				'name' 			=> 'parent',
				'placeholder'	=> '--Select Parent--',
				'value' 		=> $r_parent,
				'options'		=> $parent,
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
	
	public function delete(){
		$this->data['delete'] = array(
				'ID' => $_POST['id'],
			);		
		$result = $this->menu_model->delete($this->data['delete']);
		echo json_encode($result);		
	}
	
}
