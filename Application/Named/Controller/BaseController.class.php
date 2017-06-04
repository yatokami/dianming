<?php
namespace Named\Controller;
use Think\Controller;
class BaseController extends Controller {
    function _initialize() {
        $this->assign('MENU',C('MENU'));
        $this->assign('uname',session('user')['name']);
        //dump(is_admin());
        //if(!is_login()) redirect('/user/login/index?redirect='.$_SERVER['REQUEST_URI']);
        if(!is_admin()) $this->error('您没有登录或没有权限','/User/login');
        //dump(is_admin());
    }
}
