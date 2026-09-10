<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control extends CI_Controller {

    public function index()
	{

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_AGENCY_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_1'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('control/header_con', $arrData);
			$this->load->view('control/main_con');
            $this->load->view('control/footer_con');

		}
		else {
			redirect( base_url().'ctrl/login');
		}

	}

    public function login()
	{
        $this->load->model('confsite_model');
		$strSiteName = $this->confsite_model->getSiteName();

		$this->load->view('control/login_con', array("site_name"=>$strSiteName));
    }

    public function logout()
	{
		//$this->session->sess_destroy();
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_AGENCY_LEVEL))
		{
			$this->sess_model->logout($nLogId);
		}
		redirect( base_url().'ctrl/login', 'refresh');
	}

    public function statist()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_AGENCY_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_2'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('control/header_con', $arrData);
			$this->load->view('control/statist_con');
            $this->load->view('control/footer_con');

		}
		else {
			redirect( base_url().'ctrl/login');
		}
	}

    public function charge()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_AGENCY_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_3'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('control/header_con', $arrData);
			$this->load->view('control/charge_con');
            $this->load->view('control/footer_con');

		}
		else {
			redirect( base_url().'ctrl/login');
		}
	}

    public function discharge()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_AGENCY_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_4'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('control/header_con', $arrData);
			$this->load->view('control/discharge_con');
            $this->load->view('control/footer_con');

		}
		else {
			redirect( base_url().'ctrl/login');
		}
	}
    

    public function transform()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_AGENCY_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_5'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('control/header_con', $arrData);
			$this->load->view('control/trans_con');
            $this->load->view('control/footer_con');

		}
		else {
			redirect( base_url().'ctrl/login');
		}
	}

    public function transform2()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_AGENCY_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_6'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('control/header_con', $arrData);
			$this->load->view('control/trans2_con');
            $this->load->view('control/footer_con');

		}
		else {
			redirect( base_url().'ctrl/login');
		}
	}

    public function message()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_AGENCY_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_7'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('control/header_con', $arrData);
			$this->load->view('control/message_con');
            $this->load->view('control/footer_con');

		}
		else {
			redirect( base_url().'ctrl/login');
		}
	}

    public function cancel()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_AGENCY_LEVEL))
		{
            $arrData = getSidebarArray();
			$arrData['menuitem_8'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			
            $this->load->view('control/header_con', $arrData);
			$this->load->view('control/cancel_con');
            $this->load->view('control/footer_con');

		}
		else {
			redirect( base_url().'ctrl/login');
		}
	}
}