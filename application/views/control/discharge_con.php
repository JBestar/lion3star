
<main class="el-main">
    <div class="el-row">
        <form class="el-form el-form--inline">
            <div class="el-form-item">
                <label class="el-form-item__label">환전신청 아이디</label>
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
                <label class="el-form-item__label">환전금액</label>
                <div class="el-form-item__content">
                    <div class="el-input">
                        <input type="number" autocomplete="off" class="el-input__inner"  id="el-form-amount-input-id">
                    </div>
                </div>
            </div> 
            <button type="button" class="el-button el-button--primary" onclick="giveDischarge();">
                <span>확인</span>
            </button>
        </form> 
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
        <div class="el-divider el-divider--horizontal"></div> 
        <div class="el-table el-table--fit el-table--enable-row-hover el-table--small" style="/*height: 80vh;*/">
            <!--
            <div class="hidden-columns">
                <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> 
                <div></div> <div></div> <div></div>
            </div>
            <div class="el-table__header-wrapper">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 1226px;">
                    <colgroup>
                        <col name="el-table_22_column_153" width="134"><col name="el-table_22_column_154" width="132">
                        <col name="el-table_22_column_155" width="132"><col name="el-table_22_column_156" width="132">
                        <col name="el-table_22_column_157" width="132"><col name="el-table_22_column_158" width="132">
                        <col name="el-table_22_column_159" width="150"><col name="el-table_22_column_160" width="150">
                        <col name="el-table_22_column_161" width="132"><col name="gutter" width="0">
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_22_column_153     is-leaf">
                                <div class="cell">신청아이디</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_154     is-leaf">
                                <div class="cell">환전금액</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_155     is-leaf">
                                <div class="cell">상태</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_156     is-leaf">
                                <div class="cell">은행명</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_157     is-leaf">
                                <div class="cell">계좌번호</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_158     is-leaf">
                                <div class="cell">계좌명</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_159     is-leaf">
                                <div class="cell">신청일자</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_160     is-leaf">
                                <div class="cell">처리일자</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_161     is-leaf">
                                <div class="cell"></div>
                            </th>
                            <th class="gutter" style="width: 0px; display: none;"></th>
                        </tr>
                    </thead>
                </table>
            </div>
            -->
            <div class="el-table__body-wrapper is-scrolling-none" style="width:100%; height: 65vh; overflow:auto;">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 95%;">
                    <colgroup>
                        <col name="el-table_22_column_153" width="114">
                        <col name="el-table_22_column_154" width="112">
                        <col name="el-table_22_column_155" width="92">
                        <col name="el-table_22_column_162" width="100">
                        <col name="el-table_22_column_156" width="122">
                        <col name="el-table_22_column_161" width="88">
                        <col name="el-table_22_column_157" width="122">
                        <col name="el-table_22_column_158" width="122">
                        <col name="el-table_22_column_159" width="140">
                        <col name="el-table_22_column_160" width="140">
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_22_column_153     is-leaf">
                                <div class="cell">신청아이디</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_154     is-leaf">
                                <div class="cell">환전금액</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_155     is-leaf">
                                <div class="cell">상태</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_162     is-leaf">
                                <div class="cell">환전유형</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_156     is-leaf">
                                <div class="cell">은행명</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_161     is-leaf">
                                <div class="cell">확인</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_157     is-leaf">
                                <div class="cell">계좌번호</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_158     is-leaf">
                                <div class="cell">계좌명</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_159     is-leaf">
                                <div class="cell">신청일자</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_22_column_160     is-leaf">
                                <div class="cell">처리일자</div>
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody id="el-table-data-id">

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



<script src="<?php echo base_url('assets/js/control/discharge-control.js?v=4'); ?>"></script>

