<?php

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
      $arr=array_merge($arr,self::unlimitedForlevel($cate,$html,$v['id']),$level+1);
    }
    return $arr;
  }
}

