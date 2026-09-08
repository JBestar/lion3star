<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="ko">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?=$site_name?></title>
	
	<link rel="stylesheet" href="<?php echo base_url('assets/css/login.css');?>">
	
	<script src="<?php echo base_url('assets/jslib/jquery-1.12.4.min.js'); ?>"></script>

</head>

<body>
	<div class="login-background-panel">
		<div class="login-header">
			<img class="login-logo" src="<?php echo base_url('assets/image/star_logo.png'); ?>" alt="Star">
			<div class="login-modal-panel">
				<div class="login-item-div">
					<label class="login-item-label">아이디:</label>
					<div class="login-item-content">
						<input type="text" class="login-item-input" id="login-user-id" autocomplete="off" onKeyDown="onEnter();">
					</div>
				</div>
				<div class="login-item-div">
					<label class="login-item-label">비밀번호:</label>
					<div class="login-item-content">
						<input type="password" class="login-item-input" id="login-pwd-id" autocomplete="off" onKeyDown="onEnter();">
					</div>
				</div>
				<button type="button" class="login-button button-primary" onclick="login();">로그인</button>
			</div>
		</div>
		<div class="login-star-wrap">
			<img class="login-star" src="<?php echo base_url('assets/image/gold_star.png'); ?>" alt="star">
		</div>
	</div>

</body>

<script>
function onEnter()
{
	if( window.event.keyCode == 13 ) login();
}

function login()
{
	var strId = document.getElementById('login-user-id').value;
	var strPwd = document.getElementById('login-pwd-id').value;

	if( strId.length == 0 )
	{
		alert('아이디를 입력해주세요');
		return false;
	}

	if( strPwd.length == 0 )
	{
		alert('비밀번호를 입력해주세요');
		return false;
	}

	var objData = { "username":strId, "password":strPwd};
    var jsonData = JSON.stringify(objData);

	$.ajax({
		type: "POST",
		dataType: "json",
		url:"/bapi/login",
		data: {json_: jsonData},
		success: function(jResult) {
			if(jResult.status == "success")
			{
				location.replace('/control?l='+jResult.data);
			}
			else if(jResult.status == "fail")
			{
				if(jResult.code == 2)
					alert('잘못된 계정정보 입니다.');
				else if(jResult.code == 5)
					alert('중복로그인!');
				
			}
		},  
		error:function(request,status,error){
			
		}
	});

	   
}

</script>
</html>
