<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\Request;
use think\Config;
class Jkst extends Controller
{
    /*
     * 健康食糖
     *
     */
    public function index()
    {
        return $this->fetch();
    }
}