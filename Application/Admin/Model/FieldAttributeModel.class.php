<?php 
namespace Admin\Model;
use Think\Model\RelationModel;
class FieldAttributeModel extends RelationModel { 

	protected $pk     = 'id';

	protected $_validate = array(
		array('table_model_name', 'require','模型名必填'),
		array('field_name', 'require','字段名必填'),
		array('alias', 'require','字段别名必填'),
		array('type', 'require','数据类型必填'),
	);
}