<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class Role extends Model
{
    //取所有角色
    public static function getAllRole(){
       return self::table('shop_role')->select();
    }
    //添加角色
    public static function addRole($data){
        return self::table('shop_role')->insert($data);
    }
}