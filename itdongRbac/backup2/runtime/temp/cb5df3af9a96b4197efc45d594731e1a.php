<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"D:\wamp64\www\itdongRbac\public/../application/admin\view\index\show_authority.html";i:1526547739;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title>角色列表</title>
	<!-- semantic css -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.css">
	<link rel="stylesheet" type="text/css" href="/static/css/metroStyle/metroStyle.css?ver=<?php echo time();?>">
</head>
<div class="ui form">
	<div class="fields">
		<div class="six wide field">
			<div onclick="addAuthRule()" class="ui submit primary button">权限添加</div>
		</div>
	</div>
</div>
<table class="ui red table">
	<thead>
		<tr>
			<th>id</th>
			<th>权限名称</th>
			<th>控制器方法</th>
			<th>图标</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<?php if(is_array($auth) || $auth instanceof \think\Collection || $auth instanceof \think\Paginator): $i = 0; $__LIST__ = $auth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		<tr>
			<td><?php echo $vo['id']; ?></td>
			<td><?php echo str_repeat("&nbsp;丨---",$vo['level']-1); ?><?php echo $vo['title']; ?></td>
			<td><?php echo $vo['name']; ?></td>
			<td>
				<?php
					if(empty($vo["icon"])){
						echo "未设置";
					}else{
						echo $vo["icon"];
					}
				?>
			</td>
			<td>
				<?php if($vo['status'] == '1'): ?>
					显示
				<?php else: ?>
					<font color="red">隐藏</font>
				<?php endif; ?>
			</td>
			<td>
				<button onclick="editAuthRule(<?php echo $vo['id']; ?>,'<?php echo $vo['title']; ?>','<?php echo $vo['name']; ?>','<?php echo $vo['icon']; ?>',<?php echo $vo['sort']; ?>,<?php echo $vo['pid']; ?>,<?php echo $vo['status']; ?>)" class="ui inverted blue button">编辑</button>
				<button onclick="deleteAuthRule(<?php echo $vo['id']; ?>)" class="ui inverted red button">删除</button>
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


<!-- 权限编辑模态框开始 -->
<div class="ui authorize modal">
	<i class="close icon"></i>
	<div class="header">
		权限编辑
	</div>
	<div class="content">
		<div class="ui form">
			<!-- <div class="field">
				<label>上级菜单</label>
				<input type="text" id="edit_previous_menu" placeholder="上级菜单"> 
			</div> -->
			<div class="field">
				<label>菜单名称</label>
				<input type="text" id="edit_name_menu" placeholder="菜单名称">
			</div>
			<div class="field">
				<label>控制器</label>
				<input type="text" id="edit_controller" placeholder="控制器">
			</div>
			<div class="field">
				<label>图标icon</label>
				<input type="text" id="edit_icon" placeholder="图标icon">
			</div>
			<div class="field">
				<label>状态</label>
				<div class="fields">
					<div class="field">
						<div class="ui radio checkbox">
							<input type="radio" tabindex="1" name="status">
							<label>显示</label>
						</div>
					</div>
					<div class="field">
						<div class="ui radio checkbox">
							<input type="radio" tabindex="0" name="status">
							<label>隐藏</label>
						</div>
					</div>
				</div>
			</div>
			<div class="field">
				<label>排序</label>
				<input type="text" id="edit_sort" placeholder="排序">
			</div>
		</div>
	</div>
	<div class="actions">
		<div class="ui ztreeBtn button">提交</div>
	</div>
</div>
<!-- 权限编辑模态框结束 -->

<!-- 权限增加模态框开始 -->
<div class="ui addAuth modal">
	<i class="close icon"></i>
	<div class="header">
		权限增加
	</div>
	<div class="content">
		<div class="ui form">
			<div class="field">
				<label>上级菜单</label>
				<select class="ui dropdown" id="select">
				  <option value="0">顶级菜单</option>
				  <?php if(is_array($auth) || $auth instanceof \think\Collection || $auth instanceof \think\Paginator): $i = 0; $__LIST__ = $auth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				  	<option value="<?php echo $vo['id']; ?>"><?php echo str_repeat('丨--',$vo['level']-1); ?><?php echo $vo['title']; ?></option>
				  <?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</div>
			<div class="field">
				<label>权限名称</label>
				<input type="text" id="add_name_menu" placeholder="菜单名称">
			</div>
			<div class="field">
				<label>控制器</label>
				<input type="text" id="add_controller" placeholder="控制器">
			</div>
			<div class="field">
				<label>图标icon</label>
				<input type="text" id="add_icon" placeholder="图标icon">
			</div>
			<div class="field">
				<label>状态</label>
				<div class="fields">
					<div class="field">
						<div class="ui radio checkboxs">
							<input type="radio" tabindex="1" name="status">
							<label>显示</label>
						</div>
					</div>
					<div class="field">
						<div class="ui radio checkbox">
							<input type="radio" tabindex="0" name="status">
							<label>隐藏</label>
						</div>
					</div>
				</div>
			</div>
			<div class="field">
				<label>排序</label>
				<input type="text" id="add_sort" placeholder="排序">
			</div>
		</div>
	</div>
	<div class="actions">
		<div class="ui addAuth button">提交</div>
	</div>
</div>
<!-- 权限增加模态框结束 -->

<!-- jquery js -->
<script src="/static/js/jquery-3.3.1.js"></script>
<!-- ztree js -->
<script src="/static/js/jquery.ztree.all.js"></script>
<!-- semantic js -->
<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.js"></script>

<script type="text/javascript">
	

	// 权限增加
	function addAuthRule(){

		var pid = 0;
		var radio_status = null;

		$('#select').dropdown({
			onChange: function(value, text, $selectedItem) {
		    	pid = value;
		    }
		});

		$(".ui.checkboxs").checkbox({
			onChecked:function(){
				radio_status = this.getAttribute("tabindex")
			}
		});

		$('.ui.addAuth.modal')
			.modal({
				closable  : false,
				selector  : {
					approve  : ".addAuth"
				},
				onApprove:function(){

					$.ajax({
						url:"addAuth",
						type:"POST",
						dataType:"json",
						data:{
							title:$("#add_name_menu").val(),
							name:$("#add_controller").val(),
							icon:$("#add_icon").val(),
							status:radio_status,
							sort:$("#add_sort").val(),
							pid:pid
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

	// 权限编辑
	function editAuthRule(id,title,name,icon,sort,pid,status){

		var radio_status = null;

		$("#edit_name_menu").val(title);
		$("#edit_controller").val(name);
		$("#edit_icon").val(icon);
		$("#edit_sort").val(pid);

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

		$('.ui.authorize.modal')
		.modal({
			closable  : false,
			selector  : {
				approve  : ".ztreeBtn"
			},
			onApprove:function(){

				$.ajax({
					url:"editAuth",
					type:"POST",
					dataType:"json",
					data:{
						id:id,
						title:$("#edit_name_menu").val(),
						name:$("#edit_controller").val(),
						icon:$("#edit_icon").val(),
						status:radio_status,
						sort:$("#edit_sort").val(),
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

	// 权限删除
	function deleteAuthRule(id){
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
						url:"deleteAuth",
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