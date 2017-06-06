<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
        if(session("openid")) {
            $user = M('user');
            $map["openid"] = session("openid");
            $count = $user->where($map)->count();
            if($count == 0) {
                $this->error('您未绑定学号请返回前台绑定学号','/User/Login/index/param/admin',3);
            } else  {
                $where['openid'] = session('openid');
                $user = M('user')->field('id,name,openid,class')->where($where)->find();
                $where2['id'] = $user['id'];
                $count = M('named_admin')->where($where2)->count();
                if($count != '0') {
                    session("adminid", $user['id']);
                    $this->redirect('/Admin/Index');
                } else {
                    $this->redirect('/User/Login');
                }
            }
        } else {
            $this->redirect('/WeiXin/Index/login/param/2');
        }
    	
    }

    public function logout() {
    	session(null);
    	$this->redirect('/Admin/Login');
    }
}