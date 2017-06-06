<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {
    function _initialize() {
     //    if(!is_alogin()) {
     //    	$this->error('登录失败，无权限', '/User/Login',3);
     //    }
    	// $this->assign('uname',session('user')[0]["name"]);
    }
}
