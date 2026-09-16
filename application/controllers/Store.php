<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller {

    public function index()
	{

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_1'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('store/header_con', $arrData);
			$this->load->view('store/main_con');
            $this->load->view('store/footer_con');

		}
		else {
			redirect( base_url().'m/login');
		}

	}

    public function login()
	{
        $this->load->model('confsite_model');
		$strSiteName = $this->confsite_model->getSiteName();

		$this->load->view('store/login_con', array("site_name"=>$strSiteName));
    }

    public function logout()
	{
		//$this->session->sess_destroy();
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
			$this->sess_model->logout($nLogId);
		}
		redirect( base_url().'m/login', 'refresh');
	}

    public function statist()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_2'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('store/header_con', $arrData);
			$this->load->view('store/statist_con');
            $this->load->view('store/footer_con');

		}
		else {
			redirect( base_url().'m/login');
		}
	}

    public function charge()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_3'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('store/header_con', $arrData);
			$this->load->view('store/charge_con');
            $this->load->view('store/footer_con');

		}
		else {
			redirect( base_url().'m/login');
		}
	}

    public function discharge()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_4'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('store/header_con', $arrData);
			$this->load->view('store/discharge_con');
            $this->load->view('store/footer_con');

		}
		else {
			redirect( base_url().'m/login');
		}
	}
    

    public function transform()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_5'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('store/header_con', $arrData);
			$this->load->view('store/trans_con');
            $this->load->view('store/footer_con');

		}
		else {
			redirect( base_url().'m/login');
		}
	}

    public function transform2()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_6'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('store/header_con', $arrData);
			$this->load->view('store/trans2_con');
            $this->load->view('store/footer_con');

		}
		else {
			redirect( base_url().'m/login');
		}
	}

    public function message()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_7'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('store/header_con', $arrData);
			$this->load->view('store/message_con');
            $this->load->view('store/footer_con');

		}
		else {
			redirect( base_url().'m/login');
		}
	}

    public function cancel()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_8'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('store/header_con', $arrData);
			$this->load->view('store/cancel_con');
            $this->load->view('store/footer_con');

		}
		else {
			redirect( base_url().'m/login');
		}
	}
}