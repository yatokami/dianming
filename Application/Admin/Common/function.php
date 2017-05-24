<?php 

//是否登陆
function is_alogin() {
	return session('adminid');
}

// 登陆
function alogin($id, $pwd) {
    $where['id'] = $id;
    $where['password'] = md5($pwd);
    $map['lv'] = 10;
    $map['id'] = $id;
    $cuser = M('user')->where($where)->count();
    $cadmin = M('named_admin')->where($map)->count();
 
    if($cuser + $cadmin == 2) {
    	session("adminid", $id);
    	return session("adminid");
    } else {
    	return Null;
    }
}


 ?>