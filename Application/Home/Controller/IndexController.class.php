<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends UserController {

	public function _initialize()
	{
		parent:: _initialize();
	}

    public function index(){
    	// yc_vp(C('APP_VERSION'),1);
        $this->display();
    }
}