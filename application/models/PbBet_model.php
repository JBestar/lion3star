<?php
class PbBet_model extends CI_Model {
	

    private $mTableName ;
    private $mMemberTable ;

    function __construct()
    {
        parent::__construct();

        $this->mTableName = "bet_powerball";
        $this->mMemberTable = "member";
    }

    function gets($nCount)
    {
        
        $strSql = "SELECT bet_fid, bet_state, bet_round_fid, bet_round_no, bet_time, bet_game, bet_mode, bet_target, bet_money, bet_win_money FROM ".$this->mTableName." ORDER BY bet_time DESC LIMIT 0, ".$nCount;
        $query = $this -> db -> query($strSql);
        $result = $query -> result();
        
        return $result;  
    }

    function getByFid($fid)
    {
        
        $strSql = "SELECT bet_fid, bet_state, bet_emp_fid, bet_mb_uid, bet_mb_name, bet_round_fid, bet_round_no, bet_time, bet_game, bet_mode, bet_target, bet_ratio, bet_money, bet_win_money, bet_account_time, bet_empl_amount, bet_agen_amount  FROM ".$this->mTableName;
        $strSql .=" WHERE bet_fid='".$fid."' ";
        $result = $this -> db -> query($strSql)->row();
        
        return $result;  
    }

    function getByRoundId($strUserId, $nRoundFid, $nGameId = -1){       
        $strSql = "SELECT bet_fid, bet_state, bet_mb_uid, bet_mb_name, bet_round_fid, bet_round_no, bet_game, bet_time, bet_mode, bet_target, bet_ratio, bet_money, bet_win_money  FROM ".$this->mTableName;
        $strSql .=" WHERE bet_round_fid='".$nRoundFid."' AND bet_mb_uid='".$strUserId."' AND bet_state != ".BET_CANCEL;
        if($nGameId >= 0)
            $strSql .=" AND bet_game = '".$nGameId."' ";

        $strSql .=" ORDER BY bet_time"; 
        $query = $this -> db -> query($strSql);
        $result = $query -> result();
        
        return $result;   
        
    }

    function getByRoundNo($strUserId, $strDate, $nRoundNo, $nGameId = -1){       
        $strSql = "SELECT bet_fid, bet_state, bet_mb_uid, bet_mb_name, bet_round_fid, bet_round_no, bet_time, bet_game, bet_mode, bet_target, bet_ratio, bet_money, bet_win_money  FROM ".$this->mTableName;
        $strSql .=" WHERE bet_time >'".$strDate."' AND bet_round_no='".$nRoundNo."' AND bet_mb_uid='".$strUserId."' AND bet_state != ".BET_CANCEL;
        if($nGameId >= 0)
            $strSql .=" AND bet_game = '".$nGameId."' ";

        $strSql .=" ORDER BY bet_time"; 
        $query = $this -> db -> query($strSql);
        $result = $query -> result();
        
        return $result;   
        
    }

    function getOrderById($strUserId, $nBetId)
    {
        
        $strSql = "SELECT bet_fid, bet_state, bet_emp_fid, bet_mb_uid, bet_mb_name, bet_round_fid, bet_round_no, bet_time, bet_game, bet_mode, bet_target, bet_ratio, bet_money, bet_win_money, bet_empl_amount, bet_agen_amount  FROM ".$this->mTableName;
        $strSql .=" WHERE bet_mb_uid='".$strUserId."' AND bet_state=".BET_WAIT." AND bet_fid='".$nBetId."' ";
        $result = $this -> db -> query($strSql)->row();
        
        return $result;  
    }


    function getByUserId($strUserId, $nCount, $nGameId = -1)
    {
        
        $strSql = "SELECT bet_fid, bet_state, bet_round_fid, bet_round_date, bet_round_no, bet_time, bet_game, bet_mode, bet_target, bet_ratio, bet_money, bet_win_money  FROM ".$this->mTableName;
        $strSql .=" WHERE bet_mb_uid='".$strUserId."' AND bet_state !=".BET_CANCEL;
        if($nGameId >= 0)
            $strSql .=" AND bet_game = '".$nGameId."' ";
        
        $strSql .=" ORDER BY bet_time DESC LIMIT 0, ".$nCount;
        $query = $this -> db -> query($strSql);
        $result = $query -> result();
        
        return $result;  
    }

    function deleteByFid($fid){
        $this->db->set('bet_state', BET_CANCEL);
        $this->db->set('bet_account_time', 'NOW()', false);
       
        $this->db->where('bet_fid', $fid);
        
        return $this->db->update($this->mTableName);
    }

    function addBetRound($arrBetData, $objUser, $arrEmpRatio)
    {

        
        $this->db->set('bet_state', 1);
        $this->db->set('bet_emp_fid', $objUser->mb_emp_fid);
        $this->db->set('bet_mb_uid', $objUser->mb_uid);
        $this->db->set('bet_mb_name', $arrBetData['name']);
        $this->db->set('bet_round_fid', $arrBetData['roundid']);
        $this->db->set('bet_round_date', $arrBetData['round_date']);
        $this->db->set('bet_round_no', $arrBetData['roundno']);
        $this->db->set('bet_time', 'NOW()', false);
        $this->db->set('bet_game', $arrBetData['game']);
        $this->db->set('bet_mode', $arrBetData['mode']);
        $this->db->set('bet_target', $arrBetData['target']);        
        $this->db->set('bet_ratio', $arrBetData['ratio']);
        $this->db->set('bet_money', $arrBetData['amount']);
        $this->db->set('bet_before_money', $objUser->mb_money);
        $this->db->set('bet_empl_amount', $arrEmpRatio[1][2]);
        $this->db->set('bet_agen_amount', $arrEmpRatio[0][2]);
        //$this->db->set('bet_comp_amount', 0);
        
        $this->db->insert($this->mTableName);

        return $this->db->insert_id();
        
    }

    function updateBetObj($objBet)
    {
		$this->db->set('bet_mode', $objBet->bet_mode);
        $this->db->set('bet_target', $objBet->bet_target);  
        $this->db->set('bet_ratio', $objBet->bet_ratio);
        $this->db->set('bet_state', $objBet->bet_state);
        $this->db->set('bet_win_money', $objBet->bet_win_money);
        $this->db->set('bet_after_money', $objBet->bet_after_money);


		$this->db->where('bet_fid', $objBet->bet_fid);
    	return $this->db->update($this->mTableName);
    }
    
    
    function search($arrReqData)
    {
        $strSql = "SELECT *, CAST(bet_time AS DATE) AS bet_date FROM ".$this->mTableName;
        
        $strSql.=" WHERE bet_view_state = '0' ";
        if(array_key_exists('mb_uid', $arrReqData) && strlen($arrReqData['mb_uid']) > 0){
            $strSql.=" AND bet_mb_uid = '".$arrReqData['mb_uid']."' ";
        }
        if(array_key_exists('state', $arrReqData)){
            $strSql.=" AND bet_state = ".$arrReqData['state'];
        }
        else $strSql.=" AND bet_state != ".BET_CANCEL;

        if(array_key_exists('game', $arrReqData) && intval($arrReqData['game']) >= 0) {
            $strSql.=" AND bet_game = '".$arrReqData['game']."' ";
        }
        if(array_key_exists('mb_name', $arrReqData) && strlen($arrReqData['mb_name']) > 0) {
            $strSql.=" AND bet_mb_name = '".$this->db->escape_str($arrReqData['mb_name'])."' ";
        }
        if(strlen($arrReqData['round_fid']) > 0) {

            if(intval($arrReqData['round_fid']) <= 288){
                $strSql.=" AND bet_round_no = '".$arrReqData['round_fid']."' ";
            }
            else $strSql.=" AND bet_round_fid = '".$arrReqData['round_fid']."' ";
        }
        if(array_key_exists('start', $arrReqData) && strlen($arrReqData['start']) > 0 && strlen($arrReqData['end']) > 0 ){
            $strSql.=" AND bet_time >= '".$arrReqData['start']." 0:0:0' AND bet_time <= '".$arrReqData['end']." 23:59:59'" ;                     
        }
        if(!empty($arrReqData['emp_fid'])) {
            $strSql.=" AND bet_emp_fid = '".((int) $arrReqData['emp_fid'])."' ";
        }
        if(!empty($arrReqData['agency_fid'])) {
            $nAgencyFid = (int) $arrReqData['agency_fid'];
            $strSql.=" AND bet_emp_fid IN (SELECT mb_fid FROM member WHERE mb_emp_fid = ".$nAgencyFid." AND mb_level = ".MEMBER_EMPLOYEE_LEVEL." AND mb_state_delete = 0) ";
        }
        // $strSql.=" ORDER BY bet_date DESC, bet_round_no DESC, bet_game DESC, bet_account_time DESC, bet_fid DESC ";
        $strSql.=" ORDER BY bet_fid DESC ";
        if(array_key_exists('max_count', $arrReqData)) {
            $strSql.=" LIMIT 0, ".$arrReqData['max_count']." ";
        }

        $query = $this -> db -> query($strSql);
        $result = $query -> result();
        
        return $result; 

    }


    
    function searchByAgent($objEmp, $arrReqData)
    {
        if(is_null($objEmp)) return null;
        
        $strSql = "SELECT bet_emp_fid, bet_mb_uid, SUM(bet_money) AS bet_money_sum, SUM(bet_win_money) AS bet_win_sum, COUNT(CASE WHEN bet_win_money > 0 THEN 1 END) AS bet_win_count, SUM( bet_empl_amount) AS bet_empl_amount, SUM( bet_agen_amount) AS bet_agen_amount FROM ".$this->mTableName;
        $strSql .= " INNER JOIN MEMBER ON member.mb_uid = bet_powerball.bet_mb_uid AND member.mb_state_delete = 0 ";
        $strSql .= " WHERE bet_emp_fid = ".$objEmp->mb_fid." AND bet_state != ".BET_CANCEL;
        if(strlen($arrReqData['start']) > 0 && strlen($arrReqData['end']) > 0 ){
            $strSql.=" AND bet_time >= '".$arrReqData['start']." 0:0:0' AND bet_time <= '".$arrReqData['end']." 23:59:59'" ;
        }

        $strSql.="  GROUP BY bet_mb_uid ";
        $query = $this -> db -> query($strSql);
        $result = $query -> result();
        
        return $result; 

    }

    
    function searchByAgencyStores($objEmp, $arrReqData)
    {
        if(is_null($objEmp)) return null;

        $nAgencyFid = (int) $objEmp->mb_fid;
        $strSql = "SELECT store.mb_fid AS bet_emp_fid, store.mb_uid AS bet_mb_uid, store.mb_uid AS mb_uid, SUM(bet_money) AS bet_money_sum, SUM(bet_win_money) AS bet_win_sum, COUNT(CASE WHEN bet_win_money > 0 THEN 1 END) AS bet_win_count, SUM( bet_empl_amount) AS bet_empl_amount, SUM( bet_agen_amount) AS bet_agen_amount FROM ".$this->mTableName;
        $strSql .= " INNER JOIN MEMBER AS store ON store.mb_fid = bet_powerball.bet_emp_fid AND store.mb_state_delete = 0 ";
        $strSql .= " WHERE store.mb_emp_fid = ".$nAgencyFid." AND store.mb_level = ".MEMBER_EMPLOYEE_LEVEL." AND bet_state != ".BET_CANCEL;
        if(strlen($arrReqData['start']) > 0 && strlen($arrReqData['end']) > 0 ){
            $strSql.=" AND bet_time >= '".$arrReqData['start']." 0:0:0' AND bet_time <= '".$arrReqData['end']." 23:59:59'" ;
        }

        $strSql.="  GROUP BY store.mb_fid ";
        $query = $this -> db -> query($strSql);
        $result = $query -> result();

        return $result;

    }

    
    function searchByCompany($arrReqData)
    {
        $strSql = "SELECT agency.mb_fid AS bet_emp_fid, agency.mb_uid AS mb_uid, agency.mb_nickname, SUM(bet_money) AS bet_money_sum, SUM(bet_win_money) AS bet_win_sum, COUNT(CASE WHEN bet_win_money > 0 THEN 1 END) AS bet_win_count, SUM( bet_empl_amount) AS bet_empl_amount, SUM( bet_agen_amount) AS bet_agen_amount FROM ".$this->mTableName;
        $strSql .= " INNER JOIN MEMBER AS store ON store.mb_fid = bet_powerball.bet_emp_fid AND store.mb_state_delete = 0 ";
        $strSql .= " INNER JOIN MEMBER AS agency ON agency.mb_fid = store.mb_emp_fid AND agency.mb_state_delete = 0 ";
        $strSql .= " WHERE bet_state != ".BET_CANCEL;
        $strSql .= " AND store.mb_level = ".MEMBER_EMPLOYEE_LEVEL;
        if(strlen($arrReqData['start']) > 0 && strlen($arrReqData['end']) > 0 ){
            $strSql.=" AND bet_time >= '".$arrReqData['start']." 0:0:0' AND bet_time <= '".$arrReqData['end']." 23:59:59'" ;
        }
        $strSql.="  GROUP BY agency.mb_fid ";
        $query = $this -> db -> query($strSql);
        $result = $query -> result();
        
        return $result; 

    }

    function getBetStatist($objUser, $arrRoundData, $gameId = -1){
        $arrBetSum = [0, 0, 0];
        if(is_null($objUser) || is_null($arrRoundData))
            return $arrBetSum;

        //단폴한도
        $strSql = " SELECT SUM(bet_money) AS bet_sum FROM ".$this->mTableName;
        $strSql.= " WHERE bet_state = ".BET_WAIT." AND CHAR_LENGTH(bet_target) = 1 AND bet_mb_uid = '".$objUser->mb_uid."' AND bet_round_no = ".$arrRoundData['round_no'];
        $strSql.= " AND bet_time > '".$arrRoundData['round_date']."' ";
        if($gameId >= 0)
            $strSql.= " AND bet_game = '".$gameId."' ";
        $objResult = $this -> db -> query($strSql)->row();
        if(!is_null($objResult->bet_sum))
            $arrBetSum[0] = $objResult->bet_sum;
        //조합한도
        $strSql = " SELECT SUM(bet_money) AS bet_sum FROM ".$this->mTableName;
        $strSql.= " WHERE bet_state = ".BET_WAIT." AND CHAR_LENGTH(bet_target) > 1 AND bet_mb_uid = '".$objUser->mb_uid."' AND bet_round_no = ".$arrRoundData['round_no'];
        $strSql.= " AND bet_time > '".$arrRoundData['round_date']."' ";
        if($gameId >= 0)
            $strSql.= " AND bet_game = '".$gameId."' ";
        $objResult = $this -> db -> query($strSql)->row();
        if(!is_null($objResult->bet_sum))
            $arrBetSum[1] = $objResult->bet_sum;
        //회차한도
        $strSql = " SELECT SUM(bet_money) AS bet_sum FROM ".$this->mTableName;
        $strSql.= " WHERE bet_state = ".BET_WAIT." AND bet_mb_uid = '".$objUser->mb_uid."' AND bet_round_no = ".$arrRoundData['round_no'];
        $strSql.= " AND bet_time > '".$arrRoundData['round_date']."' ";
        if($gameId >= 0)
            $strSql.= " AND bet_game = '".$gameId."' ";
        $objResult = $this -> db -> query($strSql)->row();
        if(!is_null($objResult->bet_sum))
            $arrBetSum[2] = $objResult->bet_sum;
        
        return $arrBetSum;
        
    }

    /**
     * 회차별통계 8컬럼용 빈 버킷
     */
    private function roundstatEmptySums(){
        return array(
            'sum_pb_holu' => 0, 'sum_pb_jjak' => 0, 'sum_pb_under' => 0, 'sum_pb_over' => 0,
            'sum_nb_holu' => 0, 'sum_nb_jjak' => 0, 'sum_nb_under' => 0, 'sum_nb_over' => 0,
        );
    }

    /** 배팅금액 × 배당(bet_ratio) 후 정수(바닥) */
    private function roundstatWeightedInt($money, $ratio){
        $m = is_numeric($money) ? (float) $money : 0;
        $r = is_numeric($ratio) ? (float) $ratio : 0;
        if($m <= 0 || $r < 0){
            return 0;
        }
        return (int) floor($m * $r + 1e-9);
    }

    /** k=2 균등분배 + 나머지 1씩은 앞쪽 버킷(정확히 합 일치) */
    private function roundstatAddSplit2(&$sums, $w, $keyA, $keyB){
        if($w < 1){
            return;
        }
        $b = intdiv($w, 2);
        $rem = $w % 2;
        $sums[$keyA] += $b + ($rem > 0 ? 1 : 0);
        $sums[$keyB] += $b;
    }

    /** k=3 균등분배(3묶음) */
    private function roundstatAddSplit3(&$sums, $w, $keyA, $keyB, $keyC){
        if($w < 1){
            return;
        }
        $b = intdiv($w, 3);
        $rem = $w % 3;
        $sums[$keyA] += $b + ($rem > 0 ? 1 : 0);
        $sums[$keyB] += $b + ($rem > 1 ? 1 : 0);
        $sums[$keyC] += $b;
    }

    /**
     * 한 건의 배팅을 8컬럼 표시 규칙에 반영
     * (모드 5~8 파워 조합·13~16 일반 조합은 2분할, 41~48 3묶음은 3분할. 숫자/대중소 단독 등은 표에 없음)
     */
    private function roundstatApplyBet(&$sums, $money, $ratio, $mode){
        $mode = (int) $mode;
        $w = $this->roundstatWeightedInt($money, $ratio);
        if($w < 1){
            return;
        }

        switch($mode){
            case 1:
                $sums['sum_pb_holu'] += $w;
                break;
            case 2:
                $sums['sum_pb_jjak'] += $w;
                break;
            case 3:
                $sums['sum_pb_under'] += $w;
                break;
            case 4:
                $sums['sum_pb_over'] += $w;
                break;
            case 9:
                $sums['sum_nb_holu'] += $w;
                break;
            case 10:
                $sums['sum_nb_jjak'] += $w;
                break;
            case 11:
                $sums['sum_nb_under'] += $w;
                break;
            case 12:
                $sums['sum_nb_over'] += $w;
                break;

            case 5:
                $this->roundstatAddSplit2($sums, $w, 'sum_pb_holu', 'sum_pb_under');
                break;
            case 6:
                $this->roundstatAddSplit2($sums, $w, 'sum_pb_jjak', 'sum_pb_under');
                break;
            case 7:
                $this->roundstatAddSplit2($sums, $w, 'sum_pb_holu', 'sum_pb_over');
                break;
            case 8:
                $this->roundstatAddSplit2($sums, $w, 'sum_pb_jjak', 'sum_pb_over');
                break;

            case 13:
                $this->roundstatAddSplit2($sums, $w, 'sum_nb_holu', 'sum_nb_under');
                break;
            case 14:
                $this->roundstatAddSplit2($sums, $w, 'sum_nb_jjak', 'sum_nb_under');
                break;
            case 15:
                $this->roundstatAddSplit2($sums, $w, 'sum_nb_holu', 'sum_nb_over');
                break;
            case 16:
                $this->roundstatAddSplit2($sums, $w, 'sum_nb_jjak', 'sum_nb_over');
                break;

            case 41:
                $this->roundstatAddSplit3($sums, $w, 'sum_nb_holu', 'sum_nb_under', 'sum_pb_holu');
                break;
            case 42:
                $this->roundstatAddSplit3($sums, $w, 'sum_nb_holu', 'sum_nb_under', 'sum_pb_jjak');
                break;
            case 43:
                $this->roundstatAddSplit3($sums, $w, 'sum_nb_holu', 'sum_nb_over', 'sum_pb_holu');
                break;
            case 44:
                $this->roundstatAddSplit3($sums, $w, 'sum_nb_holu', 'sum_nb_over', 'sum_pb_jjak');
                break;
            case 45:
                $this->roundstatAddSplit3($sums, $w, 'sum_nb_jjak', 'sum_nb_under', 'sum_pb_holu');
                break;
            case 46:
                $this->roundstatAddSplit3($sums, $w, 'sum_nb_jjak', 'sum_nb_under', 'sum_pb_jjak');
                break;
            case 47:
                $this->roundstatAddSplit3($sums, $w, 'sum_nb_jjak', 'sum_nb_over', 'sum_pb_holu');
                break;
            case 48:
                $this->roundstatAddSplit3($sums, $w, 'sum_nb_jjak', 'sum_nb_over', 'sum_pb_jjak');
                break;
            default:
                break;
        }
    }

    private function roundstatFetchBetsForFids($nGameId, array $fids){
        $fids = array_values(array_unique(array_filter(array_map('intval', $fids))));
        if(count($fids) < 1){
            return array();
        }
        $gid = (int) $nGameId;
        if(count($fids) > 100){
            $fids = array_slice($fids, 0, 100);
        }
        $in = implode(',', $fids);
        $sql = "SELECT bet_round_fid, bet_money, bet_ratio, bet_mode FROM ".$this->mTableName." WHERE "
            . "bet_game='".$this->db->escape_str((string) $gid)."' AND bet_state != ".((int) BET_CANCEL)." AND bet_round_fid IN (".$in.")";
        $query = $this->db->query($sql);
        return $query ? $query->result() : array();
    }

    private function roundstatGroupBetsByRoundFid($rows){
        $g = array();
        foreach($rows as $row){
            $rk = isset($row->bet_round_fid) ? (int) $row->bet_round_fid : 0;
            if(!isset($g[$rk])){
                $g[$rk] = array();
            }
            $g[$rk][] = $row;
        }
        return $g;
    }

    private function sumsToAggregateRow($betRoundFid, $betRoundNo, array $sums){
        return (object) array(
            'bet_round_fid' => (int) $betRoundFid,
            'bet_round_no' => (int) $betRoundNo,
            'sum_pb_holu' => (int) $sums['sum_pb_holu'],
            'sum_pb_jjak' => (int) $sums['sum_pb_jjak'],
            'sum_pb_under' => (int) $sums['sum_pb_under'],
            'sum_pb_over' => (int) $sums['sum_pb_over'],
            'sum_nb_holu' => (int) $sums['sum_nb_holu'],
            'sum_nb_jjak' => (int) $sums['sum_nb_jjak'],
            'sum_nb_under' => (int) $sums['sum_nb_under'],
            'sum_nb_over' => (int) $sums['sum_nb_over'],
        );
    }

    /**
     * 본사 회차별통계: 최근 N회차. 값 = floor(배팅금액×배당) 합; 2묶음/3묶음 분할 반영 (배팅 없는 회차도 0행)
     */
    function aggregateSimpleModesByRound($nGameId, $nLimit){

        $nLimit = (int) $nLimit;
        if($nLimit < 1) $nLimit = 9;
        if($nLimit > 50) $nLimit = 50;
        $gid = (int) $nGameId;

        $sqlRounds = "
			SELECT round_fid, round_num, round_date FROM round_pball
			WHERE round_game = ".$gid."
			ORDER BY round_date DESC, round_num DESC
			LIMIT ".$nLimit;
        $rq = $this->db->query($sqlRounds);
        $rounds = $rq ? $rq->result() : array();
        $fids = array();
        foreach($rounds as $r){
            $fids[] = (int) $r->round_fid;
        }
        $betRows = $this->roundstatFetchBetsForFids($gid, $fids);
        $byFid = $this->roundstatGroupBetsByRoundFid($betRows);

        $out = array();
        foreach($rounds as $r){
            $fid = (int) $r->round_fid;
            $sums = $this->roundstatEmptySums();
            if(isset($byFid[$fid])){
                foreach($byFid[$fid] as $b){
                    $this->roundstatApplyBet($sums, $b->bet_money, $b->bet_ratio, $b->bet_mode);
                }
            }
            $out[] = $this->sumsToAggregateRow($fid, (int) $r->round_num, $sums);
        }
        return $out;

    }

    /**
     * 진행 회차 한 줄: bet_round_fid 기준 배팅×배당 집계(조합 분할 규칙 동일)
     */
    function aggregateBetsForRound($nGameId, $roundFid, $roundNo){

        $gid = (int) $nGameId;
        $fid = (int) $roundFid;
        $no = (int) $roundNo;

        $sums = $this->roundstatEmptySums();
        $sql = "
			SELECT bet_money, bet_ratio, bet_mode FROM ".$this->mTableName."
			WHERE bet_game = '".$this->db->escape_str((string) $gid)."'
				AND bet_round_fid = '".$this->db->escape_str((string) $fid)."'
				AND bet_state != ".(int) BET_CANCEL;
        $query = $this->db->query($sql);
        if($query){
            foreach($query->result() as $b){
                $this->roundstatApplyBet($sums, $b->bet_money, $b->bet_ratio, $b->bet_mode);
            }
        }

        return $this->sumsToAggregateRow($fid, $no, $sums);

    }

}
