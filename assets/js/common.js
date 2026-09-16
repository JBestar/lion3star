
function getBetDetail(iMode) {
    var tBetDetail = "";
    iMode = parseInt(iMode);
    switch (iMode) {
        case 1:
            tBetDetail = "파워볼 홀";
            break;
        case 2:
            tBetDetail = "파워볼 짝";
            break;
        case 3:
            tBetDetail = "파워볼 언더";
            break;
        case 4:
            tBetDetail = "파워볼 오버";
            break;
        case 5:
            tBetDetail = "파워볼 홀+언더";
            break;
        case 6:
            tBetDetail = "파워볼 짝+언더";
            break;
        case 7:
            tBetDetail = "파워볼 홀+오버";
            break;
        case 8:
            tBetDetail = "파워볼 짝+오버";
            break;
        case 9:
            tBetDetail = "일반볼 홀";
            break;
        case 10:
            tBetDetail = "일반볼 짝";
            break;
        case 11:
            tBetDetail = "일반볼 언더";
            break;
        case 12:
            tBetDetail = "일반볼 오버";
            break;
        case 13:
            tBetDetail = "일반볼 홀+언더";
            break;
        case 14:
            tBetDetail = "일반볼 짝+언더";
            break;
        case 15:
            tBetDetail = "일반볼 홀+오버";
            break;
        case 16:
            tBetDetail = "일반볼 짝+오버";
            break;
        case 17:
            tBetDetail = "일반볼 대";
            break;
        case 18:
            tBetDetail = "일반볼 중";
            break;
        case 19:
            tBetDetail = "일반볼 소";
            break;
        case 20:
            tBetDetail = "일반볼 홀+대";
            break;
        case 21:
            tBetDetail = "일반볼 홀+중";
            break;
        case 22:
            tBetDetail = "일반볼 홀+소";
            break;
        case 23:
            tBetDetail = "일반볼 짝+대";
            break;
        case 24:
            tBetDetail = "일반볼 짝+중";
            break;
        case 25:
            tBetDetail = "일반볼 짝+소";
            break;
        case 30:
            tBetDetail = "숫자 0";
            break;
        case 31:
            tBetDetail = "숫자 1";
            break;
        case 32:
            tBetDetail = "숫자 2";
            break;
        case 33:
            tBetDetail = "숫자 3";
            break;
        case 34:
            tBetDetail = "숫자 4";
            break;
        case 35:
            tBetDetail = "숫자 5";
            break;
        case 36:
            tBetDetail = "숫자 6";
            break;
        case 37:
            tBetDetail = "숫자 7";
            break;
        case 38:
            tBetDetail = "숫자 8";
            break;
        case 39:
            tBetDetail = "숫자 9";
            break;
        case 41:
            tBetDetail = "홀+언더+파홀";
            break;
        case 42:
            tBetDetail = "홀+언더+파짝";
            break;
        case 43:
            tBetDetail = "홀+오버+파홀";
            break;
        case 44:
            tBetDetail = "홀+오버+파짝";
            break;
        case 45:
            tBetDetail = "짝+언더+파홀";
            break;
        case 46:
            tBetDetail = "짝+언더+파짝";
            break;
        case 47:
            tBetDetail = "짝+오버+파홀";
            break;
        case 48:
            tBetDetail = "짝+오버+파짝";
            break;
        default:
            break;
    }
    return tBetDetail;
}


function applyParentLimitPlaceholders(parent) {
    var $ratio = $("#el-dialog-employee-ratio");
    var $round = $("#el-dialog-employee-liround");
    var $single = $("#el-dialog-employee-lisingle");
    var $mix = $("#el-dialog-employee-limix");

    var ratioVal = (parent && parent.mb_game_pb_ratio != null && String(parent.mb_game_pb_ratio) !== "") ? parent.mb_game_pb_ratio : "";
    if (ratioVal === "") {
        $ratio.attr("placeholder", "");
        $ratio.removeAttr("max");
    } else {
        $ratio.attr("placeholder", "최대 " + ratioVal);
        $ratio.attr("max", ratioVal);
    }

    function applyLimit($el, val) {
        if (!$el.length)
            return;
        var n = parseInt(val, 10);
        if (!n || n <= 0) {
            $el.attr("placeholder", "무제한");
            $el.removeAttr("max");
        } else {
            $el.attr("placeholder", "최대 " + n);
            $el.attr("max", n);
        }
    }

    applyLimit($round, parent ? parent.mb_limit_round : 0);
    applyLimit($single, parent ? parent.mb_limit_single : 0);
    applyLimit($mix, parent ? parent.mb_limit_mix : 0);
}


function getBetTypeHtml(type) {
    switch (parseInt(type)) {
        case 1:
        case 9:
            return '홀';
        case 2:
        case 10:
            return '짝';
        case 3:
        case 11:
            return '언더';
        case 4:
        case 12:
            return '오버';
        default:
            return '';
    }
}

/** 헤더 발권기 메뉴 — BIXOLON 드라이버 설치 파일 */
function downloadBixolonDriver() {
    location.href = "/assets/download/bixolon_driver.zip";
}