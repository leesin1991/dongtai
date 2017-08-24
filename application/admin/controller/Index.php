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
        header("Location: " . url('login/index'));
    }
}
