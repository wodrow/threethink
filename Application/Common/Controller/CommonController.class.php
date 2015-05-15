<?php 
namespace Common\Controller;
use Think\Controller;
class CommonController extends Controller {

	public function _initialize()
    {
    	get_tt_config();
    }
    
}