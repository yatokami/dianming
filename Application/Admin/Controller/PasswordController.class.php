<?php
namespace Admin\Controller;
class PasswordController extends BaseController {
    public function index() {
    	// 如果没传参
        if (!I()) {
        	$this->display();	// 加载前台模板
        } else {	// 如果有传参
        	$user = M('user');	// 实例化user表
        	$oldpassword = I('post.oldpassword');	// 获取原密码
        	$result = $user->getFieldById(session('user')[0]['id'],'password');	// 数据库查询该id的原始密码

        	// 如果数据库结果与传递的原始密码md5值一致
	        if ($result == md5($oldpassword)) {
	    		$newpassword = md5(I('post.newpassword'));	// 获取post方式传递的新密码
	    		$id = session('user')[0]['id'];	// 从session中获取学号
	    		$user->where(['id'=>$id])->field('password')->save(['password'=>$newpassword]);	// 修改密码
                $this->success('修改成功,请重新登录','/Admin/login/logout');	// 提示成功，并退出登录
	    	} else {
	    		$this->error('原密码错误');	// 否则，提示错误
	    	}
        }
    }

    // ajax查询原始密码与数据库中是否一致
    public function check() {
    	$oldpassword = I('post.oldpassword');	// 获取post传递的原始密码
    	$result = M('user')->getFieldById(session('user')[0]['id'],'password');	// 从数据库中查询该学号中的密码
    	// 如果查询结果与传递的原密码md5值一致
        //$this->ajaxReturn($oldpassword);
    	if ($result == md5($oldpassword)) {
    		$this->ajaxReturn('success');	// ajax返回success
    	} else {
    		$this->ajaxReturn('error');	// ajax返回error
    	}
    }
}
