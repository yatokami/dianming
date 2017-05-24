<?php
namespace Admin\Controller;
class IndexController extends BaseController {
    public function index(){
        $this->display();
    }

    public function add_admin() {
    	$id = I('id');
    	$pwd = I('pwd');
    	$lv = I('rad_type')=='1'?1:10;
    	$map['id']= $id;
    	$count = M('user')->where($map)->count();
    	if($count == 0) {
    		$this->error('增加失败,该号不存在');
    	} else {
    		$data['password'] = md5($pwd);
    		M('user')->where($map)->save($data);
    		$datas['lv'] = $lv;
    		$datas['id'] = $id;
    		M('named_admin')->add($datas);
    		$this->success('新增成功');
    	}
    }
}