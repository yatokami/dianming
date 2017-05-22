<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    /*显示主页*/
    public function index(){
    	redirect('/User/Login',0,'');
    }

}
