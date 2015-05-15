<?php 
namespace Common\Model;
use Think\Model\RelationModel;
class TestModel extends RelationModel { 

	protected $pk     = 'id';

	protected $_validate = array(
		array('test_name','require','测试名必填'),
		array('test_name','','测试名称已经存在！',0,'unique',1), 
	);
}