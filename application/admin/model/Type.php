<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class Type extends Model
{
    protected $pk='type_id';
    public function attr()
    {
        return $this->belongsTo('Attr','attr_id','type_id');
    }
}