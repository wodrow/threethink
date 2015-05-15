<?php
namespace Admin\Controller;
use Think\Controller;
class TestController extends MemberController {

	public function _initialize()
	{
		parent::_initialize();
	}

    public function Index()
    {
    	header("location:".U('test1'));
    }

    // bootstrap test1
    public function test1()
    {
        $this->display();
    }
}