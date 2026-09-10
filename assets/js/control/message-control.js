

    var m_arrEmp = null;

    $(document).ready(function(){

        pageLoop();

        requestEmpList();
    });

    function pageLoop() {
        requestMessages();
        // 1초뒤에 다시 실행
        setTimeout(function() {
            pageLoop();
        }, 120000);
    
    }

    function showMessages(arrMessage){
        
        var tHtml = "";

        if(arrMessage != null && arrMessage.length > 0){
            for(var idx in arrMessage){
                tHtml += " <tr class=\"el-table__row\" >";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrMessage[idx].notice_send_uid;
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrMessage[idx].notice_recv_uid;
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrMessage[idx].notice_time_create;
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrMessage[idx].notice_title;
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrMessage[idx].notice_content;
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                tHtml += "<button type=\"button\" onclick=\"deleteMessage("+arrMessage[idx].notice_fid+");\"";
                tHtml += " class=\"el-button el-button--primary el-button--small star-icon-btn\" title=\"삭제\"><i class=\"fas fa-trash\"></i></button>";
                tHtml += "</div></td></tr>";
            }
        }

        $("#el-main-data-id").html(tHtml);
        if(tHtml.length < 1){
            $("#el-main__empty-id").show();
        } else {
            $("#el-main__empty-id").hide();
        }

    }

    
    function deleteMessage(iMsgFid){
        var objData = {"msg_fid":iMsgFid};

        showConfirmModal("1", "삭제하시겠습니까?", function(confirm){
            if(confirm){
                requestDeleteMessage(objData);
                objData = null;
            }
        });

    }

    function requestMessages(){
        $.ajax({
            type: "POST",
            dataType: "json",
            url:"/bapi/getmessage"+location.search,
            success: function(jResult) {
                //console.log(jResult);
                if(jResult.status == "success")
                {
                    showMessages(jResult.data);
                } else if(jResult.status == "logout"){
                    location.reload();
                }
            },
            error:function(request,status,error){
                //console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });
    }


    function requestDeleteMessage(objData){
        if(objData == null) return;
        var jsonData = JSON.stringify(objData);
        
        $.ajax({
            type: "POST",
            dataType: "json",
            data: {json_: jsonData},
            url:"/bapi/deletemessage"+location.search,
            success: function(jResult) {
                //console.log(jResult);
                if(jResult.status == "success")
                {
                    showAlertBox(1, "Delete OK!");
                    requestMessages();
                } else if(jResult.status == "fail"){
                    showMessageBox(1, "삭제가 실패되었습니다.");
                } else if(jResult.status == "logout"){
                    location.reload();
                }
            },
            error:function(request,status,error){
                //console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });
    }

    
    function requestEmpList(){
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url:"/bapi/emplist"+location.search,
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

    
    function sendMessage(){
        var tRecvId = $("#el-form-uid-input-id").val();
        var tTitle = $("#el-dialog-message-title-id").val();
        var tContent = $("#el-dialog-message-content-id").val();
        
        if(tRecvId.length < 1){
            showMessageBox(1, "받는이 선택하세요");
            return;
        }

        if(tTitle.length<1){
            showMessageBox(1, "제목을 입력해주세요");
            return;
        }
        if(tContent.length<1){
            showMessageBox(1, "내용을 입력해주세요");
            return;
        }
        var objData = { "recv_id":tRecvId, "title":tTitle, "content":tContent};
        var jsonData = JSON.stringify(objData);

        $.ajax({
            type: "POST",
            dataType: "json",
            data: {json_: jsonData},
            url:"/bapi/sendmessage"+location.search,
            success: function(jResult) {
                //console.log(jResult);
                if(jResult.status == "success")
                {
                    closeMessageDlg();
                    showAlertBox(1, "발송완료");
                    requestMessages();

                } else if(jResult.status == "fail"){
                    showMessageBox(1, "발송이 실패되었습니다.");
                } else if(jResult.status == "logout"){
                    location.reload();
                }
            },
            error:function(request,status,error){
                //console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });

    }







    function showMessageDlg(){
        $("#el-form-uid-input-id").val('');
        $("#el-dialog-message-title-id").val('');
        $("#el-dialog-message-content-id").val('');

        $("#el-dialog-message-id").fadeIn(200);
    }

    

    function closeMessageDlg(){
        $("#el-dialog-message-id").fadeOut(200);
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