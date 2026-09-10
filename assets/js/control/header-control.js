    var worker;
    var m_objUser = null;
    var m_sessHeartbeatTimer = null;
    var SESS_HEARTBEAT_MS = 60000;

    $(document).ready(function() {

        requestMemberInfo();
        startSessionHeartbeat();
        requestRecvMessage();
        requestWaitTransfer();
        addEventListner();
        startWorker();
    });


    function clickMenu(iMenu) {
        if (iMenu == 1) {
            location.href = "/ctrl" + location.search;
        } else if (iMenu == 2) {
            location.href = "/ctrl/statist" + location.search;
        } else if (iMenu == 3) {
            location.href = "/ctrl/charge" + location.search;
        } else if (iMenu == 4) {
            location.href = "/ctrl/discharge" + location.search;
        } else if (iMenu == 5) {
            location.href = "/ctrl/transform" + location.search;
        } else if (iMenu == 6) {
            location.href = "/ctrl/transform2" + location.search;
        } else if (iMenu == 7) {
            location.href = "/ctrl/message" + location.search;
        } else if (iMenu == 8) {
            location.href = "/ctrl/cancel" + location.search;
        } else if (iMenu == 9) {
            location.href = "/ctrl/logout" + location.search;
        }

    }

    function addEventListner() {


        $("body").click(function(event) {
            if ($(event.target).is("#el-message-box-id")) {
                $("#el-message-box-id").hide();
            } else if ($(event.target).is("#el-alert-box-id")) {
                $("#el-alert-box-id").hide();
            } else if ($(event.target).is("#el-dialog-charge-id")) {
                $("#el-dialog-charge-id").hide();
            } else if ($(event.target).is("#el-dialog-discharge-id")) {
                $("#el-dialog-discharge-id").hide();
            } else if ($(event.target).is("#el-dialog-mileage-id")) {
                $("#el-dialog-mileage-id").hide();
            } else if ($(event.target).is("#el-select-box-id")) {
                $("#el-form-select-icon-id").removeClass("is-reverse");
                $("#el-select-box-id").slideUp(500);
            }

        });

        /*=============ChargeDlg=============== */
        $("#el-dialog-charge-close-id").click(function() {
            $("#el-dialog-charge-id").hide();
        });

        $("#el-dialog-charge-perform-id").click(function() {
            requestCharge();
        });

        $("#el-dialog-charge-cancel-id").click(function() {
            $("#el-dialog-charge-id").hide();
        });

        /*=============DischargeDlg=============== */
        $("#el-dialog-discharge-close-id").click(function() {
            $("#el-dialog-discharge-id").hide();
        });
        $("#el-dialog-discharge-perform-id").click(function() {
            requestDischarge();
        });

        $("#el-dialog-discharge-cancel-id").click(function() {
            $("#el-dialog-discharge-id").hide();
        });

        /*=============MileageDlg=============== */
        $("#el-dialog-mileage-close-id").click(function() {
            $("#el-dialog-mileage-id").hide();
        });
        $("#el-dialog-mileage-perform-id").click(function() {
            requestMileage();
        });

        $("#el-dialog-mileage-cancel-id").click(function() {
            $("#el-dialog-mileage-id").hide();
        });


        /*=============MessageBox=============== */
        $("#el-message-close-id").click(function() {
            $("#el-message-box-id").hide();
        });

        $("#el-message-ok-id").click(function() {
            $("#el-message-box-id").hide();
        });

        $("#el-alert-type-id").click(function() {
            $("#el-alert-box-id").hide();
        });

        $("#el-confirm-close-id").click(function() {
            $("#el-confirm-box-id").hide();
        });



    }



    function showMemberInfo(objUser) {
        if (objUser == undefined || objUser == null)
            return;
        m_objUser = objUser;

        $("#emp-name-id").text(objUser.mb_uid);
        $("#emp-money-id").text(parseInt(objUser.mb_money).toLocaleString());
        $("#emp-mileage-id").text(parseInt(objUser.mb_point).toLocaleString());
        var ratio = objUser.mb_game_pb_ratio;
        var ratioText = (ratio == null) ? "0" : String(ratio);
        if (ratioText.indexOf("%") < 0) {
            ratioText = ratioText + "%";
        }
        $("#emp-ratio-id").text(ratioText);


    }


    function showNewMessage(arrMsgData) {
        var tMessage = "";
        if (arrMsgData != null && arrMsgData.length > 0) {
            tMessage = arrMsgData[0].notice_title;
            if (m_objUser != null) {
                speak(m_objUser.mb_uid, { rate: 1, pitch: 1.2 });
            }
            setTimeout(function() { speak("새 메시지가 도착하엿습니다.", { rate: 1, pitch: 1.2 }); }, 1000);

        }
        $("#message-marquee-id").text(tMessage);
    }

    function showWaitTansfer(arrTransfer) {
        if (arrTransfer == null || arrTransfer.length != 2)
            return;

        if (arrTransfer[0] > 0) {
            speak("사랑합니다.", { rate: 1, pitch: 1.2 });
        } else if (arrTransfer[1] > 0) {
            speak("미안합니다.", { rate: 1, pitch: 1.2 });
        }


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
            url: "/bapi/heartbeat" + location.search,
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
            url: "/bapi/assets" + location.search,
            success: function(jResult) {
                //console.log(jResult);
                if (jResult.status == "success") {
                    showMemberInfo(jResult.data);
                } else if (jResult.status == "logout") {
                    location.reload();
                }
            },
            error: function(request, status, error) {
                //console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });

    }

    function requestCharge() {
        var tName = $("#el-dialog-charge-name-id").val();
        var nAmount = $("#el-dialog-charge-amount-id").val();

        if (nAmount.lenth < 1 || nAmount < 1) {
            showMessageBox(1, "금액을 입력해주세요");
            return;
        }
        if (tName.length < 1) {
            showMessageBox(1, "입금자를 입력해주세요");
            return;
        }

        var objData = { "charge_name": tName, "charge_amount": nAmount };
        var jsonData = JSON.stringify(objData);

        $.ajax({
            type: "POST",
            dataType: "json",
            data: { json_: jsonData },
            url: "/bapi/charge" + location.search,
            success: function(jResult) {

                if (jResult.status == "success") {
                    $("#el-dialog-charge-id").hide();
                    initChargeDlg();
                    showAlertBox(0, "신청완료!");
                } else if (jResult.status == "wait") {
                    showMessageBox(1, "충전신청 대기중입니다.");
                } else if (jResult.status == "fail") {
                    showMessageBox(1, "신청이 거절되었습니다.");
                } else if (jResult.status == "logout") {
                    location.reload();
                }
            },
            error: function(request, status, error) {

            }
        });
    }


    function requestChargeHistory() {
        var objData = { "charge_type": 0 };
        var jsonData = JSON.stringify(objData);

        $.ajax({
            type: "POST",
            dataType: "json",
            data: { json_: jsonData },
            url: "/bapi/chargehistory" + location.search,
            success: function(jResult) {

                if (jResult.status == "success") {
                    showChargeDlgData(jResult.data);
                } else if (jResult.status == "logout") {
                    location.reload();
                }
            },
            error: function(request, status, error) {

            }
        });

    }


    function requestDischarge() {
        var nAmount = $("#el-dialog-discharge-amount-id").val();
        var tBank = $("#el-dialog-discharge-bank-id").val();
        var tOwner = $("#el-dialog-discharge-owner-id").val();
        var tNumber = $("#el-dialog-discharge-number-id").val();

        if (nAmount.lenth < 1 || nAmount < 1) {
            showMessageBox(1, "금액을 입력해주세요");
            return;
        }
        if (parseInt(nAmount) > parseInt(m_objUser.mb_money)) {
            showMessageBox(1, "보유금액을 초과하셧습니다.");
            return;
        }
        if (tBank.length < 1 || tOwner.length < 1 || tNumber.length < 1) {
            showMessageBox(1, "은행정보를 입력해주세요");
            return;
        }

        var objData = {
            "discharge_amount": nAmount,
            "discharge_bank": tBank,
            "discharge_owner": tOwner,
            "discharge_number": tNumber,
        };
        var jsonData = JSON.stringify(objData);

        $.ajax({
            type: "POST",
            dataType: "json",
            data: { json_: jsonData },
            url: "/bapi/discharge" + location.search,
            success: function(jResult) {
                //console.log(jResult.data);
                if (jResult.status == "success") {
                    $("#el-dialog-discharge-id").hide();
                    initDischargeDlg();
                    showAlertBox(0, "신청완료!");
                } else if (jResult.status == "fail") {
                    if (jResult.data == 4)
                        showMessageBox(1, "환전신청 대기중입니다.");
                    else if (jResult.data == 5)
                        showMessageBox(1, "보유머니를 초과하셧습니다.");
                    else if (jResult.data == 6)
                        showMessageBox(1, "환전신청 최소금액은 10,000원입니다.");
                    else showMessageBox(1, "신청이 거절되엇습니다.");

                } else if (jResult.status == "logout") {
                    location.reload();
                }
            },
            error: function(request, status, error) {

            }
        });
    }


    function requestDischargeHistory() {
        var objData = { "discharge_type": 0 };
        var jsonData = JSON.stringify(objData);

        $.ajax({
            type: "POST",
            dataType: "json",
            data: { json_: jsonData },
            url: "/bapi/dischargehistory" + location.search,
            success: function(jResult) {

                if (jResult.status == "success") {
                    showDischargeDlgData(jResult.data);
                } else if (jResult.status == "logout") {
                    location.reload();
                }
            },
            error: function(request, status, error) {

            }
        });

    }

    function requestMileage() {
        var nAmount = $("#el-dialog-mileage-input-id").val();

        if (nAmount.lenth < 1 || nAmount < 1) {
            showMessageBox(1, "금액을 입력해주세요");
            return;
        }
        if (nAmount > parseInt(m_objUser.mb_point)) {
            showMessageBox(1, "적립액을 초과하셧습니다.");
            return;
        }
        var objData = { "mileage": nAmount };
        var jsonData = JSON.stringify(objData);

        $.ajax({
            type: "POST",
            dataType: "json",
            data: { json_: jsonData },
            url: "/bapi/mileage" + location.search,
            success: function(jResult) {
                // console.log(jResult);
                if (jResult.status == "success") {
                    $("#el-dialog-mileage-id").hide();
                    initMileageDlg();
                    showAlertBox(0, "신청완료!");
                    requestMemberInfo();
                } else if (jResult.status == "fail") {
                    showMessageBox(1, "신청이 거절되었습니다.");
                } else if (jResult.status == "logout") {
                    location.reload();
                }
            },
            error: function(request, status, error) {

            }
        });
    }


    function requestMileageHistory() {
        var objData = { "mileage_type": 0 };
        var jsonData = JSON.stringify(objData);

        $.ajax({
            type: "POST",
            dataType: "json",
            data: { json_: jsonData },
            url: "/bapi/mileagehistory" + location.search,
            success: function(jResult) {

                if (jResult.status == "success") {
                    showMileageDlgData(jResult.data);
                } else if (jResult.status == "logout") {
                    location.reload();
                }
            },
            error: function(request, status, error) {

            }
        });

    }



    function requestRecvMessage() {

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/bapi/getRecvNewMessage" + location.search,
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


    function requestWaitTransfer() {

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/bapi/waitTransfer" + location.search,
            success: function(jResult) {
                //console.log(jResult);
                if (jResult.status == "success") {
                    showWaitTansfer(jResult.data);
                } else if (jResult.status == "logout") {
                    location.reload();
                }
            },
            error: function(request, status, error) {
                //console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });

    }






    /*=============Dialog=============== */

    function dateRangeListener() {

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
            mouseover: function() {
                if ($('input[name="daterange"]').val().length > 0)
                    $(".el-range__close-icon").addClass("fa fa-times-circle");

            },
            mouseleave: function() {
                $(".el-range__close-icon").removeClass("fa fa-times-circle");
            }
        });

        $(".el-range__close-icon").click(function() {
            $('input[name="daterange"]').val('');
        });

        $('input[name="daterange"]').val('');
    }


    function showMessageBox(iType, tMessage) {
        var tTitle = "";
        var tClass = "";
        if (iType == 1) {
            tTitle = "";
            tClass = "fas fa-exclamation-circle";
        } else {
            tClass = "fas fa-times-circle";
            tTitle = "시스템메시지";
        }

        $("#el-message-type-id").attr("class", tClass);
        $("#el-message-title-id").text(tTitle);

        $("#el-message-text-id").text(tMessage);
        $("#el-message-box-id").fadeIn(300);

    }

    function showAlertBox(iType, tMessage) {
        var tClass = "";
        if (iType == 1) {
            tClass = "fas fa-check-circle";
        } else {
            tClass = "fas fa-times-circle";
        }
        $("#el-alert-type-id").attr("class", tClass);
        $("#el-alert-content-id").text(tMessage);
        $("#el-alert-box-id").slideDown(300);

        setTimeout(function() { $("#el-alert-box-id").fadeOut(500); }, 2000);
    }





    function showConfirmModal(iType, tMessage, callback) {

        var result = false;

        var tTitle = "";
        var tClass = "";
        if (iType == "1") {
            tTitle = "";
            tClass = "fas fa-exclamation-circle";
        } else {
            tClass = "fas fa-times-circle";
            tTitle = "시스템메시지";
        }

        $("#el-confirm-type-id").attr("class", tClass);
        $("#el-confirm-title-id").text(tTitle);

        $("#el-confirm-text-id").text(tMessage);


        modalConfirm(function(confirm) {
            if (confirm == 1) {
                result = true;
                callback(result);
            } else if (confirm == 2) {
                result = false;
                callback(result);
            }
        });

    }

    var modalConfirm = function(callback) {

        $("#el-confirm-box-id").show();

        $("#el-confirm-ok-id").on("click", function() {
            callback(1);
            $("#el-confirm-box-id").hide();
        });

        $("#el-confirm-cancel-id").on("click", function() {
            callback(2);
            $("#el-confirm-box-id").hide();
        });
    };










    /*=============CharegeDialog=============== */

    function showChargeDlg() {
        initChargeDlg();
        $("#el-dialog-charge-id").fadeIn(200);
        requestChargeHistory();
    }

    function selectChargeAmount(nAmount) {
        if (nAmount < 1)
            return;

        var nCurAmount = $("#el-dialog-charge-amount-id").val();
        if (nCurAmount.length < 1)
            nCurAmount = 0;
        nCurAmount = parseInt(nCurAmount);
        nCurAmount += nAmount;

        $("#el-dialog-charge-amount-id").val(nCurAmount);
    }

    function initChargeDlg() {
        $("#el-dialog-charge-amount-id").val('');
        $("#el-dialog-charge-name-id").val('');
    }

    function showChargeDlgData(arrChargeData) {
        var tHtml = "";
        if (arrChargeData != null && arrChargeData.length > 0) {
            for (var idx in arrChargeData) {
                tHtml += " <tr class=\"el-table__row\">";
                tHtml += "<td><div class=\"cell\">";
                tHtml += parseInt(arrChargeData[idx].charge_money).toLocaleString();
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                if (arrChargeData[idx].charge_action_state == 1) {
                    tHtml += "<span class=\"star-badge star-badge--wait\">미확인</span>";
                } else if (arrChargeData[idx].charge_action_state == 2) {
                    tHtml += "<span class=\"star-badge star-badge--ok\">확인</span>";
                } else if (arrChargeData[idx].charge_action_state == 3) {
                    tHtml += "<span class=\"star-badge star-badge--cancel\">취소됨</span>";
                }
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrChargeData[idx].charge_time_require;
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                if (arrChargeData[idx].charge_action_state != 1) {
                    tHtml += arrChargeData[idx].charge_time_process;
                }
                tHtml += "</div></td></tr>";
            }
        }

        $("#el-dialog-charge-data-id").html(tHtml);
        if (tHtml.length < 1)
            $("#el-dialog-charge-empty-id").show();
        else
            $("#el-dialog-charge-empty-id").hide();
    }



    /*=============DischaregeDialog=============== */


    function showDischargeDlg() {
        initDischargeDlg();
        $("#el-dialog-discharge-id").fadeIn(300);
        requestDischargeHistory();
    }


    function selectDischargeAmount(nAmount) {
        if (nAmount < 1)
            return;

        var nCurAmount = $("#el-dialog-discharge-amount-id").val();
        if (nCurAmount.length < 1)
            nCurAmount = 0;
        nCurAmount = parseInt(nCurAmount);
        nCurAmount += nAmount;

        $("#el-dialog-discharge-amount-id").val(nCurAmount);
    }

    function initDischargeDlg() {
        $("#el-dialog-discharge-amount-id").val('');
        $("#el-dialog-discharge-bank-id").val('');
        $("#el-dialog-discharge-number-id").val('');
        $("#el-dialog-discharge-owner-id").val('');

    }

    function showDischargeDlgData(arrChargeData) {
        var tHtml = "";
        if (arrChargeData != null && arrChargeData.length > 0) {
            for (var idx in arrChargeData) {
                tHtml += " <tr class=\"el-table__row\">";
                tHtml += "<td><div class=\"cell\">";
                tHtml += parseInt(arrChargeData[idx].exchange_money).toLocaleString();
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                if (arrChargeData[idx].exchange_action_state == 1) {
                    tHtml += "<span class=\"star-badge star-badge--wait\">미확인</span>";
                } else if (arrChargeData[idx].exchange_action_state == 2) {
                    tHtml += "<span class=\"star-badge star-badge--ok\">확인</span>";
                } else if (arrChargeData[idx].exchange_action_state == 3) {
                    tHtml += "<span class=\"star-badge star-badge--cancel\">취소됨</span>";
                }
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrChargeData[idx].exchange_time_require;
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                if (arrChargeData[idx].exchange_action_state != 1) {
                    tHtml += arrChargeData[idx].exchange_time_process;
                }
                tHtml += "</div></td></tr>";
            }
        }

        $("#el-dialog-discharge-data-id").html(tHtml);
        if (tHtml.length < 1)
            $("#el-dialog-dixcharge-empty-id").show();
        else
            $("#el-dialog-discharge-empty-id").hide();
    }



    /*=============MileageDialog=============== */


    function showMileageDlg() {

        initMileageDlg();
        $("#el-dialog-mileage-id").fadeIn(300);
        requestMileageHistory();
    }

    function selectMileageAmount() {

        $("#el-dialog-mileage-input-id").val(m_objUser.mb_point);
    }

    function initMileageDlg() {
        $("#el-dialog-mileage-amount-id").text(m_objUser.mb_point);

        $("#el-dialog-mileage-input-id").val('');

    }



    function showMileageDlgData(arrMileageData) {
        var tHtml = "";
        if (arrMileageData != null && arrMileageData.length > 0) {
            for (var idx in arrMileageData) {
                tHtml += " <tr class=\"el-table__row\">";
                tHtml += "<td><div class=\"cell\">";
                tHtml += parseInt(arrMileageData[idx].money_amount).toLocaleString();
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrMileageData[idx].money_update_time;
                tHtml += "</div></td></tr>";
            }
        }

        $("#el-dialog-mileage-data-id").html(tHtml);
        if (tHtml.length < 1)
            $("#el-dialog-mileage-empty-id").show();
        else
            $("#el-dialog-mileage-empty-id").hide();
    }


    function getToday() {
        var dtToday = new Date();
        return dtToday.getFullYear() + "-" + ("0" + (dtToday.getMonth() + 1)).slice(-2) + "-" + ("0" + dtToday.getDate()).slice(-2);
    }


    function getYesterday(){
        var dtToday = new Date();
        var yesterday = new Date(dtToday.setDate(dtToday.getDate() - 1));

        return yesterday.getFullYear() + "-" + ("0"+(yesterday.getMonth()+1)).slice(-2) + "-" + ("0"+yesterday.getDate()).slice(-2);
    }


    // worker 실행
    function startWorker() {

        // Worker 지원 유무 확인
        if (!!window.Worker) {

            // 실행하고 있는 워커 있으면 중지시키기
            if (worker) {
                stopWorker();
            }

            worker = new Worker('/assets/js/worker.js');
            worker.postMessage('워커 실행'); // 워커에 메시지를 보낸다.

            // 메시지는 JSON구조로 직렬화 할 수 있는 값이면 사용할 수 있다. Object등
            // worker.postMessage( { name : '302chanwoo' } );

            // 워커로 부터 메시지를 수신한다.
            worker.onmessage = function(e) {
                showTime();

            };
        }

    }


    // worker 중지
    function stopWorker() {

        if (worker) {
            worker.terminate();
            worker = null;
        }

    }



    function showTime() {

        let tmCurrent = new Date();

        let nCurSec = tmCurrent.getSeconds();
        if (nCurSec % 5 == 0) {
            requestMemberInfo();
            requestRecvMessage();
            requestWaitTransfer();
        }

    }




    function speak(text, opt_prop) {
        if (typeof SpeechSynthesisUtterance === "undefined" || typeof window.speechSynthesis === "undefined") {
            //alert("이 브라우저는 음성 합성을 지원하지 않습니다.");
            return;
        }

        window.speechSynthesis.cancel(); // 현재 읽고있다면 초기화

        const prop = opt_prop; // {}

        const speechMsg = new SpeechSynthesisUtterance();
        speechMsg.rate = prop.rate; // 1 // 속도: 0.1 ~ 10      
        speechMsg.pitch = prop.pitch; // 1 // 음높이: 0 ~ 2
        speechMsg.lang = "ko-KR"; //prop.lang ;// "ko-KR"
        speechMsg.text = text;

        // SpeechSynthesisUtterance에 저장된 내용을 바탕으로 음성합성 실행
        window.speechSynthesis.speak(speechMsg);
    }
