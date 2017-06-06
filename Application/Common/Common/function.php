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

function admin_login($openid) {
    $where['openid'] = $openid;
    $user = M('user')->field('id,name,openid,class')->where($where)->find();
    $where2['id'] = $user['id'];
    $count = M('named_admin')->where($where2)->count();
    if($count != '0') {
        session("adminid", $user['id']);
        return $user['id'];
    } else {
        return NULL;
    }
}