<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {
    function _initialize() {
        if(!is_alogin()) $this->redirect('/Admin/Login');
    }
}
