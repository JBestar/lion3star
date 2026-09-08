<?php

class PballRound_Model {

	private $mDbConn ;
	private $mTableName ;
	

	function __construct($dbConn)
	{
		$this->mDbConn = $dbConn;
		$this->mTableName = "round_pball";
		
	}

    public function getByDate($nGameId, $nRoundNo, $strDate){

    	$strSql = "SELECT * FROM ".$this->mTableName;
    	$strSql.= " WHERE round_game = '".$nGameId."' ";
    	$strSql.= " AND round_date = '".$strDate."' ";
    	$strSql.= " AND round_num = '".$nRoundNo."' ";

    	$arrResult = null;
    	if($objResult = $this->mDbConn->query($strSql)){
    	
	    	if ($objResult->num_rows > 0) {
			  	while($arrRow = $objResult->fetch_assoc()) {
			    	$arrResult = $arrRow;
			  	}
			}
			$objResult->free();
		}
		return $arrResult;
    }

    public function getByFid($nGameId, $nRoundFid){

    	$strSql = "SELECT * FROM ".$this->mTableName;
    	$strSql.= " WHERE round_game = '".$nGameId."' ";
    	$strSql.= " AND round_fid = '".$nRoundFid."' ";

    	$arrResult = null;
    	if($objResult = $this->mDbConn->query($strSql)){
    	
	    	if ($objResult->num_rows > 0) {
			  	while($arrRow = $objResult->fetch_assoc()) {
			    	$arrResult = $arrRow;
			  	}
			}
			$objResult->free();
		}
		return $arrResult;
    }


}


?>