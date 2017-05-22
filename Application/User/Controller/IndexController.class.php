<?php
namespace User\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index() {
        redirect('/User/Login',0,'');
    }
}
