
<main  class="el-main">
    <div  class="el-row">
        <div class="star-page-toolbar">
            <form class="el-form el-form--inline">
                <div class="el-form-item">
                    <label class="el-form-item__label">충전신청 아이디</label>
                    <div class="el-form-item__content">
                        <div class="el-select">
                            <div class="el-input el-input--suffix" onclick="toggleEmpSelect();">
                                <input type="text" readonly="readonly" id="el-form-uid-input-id" autocomplete="off" placeholder="Select" class="el-input__inner">
                                <span class="el-input__suffix">
                                    <span class="el-input__suffix-inner">
                                        <i class="el-select__caret el-input__icon fas fa-chevron-up" id="el-form-select-icon-id"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="el-form-item">
                    <label class="el-form-item__label">충전금액</label>
                    <div class="el-form-item__content">
                        <div class="el-input">
                            <input type="number" autocomplete="off" class="el-input__inner"  id="el-form-amount-input-id">
                        </div>
                    </div>
                </div>
                <button type="button" class="el-button el-button--primary" onclick="giveCharge();">
                    <span>확인</span>
                </button>
                <div class="el-form-item">
                    <div class="el-date-editor el-range-editor el-input__inner el-date-editor--daterange">
                        <i class="el-input__icon el-range__icon fa fa-calendar-alt"></i>
                        <input type="text" id="el-main-range-id" class="el-range-input" name="daterange" value="" >
                        <i class="el-input__icon el-range__close-icon" id="el-main-range__close-id"></i>
                    </div>
                    <button type="button" onclick="findCharge();" class="el-button el-button--primary star-icon-btn" title="검색">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="el-divider el-divider--horizontal"></div> 
        <div class="el-table star-page-table el-table--fit el-table--striped el-table--scrollable-x el-table--scrollable-y el-table--enable-row-hover el-table--enable-row-transition el-table--small">
            <!--
            <div class="hidden-columns">
                <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> 
                <div></div>
            </div>
            <div class="el-table__header-wrapper">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 1226px;">
                    <colgroup>
                        <col name="el-table_21_column_146" width="176"><col name="el-table_21_column_147" width="175">
                        <col name="el-table_21_column_148" width="175"><col name="el-table_21_column_149" width="175">
                        <col name="el-table_21_column_150" width="175"><col name="el-table_21_column_151" width="175">
                        <col name="el-table_21_column_152" width="175"><col name="gutter" width="0">
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_21_column_146     is-leaf">
                                <div class="cell">신청 아이디</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_21_column_147     is-leaf">
                                <div class="cell">신청금액</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_21_column_148     is-leaf">
                                <div class="cell">상태</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_21_column_149     is-leaf">
                                <div class="cell">충전유형</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_21_column_150     is-leaf">
                                <div class="cell">신청일자</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_21_column_151     is-leaf">
                                <div class="cell">처리일자</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_21_column_152     is-leaf">
                                <div class="cell"></div>
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
                        <col name="el-table_21_column_146" width="136"><col name="el-table_21_column_147" width="135">
                        <col name="el-table_21_column_148" width="135">
                        <col name="el-table_21_column_152" width="88">
                        <col name="el-table_21_column_149" width="165">
                        <col name="el-table_21_column_150" width="175">
                        <col name="el-table_21_column_151" width="175">
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_21_column_146     is-leaf">
                                <div class="cell">신청 아이디</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_21_column_147     is-leaf">
                                <div class="cell">신청금액</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_21_column_148     is-leaf">
                                <div class="cell">상태</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_21_column_152     is-leaf">
                                <div class="cell">확인</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_21_column_149     is-leaf">
                                <div class="cell">충전유형</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_21_column_150     is-leaf">
                                <div class="cell">신청일자</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_21_column_151     is-leaf">
                                <div class="cell">처리일자</div>
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody id="el-table-data-id" >
                        <!--
                        
                        <tr class="el-table__row">
                            <td rowspan="1" colspan="1" class="el-table_21_column_146  "><div class="cell">test7</div></td><td rowspan="1" colspan="1" class="el-table_21_column_147  "><div class="cell">1000</div></td><td rowspan="1" colspan="1" class="el-table_21_column_148  "><div class="cell"><span class="el-tag el-tag--warning el-tag--light">미확인</span></div></td><td rowspan="1" colspan="1" class="el-table_21_column_149  "><div class="cell"><span class="el-tag el-tag--light">신청충전</span></div></td><td rowspan="1" colspan="1" class="el-table_21_column_150  "><div class="cell">2021-02-08 02:55:02</div></td><td rowspan="1" colspan="1" class="el-table_21_column_151  "><div class="cell"></div></td><td rowspan="1" colspan="1" class="el-table_21_column_152  "><div class="cell"><button type="button" class="el-button el-button--primary el-button--small"><span>확인</span></button> <button type="button" class="el-button el-button--danger el-button--small"><span>취소</span></button></div></td>
                        </tr>
                        
                        <tr class="el-table__row">
                            <td rowspan="1" colspan="1" class="el-table_21_column_146  "><div class="cell">test7</div></td><td rowspan="1" colspan="1" class="el-table_21_column_147  "><div class="cell">10000</div></td><td rowspan="1" colspan="1" class="el-table_21_column_148  "><div class="cell"><span class="el-tag el-tag--danger el-tag--light">취소됨</span></div></td><td rowspan="1" colspan="1" class="el-table_21_column_149  "><div class="cell"><span class="el-tag el-tag--light">신청충전</span></div></td><td rowspan="1" colspan="1" class="el-table_21_column_150  "><div class="cell">2021-02-08 01:05:51</div></td><td rowspan="1" colspan="1" class="el-table_21_column_151  "><div class="cell">2021-02-08 01:07:04</div></td><td rowspan="1" colspan="1" class="el-table_21_column_152  "><div class="cell"> </div></td>
                        </tr>
                        -->
                    </tbody>
                </table>
                <div class="el-table__empty-block" id="el-table__empty-id" style="width: 100%; display:flex;">
                    <span class="el-table__empty-text">No Data</span>
                </div>
            </div>
            <div class="el-table__column-resize-proxy" style="display: none;"></div>
        </div>
    </div>


</main>



<script src="<?php echo base_url('assets/js/store/charge-control.js?v=4'); ?>"></script>

