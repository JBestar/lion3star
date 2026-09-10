
<main class="el-main">
    <div class="el-row">
        <div class="star-page-toolbar">
            <form class="el-form el-form--inline">
                <div class="el-form-item">
                    <label class="el-form-item__label">아이디</label>
                    <div class="el-form-item__content">
                        <div class="el-input">
                            <input type="text" id="el-form-input-id" autocomplete="off" class="el-input__inner" />
                        </div>
                    </div>
                </div>
                <button type="button" onclick="requestBetHistory();" class="el-button el-button--primary star-icon-btn" title="검색">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="el-divider el-divider--horizontal"></div> 
        <div class="el-table star-page-table el-table--fit el-table--striped el-table--scrollable-x el-table--scrollable-y el-table--enable-row-hover el-table--small">
            <!--
            <div class="hidden-columns">
                <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> 
                <div></div> <div></div>
            </div>
            <div class="el-table__header-wrapper">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 95%;">
                    <colgroup>
                        <col name="el-table_32_column_212" width="120"><col name="el-table_32_column_213" width="116">
                        <col name="el-table_32_column_214" width="150"><col name="el-table_32_column_215" width="116">
                        <col name="el-table_32_column_216" width="116"><col name="el-table_32_column_217" width="116">
                        <col name="el-table_32_column_218" width="116"><col name="el-table_32_column_219" width="116">
                        <col name="el-table_32_column_220" width="116"><col name="gutter" width="0">
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_32_column_212     is-leaf"><div class="cell">회차</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_213     is-leaf"><div class="cell">구매자명</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_214     is-leaf"><div class="cell">구매일자</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_215     is-leaf"><div class="cell">배팅내역</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_216     is-leaf"><div class="cell">당첨결과</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_217     is-leaf"><div class="cell">배팅금액</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_218     is-leaf"><div class="cell">배당</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_219     is-leaf"><div class="cell">적중금액</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_220     is-leaf"><div class="cell">보유금액</div></th>
                            <th class="gutter" style="width: 0px; display: none;"></th>
                        </tr>
                    </thead>
                </table>
            </div>
            -->
            <div class="el-table__body-wrapper is-scrolling-none">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width:  95%;">
                    <colgroup>
                        <col name="el-table_32_column_212" width="100">
                        <col name="el-table_32_column_212" width="120"><col name="el-table_32_column_213" width="116">
                        <col name="el-table_32_column_214" width="150"><col name="el-table_32_column_215" width="116">
                        <col name="el-table_32_column_216" width="116"><col name="el-table_32_column_217" width="116">
                        <col name="el-table_32_column_218" width="156"><col name="el-table_32_column_218" width="116">
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_20_column_211     is-leaf"><div class="cell">게임</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_212     is-leaf"><div class="cell">회차</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_213     is-leaf"><div class="cell">아이디</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_214     is-leaf"><div class="cell">구매자명</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_215     is-leaf"><div class="cell">배팅내역</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_216     is-leaf"><div class="cell">구매금액</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_216     is-leaf"><div class="cell">적중금액</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_217     is-leaf"><div class="cell">구매시간</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_218     is-leaf"><div class="cell">배팅변경</div></th>
                        </tr>
                    </thead>
                    <tbody  id="el-table-data-id" >
                    </tbody>
                </table>
                <div class="el-table__empty-block" id="el-table__empty-id" style="width: 95%;">
                    <span class="el-table__empty-text">No Data</span>
                </div>
            </div>
            <div class="el-table__column-resize-proxy" style="display: none;"></div>
        </div>
    </div>
</main>

<!-- <script src="<?php echo base_url('assets/js/admin/order-adm.js?v=1'); ?>"></script> -->
<script src="<?php echo base_url('assets/js/admin/order-adm.js?v=').time(); ?>"></script>