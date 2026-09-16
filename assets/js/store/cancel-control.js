$(document).ready(function() {
    
    dateRangeListener();

    var tToday = getToday();
    var tRange = tToday + "     ~     " + tToday;
    $("#el-dialog-range-id").val(tRange);

    requestBetHistory();
});


function showBetData(arrBetData) {
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
            tHtml += arrBetData[idx].bet_time;
            tHtml += "<td><div class=\"cell\">";
            tHtml += arrBetData[idx].bet_account_time;
            tHtml += "</div></td></tr>";

        }
    }

    $("#el-table-data-id").html(tHtml);
    if (tHtml.length < 1) {
        $("#el-table__empty-id").show();
    } else
        $("#el-table__empty-id").hide();
}

function requestBetHistory() {

    var tRange = $("#el-dialog-range-id").val();
    var tStart = "",
        tEnd = "";
    var arrRange = tRange.split('~');
    if (arrRange.length == 2) {
        tStart = arrRange[0].trim();
        tEnd = arrRange[1].trim();
    } 

    var objData = { "start": tStart, "end": tEnd, "state": 4 };
    var jsonData = JSON.stringify(objData);

    $.ajax({
        type: "POST",
        dataType: "json",
        data: { json_: jsonData },
        url: "/mapi/bethistory" + location.search,
        success: function(jResult) {
            // console.log(jResult);
            if (jResult.status == "success") {
                showBetData(jResult.data);
            } else if (jResult.status == "logout") {
                location.reload();
            }
        },
        error: function(request, status, error) {
            // console.log("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
        }
    });

}