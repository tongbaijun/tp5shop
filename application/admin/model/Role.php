<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class Role extends Model
{
    protected $pk='role_id';
    //多对多 关联模型
    public function limits()
    {
        return $this->belongsToMany('Limit','limit_role','limit_id','role_id');
    }

}