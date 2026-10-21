<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="ko">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?=$site_name?></title>
   
    <link rel="stylesheet" href="<?php echo base_url('assets/css/all.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css?v=1');?>">
    
    <script src="<?php echo base_url('assets/jslib/jquery-1.12.4.min.js'); ?>"></script>
    
    <script src="<?php echo base_url('assets/jslib/fontawesome.js'); ?>"></script>
  	
    <script src="<?php echo base_url('assets/js/common.js?v=1'); ?>"></script>
    
</head>

<body style="min-width:320px;">

<div class="main-container">
        <div class="main-container-wrap">
            <div class="main-content" >

                <div class="buy-contianer el-row">
                    <div class="buy-info el-col el-col-24">
                        <div class="issue-no el-row">
                            <input id="buy-info-game-id" value="<?=$game_id?>" hidden>
                            <i class="fas fa-chevron-left" id="buy-info-prev-id" style="cursor: pointer;"></i>
                            <span name="<?=$date_no?>" id="buy-info-round-id"><?=$round_id?></span> 회차
                            <i class="fas fa-chevron-right" id="buy-info-next-id" style="cursor: pointer;"></i>
                            
                        </div> 
                        <div class="lottery-result el-row" id="lottery-result-id" style="display:none;">
                            <button type="button" class="el-button result el-button--primary is-circle">
                                <span id="result-normal-sum-id"></span>
                            </button> 
                            <button type="button" class="el-button result el-button--primary is-circle">
                                <span id="result-normal-parity-id"></span>
                            </button> 
                            <button type="button" class="el-button result el-button--primary is-circle">
                                <span><i id="result-normal-arrow-id" class="fas fa-arrow-up"></i></span>
                            </button> 
                            <button type="button"  id="result-normal-size-id" class="el-button result is-circle" style="background: rgb(255, 193, 7); color:white; border:none;">
                                <span></span>
                            </button> 
                            <div class="el-image" style="height: 4vh; width: 12px; vertical-align: middle;">
                                <img src="/assets/image/pow.png" class="el-image__inner">
                            </div> 
                            <button type="button" class="el-button result el-button--danger is-circle">
                                <span id="result-power-parity-id"></span>
                            </button> 
                            <button type="button" class="el-button result el-button--danger is-circle">
                                <span><i id="result-power-arrow-id" class="fas fa-arrow-down"></i></span>
                            </button>
                        </div> 
                        <div class="buy-summary el-row">
                            <div class="el-col el-col-8">베팅결과</div> 
                            <div class="el-col el-col-8" id="buy-summary-bet-id">0</div>
                            <div class="el-col el-col-8" id="buy-summary-win-id">0</div>
                        </div> 
                        <div class="buy-detail el-row" id="buy-detail-id" style="height: 634px; display:block;" >
                            
                        </div>
                    </div> 

                </div>




            </div>
        </div>
    </div>



<script type="text/javascript" src="<?php echo base_url('assets/js/vieworder.js?v=3'); ?>"></script>


</body>

</html>