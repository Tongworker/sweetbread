<?php
namespace Admin\Widget;
use Think\Controller;

class CateWidget extends Controller {
    public function menu(){
    	$list = array(
    		array(
    			'id' => 1,
    			'name' => '主页',
                'class' => 'fa fa-home',
    			'list' => array(
    				array(
    					'name' => '主页',
    					'url' => U('Index/index')
    				)
    			)
    		),
    		array(
    			'id' => 2,
    			'name' => '答卷库',
                'class' => 'fa fa-desktop',
    			'list' => array(
    				array(
    					'name' => '展示',
    					'url' => U('Exam/index')
    				)
    			)
    		),
            array(
                'id' => 3,
                'name' => '酷炫',
                'class' => 'fa fa-desktop',
                'list' => array(
                    array(
                        'name' => '展示',
                        'url' => U('Canvas/index')
                    )
                )
            ),
            array(
                'id' => 4,
                'name' => 'W',
                'class' => 'fa fa-desktop',
                'list' => array(
                    array(
                        'name' => 'Excel分组',
                        'url' => U('Excel/index')
                    ),
                )
            )
    	);
        return $list;
    }
}

