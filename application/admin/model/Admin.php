<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class Admin extends Model
{
    protected $pk='admin_id';
    //模型关联
    public function role()
    {
        return $this->belongsToMany('Role','admin_role','role_id','admin_id');
    }
    //添加管理员角色
    public static function add_admin_role($data){
        return self::table('shop_admin_role')->insert($data);
    }
}