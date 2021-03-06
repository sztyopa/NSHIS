<?php

class Ajax extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		//$this->userCheck($this->session->userdata('is_logged'));
		
		$this->load->model('Ajax_model');
		
		$this->load->model('People_model');
		
		$this->load->model('Usb_headset_model');
		
		$this->config->set_item('enable_profiling', FALSE);
		
	}

	function comment_add()
	{
		$this->Ajax_model->comment_add($_POST['log_id'], $_POST['comment']);
	}
	
	function comment_filter()
	{
		$params = array();
		$params = $_POST['date_filter'] != '' ? array_merge($params, array('cdate' => $_POST['date_filter'])) : $params;
		$params = $_POST['user_filter'] != '' ? array_merge($params, array('user_id' => $_POST['user_filter'])) : $params;
		$params = isset($_POST['status_filter']) ? array_merge($params, array('status' => $_POST['status_filter'])) : $params;
		
		$this->devicelog->generate_logs($_POST['device_id'], $_POST['device_type'], $params);
		
		/*
		if ($_POST['user_filter'] != '' || $_POST['status_filter'] != '') {
			$this->devicelog->generate_logs($_POST['device_id'], $_POST['device_type'], $_POST['date_filter'], array('user_id' => $_POST['user_filter'], 'status' => $_POST['status_filter']));
		} 
		else {
			$this->devicelog->generate_logs($_POST['device_id'], $_POST['device_type'], $_POST['date_filter']);
		}
		*/
		//var_dump($_POST['status_filter']);
		//$this->Ajax_model->comment_add($_POST['log_id'], $_POST['comment']);
	}
	
	function comment_user_filter()
	{
		$params = array();
		$params = isset($_POST['status_filter']) ? array_merge($params, array('status' => $_POST['status_filter'])) : $params;
		
		$this->devicelog->generate_user_logs($_POST['user_filter'], $params);
		
		/*
		if ($_POST['user_filter'] != '' || $_POST['status_filter'] != '') {
			$this->devicelog->generate_logs($_POST['device_id'], $_POST['device_type'], $_POST['date_filter'], array('user_id' => $_POST['user_filter'], 'status' => $_POST['status_filter']));
		} 
		else {
			$this->devicelog->generate_logs($_POST['device_id'], $_POST['device_type'], $_POST['date_filter']);
		}
		*/
		//var_dump($_POST['status_filter']);
		//$this->Ajax_model->comment_add($_POST['log_id'], $_POST['comment']);
	}
	
	function status_change()
	{
		$this->Ajax_model->status_change($_POST['item'], $_POST['item_id'], $_POST['status'], $_POST['status_comment']);
	}
	
	function assign_headset($headset_id = NULL, $user_id = NULL)
	{
		if (!isset($headset_id) OR !isset($user_id)) {
			$headset_id = $_POST['headset_id'];
			$user_id = $_POST['user_id'];
		}
		
		$this->Usb_headset_model->assign_usb_headset($headset_id, $user_id);
		
		$this->devicelog->insert_log($this->session->userdata('user_id'), $headset_id, 'usb_headset', 'assign', 0, $this->People_model->get_name($user_id));
	}
	
	function assign_item()
	{
		if ($_POST['item'] == 'usbheadset') {
			$this->assign_headset($_POST['item_id'], $_POST['location_id']);
		} else {
			$this->Ajax_model->assign_item($_POST['item'], $_POST['item_id'], $_POST['location_id']);
		}
			
	}
}