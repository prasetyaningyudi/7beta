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
		$limit = array('4', '0');
		$r_nama = '';
		$r_alamat = '';
		$r_pendidikan = '';
		$r_jenis_kelamin = '';
		$r_kesehatan = '';
		//var_dump($_POST['nama']);
		if(isset($_POST['submit'])){
			if (isset($_POST['nama'])) {
				if ($_POST['nama'] != '' or $_POST['nama'] != null) {
					$filters[] = "nama = '" . $_POST['nama'] . "'";
					$r_nama = $_POST['nama'];
				}
			}
			if (isset($_POST['alamat'])) {
				if ($_POST['alamat'] != '' or $_POST['alamat'] != null) {
					$filters[] = "alamat = '" . $_POST['alamat'] . "'";
					$r_alamat = $_POST['alamat'];
				}
			}
			if (isset($_POST['pendidikan'])) {
				if ($_POST['pendidikan'] != '' or $_POST['pendidikan'] != null) {
					$filters[] = "pendidikan = '" . $_POST['pendidikan'] . "'";
					$r_pendidikan = $_POST['pendidikan'];
				}
			}
			if (isset($_POST['jenis_kelamin'])) {
				if($_POST['jenis_kelamin'] != '' or $_POST['jenis_kelamin'] != null){
					$filters[] = "jenis_kelamin = '" . $_POST['jenis_kelamin'] . "'";
					$r_jenis_kelamin = $_POST['jenis_kelamin'];
				}
			}
			if (isset($_POST['kesehatan'])) {
				if ($_POST['kesehatan'] != '' or $_POST['kesehatan'] != null) {
					$filters[] = "kesehatan = '" . $_POST['kesehatan'] . "'";
					$r_kesehatan = $_POST['kesehatan'];
				}
			}
			if (isset($_POST['offset'])) {
				if ($_POST['offset'] != '' or $_POST['offset'] != null) {
					$limit[1] = $_POST['offset'];
				}
			}			
		}
		
		$data = $this->pegawai_model->get($filters, $limit);
		$total_data = count($this->pegawai_model->get($filters));
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
						(object) array( 'classes' => ' align-left ', 'value' => $value->NAMA ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->ALAMAT ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->PENDIDIKAN ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->JENIS_KELAMIN ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->KESEHATAN ),
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
				(object) array ('colspan' => 5, 'classes' => 'bold align-center capitalize', 'value' => 'data'),					
				(object) array ('rowspan' => 2, 'classes' => 'bold align-center capitalize', 'value' => 'status'),			
			),
			array (
				(object) array ('classes' => 'bold align-center capitalize', 'value' => 'nama'),
				(object) array ('classes' => 'bold align-center capitalize', 'value' => 'alamat'),				
				(object) array ('classes' => 'bold align-center capitalize', 'value' => 'pendidikan'),				
				(object) array ('classes' => 'bold align-center capitalize', 'value' => 'jenis kelamin'),				
				(object) array ('classes' => 'bold align-center capitalize', 'value' => 'sehat'),				
			)			
		);

		$pendidikan = array();
		$pendidikan[] = (object) array('label'=>'SD', 'value'=>'SD');
		$pendidikan[] = (object) array('label'=>'SMP', 'value'=>'SMP');
		$pendidikan[] = (object) array('label'=>'SMA', 'value'=>'SMA');
		
		$jenis_kelamin = array();
		$jenis_kelamin[] = (object) array('label'=>'Pria', 'value'=>'pria');
		$jenis_kelamin[] = (object) array('label'=>'Wanita', 'value'=>'wanita');	

		$kesehatan = array();
		$kesehatan[] = (object) array('label'=>'YA');
			
		$fields = array();
		$fields[] = (object) array(
			'type' 			=> 'text',
			'label' 		=> 'Nama',
			'placeholder' 	=> 'Isikan Nama',
			'name' 			=> 'nama',
			'value' 		=> $r_nama,
			'classes' 		=> '',
		);
		$fields[] = (object) array(
			'type' 			=> 'textarea',
			'label' 		=> 'Alamat',
			'placeholder' 	=> 'Isikan Alamat',
			'name' 			=> 'alamat',
			'value' 		=> $r_alamat,
			'classes' 		=> '',
		);
		$fields[] = (object) array(
			'type' 			=> 'select',
			'label' 		=> 'Pendidikan',
			'name' 			=> 'pendidikan',
			'placeholder'	=> '--Pilih Pendidikan--',
			'value' 		=> $r_pendidikan,
			'options'		=> $pendidikan,
			'classes' 		=> '',
		);	
		$fields[] = (object) array(
			'type' 			=> 'radio',
			'label' 		=> 'Jenis Kelamin',
			'name' 			=> 'jenis_kelamin',
			'value' 		=> $r_jenis_kelamin,
			'options'		=> $jenis_kelamin,
			'classes' 		=> '',
		);
		$fields[] = (object) array(
			'type' 			=> 'checkbox',
			'label' 		=> 'Anda sehat?',
			'name' 			=> 'kesehatan',
			'value' 		=> $r_kesehatan,
			'options'		=> $kesehatan,				
			'classes' 		=> '',
		);				

		$this->data['list'] = (object) array (
			'type'  	=> 'table',
			'editable'	=> true,
			'deletable'	=> true,
			'classes'  	=> 'striped bordered hover',
			'filters'  	=> $fields,
			'header'  	=> $header,
			'body'  	=> $body,
			'footer'  	=> null,
		);		

		$this->data['list'] = (object) array (
			'type'  	=> 'table',
			'editable'	=> true,
			'deletable'	=> true,
			'classes'  	=> 'striped bordered hover',
			'filters'  	=> $fields,
			'header'  	=> $header,
			'body'  	=> $body,
			'footer'  	=> null,
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
			if($_POST['pendidikan'] == ''){
				$error_info[] = 'Pendidikan harus dipilih';
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
						'NAMA' => $_POST['nama'],
						'ALAMAT' => $_POST['alamat'],
						'PENDIDIKAN' => $_POST['pendidikan'],
						'JENIS_KELAMIN' => $_POST['jenis_kelamin'],
						'KESEHATAN' => $_POST['kesehatan'],
					);
				//var_dump($this->data['insert']);die;
				$result = $this->pegawai_model->insert($this->data['insert']);
				echo json_encode($result);				
			}
		}else{
			$pendidikan = array();
			$pendidikan[] = (object) array('label'=>'SD', 'value'=>'SD');
			$pendidikan[] = (object) array('label'=>'SMP', 'value'=>'SMP');
			$pendidikan[] = (object) array('label'=>'SMA', 'value'=>'SMA');
			
			$jenis_kelamin = array();
			$jenis_kelamin[] = (object) array('label'=>'Pria', 'value'=>'pria');
			$jenis_kelamin[] = (object) array('label'=>'Wanita', 'value'=>'wanita');

			$kesehatan = array();
			$kesehatan[] = (object) array('label'=>'YA');	
			
			$fields = array();
			$fields[] = (object) array(
				'type' 			=> 'text',
				'label' 		=> 'Nama',
				'name' 			=> 'nama',
				'placeholder'	=> 'Isikan nama',
				'value' 		=> '',
				'classes' 		=> 'required',
			);
			$fields[] = (object) array(
				'type' 			=> 'textarea',
				'label' 		=> 'Alamat',
				'name' 			=> 'alamat',
				'placeholder'	=> 'Isikan Alamat',
				'value' 		=> '',
				'classes' 		=> 'required',
			);
			$fields[] = (object) array(
				'type' 			=> 'select',
				'label' 		=> 'Pendidikan',
				'name' 			=> 'pendidikan',
				'placeholder'	=> '--Pilih Pendidikan--',
				'value' 		=> '',
				'options'		=> $pendidikan,
				'classes' 		=> 'required',
			);	
			$fields[] = (object) array(
				'type' 			=> 'radio',
				'label' 		=> 'Jenis Kelamin',
				'name' 			=> 'jenis_kelamin',
				'value' 		=> '',
				'options'		=> $jenis_kelamin,
				'classes' 		=> 'required',
			);
			$fields[] = (object) array(
				'type' 			=> 'checkbox',
				'label' 		=> 'Anda sehat?',
				'name' 			=> 'kesehatan',
				'value' 		=> '',
				'options'		=> $kesehatan,				
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
						'PENDIDIKAN' => $_POST['pendidikan'],
						'JENIS_KELAMIN' => $_POST['jenis_kelamin'],
						'KESEHATAN' => $_POST['kesehatan'],
					);
				$result = $this->pegawai_model->update($this->data['update'], $_POST['id']);
				echo json_encode($result);				
			}			
		}else{
			$r_nama = '';
			$r_alamat = '';
			$r_pendidikan = '';
			$r_jenis_kelamin = '';
			$r_kesehatan = '';
			
			$filter = array();
			$filter[] = "ID = ". $_POST['id'];
			$this->data['result'] = $this->pegawai_model->get($filter);
			foreach($this->data['result'] as $value){
				$r_id 	= $value->ID;
				$r_nama = $value->NAMA;
				$r_alamat = $value->ALAMAT;
				$r_pendidikan = $value->PENDIDIKAN;
				$r_jenis_kelamin = $value->JENIS_KELAMIN;
				$r_kesehatan = $value->KESEHATAN;
			}
			
			$pendidikan = array();
			$pendidikan[] = (object) array('label'=>'SD', 'value'=>'SD');
			$pendidikan[] = (object) array('label'=>'SMP', 'value'=>'SMP');
			$pendidikan[] = (object) array('label'=>'SMA', 'value'=>'SMA');
			
			$jenis_kelamin = array();
			$jenis_kelamin[] = (object) array('label'=>'Pria', 'value'=>'pria');
			$jenis_kelamin[] = (object) array('label'=>'Wanita', 'value'=>'wanita');	

			$kesehatan = array();
			$kesehatan[] = (object) array('label'=>'YA');	
			
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
				'type' 		=> 'textarea',
				'label' 	=> 'Alamat',
				'name' 		=> 'alamat',
				'value' 	=> $r_alamat,
				'classes' 	=> 'required',
			);
			$fields[] = (object) array(
				'type' 			=> 'select',
				'label' 		=> 'Pendidikan',
				'name' 			=> 'pendidikan',
				'placeholder'	=> '--Pilih Pendidikan--',
				'value' 		=> $r_pendidikan,
				'options'		=> $pendidikan,
				'classes' 		=> 'required',
			);	
			$fields[] = (object) array(
				'type' 			=> 'radio',
				'label' 		=> 'Jenis Kelamin',
				'name' 			=> 'jenis_kelamin',
				'value' 		=> $r_jenis_kelamin,
				'options'		=> $jenis_kelamin,
				'classes' 		=> 'required',
			);
			$fields[] = (object) array(
				'type' 			=> 'checkbox',
				'label' 		=> 'Anda sehat?',
				'name' 			=> 'kesehatan',
				'value' 		=> $r_kesehatan,
				'options'		=> $kesehatan,				
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
	
	public function delete(){
		$this->data['delete'] = array(
				'ID' => $_POST['id'],
			);		
		$result = $this->pegawai_model->delete($this->data['delete']);
		echo json_encode($result);		
	}
	
}

