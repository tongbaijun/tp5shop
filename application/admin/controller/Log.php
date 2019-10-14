<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

class Log extends Common
{
    public function log_show()
    {
        $log=\app\admin\model\Log::getAllLog();
        $count=\app\admin\model\Log::getLogCount();
        $page_sum=ceil($count/2);
        return view('',['log'=>$log,'page_sum'=>$page_sum]);
    }
}
