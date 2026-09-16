<?php
class Member_model extends CI_Model {
	
	private $mTableName ;
	private $mTableMoneyHistory ;

    function __construct()
    {
        parent::__construct();

        $this->mTableName = "member";
	    $this->mTableMoneyHistory = "money_history";
    }

    public function getInfoByUid($strId){
        if(is_null($strId))
            return null;

        $this->db->select('mb_fid');
        $this->db->select('mb_uid');
        $this->db->select('mb_level');  
        $this->db->select('mb_emp_fid');
        $this->db->select('mb_nickname');
        $this->db->select('mb_user');
        $this->db->select('mb_money');
        $this->db->select('mb_point');
        $this->db->select('mb_state_active');
        $this->db->select('mb_state_delete');
        $this->db->select('mb_state_print');
        $this->db->select('mb_game_pb_ratio');
        $this->db->select('mb_limit_round');
        $this->db->select('mb_limit_single');
        $this->db->select('mb_limit_mix');
        return $this->db->get_where($this->mTableName, array('mb_uid'=>$strId))->row();
    }

    public function getInfoByFid($strFid){
        
        if(is_null($strFid))
            return null;

        $this->db->select('mb_fid');
        $this->db->select('mb_uid');
        $this->db->select('mb_level');  
        $this->db->select('mb_emp_fid');
        $this->db->select('mb_nickname');
        $this->db->select('mb_user');
        $this->db->select('mb_money');
        $this->db->select('mb_point');
        $this->db->select('mb_state_active');
        $this->db->select('mb_state_delete');
        $this->db->select('mb_state_print');
        $this->db->select('mb_game_pb_ratio');
        $this->db->select('mb_limit_round');
        $this->db->select('mb_limit_single');
        $this->db->select('mb_limit_mix');

        return $this->db->get_where($this->mTableName, array('mb_fid'=>$strFid))->row();
    }

    function getEmployee($objUser, $nLevel){
        if(is_null($objUser))
            return null;
        if($objUser->mb_level <= $nLevel)
            return null;

        $this->db->select('mb_fid');
        $this->db->select('mb_uid');
        $this->db->select('mb_pwd');
        $this->db->select('mb_level');  
        $this->db->select('mb_emp_fid');
        $this->db->select('mb_nickname');
        $this->db->select('mb_money');
        $this->db->select('mb_point');
        $this->db->select('mb_time_join');
        $this->db->select('mb_time_last');
        $this->db->select('mb_game_pb_ratio');
        $this->db->select('mb_state_active');
        $this->db->select('mb_state_delete');
        $this->db->select('mb_limit_round');
        $this->db->select('mb_limit_single');
        $this->db->select('mb_limit_mix');
        $this->db->select('mb_state_print');

        $this->db->where('mb_emp_fid', $objUser->mb_fid);
        $this->db->where('mb_level', $nLevel);
        $this->db->where('mb_state_delete', 0);

        return $this->db->get($this->mTableName)->result();
    }

    
    function getEmployeeIds($objUser){
        if(is_null($objUser))
            return null;
        
        $this->db->select('mb_fid');
        $this->db->select('mb_uid');
        $this->db->select('mb_level');  
        $this->db->select('mb_emp_fid');
        $this->db->select('mb_nickname');

        $this->db->where('mb_emp_fid', $objUser->mb_fid);
        $this->db->where('mb_state_delete', 0);

        return $this->db->get($this->mTableName)->result();
    }

    function getAgencyIds(){
        
        $this->db->select('mb_fid');
        $this->db->select('mb_uid');
        $this->db->select('mb_level');  
        $this->db->select('mb_emp_fid');
        $this->db->select('mb_nickname');
        $this->db->select('mb_game_pb_ratio');
        $this->db->select('mb_limit_round');
        $this->db->select('mb_limit_single');
        $this->db->select('mb_limit_mix');

        $this->db->where('mb_level', MEMBER_AGENCY_LEVEL);
        $this->db->where('mb_state_delete', 0);

        return $this->db->get($this->mTableName)->result();
    }

    function getAllStores(){
        $this->db->select('member.mb_fid');
        $this->db->select('member.mb_uid');
        $this->db->select('member.mb_pwd');
        $this->db->select('member.mb_level');
        $this->db->select('member.mb_emp_fid');
        $this->db->select('member.mb_nickname');
        $this->db->select('member.mb_money');
        $this->db->select('member.mb_point');
        $this->db->select('member.mb_time_join');
        $this->db->select('member.mb_time_last');
        $this->db->select('member.mb_game_pb_ratio');
        $this->db->select('member.mb_state_active');
        $this->db->select('member.mb_state_delete');
        $this->db->select('member.mb_limit_round');
        $this->db->select('member.mb_limit_single');
        $this->db->select('member.mb_limit_mix');
        $this->db->select('member.mb_state_print');
        $this->db->select('agency.mb_uid AS mb_emp_uid', false);
        $this->db->from($this->mTableName.' AS member');
        $this->db->join($this->mTableName.' AS agency', 'agency.mb_fid = member.mb_emp_fid', 'left');
        $this->db->where('member.mb_level', MEMBER_EMPLOYEE_LEVEL);
        $this->db->where('member.mb_state_delete', 0);
        return $this->db->get()->result();
    }

    /** 접속 중 매장 상단 + 로그인날짜 최신순 정렬 */
    function applyStoreOnlineAndSort($arrStores, $arrActiveMbFids){

        if(!is_array($arrStores) || count($arrStores) < 1)
            return $arrStores;

        $activeSet = array();
        if(is_array($arrActiveMbFids)){
            foreach($arrActiveMbFids as $nFid)
                $activeSet[(int)$nFid] = true;
        }

        foreach($arrStores as $obj){
            $obj->mb_store_online = isset($activeSet[(int)$obj->mb_fid]) ? 1 : 0;
        }

        usort($arrStores, function($a, $b){
            $ua = ($a->mb_uid != null) ? (string)$a->mb_uid : '';
            $ub = ($b->mb_uid != null) ? (string)$b->mb_uid : '';
            return strcasecmp($ua, $ub);
        });

        return $arrStores;
    }

    function addEmployee($objAdmin, $arrReqData){
        
        //1:성공, 2:중복아이디, 3:수수료오유, 
        if(is_null($objAdmin))
            return 0;
        if($objAdmin->mb_level <= $arrReqData['level'])
            return 0;

        $objEmployee = $this->getInfoByUid($arrReqData['uid']);
        if(!is_null($objEmployee))
            return 2;
        
        if(strlen($arrReqData['uid']) < 1 || strlen($arrReqData['nickname']) < 1 || strlen($arrReqData['pwd']) < 1)
            return 0; 

        if(strlen($arrReqData['ratio']) < 1)
            $arrReqData['ratio'] = 0; 
        
        if(strlen($arrReqData['liround']) < 1)
            $arrReqData['liround'] = 0; 
        
        if(strlen($arrReqData['lisingle']) < 1)
            $arrReqData['lisingle'] = 0; 

        if(strlen($arrReqData['limix']) < 1)
            $arrReqData['limix'] = 0; 

        $nPrint = (isset($arrReqData['mb_print']) && (int) $arrReqData['mb_print'] === 1) ? 1 : 0;

        if($arrReqData['level'] < MEMBER_AGENCY_LEVEL && $objAdmin->mb_game_pb_ratio < $arrReqData['ratio'])
            return 3;

        if($this->childExceedsParentLimits($objAdmin, $arrReqData))
            return 6;
        
        $this->db->set('mb_uid', $arrReqData['uid']);
        $this->db->set('mb_pwd', $arrReqData['pwd']);
        $this->db->set('mb_level', $arrReqData['level']);
        $this->db->set('mb_emp_fid', $objAdmin->mb_fid);
        $this->db->set('mb_nickname', $arrReqData['nickname']);
        $this->db->set('mb_time_join', 'NOW()', false);
        $this->db->set('mb_game_pb_ratio', $arrReqData['ratio']);
        $this->db->set('mb_state_active', 1);
        $this->db->set('mb_state_delete', 0);
        $this->db->set('mb_limit_round', $arrReqData['liround']);
        $this->db->set('mb_limit_single', $arrReqData['lisingle']);
        $this->db->set('mb_limit_mix', $arrReqData['limix']);
        $this->db->set('mb_state_print', $nPrint);

        $bResult = $this->db->insert($this->mTableName);
        
        return $bResult?1:0;

    }


    function modifyEmployee($objAdmin, $arrReqData){
        
        //1:성공, 2:중복아이디, 3:수수료오유, 
        if(is_null($objAdmin))
            return 0;
        if($objAdmin->mb_level <= $arrReqData['level'])
            return 0;

        $objEmployee = $this->getInfoByUid($arrReqData['uid']);
        if(is_null($objEmployee))
            return 0;
        
        if($objEmployee->mb_level != $arrReqData['level'])
            return 0;

        if(strlen($arrReqData['uid']) < 1 || strlen($arrReqData['nickname']) < 1 || strlen($arrReqData['pwd']) < 1)
            return 0; 

        if(strlen($arrReqData['ratio']) < 1)
            $arrReqData['ratio'] = 0; 
        
        if(strlen($arrReqData['liround']) < 1)
            $arrReqData['liround'] = 0; 
        
        if(strlen($arrReqData['lisingle']) < 1)
            $arrReqData['lisingle'] = 0; 

        if(strlen($arrReqData['limix']) < 1)
            $arrReqData['limix'] = 0; 

        if($objEmployee->mb_level < MEMBER_AGENCY_LEVEL) {
            $nMaxRatio = $objAdmin->mb_game_pb_ratio;
            $objLimitParent = $objAdmin;
            if((int)$objAdmin->mb_level >= (int)MEMBER_COMPANY_LEVEL) {
                $objAgency = $this->getInfoByFid($objEmployee->mb_emp_fid);
                if(!is_null($objAgency)) {
                    $nMaxRatio = $objAgency->mb_game_pb_ratio;
                    $objLimitParent = $objAgency;
                }
            }
            if($nMaxRatio < $arrReqData['ratio'])
                return 3;
            if($this->childExceedsParentLimits($objLimitParent, $arrReqData))
                return 6;
        }
        
        $this->db->set('mb_pwd', $arrReqData['pwd']);
        $this->db->set('mb_nickname', $arrReqData['nickname']);
        $this->db->set('mb_game_pb_ratio', $arrReqData['ratio']);
        $this->db->set('mb_limit_round', $arrReqData['liround']);
        $this->db->set('mb_limit_single', $arrReqData['lisingle']);
        $this->db->set('mb_limit_mix', $arrReqData['limix']);

        if (array_key_exists('mb_print', $arrReqData)) {
            $nPrint = ((int) $arrReqData['mb_print'] === 1) ? 1 : 0;
            $this->db->set('mb_state_print', $nPrint);
        }

        $this->db->where('mb_fid', $objEmployee->mb_fid);
        
        $bResult = $this->db->update($this->mTableName);
        
        return $bResult?1:0;

    }


    function deleteEmployee($objAdmin, $arrReqData, &$del_uid = ""){
        
        //1:성공, 0:일반실패, 4:미확인 충전, 5:미확인 환전
        if(is_null($objAdmin))
            return 0;
        if($objAdmin->mb_level <= $arrReqData['level'])
            return 0;

        $objEmployee = $this->getInfoByFid($arrReqData['fid']);
        if(is_null($objEmployee))
            return 0;
        
        $del_uid = $objEmployee->mb_uid;

        if($objEmployee->mb_level != $arrReqData['level'])
            return 0;

        if($objEmployee->mb_level == MEMBER_EMPLOYEE_LEVEL && (int)$objAdmin->mb_level <= (int)MEMBER_AGENCY_LEVEL)
            return 0;

        $CI =& get_instance();
        $CI->load->model('charge_model');
        $CI->load->model('discharge_model');

        if($objEmployee->mb_level == MEMBER_EMPLOYEE_LEVEL) {
            if($CI->charge_model->hasPendingByMbUid($objEmployee->mb_uid))
                return 4;
            if($CI->discharge_model->hasPendingByMbUid($objEmployee->mb_uid))
                return 5;
        } else if($objEmployee->mb_level == MEMBER_AGENCY_LEVEL) {
            if($CI->charge_model->hasPendingByEmpFid($objEmployee->mb_fid))
                return 4;
            if($CI->discharge_model->hasPendingByEmpFid($objEmployee->mb_fid))
                return 5;
        }

        $this->db->set('mb_state_delete', 1);
        
        $this->db->where('mb_fid', $objEmployee->mb_fid);
        
        $bResult = $this->db->update($this->mTableName);
        
        if($objEmployee->mb_level == MEMBER_AGENCY_LEVEL ) {
            $this->db->select('mb_fid');
            $this->db->where('mb_level', MEMBER_EMPLOYEE_LEVEL);
            $this->db->where('mb_emp_fid', $objEmployee->mb_fid);
            $arrStores = $this->db->get($this->mTableName)->result();
            $arrStoreFids = array();
            foreach($arrStores as $objStore)
                $arrStoreFids[] = (int) $objStore->mb_fid;

            $this->db->set('mb_state_delete', 1);
            $this->db->where('mb_level', MEMBER_EMPLOYEE_LEVEL);
            $this->db->where('mb_emp_fid', $objEmployee->mb_fid);
            $this->db->update($this->mTableName);

            if(count($arrStoreFids) > 0){
                $this->db->set('mb_state_delete', 1);
                $this->db->where('mb_level', MEMBER_USER_LEVEL);
                $this->db->where_in('mb_emp_fid', $arrStoreFids);
                $this->db->update($this->mTableName);
            }

        } else if($objEmployee->mb_level == MEMBER_EMPLOYEE_LEVEL) {
            $this->db->set('mb_state_delete', 1);
            $this->db->where('mb_level', MEMBER_USER_LEVEL);
            $this->db->where('mb_emp_fid', $objEmployee->mb_fid);
            $this->db->update($this->mTableName);
        }
        return $bResult?1:0;

    }


    function login($strUserId, $strPwd){

        $this->db->select('mb_fid');
        $this->db->select('mb_uid');
        $this->db->select('mb_level');  
        $this->db->select('mb_emp_fid');
        $this->db->select('mb_nickname');
        $this->db->select('mb_state_delete');
        return $this->db->get_where($this->mTableName, array('mb_uid'=>$strUserId, 'mb_pwd'=>$strPwd))->row();

    }


    function updateLogin($objUser){
        $strIp = $this->input->ip_address();

        $this->db->set('mb_time_last', 'NOW()', false);
        $this->db->set('mb_ip_last', $strIp);
        $this->db->where('mb_fid', $objUser->mb_fid);
        
        return $this->db->update($this->mTableName);
    }


    function getEmployeePbRatio($objMember, $nAmount){
       

        //0=>총판, 1=>매장, 2=>회원
        $arrRadio = array ( array("",0,0), array("",0,0), array("",0,0) );

        if(is_null($objMember)) return $arrRadio;

        if($objMember->mb_level == MEMBER_USER_LEVEL) {
            $objStore = $this->getInfoByFid($objMember->mb_emp_fid);
            if(is_null($objStore) || (int)$objStore->mb_level !== (int)MEMBER_EMPLOYEE_LEVEL)
                return $arrRadio;
            $objAgency = $this->getInfoByFid($objStore->mb_emp_fid);
            if(is_null($objAgency) || (int)$objAgency->mb_level !== (int)MEMBER_AGENCY_LEVEL)
                return $arrRadio;

            $nUserR = (float) $objMember->mb_game_pb_ratio;
            $nStoreR = (float) $objStore->mb_game_pb_ratio;
            $nAgencyR = (float) $objAgency->mb_game_pb_ratio;
            if($nUserR >= 100 || $nStoreR >= 100 || $nAgencyR >= 100)
                return $arrRadio;
            if($nStoreR + 1e-9 < $nUserR || $nAgencyR + 1e-9 < $nStoreR)
                return $arrRadio;

            $arrRadio[0][0] = $objAgency->mb_fid;
            $arrRadio[0][1] = $nAgencyR - $nStoreR;
            $arrRadio[0][2] = (int)round(($arrRadio[0][1] * $nAmount) / 100.0);

            $arrRadio[1][0] = $objStore->mb_fid;
            $arrRadio[1][1] = $nStoreR - $nUserR;
            $arrRadio[1][2] = (int)round(($arrRadio[1][1] * $nAmount) / 100.0);

            $arrRadio[2][0] = $objMember->mb_fid;
            $arrRadio[2][1] = $nUserR;
            $arrRadio[2][2] = (int)round(($arrRadio[2][1] * $nAmount) / 100.0);

            return $arrRadio;
        }
        
        if($objMember->mb_level != MEMBER_EMPLOYEE_LEVEL ) return $arrRadio;
        if($objMember->mb_game_pb_ratio >= 100) return $arrRadio;
        
        $objEmp1 = $this->getInfoByFid($objMember->mb_emp_fid);
        if(is_null($objEmp1)) return $arrRadio;

         
        if($objEmp1->mb_game_pb_ratio >= $objMember->mb_game_pb_ratio)        
        {
            $arrRadio[0][0] = $objEmp1->mb_fid;
            $arrRadio[0][1] = $objEmp1->mb_game_pb_ratio-$objMember->mb_game_pb_ratio;            
            $arrRadio[0][2] = (int)round(($arrRadio[0][1] * $nAmount) / 100.0);

            $arrRadio[1][0] = $objMember->mb_fid;
            $arrRadio[1][1] = $objMember->mb_game_pb_ratio;
            $arrRadio[1][2] = (int)round(($arrRadio[1][1] * $nAmount) / 100.0);
        } 
        
        return $arrRadio;
        
    
    }

    function updatePoint($nUserFid, $nAddPoint){

        $strSql = "UPDATE ".$this->mTableName." SET ";
        $strSql.= " mb_point = mb_point+".$nAddPoint." WHERE mb_fid=".$nUserFid;
        return $this->db->query($strSql);
                
    }

    function modifyUser($nUserFid, $strUser){
        $strSql = "UPDATE ".$this->mTableName." SET ";
        $strSql.= " mb_user = '".$strUser."' WHERE mb_fid=".$nUserFid;
        return $this->db->query($strSql);
        
    }

    function modifyInfo($nUserFid, $arrReqData){
        if(strlen($arrReqData['mb_nickname'])<1)
            return 0;
        
        $iResult = 0;
        if(strlen($arrReqData['mb_newpwd'])>0){
            $this->db->set('mb_pwd', $arrReqData['mb_newpwd']);
        }
        $this->db->set('mb_state_print', $arrReqData['mb_print']);
        $this->db->set('mb_nickname', $arrReqData['mb_nickname']);
        $this->db->where('mb_fid', $nUserFid);
        
        if($this->db->update($this->mTableName))
            $iResult = 1;
        return $iResult;
        
    }


    public function permittedEmployee($objEmployee)
    {

        if(is_null($objEmployee))
            return false;

        if($objEmployee->mb_state_delete == 1  || $objEmployee->mb_level < MEMBER_EMPLOYEE_LEVEL)
            return false;

        if($objEmployee->mb_level > MEMBER_EMPLOYEE_LEVEL)
            return true;

        $objEmp = $this->getInfoByFid($objEmployee->mb_emp_fid);

        if(is_null($objEmp))
            return false;

        if($objEmp->mb_state_delete == 1 || $objEmp->mb_level != MEMBER_AGENCY_LEVEL)
            return false;
    
        return true;

    }

    public function permittedUser($objUser)
    {
        if(is_null($objUser))
            return false;

        if($objUser->mb_state_delete == 1 || (int)$objUser->mb_level !== (int)MEMBER_USER_LEVEL)
            return false;

        $objStore = $this->getInfoByFid($objUser->mb_emp_fid);
        if(is_null($objStore) || (int)$objStore->mb_state_delete === 1 || (int)$objStore->mb_level !== (int)MEMBER_EMPLOYEE_LEVEL)
            return false;

        return $this->permittedEmployee($objStore);
    }

    function childExceedsParentLimits($objParent, $arrReqData){
        if(is_null($objParent) || !is_array($arrReqData))
            return false;

        $arrMap = array(
            'liround' => 'mb_limit_round',
            'lisingle' => 'mb_limit_single',
            'limix' => 'mb_limit_mix',
        );
        foreach($arrMap as $strReqKey => $strCol){
            $nParent = isset($objParent->$strCol) ? (int) $objParent->$strCol : 0;
            $nChild = isset($arrReqData[$strReqKey]) ? (int) $arrReqData[$strReqKey] : 0;
            if($nParent > 0 && $nChild > $nParent)
                return true;
        }
        return false;
    }

    function changePoint($objUser, $nChgPoint){
        
        $this->db->trans_begin();
        
        $strSql1 = " INSERT INTO ".$this->mTableMoneyHistory;
        $strSql1 .=" (money_mb_fid, money_mb_uid, money_mb_emp_fid, money_amount, money_before, money_after, ";
        $strSql1 .=" money_change_type, money_bet_round, money_bet_mode, money_bet_target, money_update_time) ";
        $strSql1 .=" SELECT mb_fid, mb_uid, mb_emp_fid, ".$nChgPoint.", mb_money, mb_money+".$nChgPoint;
        $strSql1 .=", 3, 0, 0, '', NOW() ";
        $strSql1 .=" FROM ".$this->mTableName." WHERE mb_fid=".$objUser->mb_fid." FOR UPDATE";
        $this->db->query($strSql1);

        $strSql2 = "UPDATE ".$this->mTableName." SET mb_money = mb_money+".$nChgPoint;
        $strSql2.= ", mb_point = mb_point-".$nChgPoint." WHERE mb_fid=".$objUser->mb_fid;
        $this->db->query($strSql2);

        $bResult = false;
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $bResult = false;

        } else {
            $this->db->trans_commit();
            $bResult = true;
        }    

        return $bResult;    
    }

    function searchPointHistory($arrReqData){
        $this->db->where('money_mb_uid', $arrReqData['mb_uid']);
        $this->db->where('money_change_type', '3');
        $this->db->limit(20);
        $this->db->order_by('money_fid', 'DESC');
        return $this->db->get($this->mTableMoneyHistory)->result();
    }

    public function moneyHistoryProc($nUserFid, $arrBetData, $nPoint, $nType){
       
        $this->db->trans_begin();
        $nAmount = 0-$arrBetData['amount'];
        $strSql1 = " INSERT INTO ".$this->mTableMoneyHistory;
        $strSql1 .=" (money_mb_fid, money_mb_uid, money_mb_emp_fid, money_amount, money_before, money_after, ";
        $strSql1 .=" money_change_type, money_bet_round, money_bet_mode, money_bet_target, money_update_time) ";
        $strSql1 .=" SELECT mb_fid, mb_uid, mb_emp_fid, ".$nAmount.", mb_money, mb_money-".$arrBetData['amount'];
        $strSql1 .=", ".$nType.", ".$arrBetData['roundno'].", ".$arrBetData['mode'].", '".$arrBetData['target']."', NOW() ";
        $strSql1 .=" FROM ".$this->mTableName." WHERE mb_fid=".$nUserFid." FOR UPDATE";
        $this->db->query($strSql1);

        $strSql2 = "UPDATE ".$this->mTableName." SET mb_money = mb_money-".$arrBetData['amount'];
        $strSql2.= ", mb_point = mb_point+".$nPoint." WHERE mb_fid=".$nUserFid;
        $this->db->query($strSql2);

        $bResult = false;
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $bResult = false;

        } else {
            $this->db->trans_commit();
            $bResult = true;
        }    

        return $bResult;
    }


    public function moneyProc(&$objUser, $dtMoney, $dtPoint=0){
       
        
        $this->db->trans_begin();
        $strSql2 = "SELECT mb_money FROM ".$this->mTableName;
        $strSql2.= " WHERE mb_fid=".$objUser->mb_fid;
        $objResult = $this->db->query($strSql2)->row();

        $strSql1 = "UPDATE ".$this->mTableName." SET ";
        if($dtMoney >= 0)
            $strSql1 .= "mb_money = mb_money+".$dtMoney;
        else {
            $dtMoney = abs($dtMoney);
            $strSql1 .= "mb_money = mb_money-".$dtMoney;
        }
        if ($dtPoint > 0) {
            $strSql1 .= ', mb_point = mb_point+'.$dtPoint;
        } elseif ($dtPoint < 0) {
            $dtPoint = abs($dtPoint);
            $strSql1 .= ', mb_point = mb_point-'.$dtPoint;
        }
        $strSql1.= " WHERE mb_fid=".$objUser->mb_fid;
        $this->db->query($strSql1);

        $bResult = false;
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $bResult = false;

        } else {
            $this->db->trans_commit();
            $objUser->mb_money = $objResult->mb_money;
            $bResult = true;
        }    

        return $bResult;
    }



}