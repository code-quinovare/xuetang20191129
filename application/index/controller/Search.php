<?php
namespace app\index\controller;
use think\Db;
use think\Cookie;
use think\Session;
use think\Controller;
use think\Request;
use think\Config;

class Search extends Controller
{
    /*
     * 搜索界面
     */
    public function index()
    {
        //获取用户openid
        $searchCon = controller('Index');
        $searchCon->searchUserinfo();
    }
    /*
     * 获取用户openid
     */
    public function getOpenid()
    {
        if (!empty($_GET['open_id'])){
            $open_id = $_GET['open_id'];
            Session::set('open_id',$open_id);
            //查询历史记录
            $data_his = Db::table('search_his')->where('open_id',$open_id)->where('status',1)->order('add_time','DESC')->limit(10)->select();
            if($data_his){
                $this->assign('data_his', $data_his);
            }
        }
        return $this->fetch('/index/search');
    }
    /*
     * 清空搜索历史
     */
    public function cleanHistory()
    {
        $open_id = Session::get('open_id');
        Db::table('search_his')->where('open_id',$open_id)->update(['status' => 2]);
        $this->index();
    }
    /*
     * ajax搜索回显-搜索内容
     * Gaoxianghua
     * 2019-07-31
     */
    public function get_search()
    {
        if ($this->request->isAjax()) {  //判断是否ajax请求
            if(!empty($_POST['content'])){
                $content = $_POST['content'];
                $re_myjt = Db::table('videos')->field('title')
                    ->where('title','like','%'.$content.'%')
                    ->where('status',1)
                    ->order('pageviews','DESC')
                    ->select();
                $re_zskt = Db::table('videos_zskt')->field('title')
                    ->where('title','like','%'.$content.'%')
                    ->where('status',1)
                    ->order('pageviews','DESC')
                    ->select();
                $re = array_merge_recursive($re_myjt,$re_zskt);
                if(!empty($re)){
                    return $this->m_ArrayUnique($re);
                }
            }
        }
    }
    //去除数组重复字段方法
    public function m_ArrayUnique($arr, $reserveKey = false)
    {
        if (is_array($arr) && !empty($arr))
        {
            foreach ($arr as $key => $value)
            {
                $tmpArr[$key] = serialize($value) . '';
            }
            $tmpArr = array_unique($tmpArr);
            $arr = array();
            foreach ($tmpArr as $key => $value)
            {
                if ($reserveKey)
                {
                    $arr[$key] = unserialize($value);
                }
                else
                {
                    $arr[] = unserialize($value);
                }
            }
        }
        return $arr;
    }
    /*
     * ajax搜索回显-搜索名医
     * Gaoxianghua
     * 2019-07-31
     */
    public function get_doctor()
    {
        if ($this->request->isAjax()) {  //判断是否ajax请求
            if(!empty($_POST['content'])){
                $content = $_POST['content'];
                $re = Db::table('doctor')->field('id,name,img,int')
                    ->where('name','like','%'.$content.'%')
                    ->where('status',1)
                    ->select();
                if(!empty($re)){
                    return $re;
                }
            }
        }
    }
    /*
     * 搜索-关键词
     */
    public function searchKey()
    {
        //用户历史搜索
        if (!empty($_GET['kwid'])){
            $kid = $_GET['kwid'];
            $kw = Db::table('search_his')->field('keyword')->where('id',$kid)->select();
            $kws = $kw[0]['keyword'];
            $url = Config("base_url") .'index/search/searchKey?keyword='.$kws;
            echo "<script type='text/javascript'> location.href='$url'; </script>";
        }
        if(!empty($_GET['keyword'])){
            $content = $_GET['keyword'];
            if(!empty(Session::get('open_id'))){
                $open_id = Session::get('open_id');
                $check = Db::table('search_his')->field('id')->where('open_id',$open_id)->where('keyword',$content)->select();
                if(!$check){
                    $data_search['open_id'] = $open_id;
                    $data_search['keyword'] = $content;
                    $data_search['status'] = 1;
                    $data_search['add_time'] = time();
                    Db::name('search_his')->insert($data_search);
                }else{  //更新搜索字段时间
                    Db::table('search_his')->where('open_id',$open_id)->where('keyword',$content)->update(['add_time' => time()]);
                }
            }
            //名医
            $re_doc = Db::table('doctor')->field('id,name,img,int')
                ->where('name','like','%'.$content.'%')
                ->where('status',1)
                ->select();
            if(!empty($re_doc)){
                $this->assign('re_doc', $re_doc);
            }
            //名医讲糖
            $re_myjt = Db::table('videos')->field('id,title,author,img,pageviews,type')
                ->where('title','like','%'.$content.'%')
                ->where('status',1)
                ->order('pageviews','DESC')
                ->select();
            if(!empty($re_myjt)){
                $this->assign('re_myjt', $re_myjt);
            }
            $re_zskt = Db::table('videos_zskt')->field('id,title,author,img,pageviews,type')
                ->where('title','like','%'.$content.'%')
                ->where('status',1)
                ->order('pageviews','DESC')
                ->select();
            if(!empty($re_zskt)){
                $this->assign('re_zskt', $re_zskt);
            }
            $this->assign('keyword', $content);
            return $this->fetch('/index/search_keyword');
        }
    }
}