<?php
// +----------------------------------------------------------------------
// | Function for ThinkPHP5 [ Brainy is the new sexy ~ ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017-2017 http://www.iawim.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.iawim.com/)
// +----------------------------------------------------------------------
// | Author: 李清 <leesin2011@163.com>
// +----------------------------------------------------------------------
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

// 应用公共文件
error_reporting(E_ERROR | E_PARSE );


/**
 * http_curl
 * @param $url 接口url string
 * @param $type 请求类型 string
 * @param $res 返回数据类型 string
 * @param $arr post请求数组 array
 * @return error/json
 */
function http_curl($url="",$type='get',$res='json',$arr='')
{
    //1.初始化curl
    $ch = curl_init();
    //2.设置curl参数
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($type == 'post') {
        curl_setopt($ch, CURLOPT_POST, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
    }
    //3.采集
    $output = curl_exec($ch);
    //4.关闭
    curl_close($ch);
    if ($res == 'json') {
        if (curl_errno($ch)) {
            return curl_errno($ch);
        }
        else{
            return json_decode($output,TRUE);
        }
    }
}

/**
 *快捷打印变量
 * @param $val
 */
function p($val)
{
    if (is_bool($var)) {
        var_dump($val);
    }else {
        echo "<pre style='position:relative;z-index:1000;padding:10px;
		border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;
		line-height:18px;opacity:0 9;'>".print_r($val,true)."</pre>";
        //print_r($val);
    }
}


/**
 * 创建多级文件夹 *
 * @param 路径 www.iawim.com/sing/public/uploads/
 * @param 权限 755/777 $mode
 */
function mkpath($path,$mode = 0777)
{
    $path = str_replace("\\","_|",$path);
    $path = str_replace("/","_|",$path);
    $path = str_replace("__","_|",$path);
    $dirs = explode("_|",$path);
    $path = $dirs[0];
    for($i = 1;$i < count($dirs);$i++)
    {
        $path .= "/".$dirs[$i];
        if(!is_dir($path))
            mkdir($path,$mode);
    }
}

/**
 * 前台登录检查
 *
 */
function checkHomeLogin()
{
    if(!session('login_user')){
        header("Location: /sing/index.php/index/login/index");
        //$this->error('您尚未登录系统',url('login/index'));
    }
}

/**
 * 后台登录检查
 *
 */
function checkBackLogin()
{
    if(!session('login_admin')){
        $this->error('您尚未登录系统',url('login/index'));
    }
}


/**
 * 保存post(根据是否有$_POST["id"]来判断执行插入或更新操作)
 * @param string $table
 *
 */
function savePost($table)
{
    if(empty($_POST["id"])){
        //新增数据并返回主键值
        $rs=Db::name($table)->insertGetId($_POST);
    }
    else{
        $rs=Db::name($table)->where('id',$_POST["id"])->update($_POST);
    }
    return $rs;
}

/**
 * 保存(根据是否有$_POST["id"]来判断执行插入或更新操作)
 * @param string $table
 *
 */
function saveData($table,$data)
{
    if(intval($data["id"]) < 1){
        //新增数据并返回主键值
        $rs=Db::name($table)->insertGetId($data);
    }
    else{
        $rs=Db::name($table)->where(['id' => $data['id']])->update($data);
    }
    return $rs;
}

/**
 * 获取某一字段的值
 * @param string $table
 * @param array $where
 * @param string $field
 * @return string
 */
function getFieldName($table,$where,$field='name')
{
    $rs = Db::name($table)->where($where)->value($field);
    return $rs;
}


/**
 * 生成随机数
 * @param 长度 $length
 * @param 是否是数字 $num
 * @return varchar
 */
function random($length=6,$num)
{
    $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";   //   输出字符集
    if($num)$str = "0123456789";   //   只输出数字
    $len = strlen($str)-1;
    for($i=0 ; $i<$length; $i++){
        $s .=  $str[rand(0,$len)];
    }
    return $s;
}

/**
 * 字符串加密
 * @param varchar $txt
 * @return varchar
 */
function encrypt($txt)
{
    return base64_encode(QING.$txt);
}

/**
 * 字符串解密
 * @param varchar $txt
 * @return varchar
 */
function decrypt($txt)
{
    $str =  base64_decode($txt);
    return str_replace(QING,"",$str);
}

/**
 * 信息提示
 * @param varchar $text
 * @param varchar $url
 */
function sysMsg($text,$url="history.go(-1);")
{
    $str = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
    $str .=  "<script>alert('$text');$url</script>";
    die($str);
}

/**
 * 数字列表
 * @param 开始 int $from
 * @param 结束 int $end
 * @param 排序 $sort
 * @return array
 */
function getNumList($from,$end,$sort)
{
    $arr = array();
    if($sort =="DESC"){
        for ($i=$end;$i>$from;$i--){
            $arr[$i] = $i;
        }
    }
    else{
        for ($i=$from;$i<$end;$i++){
            $arr[$i] = $i;
        }
    }
    return $arr;
}

/**
 * 过期时间
 * @param varchar $endtime
 * @return varchar
 */
function leavHr($endtime)
{
    $time = (strtotime($endtime)-time());
    if ($time >= 86400 ) {
        $day = floor($time/86400);
        $time = $time-$day*86400;
        $str = $day.'天';
        $str .= floor($time/3600).'小时';
    }
    else{
        $str = floor($time/3600).'小时';
    }
    return $str;
}

function ajaxReturn($data,$type = 'json'){
    exit(json_encode($data));
}

/*
 * 过滤非法html标签
 */

function t($text) {
    $text = nl2br($text);
    $text = real_strip_tags($text);
    $text = addslashes($text);
    $text = trim($text);
    return addslashes($text);
}

function real_strip_tags($str, $allowable_tags = "") {
    $str = stripslashes(htmlspecialchars_decode($str));
    return strip_tags($str, $allowable_tags);
}

