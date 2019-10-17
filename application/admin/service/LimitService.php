<?php

namespace app\admin\service;

class LimitService
{
    //面包屑导航
    public static function breadNav($cates,$cate){
        $arr=[];
        foreach($cates as $key=>$val){
            if($val["cate_id"]==$cate["cate_pid"]){
                $arr[]=$val;
                $prev=self::breadNav($cates,$val);
                if($prev){
                    $arr=array_merge($arr,$prev);
                }
            }
        }
        return $arr;
    }
    // 用递归的方法取得分类
    public static function getLimitByRecursion($limit,$pid=0,$level=0){
        static $li=[];
        foreach($limit as $key=>$value){
            if($value['limit_pid']==$pid){
                $value['level']=$level;
                $li[]=$value;
                self::getLimitByRecursion($limit,$value['limit_id'],$level+1);
            }
        }
        return $li;
    }
    //父子结构 子集塞进父类child 字段
    public static function getLimitTree($array,$pid=0){
        $arr=[];
        foreach($array as $key=>$value) {
            if($value['limit_pid']==$pid){
                $value['child']=[];
                $son=self::getLimitTree($array,$value['limit_id']);
                if($son){
                    $value['child']=$son;
                }
                $arr[]=$value;
            }
        }
        return $arr;
    }
}
