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
		$data = $this->pegawai_model->get();

		$no_body = 0;
		$body= array();
		if(isset($data)){
            if (empty($data)) {
                $body[$no_body] = array(
                    (object) array ('colspan' => 100, 'classes' => 'bold align-center', 'value' => 'No Data')
                );
			} else {
				foreach ($data as $value) {
					$body[$no_body] = array(
						(object) array( 'classes' => ' hidden ', 'value' => $value->ID ),
						(object) array( 'classes' => ' bold align-left ', 'value' => $no_body+1 ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->NAMA ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->ALAMAT ),
						(object) array( 'classes' => ' align-left ', 'value' => $value->STATUS ),
					);
					$no_body++;
				}
			}
        } else {
            $body[$no_body] = array(
                (object) array ('colspan' => 100, 'classes' => 'bold align-center', 'value' => 'Filter First')
            );
        }
		
		$header = array(
			array (
				(object) array ('rowspan' => 2, 'classes' => 'bold align-left italic capitalize', 'value' => 'No'),
				(object) array ('colspan' => 2, 'classes' => 'bold align-center capitalize', 'value' => 'data'),					
				(object) array ('rowspan' => 2, 'classes' => 'bold align-left capitalize', 'value' => 'status'),			
			),
			array (
				(object) array ('classes' => 'bold align-center capitalize', 'value' => 'nama'),
				(object) array ('classes' => 'bold align-center capitalize', 'value' => 'alamat'),				
			)			
		);

		$this->data['list'] = (object) array (
			'type'  	=> 'table',
			'editable'	=> true,
			'deletable'	=> true,
			'classes'  	=> 'striped bordered hover',
			'filters'  	=> null,
			'header'  	=> $header,
			'body'  	=> $body,
			'footer'  	=> null,
		);
	
		echo json_encode($this->data['list']);
	}
	
	public function insert(){
		if(isset($_POST['submit'])){
			$this->data['insert'] = array(
					'NAMA' => $_POST['nama'],
					'ALAMAT' => $_POST['alamat'],
				);
			$result = $this->pegawai_model->insert($this->data['insert']);
			echo json_encode($result);
		}
	}
	
	public function update($id = null){
		$output = array(
				"draw" => 'tes'
		);
		//output to json format
		echo json_encode($output);
	}
	
	public function delete(){
			$this->data['delete'] = array(
					'ID' => $_POST['id'],
				);		
			$result = $this->pegawai_model->delete($this->data['delete']);
			echo json_encode($result);		
	}
	
}

