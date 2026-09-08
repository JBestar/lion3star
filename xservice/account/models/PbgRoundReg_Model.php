<?php

/**
 * Lion round_pball 등록용 (PBG / round_game=0). lion3star 스키마 대응.
 */
class PbgRoundReg_Model
{
	private $mTableName = 'round_pball';
	private $mGameId = 0; // GAME_POWERBALL

	private function normalizeRoundHash($roundHash)
	{
		if (is_null($roundHash)) {
			return 0;
		}
		$v = trim((string) $roundHash);
		if ($v === '') {
			return 0;
		}
		if (strpos($v, '/') !== false) {
			$parts = explode('/', $v, 2);
			if (count($parts) === 2 && is_numeric($parts[0]) && is_numeric($parts[1]) && (float) $parts[1] != 0) {
				return (int) floor(((float) $parts[0]) / ((float) $parts[1]));
			}
			if (is_numeric($parts[0])) {
				return (int) $parts[0];
			}
		}
		if (is_numeric($v)) {
			return (int) $v;
		}
		$digits = preg_replace('/[^0-9]/', '', $v);
		return ($digits === '') ? 0 : (int) $digits;
	}

	public function getByFid($dbConn, $nRoundFid)
	{
		$sql = "SELECT * FROM {$this->mTableName}"
			. " WHERE round_game = '{$this->mGameId}'"
			. " AND round_fid = '" . (int) $nRoundFid . "' LIMIT 1";
		$res = $dbConn->query($sql);
		if (!$res) {
			return null;
		}
		$row = $res->fetch_assoc();
		$res->free();
		return $row ? $row : null;
	}

	public function getByDate($dbConn, $nRoundNo, $strDate)
	{
		$escDate = $dbConn->real_escape_string($strDate);
		$sql = "SELECT * FROM {$this->mTableName}"
			. " WHERE round_game = '{$this->mGameId}'"
			. " AND round_num = '" . (int) $nRoundNo . "'"
			. " AND round_date = '{$escDate}' LIMIT 1";
		$res = $dbConn->query($sql);
		if (!$res) {
			return null;
		}
		$row = $res->fetch_assoc();
		$res->free();
		return $row ? $row : null;
	}

	public function getLast($dbConn)
	{
		$sql = "SELECT * FROM {$this->mTableName}"
			. " WHERE round_game = '{$this->mGameId}'"
			. " ORDER BY round_fid DESC LIMIT 1";
		$res = $dbConn->query($sql);
		if (!$res) {
			return null;
		}
		$row = $res->fetch_assoc();
		$res->free();
		return $row ? $row : null;
	}

	public function deleteByFid($dbConn, $nRoundFid)
	{
		$sql = "DELETE FROM {$this->mTableName}"
			. " WHERE round_game = '{$this->mGameId}'"
			. " AND round_fid = '" . (int) $nRoundFid . "'";
		return $dbConn->query($sql) === true;
	}

	public function registerEmptyRound($dbConn, $arrRoundInfo)
	{
		$existing = $this->getByDate($dbConn, $arrRoundInfo['round_no'], $arrRoundInfo['round_date']);
		if (!is_null($existing)) {
			$arrRoundInfo['round_fid'] = $existing['round_fid'];
			$arrRoundInfo['round_state'] = $existing['round_state'];
			return $arrRoundInfo;
		}

		$arrRoundInfo['round_state'] = 0;
		$last = $this->getLast($dbConn);
		if (!is_null($last)) {
			$arrRoundInfo['round_fid'] = (int) $last['round_fid'] + 1;
		} else {
			$arrRoundInfo['round_fid'] = 10001;
		}

		$escDate = $dbConn->real_escape_string($arrRoundInfo['round_date']);
		$fid = (int) $arrRoundInfo['round_fid'];
		$num = (int) $arrRoundInfo['round_no'];
		$sql = "INSERT INTO {$this->mTableName}"
			. " (round_fid, round_game, round_date, round_num, round_time, round_state,"
			. " round_result_1, round_result_2, round_result_3, round_result_4, round_result_5,"
			. " round_power, round_normal, round_hash, round_period)"
			. " VALUES ('{$fid}', '{$this->mGameId}', '{$escDate}', '{$num}', NOW(), '0',"
			. " '', '', '', '', '', '', '', '0', '5')";

		if ($dbConn->query($sql) === true) {
			return $arrRoundInfo;
		}
		return null;
	}

	public function registerRoundDiagnose($arrRoundInfo, $arrRoundResult)
	{
		if (is_null($arrRoundInfo) || is_null($arrRoundResult)) {
			return 'null_arrRoundInfo_or_arrRoundResult';
		}
		if (isset($arrRoundInfo['round_state']) && $arrRoundInfo['round_state'] == 1) {
			return 'already_done_round_state_1';
		}
		if (!array_key_exists('date', $arrRoundResult) || !array_key_exists('date_round', $arrRoundResult)) {
			return 'missing_date_or_date_round';
		}
		if (empty($arrRoundResult['date']) || $arrRoundResult['date'] !== $arrRoundInfo['round_date']) {
			return 'date_mismatch local=' . $arrRoundInfo['round_date'] . ' api=' . $arrRoundResult['date'];
		}
		if (empty($arrRoundResult['date_round']) || $arrRoundResult['date_round'] != $arrRoundInfo['round_no']) {
			return 'round_no_mismatch local=' . $arrRoundInfo['round_no'] . ' api=' . $arrRoundResult['date_round'];
		}
		if (empty($arrRoundResult['times']) || $arrRoundResult['times'] < 1) {
			return 'times_empty_or_invalid';
		}
		if (empty($arrRoundResult['ball']) || !is_array($arrRoundResult['ball'])) {
			return 'ball_missing';
		}
		if (count($arrRoundResult['ball']) != 6) {
			return 'ball_count_' . count($arrRoundResult['ball']);
		}
		return 'sql_fail_or_fid_delete_conflict';
	}

	public function registerRound($dbConn, $arrRoundInfo, $arrRoundResult)
	{
		if (is_null($arrRoundInfo) || is_null($arrRoundResult)) {
			return 0;
		}
		if ($arrRoundInfo['round_state'] == 1) {
			return $arrRoundInfo['round_fid'];
		}
		if (!array_key_exists('date', $arrRoundResult) || !array_key_exists('date_round', $arrRoundResult)) {
			return 0;
		}
		if (empty($arrRoundResult['date']) || $arrRoundResult['date'] !== $arrRoundInfo['round_date']) {
			return 0;
		}
		if (empty($arrRoundResult['date_round']) || $arrRoundResult['date_round'] != $arrRoundInfo['round_no']) {
			return 0;
		}

		$nRoundFid = (int) $arrRoundResult['times'];
		if ($nRoundFid < 1) {
			return 0;
		}

		$bExistFid = false;
		$emptyFid = (int) $arrRoundInfo['round_fid'];
		if ($emptyFid != $nRoundFid) {
			$objRoundDb = $this->getByFid($dbConn, $nRoundFid);
			if (!is_null($objRoundDb)) {
				if (!$this->deleteByFid($dbConn, $emptyFid)) {
					return 0;
				}
				$bExistFid = true;
			}
			$arrRoundInfo['round_fid'] = $nRoundFid;
		}

		$balls = $arrRoundResult['ball'];
		if (empty($balls) || !is_array($balls) || count($balls) != 6) {
			return 0;
		}

		$nNorBallSum = 0;
		$strNorball = '';
		for ($i = 0; $i < 5; $i++) {
			if (!is_numeric($balls[$i])) {
				return 0;
			}
			$nNorBallSum += (int) $balls[$i];
			$strNorball .= ((int) $balls[$i]) . ',';
		}
		$strNorball = substr($strNorball, 0, -1);
		if (!is_numeric($balls[5])) {
			return 0;
		}
		$nPowerball = (int) $balls[5];

		$strResult1 = ($nPowerball % 2) ? 'P' : 'B';
		$strResult2 = ($nPowerball < 5) ? 'P' : 'B';
		$strResult3 = ($nNorBallSum % 2) ? 'P' : 'B';
		$strResult4 = ($nNorBallSum <= 72) ? 'P' : 'B';
		$strResult5 = 'X';
		if ($nNorBallSum >= 15 && $nNorBallSum <= 64) {
			$strResult5 = 'S';
		} elseif ($nNorBallSum >= 65 && $nNorBallSum <= 80) {
			$strResult5 = 'M';
		} elseif ($nNorBallSum >= 81 && $nNorBallSum <= 130) {
			$strResult5 = 'L';
		}

		$escDate = $dbConn->real_escape_string($arrRoundInfo['round_date']);
		$fid = (int) $arrRoundInfo['round_fid'];
		$num = (int) $arrRoundInfo['round_no'];

		$sql = "UPDATE {$this->mTableName} SET ";
		if (!$bExistFid) {
			$sql .= " round_fid = '{$fid}', ";
		} else {
			$sql .= " round_date = '{$escDate}', ";
			$sql .= " round_num = '{$num}', ";
			$sql .= " round_time = NOW(), ";
		}
		$sql .= " round_state = '1', ";
		$sql .= " round_result_1 = '{$strResult1}', ";
		$sql .= " round_result_2 = '{$strResult2}', ";
		$sql .= " round_result_3 = '{$strResult3}', ";
		$sql .= " round_result_4 = '{$strResult4}', ";
		$sql .= " round_result_5 = '{$strResult5}', ";
		$sql .= " round_power = '{$nPowerball}', ";
		$sql .= " round_normal = '" . $dbConn->real_escape_string($strNorball) . "' ";

		if (array_key_exists('round_hash', $arrRoundResult)) {
			$nHash = $this->normalizeRoundHash($arrRoundResult['round_hash']);
			$sql .= ", round_hash = '{$nHash}' ";
		}

		if ($bExistFid) {
			$sql .= " WHERE round_game = '{$this->mGameId}' AND round_fid = '{$fid}' ";
		} else {
			$sql .= " WHERE round_game = '{$this->mGameId}'"
				. " AND round_date = '{$escDate}' AND round_num = '{$num}' ";
		}

		if ($dbConn->query($sql) === true) {
			return $arrRoundInfo['round_fid'];
		}
		return 0;
	}
}
