<?php 
namespace Admin\Model;
use Think\Model;
use Think\Model\RelationModel;
class AdminModuleMenuModel extends RelationModel { 

	protected $pk     = 'id';
	protected $_link = array(
		'AdminModule'=>array(
			'mapping_type'=>self::HAS_ONE,
			'foreign_key' =>'id', 
			'as_fields' =>'name:所属后台模块名'
		)
	);
}