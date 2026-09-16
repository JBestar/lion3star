
    $(document).ready(function(){


        requestTransList();
    });


    
    function requestTransList(){
        var objData = { "start":"", "end":""};
        var jsonData = JSON.stringify(objData);

        $.ajax({
            type: "POST",
            dataType: "json",
            data: {json_: jsonData},
            url:"/mapi/transferlist"+location.search,
            success: function(jResult) {
                //console.log(jResult);
                if(jResult.status == "success")
                {
                    showTransList(jResult.data);
                } else if(jResult.status == "logout"){
                    location.reload();
                }
            },
            error:function(request,status,error){
                //console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });
        
    }




    
    function showTransList(arrTransfer){
        var tHtml = "";
        var tEmptyTd = "<td><div class=\"cell\">0</div></td>";
        if(arrTransfer != null && arrTransfer.length > 0){
            for(var idx in arrTransfer){
                tHtml += " <tr class=\"el-table__row\">";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrTransfer[idx].money_mb_uid;
                tHtml += "</div></td>";
                if(arrTransfer[idx].money_change_type == 0){
                    tHtml += "<td><div class=\"cell\">";
                    tHtml += parseInt(arrTransfer[idx].money_amount).toLocaleString();
                    tHtml += "</div></td>";
                    tHtml += tEmptyTd;
                    tHtml += tEmptyTd;
                } else if(arrTransfer[idx].money_change_type == 1){
                    tHtml += tEmptyTd;
                    tHtml += "<td><div class=\"cell\">";
                    tHtml += parseInt(arrTransfer[idx].money_amount).toLocaleString();
                    tHtml += "</div></td>";
                    tHtml += tEmptyTd;
                } else if(arrTransfer[idx].money_change_type == 2){
                    tHtml += tEmptyTd;
                    tHtml += tEmptyTd;
                    tHtml += "<td><div class=\"cell\">";
                    tHtml += parseInt(0-arrTransfer[idx].money_amount).toLocaleString();
                    tHtml += "</div></td>";
                } else {
                    tHtml = "";
                    break; 
                }

                tHtml += "<td><div class=\"cell\">";
                tHtml += arrTransfer[idx].money_update_time;
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

