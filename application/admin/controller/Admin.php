<?php
namespace app\admin\controller;

use think\Request;
use think\Controller;
use think\Db;
use Ueditor;
class Admin extends Controller
{
    public function admin()
    {
        
    }
    //
    public function editor()
    {
        return $this->fetch();
    }
    public function data()
    {

        //$arr = $_POST;
        //$str1 =  implode(' ',$arr);;
        var_dump($_POST);
        //var_dump($str1);
    }
}