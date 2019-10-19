<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class Goods extends Model
{
    protected  $pk='goods_id';
    //模型关联
    public function attr(){
        return $this->belongsToMany('Attr','goods_attr','attr_id','goods_id');
    }
}