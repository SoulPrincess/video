<?php
/**
 * 标签管理.
 * User: LHP
 * Date: 2020/7/8
 * Time: 15:37
 */

namespace app\admins\controller;


class Label extends BaseAdmin
{
    //频道管理
    public function channel(){
        $data['lists']=$this->db->table('video_label')->where(['flag'=>'channel'])->lists();
        $this->assign('data',$data);
        return $this->fetch();
    }
    //资费管理
    public function charge(){
        $data['lists']=$this->db->table('video_label')->where(['flag'=>'charge'])->lists();
        $this->assign('data',$data);
       return $this->fetch();
    }
    //地区管理
    public function area(){
        $data['lists']=$this->db->table('video_label')->where(['flag'=>'area'])->lists();
        $this->assign('data',$data);
        return $this->fetch();
    }

    //保存数据
    public function save(){
        //前台提交过来是数组所以接收需要加'/a'
        $flag=trim(input('post.flag'));
        $sort=input('post.sort/a');
        $title=input('post.title/a');
        $status=input('post.status/a');
        foreach($sort as $k=>$v){
            $data['flag']=$flag;
            $data['sort']=$v;
            $data['title']=$title[$k];
            $data['status']=isset($status[$k])?1:0;
            if($k==0&&$data['title']){
                $this->db->table('video_label')->insert($data);//添加
            }
            if($k>0){
                if($data['title']==''){
                    //删除
                    $this->db->table('video_label')->where(['id'=>$k])->delete($data);
                } else{
                    //修改
                    $this->db->table('video_label')->where(['id'=>$k])->update($data);
                }
            }
        }
        exit(json_encode(['code'=>0,'msg'=>'保存成功']));
    }
}