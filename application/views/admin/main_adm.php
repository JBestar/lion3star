<main class="el-main">
    <div class="el-row">
        <button type="button" onclick="showEmpDlg();" class="el-button el-button--primary">
            
            <span>총판생성</span>
        </button>
        <div class="el-divider el-divider--horizontal"></div>
        <div class="el-table el-table--fit el-table--enable-row-hover el-table--enable-row-transition el-table--small">
            <!--
            <div class="hidden-columns">

            </div>
            <div class="el-table__header-wrapper">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 1230px;">
                    <colgroup>
                        <col name="el-table_26_column_177" width="90" />
                        <col name="el-table_26_column_178" width="90" />
                        <col name="el-table_26_column_179" width="90" />
                        <col name="el-table_26_column_180" width="90" />
                        <col name="el-table_26_column_181" width="90" />
                        <col name="el-table_26_column_182" width="90" />
                        <col name="el-table_26_column_183" width="270" />
                        <col name="el-table_26_column_184" width="270" />
                        <col name="el-table_26_column_185" width="150" />
                        <col name="gutter" width="0" />
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_26_column_177 is-leaf"><div class="cell">총판아이디</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_178 is-leaf"><div class="cell">별명</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_179 is-leaf"><div class="cell">비밀번호</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_180 is-leaf"><div class="cell">수수료율</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_181 is-leaf"><div class="cell">보유금액</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_182 is-leaf"><div class="cell">포인트</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_183 is-leaf"><div class="cell">가입날짜</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_184 is-leaf"><div class="cell">로그인날짜</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_185 is-hidden is-leaf"><div class="cell">기능</div></th>
                            <th class="gutter" style="width: 0px; display: none;"></th>
                        </tr>
                    </thead>
                </table>
            </div>
            -->
            <div class="el-table__body-wrapper is-scrolling-none" >
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 100%;">
                    <colgroup>
                        <col name="el-table_26_column_177" width="90" />
                        <col name="el-table_26_column_178" width="90" />
                        <col name="el-table_26_column_179" width="90" />
                        <col name="el-table_26_column_180" width="90" />
                        <col name="el-table_26_column_181" width="90" />
                        <col name="el-table_26_column_182" width="90" />
                        <col name="el-table_26_column_183" width="150" />
                        <col name="el-table_26_column_184" width="150" />
                        <col name="el-table_26_column_185" width="150" />
                        <col name="el-table_26_column_186" width="100" />
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_26_column_177 is-leaf"><div class="cell">총판아이디</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_178 is-leaf"><div class="cell">별명</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_179 is-leaf"><div class="cell">비밀번호</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_180 is-leaf"><div class="cell">수수료율</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_181 is-leaf"><div class="cell">보유금액</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_182 is-leaf"><div class="cell">포인트</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_183 is-leaf"><div class="cell">가입날짜</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_184 is-leaf"><div class="cell">로그인날짜</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_185 is-leaf"><div class="cell">기능</div></th>
                            <th colspan="1" rowspan="1" class="el-table_26_column_186 is-leaf"><div class="cell">상태</div></th>
                            
                        </tr>
                    </thead>
                    <tbody  id="main-employee1-id">
                        <tr class="el-table__row">
                            <td><div class="cell">test</div></td>
                            <td><div class="cell">test</div></td>
                            <td><div class="cell">1234</div></td>
                            <td><div class="cell">0.035</div></td>
                            <td><div class="cell">20000000</div></td>
                            <td><div class="cell">87900</div></td>
                            <td><div class="cell">2020-11-19 12:49:48</div></td>
                            <td><div class="cell">2021-02-10 09:07:16</div></td>
                            <td>
                                <div class="cell">
                                    <button type="button" class="el-button el-button--primary el-button--mini star-icon-btn" title="수정">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button type="button" class="el-button el-button--danger el-button--mini star-icon-btn" title="삭제">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                            <td><div class="cell"></div></td>
                        </tr>

                    </tbody>
                </table>
                
            </div>
            

            <div class="el-table__fixed-right-patch" style="width: 0px; height: 39px;"></div>
            <div class="el-table__column-resize-proxy" style="display: none;"></div>
        </div>


        <!--================Member Dialog================-->
        <div class="el-dialog__wrapper"  id="el-dialog-employee-id" style="z-index: 2015; display: none;">
            <div role="dialog" aria-modal="true" aria-label="계정관리" class="el-dialog" style="margin-top: 5vh;">
                <div class="el-dialog__header">
                    <span class="el-dialog__title">계정관리</span>
                    <button type="button"  onclick="closeEmpDlg();" aria-label="Close" class="el-dialog__headerbtn">
                        <i class="el-dialog__close fas fa-times"></i></button>
                </div>
                <div class="el-dialog__body">
                    <form class="el-form">
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;">총판아이디</label>
                            <div class="el-form-item__content" style="margin-left: 100px;">
                                <div class="el-input is-disabled"  id="el-dialog-employee-uid-div">
                                    
                                    <input type="text"  id="el-dialog-employee-uid" autocomplete="off" class="el-input__inner" disabled="disabled" />
                                    
                                </div>
                                
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;">별명</label>
                            <div class="el-form-item__content" style="margin-left: 100px;">
                                <div class="el-input">
                                    
                                    <input type="text" index="0" id="el-dialog-employee-nickname" autocomplete="off" class="el-input__inner" />
                                    
                                </div>
                                
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;">비밀번호</label>
                            <div class="el-form-item__content" style="margin-left: 100px;">
                                <div class="el-input">
                                    
                                    <input type="text" id="el-dialog-employee-pwd" autocomplete="off" class="el-input__inner" />
                                    
                                </div>
                                
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;">수수료율</label>
                            <div class="el-form-item__content" style="margin-left: 100px;">
                                <div class="el-input">
                                    
                                    <input type="number" id="el-dialog-employee-ratio" autocomplete="off" class="el-input__inner" />
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                    </form>
                </div>
                <div class="el-dialog__footer">
                    <span>
                        <button type="button" onclick="saveEmployee();" class="el-button el-button--primary">
                            
                            <span>저장</span>
                        </button>
                        <button type="button"  onclick="closeEmpDlg();" class="el-button el-button--danger">
                            
                            <span>취소</span>
                        </button>
                    </span>
                </div>
            </div>
        </div>



    </div>
</main>



<script src="<?php echo base_url('assets/js/admin/main-adm.js?v=2'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/employee-mgmt.css?v=3'); ?>">

