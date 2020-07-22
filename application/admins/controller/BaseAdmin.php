<?php
/**
 * Created by PhpStorm.
 * User: EDZ
 * Date: 2020/7/3
 * Time: 16:32
 */

namespace app\admins\controller;


use think\Controller;
use Util\data\Sysdb;

class BaseAdmin extends Controller
{
    public function __construct()
    {
        $this->db=new Sysdb();
        parent::__construct();
        $this->_admin=session('admin');
        $this->assign('admin', $this->_admin);
        //判断用户是否登录
        if(!$this->_admin){
            header('location:/admin.php/admins/Account/login');
            exit;
        }
        //判断用户登录权限
    }
}