sql语句
$data = $user->query("select u.id,IF(u.portrait != '',CONCAT('http://".$_SERVER['HTTP_HOST'].__APP__."',u.portrait),'')  from user as u;

模型的query和execute方法 同样支持预处理机制，例如：
$model->query('select * from user where id=%d and status=%d',$id,$status);//或者$model->query('select * from user where id=%d and status=%d',array($id,$status));


/*告诉浏览器utf8编码的反应头*/
header('Content-Type:text/html;charset=utf-8');

/*前端url字符串的编码*/
 phoneurl=encodeURI(encodeURI(phoneurl));

/* 
 * 对cookie的值进行加密
 */
function encryption($str,$flag=0){
    if($flag==1){
        $str=base64_decode($str);
        $crypto=md5(C('ENCRYTION_KEY'));
        $str=$str^$crypto;
        return  $str;
    }else{
         $key=md5(C('ENCRYTION_KEY'));
         $str=$str^$key;
         return base64_encode($str);
    }
};


/* 
 * 递归获得树形结构
 */
function unlimitedForlevel($cate,$html='--',$pid=0,$level=0){
    $arr=array();
    foreach ($cate as $v) {
        if($v['pid']==$pid){
            $v['level']=$level+1;
            $v['html']=str_repeat($html, $level);
            $arr[]=$v;
            $arr=array_merge($arr,unlimitedForlevel($cate,$html,$v['id'],($level+1)));
        }
    }
    return $arr;
}


/* 
 * 递归获得树形结构
 */
function getCategary($arr,$pid=0,$lev=0){
    $array=array();
    foreach ($arr as $v){
        if($v['pid']==$pid){ 
            $v=array_merge($v,array('lev'=>$lev) );
            $array[]=$v;   
            $array=array_merge($array,  getCategary($arr,$v['id'],($lev+1)));
         }
     }
     return $array;
 }

/*传入一个子id，返回所有的父级分类*/
function getParents($cate,$id){
	$arr=array();
	foreach($cate as $v){
		if($v['id']==$id){
			$arr[]=$v;
			$arr=array_merge(getParents($cate,$v['pid']),$arr);
		}
	}
	return $arr;
}


/*传入一个父级id，返回所有的子级分类(返回一维数组)*/
function getChilds($cate,$pid){
	$arr=array();
	foreach($cate as $v){
		if($v['pid']==$pid){
                        $arr[]=$v; 
			$arr=array_merge($arr,getChilds($cate,$v['id']));
		}
	}
	return $arr;
}


/**************************************************************
 *
 *  将数组转换为JSON字符串（兼容中文）
 *  @param  array   $array      要转换的数组
 *  @return string      转换得到的json字符串
 *  @access public
 *
 *************************************************************/
function JSON($array) {
        arrayRecursive($array,'urlencode',true);
        $json = json_encode($array);
        return urldecode($json);
}


/*JSON辅助方法*/
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    static $recursive_counter = 0;
    if (++$recursive_counter > 1000) {
        die('possible deep recursion attack');
    }
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            arrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function($value);
        }
        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
    $recursive_counter--;
}


    /**
     * 根据不同情况返回不同数据格式
     * @param $data 任何数据 默认为空数组 ，如果是返回json格式的这里规定只允许用数组
     * @param int $code  错误代码 默认为200
     * 返回说明：
     * 一、正常时的返回JSON数据包示例：
     * 1.一般用于不需要返回内容的情况：{"code": 0, "info": "ok","data":$data}
     * 二、错误时的返回JSON数据包示例：错误内容用中文 {"code":40001,"info":"错误XXX"}
     */
    public function apiReturn($code = 200,$data=""){
            $info=  statusCode();
            /* 返回JSON数据格式到客户端 包含状态信息*/
            header('Content-Type:application/json; charset=utf-8');
            $error = array(
                'code'=>$code,
                'info'=>$info[$code]
            );
            if(is_array($data)){
                $data=array('data'=>$data);
                $result = array_merge($error,$data);
            }else{
                $result = $error;
            }
            exit(JSON($result));
    }
