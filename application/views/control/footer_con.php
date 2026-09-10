            
            

            </div>

            <!--================Charge Dialog================-->
            <div class="el-dialog__wrapper" id="el-dialog-charge-id" style="z-index: 2027; display:none;">
                <div role="dialog" aria-modal="true" aria-label="충전신청" class="el-dialog" style="margin-top: 5vh; width: 60%;">
                    <div class="el-dialog__header">
                        <span class="el-dialog__title">충전신청</span>
                        <button type="button" id="el-dialog-charge-close-id" class="el-dialog__headerbtn">
                            <i class="el-dialog__close  fas fa-times"></i>
                        </button>
                    </div>
                    <div class="el-dialog__body">
                        <form class="el-form">
                            <div class="el-form-item el-form-item--small">
                                <label class="el-form-item__label" style="width: 100px;">충전신청금액</label>
                                <div class="el-form-item__content" style="margin-left: 100px;">
                                    <div class="el-input el-input--small">
                                        <input type="number" autocomplete="off" id="el-dialog-charge-amount-id" class="el-input__inner">
                                    </div> 
                                    <div class="el-button-group">
                                        <button type="button" class="el-button el-button--default el-button--small" onclick="selectChargeAmount(100000);">
                                            <span>10만원</span>
                                        </button>
                                        <button type="button" class="el-button el-button--default el-button--small" onclick="selectChargeAmount(500000);">
                                            <span>50만원</span>
                                        </button> 
                                        <button type="button" class="el-button el-button--default el-button--small" onclick="selectChargeAmount(1000000);">
                                            <span>100만원</span>
                                        </button>
                                        <button type="button" class="el-button el-button--default el-button--small" onclick="selectChargeAmount(3000000);">
                                            <span>300만원</span>
                                        </button>
                                    </div>
                                </div>
                            </div> 
                            <div class="el-form-item el-form-item--small">
                                <label class="el-form-item__label" style="width: 100px;">입금자명</label>
                                <div class="el-form-item__content" style="margin-left: 100px;">
                                    <div class="el-input el-input--small">
                                        <input type="text" id="el-dialog-charge-name-id" autocomplete="off" class="el-input__inner">
                                    </div>
                                </div>
                            </div> 
                            <div class="el-row">
                                <div class="el-col el-col-24" style="text-align: right;">
                                    <button type="button" id="el-dialog-charge-perform-id" class="el-button el-button--primary">
                                        <span>충전신청</span>
                                    </button> 
                                    <button type="button" id="el-dialog-charge-cancel-id" class="el-button el-button--danger">
                                        <span>취소</span>
                                    </button>
                                </div>
                            </div>
                        </form> 
                        <div class="el-divider el-divider--horizontal"></div> 
                        <div class="el-divider el-divider--horizontal"></div> 
                        <div class="el-table el-table--fit el-table--enable-row-hover el-table--enable-row-transition el-table--small" style="/*height: 30vh;*/">
                            <!--
                            <div class="hidden-columns">
                                <div></div> <div></div> <div></div> <div></div>
                            </div>
                            
                            <div class="el-table__header-wrapper">
                                <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 781px;">
                                    <colgroup>
                                        <col name="el-table_16_column_121" width="196"><col name="el-table_16_column_122" width="195">
                                        <col name="el-table_16_column_123" width="195"><col name="el-table_16_column_124" width="195">
                                        <col name="gutter" width="0">
                                    </colgroup>
                                    <thead class="has-gutter">
                                        <tr class="">
                                            <th colspan="1" rowspan="1" class="el-table_16_column_121     is-leaf">
                                                <div class="cell">충전금</div>
                                            </th>
                                            <th colspan="1" rowspan="1" class="el-table_16_column_122     is-leaf">
                                                <div class="cell">상태</div>
                                            </th>
                                            <th colspan="1" rowspan="1" class="el-table_16_column_123     is-leaf">
                                                <div class="cell">신청시간</div>
                                            </th>
                                            <th colspan="1" rowspan="1" class="el-table_16_column_124     is-leaf">
                                                <div class="cell">처리일시</div>
                                            </th>
                                            <th class="gutter" style="width: 0px; display: none;"></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            -->
                            <div class="el-table__body-wrapper is-scrolling-none" style="height: 45vh; overflow:auto;">
                                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 100%;">
                                    <colgroup>
                                        <col name="el-table_16_column_121" width="196"><col name="el-table_16_column_122" width="195">
                                        <col name="el-table_16_column_123" width="195"><col name="el-table_16_column_124" width="195">
                                    </colgroup>
                                    <thead class="has-gutter">
                                        <tr class="">
                                            <th colspan="1" rowspan="1" class="el-table_16_column_121     is-leaf">
                                                <div class="cell">충전금</div>
                                            </th>
                                            <th colspan="1" rowspan="1" class="el-table_16_column_122     is-leaf">
                                                <div class="cell">상태</div>
                                            </th>
                                            <th colspan="1" rowspan="1" class="el-table_16_column_123     is-leaf">
                                                <div class="cell">신청시간</div>
                                            </th>
                                            <th colspan="1" rowspan="1" class="el-table_16_column_124     is-leaf">
                                                <div class="cell">처리일시</div>
                                            </th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="el-dialog-charge-data-id">
                                        <!--
                                        <tr class="el-table__row">
                                            <td rowspan="1" colspan="1" class="el-table_16_column_121  ">
                                                <div class="cell">10000</div>
                                            </td>
                                            <td rowspan="1" colspan="1" class="el-table_16_column_122  ">
                                                <div class="cell">
                                                    <span class="el-tag el-tag--success el-tag--light">확인</span>
                                                </div>
                                            </td>
                                            <td rowspan="1" colspan="1" class="el-table_16_column_123  ">
                                                <div class="cell">2021-02-01 18:54:24</div>
                                            </td>
                                            <td rowspan="1" colspan="1" class="el-table_16_column_124  ">
                                                <div class="cell">2021-02-02 21:29:07</div>
                                            </td>
                                        </tr>
                                        -->
                                    </tbody>
                                </table>
                                <div class="el-table__empty-block" id="el-dialog-charge-empty-id" style="display:flex;">
                                    <span class="el-table__empty-text">No Data</span>
                                </div>
                            </div>
                            <div class="el-table__column-resize-proxy" style="display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!--================Discharge Dialog================-->
            <div class="el-dialog__wrapper" id="el-dialog-discharge-id" style="z-index: 2029; display:none;">
                <div role="dialog" aria-modal="true" aria-label="환전신청 " class="el-dialog" style="margin-top: 5vh; width: 60%;">
                    <div class="el-dialog__header">
                        <span class="el-dialog__title">환전신청 </span>
                        <button type="button" id="el-dialog-discharge-close-id" class="el-dialog__headerbtn">
                            <i class="el-dialog__close fas fa-times"></i>
                        </button>
                    </div>
                    <div class="el-dialog__body">
                        <form class="el-form">
                            <div class="el-form-item el-form-item--small">
                                <label class="el-form-item__label" style="width: 100px;">환전신청금액</label>
                                <div class="el-form-item__content" style="margin-left: 100px;">
                                    <div class="el-input el-input--small">
                                        <input type="text" id="el-dialog-discharge-amount-id" autocomplete="off" class="el-input__inner">
                                    </div> 
                                    <div class="el-button-group">
                                        <button type="button" class="el-button el-button--default el-button--small" onclick="selectDischargeAmount(100000);">
                                            <span>10만원</span>
                                        </button>
                                        <button type="button" class="el-button el-button--default el-button--small" onclick="selectDischargeAmount(500000);">
                                            <span>50만원</span>
                                        </button> 
                                        <button type="button" class="el-button el-button--default el-button--small" onclick="selectDischargeAmount(1000000);">
                                            <span>100만원</span>
                                        </button>
                                        <button type="button" class="el-button el-button--default el-button--small" onclick="selectDischargeAmount(3000000);">
                                            <span>300만원</span>
                                        </button>
                                    </div>
                                </div>
                            </div> 
                            <div class="el-form-item el-form-item--small">
                                <label class="el-form-item__label" style="width: 100px;">은행명</label>
                                <div class="el-form-item__content" style="margin-left: 100px;">
                                    <div class="el-input el-input--small">
                                        <input type="text" id="el-dialog-discharge-bank-id" autocomplete="off" class="el-input__inner">
                                    </div>
                                </div>
                            </div> 
                            <div class="el-form-item el-form-item--small">
                                <label class="el-form-item__label" style="width: 100px;">계좌번호</label>
                                <div class="el-form-item__content" style="margin-left: 100px;">
                                    <div class="el-input el-input--small">
                                        <input type="text" id="el-dialog-discharge-number-id" autocomplete="off" class="el-input__inner">
                                    </div>
                                </div>
                            </div> 
                            <div class="el-form-item el-form-item--small">
                                <label class="el-form-item__label" style="width: 100px;">예금주</label>
                                <div class="el-form-item__content" style="margin-left: 100px;">
                                    <div class="el-input el-input--small">
                                        <input type="text" id="el-dialog-discharge-owner-id" autocomplete="off" class="el-input__inner">
                                    </div>
                                </div>
                            </div> 
                            <div class="el-row">
                                <div class="el-col el-col-24" style="text-align: right;">
                                    <button type="button" id="el-dialog-discharge-perform-id" class="el-button el-button--primary">
                                        <span>환전신청</span>
                                    </button> 
                                    <button type="button" id="el-dialog-discharge-cancel-id" class="el-button el-button--danger">
                                        <span>취소</span>
                                    </button>
                                </div>
                            </div>
                        </form> 
                        <div class="el-divider el-divider--horizontal"></div> 
                        <div class="el-table el-table--fit el-table--enable-row-hover el-table--small" style="/*height: 35vh;*/">
                            <!--
                            <div class="hidden-columns">
                                <div></div> <div></div> <div></div>
                            </div>
                            <div class="el-table__header-wrapper">
                                <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 779px;">
                                    <colgroup>
                                        <col name="el-table_17_column_125" width="261"><col name="el-table_17_column_126" width="259">
                                        <col name="el-table_17_column_127" width="259"><col name="gutter" width="0">
                                    </colgroup>
                                    <thead class="has-gutter">
                                        <tr class="">
                                            <th colspan="1" rowspan="1" class="el-table_17_column_125     is-leaf">
                                                <div class="cell">환전금</div>
                                            </th>
                                            <th colspan="1" rowspan="1" class="el-table_17_column_126     is-leaf">
                                                <div class="cell">신청시간</div>
                                            </th>
                                            <th colspan="1" rowspan="1" class="el-table_17_column_127     is-leaf">
                                                <div class="cell">처리일시</div>
                                            </th>
                                            <th class="gutter" style="width: 0px; display: none;"></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            -->
                            <div class="el-table__body-wrapper is-scrolling-none" style="height: 40vh; overflow:auto;">
                                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 100%;">
                                    <colgroup>
                                        <col name="el-table_17_column_125" width="180"><col name="el-table_17_column_126" width="180">
                                        <col name="el-table_17_column_127" width="190"><col name="el-table_17_column_127" width="190">
                                    </colgroup>
                                    <thead class="has-gutter">
                                        <tr class="">
                                            <th colspan="1" rowspan="1" class="el-table_17_column_124     is-leaf">
                                                <div class="cell">환전금</div>
                                            </th>
                                            <th colspan="1" rowspan="1" class="el-table_16_column_125     is-leaf">
                                                <div class="cell">상태</div>
                                            </th>
                                            <th colspan="1" rowspan="1" class="el-table_17_column_126     is-leaf">
                                                <div class="cell">신청시간</div>
                                            </th>
                                            <th colspan="1" rowspan="1" class="el-table_17_column_127     is-leaf">
                                                <div class="cell">처리일시</div>
                                            </th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="el-dialog-discharge-data-id">

                                    </tbody>
                                </table>
                                <div class="el-table__empty-block" id="el-dialog-discharge-empty-id" style="display:flex;">
                                    <span class="el-table__empty-text">No Data</span>
                                </div>
                            </div>
                            <div class="el-table__column-resize-proxy" style="display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!--================Mileage Dialog================-->
            <div class="el-dialog__wrapper" id="el-dialog-mileage-id" style="z-index: 2031; display:none;">
                <div role="dialog" aria-modal="true" aria-label="포인트신청" class="el-dialog" style="margin-top: 5vh; width: 60%;">
                    <div class="el-dialog__header">
                        <span class="el-dialog__title">포인트신청</span>
                        <button type="button" id="el-dialog-mileage-close-id" class="el-dialog__headerbtn">
                            <i class="el-dialog__close fas fa-times"></i>
                        </button>
                    </div>
                    <div class="el-dialog__body">
                        <form class="el-form">
                            <div class="el-form-item el-form-item--small">
                                <label class="el-form-item__label" style="width: 100px;">적립포인트</label>
                                <div class="el-form-item__content"  id="el-dialog-mileage-amount-id" style="margin-left: 100px;">
                                    
                                </div>
                            </div> 
                            <div class="el-form-item el-form-item--small">
                                <label class="el-form-item__label" style="width: 100px;">신청포인트</label>
                                <div class="el-form-item__content" style="margin-left: 100px;">
                                    <div class="el-row" style="margin-left: -2.5px; margin-right: -2.5px;">
                                        <div class="el-col el-col-21" style="padding-left: 2.5px; padding-right: 2.5px;">
                                            <div class="el-input el-input--small">
                                                <input type="number"  id="el-dialog-mileage-input-id"  autocomplete="off" class="el-input__inner">
                                            </div>
                                        </div> 
                                        <div class="el-col el-col-2" style="padding-left: 2.5px; padding-right: 2.5px;">
                                            <button type="button" class="el-button el-button--default el-button--small"  onclick="selectMileageAmount();">
                                                <span>전액</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="el-row">
                                <div class="el-col el-col-24" style="text-align: right;">
                                    <button type="button" id="el-dialog-mileage-perform-id" class="el-button el-button--primary">
                                        <span>신청완료</span>
                                    </button> 
                                    <button type="button" id="el-dialog-mileage-cancel-id" class="el-button el-button--danger">
                                        <span>취소</span>
                                    </button>
                                </div>
                            </div>
                        </form> 
                        <div class="el-divider el-divider--horizontal"></div> 
                        <div class="el-table el-table--fit el-table--enable-row-hover el-table--small" style="/*height: 30vh;*/">
                            <!--
                            <div class="hidden-columns">
                                <div></div> <div></div>
                            </div>
                            <div class="el-table__header-wrapper">
                                <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 781px;">
                                    <colgroup>
                                        <col name="el-table_18_column_128" width="391"><col name="el-table_18_column_129" width="390">
                                        <col name="gutter" width="0">
                                    </colgroup>
                                    <thead class="has-gutter">
                                        <tr class="">
                                            <th colspan="1" rowspan="1" class="el-table_18_column_128     is-leaf">
                                                <div class="cell">전환포인트</div>
                                            </th>
                                            <th colspan="1" rowspan="1" class="el-table_18_column_129     is-leaf">
                                                <div class="cell">처리일시</div>
                                            </th>
                                            <th class="gutter" style="width: 0px; display: none;"></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            -->
                            <div class="el-table__body-wrapper is-scrolling-none" style="height: 55vh; overflow:auto;">
                                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 100%;">
                                    <colgroup>
                                        <col name="el-table_18_column_128" width="391"><col name="el-table_18_column_129" width="390">
                                    </colgroup>
                                    <thead class="has-gutter">
                                        <tr class="">
                                            <th colspan="1" rowspan="1" class="el-table_18_column_128     is-leaf">
                                                <div class="cell">전환포인트</div>
                                            </th>
                                            <th colspan="1" rowspan="1" class="el-table_18_column_129     is-leaf">
                                                <div class="cell">처리일시</div>
                                            </th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="el-dialog-mileage-data-id">

                                    </tbody>
                                </table>
                                <div class="el-table__empty-block" id="el-dialog-mileage-empty-id" style="display:flex;">
                                    <span class="el-table__empty-text">No Data</span>
                                </div>
                            </div>
                            <div class="el-table__column-resize-proxy" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--================MessageBox================-->
            <div class="el-message-box__wrapper" id="el-message-box-id" style="z-index: 3032; display:none;">
                <div class="el-message-box">
                    <div class="el-message-box__header">
                        <div class="el-message-box__title" id="el-message-title-id">
                            
                        </div>
                        <button type="button" id="el-message-close-id" class="el-message-box__headerbtn">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="el-message-box__content">
                        <div class="el-message-box__status el-icon-error">
                            <i id="el-message-type-id" class=" fas fa-times-circle "></i>
                        </div>
                        <div class="el-message-box__message">
                            <p id="el-message-text-id"></p>
                        </div>
                    </div>
                    <div class="el-message-box__btns">
                        
                        <button type="button" id="el-message-ok-id" class="el-button el-button--default el-button--small el-button--primary ">
                            <span>OK</span>
                        </button>
                    </div>
                </div>
            </div>
            <!--================ConfirmMessageBox================-->
            <div class="el-message-box__wrapper" id="el-confirm-box-id"  role="dialog" style="z-index: 3033; display:none;">
                <div class="el-message-box">
                    <div class="el-message-box__header">
                        <div class="el-message-box__title" id="el-confirm-title-id">
                            
                        </div>
                        <button type="button" id="el-confirm-close-id" class="el-message-box__headerbtn">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="el-message-box__content">
                        <div class="el-message-box__status el-icon-error">
                            <i id="el-confirm-type-id" class=" fas fa-times-circle "></i>
                        </div>
                        <div class="el-message-box__message">
                            <p id="el-confirm-text-id"></p>
                        </div>
                    </div>
                    <div class="el-message-box__btns">
                        <button type="button" id="el-confirm-cancel-id" class="el-button el-button--default el-button--small">
                            <span> Cancel </span>
                        </button>
                        <button type="button" id="el-confirm-ok-id" class="el-button el-button--default el-button--small el-button--primary ">
                            <span>OK</span>
                        </button>
                    </div>
                </div>
            </div>
            <!--================AlertBox================-->
            <div class="el-alert-box__wrapper" id="el-alert-box-id" style="z-index: 3034; display:none;">
                <div class="el-alert-box">
                    <p>
                    <i id="el-alert-type-id" class=" fas fa-times-circle "></i>
                    <span id="el-alert-content-id"></span>
                    </p>
                </div>
            </div>

            <!--================Select Box================-->
            <div class="el-alert-box__wrapper" id="el-select-box-id" style="z-index: 3035; display:none;">
                <div class="el-select-dropdown el-popper" id="el-select-dropdown-id" style="display:block; min-width: 199px; transform-origin: center top; position: absolute; top: 150px; left: 394px;" x-placement="bottom-start">
                    <div class="el-scrollbar" >
                        <div class="el-select-dropdown__wrap el-scrollbar__wrap" style="margin-bottom: -17px; margin-right: -17px;">
                            <ul class="el-scrollbar__view el-select-dropdown__list" id="el-select-ul-id" style="padding-left: 0px;">
                                <!--
                                <li class="el-select-dropdown__item "><span style="float: left;">testtest1</span> <span class="item-span2">tttt</span></li>
                                <li class="el-select-dropdown__item"><span style="float: left;">test7</span> <span class="item-span2">111</span></li>
                                <li class="el-select-dropdown__item"><span style="float: left;">test9</span> <span class="item-span2">999</span></li>
                                -->
                            </ul>
                        </div>
                        <div class="el-scrollbar__bar is-horizontal"><div class="el-scrollbar__thumb" style="transform: translateX(0%);"></div></div>
                        <div class="el-scrollbar__bar is-vertical"><div class="el-scrollbar__thumb" style="transform: translateY(0%);"></div></div>
                    </div>
                    <!---->
                    <div x-arrow="" class="popper__arrow" style="left: 35px;"></div>
                </div>
            </div>



        </div>
    </div>

</body>

</html>