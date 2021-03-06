<?php

Class Cubicle extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->userCheck($this->session->userdata('is_logged'));

		$this->load->model('Cubicle_model');
	}

	function index()
	{
		$this->load->view('view_all');
	}

	function add()
	{

		$this->form_validation->set_rules('cubicle_name', 'Cubicle Name', 'trim|required|xss_clean|callback_unique|alpha_numeric|min_length[4]|strtoupper');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('template',array('page'=>'cubicle/add'));
		}
		else
		{
			$cubicle_name = $this->input->post('cubicle_name');
				
			$id = $this->Cubicle_model->insert_new_cubicle($cubicle_name);
				
			if($id)
			{
				$this->devicelog->insert_log($this->session->userdata('user_id'), $id, 'cubicle', 'add');

				redirect('/cubicle/view/'.$id, 'refresh');
			}
			else
			{
				//			redirect('/user/register/', 'refresh');
			}
				
		}

	}

	function delete()
	{
		if($_POST['my_device_id'] != '' || $_POST['my_device_id'] != NULL)
		{
			$this->devicelog->insert_log($this->session->userdata('user_id'), $_POST['my_device_id'], 'cubicle', 'delete');
			
			$id = $this->Cubicle_model->delete_cubicle($_POST['my_device_id']);
		}
	}

	function view($cubicle_id)
	{

		$info = $this->Cubicle_model->get_cubicle_info($cubicle_id);
		$comments = $this->Cubicle_model->get_comments($cubicle_id);

		$data = array('info' => $info, 'comments' => $comments);

		$this->load->view('template',array('page'=>'cubicle/view', 'data'=>$data));

	}

	function viewall()
	{

		$data = $this->Cubicle_model->get_all_cubicle_info();

		$this->load->view('template',array('page'=>'cubicle/viewall', 'data'=>$data));

	}

	function unique($cubicle_name)
	{
		$exist = $this->Cubicle_model->check_cubicle_exist($cubicle_name);

		if($exist)
		{
			$info = $this->Cubicle_model->get_cubicle_info_by_name($cubicle_name);
				
			$this->form_validation->set_message('unique', anchor('cubicle/view/'.$info['cubicle_id'],$info['name']).' already exist.');
				
			return false;
		}
		else
		{
			return true;
		}
			
	}

	function userCheck($is_logged)
	{
		if(!$is_logged)
		{
			redirect('/user/notlogged', 'refresh');
		}
	}
}