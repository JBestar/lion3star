<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$sub_active = (trim($menuitem_1) !== '' || trim($menuitem_12) !== '');
?><!DOCTYPE html>
<html lang="ko">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?=$site_name?></title>

    <link rel="stylesheet" href="<?php echo base_url('assets/css/all.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/admin-star.css?v=13');?>">

    <script src="<?php echo base_url('assets/jslib/jquery-1.12.4.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/jslib/jquery-ui-1.12.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/jslib/fontawesome.js'); ?>"></script>

    <script src="<?php echo base_url('assets/jslib/moment.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/jslib/daterangepicker.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/jslib/daterangepicker.css');?>">

    <script src="<?php echo base_url('assets/js/worker.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/common.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/admin/header-adm.js?v=6');?>"></script>

</head>

<body class="admin-star-body" style="min-width: 1220px;">

<div class="v-application app v-application--is-ltr theme--light admin-star-app">
    <div class="v-application--wrap admin-star-shell">

            <header class="admin-star-topbar">
                <div class="admin-star-brand">
                    <div class="el-image logo">
                        <img src="/assets/image/logo.png" class="el-image__inner" alt="Star">
                    </div>
                    <span class="admin-star-welcome"><span id="emp-name-id">Administrator</span>님, 환영합니다!</span>
                </div>

                <ul class="admin-star-nav">
                    <li class="admin-star-dropdown<?php echo $sub_active ? ' is-open' : ''; ?>">
                        <span class="admin-star-link<?php echo $sub_active ? ' is-active' : ''; ?>">하부관리</span>
                        <ul class="admin-star-submenu">
                            <li class="<?=$menuitem_1?>" onclick="clickMenu(1);">총판관리</li>
                            <li class="<?=$menuitem_12?>" onclick="clickMenu(13);">매장관리</li>
                        </ul>
                    </li>
                    <li class="admin-star-menu-item">
                        <span class="admin-star-link <?=$menuitem_2?>" onclick="clickMenu(2);">일별통계</span>
                    </li>
                    <li class="admin-star-menu-item">
                        <span class="admin-star-link <?=$menuitem_4?>" onclick="clickMenu(4);">충전신청</span>
                    </li>
                    <li class="admin-star-menu-item">
                        <span class="admin-star-link <?=$menuitem_5?>" onclick="clickMenu(5);">환전신청</span>
                    </li>
                    <li class="admin-star-menu-item">
                        <span class="admin-star-link <?=$menuitem_6?>" onclick="clickMenu(6);">충/환전내역</span>
                    </li>
                    <li class="admin-star-menu-item">
                        <span class="admin-star-link <?=$menuitem_7?>" onclick="clickMenu(7);">알림 및 공지<span class="star-menu-msg-badge" id="message-menu-badge" aria-hidden="true"></span></span>
                    </li>
                    <li class="admin-star-menu-item">
                        <span class="admin-star-link <?=$menuitem_8?>" onclick="clickMenu(8);">거래내역보기</span>
                    </li>
                    <li class="admin-star-menu-item">
                        <span class="admin-star-link" onclick="clickMenu(10);">로그아웃</span>
                    </li>
                    <?php /* 메뉴 숨김 — URL 직접 접근 유지: 회차별통계(3), 아이피추적(9), 블록관리(12), 구매변경(11) */ ?>
                </ul>

                <div class="admin-star-actions">
                    <button type="button" class="el-button el-button--danger el-button--mini btn-site-maintain" onclick="showMaintainDlg();">
                        <span><i class="fas fa-tools"></i> site 점검</span>
                    </button>
                    <button type="button" class="el-button el-button--primary el-button--mini btn-data-clean" onclick="showCleanDlg();">
                        <span><i class="fas fa-database"></i> 데이터정리</span>
                    </button>
                    <button type="button" class="el-button el-button--danger el-button--mini" onclick="cleanDb(1);" style="display:none;">
                        <span>디비초기화</span>
                    </button>
                </div>
            </header>

            <marquee class="marquee admin-star-marquee" id="message-marquee-id"></marquee>

            <div class="admin-star-main">

            <!-- Ctrl+Shift+F12: 회차별통계 암호 (동일 /capi/roundstatunlock) -->
            <div class="admin-rs-unlock-overlay" id="admin-rs-unlock-overlay" aria-hidden="true">
                <div class="admin-rs-unlock-dialog">
                    <div class="roundstat-lock-title">회차별 통계</div>
                    <p class="roundstat-lock-desc">비밀번호를 입력하세요.</p>
                    <input type="password" id="admin-rs-pwd-input" class="roundstat-lock-input el-input__inner" autocomplete="off" />
                    <div class="roundstat-lock-actions">
                        <button type="button" class="el-button el-button--primary" id="admin-rs-pwd-submit"><span>확인</span></button>
                        <button type="button" class="el-button el-button--default" id="admin-rs-pwd-cancel"><span>취소</span></button>
                    </div>
                    <div id="admin-rs-pwd-err" class="roundstat-pwd-err"></div>
                </div>
            </div>
