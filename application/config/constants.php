<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

defined('SITE_NAME')      	   OR define('SITE_NAME', "Star");

defined('MEMBER_ADMIN_LEVEL')      	OR define('MEMBER_ADMIN_LEVEL', 10);
defined('MEMBER_COMPANY_LEVEL')     OR define('MEMBER_COMPANY_LEVEL', 9);
defined('MEMBER_AGENCY_LEVEL')      OR define('MEMBER_AGENCY_LEVEL', 8);
defined('MEMBER_EMPLOYEE_LEVEL')    OR define('MEMBER_EMPLOYEE_LEVEL', 7);
defined('MEMBER_USER_LEVEL')    	OR define('MEMBER_USER_LEVEL', 1);

/** sess_list: 마지막 API 활동 후 이 시간(분) 경과 시 세션 만료 (추첨 간격 5분) */
defined('SESS_IDLE_TIMEOUT_MINUTES') OR define('SESS_IDLE_TIMEOUT_MINUTES', 5);
/** 클라이언트 heartbeat 주기(초) — 유휴 탭에서도 세션 유지 */
defined('SESS_HEARTBEAT_INTERVAL_SECONDS') OR define('SESS_HEARTBEAT_INTERVAL_SECONDS', 60);

defined('TM_OFFSET')    	        OR define('TM_OFFSET', 0);


defined('GAME_POWERBALL')        || define('GAME_POWERBALL', 0);   
defined('GAME_COIN_5')           || define('GAME_COIN_5', 1);
defined('GAME_EOS_5')           || define('GAME_EOS_5', 2);

//Site Config
defined('CONF_SITENAME')       || define('CONF_SITENAME', 1);
defined('CONF_MAINTAIN')       || define('CONF_MAINTAIN', 10);
defined('CONF_PBG_ACC')        || define('CONF_PBG_ACC', 14);
defined('CONF_ROUNDSTAT_PWD')  || define('CONF_ROUNDSTAT_PWD', 15);

//Money History
defined('MONEYCHANGE_PRESENT')   || define('MONEYCHANGE_PRESENT', 0); 
defined('MONEYCHANGE_CHARGE')    || define('MONEYCHANGE_CHARGE', 1);   
defined('MONEYCHANGE_EXCHANGE')  || define('MONEYCHANGE_EXCHANGE', 2);   
defined('POINTCHANGE_BET')       || define('POINTCHANGE_BET', 3);   

defined('MONEYCHANGE_BET')       || define('MONEYCHANGE_BET', 4);   
defined('MONEYCHANGE_CANCEL')    || define('MONEYCHANGE_CANCEL', 5);   
defined('MONEYCHANGE_WIN')       || define('MONEYCHANGE_WIN', 6);

defined('MONEYCHANGE_PRESENT_FROM')   || define('MONEYCHANGE_PRESENT_FROM', 10); 
defined('MONEYCHANGE_CHARGE_FROM')    || define('MONEYCHANGE_CHARGE_FROM', 11);   
defined('MONEYCHANGE_EXCHANGE_TO')    || define('MONEYCHANGE_EXCHANGE_TO', 12);   

//Json Result Status
defined('STATUS_SUCCESS')      || define('STATUS_SUCCESS', 'success');
defined('STATUS_FAIL')         || define('STATUS_FAIL', 'fail');
defined('STATUS_LOGOUT')       || define('STATUS_LOGOUT', 'logout');

//Bet Status
defined('BET_WAIT')              || define('BET_WAIT', 1);   
defined('BET_LOSS')              || define('BET_LOSS', 2);
defined('BET_WIN')               || define('BET_WIN', 3);
defined('BET_CANCEL')            || define('BET_CANCEL', 4);


defined('LOG_WRITE')            || define('LOG_WRITE', true);
defined('LOG_FILE')             || define('LOG_FILE', "logs/");
/** 영수증/BIXOLON 프린트 클라이언트 디버그 → application/logs/receipt_print_YYYY-MM-DD.log (Api::receiptprintlog) */
defined('RECEIPT_PRINT_DEBUG_LOG') || define('RECEIPT_PRINT_DEBUG_LOG', true);

defined('DUP_LOGIN')            || define('DUP_LOGIN', 3);
