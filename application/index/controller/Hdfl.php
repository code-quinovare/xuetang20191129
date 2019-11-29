<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\Request;
use think\Config;
class Hdfl extends Controller
{
    public function index()
    {
        //获取用户openid
        $hdflCon = controller('Index');
        $hdflCon->hdflUserinfo();

    }
    public function getOpenid()
    {
        if (!empty($_GET['open_id'])){
            $open_id = $_GET['open_id'];
           /* $aa = Db::connect('db2')->field('ims_mc_members.credit1')
                ->table('ims_mc_members,ims_ewei_shop_member')
                ->where('ims_mc_members.uid = ims_ewei_shop_member.uid')
                ->where('ims_ewei_shop_member.openid',$open_id)
                ->select();
            var_dump($aa);*/
            $aa = Db::connect('db2')->field('uid')
                ->table('ims_ewei_shop_member')
                ->where('openid',$open_id)
                ->select();
            if(!empty($aa[0]['uid'])){
                $uid = $aa[0]['uid'];
                $jifen =  Db::connect('db2')->field('credit1')
                    ->table('ims_mc_members')
                    ->where('uid',$uid)
                    ->select();
                $credit = floatval($jifen[0]['credit1']);
                if (!empty($credit)){
                    $this->assign('credit', $credit);
                }
            }
            return $this->fetch('index');
        }
    }
}