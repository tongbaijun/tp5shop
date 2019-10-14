<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Limit extends Model
{
    //取所有权限
    public static function getAllLimit(){
        return self::table('shop_limit')->select();
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
    //添加权限
    public static function add_limit($data){
       return self::table('shop_limit')->insert($data);
    }
}
