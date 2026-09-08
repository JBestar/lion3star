<?php

class Member_Model {

	private $mDbConn ;
	private $mTableName ;

	function __construct($dbConn)
	{
		$this->mDbConn = $dbConn;
		$this->mTableName = "member";

	}

	public function getByUid($strUId){
        $strSql = "SELECT * FROM ".$this->mTableName;
    	$strSql.= " WHERE mb_uid = '".$strUId."' ";
    	
    	$objMember = null;
    	if($objResult = $this->mDbConn->query($strSql)){
	    	if ($objResult->num_rows > 0) {
			  	while($arrRow = $objResult->fetch_assoc()) {
			    	$objMember = (object)$arrRow;
			    	break;
		  		}
			}
			$objResult->free();
		}
		return $objMember;
    }



    function updateWinMoney($objBetInfo){

    	$nEarnMoney = 0;
        if($objBetInfo->bet_win_money <= 0)
            return null;
        

        $strSql1 = "SELECT * FROM ".$this->mTableName;
        $strSql1.= " WHERE mb_uid = '".$objBetInfo->bet_mb_uid."' ";

        $strSql2 = "UPDATE ".$this->mTableName." SET ";
        $strSql2.= " mb_money = mb_money+".$objBetInfo->bet_win_money;
        $strSql2.= " WHERE mb_uid = '".$objBetInfo->bet_mb_uid."' ";

        $this->mDbConn->begin_transaction();

        
        try{

            $objResult1 = $this->mDbConn->query($strSql1);
            $objResult2 =$this->mDbConn->query($strSql2);

            $this->mDbConn->commit();

            $objMember = null;
            if($objResult1 && $objResult2){
                if ($objResult1->num_rows > 0) {
                    while($arrRow = $objResult1->fetch_assoc()) {
                        $objMember = (object)$arrRow;
                        break;
                    }
                }
                $objResult1->free();
            }
            return $objMember;

        } catch(mysqli_sql_exception $exception){
            
            $this->mDbConn->rollbalck();            
            //throw $exception;
            return null;
        }
        return null;

    }


}

?>