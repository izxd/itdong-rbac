<?php 
namespace app\admin\controller;

use think\Controller;
use think\Db;

class User extends Controller
{

	public function index(){

		// 获取用户列表
		$data = Db::name("User")
			->order("id asc")
			->select();

		// 编辑页面的用户角色列表
		$auth_group = Db::name("auth_group")
			->field("id,title")
			->order("id desc")
			->select();

		$this->assign("users",$data);
		$this->assign("auth_group",$auth_group);

		return $this->fetch();
	}

	// 用户编辑
	public function editUser()
	{
		$id = $this->request->post("id");
		$this->success($id);
	}

	// 删除用户
	public function deleteUser()
	{
		$id = $this->request->post("id");
		$username = Db::name("user")
			->where("id",$id)
			->value("username");

		if((int) $id !== 1){
			$db = Db::name("user")
			->where("id",$id)
			->delete();

			$this->success("删除成功.");
		}else{
			$this->error("超级管理员不能删除");
		}
	}

}
 ?>
