<?php
namespace Home\Controller;
use Common\Controller\CommonController;
class HomeController extends CommonController {

	public function _initialize()
    {
    	parent::_initialize();
    }

    public function index(){
    	echo "asdgasd";
        echo C('APP_VERSION');
    }
}