<main class="el-main">
    <div class="el-row">
        <div class="star-page-toolbar">
            <form class="el-form el-form--inline">
                <div class="el-form-item">
                    <div class="el-date-editor el-range-editor el-input__inner el-date-editor--daterange">
                        <i class="el-input__icon el-range__icon fa fa-calendar-alt"></i>
                        <input type="text" id="el-main-range-id" class="el-range-input" name="daterange" value="" >
                        <i class="el-input__icon el-range__close-icon" id="el-main-range__close-id"></i>
                    </div>
                    <button type="button" onclick="findDischarge();" class="el-button el-button--primary star-icon-btn" title="검색">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
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
                <div></div>
            </div>
            <div class="el-table__header-wrapper">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 1226px;">
                        <colgroup>
                        <col name="el-table_30_column_205" width="134" />
                        <col name="el-table_30_column_206" width="132" />
                        <col name="el-table_30_column_207" width="132" />
                        <col name="el-table_30_column_208" width="132" />
                        <col name="el-table_30_column_209" width="132" />
                        <col name="el-table_30_column_210" width="132" />
                        <col name="el-table_30_column_211" width="150" />
                        <col name="el-table_30_column_212" width="150" />
                        <col name="el-table_30_column_213" width="132" />
                        <col name="gutter" width="0" />
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_30_column_205 is-leaf"><div class="cell">신청아이디</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_206 is-leaf"><div class="cell">환전금액</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_207 is-leaf"><div class="cell">상태</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_208 is-leaf"><div class="cell">은행명</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_209 is-leaf"><div class="cell">계좌번호</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_210 is-leaf"><div class="cell">계좌명</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_211 is-leaf"><div class="cell">신청일자</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_212 is-leaf"><div class="cell">처리일자</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_213 is-leaf"><div class="cell"></div></th>
                            <th class="gutter" style="width: 0px; display: none;"></th>
                        </tr>
                    </thead>
                </table>
            </div>
            -->
            <div class="el-table__body-wrapper is-scrolling-none">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 95%;">
                    <colgroup>
                        <col name="el-table_30_column_205" width="134" />
                        <col name="el-table_30_column_206" width="132" />
                        <col name="el-table_30_column_207" width="122" />
                        <col name="el-table_30_column_208" width="122" />
                        <col name="el-table_30_column_209" width="122" />
                        <col name="el-table_30_column_210" width="122" />
                        <col name="el-table_30_column_211" width="150" />
                        <col name="el-table_30_column_212" width="150" />
                        <col name="el-table_30_column_213" width="175" />
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_30_column_205 is-leaf"><div class="cell">신청아이디</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_206 is-leaf"><div class="cell">환전금액</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_207 is-leaf"><div class="cell">상태</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_208 is-leaf"><div class="cell">은행명</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_209 is-leaf"><div class="cell">계좌번호</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_210 is-leaf"><div class="cell">계좌명</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_211 is-leaf"><div class="cell">신청일자</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_212 is-leaf"><div class="cell">처리일자</div></th>
                            <th colspan="1" rowspan="1" class="el-table_30_column_213 is-leaf"><div class="cell"></div></th>

                        </tr>
                    </thead>
                    <tbody id="el-table-data-id">
                        <!---->
                    </tbody>
                </table>
                <div class="el-table__empty-block" id="el-table__empty-id" style="width: 95%;">
                    <span class="el-table__empty-text">No Data</span>
                </div>
            </div>
            <!----><!----><!----><!---->
            <div class="el-table__column-resize-proxy" style="display: none;"></div>
        </div>
    </div>
</main>


<script src="<?php echo base_url('assets/js/admin/discharge-adm.js?v=3') ?>"></script>

