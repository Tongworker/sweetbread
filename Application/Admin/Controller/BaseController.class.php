<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 公共继承
 */
class BaseController extends Controller {
    	
    /**
     * [__construct 后台初始验证]
     */
    public function __construct()
    {
    	// 构造验证用户
    	parent::__construct();
    	if (!session('tppadmin') ) {
    		$this->redirect('Login/index');
    	}
    	$session = session('tppadmin');
    	
    	$cache = S('tppadmin:'.$session['uid']);
    	if (!$cache) {
            session('tppadmin', null);
            $this->redirect('Login/index');
        }
    	if ($cache['code'] != $session['code']) {
    		session('tppadmin', null);
    		$this->error('你已在异地登录', 'Index-index');
    	}
    }

    /**
     * [error 404页面绑定 $this->error()]
     * @return [type] [description]
     */
    public function error($content, $url = 'callback')
    {
    	$this->redirect('Login/error', array('content' => $content, 'url' => $url));
    }

    /**
     * [error 404页面绑定 $this->error()]
     * @return [type] [description]
     */
    // public function success($content, $url = 'callback')
    // {
    //     $this->redirect('Login/success', array('content' => $content, 'url' => $url));
    // }

    /**
     * [baseLeft 公共左侧页]
     * @return [type] [description]
     */
    public function baseLeft()
    {
        $this->display();
    }

    /**
     * [getUser 获取用户详情]
     * @return [type] [description]
     */
    protected function checkUser($uid)
    {
        $return = M('project_user')->where(array('id' => $uid))->find();
        if (!$return) return array('code' => 0);
        return array('code' => 1, 'data' => $return);
    }
}