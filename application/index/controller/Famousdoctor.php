<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\Request;
use think\Config;
class FamousDoctor extends Controller
{
    /*
     * 所有医生
     */
    public function index()
    {
        $doctors = Db::name('doctor')->where('status',1)->order('order','DESC')->select();
        if(!empty($doctors)){
            $this->assign('doctors', $doctors);
        }

       return $this->fetch('alldoctor');
    }
    /*
     * 名医详情
     */
    public function doctorContent()
    {
        if(!empty($_GET['doctor_id'])){
            $doc_id = $_GET['doctor_id'];
            $data_doc = Db::name('doctor')->where('id',$doc_id)->select();
            if(!empty($data_doc)){
                $this->assign('data_doc', $data_doc[0]);
            }
            $data_v = Db::field('doctor.img_int,videos.id,videos.img,videos.title,videos.author,videos.pageviews,videos.type')
                ->name('doctor,videos')
                ->where('doctor.id',$doc_id)->where('doctor.id = videos.doctor_id')->where('videos.status',1)->order('videos.add_time','DESC')->select();
            $this->assign('data_v', $data_v);
            return $this->fetch();
        }
    }
}