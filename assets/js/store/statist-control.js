$(document).ready(function() {



    dateRangeListener();

    var tToday = getToday();
    var tRange = tToday + "     ~     " + tToday;
    $("#el-main-range-id").val(tRange);

    requestBetStatist();
});

function showBetStatistData(arrBetData) {
    var tHtml = "";
    var nBetSum = 0;
    var nWinSum = 0;
    var nMilSum = 0;
    if (arrBetData != null && arrBetData.length > 0) {
        for (var idx in arrBetData) {
            tHtml += "<tr class=\"el-table__row\" ";
            tHtml += " ondblclick=\"showEmpBetDlg('" + arrBetData[idx].bet_mb_uid + "');\" >";
            tHtml += "<td><div class=\"cell\">";
            tHtml += arrBetData[idx].bet_mb_uid;
            tHtml += "</div></td>";
            tHtml += "<td><div class=\"cell\">";
            tHtml += parseInt(arrBetData[idx].bet_money_sum).toLocaleString();
            tHtml += "</div></td>";
            tHtml += "<td><div class=\"cell\">";
            tHtml += parseInt(arrBetData[idx].bet_win_sum).toLocaleString();
            tHtml += "</div></td>";
            tHtml += "<td><div class=\"cell\">";
            tHtml += parseInt(arrBetData[idx].bet_money_sum - arrBetData[idx].bet_win_sum).toLocaleString();
            tHtml += "</div></td>";
            tHtml += "<td><div class=\"cell\">";
            tHtml += parseInt(arrBetData[idx].bet_win_count).toLocaleString();
            tHtml += "</div></td>";
            tHtml += "<td><div class=\"cell\">";
            tHtml += parseInt(arrBetData[idx].bet_empl_amount).toLocaleString();
            tHtml += "</div></td>";
            tHtml += "<td><div class=\"cell\">";
            tHtml += parseInt(arrBetData[idx].bet_agen_amount).toLocaleString();
            tHtml += "</div></td></tr>";

            nBetSum += parseInt(arrBetData[idx].bet_money_sum);
            nWinSum += parseInt(arrBetData[idx].bet_win_sum);
            nMilSum += parseInt(arrBetData[idx].bet_agen_amount);
        }

    }

    $("#el-main-data-id").html(tHtml);
    if (tHtml.length < 1) {
        $("#el-main__empty-id").show();
        $("#el-main-footer-id").hide();
    } else {
        $("#el-main__empty-id").hide();
        $("#el-main-footer-id").show();

        $("#el-main-sum_1-id").text(nBetSum.toLocaleString());

        $("#el-main-sum_2-id").text(nWinSum.toLocaleString());
        $("#el-main-sum_3-id").text((nBetSum - nWinSum).toLocaleString());
        $("#el-main-sum_4-id").text(nMilSum.toLocaleString());

    }
}



function showEmpBetDlg(tUid) {
    var tRange = $("#el-main-range-id").val();
    $("#el-dialog-range-id").val(tRange);
    $("#el-dialog-history-id").attr("name", tUid);

    $("#el-dialog-history-id").fadeIn(100);

    requestBetHistory();

}

function closeEmpBetDlg() {
    $("#el-dialog-history-id").fadeOut(100);
}


function showBetDlgData(arrBetData) {
    var tHtml = "";
    if (arrBetData != null && arrBetData.length > 0) {
        for (var idx in arrBetData) {
            tHtml += "<tr class=\"el-table__row\">";
            tHtml += "<td><div class=\"cell\">";
            if (parseInt(arrBetData[idx].bet_game) == 0)
                tHtml += "PBG";
            else if (parseInt(arrBetData[idx].bet_game) == 1)
                tHtml += "코인";
            else if (parseInt(arrBetData[idx].bet_game) == 2)
                tHtml += "EOS";
            tHtml += "</div></td>";
            tHtml += "<td><div class=\"cell\">";
            if (parseInt(arrBetData[idx].bet_game) == 0)
                tHtml += arrBetData[idx].bet_round_fid;
            else if (parseInt(arrBetData[idx].bet_game) == 1)
                tHtml += arrBetData[idx].bet_round_no;
            else if (parseInt(arrBetData[idx].bet_game) == 2)
                tHtml += arrBetData[idx].bet_round_no;
            tHtml += "</div></td>";
            tHtml += "<td><div class=\"cell\">";
            tHtml += arrBetData[idx].bet_mb_uid;
            tHtml += "</div></td>";
            tHtml += "<td><div class=\"cell\">";
            tHtml += arrBetData[idx].bet_mb_uid;
            tHtml += "</div></td>";
            tHtml += "<td><div class=\"cell\">";
            tHtml += getBetDetail(arrBetData[idx].bet_mode);
            tHtml += "</div></td>";
            tHtml += "<td><div class=\"cell\">";
            tHtml += parseInt(arrBetData[idx].bet_money).toLocaleString();
            tHtml += "</div></td>";
            tHtml += "<td><div class=\"cell\">";
            tHtml += (parseInt(arrBetData[idx].bet_before_money) - parseInt(arrBetData[idx].bet_money)).toLocaleString();
            tHtml += "</div></td>";
            tHtml += "<td><div class=\"cell\">";
            tHtml += parseInt(arrBetData[idx].bet_win_money).toLocaleString();
            tHtml += "</div></td>";
            tHtml += "<td><div class=\"cell\">";
            tHtml += parseInt(arrBetData[idx].bet_empl_amount).toLocaleString();
            tHtml += "</div></td>";
            tHtml += "<td><div class=\"cell\">";
            tHtml += arrBetData[idx].bet_time;
            tHtml += "</div></td></tr>";

        }
    }

    $("#el-dialog-data-id").html(tHtml);
    if (tHtml.length < 1) {
        $("#el-dialog__empty-id").show();

    } else
        $("#el-dialog__empty-id").hide();
}

function requestBetStatist() {

    var tRange = $("#el-main-range-id").val();
    var tStart = "",
        tEnd = "";
    var arrRange = tRange.split('~');
    if (arrRange.length == 2) {
        tStart = arrRange[0].trim();
        tEnd = arrRange[1].trim();
    } else return;

    var objData = { "start": tStart, "end": tEnd };
    var jsonData = JSON.stringify(objData);

    $.ajax({
        type: "POST",
        dataType: "json",
        data: { json_: jsonData },
        url: "/mapi/betstatist" + location.search,
        success: function(jResult) {
            // console.log(jResult);
            if (jResult.status == "success") {
                showBetStatistData(jResult.data);
            } else if (jResult.status == "logout") {
                location.reload();
            }
        },
        error: function(request, status, error) {
            // console.log("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
        }
    });

}

function requestBetHistory() {

    var tRange = $("#el-dialog-range-id").val();
    var tStart = "",
        tEnd = "";
    var arrRange = tRange.split('~');
    if (arrRange.length == 2) {
        tStart = arrRange[0].trim();
        tEnd = arrRange[1].trim();
    } else return;

    var tUid = $("#el-dialog-history-id").attr("name");

    var objData = { "start": tStart, "end": tEnd, "mb_uid": tUid };
    var jsonData = JSON.stringify(objData);

    //console.log(jsonData);

    $.ajax({
        type: "POST",
        dataType: "json",
        data: { json_: jsonData },
        url: "/mapi/bethistory" + location.search,
        success: function(jResult) {
            // console.log(jResult);
            if (jResult.status == "success") {
                showBetDlgData(jResult.data);
            } else if (jResult.status == "logout") {
                location.reload();
            }
        },
        error: function(request, status, error) {
            // console.log("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
        }
    });

}



function dateRangeListener() {

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
        mouseover: function() {
            if ($('input[name="daterange"]').val().length > 0)
                $(".el-range__close-icon").addClass("fa fa-times-circle");

        },
        mouseleave: function() {
            $(".el-range__close-icon").removeClass("fa fa-times-circle");
        }
    });

    $("#el-main-range__close-id").click(function() {
        $('#el-main-range-id').val('');
    });

    $("#el-dialog-range__close-id").click(function() {
        $('#el-dialog-range-id').val('');
    });

    $('input[name="daterange"]').val('');
}


