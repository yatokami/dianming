<?php
namespace Named\Controller;
class DmController extends BaseController {
    public function index() {
        $User = M('user');  // 实例化user表
        $UserClass = $User->field('class')->where([
            'class'      => ['like','15%'], // 15级班级
            'department' => '信息工程系' // 限定 信息工程系
        ])->group('class')->select();   // 分组查询

        $this->assign('User',$UserClass);   // 将班级信息传递给前台模板
        $this->display();   // 加载前台模板
    }
    
    public function start(){
        $named_log = M("named_log"); //实例化named_log数据库模型

        //表单提交界面
        if(I('post.')){
            // 查询全班成员，并过滤走读生
            $class = M('user')->field('id')->where([
                'class' => I('get.class'),
                // 过滤走读生
                'attend'=> '0'
            ])->getField('id,name');


            // 查询今日，同类型，已点名单
            $old_log = $named_log->where([
                'type'  => I('get.type'),
                "FROM_UNIXTIME(`date`,'%Y%m%d')"  => date('Ymd', time())
            ])->getField('user_id,admin');


            /*获取已经提交过的数据*/

            foreach ($class as $id => $name) {
                // 构建数组结构
                $data['user_id']   = $id; // id字段
                $data['user_name'] = $class[$id];   // 名字字段
                $data['type']      = I('get.type'); // 点名类型字段
                $data['admin']     = is_login();    // 操作员字段
                $data['date']      = time();    // 当前时间戳
                $data['department'] = M('user')->getFieldById($id,'department');// 根据id从user表中获取系部字段
                $data['class'] = I('get.class');// 班级字段
                $data['cadres_id'] = I('cadres_id');// 学委签名
                // 判断有没有来晚自习
                if(I('studata')[$id]) {
                    // 有来晚自习
                    $data['come']  = 1;
                } else {
                    // 没来晚自习
                    $data['come']  = 0;
                }


                // 已经提交过，保存数据
                if ($old_log[$data['user_id']]) {
                    $named_log->where([
                        'user_id' => $id,
                        "FROM_UNIXTIME(`date`,'%Y%m%d')"  => date('Y-m-d', time())
                    ])->save($data);

                // 未经提交过，新增数据
                } else {
                    $named_log->add($data);
                }
            }
            $this->success("操作完成","/named/search",10);  // 提示成功，等待10秒后返回查询页面

            
        }else{
            $user = M('user');  // 实例化user数据表

            // 查询班级成员
            $user = $user->field([
                'id',   // 查询学号列
                'name'  // 查询名字列
            ])->where([
                'class' => I('get.class'),
                // 过滤走读生
                'attend' => '0'
            ])->order('id')->select();  // 按学号排序，查询

            // 加上本日是否点过标记
            foreach ($user as $key => $value) {
                $user[$key]['come'] = $named_log->where([
                    'type'=>I('type'),  // 同种点名类型
                    "FROM_UNIXTIME(`date`,'%Y%m%d')"  => date('Y-m-d', time())  // 同日
                ])->getFieldByUser_id($value['id'],'come');
            }

            $this->assign('type',I('type'));// 把点名类型重新传回前台模板
            $this->assign('class',I('class'));// 把点名班级重新传回前台模板
            $this->assign('user',$user);// 把班级成员列表传给前台模板
            $this->display();// 加载模板文件
        }
    }
}
