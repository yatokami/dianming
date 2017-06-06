<?php
namespace Named\Controller;
use Think\Controller;
class RevokeController extends BaseController {
	public function index() {
		//dump(is_admin());
		if(is_admin() != '10') $this->error('只有老师有权限销假','/User/login');

		$named_log = M('named_log');  // 实例化named_log表
		$named_leave = M('named_leave');  // 实例化named_leave表
		$class = I('post.class');	// 获取post提交的 班级 信息
		$user_id =I('post.user_id');	// 获取post提交的 学号 信息
		// 构建条件判断数组
		$condition = [
			// come值为0表示没来晚自习
			'come' => 0,
			// 查询指定的时间区间
			"FROM_UNIXTIME(`date`,'%Y-%m-%d')" => [['EGT',I('post.stime')],['ELT',I('post.etime')]]
		];

		// 如果选择了具体的班级
		if($class != '信息工程系')
			$condition['class'] = $class;	// 添加数组元素

		// 如果填写了学号
		if ($user_id)
			$condition['user_id'] = $user_id;	// 添加数组元素

		// 开始查找符合条件的旷课记录
		$result = $named_log->field([
			'id',	// 自增长序号列
			'user_id',	// 学号列
			'user_name',	// 姓名列
			"FROM_UNIXTIME(`date`,'%Y-%m-%d %H:%i')" => 'date',	// 时间列
			'type',	// 类型列
			'admin'	// 操作员列
		])->where($condition)->select();

		// 如果有查询结果
		if ($result) {
			foreach ($result as $key => $value) {
				$result[$key]['admin'] = M('user')->getFieldById($value['admin'],'name'); // 操作员用名字显示
			}
		}

        //获取近3界信息工程系班级信息
		if(date("m") > "9") {
                $year = date("y");
                $year2 = date("y")-1;
                $year3 = date("y")-2;
            } else {
                $year = date("y")-1;
                $year2 = date("y")-2;
                $year3 = date("y")-3;
            }
            $map2["department"] = "信息工程系";
            $map2["id"] = array('like', array("$year%","$year2%", "$year3%"), 'or');
            $class_names = M('user')->where($map2)->field('class')->group('class')->select();
        

        $this->assign('classes',$class_names);   // 将近3界信息工程系班级信息传递给前台模板
		$this->assign('user_id',$user_id);	// 把学号传回前台模板
		$this->assign('class',$class);	// 把班级传回前台模板
		$this->assign('stime',I('post.stime'));	// 把选择的开始时间传回前台模板
		$this->assign('etime',I('post.etime'));	// 把选择的结束时间传回前台模板
		$this->assign('result',$result);	// 把查询结果传给前台模板
		$this->display();	// 加载前台模板
	}

	public function cancel() {
		$named_log = M('named_log');	// 实例化named_log表
		$named_leave = M('named_leave');	// 实例化named_leave表
		$id = I('id');	// 获取id信息

		// 将come字段更新为1
		foreach ($id as $key => $value) {
			$named_log->where(['id' => $value])->setField('come',1);  // come值为1代表有来晚自习
		}

		// 销假记录写入named_leave表
		foreach ($id as $key => $value) {
			$named_leave->add([
				'id' => $value,	// 销假id列
				'admin_id' => is_login()	// 销假操作员
			]);
		}
		$this->ajaxReturn('销假成功');	//ajax返回
	}
}