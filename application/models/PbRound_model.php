<?php
class PbRound_model extends CI_Model {
	
	private $mStrPowballRoundURL ;
    private $mTableName ;

    function __construct()
    {
        parent::__construct();

        $this->mTableName = "round_pball";
    }

    function gets($gameId, $nCount)
    {
        $sql = "SELECT round_fid, round_date, round_num, round_time, round_state, ";
        $sql.= " round_result_1, round_result_2, round_result_3, round_result_4, round_result_5, ";
        $sql.= "round_power, round_normal, round_hash  FROM ".$this->mTableName;
        $sql.= " WHERE round_game = ".$gameId;
        $sql.= " ORDER BY round_date DESC, round_num DESC LIMIT 0, ".$nCount;
        $query = $this -> db -> query($sql);
        $result = $query -> result();
        
        return $result;  
    }

    /** $id = round_fid (클라이언트 round_id / bet_round_fid와 동일 키) */
    public function getById($gameId, $id){
        
        return $this->db->get_where($this->mTableName, array('round_game'=>$gameId, 'round_fid'=>$id))->row();
    }

    /** round_fid => round_state */
    public function getStatesByFids($gameId, $arrFids){

        $arrMap = array();
        if(count($arrFids) < 1)
            return $arrMap;

        $this->db->select('round_fid, round_state');
        $this->db->where('round_game', $gameId);
        $this->db->where_in('round_fid', array_map('intval', $arrFids));
        foreach($this->db->get($this->mTableName)->result() as $objRow){
            $arrMap[(int)$objRow->round_fid] = (int)$objRow->round_state;
        }
        return $arrMap;
    }

    public function getByHash($gameId, $hash){
        
        return $this->db->get_where($this->mTableName, array('round_game'=>$gameId, 'round_hash'=>$hash))->row();
    }

    public function getByNum($gameId, $strDate, $nRoundNo){
        
        return $this->db->get_where($this->mTableName, array('round_game'=>$gameId, 'round_date'=>$strDate, 'round_num'=>$nRoundNo))->row();
    }

    /** 추첨 전(round_state!=1) partial 결과 필드만 갱신 */
    public function updatePendingResultCells($gameId, $roundFid, array $cells){

        if(count($cells) < 1)
            return false;

        $this->db->where('round_game', $gameId);
        $this->db->where('round_fid', $roundFid);
        $this->db->where('round_state !=', 1);
        foreach($cells as $col => $val){
            if(in_array($col, array('round_result_1','round_result_2','round_result_3','round_result_4'), true))
                $this->db->set($col, $val);
        }
        return $this->db->update($this->mTableName);
    }

}