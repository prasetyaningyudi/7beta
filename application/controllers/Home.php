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
		$this->load->model('broadcast_model');
		$this->load->model('menu_model');
		$this->data['menu'] = $this->menu_model->get_menu($this->session->userdata('ROLE_ID'));
		$this->data['sub_menu'] = $this->menu_model->get_sub_menu($this->session->userdata('ROLE_ID'));		
		$this->data['error'] = array();
		$this->data['title'] = 'Home';
	}

	public function index(){	
		$this->data['subtitle'] = 'Broadcast Information';
		$this->data['class'] = __CLASS__;
		$this->load->view('section_header', $this->data);
		$this->load->view('section_nav');
		$this->load->view('home_index');	
		$this->load->view('section_footer');
	}

	public function list(){
		$filters = array();
		$limit = array('10', '0');
		$r_title = '';
		$r_body = '';
		
		if($this->session->userdata('is_logged_in') == 1){
			$filters[] = "CREDENTIAL IN('all','user')";
		}else{
			$filters[] = "CREDENTIAL IN('all','guest')";
		}
		
		$filters[] = "STATUS = '1'";
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
					$alert = '<div class="alert alert-'.$value->TYPE.' row home-list" role="alert">';					
					$alert .= '<div class="col-1 home-list-date text-center">';					
					$alert .= '<div class="home-list-date-date">'.date("d", strtotime($value->CREATE_DATE)).'</div>';					
					$alert .= '<div class="home-list-date-year text-uppercase">'.date("M Y", strtotime($value->CREATE_DATE)).'</div>';					
					$alert .= '</div>';	
					$alert .= '<div class="col-11">';			
					$alert .= '<h4 class="alert-heading text-capitalize">'.$value->TITLE.'</h4>';				
					$alert .= '<hr>';
					$alert .= '<p>'.$value->BODY.'</p>';				
					$alert .= '</div>';				
					$alert .= '</div>';				
					
					$body[$no_body] = array(
						(object) array( 'classes' => ' hidden ', 'value' => $value->ID ),
						(object) array( 'classes' => '', 'value' => $alert ),
					);
					$no_body++;
				}
			}
        } else {
            $body[$no_body] = array(
                (object) array ('colspan' => 100, 'classes' => ' empty bold align-center', 'value' => 'Filter First')
            );
        }
			
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
	

		$this->data['list'] = (object) array (
			'type'  	=> 'broadcast',
			'insertable'=> false,
			'editable'	=> false,
			'deletable'	=> false,
			'statusable'=> false,
			'classes'  	=> null,
			'pagination'=> $limit,
			'filters'  	=> $fields,
			'header'  	=> null,
			'body'  	=> $body,
			'footer'  	=> null,
		);		
		echo json_encode($this->data['list']);
	}
}

