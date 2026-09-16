

    $(document).ready(function(){



        dateRangeListener();

        var tToday = getToday();
        var tRange = tToday + "     ~     " + tToday;
        $("#el-main-range-id").val(tRange);

        requestTransStatist();
    });


    function showTransStatist(arrTransfer){
        var tHtml = "";
        var nGiveSum = 0;
        var nChargeSum = 0;
        var nDischargeSum = 0;
        var nMileageSum = 0;
        var nProfit = 0;
        if(arrTransfer != null && arrTransfer.length > 0){
            for(var idx in arrTransfer){
                nProfit = 0;
                tHtml += " <tr class=\"el-table__row\" ondblclick=\"showDetailDlg('"+ arrTransfer[idx].money_mb_uid +"');\">";
                tHtml += "<td><div class=\"cell\">";
                tHtml += arrTransfer[idx].money_mb_uid;
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                if(arrTransfer[idx].money_give != null){
                    tHtml += parseInt(arrTransfer[idx].money_give).toLocaleString();
                    nProfit += parseInt(arrTransfer[idx].money_give);
                    nGiveSum += parseInt(arrTransfer[idx].money_give);
                } else tHtml += "0";
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                if(arrTransfer[idx].money_charge != null){
                    tHtml += parseInt(arrTransfer[idx].money_charge).toLocaleString();
                    nProfit += parseInt(arrTransfer[idx].money_charge);
                    nChargeSum += parseInt(arrTransfer[idx].money_charge);
                } else tHtml += "0";
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                if(arrTransfer[idx].money_discharge != null){
                    tHtml += parseInt(0-arrTransfer[idx].money_discharge).toLocaleString();
                    nProfit += parseInt(arrTransfer[idx].money_discharge);
                    nDischargeSum += parseInt(arrTransfer[idx].money_discharge);
                } else tHtml += "0";
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                if(arrTransfer[idx].money_mileage != null){
                    tHtml += parseInt(arrTransfer[idx].money_mileage).toLocaleString();
                    nMileageSum += parseInt(arrTransfer[idx].money_mileage);
                } else tHtml += "0";
                tHtml += "</div></td>";
                tHtml += "<td><div class=\"cell\">";
                tHtml += parseInt(nProfit).toLocaleString();
                tHtml += "</div></td></tr>";

                
            }

        }

        $("#el-main-data-id").html(tHtml);
        if(tHtml.length < 1){
            $("#el-main__empty-id").show();
            $("#el-main-footer-id").hide();
        } else {
            $("#el-main__empty-id").hide();
            $("#el-main-footer-id").show();

            $("#el-main-sum_1-id").text(nGiveSum.toLocaleString());
            $("#el-main-sum_2-id").text(nChargeSum.toLocaleString());
            $("#el-main-sum_3-id").text((0-nDischargeSum).toLocaleString());
            $("#el-main-sum_4-id").text(nMileageSum.toLocaleString());
            $("#el-main-sum_5-id").text((nGiveSum + nChargeSum + nDischargeSum).toLocaleString());

        }   

    }




    function requestTransStatist(){

        var tRange = $("#el-main-range-id").val();
        var tStart = "", tEnd = "";
        var arrRange = tRange.split('~');
        if(arrRange.length == 2){
            tStart = arrRange[0].trim();
            tEnd = arrRange[1].trim();
        } else return;

        var objData = { "start":tStart, "end":tEnd};
        var jsonData = JSON.stringify(objData);

        $.ajax({
            type: "POST",
            dataType: "json",
            data: {json_: jsonData},
            url:"/mapi/transferstatist"+location.search,
            success: function(jResult) {
                ////console.log(jResult);
                if(jResult.status == "success")
                {
                    showTransStatist(jResult.data);
                } else if(jResult.status == "logout"){
                    location.reload();
                }
            },
            error:function(request,status,error){
                ////console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });
        
    }


    function requestTransDetail(tUid){

        var tRange = $("#el-main-range-id").val();
        var tStart = "", tEnd = "";
        var arrRange = tRange.split('~');
        if(arrRange.length == 2){
            tStart = arrRange[0].trim();
            tEnd = arrRange[1].trim();
        } else return;

        var objData = { "start":tStart, "end":tEnd, "uid":tUid};
        var jsonData = JSON.stringify(objData);

        $.ajax({
            type: "POST",
            dataType: "json",
            data: {json_: jsonData},
            url:"/mapi/transferdetail"+location.search,
            success: function(jResult) {
                //console.log(jResult);
                if(jResult.status == "success")
                {
                    showTransDetail(jResult.data);
                } else if(jResult.status == "logout"){
                    location.reload();
                }
            },
            error:function(request,status,error){
                //console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });
        
    }

    
    function dateRangeListener(){

        $('input[name="daterange"]').daterangepicker({
            
            "autoApply": true,
            "locale": {
                "format": "YYYY-MM-DD",
                "separator": "     ~     ",
                "firstDay": 0
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

        $("#el-main-range__close-id").click(function(){
            $('#el-main-range-id').val('');
        });

        $('input[name="daterange"]').val('');
    }


    function showDetailDlg(tUid){
        $("#el-dialog-detail-id").fadeIn(100);
        requestTransDetail(tUid);

    }

    function closeDetailDlg(){
         
        $("#el-dialog-detail-id").fadeOut(100);
    }

    function showTransDetail(arrTransfer){
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
                    tHtml += tEmptyTd;
                } else if(arrTransfer[idx].money_change_type == 1){
                    tHtml += tEmptyTd;
                    tHtml += "<td><div class=\"cell\">";
                    tHtml += parseInt(arrTransfer[idx].money_amount).toLocaleString();
                    tHtml += "</div></td>";
                    tHtml += tEmptyTd;
                    tHtml += tEmptyTd;
                } else if(arrTransfer[idx].money_change_type == 2){
                    tHtml += tEmptyTd;
                    tHtml += tEmptyTd;
                    tHtml += "<td><div class=\"cell\">";
                    tHtml += parseInt(0-arrTransfer[idx].money_amount).toLocaleString();
                    tHtml += "</div></td>";
                    tHtml += tEmptyTd;
                } else if(arrTransfer[idx].money_change_type == 3){
                    tHtml += tEmptyTd;
                    tHtml += tEmptyTd;
                    tHtml += tEmptyTd;
                    tHtml += "<td><div class=\"cell\">";
                    tHtml += parseInt(arrTransfer[idx].money_amount).toLocaleString();
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
        $("#el-dialog-detail-data-id").html(tHtml);

    }

