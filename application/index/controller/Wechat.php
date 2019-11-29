<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\Request;
use think\Config;
const BASE_URL = 'http://xt.quinnovare.cn/';
class Wechat extends Controller
{
    public function index()
    {
        header("content-type:text/html;charset=utf-8");
        $code = $_GET["code"];//预定义的 $_GET 变量用于收集来自 method="get" 的表单中的值。

        if (isset($_GET['code']) && isset($_GET['state'])){//判断code是否存在
            //获取用户信息
            $userinfo = $this->getUserInfo($code);
            //openid
            $openid = $userinfo['openid'];
            //昵称
            $nickname = $userinfo['nickname'];
            //sex
            $sex = $userinfo['sex'];
            //头像
            $headimg = $userinfo['headimgurl'];
            //url跳转
            $state = $_GET['state'];
            //其他参数-获取state及video_id
            if ($state != 'search' && $state != 'hdfl' && $state != 'hdfltest'){
                $pizza = $_GET['state'];
                $pieces = explode(",", $pizza);
                $state = $pieces[0];
                $type = $pieces[1];
                $video_id = $pieces[2];
            }

            switch ($state) {
                case 'userinfo':
                    header('Location:' . BASE_URL . 'index/index/videoContent?open_id=' . $openid.'&nickname='.$nickname.'&sex='.$sex.'&headimgurl='.$headimg.'&type='.$type.'&video_id='.$video_id);
                    break;
                case 'userinfo_zskt':
                    header('Location:' . BASE_URL . 'index/index/zsktContent?open_id=' . $openid.'&nickname='.$nickname.'&sex='.$sex.'&headimgurl='.$headimg.'&type='.$type.'&video_id='.$video_id);
                    break;
                case 'search':
                    header('Location:' . BASE_URL . 'index/search/getOpenid?open_id=' . $openid);
                    break;
                case 'hdfl':
                    header('Location:' . BASE_URL . 'index/hdfl/getOpenid?open_id=' . $openid);
                    break;
                case 'hdfltest':
                    header('Location:' . BASE_URL . 'index/hdfltest/getOpenid?open_id=' . $openid);
                    break;
                case 'videos':
                    header('Location:' . BASE_URL . 'videos?open_id=');
                    break;
            }

        }else{
            echo "NO CODE";
        }
    }
    public function getUserInfo($code)
    {
        $appid = "wx4551d99c128182f4";
        $appsecret = "6abe7f84dd863b437c6ade0eccd9e4c4";

        //Get access_token
        $access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
        $access_token_json = $this->https_request($access_token_url);//自定义函数
        $access_token_array = json_decode($access_token_json,true);//对 JSON 格式的字符串进行解码，转换为 PHP 变量，自带函数
        //获取access_token
        $access_token = $access_token_array['access_token'];//获取access_token对应的值
       /* $ex_time = Db::name('wechat_access_token')->field('access_token','expires_in')->select();
        if($ex_time > date('Y-m-d H:i:s',time())){

        }
        //var_dump($ex_time);
        var_dump($access_token_array);
        //var_dump($access_token);
        die;*/
        //获取openid
        $openid = $access_token_array['openid'];//获取openid对应的值
        //Get user info
        $userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid";
        $userinfo_json = $this->https_request($userinfo_url);
        $userinfo_array = json_decode($userinfo_json,true);
        return $userinfo_array;
    }

    public function https_request($url)//自定义函数,访问url返回结果
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl,  CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)){
            return 'ERROR'.curl_error($curl);
        }
        curl_close($curl);
        return $data;
    }
}