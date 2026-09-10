<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="ko">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?=$site_name?></title>

    <link rel="stylesheet" href="<?php echo base_url('assets/css/all.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/control.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/control-star.css?v=7');?>">

    <script src="<?php echo base_url('assets/jslib/jquery-1.12.4.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/jslib/jquery-ui-1.12.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/jslib/fontawesome.js'); ?>"></script>

    <script src="<?php echo base_url('assets/jslib/moment.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/jslib/daterangepicker.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/jslib/daterangepicker.css');?>">

    <script src="<?php echo base_url('assets/js/worker.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/common.js?v=1'); ?>"></script>
    <script src="<?php echo base_url('assets/js/control/header-control.js?v=8'); ?>"></script>

</head>

<body class="control-star-body" style="min-width: 1220px;">

<div class="v-application app v-application--is-ltr theme--light control-star-app">
    <div class="v-application--wrap control-star-shell">

            <header class="control-star-topbar">
                <div class="control-star-brand">
                    <div class="el-image logo">
                        <img src="/assets/image/logo.png" class="el-image__inner" alt="Star">
                    </div>
                    <span class="control-star-welcome"><span id="emp-name-id">—</span>님, 환영합니다!</span>
                </div>

                <ul class="control-star-nav">
                    <li class="control-star-menu-item">
                        <span class="control-star-link <?=$menuitem_1?>" onclick="clickMenu(1);">매장 관리</span>
                    </li>
                    <li class="control-star-menu-item">
                        <span class="control-star-link <?=$menuitem_2?>" onclick="clickMenu(2);">일별통계</span>
                    </li>
                    <li class="control-star-menu-item">
                        <span class="control-star-link <?=$menuitem_3?>" onclick="clickMenu(3);">충전신청</span>
                    </li>
                    <li class="control-star-menu-item">
                        <span class="control-star-link <?=$menuitem_4?>" onclick="clickMenu(4);">환전신청</span>
                    </li>
                    <li class="control-star-menu-item">
                        <span class="control-star-link <?=$menuitem_5?>" onclick="clickMenu(5);">충/환내역</span>
                    </li>
                    <li class="control-star-menu-item">
                        <span class="control-star-link <?=$menuitem_6?>" onclick="clickMenu(6);">본사 총/환 내역</span>
                    </li>
                    <li class="control-star-menu-item">
                        <span class="control-star-link <?=$menuitem_7?>" onclick="clickMenu(7);">알림 및 공지<span class="star-menu-msg-badge" id="message-menu-badge" aria-hidden="true"></span></span>
                    </li>
                    <li class="control-star-menu-item">
                        <span class="control-star-link <?=$menuitem_8?>" onclick="clickMenu(8);">구매취소내역</span>
                    </li>
                    <li class="control-star-menu-item">
                        <span class="control-star-link" onclick="clickMenu(9);">로그아웃</span>
                    </li>
                    <?php /* 메뉴 숨김 유지 가능: 카지노 외부링크 */ ?>
                </ul>

                <div class="control-star-meta">
                    <span>보유금 <span class="amount" id="emp-money-id">0</span></span>
                    <span>P: <span class="amount" id="emp-mileage-id">0</span></span>
                    <span>수수료 <span class="amount" id="emp-ratio-id">0</span></span>
                </div>
            </header>

            <marquee class="marquee control-star-marquee" id="message-marquee-id"></marquee>

            <div class="control-star-body-row">
                <aside class="control-star-aside">
                    <ul class="control-star-quick">
                        <li class="control-star-menu-item">
                            <span class="control-star-link" onclick="showChargeDlg();">충전 신청</span>
                        </li>
                        <li class="control-star-menu-item">
                            <span class="control-star-link" onclick="showDischargeDlg();">환전 신청</span>
                        </li>
                        <li class="control-star-menu-item">
                            <span class="control-star-link" onclick="showMileageDlg();">포인트 신청</span>
                        </li>
                    </ul>
                </aside>

                <div class="control-star-main">
