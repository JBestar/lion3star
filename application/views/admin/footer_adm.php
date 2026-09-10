


            </div>

            <!--================Maintain Dialog================-->
            <div class="el-dialog__wrapper" id="el-dialog-pbg-id" style="z-index: 2030; display:none;">
                <div role="dialog" aria-modal="true" aria-label="PBG등록설정" class="el-dialog" style="margin-top: 5vh; width: 40%; min-width:400px;">
                    <div class="el-dialog__header">
                        <span class="el-dialog__title">PBG등록설정</span>
                        <button type="button" id="el-dialog-pbg-close-id" class="el-dialog__headerbtn">
                            <i class="el-dialog__close fas fa-times"></i>
                        </button>
                    </div>
                    <div class="el-dialog__body">
                        <form class="el-form">
                            <div class="el-form-item">
                                <label class="el-form-item__label" style="width: 100px;">요청사이트</label>
                                <input type="text" id="el-dialog-site-id" value="" class="el-input__inner"  style="width: 300px;">
                            </div> 
                            <div class="el-form-item">
                                <label class="el-form-item__label" style="width: 100px;">아이디</label>
                                <input type="text" id="el-dialog-uid-id" value="" class="el-input__inner"  style="width: 300px;">
                            </div> 
                            <div class="el-form-item">
                                <label class="el-form-item__label" style="width: 100px;">비빌번호</label>
                                <input type="text" id="el-dialog-pwd-id" value="" class="el-input__inner" style="width: 300px;">
                            </div>
                            <div class="el-form-item">
                                <label class="el-form-item__label" style="width: 100px;">추첨동기키</label>
                                <input type="password" id="el-dialog-pbg-drawkey-id" value="" class="el-input__inner" style="width: 300px;" autocomplete="new-password" placeholder="파워볼 .env LION_DRAW_SYNC_KEY">
                            </div>
                            <div class="el-divider el-divider--horizontal"></div> 
                            <div class="el-row">
                                
                                <div class="el-col el-col-24" style="text-align: right;">
                                    <button type="button" id="el-dialog-pbg-perform-id" class="el-button el-button--primary" onclick="savePbgInfo();">
                                        <span>저장</span>
                                    </button> 
                                    <button type="button" id="el-dialog-pbg-cancel-id" class="el-button el-button--danger">
                                        <span>취소</span>
                                    </button>
                                </div>
                            </div>
                        </form> 
                        
                        
                    </div>
                </div>
            </div>

            <!--================Clean Dialog================-->
            <div class="el-dialog__wrapper" id="el-dialog-clean-id" style="z-index: 2031; display:none;">
                <div role="dialog" aria-modal="true" aria-label="데이터정리" class="el-dialog" style="margin-top: 5vh; width: 30%; min-width:400px;">
                    <div class="el-dialog__header">
                        <span class="el-dialog__title">데이터정리</span>
                        <button type="button" id="el-dialog-clean-close-id" class="el-dialog__headerbtn">
                            <i class="el-dialog__close fas fa-times"></i>
                        </button>
                    </div>
                    <div class="el-dialog__body">
                        <form class="el-form">
                            
                            <div class="el-form-item el-form-item--small">
                                <!--
                                    <label class="el-form-item__label" style="width: 100px;">정리날짜</label>
                                -->
                                <div class="el-date-editor el-range-editor el-input__inner el-date-editor--daterange"  style="float:left; width: 250px;">
                                    <i class="el-input__icon el-range__icon fa fa-calendar-alt"></i>
                                    <input type="date" id="el-dialog-clean-range-id" class="el-range-input" name="daterange" value=""  style="width: 90%;">  
                                </div>
                                <label class="el-form-item__label" style="width: 80px;">이전내역</label>
                            </div> 
                            <div class="el-divider el-divider--horizontal"></div> 
                            <div class="el-row">
                                
                                <div class="el-col el-col-24" style="text-align: right;">
                                    <button type="button" id="el-dialog-clean-perform-id" class="el-button el-button--primary" onclick="cleanDb(0);">
                                        <span>전부삭제</span>
                                    </button> 
                                    <button type="button" id="el-dialog-clean-cancel-id" class="el-button el-button--danger">
                                        <span>취소</span>
                                    </button>
                                </div>
                            </div>
                        </form> 
                        
                        
                    </div>
                </div>
            </div>

            <!--================Maintain Dialog================-->
            <div class="el-dialog__wrapper" id="el-dialog-maintain-id" style="z-index: 2032; display:none;">
                <div role="dialog" aria-modal="true" aria-label="site 점검" class="el-dialog" style="margin-top: 5vh; width: 40%; min-width:400px;">
                    <div class="el-dialog__header">
                        <span class="el-dialog__title">site 점검</span>
                        <button type="button" id="el-dialog-maintain-close-id" class="el-dialog__headerbtn">
                            <i class="el-dialog__close fas fa-times"></i>
                        </button>
                    </div>
                    <div class="el-dialog__body">
                        <form class="el-form">
                            
                            <div class="el-form-item">
                               
                                <label class="el-form-item__label" style="width: 80px;">운영상태</label>
                                <select class="el-form-item__select" id="el-dialog-maintain-select-id" style="margin-left:0px; width:200px;">
								    <option value="0">정상운영</option>
									<option value="1" selected="">점검</option>
							    </select>
                            </div> 
                            <div class="el-form-item">
                                <label class="el-form-item__label" style="width: 80px;">점검내용</label>
                                <div class="el-form-item__content" style="margin-left: 80px;">
                                    <div class="el-textarea">
                                        <textarea autocomplete="off" id="el-dialog-maintain-content-id"  class="el-textarea__inner" style="min-height: 200px;"></textarea>
                                        <!---->
                                    </div>
                                    <!---->
                                </div>
                            </div>
                            <div class="el-divider el-divider--horizontal"></div> 
                            <div class="el-row">
                                
                                <div class="el-col el-col-24" style="text-align: right;">
                                    <button type="button" id="el-dialog-maintain-perform-id" class="el-button el-button--primary" onclick="saveMaintain();">
                                        <span>저장</span>
                                    </button> 
                                    <button type="button" id="el-dialog-maintain-cancel-id" class="el-button el-button--danger">
                                        <span>취소</span>
                                    </button>
                                </div>
                            </div>
                        </form> 
                        
                        
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
            <div class="el-alert-box__wrapper" id="el-select-box-id" style="z-index: 3030; display:none;">
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