<?php
namespace Home\Controller;
class UserController extends HomeController {

	public function _initialize()
	{
		parent:: _initialize();
	}

    public function index(){
        echo C('APP_VERSION');
    }
}