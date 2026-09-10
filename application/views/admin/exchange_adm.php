<main class="el-main">
    <div class="el-row">
        <div class="star-page-toolbar">
            <form class="el-form el-form--inline">
                <div class="el-form-item">
                    <label class="el-form-item__label">아이디</label>
                    <div class="el-form-item__content">
                        <div class="el-input">
                            <input type="text"  id="el-form-input-id" autocomplete="on" class="el-input__inner" />
                        </div>
                    </div>
                </div>
                <button type="button" class="el-button el-button--primary star-icon-btn" title="검색"  onclick="requestExchange();">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="el-divider el-divider--horizontal"></div>
        <div class="el-table star-page-table el-table--fit el-table--striped el-table--scrollable-x el-table--scrollable-y el-table--enable-row-hover el-table--small">
            <!--
            <div class="hidden-columns">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="el-table__header-wrapper">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 1226px;">
                    <colgroup>
                        <col name="el-table_33_column_226" width="158" />
                        <col name="el-table_33_column_227" width="153" />
                        <col name="el-table_33_column_228" width="153" />
                        <col name="el-table_33_column_229" width="153" />
                        <col name="el-table_33_column_230" width="153" />
                        <col name="el-table_33_column_231" width="153" />
                        <col name="el-table_33_column_232" width="150" />
                        <col name="el-table_33_column_233" width="153" />
                        <col name="gutter" width="0" />
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_33_column_226 is-leaf"><div class="cell">총판아이디</div></th>
                            <th colspan="1" rowspan="1" class="el-table_33_column_227 is-leaf"><div class="cell">거래아이디</div></th>
                            <th colspan="1" rowspan="1" class="el-table_33_column_228 is-leaf"><div class="cell">거래전보유금액</div></th>
                            <th colspan="1" rowspan="1" class="el-table_33_column_229 is-leaf"><div class="cell">거래금액</div></th>
                            <th colspan="1" rowspan="1" class="el-table_33_column_230 is-leaf"><div class="cell">거래상태</div></th>
                            <th colspan="1" rowspan="1" class="el-table_33_column_231 is-leaf"><div class="cell">거래유형</div></th>
                            <th colspan="1" rowspan="1" class="el-table_33_column_232 is-leaf"><div class="cell">거래일자</div></th>
                            <th colspan="1" rowspan="1" class="el-table_33_column_233 is-leaf"><div class="cell">현보유금액</div></th>
                            <th class="gutter" style="width: 0px; display: none;"></th>
                        </tr>
                    </thead>
                </table>
            </div>
            -->
            <div class="el-table__body-wrapper is-scrolling-none">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 95%; ">
                    <colgroup>
                        <col name="el-table_33_column_226" width="148" />
                        <col name="el-table_33_column_227" width="143" />
                        <col name="el-table_33_column_228" width="143" />
                        <col name="el-table_33_column_229" width="153" />
                        <col name="el-table_33_column_230" width="153" />
                        <col name="el-table_33_column_231" width="153" />
                        <col name="el-table_33_column_232" width="150" />
                        <col name="el-table_33_column_233" width="153" />
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_33_column_226 is-leaf"><div class="cell">총판아이디</div></th>
                            <th colspan="1" rowspan="1" class="el-table_33_column_227 is-leaf"><div class="cell">거래아이디</div></th>
                            <th colspan="1" rowspan="1" class="el-table_33_column_228 is-leaf"><div class="cell">거래전보유금액</div></th>
                            <th colspan="1" rowspan="1" class="el-table_33_column_229 is-leaf"><div class="cell">거래금액</div></th>
                            <th colspan="1" rowspan="1" class="el-table_33_column_230 is-leaf"><div class="cell">거래상태</div></th>
                            <th colspan="1" rowspan="1" class="el-table_33_column_231 is-leaf"><div class="cell">거래유형</div></th>
                            <th colspan="1" rowspan="1" class="el-table_33_column_232 is-leaf"><div class="cell">거래일자</div></th>
                            <th colspan="1" rowspan="1" class="el-table_33_column_233 is-leaf"><div class="cell">현보유금액</div></th>
                            
                        </tr>
                    </thead>
                    <tbody  id="el-main-data-id">
                        <!--
                        <tr class="el-table__row">
                            <td><div class="cell">test</div></td>
                            <td><div class="cell">test7</div></td>
                            <td>
                                <div class="cell"><span>19990000</span></div>
                            </td>
                            <td><div class="cell">10000</div></td>
                            <td>
                                <div class="cell"><span class="el-tag el-tag--success el-tag--light">거래완료</span></div>
                            </td>
                            <td>
                                <div class="cell"><span class="el-tag el-tag--light">직충전</span></div>
                            </td>
                            <td><div class="cell">2021-02-13 12:35:47</div></td>
                            <td><div class="cell">19980000</div></td>
                        </tr>
                        -->
                    </tbody>
                </table>
                <div class="el-table__empty-block"  id="el-main__empty-id"  style="width: 95%;">
                    <span class="el-table__empty-text">No Data</span>
                </div>
                <!---->
            </div>
            <!----><!----><!----><!---->
            <div class="el-table__column-resize-proxy" style="display: none;"></div>
        </div>
    </div>
</main>



<script src="<?php echo base_url('assets/js/admin/exchange-adm.js'); ?>"></script>


