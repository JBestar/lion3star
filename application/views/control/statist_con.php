
<main class="el-main">
    <div class="el-row" inline="">
        <div class="star-page-toolbar">
            <div class="el-date-editor el-range-editor el-input__inner el-date-editor--daterange">
                <i class="el-input__icon el-range__icon fa fa-calendar-alt"></i>
                <input type="text" id="el-main-range-id" class="el-range-input" name="daterange" value="" >  
                <i class="el-input__icon el-range__close-icon" id="el-main-range__close-id"></i>  
            </div> 
            <button type="button" onclick="requestBetStatist();" class="el-button el-button--primary star-icon-btn" title="검색">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <div class="el-divider el-divider--horizontal"></div> 
        <div class="el-table star-page-table el-table--fit el-table--striped el-table--scrollable-x el-table--scrollable-y el-table--enable-row-hover el-table--enable-row-transition el-table--small">
            <!--
            <div class="hidden-columns">
                <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div>
            </div>
            <div class="el-table__header-wrapper">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 100%;">
                    <colgroup>
                        <col name="el-table_19_column_130" width="176"><col name="el-table_19_column_131" width="175">
                        <col name="el-table_19_column_132" width="175"><col name="el-table_19_column_133" width="175">
                        <col name="el-table_19_column_134" width="175"><col name="el-table_19_column_135" width="175">
                        <col name="el-table_19_column_136" width="175"><col name="gutter" width="0">
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_19_column_130     is-leaf">
                                <div class="cell">아이디</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_19_column_131     is-leaf">
                                <div class="cell">구매금액</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_19_column_132     is-leaf">
                                <div class="cell">적중금액</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_19_column_133     is-leaf">
                                <div class="cell">차익</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_19_column_134     is-leaf">
                                <div class="cell">적중회차</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_19_column_135     is-leaf">
                                <div class="cell">포인트</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_19_column_136     is-leaf">
                                <div class="cell">총판포인트</div>
                            </th>
                            <th class="gutter" style="width: 0px; display: none;"></th>
                        </tr>
                    </thead>
                </table>
            </div>
            -->
            <div class="el-table__body-wrapper is-scrolling-none">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 100%;">
                    <colgroup>
                        <col name="el-table_19_column_130" width="176"><col name="el-table_19_column_131" width="175">
                        <col name="el-table_19_column_132" width="175"><col name="el-table_19_column_133" width="175">
                        <col name="el-table_19_column_134" width="175"><col name="el-table_19_column_135" width="175">
                        <col name="el-table_19_column_136" width="175">
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_19_column_130     is-leaf">
                                <div class="cell">아이디</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_19_column_131     is-leaf">
                                <div class="cell">구매금액</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_19_column_132     is-leaf">
                                <div class="cell">적중금액</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_19_column_133     is-leaf">
                                <div class="cell">차익</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_19_column_134     is-leaf">
                                <div class="cell">적중회차</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_19_column_135     is-leaf">
                                <div class="cell">포인트</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_19_column_136     is-leaf">
                                <div class="cell">총판포인트</div>
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody id="el-main-data-id">
                        <!--
                        <tr class="el-table__row">
                            <td rowspan="1" colspan="1" class="el-table_19_column_130  ">
                                <div class="cell">test7</div>
                            </td>
                            <td rowspan="1" colspan="1" class="el-table_19_column_131  ">
                                <div class="cell">10000</div>
                            </td>
                            <td rowspan="1" colspan="1" class="el-table_19_column_132  ">
                                <div class="cell">0</div>
                            </td>
                            <td rowspan="1" colspan="1" class="el-table_19_column_133  ">
                                <div class="cell">10000</div>
                            </td>
                            <td rowspan="1" colspan="1" class="el-table_19_column_134  ">
                                <div class="cell">0</div>
                            </td>
                            <td rowspan="1" colspan="1" class="el-table_19_column_135  ">
                                <div class="cell">330</div>
                            </td>
                            <td rowspan="1" colspan="1" class="el-table_19_column_136  ">
                                <div class="cell">20</div>
                            </td>
                        </tr>
                        <tr class="el-table__row">
                            <td rowspan="1" colspan="1" class="el-table_19_column_130  ">
                                <div class="cell">test9</div>
                            </td>
                            <td rowspan="1" colspan="1" class="el-table_19_column_131  ">
                                <div class="cell">100000</div>
                            </td>
                            <td rowspan="1" colspan="1" class="el-table_19_column_132  ">
                                <div class="cell">96500</div>
                            </td>
                            <td rowspan="1" colspan="1" class="el-table_19_column_133  ">
                                <div class="cell">3500</div>
                            </td>
                            <td rowspan="1" colspan="1" class="el-table_19_column_134  ">
                                <div class="cell">1</div>
                            </td>
                            <td rowspan="1" colspan="1" class="el-table_19_column_135  ">
                                <div class="cell">3300</div>
                            </td>
                            <td rowspan="1" colspan="1" class="el-table_19_column_136  ">
                                <div class="cell">200</div>
                            </td>
                        </tr>
                    -->
                    </tbody>
                </table>
                <div class="el-table__empty-block" id="el-main__empty-id" style="display:flex;">
                    <span class="el-table__empty-text">No Data</span>
                </div>

            </div>
            <div class="el-table__footer-wrapper" id="el-main-footer-id" style="display:none;">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__footer" style="width: 100%;">
                    <colgroup>
                        <col name="el-table_19_column_130" width="176"><col name="el-table_19_column_131" width="175">
                        <col name="el-table_19_column_132" width="175"><col name="el-table_19_column_133" width="175">
                        <col name="el-table_19_column_134" width="175"><col name="el-table_19_column_135" width="175">
                        <col name="el-table_19_column_136" width="175">
                    </colgroup>
                    <tbody class="has-gutter">

                        <tr>
                            <td colspan="1" rowspan="1" class="el-table_19_column_130 is-leaf">
                                <div class="cell">합계</div>
                            </td>
                            <td colspan="1" rowspan="1" class="el-table_19_column_131 is-leaf">
                                <div class="cell"  id="el-main-sum_1-id">110000</div>
                            </td>
                            <td colspan="1" rowspan="1" class="el-table_19_column_132 is-leaf" >
                                <div class="cell" id="el-main-sum_2-id">96500</div>
                            </td>
                            <td colspan="1" rowspan="1" class="el-table_19_column_133 is-leaf">
                                <div class="cell"  id="el-main-sum_3-id">13500</div>
                            </td>
                            <td colspan="1" rowspan="1" class="el-table_19_column_134 is-leaf">
                                <div class="cell"></div>
                            </td>
                            <td colspan="1" rowspan="1" class="el-table_19_column_135 is-leaf">
                                <div class="cell"></div>
                            </td>
                            <td colspan="1" rowspan="1" class="el-table_19_column_136 is-leaf">
                                <div class="cell"  id="el-main-sum_4-id">220</div>
                            </td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="el-table__column-resize-proxy" style="display: none;"></div>
        </div> 

        <!--================User Statistices Dialog================-->
        <div class="el-dialog__wrapper" id="el-dialog-history-id" name="" style="z-index: 2041; display:none;">
            <div role="dialog" aria-modal="true" aria-label="구매내역" class="el-dialog" style="margin-top: 5vh; width: 90%;">
                <div class="el-dialog__header">
                    <span class="el-dialog__title">구매내역</span>
                    <button type="button" aria-label="Close" class="el-dialog__headerbtn"  onclick="closeEmpBetDlg();">
                        <i class="el-dialog__close fas fa-times"></i>
                    </button>
                </div>
                <div class="el-dialog__body">
                    <div class="el-date-editor el-range-editor el-input__inner el-date-editor--daterange">
                        <i class="el-input__icon el-range__icon fa fa-calendar-alt"></i>
                        <input type="text" id="el-dialog-range-id" class="el-range-input" name="daterange" value="" >  
                        <i class="el-input__icon el-range__close-icon" id="el-dialog-range__close-id"></i>  
                    </div> 
                    <button type="button" class="el-button el-button--primary star-icon-btn" title="검색" onclick="requestBetHistory();">
                        <i class="fas fa-search"></i>
                    </button> 
                    <div class="el-divider el-divider--horizontal"></div> 
                    <div class="el-table el-table--fit el-table--enable-row-hover el-table--enable-row-transition el-table--small" style="/*height: 50vh;*/">
                        <!--    
                        <div class="hidden-columns">
                            <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> 
                            <div></div> <div></div> <div></div>
                        </div>
                        <div class="el-table__header-wrapper">
                            <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 100%;">
                                <colgroup>
                                    <col name="el-table_20_column_137" width="153"><col name="el-table_20_column_138" width="148">
                                    <col name="el-table_20_column_139" width="148"><col name="el-table_20_column_140" width="148">
                                    <col name="el-table_20_column_141" width="148"><col name="el-table_20_column_142" width="108">
                                    <col name="el-table_20_column_143" width="108"><col name="el-table_20_column_144" width="148">
                                    <col name="el-table_20_column_145" width="148"><col name="gutter" width="40">
                                </colgroup>
                                <thead class="has-gutter">
                                    <tr class="">
                                        <th colspan="1" rowspan="1" class="el-table_20_column_137     is-leaf">
                                            <div class="cell">회차</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_138     is-leaf">
                                            <div class="cell">아이디</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_139     is-leaf">
                                            <div class="cell">구매자명</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_140     is-leaf">
                                            <div class="cell">배팅내역</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_141     is-leaf">
                                            <div class="cell">구매금액</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_142     is-leaf">
                                            <div class="cell">적중금액</div>
                                        </th><th colspan="1" rowspan="1" class="el-table_20_column_143     is-leaf">
                                            <div class="cell">포인트</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_144     is-leaf">
                                            <div class="cell">보유금액</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_145     is-leaf">
                                            <div class="cell">구매시간</div>
                                        </th>
                                        <th style="width:40px; display: block;"> </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        -->
                        <div class="el-table__body-wrapper is-scrolling-none" style="height: 55vh; overflow:auto; ">
                            <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 100%;">
                                <colgroup>
                                    <col name="el-table_20_column_137" width="60">
                                    <col name="el-table_20_column_137" width="103"><col name="el-table_20_column_138" width="98">
                                    <col name="el-table_20_column_139" width="128"><col name="el-table_20_column_140" width="148">
                                    <col name="el-table_20_column_141" width="128"><col name="el-table_20_column_145" width="148">
                                    <col name="el-table_20_column_142" width="108"><col name="el-table_20_column_143" width="108">
                                    <col name="el-table_20_column_144" width="128">                                    
                                </colgroup>
                                <thead class="has-gutter">
                                    <tr class="">
                                        <th colspan="1" rowspan="1" class="el-table_20_column_136     is-leaf">
                                            <div class="cell">게임</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_137     is-leaf">
                                            <div class="cell">회차</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_138     is-leaf">
                                            <div class="cell">아이디</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_139     is-leaf">
                                            <div class="cell">구매자명</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_140     is-leaf">
                                            <div class="cell">배팅내역</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_141     is-leaf">
                                            <div class="cell">구매금액</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_144     is-leaf">
                                            <div class="cell">구매후금액</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_142     is-leaf">
                                            <div class="cell">적중금액</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_143     is-leaf">
                                            <div class="cell">포인트</div>
                                        </th>
                                        <th colspan="1" rowspan="1" class="el-table_20_column_145     is-leaf">
                                            <div class="cell">구매시간</div>
                                        </th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="el-dialog-data-id">
                                    <!--
                                    <tr class="el-table__row">
                                        <td>
                                            <div class="cell">1063034</div>
                                        </td>
                                        <td>
                                            <div class="cell">test7</div>
                                        </td>
                                        <td>
                                            <div class="cell">김사장</div>
                                        </td>
                                        <td>
                                            <div class="cell">파워볼홀</div>
                                        </td>
                                        <td>
                                            <div class="cell">10000</div>
                                        </td>
                                        <td>
                                            <div class="cell">0</div>
                                        </td>
                                        <td>
                                            <div class="cell">330</div>
                                        </td>
                                        <td>
                                            <div class="cell">10536500</div>
                                        </td>
                                        <td>
                                            <div class="cell">2021-02-08 13:21:08</div>
                                        </td>
                                    </tr>
                                    -->
                                </tbody>
                            </table>
                            <div class="el-table__empty-block" id="el-dialog__empty-id" style="display:flex;"><span class="el-table__empty-text">No Data</span></div>
                        </div>
                        <div class="el-table__column-resize-proxy" style="display: none;"></div>
                    </div> 
                </div>
                <div class="el-dialog__footer">
                    <span><button type="button" class="el-button el-button--primary"  onclick="closeEmpBetDlg();"><span>닫기</span></button></span>
                </div>
            </div>
        </div>
        
        
    </div>
</main>




<script src="<?php echo base_url('assets/js/control/statist-control.js?v=3'); ?>"></script>
