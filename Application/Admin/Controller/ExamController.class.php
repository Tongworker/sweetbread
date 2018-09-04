<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
/**
 * 考卷
 */
class ExamController extends BaseController {
    /**
     * [index 主页]
     * @return [type] [description]
     */
    public function index()
    {
    	if ($content = I('content')) $where['_complex'] = array(
    		'E.title' => array('LIKE', '%'.$content.'%'),
    		'U.name' => array('LIKE', '%'.$content.'%'),
    		'_logic' => 'or'
    	);
    	$count = M('project_exam')
    				->alias('E')
    				->join('project_user AS U ON E.uid = U.id')
    				->where($where)
    				->count();
    	$Page = new \Think\Page($count,10);
    	$list = M('project_exam')
    				->alias('E')
    				->field('E.id, E.title, E.addtime, E.visit_number, U.name')
    				->join('project_user AS U ON E.uid = U.id')
    				->where($where)
    				->limit($Page->firstRow.','.$Page->listRows)
    				->order('E.id desc')
    				->select();
    	$this->assign(
    		array(
    			'list' => $list,
    			'show' => $Page->show(),
    			'content' => $content
    		)
    	)->display();
    }

    /**
     * [getUser 获取用户信息]
     * @param  [type] $search [搜索条件]
     * @return [type]         [description]
     */
    public function getUser()
    {
    	if (!($search = I('search') ) ) $this->ajaxReturn(array('code' => 0, 'msg' => '请输入搜索条件'));
    	$search = trim($search);
    	$data = M('project_user')
    				->field('id, name, phone')
		    		->where(array(
		    			'_complex' => array(
		    				'name' => array('LIKE', '%'.$search.'%'),
		    				'phone' => array('LIKE', '%'.$search.'%'),
		    				'_logic' => 'or'
		    			)
		    		))
		    		->select();
		if (!$data) $this->ajaxReturn(array('code' => 0, 'msg' => '该搜索条件未找到任何用户'));
		$this->ajaxReturn(array('code' => 1, 'msg' => '数据获取成功', 'data' => $data));
    }

    /**
     * [addExam 创建答卷]
     * @param [type] $[uid] [<用户id>]
     * @param [type] $[title] [<考题标题>]
     */
    public function addExam()
    {
    	if (!($uid = I('uid')) || !is_numeric($uid) ) $this->error('用户不存在', 'Exam-index');
    	if (!($title = I('title')) ) $this->error('考卷题目不存在', 'Exam-index');
    	// 验证用户真伪性
    	$checkUser = $this->checkUser($uid);
    	if ($checkUser['code'] != 1) $this->error('用户不存在', 'Exam-index');
    	$data = $checkUser['data'];
    	$count = M('project_exam')->where(array('uid' => $uid, 'title' => $title))->count();
    	if ($count > 0) $this->error('不允许添加同样的标题考卷');
    	$res = M('project_exam')->add(array('title' => $title, 'uid' => $uid, 'addtime' => date('Y-m-d H:i:s')));
    	if (!$res) $this->error('数据库添加失败', 'Exam-index');
    	$this->success('添加成功');
    }

    /**
     * [del description]
     * @param [type] $[id] [<考题id>]
     * @return [type] [description]
     */
    public function del()
    {
    	if (!($id = I('id')) || !is_numeric($id) ) $this->error('考卷不存在');
    	$res = M('project_exam')->where(array('id' => $id))->delete();
    	if (!$res) $this->error('删除失败');
    	$this->success('删除成功');
    }

    /**
     * [getQuestion 获取考卷试题]
     * @param [type] $[eid] [<description>]
     * @return [type] [description]
     */
    public function getQuestion()
    {
        if (!($eid = I('eid')) || !is_numeric($eid) ) $this->error('考卷不存在');
        $info = M('project_exam')
                    ->alias('E')
                    ->field('E.title, U.name')
                    ->join('LEFT JOIN project_user AS U ON E.uid = U.id')
                    ->where(array('E.id' => $eid))
                    ->find();
        if (!$info) $this->error('答卷不存在');
        if (!$info['name'] ) $this->error('答卷未找到出卷者');
        $data = M('project_exam_question')
                    ->where(array('exam_id' => $eid))
                    ->select();
        $this->assign(
            array(
                'data' => $data,
                'info' => $info
            )
        )->display();
    }

    public function addQues()
    {
        
    }
}