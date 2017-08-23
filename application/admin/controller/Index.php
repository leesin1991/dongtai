<?php
namespace app\admin\controller;

use think\Session;

class Index extends Common
{
    public function index()
    {
        return view();
    }


    public function logout()
    {
        Session::clear('think');
        $this->error('您尚未登录系统',url('login/index'));
    }
}
