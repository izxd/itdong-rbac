<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"G:\phptools\Apache24\htdocs\thinkRbac\public/../application/admin\view\index\index.html";i:1526042899;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- semantic css -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.css">
	<link rel="stylesheet" type="text/css" href="/static/css/itdong-flex.css?ver=<?php echo time();?>">
	<link rel="stylesheet" type="text/css" href="/static/css/common.css?ver=<?php echo time();?>">
</head>
<body>
	<style type="text/css">
	.bg-ff0000{
		background: #ff0000;
	}
	.bg-00ff00{
		background: #00ff00;
	}
</style>
<div class="itdong-flex-container
itdong-flex-direction-row
itdong-justify-content-flex-start
itdong-align-items-flex-start
itdong-flex-wrap-nowrap
itdong-align-content-stretch">
<div class="itdong-flex-item-100 itdong-align-self-stretch itdong-flex-1" style="overflow-y: scroll;">
	<div class="ui vertical styled accordion menu">
		<?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $key=>$vo): if(isset($vo['children'])): ?>
		<div class="title"><i class="dropdown icon"></i><?php echo $vo['title']; ?></div>
		<div class="content">

			<div class="ui list">
				<?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): if( count($vo['children'])==0 ) : echo "" ;else: foreach($vo['children'] as $key=>$v): ?>
					<a class="item" data-href="/index.php/<?php echo $v['name']; ?>"><i class="circle outline icon"></i><?php echo $v['title']; ?></a>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</div>

		</div>
		<?php else: ?>
			<div class="title"><i class="folder outline icon"></i><?php echo $vo['title']; ?></div>
			<div class="content">
				<div class="ui list">
					<a class="item"><i class="circle outline icon"></i><?php echo $vo['title']; ?></a>
				</div>
			</div>
		<?php endif; endforeach; endif; else: echo "" ;endif; ?>
	</div>
</div>
<div class="itdong-flex-item-100 itdong-align-self-stretch itdong-flex-5 padding-15">
	<iframe scrolling="yes" src="/admin/index/showRole" name="iframe_a" width="100%" height="95%" frameborder="0"></iframe>
</div>
</div>
<!-- jquery js -->
<script src="/static/js/jquery-3.3.1.js"></script>
<!-- semantic js -->
<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.js"></script>
<!-- customize js -->
<script type="text/javascript">
	$('.ui.accordion').accordion({
		exclusive:true,
		animateChildren:false,
		closeNested:true,
		duration:100,
		selector:{}
	});

	$(document).ready(function(){

		// 获取页面元素
		var frame_a = document.getElementsByName("iframe_a")[0];

		// submenu导航
		$(".ui a").click(function(){

			var changeUrl = $(this).attr("data-href") + "?requestNum=2";
			frame_a.src = changeUrl;

		});
	});
</script>
</body>
</html>