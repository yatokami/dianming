<?php
namespace User\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index() {
        if(session("openid")) {
            $user = M('user');
            $map["openid"] = session("openid");
            $count = $user->where($map)->count();

            if($count == 0) {
                $this->assign('openid', session("openid"));
                $this->display();
            } else  {
                login(session("openid"));
                $this->redirect('/Named/search');
            }
        } else {
            $this->redirect('/WinXin/Index/login');
        }
    }

    public function bindId() {
        if(I("post.id")) {
            $user = M('user');
            $map["id"] = I("post.id");
            $count = $user->where($map)->count();

            if($count == 0) {
                $this->error('绑定失败,请检查学号');
            } else {
                $user->openid = session("openid");
                $user->where($map)->save();
                $this->success('绑定成功','/Named/search',3);
            }
        } else {
            $this->redirect();
        }
    }

}