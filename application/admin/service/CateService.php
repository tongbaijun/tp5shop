<?php

namespace app\admin\service;

class CateService
{
    // 用递归的方法取得分类
    public static function getCateByRecursion($cates,$pid=0,$level=0){
        static $cate=[];
        foreach($cates as $key=>$value){
            if($value['cate_pid']==$pid){
                $value['level']=$level;
                $cate[]=$value;
                self::getCateByRecursion($cates,$value['cate_id'],$level+1);
            }
        }
        return $cate;
    }
}
