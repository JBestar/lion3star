<?php

include_once('helpers/Constant.php');
include_once('helpers/Logic_Helper.php');
include_once('ServiceLogic.php');

date_default_timezone_set('Asia/Seoul');
sleep(1);

loadLionEnv();

$dbLion = connectDbFromEnv('DB_');
if ($dbLion === null) {
	echo "Lion DB connection failed. Check .env DB_*\r\n";
	sleep(30);
	exit(1);
}

$dbPbg = connectDbFromEnv('POWERBALL_DB_');
if ($dbPbg === null) {
	echo "Powerball DB connection failed. Check .env POWERBALL_DB_*\r\n";
	sleep(30);
	exit(1);
}

$tRootDir = dirname(__FILE__);
if (!is_dir($tRootDir . '/log')) {
	mkdir($tRootDir . '/log');
}

$fName = date('Y-m-d');
$fLog = fopen($tRootDir . '/log/acc_' . $fName, 'a');

$objServLogic = new ServiceLogic($dbLion, $dbPbg);

$bPgReg = false;
$bPbAcc = false;
$bSlotDone = false;

writeAccLog($fLog, 'account service started (PBG register + settle)');

// 1) 기동: 어제 ~ 현재 직전 회차 결과 백필
writeAccLog($fLog, 'startup backfill: yesterday .. now');
$bf = $objServLogic->backfillFromYesterdayToNow($fLog);
writeAccLog(
	$fLog,
	'startup backfill done slots=' . $bf['slots']
		. ' filled=' . $bf['filled']
		. ' already=' . $bf['already']
		. ' no_draw=' . $bf['no_draw']
		. ' fail=' . $bf['fail']
);

// 2) 기동: 미정산 일괄
writeAccLog($fLog, 'startup catch-up: settle unsettled PBG bets');
$arrCatchUp = $objServLogic->pbaccount(true, GAME_POWERBALL);
writeAccLog(
	$fLog,
	'startup catch-up done status=' . $arrCatchUp['status']
		. ' waits=' . $arrCatchUp['waits']
		. ' updated=' . $arrCatchUp['updated']
		. ' won=' . $arrCatchUp['won']
		. ' skip_missing=' . $arrCatchUp['skip_missing']
		. ' skip_not_ready=' . $arrCatchUp['skip_not_ready']
);

while (true) {
	$tmNow = time();
	$nHour = (int) date('G', $tmNow);
	$nMin = (int) date('i', $tmNow);
	$nSec = (int) date('s', $tmNow);

	if ($nHour === 0 && $nMin === 0 && $nSec < 4) {
		$strDate = date('Y-m-d', $tmNow);
		if ($fName !== $strDate) {
			if ($fLog) {
				fclose($fLog);
			}
			$fName = $strDate;
			$fLog = fopen($tRootDir . '/log/acc_' . $fName, 'a');
			writeAccLog($fLog, 'Log File----' . $fName);
		}
	}

	if ($nSec < 3) {
		$objServLogic->clearSession();
	}

	// 매 5분 시작 후: 직전 회차 결과 등록 → 정산
	if (!$bSlotDone && ($nMin % 5) === 0 && $nSec >= 0 && $nSec <= 90) {
		if (!$bPgReg && $nSec <= 50) {
			$reg = $objServLogic->registerCurrentSlot($fLog);
			if ($reg['status'] === 'success') {
				$bPgReg = true;
				writeAccLog($fLog, 'PBG-ok times=' . $reg['times']
					. ' drawn_at=' . $reg['drawn_at']
					. ' balls=' . $reg['balls']);
			} elseif ($reg['status'] === 'already') {
				$bPgReg = true;
				writeAccLog($fLog, 'PBG-already drawn_at=' . $reg['drawn_at']);
			} elseif ($reg['status'] === 'no_draw') {
				writeAccLog($fLog, 'PBG-wait drawn_at=' . $reg['drawn_at']);
			} else {
				writeAccLog($fLog, 'PBG-reg-' . $reg['status'] . ' drawn_at=' . $reg['drawn_at']);
			}
		}

		// 결과 등록 성공/이미있음 이거나, 슬롯 후반이면 정산 시도
		if (!$bPbAcc && ($bPgReg || $nSec >= 45)) {
			$acc = $objServLogic->pbaccount(true, GAME_POWERBALL);
			$bPbAcc = true;
			writeAccLog(
				$fLog,
				'acc-pb updated=' . $acc['updated']
					. ' won=' . $acc['won']
					. ' waits=' . $acc['waits']
					. ' skip_not_ready=' . $acc['skip_not_ready']
			);
			$bSlotDone = true;
		}
	} elseif ($bSlotDone && ($nMin % 5) === 4 && $nSec >= 30) {
		$bPgReg = false;
		$bPbAcc = false;
		$bSlotDone = false;
		$objServLogic->clearSession();
		writeAccLog($fLog, '============Round Start===========');
	}

	usleep(500000);
}

if ($fLog) {
	fclose($fLog);
}
