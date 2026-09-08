<?php

include_once('models/PballRound_Model.php');
include_once('models/PballBet_Model.php');
include_once('models/Member_Model.php');
include_once('models/MoneyHistory_Model.php');
include_once('models/Sess_model.php');
include_once('models/PbgRoundReg_Model.php');

class ServiceLogic
{
	private $dbLion;
	private $dbPbg;
	private $modelPballRound;
	private $modelPballBet;
	private $modelMember;
	private $modelSession;
	private $modelReg;

	function __construct($dbLion, $dbPbg = null)
	{
		$this->dbLion = $dbLion;
		$this->dbPbg = $dbPbg;
		$this->modelPballRound = new PballRound_Model($dbLion);
		$this->modelPballBet = new PballBet_Model($dbLion);
		$this->modelMember = new Member_Model($dbLion);
		$this->modelSession = new Sess_Model($dbLion);
		$this->modelReg = new PbgRoundReg_Model();
	}

	public function setPbgDb($dbPbg)
	{
		$this->dbPbg = $dbPbg;
	}

	/** PBG 파워볼 정산 — 대기 배팅 중 round_state=1 인 것 전부 */
	public function pbaccount($bCurrent, $gameId)
	{
		$arrBetData = $this->modelPballBet->getWaitsByGame($gameId);

		$tBetUid = '';
		$nBeforeMoney = 0;
		$nUpdated = 0;
		$nWon = 0;
		$nSkipRoundMissing = 0;
		$nSkipRoundNotReady = 0;

		foreach ($arrBetData as $arrBetInfo) {
			$objBetInfo = (object) $arrBetInfo;

			$objRoundInfo = $this->modelPballRound->getByFid($gameId, $objBetInfo->bet_round_fid);
			if (is_null($objRoundInfo)) {
				$nSkipRoundMissing++;
				continue;
			}
			$objRoundInfo = (object) $objRoundInfo;
			if ($objRoundInfo->round_state != 1) {
				$nSkipRoundNotReady++;
				continue;
			}

			if (strcmp($tBetUid, $objBetInfo->bet_mb_uid) !== 0) {
				$tBetUid = $objBetInfo->bet_mb_uid;
				$nBeforeMoney = $objBetInfo->bet_before_money;
			}

			$bResult = $this->modelPballBet->updateBetRound($objRoundInfo, $objBetInfo, $nBeforeMoney);
			if ($bResult) {
				$nUpdated++;
				if ($objBetInfo->bet_win_money > 0) {
					$nWon++;
					$this->modelMember->updateWinMoney($objBetInfo);
				}
			}
		}

		return array(
			'status' => 'success',
			'waits' => count($arrBetData),
			'updated' => $nUpdated,
			'won' => $nWon,
			'skip_missing' => $nSkipRoundMissing,
			'skip_not_ready' => $nSkipRoundNotReady,
		);
	}

	function clearSession()
	{
		$this->modelSession->clearSession();
	}

	public function fetchDrawByDrawnAt($drawnAt)
	{
		if ($this->dbPbg === null || $drawnAt === '') {
			return null;
		}
		$esc = $this->dbPbg->real_escape_string($drawnAt);
		$sql = "SELECT round, daily_round, ball1, ball2, ball3, ball4, ball5, powerball, ball_sum, drawn_at "
			. "FROM draw_results WHERE drawn_at = '{$esc}' LIMIT 1";
		$res = $this->dbPbg->query($sql);
		if (!$res) {
			return null;
		}
		$row = $res->fetch_assoc();
		$res->free();
		return $row ? $row : null;
	}

	/** 지정 슬롯에 결과 등록 (이미 state=1 이면 skip) */
	public function pbgregisterSlot($roundDate, $roundNo, $fLog = null)
	{
		$arrRoundInfo = array(
			'round_date' => $roundDate,
			'round_no' => (int) $roundNo,
		);
		$drawnAt = drawnAtFromRoundInfo($roundNo, $roundDate);
		$row = $this->fetchDrawByDrawnAt($drawnAt);
		$arrRoundResult = drawRowToRoundResult($row, $roundDate, $roundNo);
		if ($arrRoundResult === null) {
			return array('status' => 'no_draw', 'drawn_at' => $drawnAt);
		}

		$arrPbRoundInfo = $this->modelReg->registerEmptyRound($this->dbLion, $arrRoundInfo);
		if (is_null($arrPbRoundInfo)) {
			writeAccLog($fLog, 'PBG empty_round_insert_fail ' . $roundDate . ' #' . $roundNo);
			return array('status' => 'fail', 'drawn_at' => $drawnAt);
		}
		if ((int) $arrPbRoundInfo['round_state'] === 1) {
			return array('status' => 'already', 'drawn_at' => $drawnAt, 'times' => $arrPbRoundInfo['round_fid']);
		}

		$nRegPbId = $this->modelReg->registerRound($this->dbLion, $arrPbRoundInfo, $arrRoundResult);
		if ($nRegPbId > 0) {
			return array(
				'status' => 'success',
				'drawn_at' => $drawnAt,
				'times' => $nRegPbId,
				'balls' => implode(',', $arrRoundResult['ball']),
			);
		}
		$diag = $this->modelReg->registerRoundDiagnose($arrPbRoundInfo, $arrRoundResult);
		writeAccLog($fLog, 'PBG regfail ' . $diag . ' ' . $drawnAt);
		return array('status' => 'fail', 'drawn_at' => $drawnAt, 'diag' => $diag);
	}

	/** 어제 1회차 ~ 기동 직전 완료 회차까지 결과 채우기 */
	public function backfillFromYesterdayToNow($fLog = null)
	{
		$slots = slotsFromYesterdayToNow();
		$ok = 0;
		$already = 0;
		$noDraw = 0;
		$fail = 0;
		foreach ($slots as $slot) {
			$r = $this->pbgregisterSlot($slot['round_date'], $slot['round_no'], $fLog);
			if ($r['status'] === 'success') {
				$ok++;
			} elseif ($r['status'] === 'already') {
				$already++;
			} elseif ($r['status'] === 'no_draw') {
				$noDraw++;
			} else {
				$fail++;
			}
		}
		return array(
			'slots' => count($slots),
			'filled' => $ok,
			'already' => $already,
			'no_draw' => $noDraw,
			'fail' => $fail,
		);
	}

	/** 현재 직전 슬롯 결과 등록 */
	public function registerCurrentSlot($fLog = null)
	{
		$slot = getLastRoundInfo(ROUND_5MIN);
		return $this->pbgregisterSlot($slot['round_date'], $slot['round_no'], $fLog);
	}
}
