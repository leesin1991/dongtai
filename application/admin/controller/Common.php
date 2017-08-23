<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Common extends Controller
{

    public function _initialize()
    {
         if(!session('login_admin')){
            $this->error('您尚未登录系统',url('login/index'));
         }
    }

    public function saveData($table,$data)
    {
        if(empty($data["id"])){
            //新增数据并返回主键值
            $rs=Db::name($table)->insertGetId($data);
        }
        else{
            $rs=Db::name($table)->where('id',$_POST["id"])->update($data);
        }
        return $rs;
    }
}