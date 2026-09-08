<?php

  	function is_login(){ 

      if(!isset($_SESSION['logged_in']))
        return false;
      else if($_SESSION['logged_in']==TRUE)
        return true;
      else return false;  	  	
  	}

    function is_Mobile(){
      $useragent=$_SERVER['HTTP_USER_AGENT'];
      if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
        return true;
      return false;
    }
    

    //사이드바의 선택상태 초기화 배렬을 반환해주는 함수
    function getSidebarArray(){

      return array(
               'menuitem_1' => '',
               'menuitem_2' => '',
               'menuitem_3' => '',
               'menuitem_4' => '',
               'menuitem_5' => '',
               'menuitem_6' => '',
               'menuitem_7' => '',
               'menuitem_8' => '',
               'menuitem_9' => '',
               'menuitem_10' => '',
               'menuitem_11' => '',
               'menuitem_12' => ''
          );

    }

    /**
     * PBG 일회차 번호·날짜 — reground_LT getLastRoundInfo(ROUND_5MIN) 과 동일.
     * 00:00~00:04 → 전일 288회차, 00:05~ → floor(당일0시~분/5) 는 1..287.
     */
    function pballRoundSlotFloorFromTime($tmNow) {
      date_default_timezone_set('Asia/Seoul');
      $nHour = date("G", $tmNow);
      $nMin = date("i", $tmNow);
      $nSumMinutes = (int) ($nHour * 60 + $nMin);
      $roundMin = 5;
      $nRoundMax = (int) floor(1440 / $roundMin);
      $nRoundNo = (int) floor($nSumMinutes / $roundMin);
      if ($nRoundNo == 0) {
        $nRoundNo = $nRoundMax;
        $strDate = date('Y-m-d', strtotime("-1 day", $tmNow));
      } else {
        $strDate = date('Y-m-d', $tmNow);
      }
      return array(
        'round_no' => $nRoundNo,
        'round_date' => $strDate,
        'nSumMinutes' => $nSumMinutes,
        'nRoundMax' => $nRoundMax
      );
    }

    /** 해당 일회차 슬롯의 마감 시각(당일 0시 기준 분) — 구 %288+1 체계의 round_no*5 와 동일 물리 시각 */
    function pballRoundEndMinutesFromMidnight($nRoundNo) {
      $nRoundNo = (int) $nRoundNo;
      $nEnd = ($nRoundNo + 1) * 5;
      return ($nEnd > 1440) ? 1440 : $nEnd;
    }

    //회차시작시간과 마감시간, 배팅초과시간 계산하는 함수-파워볼, 파워사다리
    function getPballRoundTimes($objConfPb){

      date_default_timezone_set('Asia/Seoul');
      //$tmNow = mktime('23','59','40','5','25','2021')+TM_OFFSET;
      $tmNow = time();
      // if($objConfPb->game_index == GAME_POWERBALL)
      //   $tmNow += TM_OFFSET;

      $slot = pballRoundSlotFloorFromTime($tmNow);
      $nRoundNo = $slot['round_no'];
      $strDate = $slot['round_date'];
      $arrRoundInfo['round_no'] = $nRoundNo;
      $arrRoundInfo['round_date'] = $strDate;

      $nSumMinutes = pballRoundEndMinutesFromMidnight($nRoundNo);
      $nHour = $nSumMinutes / 60;
      $nHour = floor($nHour);
      $nMinute = $nSumMinutes % 60;

      //현재시간설정      
      $tmRoundCurrent = date("Y-m-d H:i:s", $tmNow);        
      $arrRoundInfo['round_current'] = $tmRoundCurrent;

      //회차 마감시간설정
      $strRoundEnd = $strDate." ".$nHour.":".$nMinute.":"."0";
      $tmRoundEnd = strtotime($strRoundEnd);
      $arrRoundInfo['round_end'] = date("Y-m-d H:i:s", $tmRoundEnd);
      
      //회차 시작시간설정
      $tmRoundStart = strtotime("-5 minutes", $tmRoundEnd);
      $arrRoundInfo['round_start'] = date("Y-m-d H:i:s", $tmRoundStart);
      
      $tmBetEnd = 0;
      //베팅 마감시간설정
      if($objConfPb->game_bet_permit != 1){
        $tmBetEnd = $tmRoundStart;
      } else if($objConfPb->game_time_countdown >= 20 && $objConfPb->game_time_countdown <= 250 ) {
        //$objConfPb->game_time_countdown += 5;
        $tmBetEnd = strtotime("-".$objConfPb->game_time_countdown." seconds", $tmRoundEnd);      
      } else $tmBetEnd = strtotime("-1 minutes", $tmRoundEnd); 

      $arrRoundInfo['round_bet_end'] = date("Y-m-d H:i:s", $tmBetEnd);
      
      return $arrRoundInfo;
    }

    /**
     * PBG: 일회차·날짜·슬롯시각을 "DB에 저장된 최신 회차"의 다음 회차 기준으로 맞춘다.
     * (시간만 보고 만든 round_no가 파워볼 서버/누계 round_id보다 일회차만 1 작게 나오던 문제 대응)
     */
    function pballRoundTimesAfterLastRow($objLastRound, $objConfPb) {
      date_default_timezone_set('Asia/Seoul');
      $tmNow = time();

      $ln = (int) $objLastRound->round_num;
      $rd = $objLastRound->round_date;
      $nextNum = $ln + 1;
      $nextDate = $rd;
      if ($nextNum > 288) {
        $nextNum = 1;
        $nextDate = date('Y-m-d', strtotime($rd . ' +1 day'));
      }

      $arrRoundInfo['round_no'] = $nextNum;
      $arrRoundInfo['round_date'] = $nextDate;

      $nSumMinutes = pballRoundEndMinutesFromMidnight($nextNum);
      $nHour = $nSumMinutes / 60;
      $nHour = floor($nHour);
      $nMinute = $nSumMinutes % 60;

      $tmRoundCurrent = date('Y-m-d H:i:s', $tmNow);
      $arrRoundInfo['round_current'] = $tmRoundCurrent;

      $strRoundEnd = $nextDate . ' ' . $nHour . ':' . $nMinute . ':' . '0';
      $tmRoundEnd = strtotime($strRoundEnd);
      $arrRoundInfo['round_end'] = date('Y-m-d H:i:s', $tmRoundEnd);

      $tmRoundStart = strtotime('-5 minutes', $tmRoundEnd);
      $arrRoundInfo['round_start'] = date('Y-m-d H:i:s', $tmRoundStart);

      $tmBetEnd = 0;
      if ($objConfPb->game_bet_permit != 1) {
        $tmBetEnd = $tmRoundStart;
      } elseif ($objConfPb->game_time_countdown >= 20 && $objConfPb->game_time_countdown <= 250) {
        $tmBetEnd = strtotime('-' . $objConfPb->game_time_countdown . ' seconds', $tmRoundEnd);
      } else {
        $tmBetEnd = strtotime('-1 minutes', $tmRoundEnd);
      }
      $arrRoundInfo['round_bet_end'] = date('Y-m-d H:i:s', $tmBetEnd);

      return $arrRoundInfo;
    }

    /**
     * round_no/round_date/round_id는 DB 연동 값을 유지하고,
     * 카운트다운(betcloserest)용 시각만 현재 시각 기준 5분 슬롯(getPballRoundTimes)으로 맞춘다.
     */
    function pballMergeSlotTimesFromClock(&$arrRoundData, $objConfPb) {
      $slot = getPballRoundTimes($objConfPb);
      $arrRoundData['round_current'] = $slot['round_current'];
      $arrRoundData['round_start'] = $slot['round_start'];
      $arrRoundData['round_end'] = $slot['round_end'];
      $arrRoundData['round_bet_end'] = $slot['round_bet_end'];
    }

    /**
     * 파워볼(PBG) 서버 base URL.
     * 우선순위: .env POWERBALL_BASE_URL → DB conf_site(PBG site) → 빈 문자열.
     */
    function powerball_base_url(){

      $env = getenv('POWERBALL_BASE_URL');
      if($env !== FALSE && trim($env) !== ''){
        return rtrim(trim($env), '/');
      }

      $CI =& get_instance();
      if(isset($CI->db)){
        $CI->load->model('confsite_model');
        $info = $CI->confsite_model->getPbgInfo();
        if(isset($info['site']) && trim($info['site']) !== ''){
          return rtrim(trim($info['site']), '/');
        }
      }

      return '';
    }

    /**
     * pbg draw_results.drawn_at 와 동일: KST 기준 Unix 시각이 속한 5분 슬롯 시작 문자열.
     * (PowerballDraw_Model::kstDrawnAtFromUnixTimestamp 와 동일 규칙)
     */
    function pballKstDrawnAtSlotFromUnix($unixTs){

      $unixTs = (int) $unixTs;
      $tz     = new DateTimeZone('Asia/Seoul');
      $dt     = new DateTime('@' . $unixTs);
      $dt->setTimezone($tz);
      $totalMins = (int) $dt->format('H') * 60 + (int) $dt->format('i');
      $slotMins  = (int) floor($totalMins / 5) * 5;
      $dt->setTime((int) floor($slotMins / 60), $slotMins % 60, 0);

      return $dt->format('Y-m-d H:i:s');
    }

    

    //회차번호로부터 회차시작시간과 마감시간, 배팅초과시간 계산하는 함수-파워볼, 파워사다리
    function getPballRoundInfo($gameId){

      date_default_timezone_set('Asia/Seoul');
      //$tmNow = mktime('23','58','10','5','25','2021');
      $tmNow = time();
      // if($gameId == GAME_POWERBALL)
      //   $tmNow += TM_OFFSET;

      $slot = pballRoundSlotFloorFromTime($tmNow);
      $nRoundNo = $slot['round_no'];
      $strDate = $slot['round_date'];
      $arrRoundInfo['round_no'] = $nRoundNo;
      $arrRoundInfo['round_date'] = $strDate;

      $nSumMinutes = pballRoundEndMinutesFromMidnight($nRoundNo);
      $nHour = $nSumMinutes / 60;
      $nHour = floor($nHour);
      $nMinute = $nSumMinutes % 60;

      //현재시간설정      
      $tmRoundCurrent = date("Y-m-d H:i:s", $tmNow);        
      $arrRoundInfo['round_current'] = $tmRoundCurrent;

      //회차 마감시간설정
      $strRoundEnd = $strDate." ".$nHour.":".$nMinute.":"."0";
      $tmRoundEnd = strtotime($strRoundEnd);
      $arrRoundInfo['round_end'] = date("Y-m-d H:i:s", $tmRoundEnd);
      
      //회차 시작시간설정
      $tmRoundStart = strtotime("-5 minutes", $tmRoundEnd);
      $arrRoundInfo['round_start'] = date("Y-m-d H:i:s", $tmRoundStart);
      
      return $arrRoundInfo;
    }
    
    function getPbLastRoundInfo(){

      $tmNow = time()+TM_OFFSET;
      $slot = pballRoundSlotFloorFromTime($tmNow);
      $nRoundNo = $slot['round_no'] - 1;
      if ($nRoundNo == 0) {
        $nRoundNo = $slot['nRoundMax'];
        $strDate = date('Y-m-d', strtotime("-1 day", $tmNow));
      } else {
        $strDate = $slot['round_date'];
      }

      $arrRoundInfo['round_no'] = $nRoundNo;
      $arrRoundInfo['round_date'] = $strDate;


      return $arrRoundInfo;
    }
    
    //회차번호로부터 배팅가능성 계산하는 함수
    function isEnablePbBet(&$arrBetData, $objUser, $objConfPb, $arrRoundData, $arrBetStatist){

      //0:오유 1:정상 2:유저베팅차단 3:전체베팅차단 4:최소금액오류 5:최대금액오류 6:보유머니 부족 7:회차오류 8:단폴한도 9:조합한도 10:회차한도
      if(is_null( $objConfPb)) return 0;
      if(is_null( $objUser)) return 0;

      if (!array_key_exists("roundno", $arrBetData)) return 0;

      //if(is_null($arrRoundData)) return 7;
      //if($objRoundInfo->round_fid != $arrBetData['roundid']) return 7;
      //if($objRoundInfo->round_num != $arrBetData['roundno']) return 7;

      //게임 베팅가능성
      if($objConfPb->game_bet_permit == 0) return 3;

      //유저 베팅 가능성
      if($objUser->mb_state_delete == 1 || $objUser->emp_state_active != 1) 
        return 2;
      
      //배팅요청정보 검사
      if($arrBetData['roundid'] < 1 ) return 0;
      if($arrBetData['mode'] < 1 || $arrBetData['mode'] > 48) return 0;
      if(strlen($arrBetData['name']) < 1) return 0;
      if($arrBetData['amount'] < 1) return 0;

      //금액 조건 검사
      $arrBetData['amount'] = (int)($arrBetData['amount']);
      if($arrBetData['amount'] > $objUser->mb_money)  return 6;
      if($arrBetData['amount'] < $objConfPb->game_min_bet_money)  return 4;
      //if($arrBetData['amount'] > $objConfPb->game_max_bet_money)  return 5;

      
      $tmRoundCurrent = strtotime($arrRoundData['round_current']);
      $tmRoundStart = strtotime($arrRoundData['round_start']);
      $tmRoundEnd = strtotime("+5 minutes", $tmRoundStart);
      //베팅 마감시간
      if($objConfPb->game_time_countdown >= 20)
      {
        $tmRoundBetEnd = strtotime("-".$objConfPb->game_time_countdown." seconds", $tmRoundEnd);      
      } else $tmRoundBetEnd = strtotime("-30 seconds", $tmRoundEnd);      
    
      //현재 회차가 배팅가능한 시간이 아니라면   
      if($tmRoundCurrent < $tmRoundStart || $tmRoundCurrent > $tmRoundBetEnd){
          return 0;        
      }

      $strRatio = "0";
      $nMode = (int)($arrBetData['mode']);
      $bMix = false;
      switch ($nMode) {
        case 1: $strRatio = $objConfPb->game_ratio_1; $arrBetData['target']="P"; break;
        case 2: $strRatio = $objConfPb->game_ratio_1; $arrBetData['target']="B"; break;
        case 3: $strRatio = $objConfPb->game_ratio_2; $arrBetData['target']="P"; break;
        case 4: $strRatio = $objConfPb->game_ratio_2; $arrBetData['target']="B"; break;
        case 5: $strRatio = $objConfPb->game_ratio_5; $arrBetData['target']="PP"; $bMix=true; break;
        case 6: $strRatio = $objConfPb->game_ratio_6; $arrBetData['target']="BP"; $bMix=true; break;
        case 7: $strRatio = $objConfPb->game_ratio_7; $arrBetData['target']="PB"; $bMix=true; break;
        case 8: $strRatio = $objConfPb->game_ratio_8; $arrBetData['target']="BB"; $bMix=true; break;
        case 9: $strRatio = $objConfPb->game_ratio_3; $arrBetData['target']="P"; break;
        case 10: $strRatio = $objConfPb->game_ratio_3; $arrBetData['target']="B"; break;
        case 11: $strRatio = $objConfPb->game_ratio_4; $arrBetData['target']="P"; break;
        case 12: $strRatio = $objConfPb->game_ratio_4; $arrBetData['target']="B"; break;
        case 13: $strRatio = $objConfPb->game_ratio_9; $arrBetData['target']="PP"; $bMix=true; break;
        case 14: $strRatio = $objConfPb->game_ratio_10; $arrBetData['target']="BP"; $bMix=true; break;
        case 15: $strRatio = $objConfPb->game_ratio_11; $arrBetData['target']="PB"; $bMix=true; break;
        case 16: $strRatio = $objConfPb->game_ratio_12; $arrBetData['target']="BB"; $bMix=true; break;
        case 17: $strRatio = $objConfPb->game_ratio_13; $arrBetData['target']="L"; break;
        case 18: $strRatio = $objConfPb->game_ratio_14; $arrBetData['target']="M"; break;
        case 19: $strRatio = $objConfPb->game_ratio_15; $arrBetData['target']="S"; break;
        case 20: $strRatio = $objConfPb->game_ratio_16; $arrBetData['target']="PL"; $bMix=true; break;
        case 21: $strRatio = $objConfPb->game_ratio_17; $arrBetData['target']="PM"; $bMix=true; break;
        case 22: $strRatio = $objConfPb->game_ratio_18; $arrBetData['target']="PS"; $bMix=true; break;
        case 23: $strRatio = $objConfPb->game_ratio_19; $arrBetData['target']="BL"; $bMix=true; break;
        case 24: $strRatio = $objConfPb->game_ratio_20; $arrBetData['target']="BM"; $bMix=true; break;
        case 25: $strRatio = $objConfPb->game_ratio_21; $arrBetData['target']="BS"; $bMix=true; break;
        case 30: 
        case 31:
        case 32:
        case 33:
        case 34:
        case 35:
        case 36:
        case 37:
        case 38:
        case 39: $strRatio = $objConfPb->game_ratio_23; $arrBetData['target'] = 'Q'; break;
        case 41:
        case 42:
        case 43:
        case 44:
        case 45:
        case 46:
        case 47: 
        case 48: $strRatio = $objConfPb->game_ratio_22; $arrBetData['target'] = 'PPP'; $bMix = true; break;
        default: break;
      }
      
      if($strRatio < 1)   return 0;
      $arrBetData['ratio'] = $strRatio;

      //단폴
      if(!$bMix && $objUser->mb_limit_single > 0){
          if( ($arrBetStatist[0] + $arrBetData['amount']) > $objUser->mb_limit_single )
              return 8;
      }
      //조합
      if($bMix && $objUser->mb_limit_mix > 0){
        if( ($arrBetStatist[1] + $arrBetData['amount']) > $objUser->mb_limit_mix )
            return 9;
      }
      //회차
      if($objUser->mb_limit_round > 0){
          if( ($arrBetStatist[2] + $arrBetData['amount']) > $objUser->mb_limit_round )
              return 10;
      }

      return 1;
    }


    /**
     * 파워볼: round_id(클라이언트 누적 회차) = DB에 저장된 최신 round_pball 행의 round_fid + 1.
     * (시간 슬롯과 round_num 차이로 round_id가 최신 회차와 같아지던 문제를 제거)
     */
    function calcRoundId($objLastRound, &$arrRoundData) {
      if (is_null($objLastRound) || ! isset($objLastRound->round_fid)) {
        return 0;
      }
      $arrRoundData['round_id'] = (int) $objLastRound->round_fid + 1;

      return 1;
    }


    function isNotValidSystemTm(){

      date_default_timezone_set('Asia/Seoul');
      
      $tmNow = time();
      
      $nHour = date("G",$tmNow);
      $nMin = date("i",$tmNow);

      $nMinSum = $nHour * 60 + $nMin;
      if($nMinSum >= 365)
        return true;
      return false;

    }
    
    function setChgRatio(&$arrBetData, $objConf){
      if(is_null($objConf))
        return false;
      $strRatio = "-1";
      $nMode = (int)($arrBetData['mode']);
      switch ($nMode) {
        case 1: $strRatio = $objConf->game_ratio_1; $arrBetData['mode'] = 2; $arrBetData['target'] = 'B'; break;
        case 2: $strRatio = $objConf->game_ratio_1; $arrBetData['mode'] = 1; $arrBetData['target'] = 'P'; break;
        case 3: $strRatio = $objConf->game_ratio_2; $arrBetData['mode'] = 4; $arrBetData['target'] = 'B'; break;
        case 4: $strRatio = $objConf->game_ratio_2; $arrBetData['mode'] = 3; $arrBetData['target'] = 'P'; break;
        
        case 9: $strRatio = $objConf->game_ratio_3; $arrBetData['mode'] = 10; $arrBetData['target'] = 'B'; break;
        case 10: $strRatio = $objConf->game_ratio_3; $arrBetData['mode'] = 9; $arrBetData['target'] = 'P'; break;
        case 11: $strRatio = $objConf->game_ratio_4; $arrBetData['mode'] = 12; $arrBetData['target'] = 'B'; break;
        case 12: $strRatio = $objConf->game_ratio_4; $arrBetData['mode'] = 11; $arrBetData['target'] = 'P'; break;
          
        default: break;
      }

      if(floatval($strRatio) < 0)   
        return false;
      $arrBetData['ratio'] = floatval($strRatio);
      return true;
    }

    function isEnableBetTime($arrRoundData){

      $tmCurrent = date("Y-m-d H:i:s", time()); 

      if($tmCurrent < $arrRoundData['round_start'] || $tmCurrent > $arrRoundData['round_bet_end']){
          return false;        
      }
      return true;
    }

    function writeLog($contenet){ 
    
      if(!LOG_WRITE)
          return;
  
      $tmNow = time() ;
      $nHour = date("G",$tmNow);
      $nMin = date("i",$tmNow);
      $nSec = date("s",$tmNow);
  
      $sDate = date( 'Y-m-d', $tmNow);
      $fLog = fopen(LOG_FILE.$sDate, "a") ;
  
      $tContent = "[".$nHour.":".$nMin.":".$nSec."] ".$contenet."\r\n";
  
      fputs($fLog, $tContent);
      fclose($fLog);
  }

  /**
   * PHP·MySQL 시간대 진단 (로컬 OS vs 서버·DB 불일치 확인용)
   * @param string $prefix 예: 'Api.pbcurrentgame '
   * @param object|null $ci CI_Controller — 전달 시 MySQL session/global TZ 및 NOW() 기록
   */
  function logTimezoneDiagnostic($prefix, $ci = null) {
      if (!LOG_WRITE) {
          return;
      }
      $phpTz = function_exists('date_default_timezone_get') ? date_default_timezone_get() : '';
      $phpNow = date('Y-m-d H:i:s');
      $phpIso = date('c');
      $msg = $prefix . 'tz_diag php_tz=' . $phpTz . ' php_now=' . $phpNow . ' php_iso=' . $phpIso;
      if ($ci !== null && isset($ci->db)) {
          $q = $ci->db->query("SELECT @@session.time_zone AS stz, @@global.time_zone AS gtz, NOW() AS mysql_now, UTC_TIMESTAMP() AS mysql_utc");
          if ($q && $q->num_rows() > 0) {
              $r = $q->row_array();
              $msg .= ' mysql_session_tz=' . (isset($r['stz']) ? $r['stz'] : '')
                  . ' mysql_global_tz=' . (isset($r['gtz']) ? $r['gtz'] : '')
                  . ' mysql_now=' . (isset($r['mysql_now']) ? $r['mysql_now'] : '')
                  . ' mysql_utc=' . (isset($r['mysql_utc']) ? $r['mysql_utc'] : '');
          } else {
              $msg .= ' mysql_tz_query=FAIL';
          }
      }
      writeLog($msg);
  }

  /** 로그인 요청 JSON 파싱 실패 (비밀번호 미기록) */
  function logLoginInvalidPayload($endpointLabel, $jsonLen, $jsonErrorMsg) {
      if (!LOG_WRITE) {
          return;
      }
      writeLog($endpointLabel . " FAIL invalid_payload json_len=" . $jsonLen . " json_error=" . $jsonErrorMsg);
  }

  /**
   * member_model->login 이 null일 때: 아이디 없음 vs 비밀번호 불일치 구분 (비밀번호 값은 기록하지 않음)
   */
  function logLoginCredentialFailure($endpointLabel, $member_model, $uid, $pwdLen) {
      if (!LOG_WRITE) {
          return;
      }
      $row = $member_model->getInfoByUid($uid);
      if (is_null($row)) {
          writeLog($endpointLabel . " FAIL auth uid=" . $uid . " pwd_len=" . $pwdLen . " reason=no_user");
      } else {
          writeLog($endpointLabel . " FAIL auth uid=" . $uid . " pwd_len=" . $pwdLen . " reason=password_not_match mb_level=" . $row->mb_level . " mb_state_delete=" . $row->mb_state_delete);
      }
  }

if (!function_exists('writeReceiptPrintDebugLog')) {
	/**
	 * 영수증·BIXOLON WebDriver 연동 디버그 (한 줄 = JSON 1건).
	 * @param string $emp_uid
	 * @param string $ip
	 * @param array  $entry 클라이언트가 보낸 phase·payload·응답 등
	 */
	function writeReceiptPrintDebugLog($emp_uid, $ip, array $entry) {
		if (!defined('RECEIPT_PRINT_DEBUG_LOG') || !RECEIPT_PRINT_DEBUG_LOG) {
			return;
		}
		$row = array_merge(
			array(
				'server_ts' => date('Y-m-d H:i:s'),
				'emp_uid' => $emp_uid,
				'ip' => $ip,
			),
			$entry
		);
		$flags = JSON_UNESCAPED_UNICODE;
		if (defined('JSON_INVALID_UTF8_SUBSTITUTE')) {
			$flags |= JSON_INVALID_UTF8_SUBSTITUTE;
		}
		$json = json_encode($row, $flags);
		if ($json === false) {
			$json = '{"server_ts":"' . date('c') . '","json_encode":false}' . "\n";
		} else {
			$json .= "\n";
		}
		$sDate = date('Y-m-d');
		$path = APPPATH . 'logs/receipt_print_' . $sDate . '.log';
		@file_put_contents($path, $json, FILE_APPEND | LOCK_EX);
	}
}
?>
