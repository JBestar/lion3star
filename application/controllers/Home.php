<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index()
	{

		$nLogId = trim($this->input->get('l'));	
		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_USER_LEVEL))
		{
			$this->load->model('confsite_model');
			$strSiteName = $this->confsite_model->getSiteName();
			
			$this->load->view('client/main', array("site_name"=>$strSiteName));		
		}
		else {
			redirect( base_url().'login');
		}
		
	}

	public function pbg()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_USER_LEVEL))
		{
			$this->load->model('confsite_model');
			
			$strSiteName = $this->confsite_model->getSiteName();
			
			$this->load->view('client/powerball', array("site_name"=>$strSiteName));		
		}
		else {
			redirect( base_url().'login');
		}
	}

	public function coin_5()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_USER_LEVEL))
		{
			$this->load->model('confsite_model');
			
			$strSiteName = $this->confsite_model->getSiteName();
			
			$this->load->view('client/coin_5', array("site_name"=>$strSiteName));		
		}
		else {
			redirect( base_url().'login');
		}
	}

	public function eos_5()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_USER_LEVEL))
		{
			$this->load->model('confsite_model');
			
			$strSiteName = $this->confsite_model->getSiteName();
			
			$this->load->view('client/eos_5', array("site_name"=>$strSiteName));		
		}
		else {
			redirect( base_url().'login');
		}
	}

	public function vieworder()
	{
		$nLogId = trim($this->input->get('l'));	
		$nRoundId = trim($this->input->get('r'));
		$nGameId = trim($this->input->get('g'));
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_USER_LEVEL))
		{
			$this->load->model('confsite_model');
			$strSiteName = $this->confsite_model->getSiteName();

			$nDateNo = 0;
			$round_disp = $nRoundId;
			if($nGameId == GAME_COIN_5 || $nGameId == GAME_EOS_5){
				if($nRoundId < 1){
					$nDateNo --;
					$nRoundId = 288;
				}
				else if($nRoundId > 288){
					$nDateNo ++;
					$nRoundId = 1;
				}
					
			}

			$arrData = array("site_name"=>$strSiteName, "game_id"=>$nGameId, "round_id"=>$nRoundId, "date_no"=>$nDateNo);
			$this->load->view('client/vieworder', $arrData);		
		}
		else {
			redirect( base_url().'login');
		}
	}


	public function logout()
	{
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_USER_LEVEL))
		{
			$this->sess_model->logout($nLogId);
		}
		//$this->session->sess_destroy();
		redirect( base_url().'login', 'refresh');
	}
	

	public function maintain()
	{		

		$this->load->model('confsite_model');
		$strSiteName = $this->confsite_model->getSiteName();
		$objMaintain = $this->confsite_model->getMaintain();
		
		if(!is_null($objMaintain) && $objMaintain->conf_active == 1) {
			$this->load->view('client/maintain', array("site_name"=>$strSiteName, "objMaintain"=>$objMaintain));		
		} else {
			redirect( base_url().'login');		
		}
	}

}
