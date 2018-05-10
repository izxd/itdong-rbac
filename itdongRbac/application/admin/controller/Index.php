<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
    	$menu = [];
    	$auth_rule_list = Db::name('auth_rule')->where("status",1)->order(["id"=>"ASC"])->select();
		
    	$menu = array2tree($auth_rule_list);

        $this->assign('menu', $menu);

        return $this->fetch();
    }

    public function test()
    {
		return $this->fetch();
    }
}
