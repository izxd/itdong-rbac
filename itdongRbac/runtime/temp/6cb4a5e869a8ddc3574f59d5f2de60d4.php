<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\wamp64\www\itdongRbac\public/../application/admin\view\user\index.html";i:1526552302;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title>用户列表</title>
	<!-- semantic css -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.css">
	<link rel="stylesheet" type="text/css" href="/static/css/metroStyle/metroStyle.css?ver=<?php echo time();?>">
</head>
<body>
	<table class="ui red table">
	<thead>
		<tr>
			<th>id</th>
			<th>登录名</th>
			<th>注册邮箱</th>
			<th>创建时间</th>
			<th>最后登录时间</th>
			<th>最后登录IP</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<?php if(is_array($users) || $users instanceof \think\Collection || $users instanceof \think\Paginator): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		<tr>
			<td><?php echo $vo['id']; ?></td>
			<td><?php echo $vo['username']; ?></td>
			<td><?php echo $vo['email']; ?></td>
			<td>
				<?php echo $vo['create_time']; ?>
				
			</td>
			<td>
				<?php
					if(empty($vo["last_login_time"])){
						echo "未设置";
					}else{
						echo $vo["last_login_time"];
					}
				?>
			</td>
			<td>
				<?php echo $vo['last_login_ip']; ?>
			</td>
			<td>
				<button onclick="editUser(<?php echo $vo['id']; ?>,'<?php echo $vo['username']; ?>','<?php echo $vo['email']; ?>')" class="ui inverted blue button">编辑</button> 
				<button onclick="deleteUser(<?php echo $vo['id']; ?>)" class="ui inverted red button">删除</button>
			</td>
		</tr>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</tbody>
</table>

<!-- 删除模态框开始 -->
<div class="ui mini modal">
	<div class="header">删除权限</div>
	<div class="content">
		<p>你确定要删除这个权限吗？</p>
	</div>
	<div class="actions">
		<button class="ui primary button">否</button>
		<button class="ui negative button">是</button>
	</div>
</div>
<!-- 删除模态框结束 -->

<!-- 用户编辑模态框开始 -->
<div class="ui editUser modal">
	<i class="close icon"></i>
	<div class="header">
		用户编辑
	</div>
	<div class="content">
		<div class="ui form">
			<div class="field">
				<label>用户角色</label>
				<select class="ui dropdown" id="select">
				  <option value="0">超级管理员组</option>
				  <?php if(is_array($auth_group) || $auth_group instanceof \think\Collection || $auth_group instanceof \think\Paginator): $i = 0; $__LIST__ = $auth_group;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				  	<option value="<?php echo $vo['id']; ?>"><?php echo $vo['title']; ?></option>
				  <?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</div>
			<div class="field">
				<label>用户名</label>
				<input type="text" id="edit_name" placeholder="用户名">
			</div>
			<div class="field">
				<label>邮箱</label>
				<input type="text" id="edit_email" placeholder="邮箱">
			</div>
			<div class="field">
				<label>密码</label>
				<input type="text" id="edit_pass" placeholder="密码">
			</div>
			<div class="field">
				<label>密码确认</label>
				<input type="text" id="edit_repass" placeholder="密码确认">
			</div>
		</div>
	</div>
	<div class="actions">
		<div class="ui editUser button">提交</div>
	</div>
</div>
<!-- 用户编辑模态框结束 -->

<!-- jquery js -->
<script src="/static/js/jquery-3.3.1.js"></script>
<!-- ztree js -->
<script src="/static/js/jquery.ztree.all.js"></script>
<!-- semantic js -->
<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.js"></script>
<!-- customize.js -->
<script type="text/javascript">
	// 用户编辑
	function editUser(id,username,email){

		$("#edit_name").val(username);
		$("#edit_email").val(email);

		$('#select').dropdown({
			onChange: function(value, text, $selectedItem) {
		    	console.log(value);
		    }
		});

		$('.ui.editUser.modal')
		.modal({
			closable  : false,
			selector  : {
				approve  : ".editUser"
			},
			onApprove:function(){

				$.ajax({
					url:"editUser",
					type:"POST",
					dataType:"json",
					data:{
						id:id
					},
					success:function(result,status,xhr){
						console.log(result);
						// location.reload();
					},
					error:function(xhr,status,error){
						console.log("出错了.");
					}
				})

			}
		})
		.modal('show');
	}

	// 删除用户
	function deleteUser(id){
		$('.mini.modal')
			.modal({
				closable  : false,
				selector  : {
					approve  : ".negative",
					deny     : ".primary"
				},
				onDeny    : function(){

				},
				onApprove : function() {
					$.ajax({
						url:"deleteUser",
						type:"POST",
						dataType:"json",
						data:{
							id:id
						},
						success:function(result,status,xhr){
							console.log(result);
							location.reload();
						},
						error:function(xhr,status,error){
							console.log("出错了.");
						}
					})
				}
			})
			.modal('show');
	};
</script>
</body>
</html>