<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class Brand extends Model
{
    //取所有品牌
    public static function getAllBrand(){
       return self::table('shop_brand')->select();
    }
    //添加品牌
    public static function addBrand($data){
       return self::table('shop_brand')->insert($data);
    }
}