<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\Request;
use think\Config;
use org\wechat\Jssdk;
class Wechatconf extends Controller
{
    //jssdk分享功能封装
    public function share()
    {
        $jssdkObj = new Jssdk(Config::get('WEIXINAPPID'),Config::get('WEIXINAPPSECRET'));
        $res = $jssdkObj->getSignPackage();
        $appId = $res['appId'];
        $timestamp = $res['timestamp'];
        $nonceStr = $res['nonceStr'];
        $signature = $res['signature'];
        $this->assign(
            array(
                'appId' => $appId,
                'timestamp' => $timestamp,
                'nonceStr'  => $nonceStr,
                'signature' => $signature,
            )
        );
        return $this ->fetch('famousDoctor');
    }


}