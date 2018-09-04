<?php
namespace Home\Controller;
use Think\Controller;

class LoveController extends Controller {
    /**
     * [爱心 主页]
     * @return [type] [description]
     */
    public function index()
    {
        $this->error('敬请期待');
    	// $this->display();
    }

    /**
     * [love_1 爱心-1]
     * @return [type] [description]
     */
    public function love_1() 
    {
        $this->display();   
    }

    /**
     * [love_1_2 爱心-1 对应love_1 使用iframe]
     * @return [type] [description]
     */
    public function love_1_2() 
    {
        $this->display();   
    }

    /**
     * [love_2 爱心-2]
     * @return [type] [description]
     */
    public function love_2() {
        $this->display();      
    }

    /**
     * [love_2 爱心-2 对应love_2 使用iframe]
     * @return [type] [description]
     */
    public function love_2_2() {
        $this->display();      
    }

    /**
     * [love_3 爱心-3]
     * @return [type] [description]
     */
    public function love_3() {
        $this->display();
    }

}