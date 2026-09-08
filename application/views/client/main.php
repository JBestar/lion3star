<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="ko">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?=$site_name?></title>
   
    <link rel="stylesheet" href="<?php echo base_url('assets/css/all.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css?v=2');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/index_new.css?v=1');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/client-senior-bridge.css?v=23');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/default.css?v=1');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/layout.css?v=1');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/star-theme.css?v=5');?>">
    <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css?v=').time();?>"> -->
    
    <script src="<?php echo base_url('assets/jslib/jquery-1.12.4.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/jslib/jquery-ui-1.12.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/jslib/fontawesome.js'); ?>"></script>
  	
    <script src="<?php echo base_url('assets/jslib/moment.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/jslib/daterangepicker.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/jslib/daterangepicker.css');?>">
    <script type="text/javascript" src="<?php echo base_url('assets/js/common.js?v=1'); ?>"></script>
    
</head>

<body style="min-width: 1220px;">

    <div class="main-container">
        <div class="main-container-wrap">
            <div class="main-content">
                <div class="el-col el-col-24">
                    <marquee id="message-marquee-id" class="marquee"></marquee>
                    <!--Header-->
                    <div class="header el-row">
                        <div class="text-center el-col el-col-3">
                            <div class="el-image logo">
                                <img src="/assets/image/logo.png" class="el-image__inner">
                            </div>
                        </div>
                        <div class="text-center el-col el-col-21">
                            <ul class="el-menu--horizontal el-menu">
                                <li tabindex="1" class="el-menu-item" onclick="showBetHistoryDlg();">배팅내역</li> 
                                <li tabindex="2" class="el-menu-item" onclick="showRoundHistoryPage();">실시간배팅</li> 
                                <li tabindex="3" class="el-menu-item" onclick="showChargeDlg();">충전</li> 
                                <li tabindex="4" class="el-menu-item" onclick="showDischargeDlg();">환전</li> 
                                <li tabindex="5" class="el-menu-item" onclick="showMileageDlg();">포인트</li> 
                                <li tabindex="7" class="el-menu-item" onclick="showWinHistoryPage();">당첨내역</li> 
                                <li tabindex="9" class="el-menu-item" onclick="showMessageDlg();">공지사항</li> 
                                <li tabindex="11" class="el-menu-item" onclick="logout();">로그아웃</li>
                                <li tabindex="12" class="el-menu-item header-menu-item-end" onclick="downloadBixolonDriver();">발권기<i class="fas fa-download header-menu-download-icon" aria-hidden="true"></i></li>
                            </ul>
                            <div class="pt-1 el-row">
                                
                                <div class="el-col el-col-17">
                                    <div data-v-e74cd2d0="" class="pbg_info flex flex-wrap justify-center gap-1 lg:gap-5">
                                        <div data-v-e74cd2d0="" class="">
                                            <span id="hours">00</span><span class="pbg-clock-sep">:</span><span id="min">00</span><span class="pbg-clock-sep">:</span><span id="sec">00</span>
                                        </div>
                                        <div data-v-e74cd2d0="">
                                            진행회차 &nbsp;&nbsp;
                                            <span id="cur_round" class="text-yellow-300 font-bold">—</span>
                                            [<span style="font-size:18px;" id="betcloserest">00:00</span>]
                                        </div>
                                    </div>
                                </div> 
                                <div class="px-2 el-col el-col-7">
                                    <div class="bet-customer pt-2 header-user-summary-wrap">
                                        <span id="header-user-summary">-</span>
                                        <span id="bet-name-id" style="display:none;"></span>
                                        <span value="0" id="bet-card-id" style="display:none;"></span>
                                        <span value="0" id="bet-money-id" style="display:none;"></span>
                                    </div>
                                </div> 
                            </div>
                        </div>


                    </div>
                    <!--Bet Panel-->
                    <div class="content el-row" style="padding-bottom:20px;">
                        <div class="el-col el-col-24">
                    <div class="px-5 senior-bet-layout">
                            <div class="el-row ">
                                <div class="el-col el-col-10">
                                    <button class="game-button select" id="bet-pbg-id" onclick="selectGame(0);">PBG파워볼</button> 
                                    <a class="game-button" id="bet-eos5-id" href="https://lion7589.com" target="_blank" rel="noopener noreferrer" style="text-decoration:none;">카지노</a> 
                                    <button class="game-button" id="bet-coin5-id" onclick="alert('준비중입니다.');return false;">슬롯</button>
                                </div>
                                <div class="el-col el-col-6" style="text-align:center;">
                                    <img src="/assets/image/game_eos5.png" id="game-img-id" name="eos_5"  style=" height: 60px; width: 200px; margin-top:10px" >
                                </div>
                            </div>

                    <div class="flex flex-wrap gap-5 senior-bet-columns">
                    <aside class="senior-left md:block" style="width:530px;flex-shrink:0;">
                        <div class="mb-5">
                            <div class="sub_title relative">
                                <div class="pb-2 border_b">
                                    <font class="spanBoderWhite" color="red" id="senior-game-label">PBG파워볼</font>
                                    <span id="old_round">—</span>
                                </div>
                                <button type="button" class="btn btn_red absolute right-2 top-2 text-sm" onclick="javascript: openScreen();">결과보기</button>
                                <div class="mt-2 senior-result-row flex flex-wrap justify-center items-center gap-3">
                                    <div class="flex items-center gap-2 flex-wrap justify-center">
                                        <span class="senior-result-label">파워볼</span>
                                        <div data-v-d64cd776="" class="senior-old-result-wrap justify-center flex gap-1" id="old_result_p"></div>
                                    </div>
                                    <div class="flex items-center gap-2 flex-wrap justify-center">
                                        <span class="senior-result-label">일반볼</span>
                                        <div data-v-7f6779bf="" class="senior-old-result-wrap justify-center flex gap-1" id="old_result_n"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bet_list">
                            <div class="sub_title senior-bet-list-head relative">
                                배팅리스트
                                <div class="absolute right-2 top-2 flex">
                                    <button type="button" class="btn btn_red text-sm" onclick="showBetHistoryDlg();">베팅내역</button>
                                </div>
                                <div data-v-7d0e9f73="" class="bet_list_scroll">
                                    <table class="senior-bet-table-head" border="0" cellspacing="0" cellpadding="0" width="100%">
                                        <tbody>
                                        <tr>
                                            <td style="height:35px; background:#28303f; border-bottom:1px solid #515668; font-size:14px; text-align:center; width:18%">회차</td>
                                            <td style="height:35px; background:#28303f; border-bottom:1px solid #515668; font-size:14px; text-align:center; width:34%">선택</td>
                                            <td style="height:35px; background:#28303f; border-bottom:1px solid #515668; font-size:14px; text-align:center; width:18%">배팅금</td>
                                            <td style="height:35px; background:#28303f; border-bottom:1px solid #515668; font-size:14px; text-align:center; width:18%">당첨금</td>
                                            <td style="height:35px; background:#28303f; border-bottom:1px solid #515668; font-size:14px; text-align:left; width:12%">결과</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">
                                                <div class="gameScroll" style="height:530px;overflow:auto;font-size:12px;">
                                                    <table id="bet_list" border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
                                                        <tbody id="client-bet-list-tbody"></tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <div class="flex-1 min-w-0 senior-right relative">

                            <div id="betLockMain" style="z-index: 50; border-radius: 10px; position: absolute; width: 100%; height: 100%; background-color: rgb(0, 0, 0); opacity: 0.6; text-align: center; margin: 0px auto; display: none;"></div>
                            <div id="betLockText" style="z-index: 51; position: absolute; width: 100%; height: 100%; line-height: 750px; border: 0px; color: rgb(255, 255, 255); font-weight: bold; text-align: center; margin: 0px auto; font-size: 50px; display: none;"></div>

                            <?php include __DIR__ . '/partials/senior_betting_panel.php'; ?>

                    </div>
                    </div>
                    </div>
                        </div>

                    </div>
                    <!-- 회차·당회 배팅요약 DOM (main.js 동기화용, 화면 비표시) -->
                    <div style="display:none" aria-hidden="true">
                        <button type="button" id="buy-info-prev-id"></button>
                        <button type="button" id="buy-info-next-id"></button>
                        <span id="buy-info-round-id" name="0">0</span>
                        <div id="lottery-result-id">
                            <span id="result-normal-sum-id"></span>
                            <span id="result-normal-parity-id"></span>
                            <i id="result-normal-arrow-id"></i>
                            <button type="button" id="result-normal-size-id"><span></span></button>
                            <span id="result-power-parity-id"></span>
                            <i id="result-power-arrow-id"></i>
                        </div>
                        <span id="buy-summary-bet-id">0</span>
                        <span id="buy-summary-win-id">0</span>
                        <div id="buy-detail-id"></div>
                    </div>

                </div>

                



                <!--================Bet History Dialog================-->
                <div class="el-dialog__wrapper" id="el-dialog-bethistory-id" style="z-index: 2003; min-width:1380px; display: none; ">
                    <div class="el-dialog" style="margin-top: 5vh; width: 65%;">
                        <div class="el-dialog__header">
                            <span class="el-dialog__title">배팅내역</span>
                            <button type="button" id="el-dialog-bethistory-close-id" class="el-dialog__headerbtn">
                                <i class="el-dialog__close fas fa-times"></i>
                            </button>
                        </div>
                        <div class="el-dialog__body">
                            <div style="text-align: center;">
                                <div class="el-button-group">
                                    <button type="button" class="el-button el-button--primary">
                                        <span>롤링&nbsp;&nbsp;&nbsp;</span>
                                    </button> 
                                    <button type="button" class="el-button el-button--default">
                                        <span id="el-dialog-bethistory-ratio-id"></span>
                                    </button> 
                                </div>
                            </div> 
                            <div class="el-divider el-divider--horizontal"></div> 
                            <div class="el-row">
                                <form class="el-form">
                                    <div class="el-col el-col-4">
                                        <div class="el-form-item el-form-item--small">
                                            <label class="el-form-item__label" style="width: 50px;">게임</label>
                                            <div class="el-form-item__content" style="margin-left: 50px;">
                                                <div class="el-input el-input--small">
                                                    <select id="el-dialog-bethistory-game-id" class="el-input__inner">
                                                        <option value="-1" selected>전체</option>
                                                        <option value="0">PBG</option>
                                                        <option value="1">코인</option>
                                                        <option value="2">EOS</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="el-col el-col-4">
                                        <div class="el-form-item el-form-item--small">
                                            <label class="el-form-item__label" style="width: 60px;">회차</label>
                                            <div class="el-form-item__content" style="margin-left: 60px;">
                                                <div class="el-input el-input--small">
                                                    <input type="number" id="el-dialog-bethistory-round-id" autocomplete="off" class="el-input__inner">
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="el-col el-col-10">
                                        <div class="el-form-item el-form-item--small">
                                            <label class="el-form-item__label" style="margin-left: 10px; width: 80px;">배팅일자</label>
                                            <div class="el-form-item__content" style="margin-left: 80px;">
                                                <div class="el-date-editor el-range-editor el-input__inner el-date-editor--daterange el-range-editor--small" style="width:280px">
                                                    <i class="el-input__icon el-range__icon fa fa-calendar-alt"></i>
                                                    <input type="text" id="el-dialog-bethistory-range-id" class="el-range-input" name="daterange" value="" >  
                                                    <i class="el-input__icon el-range__close-icon" id="el-range__close-id"></i>  
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="el-col el-col-2">
                                        <button type="button" id="el-dialog-bethistory-search-id" class="el-button el-button--primary el-button--small" style="width:70px;">
                                            <span>검색</span>
                                        </button>
                                    </div>
                                </form>
                            </div> 
                            <div class="el-divider el-divider--horizontal"></div> 
                            <div class="el-table el-table--fit  el-table--scrollable-x el-table--scrollable-y el-table--enable-row-hover el-table--mini" style="/*height: 50vh;*/">
                                <!--
                                <div class="el-table__header-wrapper">
                                    <table cellspacing="0" cellpadding="0" class="el-table__header" style="100%">
                                        <colgroup>
                                            <col name="el-table_1_column_1" width="71">
                                            <col name="el-table_1_column_2" width="91">
                                            <col name="el-table_1_column_3" width="152">
                                            <col name="el-table_1_column_4" width="106">
                                            <col name="el-table_1_column_5" width="71">
                                            <col name="el-table_1_column_6" width="81">
                                            <col name="el-table_1_column_7" width="71">
                                            <col name="el-table_1_column_8" width="71">
                                            <col name="el-table_1_column_9" width="81">
                                            <col name="el-table_1_column_10" width="81">
                                            <col name="gutter" width="0">
                                        </colgroup>
                                        <thead class="has-gutter">
                                            <tr class="">
                                                <th colspan="1" rowspan="1" class="el-table_1_column_1     is-leaf">
                                                    <div class="cell">회차</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_2     is-leaf">
                                                    <div class="cell">배팅자</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_3     is-leaf">
                                                    <div class="cell">배팅시간</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_4     is-leaf">
                                                    <div class="cell">배팅내역</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_5     is-leaf">
                                                    <div class="cell">당첨결과</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_6     is-leaf">
                                                    <div class="cell">배팅금액</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_7     is-leaf">
                                                    <div class="cell">배당</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_8     is-leaf">
                                                    <div class="cell">포인트</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_9     is-leaf">
                                                    <div class="cell">적중금액</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_10     is-leaf">
                                                    <div class="cell">보유금액</div>
                                                </th>
                                                <th class="gutter" style="width: 0px; display: none;">
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                -->
                                <div class="el-table__body-wrapper el-table--scrollable-y" style="height: 53vh; overflow:auto;">
                                    <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width:100%;">
                                        
                                        <colgroup>
                                            <col name="el-table_1_column_1" width="51">
                                            <col name="el-table_1_column_1" width="71">
                                            <col name="el-table_1_column_2" width="91">
                                            <col name="el-table_1_column_3" width="142">
                                            <col name="el-table_1_column_4" width="106">
                                            <col name="el-table_1_column_5" width="71">
                                            <col name="el-table_1_column_6" width="81">
                                            <col name="el-table_1_column_7" width="81">
                                            <col name="el-table_1_column_9" width="71">
                                            <col name="el-table_1_column_9" width="71">
                                            <col name="el-table_1_column_10" width="81">
                                            
                                        </colgroup>
                                        <thead class="has-gutter" >
                                            <tr >
                                                <th colspan="1" rowspan="1" class="el-table_1_column_1     is-leaf">
                                                    <div class="cell">게임</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_1     is-leaf">
                                                    <div class="cell">회차</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_2     is-leaf">
                                                    <div class="cell">배팅자</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_3     is-leaf">
                                                    <div class="cell">배팅시간</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_4     is-leaf">
                                                    <div class="cell">배팅내역</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_5     is-leaf">
                                                    <div class="cell">당첨결과</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_6     is-leaf">
                                                    <div class="cell">배팅금액</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_10     is-leaf">
                                                    <div class="cell">배팅후금액</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_7     is-leaf">
                                                    <div class="cell">배당</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_8     is-leaf">
                                                    <div class="cell">포인트</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_1_column_9     is-leaf">
                                                    <div class="cell">적중금액</div>
                                                </th>
                                                
                                                <th class="gutter" style="width: 0px; display: none;">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="el-dialog-bethistory-data-id" >
                                            <!--
                                            <tr class="el-table__row">
                                                <td><div class="cell">1062609</div>
                                                </td>
                                                <td><div class="cell">이사장</div>
                                                </td>
                                                <td><div class="cell">2021-02-07 01:55:30</div>
                                                </td>
                                                <td><div class="cell">오버</div>
                                                </td>
                                                <td><div class="cell">미적중</div>
                                                </td>
                                                <td><div class="cell">10000</div>
                                                </td>
                                                <td><div class="cell">1.93</div>
                                                </td>
                                                <td><div class="cell">330</div>
                                                </td>
                                                <td><div class="cell">0</div>
                                                </td>
                                                <td><div class="cell"><span>10536500</span></div>
                                                </td>
                                            </tr>
                                            -->
                                        </tbody>
                                    </table>

                                    <div class="el-table__empty-block" id="el-dialog-bethistory-empty-id" style="display:flex;">
                                        <span class="el-table__empty-text">No Data</span>
                                    </div>

                                </div>
                                <div class="el-table__column-resize-proxy" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--================Charge Dialog================-->
                <div class="el-dialog__wrapper"  id="el-dialog-charge-id" style="z-index: 2005; display:none">
                    <div role="dialog" class="el-dialog" style="margin-top: 5vh; width: 60%;">
                        <div class="el-dialog__header">
                            <span class="el-dialog__title">충전신청</span>
                            <button type="button" id="el-dialog-charge-close-id" class="el-dialog__headerbtn">
                                <i class="el-dialog__close fas fa-times"></i>
                            </button>
                        </div>
                        <div class="el-dialog__body">
                            <form class="el-form">
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 100px;">충전신청금액</label>
                                    <div class="el-form-item__content" style="margin-left: 100px;">
                                        <div class="el-input el-input--small">
                                            <input type="number" id="el-dialog-charge-amount-id" autocomplete="off" class="el-input__inner">
                                        </div> 
                                        <div class="el-button-group">
                                            <button type="button" class="el-button el-button--default el-button--small" onclick="selectChargeAmount(100000);">
                                                <span>10만원</span>
                                            </button>
                                            <button type="button" class="el-button el-button--default el-button--small" onclick="selectChargeAmount(500000);">
                                                <span>50만원</span>
                                            </button> 
                                            <button type="button" class="el-button el-button--default el-button--small" onclick="selectChargeAmount(1000000);">
                                                <span>100만원</span>
                                            </button>
                                            <button type="button" class="el-button el-button--default el-button--small" onclick="selectChargeAmount(3000000);">
                                                <span>300만원</span>
                                            </button>
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 100px;">입금자명</label>
                                    <div class="el-form-item__content" style="margin-left: 100px;">
                                        <div class="el-input el-input--small">
                                            <input type="text" id="el-dialog-charge-name-id" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-row">
                                    <div class="el-col el-col-24" style="text-align: right;">
                                        <button type="button"  id="el-dialog-charge-perform-id" class="el-button el-button--primary">
                                            <span>충전신청</span>
                                        </button> 
                                        <button type="button"  id="el-dialog-charge-cancel-id" class="el-button el-button--danger">
                                            <span>취소</span>
                                        </button>
                                    </div>
                                </div>
                            </form> 
                            <div class="el-divider el-divider--horizontal"></div> 
                            <div class="el-divider el-divider--horizontal"></div> 
                            <div class="el-table el-table--fit el-table--scrollable-x el-table--scrollable-y el-table--enable-row-hover el-table--enable-row-transition el-table--small" style="/*height: 30vh;*/">
                                <!--
                                <div class="el-table__header-wrapper">
                                    <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 893px; overflow-x:auto;">
                                        <colgroup>
                                            <col name="el-table_2_column_11" width="24">
                                            <col name="el-table_2_column_12" width="24">
                                            <col name="el-table_2_column_13" width="24">
                                            <col name="el-table_2_column_14" width="24">
                                            
                                        </colgroup>
                                        
                                        <thead class="has-gutter">
                                            <tr class="">
                                                <th colspan="1" rowspan="1" class="el-table_2_column_11     is-leaf">
                                                    <div class="cell">충전금</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_2_column_12     is-leaf">
                                                    <div class="cell">상태</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_2_column_13     is-leaf">
                                                    <div class="cell">신청시간</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_2_column_14     is-leaf">
                                                    <div class="cell">처리일시</div>
                                                </th>
                                                
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                -->
                                <div class="el-table__body-wrapper is-scrolling-none" style="height: 45vh;">
                                    <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 100%;">
                                        <colgroup>
                                            <col name="el-table_2_column_11" width="24">
                                            <col name="el-table_2_column_12" width="24">
                                            <col name="el-table_2_column_13" width="24">
                                            <col name="el-table_2_column_14" width="24">
                                        </colgroup>
                                        <thead class="has-gutter">
                                            <tr >
                                                <th colspan="1" rowspan="1" class="el-table_2_column_11     is-leaf">
                                                    <div class="cell">충전금</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_2_column_12     is-leaf">
                                                    <div class="cell">상태</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_2_column_13     is-leaf">
                                                    <div class="cell">신청시간</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_2_column_14     is-leaf">
                                                    <div class="cell">처리일시</div>
                                                </th>                                                
                                            </tr>
                                        </thead>
                                        <tbody id="el-dialog-charge-data-id">
                                            <!--
                                            <tr class="el-table__row">
                                                <td><div class="cell">10000</div>
                                                </td>
                                                <td><div class="cell"><span class="el-tag el-tag--warning el-tag--light">미확인</span></div>
                                                </td>
                                                <td><div class="cell">2021-02-08 00:56:42</div>
                                                </td>
                                                <td><div class="cell"></div>
                                                </td>
                                            </tr>
                                            <tr class="el-table__row">
                                                <td><div class="cell">10000000</div>
                                                </td>
                                                <td><div class="cell">
                                                        <span class="el-tag el-tag--success el-tag--light">확인</span>
                                                    </div>
                                                </td>
                                                <td><div class="cell">2021-01-30 00:53:05</div>
                                                </td>
                                                <td><div class="cell">2021-01-30 00:53:05</div>
                                                </td>
                                            </tr>
                                            <tr class="el-table__row">
                                                <td><div class="cell">1000000</div>
                                                </td>
                                                <td><div class="cell">
                                                        <span class="el-tag el-tag--danger el-tag--light">취소됨</span>
                                                    </div>
                                                </td>
                                                <td><div class="cell">2021-01-15 15:16:42</div>
                                                </td>
                                                <td><div class="cell">2021-01-16 11:48:09</div>
                                                </td>
                                            </tr>
                                            -->
                                        </tbody>
                                    </table>
                                    <div class="el-table__empty-block" id="el-dialog-charge-empty-id" style="display:flex;">
                                        <span class="el-table__empty-text">No Data</span>
                                    </div>
                                </div>
                                
                                <!--
                                <div class="el-table__column-resize-proxy" style="display: none;"></div>
                                -->
                            </div>
                        </div>
                    </div>
                </div>

                <!--================Discharge Dialog================-->
                <div class="el-dialog__wrapper"  id="el-dialog-discharge-id" style="z-index: 2007; display:none">
                    <div class="el-dialog" style="margin-top: 5vh; width: 60%;">
                        <div class="el-dialog__header">
                            <span class="el-dialog__title">환전신청 </span>
                            <button type="button" id="el-dialog-discharge-close-id" class="el-dialog__headerbtn">
                                <i class="el-dialog__close fas fa-times"></i>
                            </button>
                        </div>
                        <div class="el-dialog__body">
                            <form class="el-form">
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 100px;">환전신청금액</label>
                                    <div class="el-form-item__content" style="margin-left: 100px;">
                                        <div class="el-input el-input--small">
                                            <input type="text"  id="el-dialog-discharge-amount-id"  autocomplete="off" class="el-input__inner">
                                        </div> 
                                        <div class="el-button-group">
                                            <button type="button" class="el-button el-button--default el-button--small" onclick="selectDischargeAmount(100000);">
                                                <span>10만원</span>
                                            </button>
                                            <button type="button" class="el-button el-button--default el-button--small" onclick="selectDischargeAmount(500000);">
                                                <span>50만원</span>
                                            </button> 
                                            <button type="button" class="el-button el-button--default el-button--small" onclick="selectDischargeAmount(1000000);">
                                                <span>100만원</span>
                                            </button>
                                            <button type="button" class="el-button el-button--default el-button--small" onclick="selectDischargeAmount(3000000);">
                                                <span>300만원</span>
                                            </button>
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 100px;">은행명</label>
                                    <div class="el-form-item__content" style="margin-left: 100px;">
                                        <div class="el-input el-input--small">
                                            <input type="text" id="el-dialog-discharge-bank-id" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 100px;">계좌번호</label>
                                    <div class="el-form-item__content" style="margin-left: 100px;">
                                        <div class="el-input el-input--small">
                                            <input type="text" id="el-dialog-discharge-number-id" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 100px;">예금주</label>
                                    <div class="el-form-item__content" style="margin-left: 100px;">
                                        <div class="el-input el-input--small">
                                            <input type="text" id="el-dialog-discharge-owner-id" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-row">
                                    <div class="el-col el-col-24" style="text-align: right;">
                                        <button type="button"  id="el-dialog-discharge-perform-id" class="el-button el-button--primary">
                                            <span>환전신청</span>
                                        </button> 
                                        <button type="button" id="el-dialog-discharge-cancel-id" class="el-button el-button--danger">
                                            <span>취소</span>
                                        </button>
                                    </div>
                                </div>
                            </form> 
                            <div class="el-divider el-divider--horizontal"></div> 
                            <div class="el-table el-table--fit el-table--border el-table--enable-row-hover el-table--small" style="/*height: 35vh;*/">
                                <!--
                                <div class="hidden-columns">
                                    <div></div> <div></div> <div></div>
                                </div>
                                <div class="el-table__header-wrapper">
                                    <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 882px;">
                                        <colgroup>
                                            <col name="el-table_3_column_15" width="294"><col name="el-table_3_column_16" width="294">
                                            <col name="el-table_3_column_17" width="294"><col name="gutter" width="0">
                                        </colgroup>
                                        <thead class="has-gutter">
                                            <tr class="">
                                                <th colspan="1" rowspan="1" class="el-table_3_column_15     is-leaf">
                                                    <div class="cell">환전금</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_3_column_16     is-leaf">
                                                    <div class="cell">신청시간</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_3_column_17     is-leaf">
                                                    <div class="cell">처리일시</div>
                                                </th>
                                                <th class="gutter" style="width: 0px; display: none;"></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                -->
                                <div class="el-table__body-wrapper is-scrolling-none" style="height: 40vh; overflow:auto;">
                                    <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 100%;">
                                        <colgroup>
                                            <col name="el-table_3_column_15" width="24">
                                            <col name="el-table_3_column_16" width="24">
                                            <col name="el-table_3_column_17" width="24">
                                            <col name="el-table_3_column_18" width="24">
                                        </colgroup>
                                        <thead class="has-gutter">
                                            <tr class="">
                                                <th colspan="1" rowspan="1" class="el-table_3_column_15     is-leaf">
                                                    <div class="cell">환전금</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_3_column_16     is-leaf">
                                                    <div class="cell">상태</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_3_column_17     is-leaf">
                                                    <div class="cell">신청시간</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_3_column_18     is-leaf">
                                                    <div class="cell">처리일시</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="el-dialog-discharge-data-id"></tbody>
                                    </table>
                                    <div class="el-table__empty-block"  id="el-dialog-discharge-empty-id" style="display:flex;">
                                        <span class="el-table__empty-text">No Data</span>
                                    </div>
                                </div>
                                <div class="el-table__column-resize-proxy" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--================Mileage Dialog================-->
                <div class="el-dialog__wrapper" id="el-dialog-mileage-id" style="z-index: 2013; display:none;">
                    <div role="dialog" class="el-dialog" style="margin-top: 5vh; width: 50%;">
                        <div class="el-dialog__header">
                            <span class="el-dialog__title">포인트신청</span>
                            <button type="button" id="el-dialog-mileage-close-id" class="el-dialog__headerbtn">
                                <i class="el-dialog__close fas fa-times"></i>
                            </button>
                        </div>
                        <div class="el-dialog__body">
                            <form class="el-form">
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 100px;">적립포인트</label>
                                    <div class="el-form-item__content" id="el-dialog-mileage-amount-id" style="margin-left: 100px;">
                                        
                                    </div>
                                </div> 
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 100px;">신청포인트</label>
                                    <div class="el-form-item__content" style="margin-left: 100px;">
                                        <div class="el-row" style="margin-left: -2.5px; margin-right: -2.5px;">
                                            <div class="el-col el-col-21" style="padding-left: 2.5px; padding-right: 2.5px;">
                                                <div class="el-input el-input--small">
                                                    <input type="number" id="el-dialog-mileage-input-id" autocomplete="off" class="el-input__inner">
                                                </div>
                                            </div> 
                                            <div class="el-col el-col-2" style="padding-left: 2.5px; padding-right: 2.5px;">
                                                <button type="button" class="el-button el-button--default el-button--small" onclick="selectMileageAmount();">
                                                    <span>전액</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-row" >
                                    <div class="el-col el-col-24" style="text-align: right; margin-top:10px;">
                                        <button type="button" id="el-dialog-mileage-perform-id" class="el-button el-button--primary">
                                            <span>신청완료</span>
                                        </button> 
                                        <button type="button" id="el-dialog-mileage-cancel-id" class="el-button el-button--danger">
                                            <span>취소</span>
                                        </button>
                                    </div>
                                </div>
                            </form> 
                            <div class="el-divider el-divider--horizontal"></div> 
                            <div class="el-table el-table--fit el-table--enable-row-hover el-table--small" style="/*height: 30vh;*/">
                                <!--
                                <div class="hidden-columns">
                                    <div></div> <div></div>
                                </div>
                                <div class="el-table__header-wrapper">
                                    <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 893px;">
                                        <colgroup>
                                            <col name="el-table_4_column_18" width="447"><col name="el-table_4_column_19" width="446">
                                            <col name="gutter" width="0">
                                        </colgroup>
                                        <thead class="has-gutter">
                                            <tr class="">
                                                <th colspan="1" rowspan="1" class="el-table_4_column_18     is-leaf">
                                                    <div class="cell">전환포인트</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_4_column_19     is-leaf">
                                                    <div class="cell">처리일시</div>
                                                </th>
                                                <th class="gutter" style="width: 0px; display: none;"></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                -->
                                <div class="el-table__body-wrapper is-scrolling-none" style="height: 50vh; overflow:auto;">
                                    <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 100%;">
                                        <colgroup>
                                            <col name="el-table_4_column_18" width="200">
                                            <col name="el-table_4_column_19" width="300">
                                        </colgroup>
                                        <thead class="has-gutter">
                                            <tr class="">
                                                <th colspan="1" rowspan="1" class="el-table_4_column_18     is-leaf">
                                                    <div class="cell">전환포인트</div>
                                                </th>
                                                <th colspan="1" rowspan="1" class="el-table_4_column_19     is-leaf">
                                                    <div class="cell">처리일시</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="el-dialog-mileage-data-id"></tbody>
                                    </table>
                                    <div class="el-table__empty-block" id="el-dialog-mileage-empty-id" style="display:flex;">
                                        <span class="el-table__empty-text">No Data</span>
                                    </div>
                                </div>
                                <div class="el-table__column-resize-proxy" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--================Nickname Dialog================-->
                <div class="el-dialog__wrapper"  id="el-dialog-nickname-id" style="z-index: 2015; display:none;">
                    <div class="el-dialog" style="margin-top: 5vh; width: 60%;">
                        <div class="el-dialog__header">
                            <span class="el-dialog__title">닉네임 변경</span>
                            <button type="button" id="el-dialog-nickname-close-id" class="el-dialog__headerbtn">
                                <i class="el-dialog__close fas fa-times"></i>
                            </button>
                        </div>
                        <div class="el-dialog__body">
                            <form class="el-form">
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 60px;">1번</label>
                                    <div class="el-form-item__content" style="margin-left: 60px;">
                                        <div class="el-input el-input--small">
                                            <input type="text" id="el-dialog-nickname-input-id1" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 60px;">2번</label>
                                    <div class="el-form-item__content" style="margin-left: 60px;">
                                        <div class="el-input el-input--small">
                                            <input type="text" id="el-dialog-nickname-input-id2" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 60px;">3번</label>
                                    <div class="el-form-item__content" style="margin-left: 60px;">
                                        <div class="el-input el-input--small">
                                            <input type="text" id="el-dialog-nickname-input-id3" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 60px;">4번</label>
                                    <div class="el-form-item__content" style="margin-left: 60px;">
                                        <div class="el-input el-input--small">
                                            <input type="text" id="el-dialog-nickname-input-id4" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 60px;">5번</label>
                                    <div class="el-form-item__content" style="margin-left: 60px;">
                                        <div class="el-input el-input--small">
                                            <input type="text" id="el-dialog-nickname-input-id5" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 60px;">6번</label>
                                    <div class="el-form-item__content" style="margin-left: 60px;">
                                        <div class="el-input el-input--small">
                                            <input type="text" id="el-dialog-nickname-input-id6" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 60px;">7번</label>
                                    <div class="el-form-item__content" style="margin-left: 60px;">
                                        <div class="el-input el-input--small">
                                            <input type="text" id="el-dialog-nickname-input-id7" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 60px;">8번</label>
                                    <div class="el-form-item__content" style="margin-left: 60px;">
                                        <div class="el-input el-input--small">
                                            <input type="text" id="el-dialog-nickname-input-id8" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 60px;">9번</label>
                                    <div class="el-form-item__content" style="margin-left: 60px;">
                                        <div class="el-input el-input--small">
                                            <input type="text" id="el-dialog-nickname-input-id9" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item el-form-item--small">
                                    <label class="el-form-item__label" style="width: 60px;">10번</label>
                                    <div class="el-form-item__content" style="margin-left: 60px;">
                                        <div class="el-input el-input--small">
                                            <input type="text" id="el-dialog-nickname-input-id10" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div>
                            </form> 
                            <div style="text-align: right;">
                                <button type="button" id="el-dialog-nickname-perform-id" class="el-button el-button--primary">
                                    <span>수정완료</span>
                                </button> 
                                <button type="button" id="el-dialog-nickname-cancel-id" class="el-button el-button--danger">
                                    <span>취소</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--================Message Dialog================-->
                <div class="el-dialog__wrapper" id="el-dialog-message-id" style="z-index: 2019; display:none;">
                    <div class="el-dialog" style="margin-top: 5vh; width: 60%;">
                        <div class="el-dialog__header">
                            <span class="el-dialog__title">메시지</span>
                            <button type="button" id="el-dialog-message-close-id" class="el-dialog__headerbtn">
                                <i class="el-dialog__close fas fa-times"></i>
                            </button>
                        </div>
                        <div class="el-dialog__body">
                            <div class="el-tabs el-tabs--top">
                                <div class="el-tabs__header is-top">
                                    <div class="el-tabs__nav-wrap is-top">
                                        <div class="el-tabs__nav-scroll">
                                            <div class="el-tabs__nav is-top" style="transform: translateX(0px);">
                                                <div class="el-tabs__active-bar is-top" style="width: 75px; transform: translateX(0px);"></div>
                                                <div index="1" class="el-tabs__item is-top is-active">받은 메시지</div>
                                                <div index="2" class="el-tabs__item is-top">보낸메시지 </div>
                                                <div index="3" class="el-tabs__item is-top">메시지발송 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="el-tabs__content">
                                    <div id="el-dialog-message-tab1-id" class="el-tab-pane" style="">
                                        <h6  id="el-dialog-message-empty1-id">No message</h6>
                                        <div id="el-dialog-message-recvtb-id" class="el-table el-table--fit el-table--enable-row-hover el-table--enable-row-transition el-table--small" style="display:none;">
                                            <div class="el-table__body-wrapper is-scrolling-none" style="height: 488px;">
                                                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 100%;">
                                                    <colgroup>
                                                        <col name="el-table_1_column_1" width="92">
                                                        <col name="el-table_1_column_2" width="90">
                                                        <col name="el-table_1_column_3" width="90">
                                                        <col name="el-table_1_column_4" width="90">
                                                        <col name="el-table_1_column_5" width="90">
                                                    </colgroup>
                                                    <thead class="has-gutter">
                                                        <tr class="">
                                                            <th colspan="1" rowspan="1" class="el-table_1_column_1     is-leaf">
                                                                <div class="cell">보낸이</div>
                                                            </th>
                                                            <th colspan="1" rowspan="1" class="el-table_1_column_2     is-leaf">
                                                                <div class="cell">발송일자</div>
                                                            </th>
                                                            <th colspan="1" rowspan="1" class="el-table_1_column_3     is-leaf">
                                                                <div class="cell">제목</div>
                                                            </th>
                                                            <th colspan="1" rowspan="1" class="el-table_1_column_4     is-leaf">
                                                                <div class="cell">내용</div>
                                                            </th>
                                                            <th colspan="1" rowspan="1" class="el-table_1_column_5     is-leaf">
                                                                <div class="cell"></div>
                                                            </th>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody id="el-dialog-message-recvdata-id" >
                                                        <tr class="el-table__row">
                                                            <td>
                                                                <div class="cell">test</div>
                                                            </td>
                                                            <td>
                                                                <div class="cell">2021-02-09 01:19:23</div>
                                                            </td>
                                                            <td>
                                                                <div class="cell">새메시지</div>
                                                            </td>
                                                            <td>
                                                                <div class="cell">메시지시험</div>
                                                            </td>
                                                            <td>
                                                                <div class="cell">
                                                                    <button index="0" type="button" class="el-button el-button--danger el-button--small">
                                                                        <span>삭 제</span>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="el-table__column-resize-proxy" style="display: none;"></div>
                                        </div>
                                    </div> 
                                    <div id="el-dialog-message-tab2-id"  class="el-tab-pane" style="display: none;">
                                        <h6 id="el-dialog-message-empty2-id">No message</h6>
                                        <div id="el-dialog-message-sendtb-id" class="el-table el-table--fit el-table--enable-row-hover el-table--enable-row-transition el-table--small" style="display:none;">
                                            <div class="el-table__body-wrapper is-scrolling-none" style="height: 488px;">
                                                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 100%;">
                                                    <colgroup>
                                                        <col name="el-table_2_column_6" width="147">
                                                        <col name="el-table_2_column_7" width="145">
                                                        <col name="el-table_2_column_8" width="145">
                                                        <col name="el-table_2_column_9" width="145">
                                                        <col name="el-table_2_column_10" width="145">
                                                    </colgroup>
                                                    <thead class="has-gutter">
                                                        <tr class="">
                                                            <th colspan="1" rowspan="1" class="el-table_2_column_6     is-leaf">
                                                                <div class="cell">받는이 </div>
                                                            </th>
                                                            <th colspan="1" rowspan="1" class="el-table_2_column_7     is-leaf">
                                                                <div class="cell">발송일자</div>
                                                            </th>
                                                            <th colspan="1" rowspan="1" class="el-table_2_column_8     is-leaf">
                                                                <div class="cell">제목</div>
                                                            </th>
                                                            <th colspan="1" rowspan="1" class="el-table_2_column_9     is-leaf">
                                                                <div class="cell">내용</div>
                                                            </th>
                                                            <th colspan="1" rowspan="1" class="el-table_2_column_10     is-leaf">
                                                                <div class="cell"></div>
                                                            </th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody id="el-dialog-message-senddata-id" >
                                                        <tr class="el-table__row">
                                                            <td>
                                                                <div class="cell">test</div>
                                                            </td>
                                                            <td>
                                                                <div class="cell">2021-02-09 09:29:26</div>
                                                            </td>
                                                            <td>
                                                                <div class="cell">메시지응답</div>
                                                            </td>
                                                            <td>
                                                                <div class="cell">메시지받음</div>
                                                            </td>
                                                            <td>
                                                                <div class="cell">
                                                                    <button index="0" type="button" class="el-button el-button--danger el-button--small">
                                                                        <span>삭 제</span>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                       
                                    </div> 
                                    <div id="el-dialog-message-tab3-id" class="el-tab-pane" style="display: none;">
                                        <form class="el-form">
                                            <div class="el-form-item">
                                                <label class="el-form-item__label" style="width: 100px;">제목</label>
                                                <div class="el-form-item__content" style="margin-left: 100px;">
                                                    <div class="el-input">
                                                        <input type="text" id="el-dialog-message-title-id" autocomplete="off" class="el-input__inner">
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="el-form-item">
                                                <label class="el-form-item__label" style="width: 100px;">내용</label>
                                                <div class="el-form-item__content" style="margin-left: 100px;">
                                                    <div class="el-textarea">
                                                        <textarea id="el-dialog-message-content-id" autocomplete="off" class="el-textarea__inner" style="min-height: 33px;"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </form> 
                                        <div style="text-align: right;">
                                            <button type="button" class="el-button el-button--primary" onclick="sendMessage();">
                                                <span>발송</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--================Info Dialog================-->
                <div class="el-dialog__wrapper" id="el-dialog-empinfo-id" style="z-index: 2021; display:none;">
                    <div class="el-dialog" style="margin-top: 5vh; width: 60%;">
                        <div class="el-dialog__header">
                            <span class="el-dialog__title">정보변경</span>
                            <button type="button" id="el-dialog-empinfo-close-id" class="el-dialog__headerbtn">
                                <i class="el-dialog__close fas fa-times"></i>
                            </button>
                        </div>
                        <div class="el-dialog__body">
                            <form class="el-form">
                                <div class="el-form-item">
                                    <label class="el-form-item__label" style="width: 140px;">기존 비밀번호</label>
                                    <div class="el-form-item__content" style="margin-left: 140px;">
                                        <div class="el-input">
                                            <input type="password" id="el-dialog-empinfo-pwd-id" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item">
                                    <label class="el-form-item__label" style="width: 140px;">새비밀번호</label>
                                    <div class="el-form-item__content" style="margin-left: 140px;">
                                        <div class="el-input">
                                            <input type="password" id="el-dialog-empinfo-newpwd-id1" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item">
                                    <label class="el-form-item__label" style="width: 140px;">새비밀번호 확인</label>
                                    <div class="el-form-item__content" style="margin-left: 140px;">
                                        <div class="el-input">
                                            <input type="password" id="el-dialog-empinfo-newpwd-id2" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div> 
                                <div class="el-form-item">
                                    <label class="el-form-item__label" style="width: 140px;">별명</label>
                                    <div class="el-form-item__content" style="margin-left: 140px;">
                                        <div class="el-input">
                                            <input type="text" id="el-dialog-empinfo-nickname-id" autocomplete="off" class="el-input__inner">
                                        </div>
                                    </div>
                                </div>
                                <div class="el-form-item" style="display:none;">
                                    <label class="el-form-item__label" style="width: 140px;">영수증발급</label>
                                    <div class="el-form-item__content" style="margin-left: 140px;">
                                        <div class="el-input">
                                            <input type="checkbox" style="zoom:1.5;" id="el-dialog-empinfo-print-id" autocomplete="off" >
                                        </div>
                                    </div>
                                </div>
                            </form> 
                        </div>
                        <div class="el-dialog__footer">
                            <span>
                                <button type="button" id="el-dialog-empinfo-ok-id" class="el-button el-button--primary">
                                    <span>확인</span>
                                </button> 
                                <button type="button" id="el-dialog-empinfo-cancel-id" class="el-button el-button--danger">
                                    <span>취소</span>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <!--================MessageBox================-->
                <div class="el-message-box__wrapper" id="el-message-box-id" style="z-index: 2033; display:none;">
                    <div class="el-message-box">
                        <div class="el-message-box__header">
                            <div class="el-message-box__title" id="el-message-title-id">
                                
                            </div>
                            <button type="button" id="el-message-close-id" class="el-message-box__headerbtn">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="el-message-box__content">
                            <div class="el-message-box__status el-icon-error">
                                <i id="el-message-type-id" class=" fas fa-times-circle "></i>
                            </div>
                            <div class="el-message-box__message">
                                <p id="el-message-text-id"></p>
                            </div>
                        </div>
                        <div class="el-message-box__btns">
                            <button type="button" id="el-message-ok-id" class="el-button el-button--default el-button--small el-button--primary ">
                                <span>OK</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!--================AlertBox================-->
                <div class="el-alert-box__wrapper" id="el-alert-box-id" style="z-index: 2034; display:none;">
                    <div class="el-alert-box">
                        <p>
                        <i id="el-alert-type-id" class=" fas fa-times-circle "></i>
                        <span id="el-alert-content-id"></span>
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!--
    <div id="el-pdf-print-id" style="position:fixed; z-index:-1000; ">
        <div class="el-pdf-content">
            <h1>◆파워볼영수증◆</h1>    
            <h2 id="el-pdf-time-id">   </h2>    
            <h2 id="el-pdf-round-id">  </h2>    
            <h2 id="el-pdf-num-id">    </h2>
            <h3 id="el-pdf-name-id">   </h3>
            <h2 id="el-pdf-mode-id">   </h2>
            <h2 id="el-pdf-ratio-id">  </h2>
            <h2 id="el-pdf-amount-id"> </h2>
            <h3 id="el-pdf-win-id">    </h3>
        </div>
    </div>
    -->

    <script type="text/javascript" src="<?php echo base_url('assets/jslib/jspdf.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/jslib/html2canvas.min.js'); ?>"></script>


    <script type="text/javascript" src="<?php echo base_url('assets/js/worker.js');?>"></script>

    <!-- <script type="text/javascript" src="<?php echo base_url('assets/js/main.js?v=4'); ?>"></script> -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/main.js?v=').time(); ?>"></script>

</body>

</html>