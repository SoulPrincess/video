<?php
/**
 * 幻灯片
 * User: Lhp
 * Date: 2020/7/9
 * Time: 11:00
 */

namespace app\admins\controller;


class Slide extends BaseAdmin
{
    //首页视频
    public function index(){
        $data['lists']=$this->db->table('slide')->where(['type'=>0])->order('id desc')->lists();
        $this->assign('data',$data);
        return $this->fetch();
    }
    //添加幻灯片
    public function add_first(){
        $id=(int)input('get.id');
        $data['item']=$this->db->table('slide')->where(['id'=>$id])->item();
        $this->assign('data',$data);
        return $this->fetch();
    }
    //幻灯片保存
    public function save(){
        $id=(int)input('post.id');
        $data['title']=trim(input('post.title'));
        $data['sort']=(int)input('post.sort');
        $data['type']=(int)input('post.type');
        $data['img']=trim(input('post.img'));
        $data['url']=trim(input('post.url'));
        if(!$data['title']){
            exit(json_encode(['code'=>1,'msg'=>'幻灯片名称不能为空']));
        }if(!$data['url']){
            exit(json_encode(['code'=>1,'msg'=>'幻灯片地址不能为空']));
        }
        $res=true;//确保不做什么操作显示保存成功
        if($id==0){
            $res=$this->db->table('slide')->insert($data);
        }else{
            $this->db->table('slide')->where(['id'=>$id])->update($data);
        }
        if(!$res){
            exit(json_encode(['code'=>1,'msg'=>'保存失败']));
        }
        exit(json_encode(['code'=>0,'msg'=>'保存成功']));
    }
    //删除幻灯片
    public function delete(){
        $id=(int)input('post.id');
        $res=$this->db->table('slide')->where(['id'=>$id])->delete();
        if(!$res){
            exit(json_encode(['code'=>1,'msg'=>'删除失败']));
        }
        exit(json_encode(['code'=>0,'msg'=>'删除成功']));
    }
}