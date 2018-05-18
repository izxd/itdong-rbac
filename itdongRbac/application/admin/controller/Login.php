<?php 
namespace app\admin\controller;

use think\Controller;
use think\Db;

class Login extends Controller
{

	public function index()
	{
		return $this->fetch();
	}

	public function login()
	{
		$this->success("成功");
	}
}


 ?>