<?php
namespace app\index\controller;

use think\Controller;
use Util\data\Sysdb;
class Index extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->db=new Sysdb();
    }

    public function index()
    {
        //幻灯片
        $lists=$this->db->table('slide')->where(['type'=>0])->order('id desc')->lists();
        //频道标签
        $channel=$this->db->table('video_label')->where(['flag'=>'channel'])->order('sort asc')->pages(9);
        //地区标签
        $area=$this->db->table('video_label')->where(['flag'=>'area'])->order('sort asc')->pages(9);
        //资费标签
        $charge=$this->db->table('video_label')->where(['flag'=>'charge'])->order('sort asc')->pages(9);
        //综艺影片
        $channel_video=$this->db->table('video')->where(['channel_id'=>'3','status'=>1])->pages(9);
        $this->assign('data',$lists);
        $this->assign('channel_video',$channel_video['lists']);
        $this->assign('channel',$channel['lists']);
        $this->assign('area',$area['lists']);
        $this->assign('charge',$charge['lists']);
        return $this->fetch();
    }
    public function cate(){
        //频道标签
        $data['label_channel']=(int)input('get.label_channel');
        $data['label_charge']=(int)input('get.label_charge');
        $data['label_area']=(int)input('get.label_area');
        $channel=$this->db->table('video_label')->where(['flag'=>'channel'])->order('sort asc')->cates('id');
        $charge=$this->db->table('video_label')->where(['flag'=>'charge'])->order('sort asc')->cates('id');
        $area=$this->db->table('video_label')->where(['flag'=>'area'])->order('sort asc')->cates('id');
        $data['pageSize']=2;
        $data['page']=max(1,(int)input('get.page'));
        $where['status']=1;
        if($data['label_channel']){
            $where['channel_id']=$data['label_channel'];
        }if($data['label_charge']){
            $where['charge_id']=$data['label_charge'];
        }if($data['label_area']){
            $where['area_id']=$data['label_area'];
        }

        $data['list']=$this->db->table('video')->where($where)->pages($data['pageSize']);
        $this->assign('channel',$channel);
        $this->assign('channel',$channel);
        $this->assign('charge',$charge);
        $this->assign('video',$data);
        $this->assign('area',$area);
        return $this->fetch();
    }

    public function video(){
        $id=(int)input('get.id');
        $video_one=$this->db->table('video')->where(['id'=>$id])->item();
        $this->assign('video_one',$video_one);
        return $this->fetch();
    }
}
