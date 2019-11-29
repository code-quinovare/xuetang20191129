<?php
namespace app\index\controller;
use think\Db;
use think\Session;
use think\Controller;
use think\Request;
use think\Config;
class Index extends Controller
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
    }
    /*
     * 获取用户信息
     * 注意url更换
     * state = location跳转
     * */
    public function getUserinfo($state = 1,$type,$video_id)
    {
        $appid='wx4551d99c128182f4';
        //$redirect_uri = urlencode ( 'http://xt.quinnovare.cn/getuserinfo.php' );//将字符串以 URL 编码。
        $redirect_uri = urlencode ( 'http://xt.quinnovare.cn/index/wechat' );//将字符串以 URL 编码。
        $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=".$state.','.$type.','.$video_id."#wechat_redirect";
        header("Location:".$url);//header() 函数向客户端发送原始的 HTTP 报头。
    }
    /*
     * 搜索-获取用户信息
     * 注意url更换
     * state = location跳转
     * */
    public function searchUserinfo()
    {
        $appid='wx4551d99c128182f4';
        //$redirect_uri = urlencode ( 'http://xt.quinnovare.cn/getuserinfo.php' );//将字符串以 URL 编码。
        $redirect_uri = urlencode ( 'http://xt.quinnovare.cn/index/wechat' );//将字符串以 URL 编码。
        $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=search"."#wechat_redirect";
        header("Location:".$url);//header() 函数向客户端发送原始的 HTTP 报头。
    }
    /*
    * 互动福利-获取用户信息
    * 注意url更换
    * state = location跳转
    * */
    public function hdflUserinfo()
    {
        $appid='wx4551d99c128182f4';
        //$redirect_uri = urlencode ( 'http://xt.quinnovare.cn/getuserinfo.php' );//将字符串以 URL 编码。
        $redirect_uri = urlencode ( 'http://xt.quinnovare.cn/index/wechat' );//将字符串以 URL 编码。
        $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=hdfl"."#wechat_redirect";
        header("Location:".$url);//header() 函数向客户端发送原始的 HTTP 报头。
    }
    /*
   * 互动福利(Test)-获取用户信息
   * 注意url更换
   * state = location跳转
   * */
    public function hdfltestUserinfo()
    {
        $appid='wx4551d99c128182f4';
        //$redirect_uri = urlencode ( 'http://xt.quinnovare.cn/getuserinfo.php' );
        $redirect_uri = urlencode ( 'http://xt.quinnovare.cn/index/wechat' );//将字符串以 URL 编码。
        $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=hdfltest"."#wechat_redirect";
        header("Location:".$url);//header() 函数向客户端发送原始的 HTTP 报头。
    }
    //get请求
    public static function get($url)
    {
        //1 初始curl
        $ch = curl_init($url);
        //2 设置参数
        //是否返回数据
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);//是否显示请求头
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);//请求超时时间
        //3执行
        $content = curl_exec($ch);
        //4 关闭
        curl_close($ch);
        return $content;
    }
    /*
     *名医讲糖-视频内容详情-请求用户信息
     * 参数：userinfo（固定）url跳转、video_id视频id
     */
    public function videoUserinfo($v=null,$t=null)
    {
        //用户从别人转发的入口打开
        if (!empty($v) && !empty($t)){
            $this->getUserinfo('userinfo',$t,$v);
        }
        if (!empty($_GET['video_id'])){
            $video_id = $_GET['video_id'];
            $type = $_GET['type'];
            $this->getUserinfo('userinfo',$type,$video_id);
        }else{
            echo '文章不存在';die;
        }
    }
    /*
     *注射控糖-视频内容详情-请求用户信息
     * 参数：userinfo（固定）url跳转、video_id视频id
     */
    public function zsktUserinfo($v=null,$t=null)
    {
        //用户从别人转发的入口打开
        if (!empty($v) && !empty($t)){
            $this->getUserinfo('userinfo_zskt',$t,$v);
        }
        if (!empty($_GET['video_id'])){
            $video_id = $_GET['video_id'];
            $type = $_GET['type'];
            $this->getUserinfo('userinfo_zskt',$type,$video_id);
        }else{
            echo '文章不存在';die;
        }
    }
    /*
     * 注射控糖-文章/视频内容详情
     */
    public function zsktContent()
    {
        //获取用户微信资料
        if(!empty($_GET)){
            //如果是从微信用户转发打开的
            if(!empty($_GET['from'])){
                $v = $_GET['video_id'];
                $t = $_GET['type'];
                $this->zsktUserinfo($v,$t);
            }else{
                $userinfo = $_GET;
                $openid = $userinfo['open_id'];
                $check_openid = Db::name('user')->where('open_id',$openid)->field('id')->select();
                if(!$check_openid){
                    $data['open_id'] = $userinfo['open_id'];
                    $data['nickname'] = $userinfo['nickname'];
                    $data['sex'] = $userinfo['sex'];
                    $data['headimg'] = $userinfo['headimgurl'];
                    $data['status'] = 1;
                    $data['time'] = time();
                    $data['updatetime'] = 0;
                    //添加到数据库
                    Db::name('user')->insert($data);
                }else{  //更新头像
                    $headimg = $userinfo['headimgurl'];
                    Db::table('user')->where('open_id', $openid)->update(['headimg' => $headimg,'updatetime' => time()]);
                }
                if(!empty($_GET['video_id'])){
                    if ($_GET['type'] == 'video'){      //视频内容
                        $video_id = $_GET['video_id'];
                        //获取视频详情
                        $data_video = Db::name('videos_zskt')->where('id',$video_id)->select();
                        //浏览量
                        $shownum = $data_video[0]['pageviews'];
                        $shownum += 1;
                        Db::table('videos_zskt')->where('id', $video_id)->update(['pageviews' => $shownum]);
                        //查询评论
                        $comments = Db::field('user.headimg,user.nickname,comment_zskt.comment,comment_zskt.add_time')
                            ->name('user,comment_zskt')
                            ->where('user.id = comment_zskt.user_id')->where('comment_zskt.video_id',$video_id)->order('comment_zskt.add_time','DESC')->select();
                        $this->assign('data_video', $data_video[0]);
                        $this->assign('comments', $comments);
                        return $this->fetch('zskt_content');
                    }else{      //图文文章 $_GET['type'] == 'article'
                        $video_id = $_GET['video_id'];
                        //获取图文详情
                        $data_video = Db::name('videos_zskt')->where('id',$video_id)->select();
                        //浏览量
                        $shownum = $data_video[0]['pageviews'];
                        $shownum += 1;
                        Db::table('videos_zskt')->where('id', $video_id)->update(['pageviews' => $shownum]);
                        $this->assign('data_video', $data_video[0]);
                        return $this->fetch('my_article');
                    }
                } else{
                    echo '未找到该文章';
                }
            }
        }
    }
    /*
     * 名医讲糖-视频内容详情
     */
    public function videoContent()
    {
        //获取用户微信资料
        if(!empty($_GET)){
            //如果是从微信用户转发打开的
            if(!empty($_GET['from'])){
                $v = $_GET['video_id'];
                $t = $_GET['type'];
                $this->videoUserinfo($v,$t);
            }else{
                $userinfo = $_GET;
                $openid = $userinfo['open_id'];
                //openid存session
                Session::set('open_id',"$openid");
                $check_openid = Db::name('user')->where('open_id',$openid)->field('id')->select();
                if(!$check_openid){
                    $data['open_id'] = $userinfo['open_id'];
                    $data['nickname'] = $userinfo['nickname'];
                    $data['sex'] = $userinfo['sex'];
                    $data['headimg'] = $userinfo['headimgurl'];
                    $data['status'] = 1;
                    $data['time'] = time();
                    $data['updatetime'] = 0;
                    //添加到数据库
                    Db::name('user')->insert($data);
                }else{  //更新头像
                    $headimg = $userinfo['headimgurl'];
                    Db::table('user')->where('open_id', $openid)->update(['headimg' => $headimg,'updatetime' => time()]);
                }
                if(!empty($_GET['video_id'])){
                    if ($_GET['type'] == 'video'){      //视频内容
                        $video_id = $_GET['video_id'];
                        //获取视频详情
                        $data_video = Db::name('videos')->where('id',$video_id)->select();
                        //浏览量
                        $shownum = $data_video[0]['pageviews'];
                        $shownum += 1;
                        Db::table('videos')->where('id', $video_id)->update(['pageviews' => $shownum]);
                        //查询评论
                        $comments = Db::field('user.headimg,user.nickname,comments.comment,comments.add_time')
                            ->name('user,comments')
                            ->where('user.id = comments.user_id')->where('comments.video_id',$video_id)->where('comments.status',1)->order('comments.add_time','DESC')->select();
                        $this->assign('data_video', $data_video[0]);
                        $this->assign('comments', $comments);
                        return $this->fetch();
                    }else{      //图文文章 $_GET['type'] == 'article'
                        return $this->fetch('my_article');
                    }
                } else{
                    echo '未找到该文章';
                }
            }

        }
    }
    /*
     * 名医讲糖
     */
    public function famousDoctor()
    {
        //分类
        $classify_max = Db::name('class_doctor')->order('order','DESC')->select();
        if(!empty($classify_max)) {
            $this->assign('classify_max', $classify_max);
        }
        //ajax获取分类
        if ($this->request->isAjax()){  //判断是否ajax请求
            if(!empty($_POST['classid'])){
                $class_id = $_POST['classid'];
                $classify_min = Db::name('cd_info')->where('cd_id',"$class_id")->order('order','DESC')->select();
                return $classify_min;
            }
        }
        //默认展示第一分类
        $classify_min_base = Db::name('cd_info')->where('cd_id',1)->order('order','DESC')->select();
        if(!empty($classify_min_base)){
            $this->assign('classify_min_base', $classify_min_base);
        }
        //默认展示第一标签
        $type3 = Db::name('tags_doctor')->where('cd_id',1)->order('order','DESC')->select();
        if(!empty($type3)){
            $this->assign('type3', $type3);
        }
        //
        $data_v = Db::field('videos.id,videos.img,videos.title,videos.author,videos.pageviews,videos.type')
            ->name('videos,class_doctor')
            ->where('videos.class_id = class_doctor.id')->where('class_doctor.id',1)->order('videos.add_time','DESC')->select();
        $total = Db::name('videos,class_doctor')
            ->where('videos.class_id = class_doctor.id')->where('class_doctor.id',1)->order('videos.add_time','DESC')->select();
        if(!empty($data_v)){
            $this->assign('data_v', $data_v);
            $this->assign('total', $total);
        }
        //用户信息处理
        return $this->fetch('famousDoctor');
    }
    public function famousClass()
    {
        if ($this->request->isAjax()) {  //判断是否ajax请求

            if(!empty($_POST['max_id']) && !empty($_POST['min_id'])){
                $class_id = $_POST['max_id'];
                $classinfo_id = $_POST['min_id'];
                $data_ajax = Db::field('id,img,title,author,pageviews,type')
                    ->name('videos')
                    ->where('class_id',$class_id)->where('classinfo_id',$classinfo_id)->where('status',1)->order('add_time','DESC')->select();
                if(!empty($data_ajax)){
                    return $data_ajax;
                }else{
                    return false;
                }
            }
            //全部
            if(!empty($_POST['classid'])){
                $class_id = $_POST['classid'];
                $data_ajax = Db::field('id,img,title,author,pageviews,type')
                    ->name('videos')
                    ->where('class_id',$class_id)->where('status',1)->order('add_time','DESC')->select();
                if(!empty($data_ajax)){
                    return $data_ajax;
                }else{
                    return false;
                }
            }
            //
            if(!empty($_POST['min_id'])){
                $classinfo_id = $_POST['min_id'];
                $data_ajax = Db::field('id,img,title,author,pageviews,type')
                    ->name('videos')
                    ->where('class_id',1)->where('classinfo_id',$classinfo_id)->where('status',1)->order('add_time','DESC')->select();
                if(!empty($data_ajax)){
                    return $data_ajax;
                }else{
                    return false;
                }
            }
        }
    }
    /*
     * ajax获取标签-热门、硬结等
     */
    public function famousTags()
    {
        if ($this->request->isAjax()) {  //判断是否ajax请求
            if(!empty($_POST['classid'])) {
                $class_id = $_POST['classid'];
                $type3 = Db::name('tags_doctor')->where('cd_id',"$class_id")->order('order','DESC')->select();
                return $type3;
            }
            if(!empty($_POST['tag_id']) && !empty($_POST['cid_id'])){
                $class_id = $_POST['cid_id'];
                $classinfo_id = $_POST['tag_id'];
                $data_ajax = Db::field('id,img,title,author,pageviews,type')
                    ->name('videos')
                    ->where('class_id',$class_id)->where('tag_id',$classinfo_id)->where('status',1)->order('add_time','DESC')->select();
                if(!empty($data_ajax)){
                    return $data_ajax;
                }else{
                    return false;
                }
            }
        }
    }
    public function famousTags_page()
    {
        if ($this->request->isAjax()) {  //判断是否ajax请求
            //page
            $start = $_POST['start'];
            //$class_id = $_POST['cid_id'];
            $class_id = 1;
            $classinfo_id = 1;
            //$classinfo_id = $_POST['tag_id'];
            $data_ajax = Db::field('id,img,title,author,pageviews,type')
                ->name('videos')
                ->where('class_id', $class_id)->where('tag_id', $classinfo_id)->where('status', 1)
                ->limit($start-5,$start)
                ->order('add_time', 'DESC')->select();
            if (!empty($data_ajax)) {
                return $data_ajax;
                //return (array( 'result'=>$data_ajax,'status'=>1, 'msg'=>'获取成功！'));
            } else {
                return false;
            }
        }
    }
    //test
    public function test()
    {
        if ($this->request->isAjax()) {
            var_dump($_POST);
        }
    }
  /*
   * 注射控糖-首页
   *
   */
    public function zskt()
    {
        //分类
        $classify_max = Db::name('class_zskt')->order('order','DESC')->select();
        $this->assign('classify_max', $classify_max);
        //ajax获取分类
        if ($this->request->isAjax()){  //判断是否ajax请求
            if(!empty($_POST['classid'])){
                $class_id = $_POST['classid'];
                $classify_min = Db::name('cz_info')->where('cz_id',"$class_id")->order('order','DESC')->select();
                return $classify_min;
            }
        }
        //默认展示第一分类
        $classify_min_base = Db::name('cz_info')->where('cz_id',1)->order('order','DESC')->select();
        $this->assign('classify_min_base', $classify_min_base);
        //第一分类的所有文章
        $data_v = Db::field('videos_zskt.id,videos_zskt.img,videos_zskt.title,videos_zskt.author,videos_zskt.pageviews,videos_zskt.type')
            ->name('videos_zskt,class_zskt')
            ->where('videos_zskt.class_id = class_zskt.id')->where('class_zskt.id',1)->order('videos_zskt.add_time','DESC')->select();
        if(!empty($data_v)){
            $this->assign('data_v', $data_v);
        }
        //轮播图
        $data_lbt =  Db::field('videos_zskt.id,videos_zskt.img,videos_zskt.title,videos_zskt.author,videos_zskt.pageviews,videos_zskt.type')
            ->name('videos_zskt,tags_zskt')
            ->where('videos_zskt.tag_id = tags_zskt.video_id')->where('tags_zskt.status',1)->order('videos_zskt.add_time','DESC')->select();
        if(!empty($data_lbt)){
            $this->assign('data_lbt', $data_lbt);
        }
        return $this->fetch();
    }
    /*
     * 注射控糖ajax请求分类
     */
    public function zsktClass()
    {
        if ($this->request->isAjax()) {  //判断是否ajax请求
            if(!empty($_POST['max_id']) && !empty($_POST['min_id'])){
                $class_id = $_POST['max_id'];
                $classinfo_id = $_POST['min_id'];
                $data_ajax = Db::field('id,img,title,author,pageviews,type')
                    ->name('videos_zskt')
                    ->where('class_id',$class_id)->where('czinfo_id',$classinfo_id)->where('status',1)->order('add_time','DESC')->select();
                if(!empty($data_ajax)){
                    return $data_ajax;
                }else{
                    return false;
                }
            }
            //全部
            if(!empty($_POST['classid'])){
                $class_id = $_POST['classid'];
                $data_ajax = Db::field('id,img,title,author,pageviews,type')
                    ->name('videos_zskt')
                    ->where('class_id',$class_id)
                    ->where('status',1)->order('add_time','DESC')->select();
                if(!empty($data_ajax)){
                    return $data_ajax;
                }else{
                    return false;
                }
            }
        }
    }
    /*
     * 名医讲糖评论
     */
    public function submit_comment()
    {

        if(!empty(Session::get('open_id'))){
            if ($this->request->isAjax()) {  //判断是否ajax请求
                if (!empty($_POST['content'])) {
                    $open_id = Session::get('open_id');
                    $user_id = Db::field('id')->name('user')->where('open_id', $open_id)->select();
                    $user_id = $user_id[0]['id'];
                    $data['user_id'] = $user_id;
                    $data['comment'] = $_POST['content'];
                    $data['status'] = 2;
                    $data['add_time'] = time();
                    $data['video_id'] = $_POST['video_id'];
                    Db::table('comments')->insert($data);
                }
            }
        }else{
            echo '未知错误';
        }
    }
    /*
     * 注射控糖评论
     */
    public function submit_zskt()
    {

        if(!empty(Session::get('open_id'))){
            if(!empty($_POST['content'])){
                $open_id = Session::get('open_id');
                $user_id = Db::field('id')->name('user')->where('open_id',$open_id)->select();
                $user_id = $user_id[0]['id'];
                $data['user_id'] = $user_id;
                $data['comment'] = $_POST['content'];
                $data['status'] = 2;
                $data['add_time'] = time();
                $data['video_id'] = $_POST['video_id'];
                $insert = Db::table('comment_zskt')->insert($data);
                if ($insert){
                    echo "<script> alert('评论成功，待管理员审核后显示！');self.location=document.referrer; </script>";
                }else{
                    echo "<script> alert('评论失败！');window.history.back(-1); </script>";
                }

            }else{
                echo "<script> alert('请输入评论！');window.history.back(-1); </script>";
            }
        }else{
            echo '未知错误';
        }
    }

}
