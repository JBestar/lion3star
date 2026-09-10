

<main class="el-main">
    <div class="el-row" >
        <div class="el-date-editor el-range-editor el-input__inner el-date-editor--daterange">
            <i class="el-input__icon el-range__icon fa fa-calendar-alt"></i>
            <input type="text" id="el-main-range-id" class="el-range-input" name="daterange" value="" >  
            <i class="el-input__icon el-range__close-icon" id="el-main-range__close-id"></i>  
        </div> 
        <button type="button" class="el-button el-button--primary star-icon-btn" title="검색" onclick="requestTransStatist();">
            <i class="fas fa-search"></i>
        </button> 
        <div class="el-divider el-divider--horizontal"></div> 
        <div class="el-table el-table--fit el-table--enable-row-hover el-table--enable-row-transition">
            <!--
            <div class="hidden-columns">
                <div></div> <div></div> <div></div> <div></div> <div></div> <div></div>
            </div>
            <div class="el-table__header-wrapper">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 1226px;">
                <colgroup>
                    <col name="el-table_29_column_195" width="206"><col name="el-table_29_column_196" width="204">
                    <col name="el-table_29_column_197" width="204"><col name="el-table_29_column_198" width="204">
                    <col name="el-table_29_column_199" width="204"><col name="el-table_29_column_200" width="204">
                    <col name="gutter" width="0">
                </colgroup>
                <thead class="has-gutter">
                    <tr class="">
                        <th colspan="1" rowspan="1" class="el-table_29_column_195     is-leaf">
                            <div class="cell">아이디</div>
                        </th>
                        <th colspan="1" rowspan="1" class="el-table_29_column_196     is-leaf">
                            <div class="cell">직충전금액</div>
                        </th>
                        <th colspan="1" rowspan="1" class="el-table_29_column_197     is-leaf">
                            <div class="cell">충전신청금액</div>
                        </th>
                        <th colspan="1" rowspan="1" class="el-table_29_column_198     is-leaf">
                            <div class="cell">환전신청금액</div>
                        </th>
                        <th colspan="1" rowspan="1" class="el-table_29_column_199     is-leaf">
                            <div class="cell">포인트 전환금액</div>
                        </th>
                        <th colspan="1" rowspan="1" class="el-table_29_column_200     is-leaf">
                            <div class="cell">차익</div>
                        </th>
                        <th class="gutter" style="width: 0px; display: none;"></th>
                    </tr>
                </thead>
            </table>
        </div>
        -->
        <div class="el-table__body-wrapper is-scrolling-none">
            <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 95%;">
                <colgroup>
                    <col name="el-table_29_column_195" width="206"><col name="el-table_29_column_196" width="204">
                    <col name="el-table_29_column_197" width="204"><col name="el-table_29_column_198" width="204">
                    <col name="el-table_29_column_199" width="204"><col name="el-table_29_column_200" width="204">
                </colgroup>
                <thead class="has-gutter">
                    <tr class="">
                        <th colspan="1" rowspan="1" class="el-table_29_column_195     is-leaf">
                            <div class="cell">아이디</div>
                        </th>
                        <th colspan="1" rowspan="1" class="el-table_29_column_196     is-leaf">
                            <div class="cell">직충전금액</div>
                        </th>
                        <th colspan="1" rowspan="1" class="el-table_29_column_197     is-leaf">
                            <div class="cell">충전신청금액</div>
                        </th>
                        <th colspan="1" rowspan="1" class="el-table_29_column_198     is-leaf">
                            <div class="cell">환전신청금액</div>
                        </th>
                        <th colspan="1" rowspan="1" class="el-table_29_column_199     is-leaf">
                            <div class="cell">포인트 전환금액</div>
                        </th>
                        <th colspan="1" rowspan="1" class="el-table_29_column_200     is-leaf">
                            <div class="cell">차익</div>
                        </th>
                       
                    </tr>
                </thead>
                <tbody id="el-main-data-id">

                </tbody>
            </table>
            <div class="el-table__empty-block" id="el-main__empty-id" style="width: 95%; display:flex;">
                <span class="el-table__empty-text">No Data</span>
            </div>
        </div>
        <div class="el-table__footer-wrapper" id="el-main-footer-id" style="display: none;">
            <table cellspacing="0" cellpadding="0" border="0" class="el-table__footer" style="width: 95%;">
                <colgroup>
                    <col name="el-table_29_column_195" width="206"><col name="el-table_29_column_196" width="204">
                    <col name="el-table_29_column_197" width="204"><col name="el-table_29_column_198" width="204">
                    <col name="el-table_29_column_199" width="204"><col name="el-table_29_column_200" width="204">
                   
                </colgroup>
                <tbody class="has-gutter">
                    <tr>
                        <td>
                            <div class="cell">합계</div>
                        </td>
                        <td>
                            <div class="cell" id="el-main-sum_1-id">N/A</div>
                        </td>
                        <td>
                            <div class="cell" id="el-main-sum_2-id">N/A</div>
                        </td>
                        <td>
                            <div class="cell" id="el-main-sum_3-id">N/A</div>
                        </td>
                        <td>
                            <div class="cell" id="el-main-sum_4-id">N/A</div>
                        </td>
                        <td>
                            <div class="cell" id="el-main-sum_5-id">N/A</div>
                        </td>
                        
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="el-table__column-resize-proxy" style="display: none;"></div>
    </div> 

    <div class="el-dialog__wrapper" id="el-dialog-detail-id" style="z-index: 2009; display:none;">
        <div role="dialog" aria-modal="true" aria-label="충환전 세부내역" class="el-dialog" style="margin-top: 15vh; width: 80%;">
            <div class="el-dialog__header">
                <span class="el-dialog__title">충환전 세부내역</span>
                <button type="button"  onclick="closeDetailDlg();" class="el-dialog__headerbtn">
                    <i class="el-dialog__close fas fa-times"></i>
                </button>
            </div>
            <div class="el-dialog__body">                
                <div class="el-table el-table--fit el-table--enable-row-hover el-table--enable-row-transition">
                    <!--
                    <div class="hidden-columns">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="el-table__header-wrapper">
                        <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 1185px;">
                            <colgroup>
                                <col name="el-table_4_column_26" width="200" />
                                <col name="el-table_4_column_27" width="197" />
                                <col name="el-table_4_column_28" width="197" />
                                <col name="el-table_4_column_29" width="197" />
                                <col name="el-table_4_column_30" width="197" />
                                <col name="el-table_4_column_31" width="197" />
                                <col name="gutter" width="0" />
                            </colgroup>
                            <thead class="has-gutter">
                                <tr class="">
                                    <th colspan="1" rowspan="1" class="el-table_4_column_26 is-leaf"><div class="cell">아이디</div></th>
                                    <th colspan="1" rowspan="1" class="el-table_4_column_27 is-leaf"><div class="cell">직충전금액</div></th>
                                    <th colspan="1" rowspan="1" class="el-table_4_column_28 is-leaf"><div class="cell">충전신청금액</div></th>
                                    <th colspan="1" rowspan="1" class="el-table_4_column_29 is-leaf"><div class="cell">환전신청금액</div></th>
                                    <th colspan="1" rowspan="1" class="el-table_4_column_30 is-leaf"><div class="cell">포인트 전환금액</div></th>
                                    <th colspan="1" rowspan="1" class="el-table_4_column_31 is-leaf"><div class="cell">신청일자</div></th>
                                    <th class="gutter" style="width: 0px; display: none;"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    -->
                    <div class="el-table__body-wrapper is-scrolling-none" style="max-height:55vh; overflow:auto;">
                        <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 100%;">
                            <colgroup>
                                <col name="el-table_4_column_26" width="180" />
                                <col name="el-table_4_column_27" width="180" />
                                <col name="el-table_4_column_28" width="180" />
                                <col name="el-table_4_column_29" width="180" />
                                <col name="el-table_4_column_30" width="180" />
                                <col name="el-table_4_column_31" width="197" />
                            </colgroup>
                            <thead class="has-gutter">
                                <tr class="">
                                    <th colspan="1" rowspan="1" class="el-table_4_column_26 is-leaf"><div class="cell">아이디</div></th>
                                    <th colspan="1" rowspan="1" class="el-table_4_column_27 is-leaf"><div class="cell">직충전금액</div></th>
                                    <th colspan="1" rowspan="1" class="el-table_4_column_28 is-leaf"><div class="cell">충전신청금액</div></th>
                                    <th colspan="1" rowspan="1" class="el-table_4_column_29 is-leaf"><div class="cell">환전신청금액</div></th>
                                    <th colspan="1" rowspan="1" class="el-table_4_column_30 is-leaf"><div class="cell">포인트 전환금액</div></th>
                                    <th colspan="1" rowspan="1" class="el-table_4_column_31 is-leaf"><div class="cell">신청일자</div></th>
                                    
                                </tr>
                            </thead>
                            <tbody id="el-dialog-detail-data-id">
                               
                            </tbody>
                        </table>
                        <!----><!---->
                    </div>
                    <!----><!----><!----><!---->
                    <div class="el-table__column-resize-proxy" style="display: none;"></div>
                </div>
            </div>
            <div class="el-dialog__footer">
                <span>
                    <button type="button" class="el-button el-button--primary"  onclick="closeDetailDlg();">
                        <!----><!---->
                        <span>닫기</span>
                    </button>
                </span>
            </div>
        </div>
    </div>

</main>


<script src="<?php echo base_url('assets/js/control/trans-control.js'); ?>"></script>

