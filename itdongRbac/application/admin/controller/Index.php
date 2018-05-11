<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{
    /* 默认方法 */
    public function index()
    {
    	$menu = [];
    	$auth_rule_list = Db::name('auth_rule')->where("status",1)->order(["id"=>"ASC"])->select();
		
    	$menu = array2tree($auth_rule_list);

        $this->assign('menu', $menu);

        return $this->fetch();
    }

    /* 测试方法 */
    public function test()
    {
		return $this->fetch();
    }

    /* 展示角色列表列表 */
    public function showRole()
    {
        $role = Db::name("auth_group")
            ->order("id desc")
            ->select();

        $this->assign("role",$role);
        return $this->fetch();
    }

    /* 增加角色 */
    function addRole()
    {
        $auth_group = $this->request->post("role_name");

        if(!empty($auth_group)){
            $res = Db::name("auth_group")
            ->where("title",$auth_group)
            ->find();

            if(empty($res)){

                Db::name('auth_group')
                ->insert(['title'=>$auth_group,'status'=>"0","rules"=>"202"]);

                $this->success("添加成功");
            }else{
                $this->error('系统中已经存在该用户名');
            }

        }else{
            $this->error('请输入角色名称再添加');
        }
    }

    /* 获取规则数据 */
    public function getJson()
    {
        $id = $this->request->post("id");
        $auth_group_data = Db::name("auth_group")->find($id);
        $auth_rules = explode(",",$auth_group_data["rules"]);
        $auth_rule_list  = Db::name('auth_rule')->field('id,pid,title')->select();

        foreach ($auth_rule_list as $key => $value) {
            in_array($value['id'], $auth_rules) && $auth_rule_list[$key]['checked'] = true;
        }

        return $auth_rule_list;
    }

    /* 删除角色 */
    public function delRole()
    {
        $id = $this->request->post("id");
        if($id !== "1"){
            $res = Db::name("auth_group")
            ->delete($id);
            $this->success("删除成功.");
        }else{
            $this->error("超级管理员无法删除.");
        }
    }

    /* 编辑角色 */
    public function editRole()
    {
        $post = $this->request->post();

        if($post["id"] == 1){
            $this->error('超级管理员信息无法编辑');
        }

        // 检查数据库是否存在同名
        if(!empty($post["title"])){
            $res = Db::name('auth_group')
                ->where("title",$post["title"])
                ->find();
            if(empty($res)){
                Db::name("auth_group")
                    ->where("id",$post["id"])
                    ->update(["title"=>$post["title"],'status'=>$post['radio_status']]);
                $this->success('角色名更新成功.');
            }else{
                Db::name("auth_group")
                    ->where("id",$post["id"])
                    ->update(['status'=>$post['radio_status']]);
                $this->success('状态更新成功.');
            }
        }else{
           $this->error('请输入角色名称再添加.'); 
        }
    }

    /* 更新权限组规则 */
    public function updateAuthGroupRule()
    {
        if($this->request->isPost()){
            $post = $this->request->post();
            if($post["id"] == 1){
                $this->error("超级管理员信息无法编辑");
            }

            $group_data['id']    = $post['id'];

            $group_data['rules'] = is_array($post['auth_rule_ids']) ? implode(",",$post['auth_rule_ids']) : "";
            
            if(Db::name("auth_group")->where("id",$post['id'])->update( $group_data) !== false){
                $this->success('授权成功');
            } else {
                $this->error('授权失败');
            }
            
        }
    }
}
