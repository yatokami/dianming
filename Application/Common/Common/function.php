<?php
// 判断是否登录
function is_login() {
    return session('user')['id'];
}
// 自定义分页
function array_page($array,$rows){
            $count=count($array);
            $Page=new \Think\Page($count,$rows);
            $list=array_slice($array,$Page->firstRow,$Page->listRows);
			$page = $Page->show();
            return $list;
 }
 // 判断是否管理员
 function is_admin() {
    $admin = M('named_admin')->where(['id'=>is_login()])->find();
    //if($admin['date'] = '今天的日期')
    return $admin['lv'];
}
