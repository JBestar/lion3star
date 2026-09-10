

<main  class="el-main">
    <div  class="el-row">
        <button type="button" onclick="showEmpDlg();" class="el-button el-button--primary">
            <span>아이디 생성</span>
        </button> 
        <div class="el-divider el-divider--horizontal"></div> 
        <div class="el-table employee-mgmt-table el-table--fit el-table--striped el-table--scrollable-x el-table--scrollable-y el-table--enable-row-transition el-table--small">

            <div class="el-table__body-wrapper is-scrolling-left">
                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 1200px;">
                    <colgroup>
                        <col name="el-table_15_column_109" width="90"><col name="el-table_15_column_110" width="90">
                        <col name="el-table_15_column_111" width="90"><col name="el-table_15_column_112" width="90">
                        <col name="el-table_15_column_113" width="90"><col name="el-table_15_column_114" width="90">
                        <col name="el-table_15_column_115" width="90"><col name="el-table_15_column_116" width="90">
                        <col name="el-table_15_column_117" width="90"><col name="el-table_15_column_118" width="150">
                        <col name="el-table_15_column_119" width="150"><col name="el-table_15_column_120" width="90">
                    </colgroup>
                    <thead class="has-gutter">
                        <tr class="">
                            <th colspan="1" rowspan="1" class="el-table_15_column_109     is-leaf">
                                <div class="cell">매장아이디</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_15_column_110     is-leaf">
                                <div class="cell">별명</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_15_column_111     is-leaf">
                                <div class="cell">비밀번호</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_15_column_112     is-leaf">
                                <div class="cell">수수료율</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_15_column_113     is-leaf">
                                <div class="cell">보유금액</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_15_column_114     is-leaf">
                                <div class="cell">포인트</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_15_column_115     is-leaf">
                                <div class="cell">회차한도</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_15_column_116     is-leaf">
                                <div class="cell">단품한도</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_15_column_117     is-leaf">
                                <div class="cell">조합한도</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_15_column_118     is-leaf">
                                <div class="cell">가입날짜</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_15_column_119     is-leaf">
                                <div class="cell">로그인날짜</div>
                            </th>
                            <th colspan="1" rowspan="1" class="el-table_15_column_120     is-hidden is-leaf">
                                <div class="cell">기능</div>
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody id="main-employee1-id">

                    </tbody>
                </table>
            </div>
            <div class="el-table__fixed-right" style="width: 90px; height: 100%;">
                
                <div class="el-table__fixed-header-wrapper">
                    <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 1200px;">
                        <colgroup>
                            <col name="el-table_15_column_109" width="90"><col name="el-table_15_column_110" width="90">
                            <col name="el-table_15_column_111" width="90"><col name="el-table_15_column_112" width="90">
                            <col name="el-table_15_column_113" width="90"><col name="el-table_15_column_114" width="90">
                            <col name="el-table_15_column_115" width="90"><col name="el-table_15_column_116" width="90">
                            <col name="el-table_15_column_117" width="90"><col name="el-table_15_column_118" width="150">
                            <col name="el-table_15_column_119" width="150"><col name="el-table_15_column_120" width="90">
                        </colgroup>
                        <thead class="">
                            <tr class="">
                                <th colspan="1" rowspan="1" class="el-table_15_column_109     is-hidden is-leaf">
                                    <div class="cell">매장아이디</div>
                                </th><th colspan="1" rowspan="1" class="el-table_15_column_110     is-hidden is-leaf">
                                    <div class="cell">별명</div>
                                </th><th colspan="1" rowspan="1" class="el-table_15_column_111     is-hidden is-leaf">
                                    <div class="cell">비밀번호</div>
                                </th>
                                <th colspan="1" rowspan="1" class="el-table_15_column_112     is-hidden is-leaf">
                                    <div class="cell">수수료율</div>
                                </th>
                                <th colspan="1" rowspan="1" class="el-table_15_column_113     is-hidden is-leaf">
                                    <div class="cell">보유금액</div>
                                </th>
                                <th colspan="1" rowspan="1" class="el-table_15_column_114     is-hidden is-leaf">
                                    <div class="cell">포인트</div>
                                </th>
                                <th colspan="1" rowspan="1" class="el-table_15_column_115     is-hidden is-leaf">
                                    <div class="cell">회차한도</div>
                                </th>
                                <th colspan="1" rowspan="1" class="el-table_15_column_116     is-hidden is-leaf">
                                    <div class="cell">단품한도</div>
                                </th>
                                <th colspan="1" rowspan="1" class="el-table_15_column_117     is-hidden is-leaf">
                                    <div class="cell">조합한도</div>
                                </th>
                                <th colspan="1" rowspan="1" class="el-table_15_column_118     is-hidden is-leaf">
                                    <div class="cell">가입날짜</div>
                                </th>
                                <th colspan="1" rowspan="1" class="el-table_15_column_119     is-hidden is-leaf">
                                    <div class="cell">로그인날짜</div>
                                </th>
                                <th colspan="1" rowspan="1" class="el-table_15_column_120     is-leaf">
                                    <div class="cell">기능</div>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
                
                <div class="el-table__fixed-body-wrapper" style="top: 39px;">
                    <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 1200px;">
                        <colgroup>
                            <col name="el-table_15_column_109" width="90"><col name="el-table_15_column_110" width="90">
                            <col name="el-table_15_column_111" width="90"><col name="el-table_15_column_112" width="90">
                            <col name="el-table_15_column_113" width="90"><col name="el-table_15_column_114" width="90">
                            <col name="el-table_15_column_115" width="90"><col name="el-table_15_column_116" width="90">
                            <col name="el-table_15_column_117" width="90"><col name="el-table_15_column_118" width="150">
                            <col name="el-table_15_column_119" width="150"><col name="el-table_15_column_120" width="90">
                        </colgroup>
                        
                        <tbody  id="main-employee2-id">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="el-table__fixed-right-patch" style="width: 0px; height: 39px;"></div>
            <div class="el-table__column-resize-proxy" style="display: none;"></div>
        </div> 

        <!--================Member Dialog================-->
        <div class="el-dialog__wrapper" id="el-dialog-employee-id" style="z-index: 2025; display: none;">
            <div role="dialog" aria-modal="true" aria-label="계정관리" class="el-dialog" style="margin-top: 5vh;">
                <div class="el-dialog__header">
                    <span class="el-dialog__title">계정관리</span>
                    <button type="button" onclick="closeEmpDlg();" class="el-dialog__headerbtn">
                        <i class="el-dialog__close fas fa-times"></i>
                    </button>
                </div>
                <div class="el-dialog__body">
                    <form class="el-form" >
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;">매장아이디</label>
                            <div class="el-form-item__content" style="margin-left: 100px;">
                                <div class="el-input" id="el-dialog-employee-uid-div">
                                    <input type="text" id="el-dialog-employee-uid" autocomplete="off" class="el-input__inner">
                                </div>
                            </div>
                        </div> 
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;">별명</label>
                            <div class="el-form-item__content" style="margin-left: 100px;">
                                <div class="el-input">
                                    <input type="text" index="0" id="el-dialog-employee-nickname" autocomplete="off" class="el-input__inner">
                                </div>
                            </div>
                        </div> 
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;">비밀번호</label>
                            <div class="el-form-item__content" style="margin-left: 100px;">
                                <div class="el-input">
                                    <input type="text" id="el-dialog-employee-pwd" autocomplete="off" class="el-input__inner">
                                </div>
                            </div>
                        </div> 
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 100px;">수수료율</label>
                            <div class="el-form-item__content" style="margin-left: 100px;">
                                <div class="el-input">
                                    <input type="number" id="el-dialog-employee-ratio" autocomplete="off" class="el-input__inner">
                                </div>
                            </div>
                        </div> 
                        <div>
                            <div class="el-form-item">
                                <label class="el-form-item__label" style="width: 100px;">회차한도</label>
                                <div class="el-form-item__content" style="margin-left: 100px;">
                                    <div class="el-input">
                                        <input type="number" id="el-dialog-employee-liround" autocomplete="off" class="el-input__inner">
                                    </div>
                                </div>
                            </div> 
                            <div class="el-form-item">
                                <label class="el-form-item__label" style="width: 100px;">단품한도</label>
                                <div class="el-form-item__content" style="margin-left: 100px;">
                                    <div class="el-input">
                                        <input type="number" id="el-dialog-employee-lisingle" autocomplete="off" class="el-input__inner">
                                    </div>
                                </div>
                            </div> 
                            <div class="el-form-item">
                                <label class="el-form-item__label" style="width: 100px;">조합한도</label>
                                <div class="el-form-item__content" style="margin-left: 100px;">
                                    <div class="el-input">
                                        <input type="number"  id="el-dialog-employee-limix" autocomplete="off" class="el-input__inner">
                                    </div>
                                </div>
                            </div>
                            <div class="el-form-item">
                                <label class="el-form-item__label" style="width: 100px;">영수증발급</label>
                                <div class="el-form-item__content" style="margin-left: 100px;">
                                    <label style="cursor:pointer;">
                                        <input type="checkbox" id="el-dialog-employee-print" autocomplete="off" style="zoom:1.3;vertical-align:middle;">
                                        <span style="margin-left:6px;vertical-align:middle;">배팅 시 영수증(PDF) 자동 발급</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form> 
                </div>
                <div class="el-dialog__footer">
                    <span>
                        <button type="button"  onclick="saveEmployee();" class="el-button el-button--primary"><span>저장</span></button> 
                        <button type="button"  onclick="closeEmpDlg();" class="el-button el-button--danger"><span>취소</span></button>
                    </span>
                </div>
            </div>
        </div>



    </div>
</main>




<link rel="stylesheet" href="<?php echo base_url('assets/css/employee-mgmt.css?v=3'); ?>">
<script src="<?php echo base_url('assets/js/control/main-control.js?v=2'); ?>"></script>
