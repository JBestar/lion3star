<?php
class Clean_model extends CI_Model {
	
	
    function __construct()
    {
        parent::__construct();

    }
    //디비정리
    function cleanDb($arrReqData){
        $tmNow = time();
        $strDate = date('Y-m-d');
        
        if(!array_key_exists("date", $arrReqData))
            return 0;
        if($strDate < $arrReqData['date'])
            return 0; 
        $strDate = $arrReqData['date'];

        $strSql = " DELETE FROM bet_powerball WHERE bet_time < '".$strDate."' ";
        $this -> db -> query($strSql);
        
        $strSql = " DELETE FROM round_pball WHERE round_date < '".$strDate."' ";
        $this -> db -> query($strSql);

        $strSql = " DELETE FROM board_notice WHERE notice_time_create < '".$strDate."' ";
        $this -> db -> query($strSql);
        
        $strSql = " DELETE FROM log_history WHERE log_time < '".$strDate."' ";
        $this -> db -> query($strSql);
        
        $strSql = " DELETE FROM member_charge WHERE charge_time_require < '".$strDate."' ";
        $this -> db -> query($strSql);
        
        $strSql = " DELETE FROM member_exchange WHERE exchange_time_require < '".$strDate."' ";
        $this -> db -> query($strSql);
        
        $strSql = " DELETE FROM money_history WHERE money_update_time < '".$strDate."' ";
        $this -> db -> query($strSql);

        if($this->db->table_exists('bet_request')){
            $strSql = " DELETE FROM bet_request WHERE req_time < '".$strDate."' ";
            $this -> db -> query($strSql);
        }
        
    	//$this->db->truncate("sess_list");
        //$this->db->truncate("sessions");
        
        return 1;
    }
    //디비초기화
    function initDb(){
        $this->db->truncate("bet_powerball");
        $this->db->truncate("board_notice");
        $this->db->truncate("log_history");
    	$this->db->truncate("member_charge");
    	$this->db->truncate("member_exchange");
    	$this->db->truncate("money_history");
        if($this->db->table_exists('bet_request'))
            $this->db->truncate("bet_request");
    	$this->db->truncate("sess_list");
        $this->db->truncate("sessions");
        return 1;
    }
}