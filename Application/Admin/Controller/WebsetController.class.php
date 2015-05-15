<?php
namespace Admin\Controller;
class WebsetController extends MemberController {

	public function _initialize()
	{
        parent::_initialize();
        C('WEB_TITLE','三思框架-网站设置');
        // yc_vp(D('AdminModule')->relation(true)->select());
	}

    public function __destruct()
    {
        // yc_vp(M()->getlastsql());
    }

    public function index()
    {
    	$this->display('Base:data_index');
    }

    // 后台模块管理
    public function hou_tai_mo_kuai()
    {
        C('WEB_TITLE','三思框架-后台模块管理');
        $this->data_display('AdminModule');
    }

    // 后台菜单
    public function hou_tai_cai_dan()
    {
        C('WEB_TITLE','三思框架-后台菜单管理');
        $this->data_display('AdminModuleMenu');
    }
    // 字段管理
    public function zi_duan_guan_li()
    {
        C('WEB_TITLE','三思框架-字段管理');
        $this->data_display('FieldAttribute');
    }

    

    // 自定义配置
    public function zi_ding_yi()
    {
        C('WEB_TITLE','三思框架-自定义配置');
        $this->data_display('Config');
    }
}