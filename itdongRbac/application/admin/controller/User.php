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

	// 用户编辑 - 获取用户的角色
	public function userAuth(){
		$id = $this->request->post("id");

		// 获取用户id和权限id的对应
		$user_auth = Db::name("User")
			->alias("a")
			->join("auth_group_access b","b.uid=a.id","left")
			->field("a.*,b.group_id")
			->where("id",$id)
			->find();

		$this->success($user_auth);
	}

	// 用户添加
	public function addUser()
	{
		$post = $this->request->post();
		$this->success($post['group_id']);
	}

	// 用户编辑
	public function editUser()
	{

		$post = $this->request->post();

		if($post["id"] == 1){
			$this->error('超级管理员信息无法编辑');
		}

		// 检查数据库是否存在同名
		if(!empty($post["username"]) || 
			!empty($post["password"]) || 
			!empty($post["email"])){
			
			$res = Db::name('user')
                ->where("username",$post["username"])
                ->find();
            $resEmail = Db::name('user')
            	->where("email",$post["email"])
            	->find();

            if(empty($res)){

            	$usernameUpOk = Db::name("user")
                    ->where("id",$post["id"])
                    ->update(["username"=>$post["username"]]);

                if($usernameUpOk){
					$returnUsername = "用户名更新成功,";
                }else{
					$returnUsername = "用户名更新失败,";
                }

                $usernameUpOk = Db::name("user")
                    ->where("id",$post["id"])
                    ->update(["email"=>$post["email"]]);

                if($usernameUpOk){
					$returnUsername .= "邮箱更新成功,";
                }else{
					$returnUsername .= "邮箱更新失败,";
                }

                $this->success($returnUsername);
            	
            }else if(empty($resEmail)){

            	$usernameUpOk = Db::name("user")
                    ->where("id",$post["id"])
                    ->update(["email"=>$post["email"]]);

                if($usernameUpOk){
					$returnUsername = "邮箱更新成功,";
                }else{
					$returnUsername = "邮箱更新失败,";
                }

                $this->success($returnUsername);
            }else{
            	$this->error('用户名重复.'); 
            }

		}else{
			$this->error('请输入完整字段.'); 
		}

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
