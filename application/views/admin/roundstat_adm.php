<main class="el-main" data-roundstat-unlocked="<?= !empty($roundstat_unlocked) ? '1' : '0' ?>">

    <!-- 암호 잠금 -->
    <div id="roundstat-lock-overlay" class="roundstat-lock-overlay"<?= !empty($roundstat_unlocked) ? ' style="display:none;"' : '' ?>>
        <div class="roundstat-lock-dialog">
            <div class="roundstat-lock-title">회차별 통계</div>
            <p class="roundstat-lock-desc">비밀번호를 입력하세요.</p>
            <input type="password" id="roundstat-pwd-input" class="roundstat-lock-input el-input__inner" autocomplete="off" />
            <div class="roundstat-lock-actions">
                <button type="button" class="el-button el-button--primary" id="roundstat-pwd-submit"><span>확인</span></button>
                <button type="button" class="el-button el-button--default" id="roundstat-pwd-cancel"><span>취소</span></button>
            </div>
            <div id="roundstat-pwd-err" class="roundstat-pwd-err"></div>
        </div>
    </div>

    <!-- 본문 (잠금 해제 후 표시) -->
    <div id="roundstat-main-panel"<?= !empty($roundstat_unlocked) ? '' : ' style="display:none;"' ?>>
        <div class="roundstat-titlebar">
            <span class="roundstat-titlebar-text">회차별 통계</span>
            <button type="button" class="roundstat-titlebar-close" id="roundstat-panel-close" title="닫기" aria-label="닫기">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="roundstat-toolbar">
            <div class="roundstat-toolbar-left">
                <span id="roundstat-live-clock" class="roundstat-live-clock">—:—:—</span>
                <span id="roundstat-round-line" class="roundstat-round-line">진행회차 —</span>
                <span id="roundstat-countdown" class="roundstat-countdown">[—:—]</span>
                <span class="roundstat-drawchange-wrap">
                    <button type="button" id="roundstat-drawchange-btn" class="el-button el-button--mini roundstat-drawchange-btn roundstat-drawchange-btn--locked" disabled><span>추첨변경</span></button>
                    <span id="roundstat-queued-cond" class="roundstat-queued-cond" aria-live="polite"></span>
                </span>
            </div>
            <button type="button" class="el-button el-button--mini el-button--default roundstat-chgpwd-at-end" onclick="admRoundstatChgPwdDlg();"><span>암호변경</span></button>
        </div>

        <div class="el-divider el-divider--horizontal"></div>

        <div class="el-table el-table--fit el-table--small el-table--enable-row-hover roundstat-table-shell">
            <div class="el-table__body-wrapper is-scrolling-none">
                <table class="el-table__body roundstat-table" cellspacing="0" cellpadding="0" border="0">
                    <colgroup>
                        <col class="roundstat-col-game" />
                        <col class="roundstat-col-round" />
                        <col /><col /><col /><col /><col /><col /><col /><col />
                    </colgroup>
                    <thead>
                        <tr>
                            <th><div class="cell">게임</div></th>
                            <th><div class="cell">회차</div></th>
                            <th data-rsk="pb_holu" class="roundstat-selectable-th"><div class="cell">파워볼홀</div></th>
                            <th data-rsk="pb_jjak" class="roundstat-selectable-th"><div class="cell">파워볼짝</div></th>
                            <th data-rsk="pb_under" class="roundstat-selectable-th"><div class="cell">파워볼언더</div></th>
                            <th data-rsk="pb_over" class="roundstat-selectable-th"><div class="cell">파워볼오버</div></th>
                            <th data-rsk="nb_holu" class="roundstat-selectable-th"><div class="cell">일반볼홀</div></th>
                            <th data-rsk="nb_jjak" class="roundstat-selectable-th"><div class="cell">일반볼짝</div></th>
                            <th data-rsk="nb_under" class="roundstat-selectable-th"><div class="cell">일반볼언더</div></th>
                            <th data-rsk="nb_over" class="roundstat-selectable-th"><div class="cell">일반볼오버</div></th>
                        </tr>
                    </thead>
                    <tbody id="roundstat-tbody-id"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 암호 변경 -->
    <div class="el-dialog__wrapper" id="roundstat-chgpwd-dialog" style="display:none; z-index:2500;">
        <div class="el-dialog roundstat-mini-dialog">
            <div class="el-dialog__header">
                <span class="el-dialog__title">암호변경</span>
                <button type="button" class="el-dialog__headerbtn" onclick="$('#roundstat-chgpwd-dialog').hide();"><i class="el-dialog__close fas fa-times"></i></button>
            </div>
            <div class="el-dialog__body">
                <div class="el-form-item">
                    <label class="el-form-item__label" style="width:100px;">현재 암호</label>
                    <input type="password" id="roundstat-chgpwd-old" class="el-input__inner" style="width:220px;" autocomplete="off" />
                </div>
                <div class="el-form-item">
                    <label class="el-form-item__label" style="width:100px;">새 암호</label>
                    <input type="password" id="roundstat-chgpwd-new" class="el-input__inner" style="width:220px;" autocomplete="off" />
                </div>
            </div>
            <div class="el-dialog__footer">
                <button type="button" class="el-button el-button--primary" onclick="admRoundstatSavePwd();"><span>저장</span></button>
            </div>
        </div>
    </div>

</main>

<script src="<?php echo base_url('assets/js/admin/roundstat-adm.js?v=3'); ?>"></script>
