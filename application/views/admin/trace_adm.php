<main class="el-main">
    <div class="el-row">
        <form class="el-form el-form--inline">
            <div class="el-form-item">
                <label class="el-form-item__label">아이디</label>
                <div class="el-form-item__content">
                    <div class="el-input">
                        
                        <input type="text" id="el-form-input-id" autocomplete="off" class="el-input__inner" />
                        
                    </div>
                    
                </div>
            </div>
            <button type="button" class="el-button el-button--primary star-icon-btn" title="검색" onclick="requestTrace();">
                <i class="fas fa-search"></i>
            </button>
        </form>
        <div class="el-divider el-divider--horizontal"></div>
        <div class="el-table el-table--fit el-table--enable-row-hover el-table--small" style="/*height: 65vh;*/">
            <!--
            <div class="hidden-columns">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="el-table__header-wrapper">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 1226px;">
                    <colgroup>
                        <col name="el-table_34_column_234" width="246" />
                        <col name="el-table_34_column_235" width="245" />
                        <col name="el-table_34_column_236" width="245" />
                        <col name="el-table_34_column_237" width="245" />
                        <col name="el-table_34_column_238" width="245" />
                        <col name="gutter" width="0" />
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_34_column_234 is-leaf"><div class="cell">일자</div></th>
                            <th colspan="1" rowspan="1" class="el-table_34_column_235 is-leaf"><div class="cell">아이디</div></th>
                            <th colspan="1" rowspan="1" class="el-table_34_column_236 is-leaf"><div class="cell">별명</div></th>
                            <th colspan="1" rowspan="1" class="el-table_34_column_237 is-leaf"><div class="cell">아이피주소</div></th>
                            <th colspan="1" rowspan="1" class="el-table_34_column_238 is-leaf"><div class="cell">로그인상태</div></th>
                            <th class="gutter" style="width: 0px; display: none;"></th>
                        </tr>
                    </thead>
                </table>
            </div>
            -->
            <div class="el-table__body-wrapper is-scrolling-none" style="height: 65vh; overflow:auto;">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 95%;">
                    <colgroup>
                        <col name="el-table_34_column_234" width="246" />
                        <col name="el-table_34_column_235" width="245" />
                        <col name="el-table_34_column_236" width="245" />
                        <col name="el-table_34_column_237" width="245" />
                        <col name="el-table_34_column_238" width="245" />
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_34_column_234 is-leaf"><div class="cell">일자</div></th>
                            <th colspan="1" rowspan="1" class="el-table_34_column_235 is-leaf"><div class="cell">아이디</div></th>
                            <th colspan="1" rowspan="1" class="el-table_34_column_236 is-leaf"><div class="cell">별명</div></th>
                            <th colspan="1" rowspan="1" class="el-table_34_column_237 is-leaf"><div class="cell">아이피주소</div></th>
                            <th colspan="1" rowspan="1" class="el-table_34_column_238 is-leaf"><div class="cell">로그인상태</div></th>
                            
                        </tr>
                    </thead>
                    <tbody id="el-main-data-id">
                        
                    </tbody>
                </table>
                <div class="el-table__empty-block" id="el-main__empty-id" style="display:none;">
                    <span class="el-table__empty-text">No Data</span>
                </div>
                
            </div>
            
            <div class="el-table__column-resize-proxy" style="display: none;"></div>
        </div>
    </div>
</main>



<script src="<?php echo base_url('assets/js/admin/trace-adm.js'); ?>"></script>


