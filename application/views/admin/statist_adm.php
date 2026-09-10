<main class="el-main">
    <div class="el-row" inline="">
        <div class="el-date-editor el-range-editor el-input__inner el-date-editor--daterange">
            <i class="el-input__icon el-range__icon fa fa-calendar-alt"></i>
            <input type="text" id="el-main-range-id" class="el-range-input" name="daterange" value="" >  
            <i class="el-input__icon el-range__close-icon" id="el-main-range__close-id"></i>  
        </div>
        <button type="button"  onclick="requestBetStatist();" class="el-button el-button--primary star-icon-btn" title="검색">
            <i class="fas fa-search"></i>
        </button>
        <div class="el-divider el-divider--horizontal"></div>
        <div class="el-table el-table--fit el-table--enable-row-hover el-table--enable-row-transition">

            <div class="el-table__body-wrapper is-scrolling-none">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 100%;">
                    <colgroup>
                        <col name="el-table_27_column_186" width="205" />
                        <col name="el-table_27_column_187" width="205" />
                        <col name="el-table_27_column_188" width="205" />
                        <col name="el-table_27_column_189" width="205" />
                        <col name="el-table_27_column_190" width="205" />
                        <col name="el-table_27_column_191" width="205" />
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_27_column_186 is-leaf"><div class="cell">아이디</div></th>
                            <th colspan="1" rowspan="1" class="el-table_27_column_187 is-leaf"><div class="cell">구매금액</div></th>
                            <th colspan="1" rowspan="1" class="el-table_27_column_188 is-leaf"><div class="cell">적중금액</div></th>
                            <th colspan="1" rowspan="1" class="el-table_27_column_189 is-leaf"><div class="cell">차익</div></th>
                            <th colspan="1" rowspan="1" class="el-table_27_column_190 is-leaf"><div class="cell">적중회차</div></th>
                            <th colspan="1" rowspan="1" class="el-table_27_column_191 is-leaf"><div class="cell">포인트</div></th>
                            
                        </tr>
                    </thead>
                    <tbody id="el-main-data-id">
                        <!--
                        <tr class="el-table__row">
                            <td rowspan="1" colspan="1" class="el-table_27_column_186"><div class="cell">kkk777</div></td>
                            <td rowspan="1" colspan="1" class="el-table_27_column_187"><div class="cell">233310000</div></td>
                            <td rowspan="1" colspan="1" class="el-table_27_column_188"><div class="cell">200108900</div></td>
                            <td rowspan="1" colspan="1" class="el-table_27_column_189"><div class="cell">33201100</div></td>
                            <td rowspan="1" colspan="1" class="el-table_27_column_190"><div class="cell">1026</div></td>
                            <td rowspan="1" colspan="1" class="el-table_27_column_191"><div class="cell">5601240</div></td>
                        </tr>
                        -->
                        
                    </tbody>
                </table>
                <div class="el-table__empty-block" id="el-main__empty-id" style="display:none;">
                    <span class="el-table__empty-text">No Data</span>
                </div>
            </div>
            <div class="el-table__footer-wrapper" id="el-main-footer-id" style="display:block;">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__footer" style="width: 100%;">
                    <colgroup>
                        <col name="el-table_27_column_186" width="205" />
                        <col name="el-table_27_column_187" width="205" />
                        <col name="el-table_27_column_188" width="205" />
                        <col name="el-table_27_column_189" width="205" />
                        <col name="el-table_27_column_190" width="205" />
                        <col name="el-table_27_column_191" width="205" />
                        
                    </colgroup>
                    <tbody class="has-gutter">
                        <tr>
                            <td colspan="1" rowspan="1" class="el-table_27_column_186 is-leaf"><div class="cell">합계</div></td>
                            <td colspan="1" rowspan="1" class="el-table_27_column_187 is-leaf"><div class="cell"  id="el-main-sum_1-id">0</div></td>
                            <td colspan="1" rowspan="1" class="el-table_27_column_188 is-leaf"><div class="cell"  id="el-main-sum_2-id">0</div></td>
                            <td colspan="1" rowspan="1" class="el-table_27_column_189 is-leaf"><div class="cell"  id="el-main-sum_3-id">0</div></td>
                            <td colspan="1" rowspan="1" class="el-table_27_column_190 is-leaf"><div class="cell"></div></td>
                            <td colspan="1" rowspan="1" class="el-table_27_column_191 is-leaf"><div class="cell"  id="el-main-sum_4-id"></div></td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="el-table__column-resize-proxy" style="display: none;"></div>
        </div>
        
        
        <!--================Dialog================-->
        <div class="el-dialog__wrapper" id="el-dialog-history-id" name="" style="z-index: 2019; display:none;">
            <div role="dialog" aria-modal="true" aria-label="총판거래내역" class="el-dialog" style="margin-top: 5vh; width: 90%;">
                <div class="el-dialog__header">
                    <span class="el-dialog__title">총판거래내역</span>
                    <button type="button" aria-label="Close" class="el-dialog__headerbtn" onclick="closeEmpBetDlg();">
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
                    <div class="el-table el-table--fit el-table--scrollable-y el-table--enable-row-hover el-table--enable-row-transition el-table--small" style="/*height: 50vh;*/">

                        <div class="el-table__body-wrapper is-scrolling-none" style="height: 50vh; overflow:auto; ">
                            <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 100%;">
                                <colgroup>
                                    <col name="el-table_28_column_192" width="120" />
                                    <col name="el-table_28_column_193" width="120" />
                                    <col name="el-table_28_column_194" width="120" />
                                    <col name="el-table_28_column_195" width="120" />
                                    <col name="el-table_28_column_196" width="120" />
                                    <col name="el-table_28_column_197" width="120" />
                                </colgroup>
                                <thead class="has-gutter">
                                    <tr class="">
                                        <th colspan="1" rowspan="1" class="el-table_28_column_192 is-leaf"><div class="cell">아이디</div></th>
                                        <th colspan="1" rowspan="1" class="el-table_28_column_193 is-leaf"><div class="cell">구매금액</div></th>
                                        <th colspan="1" rowspan="1" class="el-table_28_column_194 is-leaf"><div class="cell">적중금액</div></th>
                                        <th colspan="1" rowspan="1" class="el-table_28_column_195 is-leaf"><div class="cell">차익</div></th>
                                        <th colspan="1" rowspan="1" class="el-table_28_column_196 is-leaf"><div class="cell">적중회차</div></th>
                                        <th colspan="1" rowspan="1" class="el-table_28_column_197 is-leaf"><div class="cell">포인트</div></th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="el-dialog-data-id">
                                    <!--
                                    <tr class="el-table__row">
                                        <td rowspan="1" colspan="1" class="el-table_28_column_192"><div class="cell">쌍촌01</div></td>
                                        <td rowspan="1" colspan="1" class="el-table_28_column_193"><div class="cell">30000</div></td>
                                        <td rowspan="1" colspan="1" class="el-table_28_column_194"><div class="cell">38600</div></td>
                                        <td rowspan="1" colspan="1" class="el-table_28_column_195"><div class="cell">-8600</div></td>
                                        <td rowspan="1" colspan="1" class="el-table_28_column_196"><div class="cell">2</div></td>
                                        <td rowspan="1" colspan="1" class="el-table_28_column_197"><div class="cell">960</div></td>
                                    </tr>
                                    -->
                                </tbody>
                            </table>
                            
                        </div>
                        <div class="el-table__footer-wrapper" id="el-dialog-footer-id">
                            <table cellspacing="0" cellpadding="0" border="0" class="el-table__footer" style="width: 100%;">
                                
                                <colgroup>
                                    <col name="el-table_28_column_192" width="120" />
                                    <col name="el-table_28_column_193" width="120" />
                                    <col name="el-table_28_column_194" width="120" />
                                    <col name="el-table_28_column_195" width="120" />
                                    <col name="el-table_28_column_196" width="120" />
                                    <col name="el-table_28_column_197" width="120" />
                                    
                                </colgroup>

                                <tbody class="has-gutter">
                                    <tr>
                                        <td colspan="1" rowspan="1" class="is-leaf"><div class="cell">합계</div></td>
                                        <td colspan="1" rowspan="1" class="is-leaf"><div class="cell" id="el-dialog-sum_1-id">0</div></td>
                                        <td colspan="1" rowspan="1" class="is-leaf"><div class="cell" id="el-dialog-sum_2-id">0</div></td>
                                        <td colspan="1" rowspan="1" class="is-leaf"><div class="cell" id="el-dialog-sum_3-id">0</div></td>
                                        <td colspan="1" rowspan="1" class="is-leaf"><div class="cell"></div></td>
                                        <td colspan="1" rowspan="1" class="is-leaf"><div class="cell"></div></td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="el-table__column-resize-proxy" style="display: none;"></div>
                    </div>
                </div>
                <div class="el-dialog__footer">
                    <span>
                        <button type="button"  onclick="closeEmpBetDlg();" class="el-button el-button--primary">
                            
                            <span>닫기</span>
                        </button>
                    </span>
                </div>
            </div>
        </div>



    </div>
</main>



<script src="<?php echo base_url('assets/js/admin/statist-adm.js'); ?>"></script>
