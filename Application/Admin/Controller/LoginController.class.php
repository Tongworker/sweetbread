<?php
namespace Admin\Controller;
use Think\Controller;
/**
 *
 * 登录
 */
class LoginController extends controller {
    /**
     * [index 登陆页面]
     * @return [type] [description]
     */
    public function index()
    {
    	if (session('tppadmin') ) {
    		$this->redirect('Index/index');
    	}
    	$this->display();
    }

    /**
     * [login 登录]
     * @param  [type] $account [账号]
     * @param  [type] $pass    [密码]
     * @return [type]          [description]
     */
    public function login()
    {
    	if (!($account = I('account') ) ) $this->error('给我个账号');
    	if (!($pass = I('pass') ) ) $this->error('给我个密码');
    	$data = M('project_user')->where(array('account' => $account))->find();
    	if (!$data) $this->error('账号错误');
    	if ($data['pass'] != $pass) $this->error('密码错误');
    	$code = rand();
    	session('tppadmin', array(
    		'uid' => $data['id'],
    		'name' => $data['name'],
    		'code' => $code
    	));
    	S('tppadmin:'.$data['id'], array('code' => $code));
    	$this->success('登录成功');
    }
    /**
     * [error 404页面绑定 $this->error()]
     * @return [type] [description]
     */
    public function error($content, $url = 'callback')
    {
        if ($url != 'callback') {
            $url = str_replace('-', '/', $url);
        }
    	$this->assign(
    		array(
    			'content' => $content,
    			'url' => $url
    		)
    	)->display('login/error');
    	// exit();
    }

    /**
     * [success 成功页面绑定 $this->success()]
     * @return [type] [description]
     */
    // public function success($content, $url = 'callback')
    // {
    //     if ($url != 'callback') {
    //         $url = str_replace('-', '/', $url);
    //     }
    //     $this->assign(
    //         array(
    //             'content' => $content,
    //             'url' => $url
    //         )
    //     )->display('/login/success');
    //     // exit();
    // }

    /**
     * [logout 登出]
     * @return [type] [description]
     */
    public function logout()
    {
        S('tppadmin:'.session('tppadmin.uid'), null);
        session('tppadmin', null);
        $this->redirect('Index/index');
    }
}