<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth{
	private $_role_permission;
	
	public function __construct(){
		$this->_role_permission = array(
			'administrator' => array (
				'home' => array ('index', 'list', 'insert', 'update', 'update_status', 'delete'),
				'user' => array ('index', 'list', 'insert', 'update', 'update_status'),
			),
			'supervisor' => array (
				'menu' => array ('index', 'list', 'insert', 'update', 'update_status', 'delete'),
				'user' => array ('index', 'list', 'insert', 'update', 'update_status', 'delete'),		
			),
			'operator' => array (
				'menu' => array ('index', 'list', 'insert', 'update', 'update_status', 'delete'),
				'user' => array ('index', 'list', 'insert', 'update', 'update_status', 'delete'),	
			),	
		);
	}
	
	public function getPermission($role, $menu, $submenu){
		$mymenu = mb_strtolower($menu);
		$mysubmenu = mb_strtolower($submenu);
		$exist = false;
		$role_array = array();
		$menu_array = array();
		for($i=0; $i < sizeOf($this->_role_permission); $i++){
			if(array_key_exists($role, $this->_role_permission)){
				$role_array = $this->_role_permission[$role];
			}else{
				$exist = false;
			}
		}
		if(!empty($role_array)){
			for($j=0; $j < sizeOf($role_array); $j++){
				if(array_key_exists($mymenu, $role_array)){
					$menu_array = $role_array[$mymenu];
				}else{
					$exist = false;
				}
			}
		}
		
		if(!empty($menu_array)){
			foreach($menu_array as $value){
				if($value == $mysubmenu){
					$exist = true;
				}
			}
		}
		return $exist;
	}
}



