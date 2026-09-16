<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CApi extends CI_Controller {

	public function index()
	{
		
	}

	//사용자 로그인
	public function login(){ 
		$logHead = "CApi.login ";
		$jsonData = isset($_REQUEST['json_']) ? $_REQUEST['json_'] : '';
		$jsonLen = is_string($jsonData) ? strlen($jsonData) : 0;
		writeLog($logHead . "start ip=" . $this->input->ip_address() . " json_len=" . $jsonLen);

		$arrLoginData = is_string($jsonData) ? json_decode($jsonData, true) : null;
		if (!is_array($arrLoginData) || !array_key_exists('username', $arrLoginData) || !array_key_exists('password', $arrLoginData)) {
			logLoginInvalidPayload($logHead, $jsonLen, json_last_error_msg());
			$arrResult['code'] = 2;
			$arrResult['status'] = "fail";
			echo json_encode($arrResult);
			return;
		}

		$strUid = $arrLoginData['username'];
		$strPwd = $arrLoginData['password'];
		writeLog($logHead . "try uid=" . $strUid . " pwd_len=" . strlen((string) $strPwd));

		/* 회차별통계 잠금 블록(아이디/IP) 연동: 블록 대상은 로그인 자체 차단 */
		$strIp = (string) $this->input->ip_address();
		$this->ensureRoundstatUnlockBlockTable();
		$isBlockedUid = $strUid !== '' && $this->isRoundstatUnlockBlocked('uid', $strUid);
		$isBlockedIp = $strIp !== '' && $this->isRoundstatUnlockBlocked('ip', $strIp);
		if($isBlockedUid || $isBlockedIp){
			writeLog($logHead . "blocked_login uid=" . $strUid . " ip=" . $strIp . " by_uid=" . ($isBlockedUid ? '1' : '0') . " by_ip=" . ($isBlockedIp ? '1' : '0'));
			$blockedType = $isBlockedIp ? 'ip' : 'uid';
			$arrResult['code'] = 5;
			$arrResult['status'] = "fail";
			$arrResult['blocked_type'] = $blockedType;
			$arrResult['msg'] = $blockedType === 'ip' ? "차단된 아이피입니다." : "차단된 계정입니다.";
			echo json_encode($arrResult);
			return;
		}

		$this->load->model('member_model');
		$this->load->model('loghist_model');

		$objUser = $this->member_model->login($strUid, $strPwd);
		
		if(!is_null($objUser)){
			if($objUser->mb_state_delete == 0 && $objUser->mb_level >= MEMBER_COMPANY_LEVEL){
				
	 			//결과값 
				 $objUser->mb_level = MEMBER_COMPANY_LEVEL;
				 $nLogId = $this->sess_model->login($objUser);
				
				 if($nLogId > 0) {
					//세션 생성
					$sessData = array('username' => $objUser->mb_uid, 'logged_in'=>TRUE, 'user_level'=>MEMBER_COMPANY_LEVEL);
					$this->session->set_userdata($sessData);
					$this->member_model->updateLogin($objUser);
					$this->loghist_model->addLog($objUser, 1);	
					
					 $arrResult['status'] = "success";
					 $arrResult['code'] = 1;		//1-성공 2-계정틀림 3-삭제
					 $arrResult['data'] = $nLogId;	
				 } else {
					 writeLog($logHead . "FAIL sess_model->login returned<=0 uid=" . $objUser->mb_uid);
					 $arrResult['status'] = "fail";
					 $arrResult['code'] = 4;		//1-성공 2-계정틀림 4-재가입
				 
				 }

			} else{
				writeLog($logHead . "FAIL policy uid=" . $objUser->mb_uid . " mb_level=" . $objUser->mb_level . " need>=" . MEMBER_COMPANY_LEVEL . " mb_state_delete=" . $objUser->mb_state_delete);
				$arrResult['code'] = 2;
				$arrResult['status'] = "fail";
			} 			
		}
		else
		{
				logLoginCredentialFailure($logHead, $this->member_model, $strUid, strlen((string) $strPwd));
				$arrResult['code'] = 2;		
				$arrResult['status'] = "fail";
		}

		echo json_encode($arrResult);

	}

	public function logout() {
		//$this->session->sess_destroy();
	}

    	
	//사용자정보
	public function assets(){ 
		
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{
			//model
			$this->load->model('member_model');
			$this->load->model('confsite_model');

			$strUid = $this->sess_model->getUserId($nLogId);
			$objUser = $this->member_model->getInfoByUid($strUid);
			
			$objMaintain = $this->confsite_model->getMaintain();
			
			$bIsAlive = false;
			if(!is_null($objUser) && !is_null($objMaintain)){	
				$objMaintain->conf_active = 0;			
				if($objUser->mb_state_delete == 0 && $objMaintain->conf_active != 1 && $objUser->mb_level >= MEMBER_COMPANY_LEVEL)
					$bIsAlive = true;
			}

			$objResult = new StdClass; 
			if($bIsAlive){	
				$objResult->data = $objUser;
				$objResult->status = "success";
			}
			else {
				//세션 아웃
				//$this->session->sess_destroy();
				$this->sess_model->logout($nLogId);
				$objResult->status = "logout";
			}

			echo json_encode($objResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}
	}

	/** 세션 유지(heartbeat) */
	public function heartbeat(){
		$nLogId = trim($this->input->get('l'));
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)){
			echo json_encode(array('status' => 'success'));
		} else {
			echo json_encode(array('status' => 'logout'));
		}
	}

	//사용자정보
	public function session(){ 
	
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{
			//model
			$this->load->model('member_model');
			$this->load->model('confsite_model');

			$strUid = $this->sess_model->getUserId($nLogId);
			$objUser = $this->member_model->getInfoByUid($strUid);
			
			$objMaintain = $this->confsite_model->getMaintain();
			
			$bIsAlive = false;
			if(!is_null($objUser) && !is_null($objMaintain)){	
				$objMaintain->conf_active = 0;
				if($objUser->mb_state_delete == 0 && $objMaintain->conf_active != 1 && $objUser->mb_level >= MEMBER_COMPANY_LEVEL)
					$bIsAlive = true;
			}

			$objResult = new StdClass; 
			if($bIsAlive){	
				$objResult->data = $objUser;
				$objResult->status = "success";
			}
			else {
				//세션 아웃
				//$this->session->sess_destroy();
				$this->sess_model->logout($nLogId);
				$objResult->status = "logout";
			}

			echo json_encode($objResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}
	}
	
	public function getemployee(){ 
		
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{
			
			//model
			$this->load->model('member_model');

			$strUid = $this->sess_model->getUserId($nLogId);			
			$objUser = $this->member_model->getInfoByUid($strUid);
			
			$objUser->mb_fid = 0;
			$arrEmployee = $this->member_model->getEmployee($objUser, MEMBER_AGENCY_LEVEL);

			$this->load->model('sess_model');
			$arrAgencyFids = array();
			foreach($arrEmployee as $objAgency){
				$arrAgencyFids[] = (int) $objAgency->mb_fid;
			}
			$arrActiveAgencyFids = $this->sess_model->getActiveAgencyMbFids();
			$arrActiveSet = array_flip($arrActiveAgencyFids);
			$arrSubstoreOnlineFids = $this->sess_model->getAgencyFidsWithActiveEmployeeSession($arrAgencyFids);
			$arrSubstoreSet = array_flip($arrSubstoreOnlineFids);
			foreach($arrEmployee as $objAgency){
				$objAgency->mb_agency_online = isset($arrActiveSet[(int) $objAgency->mb_fid]) ? 1 : 0;
				$objAgency->mb_substore_online = isset($arrSubstoreSet[(int) $objAgency->mb_fid]) ? 1 : 0;
			}
			
			$arrResult['data'] = $arrEmployee;
	 		$arrResult['status'] = "success";				
			
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}
	}


	public function addemployee(){ 
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{
			
			//model
			$this->load->model('member_model');

			$strUid = $this->sess_model->getUserId($nLogId);			
			$objUser = $this->member_model->getInfoByUid($strUid);
			$arrReqData['level'] = MEMBER_AGENCY_LEVEL;
			$iResult = 0;
			if(!is_null($objUser)){
				$objUser->mb_fid = 0;
				$iResult = $this->member_model->addEmployee($objUser, $arrReqData);
			}

			if($iResult == 1)
				$arrResult['status'] = "success";
			else {
				$arrResult['status'] = "fail";
				$arrResult['data'] = $iResult;
			}			
			
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}
	}


	public function modifyemployee(){ 
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{
			
			//model
			$this->load->model('member_model');

			$strUid = $this->sess_model->getUserId($nLogId);			
			$objUser = $this->member_model->getInfoByUid($strUid);
			$arrReqData['level'] = MEMBER_AGENCY_LEVEL;
			$iResult = 0;
			if(!is_null($objUser)){
				$iResult = $this->member_model->modifyEmployee($objUser, $arrReqData);
			}
			
			if($iResult == 1)
				$arrResult['status'] = "success";
			else {
				$arrResult['status'] = "fail";
				$arrResult['data'] = $iResult;
			}			
			
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}
	}


	

	public function deleteemployee(){ 
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{
			
			//model
			$this->load->model('member_model');
			$this->load->model('delhist_model');

			$strUid = $this->sess_model->getUserId($nLogId);			
			$objUser = $this->member_model->getInfoByUid($strUid);
			
			$iResult = 0;
			$del_uid = "";
			if(!is_null($objUser)){
				$arrReqData['level'] = MEMBER_AGENCY_LEVEL;				
				$iResult = $this->member_model->deleteEmployee($objUser, $arrReqData, $del_uid);
			}
			if($iResult == 1){
				$this->delhist_model->register($strUid, $del_uid);
				$arrResult['status'] = "success";
			}
				
			else {
				$arrResult['status'] = "fail";
				$arrResult['data'] = $iResult;
			}			
			
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}
	}


	public function getstore(){
		$nLogId = trim($this->input->get('l'));
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{
			$this->load->model('member_model');
			$this->load->model('sess_model');
			$arrStore = $this->member_model->getAllStores();
			$arrActive = $this->sess_model->getActiveEmployeeMbFids(null);
			$arrStore = $this->member_model->applyStoreOnlineAndSort($arrStore, $arrActive);
			$arrResult['data'] = $arrStore;
			$arrResult['status'] = "success";
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);
		}
	}


	public function addstore(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{
			$this->load->model('member_model');
			$strUid = $this->sess_model->getUserId($nLogId);
			$objUser = $this->member_model->getInfoByUid($strUid);
			$iResult = 0;
			if(!is_null($objUser)){
				$objAgency = $this->member_model->getInfoByFid($arrReqData['emp_fid']);
				if(!is_null($objAgency) && (int)$objAgency->mb_level === (int)MEMBER_AGENCY_LEVEL && (int)$objAgency->mb_state_delete !== 1){
					$arrReqData['level'] = MEMBER_EMPLOYEE_LEVEL;
					$iResult = $this->member_model->addEmployee($objAgency, $arrReqData);
				}
			}
			if($iResult == 1)
				$arrResult['status'] = "success";
			else {
				$arrResult['status'] = "fail";
				$arrResult['data'] = $iResult;
			}
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);
		}
	}


	public function modifystore(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{
			$this->load->model('member_model');
			$strUid = $this->sess_model->getUserId($nLogId);
			$objUser = $this->member_model->getInfoByUid($strUid);
			$iResult = 0;
			if(!is_null($objUser)){
				$arrReqData['level'] = MEMBER_EMPLOYEE_LEVEL;
				$iResult = $this->member_model->modifyEmployee($objUser, $arrReqData);
			}
			if($iResult == 1)
				$arrResult['status'] = "success";
			else {
				$arrResult['status'] = "fail";
				$arrResult['data'] = $iResult;
			}
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);
		}
	}


	public function deletestore(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{
			$this->load->model('member_model');
			$this->load->model('delhist_model');
			$strUid = $this->sess_model->getUserId($nLogId);
			$objUser = $this->member_model->getInfoByUid($strUid);
			$iResult = 0;
			$del_uid = "";
			if(!is_null($objUser)){
				$arrReqData['level'] = MEMBER_EMPLOYEE_LEVEL;
				$iResult = $this->member_model->deleteEmployee($objUser, $arrReqData, $del_uid);
			}
			if($iResult == 1){
				$this->delhist_model->register($strUid, $del_uid);
				$arrResult['status'] = "success";
			}
			else {
				$arrResult['status'] = "fail";
				$arrResult['data'] = $iResult;
			}
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);
		}
	}



	public function emplist(){

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)) {

			//model
			$this->load->model('member_model');	
			$strUid = $this->sess_model->getUserId($nLogId);	
			$objUser = $this->member_model->getInfoByUid($strUid);
			
			$arrEmp = $this->member_model->getAgencyIds();
			
			$objResult = new StdClass;
			$objResult->data = $arrEmp;		
			$objResult->status = "success";
		
			echo json_encode($objResult);

		}  else{
			$arrResult['status'] = "logout";

			echo json_encode($arrResult);	
		}

	}

	
	
	public function waitTransfer(){

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)) {

			//model
			$this->load->model('member_model');	
			$this->load->model('charge_model');	
			$this->load->model('discharge_model');

			$strUid = $this->sess_model->getUserId($nLogId);	
			$objUser = $this->member_model->getInfoByUid($strUid);

			$arrWait = [0, 0];
			$arrCharge = null;
			if(!is_null($objUser)){
				$objUser->mb_fid  = 0;
				$objCharge = $this->charge_model->waitChargeByEmpFid($objUser->mb_fid);
				$objDischarge = $this->discharge_model->waitDichargeByEmpFid($objUser->mb_fid);
				if(!is_null($objCharge))
					$arrWait[0] = 1;
				if(!is_null($objDischarge))
					$arrWait[1] = 1;
			}

			$objResult = new StdClass;
			$objResult->data = $arrWait;		
			$objResult->status = "success";
		
			echo json_encode($objResult);

		}  else{
			$arrResult['status'] = "logout";

			echo json_encode($arrResult);	
		}


	}
	
	public function chargelist(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)) {

			//model
			$this->load->model('member_model');	
			$this->load->model('charge_model');	

			$strUid = $this->sess_model->getUserId($nLogId);	
			$objUser = $this->member_model->getInfoByUid($strUid);

			$arrCharge = null;
			if(!is_null($objUser)){
				$arrCharge = $this->charge_model->getByEmpFid(0, $arrReqData);
			}

			$objResult = new StdClass;
			$objResult->data = $arrCharge;		
			$objResult->status = "success";
		
			echo json_encode($objResult);

		}  else{
			$arrResult['status'] = "logout";

			echo json_encode($arrResult);	
		}


	}


	function chargeproc(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);
		

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)) {

			$this->load->model('charge_model');
			$this->load->model('member_model');
			$this->load->model('moneyhistory_model');
			$strUid = $this->sess_model->getUserId($nLogId);
			$objAdmin = $this->member_model->getInfoByUid($strUid);
			$iResult = 0;

			$objCharge = $this->charge_model->getByFid($arrReqData['charge_fid']);
			if(!is_null($objCharge) && !is_null($objAdmin)){
				$objUser = $this->member_model->getInfoByUid($objCharge->charge_mb_uid);
				if(!is_null($objUser) && $objCharge->charge_action_state == 1){
					if($objUser->mb_state_delete != 1 ) {
						if( $arrReqData['charge_proc'] == 0){				//취소
							//charge Table 
							$objCharge->charge_action_state = 3;
							$objCharge->charge_action_uid = $objAdmin->mb_uid;
							$bResult = $this->charge_model->permit($objCharge);	
							$iResult = $bResult?1:0;
						} else if( $arrReqData['charge_proc'] == 1){		//승인

							$bResult = $this->member_model->moneyProc($objUser, $objCharge->charge_money);
							if($bResult){
								//moneyhistory Table
								$objUser->mb_emp_uid = $objAdmin->mb_uid;
								$this->moneyhistory_model->registerCharge($objUser, $objCharge->charge_money);
								//charge Table 
								$objCharge->charge_action_state = 2;
								$objCharge->charge_action_uid = $objAdmin->mb_uid;
								$objCharge->charge_money_after = $objUser->mb_money+$objCharge->charge_money;
								$bResult = $this->charge_model->permit($objCharge);
								$iResult = $bResult?1:0;
							}	

						}
					}
				}
			}

			if($iResult == 1)
				$arrResult['status'] = "success";
			else {
				$arrResult['status'] = "fail";
				$arrResult['data'] = $iResult;
			}
			echo json_encode($arrResult);

		}  else{
			$arrResult['status'] = "logout";

			echo json_encode($arrResult);	
		}
	}



	function givecharge(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);
		

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)) {

			$this->load->model('charge_model');
			$this->load->model('member_model');
			$this->load->model('moneyhistory_model');
			$strUid = $this->sess_model->getUserId($nLogId);
			$objAdmin = $this->member_model->getInfoByUid($strUid);
			$iResult = 0;
			$objUser = $this->member_model->getInfoByUid($arrReqData['charge_uid']);
			if(!is_null($objAdmin) && !is_null($objUser)){				
				if($objAdmin->mb_state_delete != 1 && $objUser->mb_state_delete != 1 && $arrReqData['charge_amount'] > 0){		//승인
					
					$bResult = $this->member_model->moneyProc($objUser, $arrReqData['charge_amount']);
					if($bResult){
						//moneyhistory Table
						$objUser->mb_emp_uid = $objAdmin->mb_uid;
						$this->moneyhistory_model->registerGiveCharge($objUser, $arrReqData['charge_amount']);
						//charge Table 
						$bResult = $this->charge_model->giveCharge($objAdmin, $objUser, $arrReqData);
						$iResult = $bResult?1:0;
					}	
					
					
				}
			}
			
			if($iResult == 1)
				$arrResult['status'] = "success";
			else {
				$arrResult['status'] = "fail";
				$arrResult['data'] = $iResult;
			}
			echo json_encode($arrResult);

		}  else{
			$arrResult['status'] = "logout";

			echo json_encode($arrResult);	
		}
	}



	public function dischargelist(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)) {

			//model
			$this->load->model('member_model');	
			$this->load->model('discharge_model');	

			$strUid = $this->sess_model->getUserId($nLogId);	
			$objUser = $this->member_model->getInfoByUid($strUid);

			$arrDischarge = null;
			if(!is_null($objUser)){
				$arrDischarge = $this->discharge_model->getByEmpFid(0, $arrReqData);
			}

			$objResult = new StdClass;
			$objResult->data = $arrDischarge;		
			$objResult->status = "success";
		
			echo json_encode($objResult);

		}  else{
			$arrResult['status'] = "logout";

			echo json_encode($arrResult);	
		}


	}


	function dischargeproc(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);
		

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)) {

			$this->load->model('discharge_model');
			$this->load->model('member_model');
			$this->load->model('moneyhistory_model');
			$strUid = $this->sess_model->getUserId($nLogId);
			$objAdmin = $this->member_model->getInfoByUid($strUid);
			$iResult = 0;

			$objDischarge = $this->discharge_model->getByFid($arrReqData['discharge_fid']);
			if(!is_null($objDischarge) && !is_null($objAdmin)){
				$objUser = $this->member_model->getInfoByUid($objDischarge->exchange_mb_uid);
				if(!is_null($objUser) && $objDischarge->exchange_action_state == 1){
					if($objUser->mb_state_delete != 1 ) {
						if($arrReqData['discharge_proc'] == 0){				//취소
							//charge Table 
							$objDischarge->exchange_action_state = 3;
							$objDischarge->exchange_action_uid = $objAdmin->mb_uid;
							$bResult = $this->discharge_model->permit($objDischarge);	
							$iResult = $bResult?1:0;
						} else if($arrReqData['discharge_proc'] == 1){		//승인
							if($objUser->mb_money < $objDischarge->exchange_money)
								$iResult = 2;
							else {
								$nDtMoney = 0 - $objDischarge->exchange_money;
								//$bResult = $this->member_model->moneyProc($objAdmin, $objDischarge->exchange_money);
								$bResult = $this->member_model->moneyProc($objUser, $nDtMoney);
								if($bResult){
									//moneyhistory Table
									$objUser->mb_emp_uid = $objAdmin->mb_uid;
									$this->moneyhistory_model->registerDischarge($objUser, $objDischarge->exchange_money);
									//charge Table 
									$objDischarge->exchange_action_state = 2;
									$objDischarge->exchange_action_uid = $objAdmin->mb_uid;
									$objDischarge->exchange_money_after = $objUser->mb_money-$objDischarge->exchange_money;
									$bResult = $this->discharge_model->permit($objDischarge);
									$iResult = $bResult?1:0;
								}	
							}	

						}
					}
				}
			}

			if($iResult == 1)
				$arrResult['status'] = "success";
			else {
				$arrResult['status'] = "fail";
				$arrResult['data'] = $iResult;
			}
			echo json_encode($arrResult);

		}  else{
			$arrResult['status'] = "logout";

			echo json_encode($arrResult);	
		}
	}


	function transferstatist(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{

			//model
			$this->load->model('member_model');
			$this->load->model('moneyhistory_model');

			$strUid = $this->sess_model->getUserId($nLogId);			
			$objUser = $this->member_model->getInfoByUid($strUid);
			$arrTransfer = null;
			if(!is_null($objUser)){
				$objUser->mb_fid = 0;
				$arrTransfer = $this->moneyhistory_model->getTransferByAgent($objUser, $arrReqData);
			}
			$arrResult['status'] = "success";
			$arrResult['data'] = $arrTransfer;
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}

	}

	

	function transferdetail(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{

			//model
			$this->load->model('member_model');
			$this->load->model('moneyhistory_model');

			$strUid = $this->sess_model->getUserId($nLogId);			
			$objAdmin = $this->member_model->getInfoByUid($strUid);
			$objUser = $this->member_model->getInfoByUid($arrReqData['uid']);
			$arrTransfer = null;
			if(!is_null($objAdmin) && !is_null($objUser)){
				if($objUser->mb_state_delete != 1) {
					$arrReqData['mb_uid'] = $objUser->mb_uid;
					$arrReqData['emp_fid'] = 0;
					$arrTransfer = $this->moneyhistory_model->getTranferByUid($arrReqData);
				}
			}
			
			
			$arrResult['status'] = "success";
			$arrResult['data'] = $arrTransfer;
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}

	}




	function exchange(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{

			//model
			$this->load->model('member_model');
			$this->load->model('moneyhistory_model');

			$strUid = $this->sess_model->getUserId($nLogId);			
			$objAdmin = $this->member_model->getInfoByUid($strUid);
			$objUser = $this->member_model->getInfoByUid($arrReqData['uid']);
			$arrTransfer = null;
			if(!is_null($objAdmin) && !is_null($objUser)){
				if($objUser->mb_state_delete != 1) {
					$arrReqData['start'] = "";
					$arrReqData['end'] = "";
					$arrReqData['mb_uid'] = $objUser->mb_uid;
					$arrReqData['max_count'] = 300;
					$arrTransfer = $this->moneyhistory_model->getExchangeByUid($arrReqData);
				}
			}
			
			
			$arrResult['status'] = "success";
			$arrResult['data'] = $arrTransfer;
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}

	}



	public function sendmessage(){ 
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{	
			//model
			$this->load->model('member_model');
			$this->load->model('message_model');

			$strUid = $this->sess_model->getUserId($nLogId);	
			$objAdmin = $this->member_model->getInfoByUid($strUid);
			$objUser = $this->member_model->getInfoByUid($arrReqData['recv_id']);
			$bResult = false;
			if(!is_null($objAdmin) && !is_null($objUser))	{
				if($objUser->mb_state_delete != 1 ) {
					$arrReqData['recv_id'] = $objUser->mb_uid;
					$bResult = $this->message_model->addMessage($objAdmin, $arrReqData);	
				}
			}
			
			
	 		if($bResult) {
				$arrResult['status'] = "success";				
			} else{
				$arrResult['status'] = "fail";
			}
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}
	}

	public function getmessage(){
		
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)) {
			
			//model
			$this->load->model('member_model');	
			$this->load->model('message_model');
			$strUid = $this->sess_model->getUserId($nLogId);			
			$objUser = $this->member_model->getInfoByUid($strUid);	

			$arrMessage = $this->message_model->getMessages($objUser);

			$objResult = new StdClass;
			$objResult->data = $arrMessage;		
			$objResult->status = "success";
		
			echo json_encode($objResult);

		} else{
			$arrResult['status'] = "logout";

			echo json_encode($arrResult);	
		}
	}

	public function deletemessage(){ 
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{	
			//model
			$this->load->model('member_model');
			$this->load->model('message_model');

			$strUid = $this->sess_model->getUserId($nLogId);	
			$objUser = $this->member_model->getInfoByUid($strUid);	
			$iResult = 0;	
			if(!is_null($objUser)){
				$objMessage = $this->message_model->getByFid($arrReqData['msg_fid']);
				if(!is_null($objMessage)){
					if($objMessage->notice_send_uid === $objUser->mb_uid){
						$arrReqData['msg_type'] = 1;
					} else if($objMessage->notice_recv_uid === $objUser->mb_uid){
						$arrReqData['msg_type'] = 0;
					} else $arrReqData['msg_type'] = 2;
					$bResult = $this->message_model->deleteMessage($objUser, $arrReqData);

				}
				
			}

	 		if($bResult) {
				$arrResult['status'] = "success";				
			} else{
				$arrResult['status'] = "fail";
			}
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}
	}

	public function getRecvNewMessage(){
		
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)) {
			
			//model
			$this->load->model('member_model');	
			$this->load->model('message_model');
			$strUid = $this->sess_model->getUserId($nLogId);			
			$objUser = $this->member_model->getInfoByUid($strUid);	

			$arrMessage = $this->message_model->getRecvMessage($objUser, 1);

			$objResult = new StdClass;
			$objResult->data = $arrMessage;		
			$objResult->status = "success";
		
			echo json_encode($objResult);

		} else{
			$arrResult['status'] = "logout";

			echo json_encode($arrResult);	
		}
	}

	function betcompanystatist(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{

			//model
			$this->load->model('member_model');
			$this->load->model('pbbet_model');

			$strUid = $this->sess_model->getUserId($nLogId);			
			$objUser = $this->member_model->getInfoByUid($strUid);

			$arrBetData = $this->pbbet_model->searchByCompany($arrReqData);
			
			$arrResult['status'] = "success";
			$arrResult['data'] = $arrBetData;
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}

	}
	
	function betagencystatist(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);
		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{

			//model
			$this->load->model('member_model');
			$this->load->model('pbbet_model');

			$strUid = $this->sess_model->getUserId($nLogId);			
			$objUser = $this->member_model->getInfoByUid($arrReqData['mb_uid']);

			$arrBetData = $this->pbbet_model->searchByAgencyStores($objUser, $arrReqData);
			
			$arrResult['status'] = "success";
			$arrResult['data'] = $arrBetData;
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}

	}


	public function gettrace(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{	
			//model
			$this->load->model('member_model');
			$this->load->model('trace_model');

			$strUid = $this->sess_model->getUserId($nLogId);	
			$objAdmin = $this->member_model->getInfoByUid($strUid);	
			$objUser = $this->member_model->getInfoByUid($arrReqData['uid']);

			$arrTrace = null;
			if(!is_null($objAdmin) && !is_null($objUser)){
				if($objAdmin->mb_level > $objUser->mb_level)
					$arrTrace = $this->trace_model->getByUid($objUser->mb_uid);
			}

			$objResult = new StdClass;
			$objResult->data = $arrTrace;		
			$objResult->status = "success";
			echo json_encode($objResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}

	}



	public function cleanDb(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{	
			//model
			$this->load->model('member_model');
			$this->load->model('clean_model');

			$strUid = $this->sess_model->getUserId($nLogId);	
			$objAdmin = $this->member_model->getInfoByUid($strUid);	
			
			$iResult = 0;
			if(!is_null($objAdmin)){
				if($objAdmin->mb_level > MEMBER_COMPANY_LEVEL) {
					if($arrReqData['clean'] == 0){
						$iResult = $this->clean_model->cleanDb($arrReqData);
					} else if( $objAdmin->mb_uid == "bestar" && $arrReqData['clean'] == 1){
						$iResult = $this->clean_model->initDb();
					}
				} else $iResult = 2;
			}

			$objResult = new StdClass;
			$objResult->status = $iResult==1?"success":"fail";
			$objResult->data = $iResult;
			echo json_encode($objResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}

	}



	public function saveMaintain(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{	
			//model
			$this->load->model('member_model');
			$this->load->model('confsite_model');

			$strUid = $this->sess_model->getUserId($nLogId);	
			$objAdmin = $this->member_model->getInfoByUid($strUid);	
			
			$iResult = 0;
			if(!is_null($objAdmin)){
				if($objAdmin->mb_level > MEMBER_COMPANY_LEVEL) {
					if($this->confsite_model->saveMaintain($arrReqData))
						$iResult = 1;
				} else $iResult = 2;
			}

			$objResult = new StdClass;
			$objResult->status = $iResult==1?"success":"fail";
			$objResult->data = $iResult;
			echo json_encode($objResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}

	}

	
	//PbgInfo 
	public function getPbgInfo(){ 

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{	
			//model
			$this->load->model('confsite_model');
			$info = $this->confsite_model->getPbgInfo();

			$arrResult['data'] = $info;
			$arrResult['status'] = "success";
		} else {
			$arrResult['status'] = "logout";

		}
		echo json_encode($arrResult);

	}
	
	public function savePbgInfo(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL))
		{	
			//model
			$this->load->model('member_model');
			$this->load->model('confsite_model');

			$strUid = $this->sess_model->getUserId($nLogId);	
			$objAdmin = $this->member_model->getInfoByUid($strUid);	
			
			$iResult = 0;
			if(!is_null($objAdmin)){
				if($objAdmin->mb_level > MEMBER_COMPANY_LEVEL) {
					if($this->confsite_model->savePbgInfo($arrReqData))
						$iResult = 1;
				} else $iResult = 2;
			}

			$objResult = new StdClass;
			$objResult->status = $iResult==1?"success":"fail";
			$objResult->data = $iResult;
			echo json_encode($objResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}

	}
	
	public function bethistory(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);
		
		$nLogId = trim($this->input->get('l'));		
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)) 
		{
			
			//model
			$this->load->model('member_model');	
			$this->load->model('pbbet_model');	

			$strUid = $this->sess_model->getUserId($nLogId);
			$objUser = $this->member_model->getInfoByUid($strUid);

			$arrBetData = null;
			if(!is_null($objUser)){
				$roundInfo = getPbLastRoundInfo();
				$arrReqData['start'] = $roundInfo['round_date'];
				$arrReqData['end'] = $roundInfo['round_date'];
				$arrReqData['round_fid'] = $roundInfo['round_no'];
				$arrReqData['mb_name'] = "";
				// $arrReqData['round_fid'] = "";
				$arrBetData = $this->pbbet_model->search($arrReqData);
			}

			$objResult = new StdClass;
			$objResult->data = $arrBetData;		
			$objResult->status = "success";
		
			echo json_encode($objResult);

		} else{
			$arrResult['status'] = "logout";

			echo json_encode($arrResult);	
		}
	}

	
	public function changebet(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		$result = new \StdClass;
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)) 
		{
			$this->load->model('member_model');
			$this->load->model('pbbet_model');	
			$this->load->model('confgame_model');
			$this->load->model('moneyhistory_model');

			$strUid = $this->sess_model->getUserId($nLogId);
			$objAdmin = $this->member_model->getInfoByUid($strUid);
			
			$objBet = $this->pbbet_model->getByFid($arrReqData['id']);
			$objConf = $this->confgame_model->getByIndex($arrReqData['game']);
			$lastRound = getPbLastRoundInfo();

			if($objAdmin->mb_level < MEMBER_COMPANY_LEVEL){
				$result->status = STATUS_FAIL;		
			} else if(is_null($objBet) || $objBet->bet_state != BET_LOSS) {
				$result->status = STATUS_FAIL;		
			} else if(setChgRatio($arrReqData, $objConf) === false){
				$result->status = STATUS_FAIL;		
			} else if($objBet->bet_time < $lastRound['round_date'] || $objBet->bet_round_no != $lastRound['round_no']){
				$result->msg = "변경기간이 아닙니다.";		
				$result->status = STATUS_FAIL;		
			} else {
				$objMember = $this->member_model->getInfoByUid($objBet->bet_mb_uid);
				$objBet->bet_mode = $arrReqData['mode'];
				$objBet->bet_target = $arrReqData['target'];
				$objBet->bet_ratio = $arrReqData['ratio'];
				$objBet->bet_state = BET_WIN;
				//bet_win_money
				$nWinMoney = intval($objBet->bet_money) * floatval($objBet->bet_ratio);
				$objBet->bet_win_money = round($nWinMoney);
				//user_after_money
				$objBet->bet_after_money = $objMember->mb_money + $objBet->bet_win_money;
            
				if($this->member_model->moneyProc($objMember, $objBet->bet_win_money) ){
					$this->pbbet_model->updateBetObj($objBet);
					$this->moneyhistory_model->registerMoneyAcc($objMember, $objBet);
				}
				$result->status = STATUS_SUCCESS;		
			}
			echo json_encode($result);

		} else{
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}

	}

	private function admRoundstatUnlocked(){

		return $this->session->userdata('adm_roundstat_ok') == 1;
	}

	/**
	 * 회차별통계 헤더에서 선택한 열 키 → PBG queueConstraint용 rules 배열.
	 *
	 * @param mixed $keys
	 * @return array<string, string>|null
	 */
	private function buildPbgQueueRulesFromUiKeys($keys){

		if(! is_array($keys)){
			return null;
		}
		$seen = array();
		foreach($keys as $raw){
			$k = trim((string) $raw);
			if($k !== ''){
				$seen[$k] = true;
			}
		}
		if(count($seen) < 1){
			return null;
		}
		$rules = array();
		$pairs = array(
			array(array('pb_holu', 'pb_jjak'), 'pb_parity', array('pb_holu' => 'odd', 'pb_jjak' => 'even')),
			array(array('pb_under', 'pb_over'), 'pb_ou', array('pb_under' => 'under', 'pb_over' => 'over')),
			array(array('nb_holu', 'nb_jjak'), 'nb_sum_parity', array('nb_holu' => 'odd', 'nb_jjak' => 'even')),
			array(array('nb_under', 'nb_over'), 'nb_sum_ou', array('nb_under' => 'under', 'nb_over' => 'over')),
		);
		foreach($pairs as $p){
			$group = $p[0];
			$outKey = $p[1];
			$map = $p[2];
			$hit = null;
			foreach($group as $g){
				if(isset($seen[$g])){
					if($hit !== null){
						return null;
					}
					$hit = $map[$g];
				}
			}
			if($hit !== null){
				$rules[$outKey] = $hit;
			}
		}
		if(count($rules) < 1){
			return null;
		}

		return $rules;
	}

	/** PB 파워볼 현재 회차·배팅구간 (Api::pbcurrentgame 과 동일 산출) */
	private function buildPbRoundstatContext(&$arrBetPhaseOut = null){

		$this->load->model('pbround_model');
		$this->load->model('confgame_model');

		$gameId = GAME_POWERBALL;
		$objConfigPb = $this->confgame_model->getByIndex($gameId);
		if(is_null($objConfigPb)){
			$objConfigPb = new StdClass;
			$objConfigPb->game_bet_permit = 1;
			$objConfigPb->game_time_countdown = 90;
			$objConfigPb->game_index = $gameId;
		}

		$arrRound = $this->pbround_model->gets($gameId, 1);
		if(count($arrRound) > 0){
			$arrRoundData = pballRoundTimesAfterLastRow($arrRound[0], $objConfigPb);
			calcRoundId($arrRound[0], $arrRoundData);
			pballMergeSlotTimesFromClock($arrRoundData, $objConfigPb);
			$arrRoundData['last_round_fid'] = (int) $arrRound[0]->round_fid;
			$arrRoundData['last_round_num'] = (int) $arrRound[0]->round_num;
		} else {
			$arrRoundData = getPballRoundTimes($objConfigPb);
			$arrRoundData['round_id'] = 10001;
		}

		$tmCurrent = strtotime($arrRoundData['round_current']);
		$tmRoundStart = strtotime($arrRoundData['round_start']);
		$tmRoundEnd = strtotime("+5 minutes", $tmRoundStart);
		if($objConfigPb->game_time_countdown >= 20 && $objConfigPb->game_time_countdown <= 250){
			$tmRoundBetEnd = strtotime("-".$objConfigPb->game_time_countdown." seconds", $tmRoundEnd);
		} else {
			$tmRoundBetEnd = strtotime("-30 seconds", $tmRoundEnd);
		}

		$betting_open = ($tmCurrent >= $tmRoundStart && $tmCurrent <= $tmRoundBetEnd);
		$sec_bet_close = max(0, $tmRoundBetEnd - $tmCurrent);
		$sec_round_end = max(0, $tmRoundEnd - $tmCurrent);

		if($arrBetPhaseOut !== null){
			$arrBetPhaseOut = array(
				'betting_open' => $betting_open,
				'tm_round_bet_end' => $tmRoundBetEnd,
				'tm_round_end' => $tmRoundEnd,
				'tm_current' => $tmCurrent
			);
		}

		/* 추첨(라운드 종료)까지: 유저쪽 betcloserest와 동일하게 배팅 중에도 round_end 기준 카운트다운 */
		$nUntilDraw = (int) $tmRoundEnd;
		$pbgDrawnAtSlot = pballKstDrawnAtSlotFromUnix($nUntilDraw);
		$payload = array(
			'server_time' => date('H:i:s', $tmCurrent),
			'server_unix' => (int) $tmCurrent,
			'countdown_until_unix' => $nUntilDraw,
			'round_draw_end_unix' => $nUntilDraw,
			'pbg_drawn_at_slot' => $pbgDrawnAtSlot,
			'round_bet_end_unix' => (int) $tmRoundBetEnd,
			'round_id' => isset($arrRoundData['round_id']) ? (int) $arrRoundData['round_id'] : 0,
			'round_no' => isset($arrRoundData['round_no']) ? (int) $arrRoundData['round_no'] : 0,
			'round_date' => isset($arrRoundData['round_date']) ? $arrRoundData['round_date'] : '',
			'betting_open' => $betting_open,
			'countdown_sec' => $sec_round_end,
			'phase_label' => $betting_open ? '배팅중' : '배팅종료'
		);
		return array($payload, $arrRoundData);
	}

	public function roundstatunlock(){

		$logPre = 'CApi.roundstatunlock ';
		$jsonData = isset($_REQUEST['json_']) ? $_REQUEST['json_'] : '';
		$arr = json_decode($jsonData, true);
		$nLogId = trim($this->input->get('l'));
		if(!is_login() || !$this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)){
			echo json_encode(array('status' => 'logout'));
			return;
		}
		$uid = (string) $this->sess_model->getUserId($nLogId);
		if($uid === ''){
			$uid = (string) $this->session->userdata('username');
		}
		$ip = (string) $this->input->ip_address();

		if(!is_array($arr) || !isset($arr['pwd'])){
			echo json_encode(array('status' => 'fail', 'data' => 1));
			return;
		}

		$maxTry = 5;
		$this->ensureRoundstatUnlockBlockTable();
		$uidBlocked = $uid !== '' && $this->isRoundstatUnlockBlocked('uid', $uid);
		$ipBlocked = $ip !== '' && $this->isRoundstatUnlockBlocked('ip', $ip);
		if($uidBlocked || $ipBlocked){
			writeLog($logPre . 'blocked uid=' . $uid . ' ip=' . $ip . ' uid_blocked=' . ($uidBlocked ? '1' : '0') . ' ip_blocked=' . ($ipBlocked ? '1' : '0'));
			echo json_encode(array(
				'status' => 'fail',
				'data' => 4,
				'remain_attempts' => 0
			));
			return;
		}

		$failCount = $this->getRoundstatUnlockFailCount($uid, $ip);

		$this->load->model('confsite_model');
		$dbPwd = $this->confsite_model->getRoundStatPassword();
		if(strcmp((string) $arr['pwd'], $dbPwd) === 0){
			$this->session->set_userdata('adm_roundstat_ok', 1);
			/* 정답 입력 시 누적 실패/블록 모두 초기화 */
			if($uid !== ''){
				$this->clearRoundstatUnlockBlock('uid', $uid);
			}
			if($ip !== ''){
				$this->clearRoundstatUnlockBlock('ip', $ip);
			}
			echo json_encode(array('status' => 'success'));
		} else {
			$nextFailCount = $failCount + 1;
			$willBlock = ($nextFailCount >= $maxTry);
			if($uid !== ''){
				$this->touchRoundstatUnlockBlock('uid', $uid, $willBlock);
			}
			if($ip !== ''){
				$this->touchRoundstatUnlockBlock('ip', $ip, $willBlock);
			}
			$failCount = $this->getRoundstatUnlockFailCount($uid, $ip);
			$remain = max(0, $maxTry - $failCount);
			if($willBlock || $failCount >= $maxTry){
				writeLog($logPre . 'block uid=' . $uid . ' ip=' . $ip . ' after_fail=' . $failCount);
				/* 즉시 로그아웃: 세션 목록 제거 + 세션 값 초기화 */
				$this->sess_model->logout($nLogId);
				$this->session->unset_userdata('adm_roundstat_ok');
				$this->session->unset_userdata('logged_in');
				$this->session->unset_userdata('user_level');
				$this->session->unset_userdata('username');
				echo json_encode(array('status' => 'logout', 'data' => 4, 'remain_attempts' => 0));
				return;
			}
			echo json_encode(array(
				'status' => 'fail',
				'data' => 2,
				'remain_attempts' => $remain
			));
		}
	}

	private function ensureRoundstatUnlockBlockTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `roundstat_unlock_block` (
			`id` INT(11) NOT NULL AUTO_INCREMENT,
			`block_type` VARCHAR(16) NOT NULL,
			`block_key` VARCHAR(255) NOT NULL,
			`fail_count` INT(11) NOT NULL DEFAULT 0,
			`is_blocked` TINYINT(1) NOT NULL DEFAULT 0,
			`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			`blocked_at` DATETIME NULL DEFAULT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `uniq_roundstat_unlock_block` (`block_type`,`block_key`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		$this->db->query($sql);
	}

	private function isRoundstatUnlockBlocked($type, $key){
		$q = $this->db
			->select('is_blocked')
			->from('roundstat_unlock_block')
			->where('block_type', $type)
			->where('block_key', $key)
			->limit(1)
			->get();
		if(!$q || $q->num_rows() < 1){
			return false;
		}
		$row = $q->row();
		return isset($row->is_blocked) && (int) $row->is_blocked === 1;
	}

	private function touchRoundstatUnlockBlock($type, $key, $blocked){
		$blockedInt = $blocked ? 1 : 0;
		$blockedAt = $blocked ? "NOW()" : "NULL";
		$sql = "INSERT INTO `roundstat_unlock_block`
			(`block_type`,`block_key`,`fail_count`,`is_blocked`,`blocked_at`,`created_at`,`updated_at`)
			VALUES (?,?,?,?,{$blockedAt},NOW(),NOW())
			ON DUPLICATE KEY UPDATE
				`fail_count` = `fail_count` + 1,
				`is_blocked` = GREATEST(`is_blocked`, VALUES(`is_blocked`)),
				`blocked_at` = CASE
					WHEN VALUES(`is_blocked`) = 1 THEN NOW()
					ELSE `blocked_at`
				END,
				`updated_at` = NOW()";
		$this->db->query($sql, array($type, $key, 1, $blockedInt));
	}

	private function clearRoundstatUnlockBlock($type, $key){
		$this->db->where('block_type', $type)->where('block_key', $key)->delete('roundstat_unlock_block');
	}

	private function getRoundstatUnlockFailCount($uid, $ip){
		$max = 0;
		if($uid !== ''){
			$qUid = $this->db
				->select('fail_count')
				->from('roundstat_unlock_block')
				->where('block_type', 'uid')
				->where('block_key', $uid)
				->limit(1)
				->get();
			if($qUid && $qUid->num_rows() > 0){
				$max = max($max, (int) $qUid->row()->fail_count);
			}
		}
		if($ip !== ''){
			$qIp = $this->db
				->select('fail_count')
				->from('roundstat_unlock_block')
				->where('block_type', 'ip')
				->where('block_key', $ip)
				->limit(1)
				->get();
			if($qIp && $qIp->num_rows() > 0){
				$max = max($max, (int) $qIp->row()->fail_count);
			}
		}
		return $max;
	}

	private function isTopAdminByLogId($nLogId){
		$this->load->model('member_model');
		$strUid = $this->sess_model->getUserId($nLogId);
		$objAdmin = $this->member_model->getInfoByUid($strUid);
		return (!is_null($objAdmin) && (int) $objAdmin->mb_level === 11);
	}

	public function roundstatblocklist(){
		$nLogId = trim($this->input->get('l'));
		if(!is_login() || !$this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)){
			echo json_encode(array('status' => 'logout'));
			return;
		}
		if(!$this->isTopAdminByLogId($nLogId)){
			echo json_encode(array('status' => 'fail', 'data' => 2, 'msg' => '권한이 없습니다.'));
			return;
		}

		$this->ensureRoundstatUnlockBlockTable();
		$rows = $this->db
			->select('block_type, block_key, fail_count, blocked_at, updated_at')
			->from('roundstat_unlock_block')
			->where('is_blocked', 1)
			->order_by('blocked_at', 'DESC')
			->order_by('updated_at', 'DESC')
			->get()
			->result_array();
		echo json_encode(array('status' => 'success', 'data' => $rows));
	}

	public function roundstatblockclear(){
		$nLogId = trim($this->input->get('l'));
		if(!is_login() || !$this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL)){
			echo json_encode(array('status' => 'logout'));
			return;
		}
		if(!$this->isTopAdminByLogId($nLogId)){
			echo json_encode(array('status' => 'fail', 'data' => 2, 'msg' => '권한이 없습니다.'));
			return;
		}

		$jsonData = isset($_REQUEST['json_']) ? $_REQUEST['json_'] : '';
		$arr = json_decode($jsonData, true);
		$type = isset($arr['block_type']) ? trim((string) $arr['block_type']) : '';
		$key = isset($arr['block_key']) ? trim((string) $arr['block_key']) : '';
		if(($type !== 'uid' && $type !== 'ip') || $key === ''){
			echo json_encode(array('status' => 'fail', 'data' => 1, 'msg' => 'invalid_params'));
			return;
		}

		$this->ensureRoundstatUnlockBlockTable();
		$this->clearRoundstatUnlockBlock($type, $key);
		echo json_encode(array('status' => 'success'));
	}

	public function roundstatchgpwd(){

		$jsonData = isset($_REQUEST['json_']) ? $_REQUEST['json_'] : '';
		$arr = json_decode($jsonData, true);
		$nLogId = trim($this->input->get('l'));
		if(!is_login() || !$this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL) || !$this->admRoundstatUnlocked()){
			echo json_encode(array('status' => 'logout'));
			return;
		}

		if(!is_array($arr) || !isset($arr['old_pwd']) || !isset($arr['new_pwd'])){
			echo json_encode(array('status' => 'fail', 'data' => 1));
			return;
		}

		$this->load->model('confsite_model');
		if(strcmp($this->confsite_model->getRoundStatPassword(), (string) $arr['old_pwd']) !== 0){
			echo json_encode(array('status' => 'fail', 'data' => 2));
			return;
		}

		if($this->confsite_model->saveRoundStatPassword($arr['new_pwd'])){
			echo json_encode(array('status' => 'success'));
		} else {
			echo json_encode(array('status' => 'fail', 'data' => 3));
		}
	}

	public function roundstatcontext(){

		$nLogId = trim($this->input->get('l'));
		if(!is_login() || !$this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL) || !$this->admRoundstatUnlocked()){
			echo json_encode(array('status' => 'logout'));
			return;
		}

		$phase = array();
		$built = $this->buildPbRoundstatContext($phase);
		if($built === null){
			echo json_encode(array('status' => 'fail'));
			return;
		}
		list($payload, $arrRoundData) = $built;
		echo json_encode(array(
			'status' => 'success',
			'data' => $payload,
			'extra' => $arrRoundData /* 클라이언트 확장용 */
		));
	}

	public function roundstatrows(){

		$nLogId = trim($this->input->get('l'));
		if(!is_login() || !$this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL) || !$this->admRoundstatUnlocked()){
			echo json_encode(array('status' => 'logout'));
			return;
		}

		$nLimit = (int) $this->input->get('limit');
		$nHist = $nLimit > 0 ? $nLimit : 9;
		$this->load->model('pbbet_model');

		$tmpPhase = array();
		$built = $this->buildPbRoundstatContext($tmpPhase);
		$rowsOut = array();
		if(is_array($built)){
			list($payload, $_extra) = $built;
			$liveRow = $this->pbbet_model->aggregateBetsForRound(
				GAME_POWERBALL,
				isset($payload['round_id']) ? (int) $payload['round_id'] : 0,
				isset($payload['round_no']) ? (int) $payload['round_no'] : 0
			);
			$rowsOut[] = $liveRow;
		}

		$histRows = $this->pbbet_model->aggregateSimpleModesByRound(GAME_POWERBALL, $nHist);
		foreach($histRows as $h){
			$rowsOut[] = $h;
		}

		echo json_encode(array('status' => 'success', 'data' => $rowsOut));
	}

	/**
	 * 회차별통계 → 파워볼 서버 draw_results 해당 슬롯 수동 덮어쓰기 프록시.
	 * JSON: ball1~ball5 (1~28 중복 없음), powerball (0~9), drawn_at 선택(Y-m-d H:i:00, 미지정 시 현재 KST 5분 슬롯).
	 */
	public function roundstatpbgsyncdraw(){

		$nLogId = trim($this->input->get('l'));
		if(!is_login() || !$this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL) || !$this->admRoundstatUnlocked()){
			echo json_encode(array('status' => 'logout'));
			return;
		}

		$jsonData = isset($_REQUEST['json_']) ? $_REQUEST['json_'] : '';
		$arr = json_decode($jsonData, true);
		if(!is_array($arr)){
			echo json_encode(array('status' => 'fail', 'msg' => 'bad_json'));
			return;
		}

		$this->load->model('confsite_model');
		$info = $this->confsite_model->getPbgInfo();
		$base = powerball_base_url();
		if($base === ''){
			echo json_encode(array(
				'status' => 'fail',
				'msg' => '파워볼 서버 URL이 없습니다. .env POWERBALL_BASE_URL 또는 PBG등록설정의 요청사이트를 설정하세요.',
			));
			return;
		}

		$syncKey = isset($info['draw_sync_key']) ? trim($info['draw_sync_key']) : '';
		if($syncKey === ''){
			echo json_encode(array(
				'status' => 'fail',
				'msg' => '추첨동기키 미설정입니다. 상단 PBG등록설정에 추첨동기키를 입력하세요(.env LION_DRAW_SYNC_KEY와 동일).',
			));
			return;
		}

		$b1 = isset($arr['ball1']) ? (int) $arr['ball1'] : 0;
		$b2 = isset($arr['ball2']) ? (int) $arr['ball2'] : 0;
		$b3 = isset($arr['ball3']) ? (int) $arr['ball3'] : 0;
		$b4 = isset($arr['ball4']) ? (int) $arr['ball4'] : 0;
		$b5 = isset($arr['ball5']) ? (int) $arr['ball5'] : 0;
		$pb = isset($arr['powerball']) ? (int) $arr['powerball'] : -1;

		$drawnAt = isset($arr['drawn_at']) ? trim((string) $arr['drawn_at']) : '';
		if($drawnAt === ''){
			$drawnAt = pballKstDrawnAtSlotFromUnix(time());
		}

		$payload = array(
			'key'        => $syncKey,
			'ball1'      => $b1,
			'ball2'      => $b2,
			'ball3'      => $b3,
			'ball4'      => $b4,
			'ball5'      => $b5,
			'powerball'  => $pb,
			'drawn_at'   => $drawnAt,
		);

		$url  = $base . '/lion/syncDraw';
		$body = json_encode($payload);
		$r    = $this->lion_http_post_json($url, $body, array('X-Lion-Draw-Key: ' . $syncKey));

		$remote = json_decode($r['body'], true);
		if(! $r['ok']){
			echo json_encode(array(
				'status' => 'fail',
				'msg'    => '네트워크 오류 또는 pbg 미응답',
				'detail' => $r['err'] !== '' ? $r['err'] : substr($r['body'], 0, 400),
				'http'   => $r['http'],
			));
			return;
		}

		if(is_array($remote) && isset($remote['status'])){
			if($remote['status'] === 'success'){
				echo json_encode(array('status' => 'success', 'data' => $remote));
				return;
			}
			echo json_encode(array('status' => 'fail', 'http' => $r['http'], 'remote' => $remote));

			return;
		}

		echo json_encode(array('status' => 'fail', 'http' => $r['http'], 'raw' => substr($r['body'], 0, 600)));
	}

	/**
	 * 회차별통계 → PBG 추첨 전 조건 큐(동일 drawn_at UPSERT, 마지막 요청만 반영).
	 * JSON: keys — 선택된 헤더 키 배열( pb_holu, pb_jjak, … ). drawn_at 은 서버가 round_draw_end_unix 기준으로만 결정.
	 */
	public function roundstatpbgqueueconstraint(){

		$logPre = 'CApi.roundstatpbgqueueconstraint ';
		$nLogId = trim($this->input->get('l'));
		if(!is_login() || !$this->sess_model->is_login($nLogId, MEMBER_COMPANY_LEVEL) || !$this->admRoundstatUnlocked()){
			writeLog($logPre . 'abort not_logged_in_or_roundstat_locked l=' . $nLogId);
			echo json_encode(array('status' => 'logout'));
			return;
		}

		$jsonData = isset($_REQUEST['json_']) ? $_REQUEST['json_'] : '';
		$arr = json_decode($jsonData, true);
		if(!is_array($arr)){
			writeLog($logPre . 'fail bad_json json_len=' . (is_string($jsonData) ? strlen($jsonData) : 0) . ' err=' . json_last_error_msg());
			echo json_encode(array('status' => 'fail', 'msg' => 'bad_json'));
			return;
		}

		$keys = isset($arr['keys']) ? $arr['keys'] : array();
		$rules = $this->buildPbgQueueRulesFromUiKeys($keys);
		if($rules === null){
			writeLog($logPre . 'fail no_rules_or_conflict keys_raw=' . json_encode($keys, JSON_UNESCAPED_UNICODE));
			echo json_encode(array(
				'status' => 'fail',
				'msg' => '선택한 열이 없거나 상호 배타 조건이 충돌합니다.',
			));
			return;
		}

		$tmpPhase = array();
		$built = $this->buildPbRoundstatContext($tmpPhase);
		if($built === null){
			writeLog($logPre . 'fail buildPbRoundstatContext_null');
			echo json_encode(array('status' => 'fail', 'msg' => 'context'));
			return;
		}
		list($payload, $_extra) = $built;
		$nUntil = isset($payload['round_draw_end_unix']) ? (int) $payload['round_draw_end_unix'] : 0;
		if($nUntil < 1){
			writeLog($logPre . 'fail bad_draw_unix until=' . $nUntil);
			echo json_encode(array('status' => 'fail', 'msg' => 'bad_draw_unix'));
			return;
		}
		$drawnAt = pballKstDrawnAtSlotFromUnix($nUntil);

		$this->load->model('confsite_model');
		$info = $this->confsite_model->getPbgInfo();
		$base = powerball_base_url();
		if($base === ''){
			writeLog($logPre . 'fail powerball_base_url_empty');
			echo json_encode(array(
				'status' => 'fail',
				'msg' => '파워볼 서버 URL이 없습니다. .env POWERBALL_BASE_URL 또는 PBG등록설정의 요청사이트를 설정하세요.',
			));
			return;
		}

		$syncKey = isset($info['draw_sync_key']) ? trim($info['draw_sync_key']) : '';
		if($syncKey === ''){
			writeLog($logPre . 'fail draw_sync_key_empty pbg_base=' . $base);
			echo json_encode(array(
				'status' => 'fail',
				'msg' => '추첨동기키 미설정입니다. 상단 PBG등록설정에 추첨동기키를 입력하세요(.env LION_DRAW_SYNC_KEY와 동일).',
			));
			return;
		}

		$postBody = array(
			'key' => $syncKey,
			'drawn_at' => $drawnAt,
			'rules' => $rules,
		);
		$url = $base . '/lion/queueConstraint';
		$body = json_encode($postBody);
		$logOutbound = array('drawn_at' => $drawnAt, 'rules' => $rules, 'key' => '(set,len=' . strlen($syncKey) . ')');
		writeLog($logPre . 'POST url=' . $url . ' payload=' . json_encode($logOutbound, JSON_UNESCAPED_UNICODE));

		$r = $this->lion_http_post_json($url, $body, array('X-Lion-Draw-Key: ' . $syncKey));

		$remote = json_decode($r['body'], true);
		if(! $r['ok']){
			$peek = $r['body'] !== '' ? substr($r['body'], 0, 500) : '';
			writeLog($logPre . 'curl_fail ok=0 http=' . $r['http'] . ' curl_err=' . $r['err'] . ' body_snip=' . $peek);
			echo json_encode(array(
				'status' => 'fail',
				'msg' => '네트워크 오류 또는 pbg 미응답',
				'detail' => $r['err'] !== '' ? $r['err'] : substr($r['body'], 0, 400),
				'http' => $r['http'],
			));
			return;
		}

		if(is_array($remote) && isset($remote['status'])){
			if($remote['status'] === 'success'){
				writeLog($logPre . 'ok http=' . $r['http'] . ' drawn_at=' . $drawnAt);
				echo json_encode(array('status' => 'success', 'data' => $remote, 'drawn_at' => $drawnAt));
				return;
			}
			writeLog($logPre . 'remote_fail http=' . $r['http'] . ' remote=' . json_encode($remote, JSON_UNESCAPED_UNICODE));
			echo json_encode(array('status' => 'fail', 'http' => $r['http'], 'remote' => $remote));

			return;
		}

		$rawSnip = substr($r['body'], 0, 600);
		writeLog($logPre . 'bad_remote_body http=' . $r['http'] . ' body_snip=' . $rawSnip);
		echo json_encode(array('status' => 'fail', 'http' => $r['http'], 'raw' => substr($r['body'], 0, 600)));
	}

	private function lion_http_post_json($url, $bodyString, $extraHeaders = array()){

		if(! function_exists('curl_init')){
			return array('ok' => false, 'http' => 0, 'body' => '', 'err' => 'no_curl');
		}
		$headers = array_merge(array(
			'Content-Type: application/json; charset=UTF-8',
			'Content-Length: ' . strlen($bodyString),
		), $extraHeaders);

		$ch = curl_init($url);
		curl_setopt_array($ch, array(
			CURLOPT_POST           => true,
			CURLOPT_POSTFIELDS     => $bodyString,
			CURLOPT_HTTPHEADER     => $headers,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 12,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_SSL_VERIFYPEER => true,
		));
		$body = curl_exec($ch);
		$code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$cerr = curl_error($ch);
		curl_close($ch);
		$ok = ($cerr === '' && $body !== false);

		return array(
			'ok'   => $ok,
			'http' => $code,
			'body' => ($body === false) ? '' : (string) $body,
			'err'  => $cerr,
		);
	}


}