<?php
namespace Admin\Controller;
class MemberController extends AdminController {
	
	public function _initialize()
	{
		parent::_initialize();
		C('WEB_TITLE','三思框架-成员权限');
		$this->get_header();
        $this->get_menu();
	}

	public function index()
	{
		$this->display();
	}
	
	public function cheng_yuan_guan_li()
	{
		C('WEB_TITLE','三思框架-成员管理');
		$this->get_list_table('Member',array(
            'table_show'=>5,
        ));
		$this->display('Base:data_show');
	}
}