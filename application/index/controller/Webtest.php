<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\Request;
use think\Config;
class Webtest extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}