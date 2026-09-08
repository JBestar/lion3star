<?php

class PballBet_Model {

	private $mDbConn ;
	private $mTableName ;
	private $mMemberTable;

	function __construct($dbConn)
	{
		$this->mDbConn = $dbConn;
		$this->mTableName = "bet_powerball";
        $this->mMemberTable = "member";

	}



    public function getWaits($objRoundInfo, $gameId){
    	$strSql = "SELECT * FROM ".$this->mTableName;
    	$strSql.= " WHERE bet_state = '1' ";
        $strSql.= " AND bet_game = '".$gameId."' ";
        $strSql.= " AND bet_round_fid = '".$objRoundInfo->round_fid."' ";
        $strSql.= " ORDER BY bet_mb_uid, bet_time ASC ";
    	$arrResult = array();
    	if($objResult = $this->mDbConn->query($strSql)){
	    	if ($objResult->num_rows > 0) {
			  	while($arrRow = $objResult->fetch_assoc()) {
			    	array_push($arrResult, $arrRow);
		  		}
			}
			$objResult->free();
		}
		return $arrResult;

    }

    public function getWaitsByGame($gameId){
    	$strSql = "SELECT * FROM ".$this->mTableName;
    	$strSql.= " WHERE bet_state = '1' ";
        $strSql.= " AND bet_game = '".$gameId."' ";
        $strSql.= " ORDER BY bet_mb_uid, bet_time ASC ";
    	$arrResult = array();
    	if($objResult = $this->mDbConn->query($strSql)){
	    	if ($objResult->num_rows > 0) {
			  	while($arrRow = $objResult->fetch_assoc()) {
			    	array_push($arrResult, $arrRow);
		  		}
			}
			$objResult->free();
		}
		return $arrResult;
    }

    // 정산 디버깅용: 대기베팅이 왜 0건인지 빠르게 분해 확인
    public function getWaitDebugStats($objRoundInfo, $objRoundTm, $gameId){
        $arrStat = array(
            'wait_all_game' => 0,
            'wait_same_game' => 0,
            'wait_same_game_fid' => 0,
            'wait_same_game_in_window' => 0
        );

        $strSql = "SELECT COUNT(*) AS cnt FROM ".$this->mTableName;
        $strSql.= " WHERE bet_state = '1' ";
        $strSql.= " AND bet_round_no = '".$objRoundInfo->round_num."' ";
        if($objResult = $this->mDbConn->query($strSql)){
            if($objResult->num_rows > 0){
                while($arrRow = $objResult->fetch_assoc()){
                    $arrStat['wait_all_game'] = (int)$arrRow['cnt'];
                }
            }
            $objResult->free();
        }

        $strSql = "SELECT COUNT(*) AS cnt FROM ".$this->mTableName;
        $strSql.= " WHERE bet_state = '1' ";
        $strSql.= " AND bet_round_no = '".$objRoundInfo->round_num."' ";
        $strSql.= " AND bet_game = '".$gameId."' ";
        if($objResult = $this->mDbConn->query($strSql)){
            if($objResult->num_rows > 0){
                while($arrRow = $objResult->fetch_assoc()){
                    $arrStat['wait_same_game'] = (int)$arrRow['cnt'];
                }
            }
            $objResult->free();
        }

        $strSql = "SELECT COUNT(*) AS cnt FROM ".$this->mTableName;
        $strSql.= " WHERE bet_state = '1' ";
        $strSql.= " AND bet_game = '".$gameId."' ";
        $strSql.= " AND bet_round_fid = '".$objRoundInfo->round_fid."' ";
        if($objResult = $this->mDbConn->query($strSql)){
            if($objResult->num_rows > 0){
                while($arrRow = $objResult->fetch_assoc()){
                    $arrStat['wait_same_game_fid'] = (int)$arrRow['cnt'];
                }
            }
            $objResult->free();
        }

        $strSql = "SELECT COUNT(*) AS cnt FROM ".$this->mTableName;
        $strSql.= " WHERE bet_state = '1' ";
        $strSql.= " AND bet_round_no = '".$objRoundInfo->round_num."' ";
        $strSql.= " AND bet_game = '".$gameId."' ";
        $strSql.= " AND bet_time >= '".$objRoundTm['round_start']."' ";
        $strSql.= " AND bet_time <= '".$objRoundTm['round_end']."' ";
        if($objResult = $this->mDbConn->query($strSql)){
            if($objResult->num_rows > 0){
                while($arrRow = $objResult->fetch_assoc()){
                    $arrStat['wait_same_game_in_window'] = (int)$arrRow['cnt'];
                }
            }
            $objResult->free();
        }

        return $arrStat;
    }



    function updateBetRound($objRoundInfo, &$objBetInfo, &$nBeforeMoney)
    {
        $nWinMoney = 0;
        $isWin = false;
        if($objRoundInfo->round_state == 0)
            return false;
        //bet_state=2:Betting-loss 3:Betting-Earn 
        switch(intval($objBetInfo->bet_mode))
        {
            case 1:
            case 2:
                $objBetInfo->bet_result = $objRoundInfo->round_result_1;
                if($objBetInfo->bet_target == $objRoundInfo->round_result_1){
                    $isWin = true;                            
                }
                break;
            case 3:
            case 4:
                $objBetInfo->bet_result = $objRoundInfo->round_result_2;
                if($objBetInfo->bet_target == $objRoundInfo->round_result_2){
                    $isWin = true;
                }
                break;
            case 5:
                $objBetInfo->bet_result = $objRoundInfo->round_result_1.$objRoundInfo->round_result_2;
                if($objRoundInfo->round_result_1 == 'P' && $objRoundInfo->round_result_2 == 'P' ){
                    $isWin = true;
                }
                break;
            case 6:
                $objBetInfo->bet_result = $objRoundInfo->round_result_1.$objRoundInfo->round_result_2;
                if($objRoundInfo->round_result_1 == 'B' && $objRoundInfo->round_result_2 == 'P' ){
                    $isWin = true;
                }
                break;
            case 7:
                $objBetInfo->bet_result = $objRoundInfo->round_result_1.$objRoundInfo->round_result_2;
                if($objRoundInfo->round_result_1 == 'P' && $objRoundInfo->round_result_2 == 'B' ){
                    $isWin = true;
                }
                break;
            case 8:
                $objBetInfo->bet_result = $objRoundInfo->round_result_1.$objRoundInfo->round_result_2;
                if($objRoundInfo->round_result_1 == 'B' && $objRoundInfo->round_result_2 == 'B' ){
                    $isWin = true;
                }
                break;
            case 9:
            case 10:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3;
                if($objBetInfo->bet_target == $objRoundInfo->round_result_3){
                    $isWin = true;
                }
                break;
            case 11:
            case 12:
                $objBetInfo->bet_result = $objRoundInfo->round_result_4;
                if($objBetInfo->bet_target == $objRoundInfo->round_result_4){
                    $isWin = true;
                }
                break;
            case 13:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_4;
                if($objRoundInfo->round_result_3 == 'P' && $objRoundInfo->round_result_4 == 'P' ){
                    $isWin = true;
                }
                break;
            case 14:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_4;
                if($objRoundInfo->round_result_3 == 'B' && $objRoundInfo->round_result_4 == 'P' ){
                    $isWin = true;
                }
                break;
            case 15:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_4;
                if($objRoundInfo->round_result_3 == 'P' && $objRoundInfo->round_result_4 == 'B' ){
                    $isWin = true;
                }
                break;

            case 16:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_4;
                if($objRoundInfo->round_result_3 == 'B' && $objRoundInfo->round_result_4 == 'B' ){
                    $isWin = true;
                }
                break;
            case 17:
            case 18:
            case 19:
                $objBetInfo->bet_result = $objRoundInfo->round_result_5;
                if($objBetInfo->bet_target == $objRoundInfo->round_result_5){
                    $isWin = true;
                }
                break;
            case 20:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_5;
                if($objRoundInfo->round_result_3 == 'P' && $objRoundInfo->round_result_5 == 'L' ){
                    $isWin = true;
                }
                break;
            case 21:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_5;
                if($objRoundInfo->round_result_3 == 'P' && $objRoundInfo->round_result_5 == 'M' ){
                    $isWin = true;
                }
                break;
            case 22:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_5;
                if($objRoundInfo->round_result_3 == 'P' && $objRoundInfo->round_result_5 == 'S' ){
                    $isWin = true;
                }
                break;
            case 23:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_5;
                if($objRoundInfo->round_result_3 == 'B' && $objRoundInfo->round_result_5 == 'L' ){
                    $isWin = true;
                }
                break;
            case 24:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_5;
                if($objRoundInfo->round_result_3 == 'B' && $objRoundInfo->round_result_5 == 'M' ){
                    $isWin = true;
                }
                break;
            case 25;
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_5;
                if($objRoundInfo->round_result_3 == 'B' && $objRoundInfo->round_result_5 == 'S' ){
                    $isWin = true;
                }
                break;
            case 30:
                $objBetInfo->bet_result = intval($objRoundInfo->round_power);
                if($objBetInfo->bet_result == 0){
                    $isWin = true;
                }
                break;
            case 31:
                $objBetInfo->bet_result = intval($objRoundInfo->round_power);
                if($objBetInfo->bet_result == 1){
                    $isWin = true;
                }
                break;
            case 32:
                $objBetInfo->bet_result = intval($objRoundInfo->round_power);
                if($objBetInfo->bet_result == 2){
                    $isWin = true;
                }
                break;
            case 33:
                $objBetInfo->bet_result = intval($objRoundInfo->round_power);
                if($objBetInfo->bet_result == 3){
                    $isWin = true;
                }
                break;
            case 34:
                $objBetInfo->bet_result = intval($objRoundInfo->round_power);
                if($objBetInfo->bet_result == 4){
                    $isWin = true;
                }
                break;
            case 35:
                $objBetInfo->bet_result = intval($objRoundInfo->round_power);
                if($objBetInfo->bet_result == 5){
                    $isWin = true;
                }
                break;
            case 36:
                $objBetInfo->bet_result = intval($objRoundInfo->round_power);
                if($objBetInfo->bet_result == 6){
                    $isWin = true;
                }
                break;
            case 37:
                $objBetInfo->bet_result = intval($objRoundInfo->round_power);
                if($objBetInfo->bet_result == 7){
                    $isWin = true;
                }
                break;
            case 38:
                $objBetInfo->bet_result = intval($objRoundInfo->round_power);
                if($objBetInfo->bet_result == 8){
                    $isWin = true;
                }
                break;
            case 39:
                $objBetInfo->bet_result = intval($objRoundInfo->round_power);
                if($objBetInfo->bet_result == 9){
                    $isWin = true;
                }
                break;
            case 41:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_4.$objRoundInfo->round_result_1;
                if($objRoundInfo->round_result_3 == 'P' && $objRoundInfo->round_result_4 == 'P' && $objRoundInfo->round_result_1 == 'P' ){
                    $isWin = true;
                }
                break;
            case 42:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_4.$objRoundInfo->round_result_1;
                if($objRoundInfo->round_result_3 == 'P' && $objRoundInfo->round_result_4 == 'P' && $objRoundInfo->round_result_1 == 'B' ){
                    $isWin = true;
                }
                break;
            case 43:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_4.$objRoundInfo->round_result_1;
                if($objRoundInfo->round_result_3 == 'P' && $objRoundInfo->round_result_4 == 'B' && $objRoundInfo->round_result_1 == 'P' ){
                    $isWin = true;
                }
                break;
            case 44:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_4.$objRoundInfo->round_result_1;
                if($objRoundInfo->round_result_3 == 'P' && $objRoundInfo->round_result_4 == 'B' && $objRoundInfo->round_result_1 == 'B' ){
                    $isWin = true;
                }
                break;
            case 45:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_4.$objRoundInfo->round_result_1;
                if($objRoundInfo->round_result_3 == 'B' && $objRoundInfo->round_result_4 == 'P' && $objRoundInfo->round_result_1 == 'P' ){
                    $isWin = true;
                }
                break;
            case 46:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_4.$objRoundInfo->round_result_1;
                if($objRoundInfo->round_result_3 == 'B' && $objRoundInfo->round_result_4 == 'P' && $objRoundInfo->round_result_1 == 'B' ){
                    $isWin = true;
                }
                break;
            case 47:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_4.$objRoundInfo->round_result_1;
                if($objRoundInfo->round_result_3 == 'B' && $objRoundInfo->round_result_4 == 'B' && $objRoundInfo->round_result_1 == 'P' ){
                    $isWin = true;
                }
                break;
            case 48:
                $objBetInfo->bet_result = $objRoundInfo->round_result_3.$objRoundInfo->round_result_4.$objRoundInfo->round_result_1;
                if($objRoundInfo->round_result_3 == 'B' && $objRoundInfo->round_result_4 == 'B' && $objRoundInfo->round_result_1 == 'B' ){
                    $isWin = true;
                }
                break;
            
            default:
                return false;
        }


        if($nBeforeMoney < (int)$objBetInfo->bet_money){
            $nBeforeMoney = $objBetInfo->bet_before_money;
        }

        if($isWin){
            $objBetInfo->bet_state = 3;
            //bet_win_money
            $nWinMoney = $objBetInfo->bet_money * $objBetInfo->bet_ratio;
            $objBetInfo->bet_win_money = (int)$nWinMoney;
            //user_after_money
            $objBetInfo->bet_after_money = $nBeforeMoney + $objBetInfo->bet_win_money - $objBetInfo->bet_money;
            
            
        } else {
            $objBetInfo->bet_state = 2;
            $objBetInfo->bet_win_money = 0;
            //user_after_money
            $objBetInfo->bet_after_money = $nBeforeMoney - $objBetInfo->bet_money;
            
        }


        $strSql = "UPDATE ".$this->mTableName." SET ";
		$strSql.= " bet_state = '".$objBetInfo->bet_state."', ";	
		$strSql.= " bet_result = '" .$objBetInfo->bet_result."', ";
		$strSql.= " bet_win_money = '" .$objBetInfo->bet_win_money."', ";
		$strSql.= " bet_account_time = NOW(), ";
        $strSql.= " bet_after_money = '" .$objBetInfo->bet_after_money."' ";
		$strSql.= " WHERE bet_fid = '".$objBetInfo->bet_fid."' ";

        $bResult = $this->mDbConn->query($strSql);
        if($bResult)
            $nBeforeMoney = $objBetInfo->bet_after_money;
        
        return $bResult;
    }




    




}


?>