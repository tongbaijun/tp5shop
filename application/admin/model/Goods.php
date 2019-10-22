<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class Goods extends Model
{
    protected  $pk='goods_id';
    //模型关联 多对多
    public function attr(){
        return $this->belongsToMany('Attr','goods_attr','attr_id','goods_id');
    }
    //   一对多
    public function product()
    {
        return $this->hasMany('Product','goods_id','goods_id');
    }
}