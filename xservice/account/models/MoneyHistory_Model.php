<?php

class MoneyHistory_Model {

	private $mDbConn ;
	private $mTableName ;
	
	function __construct($dbConn)
	{
		$this->mDbConn = $dbConn;
		$this->mTableName = "money_history";
	

	}

    function registerAccountBet($objUser, $objBetData, $iType)
    {
        
        if(is_null($objUser)) return false;    
        if($objBetData->bet_win_money < 1) return false;


        $strSql = "INSERT INTO ".$this->mTableName." (money_mb_fid, money_mb_uid, money_mb_emp_fid, money_amount, money_before, ";
        $strSql.= " money_after, money_change_type, money_bet_round, money_bet_mode, money_bet_target, money_update_time) " ;

        $strSql .= " VALUES ('".$objUser->mb_fid."', '".$objUser->mb_uid."', '";
        $strSql .= $objUser->mb_emp_fid."', '".$objBetData->bet_win_money."', '".$objUser->mb_money."', '";
        $strSql .= ($objUser->mb_money+$objBetData->bet_win_money)."', '".$iType."', '";
        $strSql .= $objBetData->bet_round_no."', '".$objBetData->bet_mode."', '";
        $strSql .= $objBetData->bet_target."', NOW() )";

        return $this->mDbConn->query($strSql);
        
    }



}

?>