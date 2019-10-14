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
    //面包屑
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
    //通过递归取 子集塞进父类child 字段
    public static function getLimit($array,$pid=0){
        $arr=[];
        foreach($array as $key=>$value) {
            if($value['limit_pid']==$pid){
                $son=self::getLimit($array,$value['limit_id']);
                if($son){
                    $value['child']=$son;
                }
                $arr[]=$value;
            }
        }
        return $arr;
    }
    //添加权限
    public static function add_limit($data){
       return self::table('shop_limit')->insert($data);
    }
    //添加角色权限
    public static function add_role_limit($data){
        return self::table('shop_limit_role')->insert($data);
    }
    //角色权限 权限表 、 角色表三表联查
    public static function getAllRoleLimit(){
        return self::table('shop_limit_role')->join('shop_limit','shop_limit_role.limit_id = shop_limit.limit_id')->join('shop_role','shop_role.role_id=shop_limit_role.role_id')->select();
    }

}
