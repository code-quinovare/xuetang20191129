<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;

//数据库链接
use think\Db;


class Admin extends  Controller
{
    public function editor()
    {
        $this->fetch();
    }
}