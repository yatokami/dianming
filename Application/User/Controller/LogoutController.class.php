<?php
namespace User\Controller;
class LogoutController extends \Common\Controller\BaseController {
    public function index() {
        session(null);
        $this->redirect('/home/index');	// 重定向到主页
    }
}
