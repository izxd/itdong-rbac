<?php 
// +----------------------------------------------------------------------
// | ITDONG USE THINKPHP [ WE CAN DO IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018~2019 http://itdong.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( None )
// +----------------------------------------------------------------------
// | Author: itdong <izhaoxudong@gmail.com>
// +----------------------------------------------------------------------

//------------------------
// ITDONG 助手函数
//-------------------------

/**
* @brief 子元素计数器
* @param Array $array 处理的一维数组
* @param Int $pid 父元素id
* @return array 以父元素pid分组的数组
*/
function array_children_count($array,$pid)
{
	$counter = [];
	foreach($array as $item){
		$count = isset($counter[$item[$pid]]) ? $counter[$item[$pid]] : 0;
		$count++;
		$counter[$item[$pid]] = $count;
	}
	return $counter;
}

/**
* @brief把元素插入到对应的父元素$child_key_name字段
* @param Array $parent 父元素数组
* @param Int $pid 父元素ID
* @param String $child 子元素
* @param String $child_key_name 子元素键名
* @return Array $parent
*/
function array_child_append($parent,$pid, $child, $child_key_name)
{
	foreach($parent as &$item){
		if($item["id"] == $pid){
			if(!isset($item[$child_key_name])){
				$item[$child_key_name] = [];
			}
			$item[$child_key_name][] = $child;
		}
	}
	return $parent;
}

/**
* @brief 数组层级缩进转换
* @param Array $array
* @param int $pid
* @param int $level
* @return array
*/ 
function array2level($array, $pid = 0, $level = 1)
{
	static $list = [];
	foreach ($array as $v) {
		if($v["pid"] == $pid){
			$v["level"] = $level;
			$list[] = $v;
			array2level($array, $v["id"], $level + 1);
		}
	}
	return $list;
}

/*
* @brief 构建层级（树状）数组
* @param Array $array 处理的一维数组
* @param String $pid_name 父级ID的字段名
* @param String $child_key_name 子元素键名
* @return Array|Bool
*/
function array2tree(&$array, $pid_name = 'pid', $child_key_name = 'children'){
	
	$counter = array_children_count($array,$pid_name);

	if(!isset($counter[0]) || $counter[0] == 0){
		return $array;
	}

	$tree = [];

	while(isset($counter[0]) && $counter[0] > 0){
		$temp = array_shift($array);
		if(isset($counter[$temp["id"]]) && $counter[$temp["id"]] > 0){
			array_push($array,$temp);
		}else{
			if($temp[$pid_name] == 0){
				$tree[] = $temp;
			}else{
				$array = array_child_append($array, $temp[$pid_name], $temp, $child_key_name);
			}
		}
		$counter = array_children_count($array,$pid_name);
	}

	return $tree;
}

 ?>