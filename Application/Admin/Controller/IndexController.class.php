<?php
namespace Admin\Controller;
class IndexController extends MemberController {

	public function _initialize()
	{
		parent::_initialize();
		C('WEB_TITLE','三思框架-首页');
		$this->get_header();
		$this->get_menu();
	}

    public function index()
    {
    	C('WEB_TITLE','三思框架-首页');
    	$this->display();
    }
}