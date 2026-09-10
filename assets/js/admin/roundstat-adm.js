
var m_rsSelected = {};
var m_rsBettingOpen = true;
var m_rsTimerCtx = null;
var m_rsTimerRows = null;
/** 서버 동기 후 보간 — main.js betcloserest: 배팅 중엔 round_end까지 남은 시간, 마감 후엔 표시 교체 */
var m_rsSrvUnix = null;
var m_rsDrawEndUnix = null;
var m_rsBetEndUnix = null;
var m_rsPollPerfMs = null;
var m_rsContextFailBanner = false;
/** roundstatcontext: 다음 추첨 시각에 대응하는 PBG drawn_at 슬롯 (안내·불일치 경고용) */
var m_rsPbgDrawnAtSlot = null;
/** 이력 행 변화 없을 때 진행 행만 갱신해 2.5초 폴링 깜박임 제거 */
var m_rsLastHistKey = null;
var m_rsLastLiveSig = null;
var RS_EXCLUSIVE = {
	pb_holu: ["pb_jjak"], pb_jjak: ["pb_holu"],
	pb_under: ["pb_over"], pb_over: ["pb_under"],
	nb_holu: ["nb_jjak"], nb_jjak: ["nb_holu"],
	nb_under: ["nb_over"], nb_over: ["nb_under"]
};

/** 첫 행(진행 회차): 합계 금액 비교용 열 키 — RS_EXCLUSIVE 쌍과 동일 순서 */
var RS_LIVE_COMPARE_PAIRS = [
	["pb_holu", "pb_jjak"],
	["pb_under", "pb_over"],
	["nb_holu", "nb_jjak"],
	["nb_under", "nb_over"]
];

var RS_KEY_LABELS = {
	pb_holu: "파워볼홀",
	pb_jjak: "파워볼짝",
	pb_under: "파워볼언더",
	pb_over: "파워볼오버",
	nb_holu: "일반볼홀",
	nb_jjak: "일반볼짝",
	nb_under: "일반볼언더",
	nb_over: "일반볼오버"
};

function rsSelectedLabelsForKeys(keys){
	var out = [];
	for(var i = 0; i < keys.length; i++){
		out.push(RS_KEY_LABELS[keys[i]] || keys[i]);
	}
	return out.join(", ");
}

function rsFmtWon(n){
	var x = parseInt(n, 10) || 0;
	return x.toLocaleString() + "원";
}

/** 브라우저/PC 타임존과 무관하게 KST(서울) 시:분:초 */
function rsFormatSeoulHms(){

	return new Date().toLocaleTimeString("sv-SE", { timeZone: "Asia/Seoul" });
}

function rsStartLiveClock(){

	if(window._rsClkIv) clearInterval(window._rsClkIv);
	window._rsClkIv = setInterval(function(){
		$("#roundstat-live-clock").text(rsFormatSeoulHms());
	}, 500);
}

function rsStartCountdownInterpolated(){

	if(window._rsCdIv) clearInterval(window._rsCdIv);
	window._rsCdIv = setInterval(rsTickCountdownDisplay, 200);
}

/** 카운트다운 보간과 동일한 “서버 시각” (추첨변경 버튼 활성 시점을 배팅종료 문구와 맞추기 위함) */
function rsApproxServerUnix(){

	if(m_rsSrvUnix == null || m_rsPollPerfMs == null){
		return null;
	}
	var perfMs = (typeof performance !== "undefined" && typeof performance.now === "function") ? performance.now() : Date.now();
	return m_rsSrvUnix + (perfMs - m_rsPollPerfMs) / 1000;
}

/** rsTickCountdownDisplay와 동일: 배팅 마감 시각 경과 여부 */
function rsIsPastBetEndByClock(){

	if(m_rsBetEndUnix == null){
		return false;
	}
	var a = rsApproxServerUnix();
	if(a == null){
		return false;
	}
	return a >= m_rsBetEndUnix;
}

/** 배팅종료로 볼 수 있는가 — 서버 플래그 또는 보간 시각(폴링 지연 없이 카운트다운과 일치) */
function rsIsBettingClosedEffective(){

	return !m_rsBettingOpen || rsIsPastBetEndByClock();
}

function rsTickCountdownDisplay(){

	if(m_rsSrvUnix == null || m_rsPollPerfMs == null){
		return;
	}
	var approxSrv = rsApproxServerUnix();
	if(approxSrv == null){
		return;
	}
	if(m_rsBetEndUnix != null && approxSrv >= m_rsBetEndUnix){
		$("#roundstat-countdown").text("배팅종료");
		rsUpdateDrawChangeBtn();
		return;
	}
	if(m_rsDrawEndUnix == null){
		return;
	}
	var rem = Math.max(0, Math.floor(m_rsDrawEndUnix - approxSrv));
	$("#roundstat-countdown").text(rsFmtCountdown(rem));
	rsUpdateDrawChangeBtn();
}

function rsApplyContextCountdownSync(data){

	if(!data || data.server_unix == null){
		return;
	}
	m_rsSrvUnix = parseInt(data.server_unix, 10);
	var drawUx = data.round_draw_end_unix != null ? parseInt(data.round_draw_end_unix, 10)
		: (data.countdown_until_unix != null ? parseInt(data.countdown_until_unix, 10) : NaN);
	m_rsDrawEndUnix = !isNaN(drawUx) ? drawUx : null;
	var betUx = data.round_bet_end_unix != null ? parseInt(data.round_bet_end_unix, 10) : NaN;
	m_rsBetEndUnix = !isNaN(betUx) ? betUx : null;
	m_rsPollPerfMs = (typeof performance !== "undefined" && typeof performance.now === "function") ? performance.now() : Date.now();
	rsTickCountdownDisplay();
}

function rsFmtCountdown(sec){
	sec = parseInt(sec, 10);
	if(isNaN(sec) || sec < 0) sec = 0;
	var m = Math.floor(sec / 60);
	var s = sec % 60;
	return "[" + ("0" + m).slice(-2) + ":" + ("0" + s).slice(-2) + "]";
}

function rsAnySelected(){
	for(var k in m_rsSelected){
		if(m_rsSelected[k]) return true;
	}
	return false;
}

function rsUpdateDrawChangeBtn(){

	var ok = rsIsBettingClosedEffective() && rsAnySelected();
	var $b = $("#roundstat-drawchange-btn");
	$b.prop("disabled", !ok);
	$b.toggleClass("roundstat-drawchange-btn--ready", ok);
	$b.toggleClass("roundstat-drawchange-btn--locked", !ok);
	if(!ok){
		$("#roundstat-queued-cond").empty();
	}
	$b.attr("title", ok
		? "배팅마감이며 열을 선택한 뒤 한 번 클릭하면 파워볼 서버로 추첨변경 요청이 곧바로 전달됩니다."
		: "배팅마감 이면서 파워볼·일반볼 열 중 하나 이상 선택 시 사용할 수 있습니다.");
}

function rsReflectHeaderSelectionClasses(){
	$(".roundstat-selectable-th").each(function(){
		var k = $(this).attr("data-rsk");
		var on = !!(k && m_rsSelected[k]);
		$(this).toggleClass("is-selected", on);
		$(this).toggleClass("is-blocked-peer", false);
	});
	var peerBlocked = {};
	for(var sel in m_rsSelected){
		if(!m_rsSelected[sel]) continue;
		var ex = RS_EXCLUSIVE[sel];
		if(ex){
			for(var i = 0; i < ex.length; i++) peerBlocked[ex[i]] = 1;
		}
	}
	$(".roundstat-selectable-th").each(function(){
		var k = $(this).attr("data-rsk");
		if(!k || m_rsSelected[k]) return;
		$(this).toggleClass("is-blocked-peer", !!peerBlocked[k]);
	});
}

function rsToggleHeaderKey(key){

	if(!m_rsSelected[key] && peerBlockedWithoutSelecting(key)){
		return;
	}
	if(m_rsSelected[key]){
		delete m_rsSelected[key];
	} else {
		if(RS_EXCLUSIVE[key]){
			for(var i = 0; i < RS_EXCLUSIVE[key].length; i++){
				delete m_rsSelected[RS_EXCLUSIVE[key][i]];
			}
		}
		m_rsSelected[key] = 1;
	}
	rsReflectHeaderSelectionClasses();
	rsUpdateDrawChangeBtn();
}

function peerBlockedWithoutSelecting(key){
	for(var sel in m_rsSelected){
		if(!m_rsSelected[sel]) continue;
		var ex = RS_EXCLUSIVE[sel];
		if(ex && ex.indexOf(key) >= 0) return true;
	}
	var ex2 = RS_EXCLUSIVE[key];
	if(ex2){
		for(var j = 0; j < ex2.length; j++){
			var o = ex2[j];
			if(m_rsSelected[o]) return true;
		}
	}
	return false;
}

function rsCellSum(r, key){
	switch(key){
		case "pb_holu": return parseInt(r.sum_pb_holu, 10) || 0;
		case "pb_jjak": return parseInt(r.sum_pb_jjak, 10) || 0;
		case "pb_under": return parseInt(r.sum_pb_under, 10) || 0;
		case "pb_over": return parseInt(r.sum_pb_over, 10) || 0;
		case "nb_holu": return parseInt(r.sum_nb_holu, 10) || 0;
		case "nb_jjak": return parseInt(r.sum_nb_jjak, 10) || 0;
		case "nb_under": return parseInt(r.sum_nb_under, 10) || 0;
		case "nb_over": return parseInt(r.sum_nb_over, 10) || 0;
		default: return 0;
	}
}

function rsHistoryRowSig(r){

	if(!r){
		return "";
	}
	var parts = [
		r.bet_round_fid, r.bet_round_no,
		r.sum_pb_holu, r.sum_pb_jjak, r.sum_pb_under, r.sum_pb_over,
		r.sum_nb_holu, r.sum_nb_jjak, r.sum_nb_under, r.sum_nb_over
	];
	var out = "";
	for(var i = 0; i < parts.length; i++){
		out += (i ? "|" : "") + (parts[i] != null && parts[i] !== "" ? String(parts[i]) : "");
	}
	return out;
}

function rsLiveRowSig(r){

	if(!r){
		return "";
	}
	var fid = r.bet_round_fid != null ? String(r.bet_round_fid) : "";
	var rn = r.bet_round_no != null ? String(r.bet_round_no) : "";
	var label = fid && rn ? (fid + "(" + rn + ")회") : (fid || rn || "—");
	var k = ["pb_holu", "pb_jjak", "pb_under", "pb_over", "nb_holu", "nb_jjak", "nb_under", "nb_over"];
	var parts = [label, fid, rn];
	for(var c = 0; c < k.length; c++){
		parts.push(String(rsCellSum(r, k[c])));
	}
	return parts.join("|");
}

/** 맨 위 행(진행 회차): 대응 열 쌍에서 합계가 더 작은 쪽만 하이라이트 (동률이면 둘 다 해제) */
function rsApplyLiveRowMinHighlight(){

	var $tr = $("#roundstat-tbody-id tr:first");
	if(!$tr.length){
		return;
	}
	$tr.find("td[data-rscell]").removeClass("roundstat-live-min");

	for(var p = 0; p < RS_LIVE_COMPARE_PAIRS.length; p++){
		var a = RS_LIVE_COMPARE_PAIRS[p][0];
		var b = RS_LIVE_COMPARE_PAIRS[p][1];
		var $ta = $tr.find('td[data-rscell="' + a + '"]');
		var $tb = $tr.find('td[data-rscell="' + b + '"]');
		if(!$ta.length || !$tb.length){
			continue;
		}
		var va = parseInt($ta.attr("data-rs-sum"), 10) || 0;
		var vb = parseInt($tb.attr("data-rs-sum"), 10) || 0;
		if(va < vb){
			$ta.addClass("roundstat-live-min");
		} else if(vb < va){
			$tb.addClass("roundstat-live-min");
		}
	}
}

function rsPatchLiveRowOnly(r){

	var fid = r.bet_round_fid != null ? String(r.bet_round_fid) : "";
	var rn = r.bet_round_no != null ? String(r.bet_round_no) : "";
	var label = fid && rn ? (fid + "(" + rn + ")회") : (fid || rn || "—");
	var $tr = $("#roundstat-tbody-id tr:first");
	if(!$tr.length){
		return;
	}
	$tr.children("td").eq(1).find(".cell").text(label);
	var k = ["pb_holu", "pb_jjak", "pb_under", "pb_over", "nb_holu", "nb_jjak", "nb_under", "nb_over"];
	for(var c = 0; c < k.length; c++){
		var kk = k[c];
		var sum = rsCellSum(r, kk);
		$tr.find('td[data-rscell="' + kk + '"]').attr("data-rs-sum", sum).find(".cell").text(rsFmtWon(r["sum_" + kk]));
	}
}

function rsRenderRows(arr){

	var $tbody = $("#roundstat-tbody-id");
	if(!arr || arr.length < 1){
		m_rsLastHistKey = null;
		m_rsLastLiveSig = null;
		$tbody.empty();
		return;
	}

	var histKey = "";
	for(var h = 1; h < arr.length; h++){
		histKey += (h > 1 ? "\n" : "") + rsHistoryRowSig(arr[h]);
	}
	var liveSig = rsLiveRowSig(arr[0]);
	var n = $tbody.find("tr").length;

	if(n === arr.length && m_rsLastHistKey === histKey){
		if(m_rsLastLiveSig === liveSig){
			return;
		}
		rsPatchLiveRowOnly(arr[0]);
		m_rsLastLiveSig = liveSig;
		rsApplyLiveRowMinHighlight();
		return;
	}

	m_rsLastHistKey = histKey;
	m_rsLastLiveSig = liveSig;

	var html = "";
	for(var i = 0; i < arr.length; i++){
		var r = arr[i];
		var fid = r.bet_round_fid != null ? String(r.bet_round_fid) : "";
		var rn = r.bet_round_no != null ? String(r.bet_round_no) : "";
		var label = fid && rn ? (fid + "(" + rn + ")회") : (fid || rn || "—");
		var isLive = i === 0;
		html += "<tr>";
		html += "<td><div class=\"cell\">PBG</div></td>";
		html += "<td><div class=\"cell roundstat-cell-round\">" + label + "</div></td>";

		if(isLive){
			var k = ["pb_holu", "pb_jjak", "pb_under", "pb_over", "nb_holu", "nb_jjak", "nb_under", "nb_over"];
			for(var c = 0; c < k.length; c++){
				var kk = k[c];
				var sum = rsCellSum(r, kk);
				html += "<td data-rscell=\"" + kk + "\" data-rs-sum=\"" + sum + "\"><div class=\"cell\">" + rsFmtWon(r["sum_" + kk]) + "</div></td>";
			}
		} else {
			html += "<td><div class=\"cell\">" + rsFmtWon(r.sum_pb_holu) + "</div></td>";
			html += "<td><div class=\"cell\">" + rsFmtWon(r.sum_pb_jjak) + "</div></td>";
			html += "<td><div class=\"cell\">" + rsFmtWon(r.sum_pb_under) + "</div></td>";
			html += "<td><div class=\"cell\">" + rsFmtWon(r.sum_pb_over) + "</div></td>";
			html += "<td><div class=\"cell\">" + rsFmtWon(r.sum_nb_holu) + "</div></td>";
			html += "<td><div class=\"cell\">" + rsFmtWon(r.sum_nb_jjak) + "</div></td>";
			html += "<td><div class=\"cell\">" + rsFmtWon(r.sum_nb_under) + "</div></td>";
			html += "<td><div class=\"cell\">" + rsFmtWon(r.sum_nb_over) + "</div></td>";
		}
		html += "</tr>";
	}
	$tbody.html(html);
	rsApplyLiveRowMinHighlight();
}

function requestRoundstatContext(){

	$.ajax({
		type: "POST",
		dataType: "json",
		url: "/capi/roundstatcontext" + location.search,
		success: function(j){

			if(j.status === "logout"){
				location.reload();
				return;
			}
			if(j.status !== "success" || !j.data){
				if(!m_rsContextFailBanner){
					m_rsContextFailBanner = true;
					if(typeof showMessageBox === "function"){
						showMessageBox(1, "진행 회차 정보를 불러오지 못했습니다. 주소에 로그인 파라미터(?l=...)가 있는지, conf_game 설정을 확인해 주세요.");
					}
				}
				return;
			}
			m_rsContextFailBanner = false;

			m_rsBettingOpen = !!j.data.betting_open;
			m_rsPbgDrawnAtSlot = (j.data.pbg_drawn_at_slot != null && String(j.data.pbg_drawn_at_slot).length > 0)
				? String(j.data.pbg_drawn_at_slot).trim() : null;

			var rid = (j.data.round_id !== undefined && j.data.round_id !== null && j.data.round_id !== "") ? j.data.round_id : "—";
			var rno = (j.data.round_no !== undefined && j.data.round_no !== null && j.data.round_no !== "") ? j.data.round_no : "—";
			$("#roundstat-round-line").text("진행회차 " + rid + "(" + rno + ")회");

			rsApplyContextCountdownSync(j.data);

			rsUpdateDrawChangeBtn();
		},
		error: function(xhr){
			if(!m_rsContextFailBanner){
				m_rsContextFailBanner = true;
				var t = (xhr && xhr.status) ? (" HTTP " + xhr.status) : "";
				if(typeof showMessageBox === "function"){
					showMessageBox(1, "진행 회차 정보 요청 실패입니다." + t + " 새로고침 후 재시도해 주세요.");
				}
			}
		}
	});
}

function requestRoundstatRows(){

	$.ajax({
		type: "POST",
		dataType: "json",
		url: "/capi/roundstatrows" + (location.search ? location.search + "&" : "?") + "limit=9",
		success: function(j){
			if(j.status === "logout"){
				location.reload();
				return;
			}
			if(j.status !== "success" || !j.data){
				rsRenderRows([]);
				return;
			}
			rsRenderRows(j.data);
		},
		error: function(){
			rsRenderRows([]);
		}
	});
}

function unlockRoundstat(pwd){

	var pw = (pwd != null) ? String(pwd) : "";
	var jsonData = JSON.stringify({ pwd: pw });
	$("#roundstat-pwd-err").text("");
	if(pw.length < 1){
		$("#roundstat-pwd-err").text("암호를 입력하세요.");
		$("#roundstat-pwd-input").focus();
		return;
	}
	$.ajax({
		type: "POST",
		dataType: "json",
		data: { json_: jsonData },
		url: "/capi/roundstatunlock" + location.search,
		success: function(j){

            if(j.status === "success"){
				m_rsContextFailBanner = false;
				$("#roundstat-lock-overlay").hide();
				$("#roundstat-main-panel").show();
				rsStartLiveClock();
				rsStartCountdownInterpolated();
				requestRoundstatContext();
				requestRoundstatRows();
				if(m_rsTimerCtx) clearInterval(m_rsTimerCtx);
				m_rsTimerCtx = setInterval(requestRoundstatContext, 6000);
				if(m_rsTimerRows) clearInterval(m_rsTimerRows);
				m_rsTimerRows = setInterval(requestRoundstatRows, 2500);
			} else if(j.status === "fail"){
				var remain = (j.remain_attempts != null) ? parseInt(j.remain_attempts, 10) : NaN;
				if(j.data === 4){
					$("#roundstat-pwd-err").text("암호 5회 오류로 계정과 접속 IP가 차단되었습니다. 관리자에게 문의하세요.");
				} else if(j.data === 3){
					$("#roundstat-pwd-err").text("암호 입력 가능 횟수를 모두 사용했습니다. 관리자에게 문의하세요.");
				} else if(!isNaN(remain)){
					$("#roundstat-pwd-err").text("암호가 올바르지 않습니다. 남은 횟수: " + remain + "/5");
				} else {
					$("#roundstat-pwd-err").text("암호가 올바르지 않습니다.");
				}
				$("#roundstat-pwd-input").val("").focus();
			}
		}
	});
}

/** 추첨변경: 확인·다이얼로그 없이 즉시 파워볼(PBG) 큐 API 호출 */
function admRoundstatQueueConstraintNow(){

	if($("#roundstat-drawchange-btn").prop("disabled")){
		return;
	}
	var keys = [];
	for(var k in m_rsSelected){
		if(m_rsSelected[k]) keys.push(k);
	}
	if(keys.length < 1){
		if(typeof showMessageBox === "function"){
			showMessageBox(1, "적용할 열을 표에서 먼저 선택하세요.");
		}
		return;
	}
	var $btn = $("#roundstat-drawchange-btn");
	if($btn.data("rs-sending")){
		return;
	}
	var $span = $btn.find("span");
	var prevText = $span.text();
	$btn.data("rs-sending", true).prop("disabled", true);
	$span.text("전송 중…");

	$.ajax({
		type: "POST",
		dataType: "json",
		data: { json_: JSON.stringify({ keys: keys }) },
		url: "/capi/roundstatpbgqueueconstraint" + location.search,
		complete: function(){

			$btn.data("rs-sending", false);
			$span.text(prevText);
			rsUpdateDrawChangeBtn();
		},
		success: function(j){

			if(j.status === "logout"){
				location.reload();
				return;
			}
			if(j.status === "success"){
				var at = (j.drawn_at != null) ? String(j.drawn_at).trim() : (j.data && j.data.drawn_at ? String(j.data.drawn_at).trim() : "");
				var cond = rsSelectedLabelsForKeys(keys);
				var queuedLine = "추첨조건 " + cond;
				if(at){
					queuedLine += " · 적용슬롯 " + at;
				}
				$("#roundstat-queued-cond").text(queuedLine);
				var msg = "";
				if(at){
					msg = "PBG 추첨 적용 시각(KST): " + at + "\n";
					msg += "※ 위 시각의 5분 슬롯 추첨에만 조건이 반영됩니다. (다른 시각이면 적용되지 않습니다.)\n\n";
				} else {
					msg = "파워볼 추첨 서버가 요청을 접수했습니다.\n\n";
				}
				msg += "조건: " + cond;
				if(m_rsPbgDrawnAtSlot && at && m_rsPbgDrawnAtSlot !== at){
					msg += "\n\n[확인] 직전 화면에 표시된 진행 회차 종료 슬롯(" + m_rsPbgDrawnAtSlot + ")과 접수된 슬롯이 다릅니다.\n요청 순간 서버가 계산한 '다음 추첨' 슬롯이 적용됩니다. 원하는 회차와 같다면 슬롯을 다시 확인하세요.";
				}
				if(typeof showAlertBox === "function"){
					showAlertBox(0, msg);
				} else {
					alert(msg);
				}
				return;
			}
			var m = j.msg ? j.msg : "요청 실패";
			if(j.remote && j.remote.msg){
				m += " — " + j.remote.msg;
			} else if(j.raw){
				m += " — " + String(j.raw).slice(0, 120);
			}
			var lower = String(m).toLowerCase();
			if(lower.indexOf("already exists") >= 0 || lower.indexOf("already_exists") >= 0 || lower.indexOf("drawn") >= 0 || lower.indexOf("closed") >= 0){
				m = "추첨이 이미 진행되어 변경할 수 없습니다. 다음 회차에서 다시 시도해 주세요.";
			}
			if(typeof showMessageBox === "function"){
				showMessageBox(1, m);
			}
		},
		error: function(){

			if(typeof showMessageBox === "function"){
				showMessageBox(1, "네트워크 오류로 요청을 보내지 못했습니다.");
			}
		}
	});
}

function admRoundstatChgPwdDlg(){
	$("#roundstat-chgpwd-old").val("");
	$("#roundstat-chgpwd-new").val("");
	$("#roundstat-chgpwd-dialog").show();
}

function admRoundstatSavePwd(){

	var oldP = $("#roundstat-chgpwd-old").val();
	var newP = $("#roundstat-chgpwd-new").val();
	if(oldP.length < 1 || newP.length < 1){
		showMessageBox(1, "현재 암호와 새 암호를 입력하세요.");
		return;
	}
	var jsonData = JSON.stringify({ old_pwd: oldP, new_pwd: newP });
	$.ajax({
		type: "POST",
		dataType: "json",
		data: { json_: jsonData },
		url: "/capi/roundstatchgpwd" + location.search,
		success: function(j){
			if(j.status === "logout"){
				location.reload();
				return;
			}
			if(j.status === "success"){
				$("#roundstat-chgpwd-dialog").hide();
				showAlertBox(0, "암호가 변경되었습니다.");
			} else if(j.status === "fail"){
				showMessageBox(1, "현재 암호가 일치하지 않거나 저장에 실패했습니다.");
			}
		}
	});
}

$(document).ready(function(){

	var alreadyOk = ($("main.el-main").attr("data-roundstat-unlocked") === "1");

	function rsEnterUnlocked(){
		m_rsContextFailBanner = false;
		$("#roundstat-lock-overlay").hide();
		$("#roundstat-main-panel").show();
		rsStartLiveClock();
		rsStartCountdownInterpolated();
		requestRoundstatContext();
		requestRoundstatRows();
		if(m_rsTimerCtx) clearInterval(m_rsTimerCtx);
		m_rsTimerCtx = setInterval(requestRoundstatContext, 6000);
		if(m_rsTimerRows) clearInterval(m_rsTimerRows);
		m_rsTimerRows = setInterval(requestRoundstatRows, 2500);
	}

	if(alreadyOk){
		rsEnterUnlocked();
	} else {
		$("#roundstat-main-panel").hide();
		$("#roundstat-lock-overlay").show();
		setTimeout(function(){
			$("#roundstat-pwd-input").focus();
		}, 0);
	}

	$("#roundstat-pwd-submit").on("click", function(){
		unlockRoundstat($("#roundstat-pwd-input").val());
	});
	$("#roundstat-pwd-cancel").on("click", function(){
		if(window.history.length > 1){
			window.history.back();
			return;
		}
		if(typeof clickMenu === "function"){
			clickMenu(2);
		}
	});

	$("#roundstat-panel-close").on("click", function(){
		if(window.history.length > 1){
			window.history.back();
			return;
		}
		if(typeof clickMenu === "function"){
			clickMenu(2);
		}
	});

	$("#roundstat-pwd-input").on("keydown", function(e){
		if(e.keyCode === 13){
			unlockRoundstat($(this).val());
		}
	});

	$(".roundstat-selectable-th").on("click", function(){
		var key = $(this).attr("data-rsk");
		if(!key) return;
		rsToggleHeaderKey(key);
	});

	$("#roundstat-drawchange-btn").on("click", function(){
		admRoundstatQueueConstraintNow();
	});
});
