<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {
	private $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->library('session');		
		$this->load->helper('url');			
		$this->load->database();
		$this->load->model('pegawai_model');
		$this->data['error'] = array();
		$this->data['title'] = 'Pegawai';
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
		$r_nama = '';
		$r_alamat = '';
		if(isset($_POST['submit'])){
			if ($_POST['nama'] != '') {
				$filters[] = "nama = '" . $_POST['nama'] . "'";
				$r_nama = $_POST['nama'];
			}
			
			if ($_POST['alamat'] != '') {
				$filters[] = "alamat = '" . $_POST['alamat'] . "'";
				$r_alamat = $_POST['alamat'];
			}
		}
		
		$data = $this->pegawai_model->get($filters);
		
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
						(object) array( 'classes' => ' align-left ', 'value' => $value->NAMA ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->ALAMAT ),
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
				(object) array ('rowspan' => 2, 'classes' => 'bold align-left capitalize', 'value' => 'No'),
				(object) array ('colspan' => 2, 'classes' => 'bold align-center capitalize', 'value' => 'data'),					
				(object) array ('rowspan' => 2, 'classes' => 'bold align-center capitalize', 'value' => 'status'),			
			),
			array (
				(object) array ('classes' => 'bold align-center capitalize', 'value' => 'nama'),
				(object) array ('classes' => 'bold align-center capitalize', 'value' => 'alamat'),				
			)			
		);
		
		$filter = array();
		$filter[] = (object) array(
			'type' 		=> 'text',
			'label' 	=> 'Nama',
			'name' 		=> 'nama',
			'value' 	=> $r_nama,
			'classes' 	=> '',
		);
		$filter[] = (object) array(
			'type' 		=> 'textarea',
			'label' 	=> 'Alamat',
			'name' 		=> 'alamat',
			'value' 	=> $r_alamat,
			'classes' 	=> '',
		);			

		$this->data['list'] = (object) array (
			'type'  	=> 'table',
			'editable'	=> true,
			'deletable'	=> true,
			'classes'  	=> 'striped bordered hover',
			'filters'  	=> $filter,
			'header'  	=> $header,
			'body'  	=> $body,
			'footer'  	=> null,
		);
	
		echo json_encode($this->data['list']);
	}
	
	public function insert(){
		if(isset($_POST['submit'])){
			//validation example
			$error_info = array();
			$error_status = false;
/* 			if($_POST['nama'] != 'yudi'){
				$error_info[] = 'Invalid Name';
				$error_status = true;
			}
			if($_POST['alamat'] != 'yudi'){
				$error_info[] = 'Invalid Alamat';
				$error_status = true;
			} */
			
			if($error_status == true){
				$this->data['error'] = (object) array (
					'type'  	=> 'error',
					'status'	=> $error_status,
					'info'	=> $error_info,
				);				
				echo json_encode($this->data['error']);
			}else{
				$this->data['insert'] = array(
						'NAMA' => $_POST['nama'],
						'ALAMAT' => $_POST['alamat'],
					);
				$result = $this->pegawai_model->insert($this->data['insert']);
				echo json_encode($result);				
			}
		}else{
			$fields = array();
			$fields[] = (object) array(
				'type' 		=> 'text',
				'label' 	=> 'Nama',
				'name' 		=> 'nama',
				'value' 	=> '',
				'classes' 	=> 'required',
			);
			$fields[] = (object) array(
				'type' 		=> 'textarea',
				'label' 	=> 'Alamat',
				'name' 		=> 'alamat',
				'value' 	=> '',
				'classes' 	=> 'required',
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
			//validation example
			$error_info = array();
			$error_status = false;
/* 			if($_POST['nama'] != 'yudi'){
				$error_info[] = 'Invalid Name';
				$error_status = true;
			}
			if($_POST['alamat'] != 'yudi'){
				$error_info[] = 'Invalid Alamat';
				$error_status = true;
			} */
			
			if($error_status == true){
				$this->data['error'] = (object) array (
					'type'  	=> 'error',
					'status'	=> $error_status,
					'info'	=> $error_info,
				);				
				echo json_encode($this->data['error']);
			}else{
				$this->data['update'] = array(
						'NAMA' => $_POST['nama'],
						'ALAMAT' => $_POST['alamat'],
					);
				$result = $this->pegawai_model->update($this->data['update'], $_POST['id']);
				echo json_encode($result);				
			}			
		}else{
			$filter = array();
			$filter[] = "ID = ". $_POST['id'];
			$this->data['result'] = $this->pegawai_model->get($filter);
			foreach($this->data['result'] as $value){
				$r_id 	= $value->ID;
				$r_nama = $value->NAMA;
				$r_alamat = $value->ALAMAT;
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
				'type' 		=> 'text',
				'label' 	=> 'Nama',
				'name' 		=> 'nama',
				'value' 	=> $r_nama,
				'classes' 	=> 'required',
			);
			$fields[] = (object) array(
				'type' 		=> 'text',
				'label' 	=> 'Alamat',
				'name' 		=> 'alamat',
				'value' 	=> $r_alamat,
				'classes' 	=> 'required',
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
		$result = $this->pegawai_model->delete($this->data['delete']);
		echo json_encode($result);		
	}
	
}

