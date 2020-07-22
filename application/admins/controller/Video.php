<?php
/**
 * 影片管理
 * User: LHP
 * Date: 2020/7/8
 * Time: 16:10
 */

namespace app\admins\controller;


class Video extends BaseAdmin
{
    //影片列表
    public function index(){
        $where=[];
        $data['wd']=trim(input('get.wd'));
        $data['wd'] && $where=' title like "%'.$data['wd'] .'%"';
        $data['pagesize']=15;
        $data['page']=max(1,(int)input('get.page'));
        $data['lists']=$this->db->table('video')->where($where)->order('id desc')->pages($data['pagesize']);
        $label_ids=[];
        foreach($data['lists']['lists'] as $k=>$v){
            !in_array($v['channel_id'],$label_ids) && $label_ids[]=$v['channel_id'];
            !in_array($v['charge_id'],$label_ids) && $label_ids[]=$v['charge_id'];
            !in_array($v['area_id'],$label_ids) && $label_ids[]=$v['area_id'];
        }
        $label_ids && $data['label']=$this->db->table('video_label')->where('id in ('.implode(',',$label_ids).')')->cates('id');
        $this->assign('data',$data);
       return  $this->fetch();
    }
    //添加影片
    public function add(){
        $id=(int)input('get.id');
        $data['item']=$this->db->table('video')->where(['id'=>$id])->item();
        $data['channel']=$this->db->table('video_label')->where(['flag'=>'channel'])->lists();
        $data['charge']=$this->db->table('video_label')->where(['flag'=>'charge'])->lists();
        $data['area']=$this->db->table('video_label')->where(['flag'=>'area'])->lists();
        $this->assign('data',$data);
        return $this->fetch();
    }
    //图片上传
    public function upload_img(){
        $file=request()->file('file');
        if($file==null){
            exit(json_encode(['code'=>1,'msg'=>'没有上传文件']));
        }
        $info=$file->move(ROOT_PATH.'public'.DS.'uploads');
        $ext=$info->getExtension();
        if(!in_array($ext,['jpg','jpeg','gif','png'])){
            exit(json_encode(['code'=>1,'msg'=>'文件格式不支持']));
        }
        $img='/uploads/'.$info->getSaveName();
        exit(json_encode(['code'=>0,'msg'=>$img]));
    }
    /*影片保存*/
    public function save(){
        $id=(int)input('post.id');
        $data['title']=trim(input('post.title'));
        $data['channel_id']=(int)input('post.channel_id');
        $data['charge_id']=(int)input('post.charge_id');
        $data['area_id']=(int)input('post.area_id');
        $data['img']=trim(input('post.img'));
        $data['url']=trim(input('post.url'));
        $data['keyword']=trim(input('post.keyword'));
        $data['desc']=trim(input('post.desc'));
        $data['status']=(int)input('post.status');
        if(!$data['title']){
            exit(json_encode(['code'=>1,'msg'=>'影片名称不能为空']));
        }if(!$data['url']){
            exit(json_encode(['code'=>1,'msg'=>'影片地址不能为空']));
        }
        $res=true;//确保不做什么操作显示保存成功
        if($id==0){
            $data['add_time']=time();
            //保存数据
            $res=$this->db->table('video')->insert($data);
        }else{
            $this->db->table('video')->where(['id'=>$id])->update($data);
        }
        if(!$res){
            exit(json_encode(['code'=>1,'msg'=>'保存失败']));
        }
        exit(json_encode(['code'=>0,'msg'=>'保存成功']));
    }
    //删除影片
    public function delete(){
        $id=(int)input('post.id');
        $res=$this->db->table('video')->where(['id'=>$id])->delete();
        if(!$res){
            exit(json_encode(['code'=>1,'msg'=>'删除失败']));
        }
        exit(json_encode(['code'=>0,'msg'=>'删除成功']));
    }
}