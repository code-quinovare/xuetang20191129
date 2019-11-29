<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\Request;
use think\Config;
class Zskt extends Controller
{
    /*
     * 注射控糖
     *
     */
    public function index()
    {
        return $this->fetch();
    }
}