<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function index()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)) 
		{

			$arrData = getSidebarArray();
			$arrData['menuitem_1'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			$this->attachTopAdminFlag($arrData, $nLogId);
			
            $this->load->view('admin/header_adm', $arrData);
			$this->load->view('admin/main_adm');
            $this->load->view('admin/footer_adm');
		}
		else {
			redirect( base_url().'admin/login');
		}
	}


    public function login()
	{
        $this->load->model('confsite_model');
		$strSiteName = $this->confsite_model->getSiteName();

		$this->load->view('admin/login_adm', array("site_name"=>$strSiteName));
    }

    public function logout()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{
			$this->sess_model->logout($nLogId);
		}
		//$this->session->sess_destroy();
		redirect( base_url().'admin/login', 'refresh');
	}

    public function statist()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{

			$arrData = getSidebarArray();
			$arrData['menuitem_2'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			$this->attachTopAdminFlag($arrData, $nLogId);
			
            $this->load->view('admin/header_adm', $arrData);
			$this->load->view('admin/statist_adm');
            $this->load->view('admin/footer_adm');
		}
		else {
			redirect( base_url().'admin/login');
		}
	}

    public function store()
	{
		$nLogId = trim($this->input->get('l'));
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{
			$arrData = getSidebarArray();
			$arrData['menuitem_12'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			$this->attachTopAdminFlag($arrData, $nLogId);

			$this->load->view('admin/header_adm', $arrData);
			$this->load->view('admin/store_adm');
			$this->load->view('admin/footer_adm');
		}
		else {
			redirect( base_url().'admin/login');
		}
	}

    public function roundstat()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{

			$arrData = getSidebarArray();
			$arrData['menuitem_3'] = " is-active ";
			$arrData['roundstat_unlocked'] = ((int) $this->session->userdata('adm_roundstat_ok') === 1);

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			$this->attachTopAdminFlag($arrData, $nLogId);
			
            $this->load->view('admin/header_adm', $arrData);
			$this->load->view('admin/roundstat_adm', $arrData);
            $this->load->view('admin/footer_adm');
		}
		else {
			redirect( base_url().'admin/login');
		}
	}

    public function charge()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{

			$arrData = getSidebarArray();
			$arrData['menuitem_4'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			$this->attachTopAdminFlag($arrData, $nLogId);
			
            $this->load->view('admin/header_adm', $arrData);
			$this->load->view('admin/charge_adm');
            $this->load->view('admin/footer_adm');
		}
		else {
			redirect( base_url().'admin/login');
		}
	}

	public function discharge()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{

			$arrData = getSidebarArray();
			$arrData['menuitem_5'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			$this->attachTopAdminFlag($arrData, $nLogId);
			
            $this->load->view('admin/header_adm', $arrData);
			$this->load->view('admin/discharge_adm');
            $this->load->view('admin/footer_adm');
		}
		else {
			redirect( base_url().'admin/login');
		}
	}


    public function transform()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{

			$arrData = getSidebarArray();
			$arrData['menuitem_6'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			$this->attachTopAdminFlag($arrData, $nLogId);
			
            $this->load->view('admin/header_adm', $arrData);
			$this->load->view('admin/transform_adm');
            $this->load->view('admin/footer_adm');
		}
		else {
			redirect( base_url().'admin/login');
		}
	}

    public function message()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{

			$arrData = getSidebarArray();
			$arrData['menuitem_7'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			$this->attachTopAdminFlag($arrData, $nLogId);
			
            $this->load->view('admin/header_adm', $arrData);
			$this->load->view('admin/message_adm');
            $this->load->view('admin/footer_adm');
		}
		else {
			redirect( base_url().'admin/login');
		}
	}


    public function exchange()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{

			$arrData = getSidebarArray();
			$arrData['menuitem_8'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			$this->attachTopAdminFlag($arrData, $nLogId);
			
            $this->load->view('admin/header_adm', $arrData);
			$this->load->view('admin/exchange_adm');
            $this->load->view('admin/footer_adm');
		}
		else {
			redirect( base_url().'admin/login');
		}
	}

    public function trace()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{

			$arrData = getSidebarArray();
			$arrData['menuitem_9'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			$this->attachTopAdminFlag($arrData, $nLogId);
			
            $this->load->view('admin/header_adm', $arrData);
			$this->load->view('admin/trace_adm');
            $this->load->view('admin/footer_adm');
		}
		else {
			redirect( base_url().'admin/login');
		}
	}

    public function order()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{

			$arrData = getSidebarArray();
			$arrData['menuitem_10'] = " is-active ";

			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			$this->attachTopAdminFlag($arrData, $nLogId);
			
            $this->load->view('admin/header_adm', $arrData);
			$this->load->view('admin/order_adm');
            $this->load->view('admin/footer_adm');
		}
		else {
			redirect( base_url().'admin/login');
		}
	}

	public function blockmanage()
	{
		$nLogId = trim($this->input->get('l'));
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{
			$this->load->model('member_model');
			$strUid = $this->sess_model->getUserId($nLogId);
			$objAdmin = $this->member_model->getInfoByUid($strUid);
			if(is_null($objAdmin) || (int) $objAdmin->mb_level !== 11){
				redirect(base_url().'admin');
				return;
			}

			$arrData = getSidebarArray();
			$arrData['menuitem_11'] = " is-active ";
			$this->load->model('confsite_model');
			$arrData['site_name'] = $this->confsite_model->getSiteName();
			$arrData['is_top_admin'] = true;

			$this->load->view('admin/header_adm', $arrData);
			$this->load->view('admin/blockmanage_adm');
			$this->load->view('admin/footer_adm');
		}
		else {
			redirect( base_url().'admin/login');
		}
	}

	private function attachTopAdminFlag(&$arrData, $nLogId){
		$arrData['is_top_admin'] = false;
		$this->load->model('member_model');
		$strUid = $this->sess_model->getUserId($nLogId);
		$objAdmin = $this->member_model->getInfoByUid($strUid);
		if(!is_null($objAdmin) && (int) $objAdmin->mb_level === 11){
			$arrData['is_top_admin'] = true;
		}
	}





}