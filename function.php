<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 define('COOKIEENCODE', 'localhost');

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


function getChild($node,$pid=0,$lev=0){
    
    $arr=array();
    
    foreach ($node as $key => $value) {
        if($value['pid']==$pid){
            $level=array('lev'=>$lev);
            $value=  array_merge($value,$level);
            $arr[]=  $value;
            $arr=array_merge($arr, getChild($node,$value['id'],($lev+1))) ;
        }
    }

    return $arr;
}

/**
 * 获得祖先元素
 * @param int $nid 节点id
 * @return array 返回数组
 */

function getFather($arr,$id){
    $array=array();
    foreach ($arr as $v){
        if($v['id']==$id){
            $array=getFather($arr,$v['pid']);
            array_push($array,$v);
            
        }
    }
    
    return $array;
}

function getChildren($arr,$id){
    $array=array();
}

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

