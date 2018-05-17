<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\wamp64\www\itdongRbac\public/../application/admin\view\index\show_role.html";i:1526085264;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title>角色列表</title>
	<!-- semantic css -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.css">
	<link rel="stylesheet" type="text/css" href="/static/css/metroStyle/metroStyle.css?ver=<?php echo time();?>">
</head>
<body>
	<div class="ui form">
		<div class="fields">
			<div class="four wide field">
				<input id="role_name" name="role_name" type="text" placeholder="请输入角色名称" />
			</div>
			<div class="two wide field">
				<div onclick="addRole()" class="ui submit primary button">添加</div>
			</div>
			<div class="eight wide field">
				<div class="ui mini orange message"></div>
			</div>
		</div>
	</div>
	<table class="ui red table">
		<thead>
			<tr>
				<th>id</th>
				<th>角色名</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($role) || $role instanceof \think\Collection || $role instanceof \think\Paginator): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<tr>
				<td><?php echo $vo['id']; ?></td>
				<td><?php echo $vo['title']; ?></td>
				<td>
					<?php 
					if($vo["status"] == 1)
					{
						echo '<span style=color:green>启用</span>';
					}else{
					echo '<span style=color:red>禁用</span>';
				}
				 ?>
				</td>
				<td>
					<button onclick="authrizeRole(<?php echo $vo['id']; ?>)" class="ui inverted blue button">授权</button>
					<button onclick="editRole(<?php echo $vo['id']; ?>,'<?php echo $vo['title']; ?>',<?php echo $vo['status']; ?>)" class="ui inverted green button">编辑</button>
					<button onclick="delRole(<?php echo $vo['id']; ?>)" class="ui inverted red button">删除</button>
				</td>
			</tr>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>

<!-- 删除模态框开始 -->
<div class="ui mini modal">
	<div class="header">删除角色</div>
	<div class="content">
		<p>你确定要删除这个角色吗？</p>
	</div>
	<div class="actions">
		<button class="ui primary button">否</button>
		<button class="ui negative button">是</button>
	</div>
</div>
<!-- 删除模态框结束 -->

<!-- 编辑模态框开始 -->
<div class="ui edit modal">
	<i class="close icon"></i>
	<div class="header">
		角色编辑
	</div>
	<div class="content">
		<div class="ui form">
			<div class="field">
				<label>角色名称</label>
				<input type="text" id="edit_name_role" placeholder="请输入角色名称">
			</div>
			<div class="field">
				<label>启用状态</label>
				<div class="fields">
					<div class="field">
						<div class="ui radio checkbox">
							<input type="radio" tabindex="1" name="status">
							<label>启用</label>
						</div>
					</div>
					<div class="field">
						<div class="ui radio checkbox">
							<input type="radio" tabindex="0" name="status">
							<label>禁用</label>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<div class="actions">
		<div class="ui button">提交</div>
	</div>
</div>
<!-- 编辑模态框结束 -->

<!-- 授权模态框开始 -->
<div class="ui authorize modal">
	<i class="close icon"></i>
	<div class="header">
		用户授权
	</div>
	<div class="content">
		<div>
			<ul id="tree" class="ztree"></ul>
		</div>
	</div>
	<div class="actions">
		<div class="ui ztreeBtn button">提交</div>
	</div>
</div>
<!-- 授权模态框结束 -->

<!-- jquery js -->
<script src="/static/js/jquery-3.3.1.js"></script>
<!-- ztree js -->
<script src="/static/js/jquery.ztree.all.js"></script>
<!-- semantic js -->
<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.js"></script>
<!-- customize js -->
<script type="text/javascript">

// 角色授权
function authrizeRole(id){

	var tree = $("#tree");
	var zTree;
	var setting = {
		check: {
			enable: true
		},
		view: {
			dblClickExpand: false,
			showLine: true,
			showIcon: true,
			selectedMulti: false
		},
		data: {
			simpleData: {
				enable: true,
				idKey: "id",
				pIdKey: "pid",
				rootpid: ""
			},
			key: {
				name: "title"
			}
		}
	};

	$.ajax({
		url:"getJson",
		type:"POST",
		dataType:"json",
		data:{
			id:id
		},
		success:function(result,status,xhr){
			zTree = $.fn.zTree.init(tree, setting, result);
		},
		error:function(xhr,status,error){
			console.log(error);
		}
	});

	$('.ui.authorize.modal')
	.modal({
		closable  : false,
		selector  : {
			approve  : ".ztreeBtn"
		},
		onApprove:function(){

			var checked_ids,auth_rule_ids = [];
			checked_ids = zTree.getCheckedNodes(); // 获取当前选中的checkbox

			$.each(checked_ids,function(index,item){
				auth_rule_ids.push(item.id);
			});

			$.ajax({
				url:"updateAuthGroupRule",
				type:"POST",
				dataType:"json",
				data:{
					id:id,
					auth_rule_ids:auth_rule_ids
				},
				success:function(result,status,xhr){
					console.log(result);
				},
				error:function(xhr,status,error){
					console.log(error);
				}
			});

		}
	})
	.modal('show');
}

// 角色添加
function addRole(){
	var roleName = $("#role_name").val();
	if(roleName.length == 0){
		$(".mini.message").html("角色名不能为空.");
		return false;
	}
	if(roleName.length < 5){
		$(".mini.message").html("角色名过短.");
		return false;
	}

	$.ajax({
		url:"addRole",
		type:"POST",
		dataType:"json",
		data:{
			role_name:roleName
		},
		success:function(result,status,xhr){
			console.log(result);
			location.reload();
		},
		error:function(xhr,status,error){
			console.log(error);
		}
	})
}

// 角色编辑
function editRole(id,title,status){
	var radio_status = null;
	$("#edit_name_role").val(title);

	if(status == 0){
		$('.ui.checkbox').last().checkbox( "set checked" );
		radio_status = 0;
	}else if(status == 1){
		$('.ui.checkbox').first().checkbox( "set checked" );
		radio_status = 1;
	}

	$(".ui.checkbox").checkbox({
		onChecked:function(){
			radio_status = this.getAttribute("tabindex")
		}
	});

	$('.ui.edit.modal')
	.modal({
		closable  : false,
		selector  : {
			approve  : ".button"
		},
		onApprove:function(){

			var edit_name_role = $("#edit_name_role").val();

			$.ajax({
				url:"editRole",
				type:"POST",
				dataType:"json",
				data:{
					id:id,
					radio_status:radio_status,
					title:edit_name_role
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
}

// 角色删除
function delRole(id){
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
				url:"delRole",
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
}	

</script>
</body>
</html>