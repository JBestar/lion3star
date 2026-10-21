<?php

/** 회차 결과·정산 직후 회원별 보유금액 스냅샷 (회차별 베팅정보 표시용) */
class RoundBalance_Model {

	private $mDbConn ;
	private $mTableName ;

	function __construct($dbConn)
	{
		$this->mDbConn = $dbConn;
		$this->mTableName = "member_round_balance";
	}

	public function ensureTable()
	{
		$strSql = "CREATE TABLE IF NOT EXISTS ".$this->mTableName." (";
		$strSql.= " rb_fid int(11) NOT NULL AUTO_INCREMENT,";
		$strSql.= " rb_mb_uid varchar(30) NOT NULL,";
		$strSql.= " rb_game int(11) NOT NULL,";
		$strSql.= " rb_round_fid int(11) NOT NULL,";
		$strSql.= " rb_round_no int(11) NOT NULL,";
		$strSql.= " rb_balance int(11) NOT NULL,";
		$strSql.= " rb_time datetime NOT NULL,";
		$strSql.= " PRIMARY KEY (rb_fid),";
		$strSql.= " UNIQUE KEY uk_uid_game_round (rb_mb_uid, rb_game, rb_round_fid),";
		$strSql.= " KEY idx_game_round (rb_game, rb_round_fid)";
		$strSql.= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

		return $this->mDbConn->query($strSql);
	}

	public function getLatestDoneRound($nGameId)
	{
		$strSql = "SELECT round_fid, round_num FROM round_pball";
		$strSql.= " WHERE round_game = ".intval($nGameId)." AND round_state = 1";
		$strSql.= " ORDER BY round_fid DESC LIMIT 1";

		$arrRow = null;
		if($objResult = $this->mDbConn->query($strSql)){
			$arrRow = $objResult->fetch_assoc();
			$objResult->free();
		}
		return $arrRow;
	}

	/**
	 * 보유금액 = 현재 mb_money + 이후 회차 대기 베팅금.
	 * 해당 회차에 아직 대기 베팅이 남은 회원은 정산 전이므로 제외.
	 */
	public function snapshot($nGameId, $nRoundFid, $nRoundNo)
	{
		$nGameId = intval($nGameId);
		$nRoundFid = intval($nRoundFid);
		$nRoundNo = intval($nRoundNo);

		$strSql = "INSERT IGNORE INTO ".$this->mTableName;
		$strSql.= " (rb_mb_uid, rb_game, rb_round_fid, rb_round_no, rb_balance, rb_time)";
		$strSql.= " SELECT m.mb_uid, ".$nGameId.", ".$nRoundFid.", ".$nRoundNo.", m.mb_money + IFNULL(w.wait_sum, 0), NOW()";
		$strSql.= " FROM member m";
		$strSql.= " LEFT JOIN (SELECT bet_mb_uid, SUM(bet_money) AS wait_sum FROM bet_powerball";
		$strSql.= "   WHERE bet_state = ".BET_WAIT." AND bet_game = ".$nGameId." AND bet_round_fid > ".$nRoundFid;
		$strSql.= "   GROUP BY bet_mb_uid) w ON w.bet_mb_uid = m.mb_uid";
		$strSql.= " WHERE m.mb_level = ".MEMBER_USER_LEVEL." AND m.mb_state_delete = 0";
		$strSql.= " AND NOT EXISTS (SELECT 1 FROM bet_powerball b WHERE b.bet_mb_uid = m.mb_uid";
		$strSql.= "   AND b.bet_state = ".BET_WAIT." AND b.bet_game = ".$nGameId." AND b.bet_round_fid = ".$nRoundFid.")";

		if(!$this->mDbConn->query($strSql))
			return -1;
		return $this->mDbConn->affected_rows;
	}

	public function prune($nGameId, $nRoundFid)
	{
		$strSql = "DELETE FROM ".$this->mTableName;
		$strSql.= " WHERE rb_game = ".intval($nGameId);
		$strSql.= " AND rb_round_fid < ".(intval($nRoundFid) - ROUND_BALANCE_KEEP);

		return $this->mDbConn->query($strSql);
	}
}

?>
