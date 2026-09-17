
    var m_arrEmp = null;
    var m_arrDischarge = null;


    $(document).ready(function(){

        dateRangeListener();

        requestEmpList();
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

    function toggleEmpSelect(){

        var divDropdown = $("#el-form-select-icon-id");
        var nLeft = parseInt(divDropdown.offset().left)-168;    //562 - 394
        var nTop = parseInt(divDropdown.offset().top)+45;      //105 - 150 
        
        
        if($("#el-select-box-id").css("display") == "none"){
            $("#el-form-select-icon-id").addClass( "is-reverse" );
        
            $("#el-select-dropdown-id").css({"top": nTop.toString()+"px", "left": nLeft.toString()+"px"});

            $("#el-select-box-id").slideDown(300);
            //$("#el-select-dropdown-id").slideDown(200);

        } else {
            $("#el-form-select-icon-id").removeClass( "is-reverse" );
            $("#el-select-box-id").slideUp(300);
            //$("#el-select-dropdown-id").slideUp(200);

        }


        
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
                if(arrDischarge[idx].exchange_type == 0)
                    tHtml += "<span class=\"star-badge star-badge--type\">신청환전</span>";
                else if(arrDischarge[idx].exchange_type == 1)
                    tHtml += "<span class=\"star-badge star-badge--type-direct\">직환전</span>";                
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrDischarge[idx].exchange_bank_name;
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                if(arrDischarge[idx].exchange_action_state == 1) {
                    tHtml += "<button type=\"button\" class=\"el-button el-button--primary el-button--small\" onclick=\"permitDischarge(1, "+idx+");\"><span>확인</span></button>";
                }
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
                tHtml += "</div></td></tr>";

            }
        }
        $("#el-table-data-id").html(tHtml);
        if(tHtml.length < 1)
            $("#el-table__empty-id").show();
        else 
            $("#el-table__empty-id").hide();
    }



    function setEmpList(arrEmp){
        var tHtml = "";
        m_arrEmp = arrEmp;
        if(arrEmp != null && arrEmp.length > 0){
            
            for(var idx in arrEmp){
                tHtml += "<li class=\"el-select-dropdown__item \" index=\""+ idx +"\" onclick=\"selectEmp(this);\">";
                tHtml += "<span style=\"float: left;\">";
                tHtml += arrEmp[idx].mb_uid + "</span>";
                tHtml += "<span class=\"item-span2\">";
                tHtml += arrEmp[idx].mb_uid + "</span></li>";


            }
        }

        $("#el-select-ul-id").html(tHtml);

        
    }
    

    function selectEmp(liEmp){
        $("#el-form-select-icon-id").removeClass( "is-reverse" );
        $("#el-select-box-id").slideUp(500);

        if(m_arrEmp == null || m_arrEmp.legnth<=idx)
            return;

        $("#el-select-box-id li").removeClass("selected");
        $(liEmp).addClass("selected");
        var idx = $(liEmp).attr("index");
        
        $("#el-form-uid-input-id").val(m_arrEmp[idx].mb_uid);

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

    
    function giveDischarge(){
        var tUid = $("#el-form-uid-input-id").val();
        if(tUid.length < 1){
            showMessageBox(1, "환전신청 아이디를 선택해주세요.");
            return;
        }
        var tAmount = $("#el-form-amount-input-id").val();
        if(tAmount.length < 1 || tAmount < 1){
            showMessageBox(1, "환전금액을 입력해주세요.");
            return;
        }

        var objData = { "discharge_uid":tUid, "discharge_amount":tAmount};

        showConfirmModal("1", "환전하시겠습니까?", function(confirm){
            if(confirm){
                requestGiveDischarge(objData);
                objData = null;
            }
        });
        
    }


    function requestEmpList(){
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url:"/mapi/emplist"+location.search,
            success: function(jResult) {
                
                if(jResult.status == "success")
                {
                    setEmpList(jResult.data);
                } else if(jResult.status == "logout"){
                    location.reload();
                }
            },
            error:function(request,status,error){
                
            }
        });

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
            url:"/mapi/dischargelist"+location.search,
            success: function(jResult) {
                
                if(jResult.status == "success")
                {
                    setDischargeList(jResult.data);
                } else if(jResult.status == "logout"){
                    location.reload();
                }
            },
            error:function(request,status,error){
                
            }
        });
    }

    function requestPermitDischarge(objData){
        if(objData == null) return;

        var jsonData = JSON.stringify(objData);

        $.ajax({
            type: "POST",
            dataType: "json",
            data: {json_: jsonData},
            url:"/mapi/dischargeproc"+location.search,
            success: function(jResult) {
                //console.log(jResult);
                if(jResult.status == "success")
                {
                    showAlertBox(0, "처리완료!");
                    todayDischarge();
                    if (typeof notifyTransferProcessed === "function") notifyTransferProcessed();
                    setTimeout( function() {requestMemberInfo();}, 1000);  
                } else if(jResult.status == "fail"){
                    if(jResult.data == 2)
                        showMessageBox(1, "매장보유머니가 부족합니다.");
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


    
    
    function requestGiveDischarge(objData) {

        if(objData == null) return;
 
         var jsonData = JSON.stringify(objData);
 
         $.ajax({
             type: "POST",
             dataType: "json",
             data: {json_: jsonData},
             url:"/mapi/givedischarge"+location.search,
             success: function(jResult) {
                 //console.log(jResult);
                 if(jResult.status == "success")
                 {
                     showAlertBox(1, "처리완료!");
                     todayDischarge();
                     if (typeof notifyTransferProcessed === "function") notifyTransferProcessed();
                     setTimeout( function() {requestMemberInfo();}, 1000);  
                 } else if(jResult.status == "fail"){
                     if(jResult.data == 2)
                         showMessageBox(1, "환전금액이 매장 보유머니를 초과하셧습니다.");
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