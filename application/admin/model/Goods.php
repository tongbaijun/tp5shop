<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class Goods extends Model
{
    //获取所有商品
    public static function getALlGoods(){
       return self::table('shop_goods')->select();
    }
}