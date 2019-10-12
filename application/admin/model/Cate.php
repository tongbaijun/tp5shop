<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class Cate extends Model
{
    //取得所有分类
    public static function getAllCate(){
      return  Db::table('shop_cate')->select();
    }
    //取得单个分类
    public static function getOneCate($cate_id){
        return Db::table('shop_cate')->where(['cate_id'=>$cate_id])->find();
    }
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
    //修改分类
    public static function updateCate($cate_id,$data){
        if(Db::table('shop_cate')->where(['cate_id'=>$cate_id])->update($data)){
            return true ;
        }
    }
}
