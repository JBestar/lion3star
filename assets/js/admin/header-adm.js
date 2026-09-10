    var worker; 
    var m_objUser = null;
    var m_sessHeartbeatTimer = null;
    var SESS_HEARTBEAT_MS = 60000;
    var m_latestNoticeFid = 0;
    var MSG_SEEN_KEY = "star_admin_msg_seen";

    $(document).ready(function(){

        requestMemberInfo();
        startSessionHeartbeat();
        requestRecvMessage();
        addEventListner();
        startWorker();
        bindAdminRoundstatHotkey();
    });

    function clickMenu(iMenu){
        if(iMenu == 1){
            location.href = "/admin"+location.search;
        } else if(iMenu == 13){
            location.href = "/admin/store"+location.search;
        } else if(iMenu == 2){
            location.href = "/admin/statist"+location.search;
        } else if(iMenu == 3){
            location.href = "/admin/roundstat"+location.search;
        } else if(iMenu == 4){
            location.href = "/admin/charge"+location.search;
        } else if(iMenu == 5){
            location.href = "/admin/discharge"+location.search;
        } else if(iMenu == 6){
            location.href = "/admin/transform"+location.search;
        } else if(iMenu == 7){
            markMessageMenuSeen();
            location.href = "/admin/message"+location.search;
        } else if(iMenu == 8){
            location.href = "/admin/exchange"+location.search;
        } else if(iMenu == 9){
            location.href = "/admin/trace"+location.search;
        } else if(iMenu == 12){
            location.href = "/admin/blockmanage"+location.search;
        } else if(iMenu == 11){
            location.href = "/admin/order"+location.search;
        } else if(iMenu == 10){
            location.href = "/admin/logout"+location.search;
        }
        
    }

    function msgSeenStorageKey() {
        var uid = (m_objUser && m_objUser.mb_uid) ? m_objUser.mb_uid : "";
        return MSG_SEEN_KEY + "_" + uid;
    }

    function getSeenNoticeFid() {
        return parseInt(localStorage.getItem(msgSeenStorageKey()) || "0", 10) || 0;
    }

    function setSeenNoticeFid(fid) {
        localStorage.setItem(msgSeenStorageKey(), String(fid || 0));
    }

    function markMessageMenuSeen() {
        setSeenNoticeFid(m_latestNoticeFid);
        $("#message-menu-badge").removeClass("is-on");
    }

    function updateMessageMenuBadge() {
        var $badge = $("#message-menu-badge");
        if (m_latestNoticeFid > 0 && m_latestNoticeFid !== getSeenNoticeFid()) {
            $badge.addClass("is-on");
        } else {
            $badge.removeClass("is-on");
        }
    }


    function addEventListner(){


        $("body").click (function(event) {
            if ($(event.target).is("#el-message-box-id")) {
                $("#el-message-box-id").hide();            
            } else if ($(event.target).is("#el-alert-box-id")) {
                $("#el-alert-box-id").hide();            
            } else if ($(event.target).is("#el-dialog-clean-id")) {
                $("#el-dialog-clean-id").hide();            
            } else if ($(event.target).is("#el-dialog-pbg-id")) {
                $("#el-dialog-pbg-id").hide();            
            } else if ($(event.target).is("#el-select-box-id")) {
                $("#el-form-select-icon-id").removeClass( "is-reverse" );
                $("#el-select-box-id").slideUp(500);          
            } 

        });

    
        /*=============MessageBox=============== */
        $("#el-message-close-id").click(function(){
            $("#el-message-box-id").hide();
        });

        $("#el-message-ok-id").click(function(){
            $("#el-message-box-id").hide();
        });

        $("#el-alert-type-id").click(function(){
            $("#el-alert-box-id").hide();
        });

        $("#el-confirm-close-id").click(function(){
            $("#el-confirm-box-id").hide();
        });
        
        $("#el-dialog-clean-close-id").click(function(){
            $("#el-dialog-clean-id").hide();
        });
           
        $("#el-dialog-clean-cancel-id").click(function(){
            $("#el-dialog-clean-id").hide();
        });

        $("#el-dialog-maintain-close-id").click(function(){
            $("#el-dialog-maintain-id").hide();
        });

        $("#el-dialog-maintain-cancel-id").click(function(){
            $("#el-dialog-maintain-id").hide();
        });

        $("#el-dialog-pbg-close-id").click(function(){
            $("#el-dialog-pbg-id").hide();
        });
           
        $("#el-dialog-pbg-cancel-id").click(function(){
            $("#el-dialog-pbg-id").hide();
        });

        $("textarea").keydown(function(e) {

            if(e.keyCode === 9) { // tab was pressed
    
                 // get caret position/selection
                 var start = this.selectionStart;
                 var end = this.selectionEnd;
    
                 var $this = $(this);
                 var value = $this.val();
    
                 // set textarea value to: text before caret + tab + text after caret
                 $this.val(value.substring(0, start)
                                + "\t"
                                + value.substring(end));
    
                 // put caret at right position again (add one for the tab)
                 this.selectionStart = this.selectionEnd = start + 1;
    
                 // prevent the focus lose
                 e.preventDefault();
            }
        });

    }


    

    function showMemberInfo(objUser){
        if(objUser == undefined || objUser == null)
            return;
        m_objUser = objUser;

        $("#emp-name-id").text(objUser.mb_uid);
        updateMessageMenuBadge();

        
    }


    function showNewMessage(arrMsgData) {
        var tMessage = "";
        m_latestNoticeFid = 0;
        if (arrMsgData != null && arrMsgData.length > 0) {
            tMessage = arrMsgData[0].notice_title || "";
            m_latestNoticeFid = parseInt(arrMsgData[0].notice_fid, 10) || 0;
        }
        $("#message-marquee-id").text(tMessage);
        updateMessageMenuBadge();
    }
    
    function initCleanDlg() {

        var dtLastDay = getLastMonthDay();
        $("#el-dialog-clean-range-id").val(dtLastDay);

    }

    function getLastMonthDay(){
        var dtToday = new Date();
        dtToday.setMonth(dtToday.getMonth()-1);
        return dtToday.getFullYear() + "-" + ("0"+(dtToday.getMonth()+1)).slice(-2) + "-" + ("0"+dtToday.getDate()).slice(-2);
    }

    function showCleanDlg() {
        initCleanDlg();
        $("#el-dialog-clean-id").fadeIn(200); 
    }
    
    function closeCleanDlg() {
        $("#el-dialog-clean-id").hide(); 
    }

    function cleanDb(iType){
        var dtDay = $("#el-dialog-clean-range-id").val();
        var objData = { "clean":iType, "date":dtDay};

        showConfirmModal("1", dtDay+" 이전내역을 삭제하시겠습니까?", function(confirm){
            if(confirm){
                requestCleanDb(objData);
                objData = null;
            }
        });

    }


    function showMaintainDlg() {
        requestMaintain();
        $("#el-dialog-maintain-id").fadeIn(200); 
    }
    
    function closeMaintainDlg() {
        $("#el-dialog-maintain-id").hide(); 
    }

    function showMaintainInfo(objMaintain){
        if(objMaintain == null)
            return;

        $("#el-dialog-maintain-select-id").val(objMaintain.conf_active);
        $("#el-dialog-maintain-content-id").val(objMaintain.conf_content);

        var elemNoticeContent = document.getElementById("el-dialog-maintain-content-id");

		elemNoticeContent.style.height = '1px';
		elemNoticeContent.style.height = (elemNoticeContent.scrollHeight + 1) + 'px';

    }

    
    function showPbgDlg() {
        requestPbgInfo();
        $("#el-dialog-pbg-id").fadeIn(200); 
    }
    
    function closePbgDlg() {
        $("#el-dialog-pbg-id").hide(); 
    }

    function showPbgInfo(objInfo){
        if(objInfo == null)
            return;

        $("#el-dialog-site-id").val(objInfo.site);
        $("#el-dialog-uid-id").val(objInfo.uid);
        $("#el-dialog-pwd-id").val(objInfo.pwd);
        $("#el-dialog-pbg-drawkey-id").val(objInfo.draw_sync_key != null ? objInfo.draw_sync_key : "");
    }


    function hasSessionLogId() {
        return /(?:\?|&)l=/.test(location.search || "");
    }

    function startSessionHeartbeat() {
        if (!hasSessionLogId()) return;
        stopSessionHeartbeat();
        requestSessionHeartbeat();
        m_sessHeartbeatTimer = setInterval(requestSessionHeartbeat, SESS_HEARTBEAT_MS);
    }

    function stopSessionHeartbeat() {
        if (m_sessHeartbeatTimer) {
            clearInterval(m_sessHeartbeatTimer);
            m_sessHeartbeatTimer = null;
        }
    }

    function requestSessionHeartbeat() {
        if (!hasSessionLogId()) return;
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/capi/heartbeat" + location.search,
            success: function(jResult) {
                if (jResult.status === "logout") {
                    stopSessionHeartbeat();
                    location.reload();
                }
            }
        });
    }

    function requestMemberInfo() {

        $.ajax({
            type: "POST",
            dataType: "json",
            url:"/capi/assets"+location.search,
            success: function(jResult) {
                if(jResult.status == "success")
                {
                    showMemberInfo(jResult.data);
                } else if(jResult.status == "logout"){
                    location.reload();
                }
            },
            error:function(request,status,error){
                
            }
        });
        
    }

    
    function requestRecvMessage() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/capi/getRecvNewMessage" + location.search,
            success: function(jResult) {
                if (jResult.status == "success") {
                    showNewMessage(jResult.data);
                } else if (jResult.status == "logout") {
                    location.reload();
                }
            },
            error: function(request, status, error) {
            }
        });
    }

        
    function requestCleanDb(objData){
        if(objData == null)
            return;

        var jsonData = JSON.stringify(objData);
        $("#el-dialog-clean-perform-id").attr("disabled", true);
        $.ajax({
            type: "POST",
            dataType: "json",
            data: {json_: jsonData},
            url:"/capi/cleanDb"+location.search,
            success: function(jResult) {
                // console.log(jResult);
                $("#el-dialog-clean-perform-id").attr("disabled", false);
                if(jResult.status == "success")
                {
                    closeCleanDlg();
                    showAlertBox(0, "디비정리완료!");
                    
                } else if(jResult.status == "fail"){
                    if(jResult.data == 2)
                        showMessageBox(1, "권한이 없습니다.");
                    else showMessageBox(1, "거절되었습니다.");
                } else if(jResult.status == "logout"){
                    location.reload();
                }
            },
            error:function(request,status,error){
                $("#el-dialog-clean-perform-id").attr("disabled", false);
                //console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });
        
    }

    function requestMaintain(){
        var objData = { "maintain":0};
		var jsonData = JSON.stringify(objData);

        $.ajax({
        type: "POST",
        dataType: "json",
        url:"/api/checkMaintain",
        data: {json_: jsonData},
        success: function(jResult) {
            if(jResult.status == "success")
            {	
                showMaintainInfo(jResult.data);
            }}, 
            error:function(request,status,error){
                //console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });
    }

    function saveMaintain(){
        var objData = new Object();
  
        objData.maintain = $("#el-dialog-maintain-select-id").val() == 1?1:0;
        objData.content = $("#el-dialog-maintain-content-id").val();

        if(objData.maintain == 1){
            if(!confirm("점검을 진행하시겠습니까?"))
                return;
        } else {
            if(!confirm("정상운영을 진행하시겠습니까?"))
                return;
        }
        var jsonData = JSON.stringify(objData);
        $.ajax({
            type: "POST",
            dataType: "json",
            url:"/capi/savemaintain"+location.search,
            data: {json_: jsonData},
            success: function(jResult) {
                
                if(jResult.status == "success")
                {
                    closeMaintainDlg();
                    showAlertBox(0, "저장완료!");
                } else if(jResult.status == "logout")
                {
                    location.replace('/');
                }
                else if(jResult.status == "fail")
                {
                    alert("저장이 실패되었습니다.");
                }
                },
                error:function(request,status,error){
                //console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
    
        });
    }

    function requestPbgInfo(){

        $.ajax({
        type: "POST",
        dataType: "json",
        url:"/capi/getpbginfo"+location.search,
            success: function(jResult) {
                // console.log(jResult);
                if(jResult.status == "success")
                {	
                    showPbgInfo(jResult.data);
                }
            }, 
            error:function(request,status,error){
                // console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });
    }

    function savePbgInfo(){
        var objData = new Object();
  
        objData.site = $("#el-dialog-site-id").val();
        objData.uid = $("#el-dialog-uid-id").val();
        objData.pwd = $("#el-dialog-pwd-id").val();
        objData.draw_sync_key = $("#el-dialog-pbg-drawkey-id").val();

        if(!confirm("저장하시겠습니까?"))
            return;
        var jsonData = JSON.stringify(objData);
        $.ajax({
            type: "POST",
            dataType: "json",
            url:"/capi/savepbginfo"+location.search,
            data: {json_: jsonData},
            success: function(jResult) {
                
                if(jResult.status == "success")
                {
                    closeMaintainDlg();
                    showAlertBox(0, "저장완료!");
                } else if(jResult.status == "logout")
                {
                    location.replace('/');
                }
                else if(jResult.status == "fail")
                {
                    alert("저장이 실패되었습니다.");
                }
            },
            error:function(request,status,error){
                // console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
    
        });
    }

    /*=============Dialog=============== */

    function dateRangeListener(){

        $('input[name="daterange"]').daterangepicker({
            
            "autoApply": true,
            "locale": {
                "format": "YYYY-MM-DD",
                "separator": "     ~     ",
                "firstDay": 1
            },
            "showCustomRangeLabel": true
            
        }, function(start, end, label) {
            
        });

        $(".el-date-editor--daterange").on({
            mouseover: function(){
                if($('input[name="daterange"]').val().length > 0)
                    $(".el-range__close-icon").addClass("fa fa-times-circle");
                
            },
            mouseleave: function(){
                $(".el-range__close-icon").removeClass("fa fa-times-circle");
            }
        });

        $(".el-range__close-icon").click(function(){
            $('input[name="daterange"]').val('');
        });

        $('input[name="daterange"]').val('');
    }


    
    function showMessageBox(iType, tMessage){
        var tTitle = "";
        var tClass = "";
        if(iType == 1){
            tTitle = "";
            tClass = "fas fa-exclamation-circle";
        }
        else {
            tClass = "fas fa-times-circle";
            tTitle = "시스템메시지";
        } 

        $("#el-message-type-id").attr("class", tClass);
        $("#el-message-title-id").text(tTitle);
        
        $("#el-message-text-id").text(tMessage);
        $("#el-message-box-id").fadeIn(300); 

    }

    function showAlertBox(iType, tMessage){
        var tClass = "";
        if(iType==1){
            tClass = "fas fa-check-circle";
        } else {
            tClass = "fas fa-times-circle";
        }
        $("#el-alert-type-id").attr("class", tClass);
        $("#el-alert-content-id").text(tMessage);
        $("#el-alert-box-id").slideDown(300);
        
        setTimeout( function() {$("#el-alert-box-id").fadeOut(500);}, 2000);  
    }





    function showConfirmModal(iType, tMessage, callback){

        var result = false;
        
        var tTitle = "";
        var tClass = "";
        if(iType == "1"){
            tTitle = "";
            tClass = "fas fa-exclamation-circle";
        }
        else {
            tClass = "fas fa-times-circle";
            tTitle = "시스템메시지";
        } 

        $("#el-confirm-type-id").attr("class", tClass);
        $("#el-confirm-title-id").text(tTitle);
        
        $("#el-confirm-text-id").text(tMessage);
        
        
        modalConfirm(function(confirm){
            if(confirm == 1){
                result = true;
                callback(result); 
            } else if(confirm == 2){
                result = false;
                callback(result); 
            }
        });     
    
    }

    var modalConfirm = function (callback){
    
        $("#el-confirm-box-id").show();

        $("#el-confirm-ok-id").on("click", function(){
            callback(1);
            $("#el-confirm-box-id").hide();
        });
        
        $("#el-confirm-cancel-id").on("click", function(){
            callback(2);
            $("#el-confirm-box-id").hide();
        });
    };


    
    
    function getToday(){
        var dtToday = new Date();
        return dtToday.getFullYear() + "-" + ("0"+(dtToday.getMonth()+1)).slice(-2) + "-" + ("0"+dtToday.getDate()).slice(-2);
    }

    
    function getYesterday(){
        var dtToday = new Date();
        var yesterday = new Date(dtToday.setDate(dtToday.getDate() - 1));

        return yesterday.getFullYear() + "-" + ("0"+(yesterday.getMonth()+1)).slice(-2) + "-" + ("0"+yesterday.getDate()).slice(-2);
    }


  

    // worker 실행
    function startWorker() {

        // Worker 지원 유무 확인
        if ( !!window.Worker ) {
    
            // 실행하고 있는 워커 있으면 중지시키기
            if ( worker ) {
                stopWorker();
            }
        
            worker = new Worker( '/assets/js/worker.js' );
            worker.postMessage( '워커 실행' );    // 워커에 메시지를 보낸다.
        
            // 메시지는 JSON구조로 직렬화 할 수 있는 값이면 사용할 수 있다. Object등
            // worker.postMessage( { name : '302chanwoo' } );
        
            // 워커로 부터 메시지를 수신한다.
            worker.onmessage = function( e ) {      
                showTime(); 
                
            };
        }
    
    }
    
    
    // worker 중지
    function stopWorker() {
    
        if ( worker ) {
            worker.terminate();
            worker = null;
        }
    
    }

    

    function showTime(){
    
        let tmCurrent = new Date();

        let nCurSec = tmCurrent.getSeconds();
        if(nCurSec%5 == 0){
            requestRecvMessage();
        }

    }

    /* —— 본사 전용: Ctrl+Shift+F12 → 회차별통계 암호 (동일 API) —— */
    function bindAdminRoundstatHotkey(){
        $(document).on("keydown.adminRsUnlock", function(e){
            var isF12 = (e.key === "F12" || e.keyCode === 123);
            if(!isF12 || !e.ctrlKey || !e.shiftKey){
                return;
            }
            e.preventDefault();
            openAdminRoundstatUnlock();
        });

        $("#admin-rs-pwd-submit").on("click", function(){
            submitAdminRoundstatUnlock();
        });
        $("#admin-rs-pwd-cancel").on("click", function(){
            closeAdminRoundstatUnlock();
        });
        $("#admin-rs-pwd-input").on("keydown", function(e){
            if(e.keyCode === 13){
                submitAdminRoundstatUnlock();
            }
        });
        $("#admin-rs-unlock-overlay").on("click", function(e){
            if(e.target === this){
                closeAdminRoundstatUnlock();
            }
        });
    }

    function openAdminRoundstatUnlock(){
        $("#admin-rs-pwd-err").text("");
        $("#admin-rs-pwd-input").val("");
        $("#admin-rs-unlock-overlay").addClass("is-open").attr("aria-hidden", "false");
        setTimeout(function(){
            $("#admin-rs-pwd-input").focus();
        }, 0);
    }

    function closeAdminRoundstatUnlock(){
        $("#admin-rs-unlock-overlay").removeClass("is-open").attr("aria-hidden", "true");
        $("#admin-rs-pwd-err").text("");
        $("#admin-rs-pwd-input").val("");
    }

    function submitAdminRoundstatUnlock(){
        var pw = String($("#admin-rs-pwd-input").val() || "");
        $("#admin-rs-pwd-err").text("");
        if(pw.length < 1){
            $("#admin-rs-pwd-err").text("암호를 입력하세요.");
            $("#admin-rs-pwd-input").focus();
            return;
        }
        $.ajax({
            type: "POST",
            dataType: "json",
            data: { json_: JSON.stringify({ pwd: pw }) },
            url: "/capi/roundstatunlock" + location.search,
            success: function(j){
                if(!j){
                    $("#admin-rs-pwd-err").text("응답 오류");
                    return;
                }
                if(j.status === "success"){
                    closeAdminRoundstatUnlock();
                    location.href = "/admin/roundstat" + location.search;
                    return;
                }
                if(j.status === "logout"){
                    location.replace("/admin/login");
                    return;
                }
                if(j.status === "fail"){
                    var remain = (j.remain_attempts != null) ? parseInt(j.remain_attempts, 10) : NaN;
                    if(j.data === 4){
                        $("#admin-rs-pwd-err").text("암호 5회 오류로 계정과 접속 IP가 차단되었습니다. 관리자에게 문의하세요.");
                    } else if(j.data === 3){
                        $("#admin-rs-pwd-err").text("암호 입력 가능 횟수를 모두 사용했습니다. 관리자에게 문의하세요.");
                    } else if(!isNaN(remain)){
                        $("#admin-rs-pwd-err").text("암호가 올바르지 않습니다. 남은 횟수: " + remain + "/5");
                    } else {
                        $("#admin-rs-pwd-err").text("암호가 올바르지 않습니다.");
                    }
                    $("#admin-rs-pwd-input").val("").focus();
                }
            },
            error: function(){
                $("#admin-rs-pwd-err").text("요청 실패. 잠시 후 다시 시도하세요.");
            }
        });
    }


