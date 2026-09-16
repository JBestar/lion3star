<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MApi extends CI_Controller {

	public function index()
	{

	}

	//사용자 로그인
	public function login(){ 
		$logHead = "MApi.login ";
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

		$this->load->model('member_model');
		$this->load->model('loghist_model');

		$objUser = $this->member_model->login($strUid, $strPwd);
		
		if(!is_null($objUser)){

			if($objUser->mb_state_delete == 0 && $objUser->mb_level == MEMBER_EMPLOYEE_LEVEL && $this->member_model->permittedEmployee($objUser)){
				$sessId = $this->session->session_id;
					
				$objSess = $this->sess_model->getByUid($objUser->mb_uid);
				$bNeedLog = false;
				$nLogId = 0;

				if(is_null($objSess))
					$bNeedLog = true;
				else {
					$ipAddr = $this->input->ip_address();
					writeLog("Repeat uid=".$objUser->mb_uid." ipAddr=".$ipAddr." <> ".$objSess->sess_ip);
					if(!strcmp($objSess->sess_ip, $this->input->ip_address())) {
						$bNeedLog = true;
						$nLogId = $objSess->sess_fid;
					} else {
						$this->sess_model->logout($objSess->sess_fid);
						$bNeedLog = true;
					}
				}
				
				if($bNeedLog && $nLogId == 0){
					//결과값 
					$nLogId = $this->sess_model->login($objUser, $sessId);
				}
	 			
				if($nLogId > 0) {
					writeLog("Login Success uid=".$objUser->mb_uid);
					//세션 생성
					$sessData = array('username' => $objUser->mb_uid, 'logged_in'=>TRUE, 'user_level'=>MEMBER_EMPLOYEE_LEVEL);
					$this->session->set_userdata($sessData);
					$this->member_model->updateLogin($objUser);
					$this->loghist_model->addLog($objUser, 1);
					
					$arrResult['status'] = "success";
					$arrResult['code'] = 1;		//1-성공 2-계정틀림 3-삭제
					$arrResult['data'] = $nLogId;	
				} /*else if($bNeedLog){
					$arrResult['status'] = "fail";
					$arrResult['code'] = 4;		//1-성공 2-계정틀림 4-재가입
				
				}*/ else {
					writeLog($logHead . "FAIL session ip=" . $this->input->ip_address() . " uid=" . $objUser->mb_uid . " bNeedLog=" . ($bNeedLog ? '1' : '0') . " nLogId=" . $nLogId . " code5");
					$arrResult['status'] = "fail";
					$arrResult['code'] = 5;		//1-성공 2-계정틀림 4-재가입 5-중복
				
				}

			} else{
				writeLog($logHead . "FAIL policy uid=" . $objUser->mb_uid . " mb_level=" . $objUser->mb_level . " need=" . MEMBER_EMPLOYEE_LEVEL . " mb_state_delete=" . $objUser->mb_state_delete);
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
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
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
				if($objUser->mb_state_delete == 0 && $objMaintain->conf_active != 1 && $objUser->mb_level == MEMBER_EMPLOYEE_LEVEL && $this->member_model->permittedEmployee($objUser))
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
		if(is_login() && $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL)){
			echo json_encode(array('status' => 'success'));
		} else {
			echo json_encode(array('status' => 'logout'));
		}
	}

	//사용자정보
	public function session(){ 
	
		$nLogId = trim($this->input->get('l'));		
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
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
				if($objUser->mb_state_delete == 0 && $objMaintain->conf_active != 1 && $objUser->mb_level == MEMBER_EMPLOYEE_LEVEL && $this->member_model->permittedEmployee($objUser))
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


	public function charge(){ 
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
			
			//model
			$this->load->model('charge_model');
			$this->load->model('member_model');

			$strUid = $this->sess_model->getUserId($nLogId);		
			$objUser = $this->member_model->getInfoByUid($strUid);
			$objWaitCharge = $this->charge_model->waitCharge($objUser);
			$bResult = false;
			if(is_null($objWaitCharge))
				$bResult = $this->charge_model->addCharge($objUser, $arrReqData);
		
	 		if($bResult)	{
				$arrResult['status'] = "success";				
			}
			else{
					if(!is_null($objWaitCharge))
						$arrResult['status'] = "wait";
					else $arrResult['status'] = "fail";
				}
				echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}
	}

		
	public function chargehistory(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);
		
		$nLogId = trim($this->input->get('l'));		
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL)) 
		{
			
			//model
			$this->load->model('member_model');	
			$this->load->model('charge_model');	

			$strUid = $this->sess_model->getUserId($nLogId);		
			$arrReqData['mb_uid'] = $strUid;
			$arrChargeData = $this->charge_model->search($arrReqData);

			$objResult = new StdClass;
			$objResult->data = $arrChargeData;		
			$objResult->status = "success";
		
			echo json_encode($objResult);

		} else{
			$arrResult['status'] = "logout";

			echo json_encode($arrResult);	
		}
	}



	
	public function discharge(){ 
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
			
			//model
			$this->load->model('discharge_model');
			$this->load->model('member_model');

			$strUid = $this->sess_model->getUserId($nLogId);		
			$objUser = $this->member_model->getInfoByUid($strUid);
			$objWaitCharge = $this->discharge_model->waitDicharge($objUser);
			
			$iResult = 0;
			if(!is_null($objWaitCharge))
				$iResult = 4;
			else 	
				$iResult = $this->discharge_model->addDischarge($objUser, $arrReqData);
		
	 		if($iResult == 1)	{
				$arrResult['status'] = "success";				
			} else{
					$arrResult['data'] = $iResult;		
					$arrResult['status'] = "fail";
			}
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}
	}

		
	public function dischargehistory(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);
		
		$nLogId = trim($this->input->get('l'));		
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL)) 
		{
			
			//model
			$this->load->model('member_model');	
			$this->load->model('discharge_model');	

			$strUid = $this->sess_model->getUserId($nLogId);		
			$arrReqData['mb_uid'] = $strUid;
			$arrChargeData = $this->discharge_model->search($arrReqData);

			$objResult = new StdClass;
			$objResult->data = $arrChargeData;		
			$objResult->status = "success";
		
			echo json_encode($objResult);

		} else{
			$arrResult['status'] = "logout";

			echo json_encode($arrResult);	
		}
	}



	
	public function mileage(){ 
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
			
			//model
			$this->load->model('member_model');

			$strUid = $this->sess_model->getUserId($nLogId);		
			$objUser = $this->member_model->getInfoByUid($strUid);
			$bResult = false;
			if($objUser->mb_point >= $arrReqData['mileage'])
				$bResult = $this->member_model->changePoint($objUser, $arrReqData['mileage']);
			
	 		if($bResult)	{
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

		
	public function mileagehistory(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);
		
		$nLogId = trim($this->input->get('l'));		
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL)) 
		{
			
			//model
			$this->load->model('member_model');	
			
			$strUid = $this->sess_model->getUserId($nLogId);		
			$arrReqData['mb_uid'] = $strUid;
			$arrMileageData = $this->member_model->searchPointHistory($arrReqData);

			$objResult = new StdClass;
			$objResult->data = $arrMileageData;		
			$objResult->status = "success";
		
			echo json_encode($objResult);

		} else{
			$arrResult['status'] = "logout";

			echo json_encode($arrResult);	
		}
	}

	
	public function getemployee(){ 
		
		$nLogId = trim($this->input->get('l'));		
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
			
			//model
			$this->load->model('member_model');
			$this->load->model('sess_model');

			$strUid = $this->sess_model->getUserId($nLogId);		
			$objUser = $this->member_model->getInfoByUid($strUid);
			
			$arrEmployee = $this->member_model->getEmployee($objUser, MEMBER_USER_LEVEL);
			$arrActive = $this->sess_model->getActiveEmployeeMbFids($objUser->mb_fid, MEMBER_USER_LEVEL);
			$arrEmployee = $this->member_model->applyStoreOnlineAndSort($arrEmployee, $arrActive);
			
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
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
			
			//model
			$this->load->model('member_model');

			$strUid = $this->sess_model->getUserId($nLogId);		
			$objUser = $this->member_model->getInfoByUid($strUid);
			$arrReqData['level'] = MEMBER_USER_LEVEL;
			$iResult = $this->member_model->addEmployee($objUser, $arrReqData);
			
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
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
			
			//model
			$this->load->model('member_model');

			$strUid = $this->sess_model->getUserId($nLogId);		
			$objUser = $this->member_model->getInfoByUid($strUid);
			$arrReqData['level'] = MEMBER_USER_LEVEL;
			$iResult = $this->member_model->modifyEmployee($objUser, $arrReqData);
			
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
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{
			$arrResult['status'] = "fail";
			$arrResult['data'] = 0;
			echo json_encode($arrResult);
		}
		else {
			$arrResult['status'] = "logout";
			echo json_encode($arrResult);	
		}
	}


	function betstatist(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);
		$nLogId = trim($this->input->get('l'));		
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{

			//model
			$this->load->model('member_model');
			$this->load->model('pbbet_model');

			$strUid = $this->sess_model->getUserId($nLogId);		
			$objUser = $this->member_model->getInfoByUid($strUid);

			$arrBetData = $this->pbbet_model->searchByAgent($objUser, $arrReqData);
			
			$arrResult['status'] = "success";
			$arrResult['data'] = $arrBetData;
			echo json_encode($arrResult);
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
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL)) 
		{
			
			//model
			$this->load->model('member_model');	
			$this->load->model('pbbet_model');	

			$strUid = $this->sess_model->getUserId($nLogId);
			$objUser = $this->member_model->getInfoByUid($strUid);

			$arrBetData = null;
			if(!is_null($objUser)){
				$arrReqData['emp_fid'] = $objUser->mb_fid;
				$arrReqData['mb_name'] = "";
				$arrReqData['round_fid'] = "";
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


	public function emplist(){

		$nLogId = trim($this->input->get('l'));		
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL)) 
		{

			//model
			$this->load->model('member_model');	
			$strUid = $this->sess_model->getUserId($nLogId);
			$objUser = $this->member_model->getInfoByUid($strUid);

			$arrEmp = $this->member_model->getEmployeeIds($objUser);
			
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
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL)) 
		{

			//model
			$this->load->model('member_model');	
			$this->load->model('charge_model');	
			$this->load->model('discharge_model');

			$strUid = $this->sess_model->getUserId($nLogId);
			$objUser = $this->member_model->getInfoByUid($strUid);

			$arrWait = [0, 0];
			$arrCharge = null;
			if(!is_null($objUser)){
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
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL)) 
		{

			//model
			$this->load->model('member_model');	
			$this->load->model('charge_model');	

			$strUid = $this->sess_model->getUserId($nLogId);
			$objUser = $this->member_model->getInfoByUid($strUid);

			$arrCharge = null;
			if(!is_null($objUser)){
				$arrCharge = $this->charge_model->getByEmpFid($objUser->mb_fid, $arrReqData);
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
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL)) 
		{
			$iCode = 0;
			$this->load->model('charge_model');
			$this->load->model('member_model');
			$this->load->model('moneyhistory_model');
			$strUid = $this->sess_model->getUserId($nLogId);
			$objAdmin = $this->member_model->getInfoByUid($strUid);
			$iResult = 0;

			$objCharge = $this->charge_model->getByFid($arrReqData['charge_fid']);
			if(!is_null($objCharge) && !is_null($objAdmin)){
				$objUser = $this->member_model->getInfoByUid($objCharge->charge_mb_uid);
				$iCode = 1;
				if(!is_null($objUser) && $objCharge->charge_action_state == 1){
					$iCode = 2;
					
					if($objUser->mb_state_delete != 1 && $objAdmin->mb_fid == $objUser->mb_emp_fid) {
						$iCode = 3;
						if( $arrReqData['charge_proc'] == 0){				//취소
							//charge Table 
							$objCharge->charge_action_state = 3;
							$objCharge->charge_action_uid = $objAdmin->mb_uid;
							$bResult = $this->charge_model->permit($objCharge);	
							$iResult = $bResult?1:0;
						} else if( $arrReqData['charge_proc'] == 1){		//승인
							if((int)$objAdmin->mb_money < (int)$objCharge->charge_money)
								$iResult = 2;
							else {
								$iCode = 4;
								$nDtMoney = 0 - $objCharge->charge_money;
								$bResult = $this->member_model->moneyProc($objAdmin, $nDtMoney);
								$bResult = $this->member_model->moneyProc($objUser, $objCharge->charge_money);
								if($bResult){
									//moneyhistory Table
									$objUser->mb_emp_uid = $objAdmin->mb_uid;
									$this->moneyhistory_model->registerCharge($objUser, $objCharge->charge_money);
									$objAdmin->mb_emp_uid = $objUser->mb_uid;
									$this->moneyhistory_model->registerChargeFrom($objAdmin, $objCharge->charge_money);
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
			}

			if($iResult == 1)
				$arrResult['status'] = "success";
			else {
				$arrResult['status'] = "fail";
				$arrResult['data'] = $iResult;
				$arrResult['code'] = $iCode;
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
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL)) 
		{

			$this->load->model('charge_model');
			$this->load->model('member_model');
			$this->load->model('moneyhistory_model');
			$strUid = $this->sess_model->getUserId($nLogId);
			$objAdmin = $this->member_model->getInfoByUid($strUid);
			$iResult = 0;
			$objUser = $this->member_model->getInfoByUid($arrReqData['charge_uid']);
			if(!is_null($objAdmin) && !is_null($objUser)){				
				if($objAdmin->mb_state_delete != 1 && $objUser->mb_state_delete != 1 && $objAdmin->mb_fid === $objUser->mb_emp_fid && $arrReqData['charge_amount'] > 0){		//승인
					if($objAdmin->mb_money < $arrReqData['charge_amount'])
						$iResult = 2;
					else {
						$nDtMoney = 0 - $arrReqData['charge_amount'];
						$bResult = $this->member_model->moneyProc($objAdmin, $nDtMoney);
						$bResult = $this->member_model->moneyProc($objUser, $arrReqData['charge_amount']);
						if($bResult){
							//moneyhistory Table
							$objUser->mb_emp_uid = $objAdmin->mb_uid;
							$this->moneyhistory_model->registerGiveCharge($objUser, $arrReqData['charge_amount']);

							$objAdmin->mb_emp_uid = $objUser->mb_uid;
							$this->moneyhistory_model->registerGiveChargeFrom($objAdmin, $arrReqData['charge_amount']);

							//charge Table 
							$bResult = $this->charge_model->giveCharge($objAdmin, $objUser, $arrReqData);
							$iResult = $bResult?1:0;
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



	public function dischargelist(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL)) 
		{

			//model
			$this->load->model('member_model');	
			$this->load->model('discharge_model');	

			$strUid = $this->sess_model->getUserId($nLogId);
			$objUser = $this->member_model->getInfoByUid($strUid);

			$arrDischarge = null;
			if(!is_null($objUser)){
				$arrDischarge = $this->discharge_model->getByEmpFid($objUser->mb_fid, $arrReqData);
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
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL)) 
		{

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
					if($objUser->mb_state_delete != 1 && $objAdmin->mb_fid === $objUser->mb_emp_fid) {
						/*
						if($arrReqData['discharge_proc'] == 0){				//취소
							//charge Table 
							$objDischarge->exchange_action_state = 3;
							$objDischarge->exchange_action_uid = $objAdmin->mb_uid;
							$bResult = $this->discharge_model->permit($objDischarge);	
							$iResult = $bResult?1:0;
						} else
						*/ 
						if($arrReqData['discharge_proc'] == 1){		//승인
							//charge Table 
							$objDischarge->exchange_action_state = 2;
							$objDischarge->exchange_action_uid = $objAdmin->mb_uid;
							$bResult = $this->discharge_model->permit($objDischarge);
							$iResult = $bResult?1:0;
					
							/*
							if((int)$objUser->mb_money < (int)$objDischarge->exchange_money)
								$iResult = 2;
							else {

								
								$nDtMoney = 0 - $objDischarge->exchange_money;
								$bResult = $this->member_model->moneyProc($objAdmin, $objDischarge->exchange_money);
								$bResult = $this->member_model->moneyProc($objUser, $nDtMoney);
								if($bResult){
									//moneyhistory Table
									$objUser->mb_emp_uid = $objAdmin->mb_uid;
									$this->moneyhistory_model->registerDischarge($objUser, $objDischarge->exchange_money);
									$objAdmin->mb_emp_uid = $objUser->mb_uid;
									$this->moneyhistory_model->registerDischargeFrom($objAdmin, $objDischarge->exchange_money);
									
									//charge Table 
									$objDischarge->exchange_action_state = 2;
									$objDischarge->exchange_action_uid = $objAdmin->mb_uid;
									$objDischarge->exchange_money_after = $objUser->mb_money-$objDischarge->exchange_money;
									$bResult = $this->discharge_model->permit($objDischarge);
									$iResult = $bResult?1:0;
								}
									
							}	
							*/
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

	
	function givedischarge(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);
		

		$nLogId = trim($this->input->get('l'));		
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL)) 
		{

			$this->load->model('discharge_model');
			$this->load->model('member_model');
			$this->load->model('moneyhistory_model');
			$strUid = $this->sess_model->getUserId($nLogId);
			$objAdmin = $this->member_model->getInfoByUid($strUid);
			$iResult = 0;
			$objUser = $this->member_model->getInfoByUid($arrReqData['discharge_uid']);
			if(!is_null($objAdmin) && !is_null($objUser)){				
				if($objAdmin->mb_state_delete != 1 && $objUser->mb_state_delete != 1 && $objAdmin->mb_fid === $objUser->mb_emp_fid && $arrReqData['discharge_amount'] > 0){		//승인
					if($objUser->mb_money < $arrReqData['discharge_amount'])
						$iResult = 2;
					else {
						$nDtMoney = 0 - $arrReqData['discharge_amount'];
						$bResult = $this->member_model->moneyProc($objAdmin, $arrReqData['discharge_amount']);
						$bResult = $this->member_model->moneyProc($objUser, $nDtMoney);
						if($bResult){
							//moneyhistory Table
							$objUser->mb_emp_uid = $objAdmin->mb_uid;
							$this->moneyhistory_model->registerDischarge($objUser, $arrReqData['discharge_amount']);
							$objAdmin->mb_emp_uid = $objUser->mb_uid;
							$this->moneyhistory_model->registerDischargeFrom($objAdmin, $arrReqData['discharge_amount']);
							
							//discharge Table 
							$bResult = $this->discharge_model->giveDischarge($objAdmin, $objUser, $arrReqData);
							$iResult = $bResult?1:0;
							

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
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{

			//model
			$this->load->model('member_model');
			$this->load->model('moneyhistory_model');

			$strUid = $this->sess_model->getUserId($nLogId);		
			$objUser = $this->member_model->getInfoByUid($strUid);

			$arrTransfer = $this->moneyhistory_model->getTransferByAgent($objUser, $arrReqData);
			
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
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{

			//model
			$this->load->model('member_model');
			$this->load->model('moneyhistory_model');

			$strUid = $this->sess_model->getUserId($nLogId);		
			$objAdmin = $this->member_model->getInfoByUid($strUid);
			$objUser = $this->member_model->getInfoByUid($arrReqData['uid']);
			$arrTransfer = null;
			if(!is_null($objAdmin) && !is_null($objUser)){
				if($objUser->mb_state_delete != 1 && $objAdmin->mb_fid === $objUser->mb_emp_fid) {
					$arrReqData['mb_uid'] = $objUser->mb_uid;
					$arrReqData['emp_fid'] = $objAdmin->mb_fid;
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


	
	function transferlist(){
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);
		$nLogId = trim($this->input->get('l'));		
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{

			//model
			$this->load->model('member_model');
			$this->load->model('moneyhistory_model');

			$strUid = $this->sess_model->getUserId($nLogId);		
			$objAdmin = $this->member_model->getInfoByUid($strUid);
			
			$arrTransfer = null;
			if(!is_null($objAdmin)){
				if($objAdmin->mb_state_delete != 1 ) {
					$arrReqData['mb_uid'] = $objAdmin->mb_uid;
					$arrReqData['emp_fid'] = $objAdmin->mb_emp_fid;
					$arrReqData['type'] = 3;
					$arrReqData['max_count'] = 100;
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


	public function sendmessage(){ 
		$jsonData = $_REQUEST['json_'];
		$arrReqData = json_decode($jsonData, true);

		$nLogId = trim($this->input->get('l'));		
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
		{	
			//model
			$this->load->model('member_model');
			$this->load->model('message_model');

			$strUid = $this->sess_model->getUserId($nLogId);
			$objAdmin = $this->member_model->getInfoByUid($strUid);
			$objUser = $this->member_model->getInfoByUid($arrReqData['recv_id']);
			$bResult = false;
			if(!is_null($objAdmin) && !is_null($objUser))	{
				if($objUser->mb_state_delete != 1 && $objAdmin->mb_fid === $objUser->mb_emp_fid) {
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
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL)) 
		{
			
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
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL))
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
		if(is_login() &&  $this->sess_model->is_login($nLogId, MEMBER_EMPLOYEE_LEVEL)) 
		{
			
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







}