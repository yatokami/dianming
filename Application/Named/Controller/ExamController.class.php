<?php
namespace Named\Controller;
use Think\Controller;
class ExamController extends Controller {
    function _initialize() {
        $this->assign('MENU',C('MENU'));
        $this->assign('uname',session('user')['name']);
    }

    //考卷信息页面显示
    public function index() {
        $uid = session('user')['id'];
        $class = session('user')['class'];

        //查询结束的考试和正在进行的考试
        if(I('time') == 'ed') {
            $now_time = time();
            $map["end_time"] = array('elt', $now_time);
            $map["class_name"] = $class;
            $exam_task = M('exam_task')->where($map)->select();

            $this->assign('ed_active', 'am-active');
            $this->assign('time', 'ed');
        } else {
            $now_time = time();
            $map["create_time"] = array('elt', $now_time);
            $map["end_time"] = array('egt', $now_time);
            $map["class_name"] = $class;
            $exam_task = M('exam_task')->where($map)->select();

            $this->assign('ing_active', 'am-active'); 
            $this->assign('time', 'ing');
        }   
        $this->assign('exam_task', $exam_task);
        $this->display('list');
    }

    //考试信息
    public function info() {
        if (I('time_active') == "ed") {
            $where2["et_id"] = I('et_id');//任务表id
            $where2['uid'] = session('user')['id'];
            $where['et_id'] = I('et_id');

            //根据任务表id和学生id获取学生考卷记录
            $exam_log = M('exam_log')->where($where2)->limit(1)->find();
            $exam_task = M('exam_task')->where($where)->limit(1)->find();

            //正确题目编号字符串拆分
            $t_answer = explode(",", $exam_log["t_answer"]);
            $map["m_id"] = $exam_task["m_id"];

            //将题目表和答案表关联
            $exam_question = M('exam_question');
            $exam_option = $exam_question->join('right join exam_answer on exam_answer.q_id=exam_question.q_id')->where($map)->select();
            $exam_question = $exam_question->where($map)->select();
            //遍历题目，与正确题目编号进行判断
            for ($i = 0; $i < count($exam_question); $i++) { 
                $exam_questions[$i]["q_id"] = $exam_question[$i]["q_id"];
                $exam_questions[$i]["question"] = $exam_question[$i]["question"];
                $exam_questions[$i]["m_id"] = $exam_question[$i]["m_id"];

                for ($j = 0; $j < count($t_answer); $j++) { 
                    //正确题目编号和题目进行对比
                    if($t_answer[$j] == $exam_question[$i]["q_id"]) {
                        $exam_questions[$i]["bool"] =  "T";
                        break;
                    } else {
                        $exam_questions[$i]["bool"] =  "F";
                    }
                }
                
            }
            //打乱数组顺序
            shuffle($exam_questions);
            shuffle($exam_option);
            $exam_log["sum"] = ($exam_log["sum"]==NULL) ? 0 : $exam_log["sum"];
            $this->assign('exam_task', $exam_task);
            $this->assign('exam_log', $exam_log);
            $this->assign('exam_option', $exam_option);
            $this->assign('exam_questions', $exam_questions);
            $this->display('end_info');
        } else {
            $where['et_id'] = I('et_id');
            $where2["et_id"] = I('et_id');
            $where2['uid'] = session('user')['id'];
            $count = M('exam_log')->where($where2)->count();
            //判断学生有没有考过
            if ($count == 0) {
                $exam_task = M('exam_task')->where($where)->limit(1)->find();
                $exam_question = M('exam_question');
                $map["m_id"] = $exam_task["m_id"];
                $exam_option = $exam_question->join('right join exam_answer on exam_answer.q_id=exam_question.q_id')->where($map)->select();
                $exam_question = $exam_question->where($map)->select();
                shuffle($exam_question);
                shuffle($exam_option);
                $this->assign('exam_task', $exam_task);
                $this->assign('exam_option', $exam_option);
                $this->assign('exam_question', $exam_question);
            } else {
                $this->error('你已经参加过考试', '/Named/Exam/index');
            }
            $this->display('info');
        }
    }


    //交卷
    public function sub_exam() {
        if (time() < I('end_time')) {
        	$option = (int)I('option');
            $m_id = I('m_id');
            $et_id = I('et_id');
            $t_answer = "";
            $f_answer = "";
            $sum = 0;
        	for ($i = 1; $i <= $option; $i++) { 
        		$answer = I('doc-radio-'.$i);
                //拆分选项的值，第一个是题目id，第二个是答案id，通过这两个值从答案表获取分数
                $answers = explode("+",$answer);
                $where['q_id'] = $answers[0];
                $where['a_id'] = $answers[1];
                $numbers = M('exam_answer')->where($where)->field('number')->find();
                if ((float)$numbers["number"] != 0) {
                    $t_answer .= $answers[0].",";
                    $sum =  $sum + (float)$numbers["number"];
                } else {
                    $f_answer .= $answers[0].",";
                }
        	}
            //去除末尾逗号
            $t_answer = substr($t_answer, 0, -1);
            $f_answer = substr($f_answer, 0, -1);

            $data["m_id"] = $m_id;
            $data['sum'] = $sum;
            $data['uid'] = session('user')['id'];
            $data['t_answer'] = $t_answer;
            $data['f_answer'] = $f_answer;
            $data['et_id'] = $et_id;
            $id = M('exam_log')->add($data);
            if($id > 0) {
                $this->success('提交试卷成功', '/Named/Exam/index');
            } else {
                $this->error('提交试卷失败');
            }
        } else {
            $this->error('考试已经结束', '/Named/Exam/index');
        }           
    }
}
