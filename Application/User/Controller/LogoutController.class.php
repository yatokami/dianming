<?php
namespace User\Controller;
class LogoutController extends \Common\Controller\BaseController {
    public function index() {
        session('user', NULL);	// 清空session
        $this->redirect('/home/index');	// 重定向到主页
    }
}
