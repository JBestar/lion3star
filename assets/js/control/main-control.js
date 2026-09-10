    var m_arrEmployee = null;

    $(document).ready(function() {

        requestEmployee();
        setInterval(requestEmployee, 10000);

    });

    function showEmpDlg() {
        initEmpDlg();
        $("#el-dialog-employee-id").fadeIn(100);
    }

    function closeEmpDlg() {
        $("#el-dialog-employee-id").fadeOut(100);
    }

    function initEmpDlg() {
        $("#el-dialog-employee-id .el-input__inner").val('');
        $("#el-dialog-employee-print").prop("checked", false);
        $("#el-dialog-employee-uid").removeAttr("disabled");
        $("#el-dialog-employee-uid").attr("index", 0);
        $("#el-dialog-employee-uid-div").removeClass("is-disabled");
    }

    function modifyEmpDlg(idx) {

        if (idx < 0)
            return;

        if (m_arrEmployee == null)
            return;

        if (m_arrEmployee.length < idx)
            return;

        if (m_arrEmployee[idx] == null)
            return;

        showEmpDlg();

        $("#el-dialog-employee-uid").val(m_arrEmployee[idx].mb_uid);
        $("#el-dialog-employee-uid").attr("disabled", true);
        $("#el-dialog-employee-uid").attr("index", m_arrEmployee[idx].mb_fid);
        $("#el-dialog-employee-uid-div").addClass("is-disabled");
        $("#el-dialog-employee-nickname").val(m_arrEmployee[idx].mb_uid);
        $("#el-dialog-employee-pwd").val(m_arrEmployee[idx].mb_pwd);
        $("#el-dialog-employee-ratio").val(m_arrEmployee[idx].mb_game_pb_ratio);
        $("#el-dialog-employee-liround").val(m_arrEmployee[idx].mb_limit_round);
        $("#el-dialog-employee-lisingle").val(m_arrEmployee[idx].mb_limit_single);
        $("#el-dialog-employee-limix").val(m_arrEmployee[idx].mb_limit_mix);
        $("#el-dialog-employee-print").prop("checked", parseInt(m_arrEmployee[idx].mb_state_print, 10) === 1);
    }

    function saveEmployee() {

        var index = $("#el-dialog-employee-uid").attr("index");

        var objData = new Object;
        objData.uid = $("#el-dialog-employee-uid").val();
        objData.nickname = $("#el-dialog-employee-nickname").val();
        objData.pwd = $("#el-dialog-employee-pwd").val();
        objData.ratio = $("#el-dialog-employee-ratio").val();
        objData.liround = $("#el-dialog-employee-liround").val();
        objData.lisingle = $("#el-dialog-employee-lisingle").val();
        objData.limix = $("#el-dialog-employee-limix").val();
        objData.mb_print = $("#el-dialog-employee-print").is(":checked") ? 1 : 0;

        if (objData.uid.length < 1 || objData.nickname.length < 1 || objData.pwd.length < 1) {
            showMessageBox(1, "계정정보를 정확히 입력해주세요");
            return;
        }

        var jsonData = JSON.stringify(objData);
        //console.log(jsonData);

        if (index == 0) {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { json_: jsonData },
                url: "/bapi/addemployee" + location.search,
                success: function(jResult) {

                    if (jResult.status == "success") {
                        closeEmpDlg();
                        showAlertBox(0, "저장완료!");
                        requestEmployee();
                    } else if (jResult.status == "fail") {
                        if (jResult.data == 2)
                            showMessageBox(1, "아이디 중복!");
                        else if (jResult.data == 3)
                            showMessageBox(1, "수수료율이 총판보다 크게 설정되었습니다.");
                        else showMessageBox(1, "저장이 실패되었습니다.");
                    } else if (jResult.status == "logout") {
                        location.reload();
                    }
                },
                error: function(request, status, error) {
                    //console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                }
            });
        } else {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: { json_: jsonData },
                url: "/bapi/modifyemployee" + location.search,
                success: function(jResult) {

                    if (jResult.status == "success") {
                        closeEmpDlg();
                        showAlertBox(0, "저장완료!");
                        requestEmployee();
                    } else if (jResult.status == "fail") {
                        if (jResult.data == 3)
                            showMessageBox(1, "수수료율이 총판보다 크게 설정되었습니다.");
                        else showMessageBox(1, "저장이 실패되었습니다.");
                    } else if (jResult.status == "logout") {
                        location.reload();
                    }
                },
                error: function(request, status, error) {
                    //console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                }
            });
        }



    }



    function requestEmployee() {

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/bapi/getemployee" + location.search,
            success: function(jResult) {

                if (jResult.status == "success") {
                    showEmployeeData(jResult.data);
                } else if (jResult.status == "logout") {
                    location.reload();
                }
            },
            error: function(request, status, error) {

            }
        });

    }



    function formatStoreUidCell(item) {
        var uid = item.mb_uid;
        if (parseInt(item.mb_store_online, 10) === 1)
            return "<span class=\"employee-mgmt-online-uid\">" + uid + "</span>";
        return uid;
    }

    function showEmployeeData(arrEmployee) {

        m_arrEmployee = arrEmployee;

        var $wrap = $(".employee-mgmt-table");
        var nScrollTop = $wrap.length ? $wrap.find(".el-table__body-wrapper").scrollTop() : 0;

        var tHtml1 = "";
        var tHtml2 = "";

        var tTd1 = "<td><div class=\"cell\">";
        var tTd2 = "<td class=\" is-hidden\"><div class=\"cell\">";

        if (arrEmployee != null && arrEmployee.length > 0) {
            for (var idx in arrEmployee) {
                tHtml1 += " <tr class=\"el-table__row\">";
                tHtml2 += " <tr class=\"el-table__row\">";
                tHtml1 += tTd1;
                tHtml2 += tTd2;
                tHtml1 += formatStoreUidCell(arrEmployee[idx]);
                tHtml2 += formatStoreUidCell(arrEmployee[idx]);
                tHtml1 += "</div></td>";
                tHtml2 += "</div></td>";

                tHtml1 += tTd1;
                tHtml2 += tTd2;
                tHtml1 += arrEmployee[idx].mb_uid;
                tHtml2 += arrEmployee[idx].mb_uid;
                tHtml1 += "</div></td>";
                tHtml2 += "</div></td>";

                tHtml1 += tTd1;
                tHtml2 += tTd2;
                tHtml1 += arrEmployee[idx].mb_pwd;
                tHtml2 += arrEmployee[idx].mb_pwd;
                tHtml1 += "</div></td>";
                tHtml2 += "</div></td>";

                tHtml1 += tTd1;
                tHtml2 += tTd2;
                tHtml1 += arrEmployee[idx].mb_game_pb_ratio;
                tHtml2 += arrEmployee[idx].mb_game_pb_ratio;
                tHtml1 += "</div></td>";
                tHtml2 += "</div></td>";

                tHtml1 += tTd1;
                tHtml2 += tTd2;
                tHtml1 += parseInt(arrEmployee[idx].mb_money).toLocaleString();
                tHtml2 += parseInt(arrEmployee[idx].mb_money).toLocaleString();
                tHtml1 += "</div></td>";
                tHtml2 += "</div></td>";

                tHtml1 += tTd1;
                tHtml2 += tTd2;
                tHtml1 += parseInt(arrEmployee[idx].mb_point).toLocaleString();
                tHtml2 += parseInt(arrEmployee[idx].mb_point).toLocaleString();
                tHtml1 += "</div></td>";
                tHtml2 += "</div></td>";

                tHtml1 += tTd1;
                tHtml2 += tTd2;
                tHtml1 += parseInt(arrEmployee[idx].mb_limit_round).toLocaleString();
                tHtml2 += parseInt(arrEmployee[idx].mb_limit_round).toLocaleString();
                tHtml1 += "</div></td>";
                tHtml2 += "</div></td>";

                tHtml1 += tTd1;
                tHtml2 += tTd2;
                tHtml1 += parseInt(arrEmployee[idx].mb_limit_single).toLocaleString();
                tHtml2 += parseInt(arrEmployee[idx].mb_limit_single).toLocaleString();
                tHtml1 += "</div></td>";
                tHtml2 += "</div></td>";

                tHtml1 += tTd1;
                tHtml2 += tTd2;
                tHtml1 += parseInt(arrEmployee[idx].mb_limit_mix).toLocaleString();
                tHtml2 += parseInt(arrEmployee[idx].mb_limit_mix).toLocaleString();
                tHtml1 += "</div></td>";
                tHtml2 += "</div></td>";

                tHtml1 += tTd1;
                tHtml2 += tTd2;
                tHtml1 += arrEmployee[idx].mb_time_join;
                tHtml2 += arrEmployee[idx].mb_time_join;
                tHtml1 += "</div></td>";
                tHtml2 += "</div></td>";

                tHtml1 += tTd1;
                tHtml2 += tTd2;
                tHtml1 += arrEmployee[idx].mb_time_last;
                tHtml2 += arrEmployee[idx].mb_time_last;
                tHtml1 += "</div></td>";
                tHtml2 += "</div></td>";

                tHtml1 += tTd2;
                tHtml2 += tTd1;
                tHtml1 += "<button type=\"button\" onclick=\"modifyEmpDlg(" + idx + ");\" class=\"el-button el-button--primary el-button--mini star-icon-btn\" title=\"수정\"><i class=\"fas fa-pen\"></i></button>";
                tHtml2 += "<button type=\"button\" onclick=\"modifyEmpDlg(" + idx + ");\" class=\"el-button el-button--primary el-button--mini star-icon-btn\" title=\"수정\"><i class=\"fas fa-pen\"></i></button>";

                tHtml1 += "</div></td></tr>";
                tHtml2 += "</div></td></tr>";
            }

        }

        $("#main-employee1-id").html(tHtml1);
        $("#main-employee2-id").html(tHtml2);

        syncEmployeeTableScroll(nScrollTop);
    }

    function syncEmployeeTableScroll(preserveTop) {
        var $wrap = $(".employee-mgmt-table");
        if (!$wrap.length) return;
        var $main = $wrap.find(".el-table__body-wrapper");
        var $fixed = $wrap.find(".el-table__fixed-body-wrapper");
        $main.off("scroll.empMgmt").on("scroll.empMgmt", function() {
            $fixed.scrollTop($main.scrollTop());
        });
        if (typeof preserveTop === "number" && preserveTop > 0) {
            $main.scrollTop(preserveTop);
            $fixed.scrollTop(preserveTop);
        } else {
            $fixed.scrollTop(0);
            $main.scrollTop(0);
        }
    }