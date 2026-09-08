<?php

/**
 * Load key=value pairs from lion3/.env into putenv / $_ENV.
 */
function loadLionEnv($envPath = null)
{
	if ($envPath === null) {
		$envPath = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . '.env';
	}
	if (!is_file($envPath) || !is_readable($envPath)) {
		return false;
	}
	foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
		$line = trim($line);
		if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) {
			continue;
		}
		list($name, $value) = explode('=', $line, 2);
		$name = trim($name);
		$value = trim($value);
		if ($value !== '' && ($value[0] === '"' || $value[0] === "'")) {
			$value = trim($value, "\"'");
		}
		if ($name !== '' && !array_key_exists($name, $_ENV)) {
			putenv($name . '=' . $value);
			$_ENV[$name] = $value;
		}
	}
	return true;
}

function envOr($key, $default = '')
{
	$v = getenv($key);
	if ($v === false || $v === '') {
		return $default;
	}
	return $v;
}

function connectDbFromEnv($prefix = 'DB_')
{
	$host = envOr($prefix . 'HOSTNAME', 'localhost');
	$user = envOr($prefix . 'USERNAME', 'root');
	$pwd  = envOr($prefix . 'PASSWORD', '');
	$name = envOr($prefix . 'DATABASE', '');
	if ($name === '') {
		return null;
	}
	mysqli_report(MYSQLI_REPORT_OFF);
	$conn = @new mysqli($host, $user, $pwd, $name);
	if ($conn->connect_errno) {
		return null;
	}
	$conn->set_charset('utf8');
	return $conn;
}

function writeAccLog($fLog, $msg)
{
	$line = date('Y-m-d H:i:s') . ' ' . $msg . "\r\n";
	echo $line;
	if ($fLog) {
		fputs($fLog, $line);
	}
}

/** 직전(완료) 5분 회차 */
function getLastRoundInfo($roundMin = 5)
{
	date_default_timezone_set('Asia/Seoul');
	$tmNow = time();
	$nHour = (int) date('G', $tmNow);
	$nMin = (int) date('i', $tmNow);
	$nSumMinutes = $nHour * 60 + $nMin;
	$nRoundNo = (int) floor($nSumMinutes / $roundMin);
	$nRoundMax = (int) floor(1440 / $roundMin);
	if ($nRoundNo === 0) {
		$nRoundNo = $nRoundMax;
		$strDate = date('Y-m-d', strtotime('-1 day', $tmNow));
	} else {
		$strDate = date('Y-m-d', $tmNow);
	}
	return array(
		'round_no' => $nRoundNo,
		'round_date' => $strDate,
	);
}

/** Lion round_no + round_date → powerball draw_results.drawn_at */
function drawnAtFromRoundInfo($roundNo, $roundDate)
{
	$roundNo = (int) $roundNo;
	if ($roundNo === 288) {
		$next = date('Y-m-d', strtotime($roundDate . ' +1 day'));
		return $next . ' 00:00:00';
	}
	$mins = $roundNo * 5;
	$h = (int) floor($mins / 60);
	$m = $mins % 60;
	return sprintf('%s %02d:%02d:00', $roundDate, $h, $m);
}

function drawRowToRoundResult($row, $roundDate, $roundNo)
{
	if ($row === null) {
		return null;
	}
	$times = isset($row['round']) ? (int) $row['round'] : 0;
	if ($times < 1) {
		return null;
	}
	return array(
		'date' => $roundDate,
		'date_round' => (int) $roundNo,
		'times' => $times,
		'round_hash' => $times,
		'ball' => array(
			(int) $row['ball1'],
			(int) $row['ball2'],
			(int) $row['ball3'],
			(int) $row['ball4'],
			(int) $row['ball5'],
			(int) $row['powerball'],
		),
	);
}

/**
 * 어제 1회차 ~ 기동 시점 직전 완료 회차까지 슬롯 목록
 * @return array<int, array{round_date:string,round_no:int}>
 */
function slotsFromYesterdayToNow()
{
	$end = getLastRoundInfo(ROUND_5MIN);
	$startDate = date('Y-m-d', strtotime('-1 day'));
	$endDate = $end['round_date'];
	$endNo = (int) $end['round_no'];

	$slots = array();
	$d = $startDate;
	while (true) {
		$maxNo = ($d === $endDate) ? $endNo : 288;
		for ($n = 1; $n <= $maxNo; $n++) {
			$slots[] = array('round_date' => $d, 'round_no' => $n);
		}
		if ($d === $endDate) {
			break;
		}
		$d = date('Y-m-d', strtotime($d . ' +1 day'));
		if ($d > $endDate) {
			break;
		}
	}
	return $slots;
}
