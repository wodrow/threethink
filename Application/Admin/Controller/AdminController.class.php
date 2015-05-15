<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
class AdminController extends CommonController {
	
	public $list_modules; // 头部菜单列
	public $module_id; // 所属模块id
	public $_module; // 所属模块
	public $list_menus; // 菜单列
    
    public function _initialize()
    {
    	parent::_initialize();
    }

    // 获取头部菜单列
	public function get_header()
	{
		$this->list_modules = D('AdminModule')->where('visible>0')->select();
		$this->assign('list_modules',$this->list_modules ); // 注入显示模块
		$_module = $this->_module = get_arr_form_uncol('AdminModule','url',CONTROLLER_NAME);
		$this->assign('module_id',$this->module_id=$_module[id]); // 注入该模块id
		$this->assign('_module',$_module); // 注入该模块
	}
	
	// 获取菜单列
	public function get_menu()
	{
		$this->list_menus  = D('AdminModuleMenu')->where("adminmodule_id='$this->module_id'")->select();
		$this->assign('tree_menus',list_to_tree($this->list_menus)); // 注入左侧菜单
		foreach ($this->list_menus as $key => $value) {
			if ($value[url]==ACTION_NAME) {
				$node_id = $value[id];
			}
		}
		$parent_menus = get_list_parent($this->list_menus,$node_id);
		$this->assign('parent_menus',$parent_menus); // 注入父菜单列
	}

    // 获取筛选信息
    public function get_search()
    {
        if (I("post.table_search")) {
            if (I("post.search_value")=='') {
                $this->error("请输入查询条件!");
            }
            if (I("post.field_where")!='') {
                $this->table_search = I("post.field_where")." like '%".I("post.search_value")."%'";
            }else{
                $this->error("查询字段异常!");
            }
        }
    }

	/**
     * 获取数据表格
     * @param  string $modelname 数据表模型
     * @param  array $querystyle  查询方式 querys : tp连贯操作键值对
     * @param array $rewrites 结果重置 : '字段'=>array('结果'=>'重写')
     * @param array $newrow 关联新结果字段 : '关联模型'=>array('foreign_key'=>'外键','link_key'=>'关联字段','get_field'=>'获取字段','show_name'=>'显示字段别名')
     * @return assign
     * @todo 需要在模版中添加 show_table.html <include file="Public:show_table" />
     * @author wodrow <wodrow451611cv@gmail.com>
     */
    public function get_list_table($modelname,$querystyle=array(),$rewrites=array(),$newrow=array())
    {
    	// 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $Model = D($modelname);
        if ($querystyle[relation]) {
        	$Model = $Model->relation(true);
        }
        $Model = $Model->field($querystyle[fields])->where($querystyle[where])->order($querystyle[order]);
        if ($querystyle[table_show]) {
            C('TABLE_LIST_SHOW_COUNT',$querystyle[table_show]);
        }
        if ($querystyle[select]) {
            $table_info = $Model->page(I('get.p'),C('TABLE_LIST_SHOW_COUNT'))->select($querystyle[select]);
        }else{
            $table_info = $Model->page(I('get.p'),C('TABLE_LIST_SHOW_COUNT'))->select();
        }
        $count      = $Model->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,C('TABLE_LIST_SHOW_COUNT'));// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出

        $field_keys = $Model->getDbFields();
        $Model_FieldAttribute = D('FieldAttribute')->where("table_model_name='$modelname'");
        $field_id = $Model_FieldAttribute->getField('field_name,id');
        foreach ($field_keys as $k => $v) {
            if (!($field_id[$v])) {
                $this->error("field ".$v." haven't define in FieldAttribute!");
            }
        }
        // 字段别名
        $field_alias = $Model_FieldAttribute->getField('field_name,alias');
        $field_show_type = $Model_FieldAttribute->getField('field_name,show_type');
        // 结果重置
        $arr = array(
            // 'visible'=>array('0'=>'否','1'=>'是'),
            // 'fasten'=>array('0'=>'否','1'=>'是'),
            // 'is_null'=>array('0'=>'否','1'=>'是'),
        );
        $rewrites = array_merge($arr,$rewrites);
        if ($rewrites&&is_array($rewrites)) {
        	$field_names = array_keys($rewrites);
        	for ($i=0; $i < count($field_names); $i++) {
        		foreach ($table_info as $k => $v) {
        			if ($table_info[$k][$field_names[$i]]!=null) {
        				$table_info[$k][$field_names[$i]] = $rewrites[$field_names[$i]][$v[$field_names[$i]]];
        			}
        		}
        	}
        }
        // 新结果字段
        if ($newrow&&is_array($newrow)) {
        	$link_models = array_keys($newrow);
        	for ($i=0; $i < count($link_models); $i++) { 
        		// yc_vp($link_models[$i]);
        	}
        }
        $this->assign('count',$count); // 注入记录总数
        $this->assign('model_name',$modelname); // 注入模型名
        $this->assign('field_keys',$field_keys); // 获取所有字段
        $this->assign('field_alias',$field_alias); // 注入字段别名
        $this->assign('field_show_type',$field_show_type);
        // yc_vp($field_show_type,1);
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('table_info',$table_info);  // 注入列表信息(后台模块列表)
    }

    /**
     * 获取字段信息
     * @param  $model 模型名
     * @return assign
     * @author wodrow <wodrow451611cv@gmail.com>
     */
    public function get_field_info($modelname)
    {
        $Model = D($modelname);
        // 所有字段
        $field_keys = $Model->getDbFields();

        $Model_FieldAttribute = D('FieldAttribute')->where("table_model_name='$modelname'");
        // 字段详细
        $field_attrs = $Model_FieldAttribute->select();
        // 字段别名
        // $field_alias = $Model_FieldAttribute->getField('field_name,alias');
        // $field_show_type = $Model_FieldAttribute->getField('field_name,show_type');
        foreach ($field_keys as $k => $v) {
            if (!is_in_field($v,$field_attrs,'field_name')) {
                $this->error("字段".$v."并没有在字段属性表里！请在字段管理里面添加该字段属性");
            }
        }
        $this->assign('model_name',$modelname); // 注入模型名
        // $this->assign('field_keys', $field_keys); // 获取所有字段
        // $this->assign('field_alias',$field_alias); // 注入字段别名
        // $this->assign('field_show_type',$field_show_type);
        $this->assign('field_attrs',$field_attrs); // 注入字段别名
    }

    // 选择显示？增加？编辑模版
    public function data_display($modelname,$querystyle=array(),$rewrites=array(),$newrow=array())
    {
        $this->get_header();
        $this->get_menu();
        $this->get_search();

        if (!I("get.add")&&!I("get.edit")) {
            $this->get_list_table($modelname,$querystyle=array(),$rewrites=array(),$newrow=array());
        }else{
            $this->get_field_info($modelname);
        }
        if ($this->table_search) {
            $this->get_list_table($modelname,array(
                'where'=>$this->table_search,
                'table_show'=>10000,
            ));
        }

        if (I("get.add")==true) {
            if (I("get.success_url")) {
                session("back_url",I("get.success_url"));
                $this->display('Base:data_add');
            }else{
                $this->error("no back");
            }
        }else if(I("get.edit")==true){
            if (!I('edit_id')) {
                $this->error("have not select a data");
            }
            $data_info = D($modelname)->where("id=".I("get.edit_id"))->find();
            $this->assign('info',$data_info);
            $this->display('Base:data_edit');
        }else{
            $this->display('Base:data_show');
        }
    }

        public function uploadify()
    {
        /*
        Uploadify
        Copyright (c) 2012 Reactive Apps, Ronnie Garcia
        Released under the MIT License
<http://www.opensource.org/licenses/mit-license.php>
    */
        // Define a destination
        // $targetFolder = '/uploads'; // Relative to the root
        if (I('get.model_name')) {
            $model_name = I("get.model_name");
        }else{
            $this->error("no upload model directory define");
        }

        $verifyToken = md5('unique_salt' . $_POST['timestamp']);

        if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            // $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            // $targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
            $targetFile= './Uploads/images/'.$model_name.'/'.$_FILES['Filedata']['name'];
            // file_put_contents("filename", $targetFile);
            
            // Validate the file type
            $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            
            if (in_array($fileParts['extension'],$fileTypes)) {
                move_uploaded_file($tempFile,$targetFile);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    // 数据添加
    public function data_add()
    {
        if (I("get.model_name")) {
            $Model = D(I("get.model_name"));
            if ($y = $Model->create()) {
                if ($addid = $Model->data($y)->add()) {
                    $this->success("add success" ,U(session("back_url")."?edit=true&edit_id=".$addid));
                }else{
                    $this->error($Model->getError());
                }
            }else{
                $this->error($Model->getError());
            }
        }else{
            $this->error('非法访问！');
        }
    }

    // 数据编辑
    public function data_edit()
    {
        if (I("get.model_name")) {
            $Model = D(I("get.model_name"));
            if ($y = $Model->create()) {
                 if ($addid = $Model->data($y)->save()) {
                    $this->success("edit success");
                }else{
                    $this->error($Model->getError());
                }
            }else{
                $this->error($Model->getError());
            }
        }else{
            $this->error('非法访问！');
        }
    }

    // 数据删除
    public function data_del()
    {
        if (($model_name=I('model_name','','htmlspecialchars'))&&($ids = I("ids"))) {
            $map[id] = array('in',$ids);
            yc_vp(D($model_name)->where($map)->select(),1);
        }
    }
}