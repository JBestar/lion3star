<main class="el-main">
    <div class="el-row">
        <div class="star-page-toolbar">
            <button type="button" class="el-button el-button--primary"  onclick="showMessageDlg();">
                <span>새메시지</span>
            </button>
        </div>
        <div class="el-divider el-divider--horizontal"></div>
        <div class="el-table star-page-table el-table--fit el-table--striped el-table--scrollable-x el-table--scrollable-y el-table--enable-row-hover el-table--enable-row-transition el-table--small">
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
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 1226px;">
                    <colgroup>
                        <col name="el-table_32_column_220" width="206" />
                        <col name="el-table_32_column_221" width="204" />
                        <col name="el-table_32_column_222" width="204" />
                        <col name="el-table_32_column_223" width="204" />
                        <col name="el-table_32_column_224" width="204" />
                        <col name="el-table_32_column_225" width="204" />
                        <col name="gutter" width="0" />
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_32_column_220 is-leaf"><div class="cell">보낸이</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_221 is-leaf"><div class="cell">받는이</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_222 is-leaf"><div class="cell">발송일자</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_223 is-leaf"><div class="cell">제목</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_224 is-leaf"><div class="cell">내용</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_225 is-leaf"><div class="cell"></div></th>
                            <th class="gutter" style="width: 0px; display: none;"></th>
                        </tr>
                    </thead>
                </table>
            </div>
            -->
            <div class="el-table__body-wrapper is-scrolling-none">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 95%;">
                    <colgroup>
                        <col name="el-table_32_column_220" width="206" />
                        <col name="el-table_32_column_221" width="204" />
                        <col name="el-table_32_column_222" width="204" />
                        <col name="el-table_32_column_223" width="204" />
                        <col name="el-table_32_column_224" width="204" />
                        <col name="el-table_32_column_225" width="204" />
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_32_column_220 is-leaf"><div class="cell">보낸이</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_221 is-leaf"><div class="cell">받는이</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_222 is-leaf"><div class="cell">발송일자</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_223 is-leaf"><div class="cell">제목</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_224 is-leaf"><div class="cell">내용</div></th>
                            <th colspan="1" rowspan="1" class="el-table_32_column_225 is-leaf"><div class="cell"></div></th>
                            
                        </tr>
                    </thead>
                    <tbody id="el-main-data-id">
                        <!--
                        <tr class="el-table__row">
                            <td rowspan="1" colspan="1" class="el-table_32_column_220"><div class="cell">god9080.</div></td>
                            <td rowspan="1" colspan="1" class="el-table_32_column_221"><div class="cell">test</div></td>
                            <td rowspan="1" colspan="1" class="el-table_32_column_222"><div class="cell">2021-02-10 23:16:45</div></td>
                            <td rowspan="1" colspan="1" class="el-table_32_column_223"><div class="cell">메시지</div></td>
                            <td rowspan="1" colspan="1" class="el-table_32_column_224"><div class="cell">메시지발송</div></td>
                            <td rowspan="1" colspan="1" class="el-table_32_column_225">
                                <div class="cell">
                                    <button type="button" class="el-button el-button--primary el-button--small star-icon-btn" title="삭제">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        -->
                    </tbody>
                </table>
                <div class="el-table__empty-block" id="el-main__empty-id" style="width: 95%; display:none;">
                    <span class="el-table__empty-text">No Data</span>
                </div>
            </div>
            <div class="el-table__column-resize-proxy" style="display: none;"></div>
        </div>

        <!--================Dialog================-->
        <div class="el-dialog__wrapper"  id="el-dialog-message-id" style="z-index: 2032; display:none;">
            <div role="dialog" aria-modal="true" aria-label="새메시지" class="el-dialog" style="margin-top: 15vh;">
                <div class="el-dialog__header">
                    <span class="el-dialog__title">새메시지</span>
                    <button type="button" aria-label="Close" class="el-dialog__headerbtn"  onclick="closeMessageDlg();"><i class="el-dialog__close  fas fa-times"></i></button>
                </div>
                <div class="el-dialog__body">
                    <form class="el-form">
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;"> 받는이</label>
                            <div class="el-form-item__content" style="margin-left: 100px;">
                                <div class="el-select">
                                    <!---->
                                    <div class="el-input el-input--suffix"  onclick="toggleEmpSelect();">
                                        <!---->
                                        <input type="text" readonly="readonly" id="el-form-uid-input-id" autocomplete="off" placeholder="Select" class="el-input__inner" />
                                        <!---->
                                        <span class="el-input__suffix">
                                            <span class="el-input__suffix-inner">
                                                <i class="el-select__caret el-input__icon fas fa-chevron-up" id="el-form-select-icon-id"></i>
                                                <!----><!----><!----><!----><!---->
                                            </span>
                                            <!---->
                                        </span>
                                        <!----><!---->
                                    </div>
                                </div>
                                <!---->
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;">제목</label>
                            <div class="el-form-item__content" style="margin-left: 100px;">
                                <div class="el-input">
                                    <!---->
                                    <input type="text" id="el-dialog-message-title-id" autocomplete="off" class="el-input__inner" />
                                    <!----><!----><!----><!---->
                                </div>
                                <!---->
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;">내용</label>
                            <div class="el-form-item__content" style="margin-left: 100px;">
                                <div class="el-textarea">
                                    <textarea autocomplete="off" id="el-dialog-message-content-id"  class="el-textarea__inner" style="min-height: 33px;"></textarea>
                                    <!---->
                                </div>
                                <!---->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="el-dialog__footer">
                    <span>
                        <button type="button" class="el-button el-button--primary"  onclick="sendMessage();">
                            <!----><!---->
                            <span>발송</span>
                        </button>
                        <button type="button" class="el-button el-button--danger" onclick="closeMessageDlg();">
                            <!----><!---->
                            <span>취소</span>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</main>


<script src="<?php echo base_url('assets/js/admin/message-adm.js'); ?>"></script>

