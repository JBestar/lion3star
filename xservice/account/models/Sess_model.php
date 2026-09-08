<?php

class Sess_Model {

	private $mDbConn ;
	private $mTableName ;
	private $mKeepDelay ;

	function __construct($dbConn)
	{
		$this->mDbConn = $dbConn;
		$this->mTableName = "sess_list";
		//세션 유지 시간
		$this->mKeepDelay = "7200"; 

	}



    public function clearSession(){
    	

    	$strCurrent = date("Y-m-d H:i:s"); 

    	$tmSessionEnd = strtotime("-".$this->mKeepDelay." seconds", strtotime($strCurrent));
    	$strSessionEnd = date("Y-m-d H:i:s", $tmSessionEnd);

    	$strSql = "DELETE FROM ".$this->mTableName;
    	$strSql .= " WHERE sess_update_time < '".$strSessionEnd."'";

    	return $this->mDbConn->query($strSql);
    	
    }



}


?>