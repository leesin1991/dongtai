<?php
namespace app\admin\controller;
use think\Request;
use think\Db;
use think\Session;

class Article extends Common
{
    public function index()
    {
        $where['is_del'] = 0;
        $order = 'sort Asc';
        $data = Db::name('article')->where($where)->order($order)->paginate();
        foreach ($data as $key => $value) {
            $value['catename'] = Db::name('article_category')->where(['id'=>$value['category_id']])->value('title');
            $data[$key] = $value;
        }
        $this->assign('data',$data);
        return view('article');
    }

    public function editArticle()
    {
        $where['id'] = input('get.id');
        $where['is_del'] = 0;
        $data = Db::name('article')->where($where)->find();
        $categoryList = Db::name('article_category')->where(['is_del'=>0])->select();
        $this->assign('categoryList',$categoryList);
        $this->assign('data',$data);
        return view();
    }


    public function doEditArticle()
    {
        $post = input('post.');
        $post['uid'] = Session::get('login_admin')['id'];
        $now = time();
        $post['mtime'] = $now;
        if (!$post['id']) {
            $post['ctime'] =$now;
        }
        $rs = $this->saveData('article',$post);
        if ( $rs ){
            $return = ['errno' => 0, 'errmsg' => ''];
        } else{
            $return = ['errno' => 1, 'errmsg' => '保存失败'];
        }
        ajaxReturn($return);
    }


    public function category()
    {
        $where['is_del'] = 0;
        $order = 'sort Asc';
        $data = Db::name('article_category')->where($where)->order($order)->paginate();
        $this->assign('data',$data);
        return view();
    }

    public function editCategory()
    {
        $where['id'] = input('get.id');
        $where['is_del'] = 0;
        $data = Db::name('article_category')->where($where)->find();
        $this->assign('data',$data);
        return view();
    }


    public function doEditCategory()
    {
        $post = input('post.');
        $rs = $this->saveData('article_category',$post);
        if ( $rs ){
            $return = ['errno' => 0, 'errmsg' => ''];
        } else{
            $return = ['errno' => 1, 'errmsg' => '保存失败'];
        }
        ajaxReturn($return);
    }



}
