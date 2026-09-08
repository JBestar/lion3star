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
  	
    
</head>

<body style="min-width:820px;">

    <div class="main-container">
        <div class="main-container-wrap">
            <div class="main-content" style="background-color:white;">

                <div class="el-row">
                    <?php
                    /** pbg 미니뷰: openMini=1 시 pbg 쪽에서 추첨 패널 펼침 · POWERBALL_BASE_URL 또는 DB site */
                    $pbgBase = powerball_base_url();
                    $pbgMiniSrc = ($pbgBase !== '') ? ($pbgBase . '/?view=powerballMiniView&openMini=1') : '';
                    ?>
                    <?php if ($pbgMiniSrc !== ''): ?>
                    <iframe id="lion-pbg-mini-iframe" src="<?= htmlspecialchars($pbgMiniSrc, ENT_QUOTES, 'UTF-8') ?>" allowtransparency="true" frameborder="0" scrolling="no" style="width: 830px; height: 273px; border: 0; vertical-align: top;">
                    </iframe>
                    <?php else: ?>
                    <div style="width:830px;height:273px;display:flex;align-items:center;justify-content:center;background:#111;color:#f66;font-size:14px;box-sizing:border-box;padding:20px;text-align:center;">
                        파워볼 서버 URL이 없습니다.<br>.env POWERBALL_BASE_URL 또는 PBG등록설정의 요청사이트를 설정하세요.
                    </div>
                    <?php endif; ?>
                    <div class="el-table el-table--fit el-table--enable-row-hover el-table--enable-row-transition el-table--mini" style="width: 830px; height: 55vh;">
                        
                        <div class="el-table__body-wrapper is-scrolling-none" style="height: 459px;">
                            <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 830px;">
                                <colgroup>
                                    <col name="el-table_1_column_1" width="80"><col name="el-table_1_column_2" width="150">
                                    <col name="el-table_1_column_3" width="60"><col name="el-table_1_column_4" width="100">
                                    <col name="el-table_1_column_5" width="80"><col name="el-table_1_column_6" width="80">
                                    <col name="el-table_1_column_7" width="80"><col name="el-table_1_column_8" width="80">
                                </colgroup>
                                <thead class="has-gutter">
                                    <tr class="">
                                        <th colspan="1" rowspan="1" class="el-table_1_column_1     is-leaf">
                                            <div class="cell">회차</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_1_column_2     is-leaf">
                                            <div class="cell">시간</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_1_column_4     is-leaf">
                                            <div class="cell">합</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_1_column_5     is-leaf">
                                            <div class="cell">대중소</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_1_column_6     is-leaf">
                                            <div class="cell">홀짝</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_1_column_7     is-leaf">
                                            <div class="cell">언더/오버</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_1_column_8     is-leaf">
                                            <div class="cell">파 홀짝</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_1_column_8     is-leaf">
                                            <div class="cell">파 언더/오버</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="el-table-data-id">
                                    <!--
                                    <tr class="el-table__row">
                                        <td>
                                            <div class="cell">1063364</div>
                                        </td>
                                        <td>
                                            <div class="cell"><span> 16:53:00</span></div>
                                        </td>
                                        <td>
                                            <div class="cell">19,4,17,14,8</div>
                                        </td>
                                        <td>
                                            <div class="cell">62</div>
                                        </td>
                                        <td>
                                            <div class="cell">소(15-64)</div>
                                        </td>
                                        <td>
                                            <div class="cell"><span>짝</span></div>
                                        </td>
                                        <td>
                                            <div class="cell"><span>언더</span></div>
                                        </td>
                                        <td>
                                            <div class="cell">3</div>
                                        </td>
                                    </tr>
                                    -->
                                </tbody>
                            </table>
                        </div>
                        <div class="el-table__column-resize-proxy" style="display: none;"></div>
                    </div>

                </div>





            </div>
        </div>
    </div>



<script type="text/javascript" src="<?php echo base_url('assets/js/powerball.js?v=7'); ?>"></script>


</body>

</html>