<?php
namespace Common\Controller;
use Think\Controller;
class BaseController extends Controller {
    function _initialize() {
        $this->assign('MENU',C('MENU'));
        $this->assign('uname',session('user')['name']);
        if(!is_login()) redirect('/user/login/index?redirect='.$_SERVER['REQUEST_URI']);
    }
}
