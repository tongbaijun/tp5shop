<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Limit extends Model
{
    protected $pk='limit_id';

    //添加角色权限
    public static function add_role_limit($data){
        return self::table('shop_limit_role')->insert($data);
    }

}
