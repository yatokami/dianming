<?php
namespace Named\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index() {
        redirect('/Named/Search',0,'');
    }
}
