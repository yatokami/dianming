<?php
namespace Admin\Controller;
class ExamController extends BaseController {
    public function index() {
        $exam_menu = M('exam_menu')->select();

        $this->assign('exam_menu', $exam_menu);
        $this->display();
    }

    public function task() {
        $map["m_id"] = I('m_id');
        $exam_menu = M('exam_menu')->where($map)->field('menu_title,m_id')->find();
        $year = date("y");
        $year2 = date("y")-1;
        $year3 = date("y")-2;
        $map2["department"] = "信息工程系";
        $map2["id"] = array('like', array("$year%","$year2%", "$year3%"), 'or');
        $class_names = M('user')->where($map2)->field('class')->group('class')->select();

        $this->assign('exam_menu', $exam_menu);
        $this->assign('class_names', $class_names);
        $this->display('add_task');
    }


    public function add_task() {
        $data['m_id'] = I('menu_mid');
        $data['menu_title'] = I('menu_title');
        $data['class_name'] = I('class');
        $data['create_time'] = time();
        $hour = I('hour');
        $data['end_time'] = time()+60*60*$hour;

        $task = M('exam_task');
        $result = $task->add($data);
        if($result){
            //设置成功后跳转页面的地址，默认的返回页面是$_SERVER['HTTP_REFERER']
            $this->success('发布成功', '/Admin/Exam');
        } else {
            //错误页面的默认跳转页面是返回前一页，通常不需要设置
            $this->error('发布失败');
        }
    }

    public function del_exam() {
        $m_ids = rtrim(I('m_ids'), ",");
        $where['m_id'] = array('in', $m_ids);
        M('exam_menu')->where($where)->delete();
        M('exam_task')->where($where)->delete();
        $Model = new \Think\Model();
        $Model->execute("delete a.*,b.* from exam_question as a left join exam_answer as b on a.q_id=b.q_id where m_id in ($m_ids)");
        $this->ajaxReturn("1");
    }

    public function add_exam() {
        $this->display();
    }
}
