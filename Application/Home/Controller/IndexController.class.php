<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    /**
     * [index 主页]
     * @return [type] [description]
     */
    public function index()
    {
    	$this->display();
    }

    /**
     * [time 一个关于时间炫的页面]
     * @return [type] [description]
     */
    public function time()
    {
        $this->display();
    }

    /**
     * [index 个人简介主页]
     * @return [type] [description]
     */
    public function tpp()
    {
        $data = M('project_user')->where(array('id' => 1))->find(); 
        $this->assign('data', $data)->display();
    }

    /**
     * [Contact 联系我]
     * @param [type] $name    [姓名]
     * @param [type] $contact   [联系方式]
     * @param [type] $message [信息]
     */
    public function Contact()
    {
        if (!($name = I('name') ) ) $this->ajaxReturn(array('code' => 0, 'msg' => '抱歉，请告诉我你叫什么名字？'));
        if (!($contact = I('contact') ) ) $this->ajaxReturn(array('code' => 0, 'msg' => '请给我你的联系方式，好让我找到你'));
        if (!($message = I('message') ) ) $this->ajaxReturn(array('code' => 0, 'msg' => '请问你要给我说什么？'));

        $cid = M('project_contact')->where(array('name' => $name, 'contact' => $contact, 'message' => $message))->getField('id');
        if ($cid) $this->ajaxReturn(array('code' => 0, 'msg' => '你已告诉我过同样的信息'));
        $datestart = date("Y-m-d",strtotime("-1 day"));
        $dateend = date("Y-m-d",strtotime("+1 day"));
        $count = M('project_contact')
                    ->where(array('addtime' => array('between',[$datestart,$dateend])))
                    ->count();
        if (!$count) $count = 0;
        if ($count >= C('contact_count')) $this->ajaxReturn(array('code' => 0, 'msg' => '不好意思，今日悄悄话已达上限，请明日一早告诉我'));
        $res = M('project_contact')->add(array('name' => $name, 'contact' => $contact, 'message' => $message, 'addtime' => date('Y-m-d H:i:s')));
        if (!$res) $this->ajaxReturn(array('code' => 0, 'msg' => '破系统，坏了，刷新重新试试'));
        $this->ajaxReturn(array('code' => 1, 'msg' => '我收到了，我会回复你的，等我。'));
    }
    /**
     * [question 答卷]
     * @param [type] $[exam_id] [<考卷id>]
     * @return [type] [description]
     */
    public function question()
    {
        if (!($exam_id = I('exam_id') ) || !is_numeric($exam_id) ) $this->error('我还真不知道给你出什么题');
        $list = M('project_exam_question')->where(array('exam_id' => $exam_id))->select();
        if (!$list) $this->error('这套考卷出题者未出题');

        foreach ($list as &$item) {
            $item['option'] = json_decode($item['option'], true);
        }
        $this->assign(
            array(
                'list'=> $list,
                'exam_id'=> $exam_id
            )
        )->display();
    }

    /**
     * [getExamQuestion 获取题库]
     * @param [type] $[exam_id] [<考卷id>]
     * @return [type] [description]
     */
    public function getExamQuestion()
    {
        if (!($exam_id = I('exam_id') ) || !is_numeric($exam_id) ) $this->ajaxReturn(array('code' => 0, 'msg' => '我还真不知道你做的什么题'));
        $list = M('project_exam_question')->where(array('exam_id' => $exam_id))->select();
        if (!$list) $this->ajaxReturn(array('code' => 0, 'msg' => '这套考卷出题者未出题'));
        $this->ajaxReturn(array('code' => 1, 'msg' => '数据获取成功', 'data' => $list));
    }

    /**
     * [getExam 获取答卷]
     * @return [type] [description]
     */
    public function getExam()
    {
        if (!($uid = I('uid') ) || !is_numeric($uid) ) $this->ajaxReturn(array('code' => 0, 'msg' => '用户不存在')); 
        $exam = M('project_exam')->where(array('uid' => $uid))->select(); 
        if (!$exam) $this->ajaxReturn(array('code' => 0, 'msg' => '抱歉，该用户还未添加考卷'));
        $this->ajaxReturn(array('code' => 1, 'msg' => '数据获取成功', 'data' => $exam));  
    }


    /**
     * [resume 个人简历]
     * @return [type] [description]
     */
    public function resume()
    {
        if (!($uid = I('uid') ) || !is_numeric($uid) ) $this->error('不知道你要找谁的简历');
        
        $this->display();
    }

}