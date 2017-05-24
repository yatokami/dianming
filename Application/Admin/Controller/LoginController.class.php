<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
    	if(alogin(I('id'), I('pwd'))) {
    		$this->redirect('/Admin/Index');
    	} else {
    		$this->display();
    	}
    }

    public function logout() {
    	session('adminid', Null);
    	$this->redirect('/Admin/Login');
    }
}