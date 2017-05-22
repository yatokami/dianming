<?php
namespace Named\Controller;
use Think\Controller;
class SearchController extends Controller {
	function _initialize() {
		$this->assign('MENU',C('MENU'));
		$this->assign('uname',session('user')['name']);
	}

	function index() {
		$user_id = I('get.id');  // 获取学号 
		$named_log = M('named_log'); // 实例化named_log表
		$user = M('user');	// 实例化user表
		// 查询粗略信息
		$rough = $named_log->field([
			'user_id',
			'user_name'
		])// 查询学号列，姓名列
		->where([
			'user_id'     => $user_id,
			'come'        => 0,	// come值为0表示没来晚自习
			// 时间区间查询
			"FROM_UNIXTIME(`date`,'%Y-%m-%d')" => [['EGT',I('get.stime')],['ELT',I('get.etime')]]
		])
		->find();

		// 如果有粗略数据
		if ($rough) {
			// 为其计算缺勤次数
			// 计算正常点名缺勤数
			$count1 = $named_log->where([
				'user_id'    =>$user_id,
				'come'       => 0,	// come值为0表示没来晚自习
				'type'       =>['LT',3],
				"FROM_UNIXTIME(`date`,'%Y-%m-%d')" => [['EGT',I('get.stime')],['ELT',I('get.etime')]]
			])->count();

			// 计算抽点缺勤数
			$count2 = $named_log->where([
				'user_id'    =>$user_id,
				'come'       => 0,	// come值为0表示没来晚自习
				'type'       =>['EGT',3],
				"FROM_UNIXTIME(`date`,'%Y-%m-%d')" => [['EGT',I('get.stime')],['ELT',I('get.etime')]]
			])->count();

			$count = $count1 + $count2 * 2;// 抽点未到按缺勤两节课
			$rough['count'] = $count; // 添加数组元素

			//查询详细
			$about = $named_log->field([
				'user_id',  // 学号列
				'user_name',    // 姓名列
				'type',         // 类型列
				"FROM_UNIXTIME(`date`,'%Y-%m-%d %H:%i:%s')" => 'date',   // 类型列
				'cadres_id',	// 学委签名列
				'admin' // 操作员列
			])
			->where([
				'user_id'     => $user_id,
				'come'        => 0,	// come值为0表示没来晚自习
				// 时间区间查询
				"FROM_UNIXTIME(`date`,'%Y-%m-%d')" => [['EGT',I('get.stime')],['ELT',I('get.etime')]]
			])
			->select();

			// 学号替换为名字
			foreach ($about as $key => $value) {
				$about[$key]['admin'] = $user->getFieldById($value['admin'],'name');	// 操作员学号改名字
				$about[$key]['cadres_id'] = $user->getFieldById($value['cadres_id'],'name');	// 学委学号改名字
			}
		}

		//dump($about);
		$this->assign('user_id',$user_id); // 将学号传递给前台
		$this->assign('rough',$rough);// 查询粗略信息传递给前台
		$this->assign('about',$about);// 查询详细信息传递给前台
		$this->assign('start',I('get.stime')); // 时间开始的范围传递给前台
		$this->display();
	}

	function c() {
		$named_log = M('named_log');// 实例化named_log表
		$class = I('class'); // 获取班级

		// 开始查询粗略信息
		// 如果选择全部班级
		if ($class == '信息工程系') {
			$rough = $named_log->field([
				'user_id',	// 查询学号列
				'user_name' // 查询姓名列
			])->where([
				// 查询所选时间区间
				"FROM_UNIXTIME(`date`,'%Y-%m-%d')" => [['EGT',I('get.stime')],['ELT',I('get.etime')]],
				// come值0表示没来晚自习
				'come' => 0,
			])->group('user_id')->order('user_id')->select();	// 按学号分组，升序查询
		} else{ // 如果选的是某个班级
			$rough = $named_log->field([
				'user_id',	// 查询学号列
				'user_name'	//查询姓名列
			])->where([
				// come值0表示没来晚自习
				'come' => 0,	
				// 查询所选时间区间
				"FROM_UNIXTIME(`date`,'%Y-%m-%d')" => [['EGT',I('get.stime')],['ELT',I('get.etime')]],
				// 查询所选班级
				'class' => $class
			])->group('user_id')->order('user_id')->select();	// 按学号分组，升序查询
		}

		// 如果有粗略数据
		if ($rough) {
			// 计算缺勤次数
			foreach ($rough as $key => $value) {
				// 计算正常点名缺勤次数
				$count1 = $named_log->where([
					'come' => 0,	// come值为0表示没来晚自习
					'type' => ['LT',3], // 小于3
					"FROM_UNIXTIME(`date`,'%Y-%m-%d')" => [['EGT',I('get.stime')],['ELT',I('get.etime')]],
					'user_id' => $value['user_id']
				])->count();

				// 计算抽点缺勤次数
				$count2 = $named_log->where([
					'come' => 0,	// come值为0表示没来晚自习
					'type' => ['EGT',3], // 大于等于3
					"FROM_UNIXTIME(`date`,'%Y-%m-%d')" => [['EGT',I('get.stime')],['ELT',I('get.etime')]],
					'user_id' => $value['user_id']
				])->count();
				$count = $count1 + ($count2 * 2);// 抽点未到按缺勤两节课
				$rough[$key]['count'] = $count;	//添加数字元素
			}
		}
		$this->assign('start',I('get.stime'));// 将开始时间传回前台模板
		$this->assign('end',I('get.etime'));// 将结束时间传回前台模板
		$this->assign('class',$class);// 将班级信息传回前台模板
		$this->assign('rough',$rough);// 将查询的粗略结果传给前台模板
		$this->display();
	}

	function tem() {
		$named_log = M('named_log')->select();
		foreach ($named_log as $key => $log) {
			$user = M('user')->find($log['user_id']);

			M('named_log')->where([
				'id' => $log['id']
			])->save([
				'name' => $user['name']
			]);
		}
	}
}
