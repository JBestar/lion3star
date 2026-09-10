
    var m_arrDischarge = null;


    $(document).ready(function(){
        dateRangeListener();

        todayDischarge();
        setTimeout(function() {
            pageLoop();
        }, 120000);

    });


    function pageLoop() {
        requestDischargeList();
        // 1초뒤에 다시 실행
        setTimeout(function() {
            pageLoop();
        }, 120000);
    
    }
    

    function setDischargeList(arrDischarge){
        var tHtml = "";
        m_arrDischarge = arrDischarge;
        if(arrDischarge != null && arrDischarge.length > 0){
            for(var idx in arrDischarge){
                tHtml += " <tr class=\"el-table__row\">";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrDischarge[idx].exchange_mb_uid;
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                tHtml += parseInt(arrDischarge[idx].exchange_money).toLocaleString();
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                if(arrDischarge[idx].exchange_action_state == 1)
                    tHtml += "<span class=\"star-badge star-badge--wait\">미확인</span>";
                else if(arrDischarge[idx].exchange_action_state == 2)
                    tHtml += "<span class=\"star-badge star-badge--ok\">확인</span>";
                else if(arrDischarge[idx].exchange_action_state == 3)
                    tHtml += "<span class=\"star-badge star-badge--cancel\">취소됨</span>";
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrDischarge[idx].exchange_bank_name;
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrDischarge[idx].exchange_bank_number;
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrDischarge[idx].exchange_bank_owner;
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrDischarge[idx].exchange_time_require;
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                if(parseInt(arrDischarge[idx].exchange_time_process)>0)
                    tHtml += arrDischarge[idx].exchange_time_process;
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                if(arrDischarge[idx].exchange_action_state == 1) {
                    tHtml += "<button type=\"button\" class=\"el-button el-button--primary el-button--small\" onclick=\"permitDischarge(1, "+idx+");\"><span>확인</span></button>";
                    tHtml += "<button type=\"button\" class=\"el-button el-button--danger el-button--small\" onclick=\"permitDischarge(0, "+idx+");\"><span>취소</span></button>";
                }
                tHtml += "</div></td></tr>";

            }
        }
        $("#el-table-data-id").html(tHtml);
        if(tHtml.length < 1)
            $("#el-table__empty-id").show();
        else 
            $("#el-table__empty-id").hide();
    }

    function todayDischarge(){
      
        var tRange = getYesterday() + "     ~     " + getToday();
        $("#el-main-range-id").val(tRange);
        
        requestDischargeList();
    }

    function findDischarge(){
      
        requestDischargeList();
    }

    function requestDischargeList(){
        var tRange = $("#el-main-range-id").val();
        var tStart = "",
            tEnd = "";
        var arrRange = tRange.split('~');
        if (arrRange.length == 2) {
            tStart = arrRange[0].trim();
            tEnd = arrRange[1].trim();
        } 

        var objData = { "start": tStart, "end": tEnd };
        var jsonData = JSON.stringify(objData);

        $.ajax({
            type: "POST",
            dataType: "json",
            data: {json_: jsonData},
            url:"/capi/dischargelist"+location.search,
            success: function(jResult) {
                // console.log(jResult);
                if(jResult.status == "success")
                {
                    setDischargeList(jResult.data);
                } else if(jResult.status == "logout"){
                    location.reload();
                }
            },
            error:function(request,status,error){
                // console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });
    }

    
    function permitDischarge(iProc, idx){
        if(m_arrDischarge == null || m_arrDischarge.legnth<=idx)
            return;

        var objData = { "discharge_fid":m_arrDischarge[idx].exchange_fid, "discharge_proc":iProc};
        if(iProc == 0){
            showConfirmModal("1", "취소하시겠습니까?", function(confirm){
                if(confirm){
                    requestPermitDischarge(objData);
                    objData = null;
                }
            });
        } else if(iProc == 1){
            showConfirmModal("1", "승인하시겠습니까?", function(confirm){
                if(confirm){
                    requestPermitDischarge(objData);
                    objData = null;
                }
            });
        }

    }

    function requestPermitDischarge(objData){
        if(objData == null) return;

        var jsonData = JSON.stringify(objData);

        $.ajax({
            type: "POST",
            dataType: "json",
            data: {json_: jsonData},
            url:"/capi/dischargeproc"+location.search,
            success: function(jResult) {
                ////console.log(jResult);
                if(jResult.status == "success")
                {
                    showAlertBox(0, "처리완료!");
                    todayDischarge();
                    setTimeout( function() {requestMemberInfo();}, 1000);  
                } else if(jResult.status == "fail"){
                    if(jResult.data == 2)
                        showMessageBox(1, "총판보유머니가 부족합니다.");
                    else
                        showMessageBox(1, "환전처리가 실패되었습니다.");
                } else if(jResult.status == "logout"){
                    location.reload();
                }
            },
            error:function(request,status,error){
                //console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });


    }