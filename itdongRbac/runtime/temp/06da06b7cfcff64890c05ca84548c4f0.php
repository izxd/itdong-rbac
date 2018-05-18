<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:74:"D:\wamp64\www\itdongRbac\public/../application/admin\view\login\index.html";i:1526629618;s:65:"D:\wamp64\www\itdongRbac\application\admin\view\login\header.html";i:1526629820;s:65:"D:\wamp64\www\itdongRbac\application\admin\view\login\script.html";i:1526519954;s:71:"D:\wamp64\www\itdongRbac\application\admin\view\login\script-login.html";i:1526526349;s:65:"D:\wamp64\www\itdongRbac\application\admin\view\login\footer.html";i:1526519805;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>透传云</title>
	<!-- semantic css -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.css">
	<!-- common.css -->
	<link rel="stylesheet" type="text/css" href="/static/css/common.css?ver=<?php echo time();?>">
	<!-- itdong-flex.css -->
	<link rel="stylesheet" type="text/css" href="/static/css/itdong-flex.css?ver=<?php echo time();?>">
</head>
<body>

<div class="ui middle aligned container grid">
	<div class="four wide column"></div>
	<div class="eight wide column">
		<h2 class="ui header">
			<i class="plug icon"></i>
			<div class="content">透传云</div>
		</h2>
		<div class="ui form">
			<div class="field">
				<label>用户名</label>
				<input type="text" id="username" name="username" placeholder="请输入用户名/邮箱/手机号">
			</div>
			<div class="field">
				<label>密码</label>
				<input type="password" id="password" name="password" placeholder="请输入密码">
			</div>
			<button id="login" class="ui button" type="button">登录</button>
		</div>
	</div>
	<div class="four wide column"></div>
</div>

<!-- jquery js -->
<script src="/static/js/jquery-3.3.1.js"></script>
<!-- semantic js -->
<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.js"></script>
<script type="text/javascript">
	
</script>
</body>
</html>