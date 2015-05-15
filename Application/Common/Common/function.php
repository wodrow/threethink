<?php

/**
 * 调试输出|调试模式下
 * @param  mixed $test 调试变量
 * @param  int $style 是否停止 | 打印输出
 * @return void       浏览器输出
 * @author wodrow <wodrow451611cv@gmail.com>
 */
function yc_vp($test,$style=0)
{
    switch ($style) {
        case 1:
            echo "<pre>";
            var_dump($test);
            echo "</pre>";
            break;

        case 2:
            echo "<pre>";
            var_dump($test);
            echo "</pre>";
            exit("<hr>");
            break;

        case 3:
            file_put_contents('testfile.php', "<? \r".var_export($test, true));
            break;

        case 4:
            file_put_contents('testfile.php', "<? \r".var_export($test, true));
            exit("<hr>");
            break;

        case 5:
            file_put_contents('testfile.php', "\r\r".var_export($test, true),FILE_APPEND);
            break;

        case 6:
            file_put_contents('testfile.php', "\r\r".var_export($test, true),FILE_APPEND);
            exit("<hr>");
            break;   

        default:
            echo "<pre>";
            var_dump('fff');
            echo "</pre>";
            break;
    }
}

/**
 * 获取自定义配置
 * @return void  
 * @author wodrow <wodrow451611cv@gmail.com>
 */
function get_tt_config()
{
	foreach (M('config')->select() as $key => $value) {
		C($value[name],$value[value]);
	}
}


/**
 * 把数组做成树
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $child level标记字段
 * @param int $root 
 * @return array   树状数组 
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function list_to_tree($list, $pk='id',$pid = 'pid',$child = '_child',$root=0)
{
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree  原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array  $list  过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
function tree_to_list($tree, $child = '_child', $order='id', &$list = array()){
    if(is_array($tree)) {
        $refer = array();
        foreach ($tree as $key => $value) {
            $reffer = $value;
            if(isset($reffer[$child])){
                unset($reffer[$child]);
                tree_to_list($value[$child], $child, $order, $list);
            }
            $list[] = $reffer;
        }
        $list = list_sort_by($list, $order, $sortby='asc');
    }
    return $list;
}

/**
 * 字符串转换为数组，主要用于把分隔符调整到第二个参数
 * @param  string $str  要分割的字符串
 * @param  string $glue 分割符
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function str2arr($str, $glue = ','){
    return explode($glue, $str);
}

/**
 * 数组转换为字符串，主要用于把分隔符调整到第二个参数
 * @param  array  $arr  要连接的数组
 * @param  string $glue 分割符
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function arr2str($arr, $glue = ','){
    return implode($glue, $arr);
}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 单位 秒
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_encrypt($data, $key = '', $expire = 0) {
    $key  = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
    $data = base64_encode($data);
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    $str = sprintf('%010d', $expire ? $expire + time():0);

    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
    }
    return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
}

/**
 * 我的加密方法
 * @param  string $data 加密的数据
 * @return string   $data 返回的数据
 * @author wodrow <wodrow451611cv@gmail.com>
 */
function wodrow_encrypt($data)
{
    return md5($data);
}

/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key  加密密钥
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_decrypt($data, $key = ''){
    $key    = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
    $data   = str_replace(array('-','_'),array('+','/'),$data);
    $mod4   = strlen($data) % 4;
    if ($mod4) {
       $data .= substr('====', $mod4);
    }
    $data   = base64_decode($data);
    $expire = substr($data,0,10);
    $data   = substr($data,10);

    if($expire > 0 && $expire < time()) {
        return '';
    }
    $x      = 0;
    $len    = strlen($data);
    $l      = strlen($key);
    $char   = $str = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        }else{
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return base64_decode($str);
}

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function data_auth_sign($data) {
    //数据类型检测
    if(!is_array($data)){
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

/**
* 对查询结果集进行排序
* @access public
* @param array $list 查询结果
* @param string $field 排序的字段名
* @param array $sortby 排序类型
* asc正向排序 desc逆向排序 nat自然排序
* @return array
*/
function list_sort_by($list,$field, $sortby='asc') {
   if(is_array($list)){
       $refer = $resultSet = array();
       foreach ($list as $i => $data)
           $refer[$i] = &$data[$field];
       switch ($sortby) {
           case 'asc': // 正向排序
                asort($refer);
                break;
           case 'desc':// 逆向排序
                arsort($refer);
                break;
           case 'nat': // 自然排序
                natcasesort($refer);
                break;
       }
       foreach ( $refer as $key=> $val)
           $resultSet[] = &$list[$key];
       return $resultSet;
   }
   return false;
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 设置跳转页面URL
 * 使用函数再次封装，方便以后选择不同的存储方式（目前使用cookie存储）
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function set_redirect_url($url){
    cookie('redirect_url', $url);
}

/**
 * 获取跳转页面URL
 * @return string 跳转页URL
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_redirect_url(){
    $url = cookie('redirect_url');
    return empty($url) ? __APP__ : $url;
}

/**
 * 获取email登录页url
 * @param  string $email emial
 * @return string       $email_url
 * @author wodrow <wodrow451611cv@gmail.com>
 */
function getemailurl($email)
{
    $email = explode('@',$email); 
        switch ($email[1]) {
            case 'foxmail.com':
                $email_url="http://www.foxmail.com";
                break;
            case 'eyou.com':
                $email_url="http://www.eyou.com/";
                break;
            case '189.com':
                $email_url="http://webmail16.189.cn/webmail/";
                break;
            case 'live.com.cn':
                $email_url="http://login.live.com.cn";
                break;
            case 'live.cn':
                $email_url="http://login.live.cn";
                break;
            case 'live.com':
                $email_url="http://login.live.com";
                break;
            case 'hotmail.com':
                $email_url="http://mail.hotmail.com";
                break;
            case '139.com':
                $email_url="http://mail.10086.cn";
                break;
            case 'sogou.com':
                $email_url="http://mail.sogou.com";
                break;
            case 'qq.com':
                $email_url="http://mail.qq.com";
                break;
            case "163.com":
                $email_url="http://mail.163.com";
                break;
            case "126.com":
                $email_url="http://mail.126.com";
                break;
            case "yeah.net":
                $email_url="http://www.yeah.net/";
                break;
            case "188.com":
                $email_url="http://www.188.com/";
                break;
            case "sohu.com":
                $email_url="http://mail.sogou.com/";
                break;
            case "yahoo.cn":
                $email_url="http://mail.cn.yahoo.com/";
                break;
            case "yahoo.com.cn":
                $email_url="http://mail.cn.yahoo.com/";
                break;
            case "tom.com":
                $email_url="http://mail.tom.com/";
                break;
            case "21cn.com":
                $email_url="http://mail.21cn.com/";
                break;
            case "sina.com":
                $email_url="http://mail.sina.com.cn";
                break;
            case "gmail.com":
                $email_url="http://mail.google.com";
                break;
            default:
                $email_url="";
                break;
        }
    return $email_url;
}

/**
 * 获取节点所有父级元素
 * @param array $list 数据
 * @param int $id
 * @param int $pid
 * @param int $root 根节点
 * @return array 父节点
 * @author wodrow <wodrow451611cv@gmail.com>
 */
function get_list_parent($list,$node_id,$id='id',$pid='pid',$root=0)
{
    $Stime=0;
    $Etime=0;
    $Ttime=0;
    $Stime=microtime(true);//获取程序开始执行的时间
    //echo $Stime."<br/>";
    
	$i = $root;
	while($node_id!=$root){
		foreach ($list as $k => $v){
			if ($v[id]==$node_id){
				$node_to_root[$i++] = $k;
				$node_id = $v[pid];
			}
		}
	} 
	$i = $i-1;
    for($i;$i>=$root;$i--){
    	$root_to_node[] = $node_to_root[$i];
    	$parent_list[] = $list[$node_to_root[$i]];
    }

    $Etime=microtime(true);//获取程序执行结束的时间
    //echo $Etime."<br/>";
    $Ttime=$Etime-$Stime;//计算差值
    //echo $Ttime."<br/>";
    $str_total=var_export($Ttime,TRUE);
    if(substr_count($str_total,"E")){ //为了避免1.28746032715E-005这种结果的出现,做了一下处理.
    $float_total=floatval(substr($str_total,5));
    $Ttime=$float_total/100000;
    }
    // echo $Ttime.'秒';

    return $parent_list;
    // return $list;
}

/**
 * 从唯一列获取该条数据信息
 * @param array $M 数据表
 * @param string $col 列字段
 * @param all $data 字段值
 * @return int 主键id
 * @author wodrow <wodrow451611cv@gmail.com>
 */
function get_arr_form_uncol($M,$col,$data)
{
	$tmp = M($M)->where($col."='$data'")->find();
	return $tmp;
}

/**
 * 页面输出结果
 * @param  string|int|arr $data 
 * @return string      
 */
function text_show($data)
{
    if ($data==''||$data==null) {
        $data = "无";
    }
    if (is_array($data)) {
        echo "array";
    }
    return $data;
}

/**
 * 读取一个表的列信息
 * @author 吾爱 qq296624314
 * @param string $tableName 表名
 * @param array $option 需要获取的属性
 * @return array 返回的一个数组，若指定属性，则以 array("列名1"=>array("属性名1"=>"属性1值"……)……)的格式返回，否则以 array("列名1","列名2"……)的格式返回
 * @example 
 */
function  getcolumns($tableName,$option=array()){
    $m=M();
    $columns=array();
    $m_re=$m->query("show columns from `{$tableName}`");
    if(!$m_re){
        return array();
    }
    foreach($m_re as $v){
        $v=array_change_key_case($v);
        if(empty($option)){
            $columns[]=$v["field"];
        }else{
            $vv=array();
            foreach($option as $op){
                $op=strtolower($op);
                if(array_key_exists($op,$v)){
                    $vv[$op]=$v[$op];
                }
            }
            $columns[$v["field"]]=$vv;
        }
    }
    return $columns;
}

/**
 * 检查值是否在二维数组特定字段里
 * @param  string  $value 检查的值
 * @param  array  $arr   二维数组
 * @param  string  $field 字段名
 * @return int|null        二维数组行id
 */
function is_in_field($value,$arr,$field)
{
    $x = array();
    foreach ($arr as $k => $v) {
        $x[$v[id]] = $v[$field];
    }
    foreach ($x as $k => $v) {
        if ($value==$v) {
            return $k;
        }
    }
}

function find_binary_checked($number,$select)
{
    // yc_vp($number,1);
    $binary = decbin($number);
    // yc_vp($binary,1);
    $x = strrev($binary);
    $x = substr($x, $select-1,1);
    // yc_vp($x,1);
    if ($x) {
        return true;
    }else{
        return false;
    }
}