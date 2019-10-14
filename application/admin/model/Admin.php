<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class Admin extends Model
{
    //取所有管理员
    public static function getAllAdmin(){
        return  self::table('shop_admin')->select();
    }
    //添加管理员
    public static function add_admin($data){
        return  self::table('shop_admin')->insert($data);
    }
    //添加管理员角色
    public static function add_admin_role($data){
        return self::table('shop_admin_role')->insert($data);
    }
}