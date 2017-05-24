<?php
namespace Named\Controller;
use Think\Controller;
class ExamController extends Controller {
    public function index() {
    	$exam_menu = M('exam_menu')->order('m_id desc')->limit(1)->find();
    	$exam_question = M('exam_question');
    	$map["m_id"] = $exam_menu["m_id"];
    	$exam_option = $exam_question->join('right join exam_answer on exam_answer.q_id=exam_question.q_id')->where($map)->select();
    	$exam_question = $exam_question->where($map)->select();
    	$this->assign('menu_title', $exam_menu["menu_title"]);
    	$this->assign('exam_option', $exam_option);
    	$this->assign('exam_question', $exam_question);
        $this->display();
    }

    // public function sub_exam() {
    // 	$option = (int)I('option');
    // 	for ($i = 1; $i <= $option; $i++) { 
    // 		$answer = I('doc-radio-'.$i);
    // 	}
    // }
}
