<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"G:\phptools\Apache24\htdocs\thinkRbac\public/../application/index\view\index\index.html";i:1525871827;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title>首页</title>
	<!-- semantic css -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.css">
	<link rel="stylesheet" type="text/css" href="/static/css/itdong-flex.css">
</head>
<body>
	<div class="itdong-flex-container itdong-flex-direction-row itdong-justify-content-center itdong-align-items-center itdong-flex-wrap-nowrap">

		<div class="itdong-flex-item itdong-align-self-center">
			<button id="redirection" class="ui button">跳转</button>
		</div>
		
	</div>
	
	<!-- jquery js -->
	<script src="static/js/jquery-3.3.1.js"></script>
	<!-- semantic js -->
	<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.js"></script>
	<script type="text/javascript">
		window.onload = function(){
			document.getElementById("redirection").addEventListener("click", function(){
				window.location.href="admin/index";
			});
		}
	</script>
</body>
</html>