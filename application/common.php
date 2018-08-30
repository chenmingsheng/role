<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * echo json
 * @param int    $code 编码
 * @param string $msg  描述
 * @param mixed  $data 返回接口
 * @return json
 */
function echoJson($code, $msg, $data=''){
    $array = [
        'code' => "{$code}",
        'msg'  => $msg,
        'data' => $data,
    ];
    echo json_encode($array);
    exit;
}

/**
 * echo json
 * @param int    $code 编码
 * @param string $msg  描述
 * @param mixed  $data 返回接口
 * @return json
 */
function Jsonlist($code, $msg,$count='',$data=''){
    $array = [
        'code' => "{$code}",
        'msg'  => $msg,
        'count'=>$count,
         'data' => $data,
    ];
    echo json_encode($array);
    exit;
}

/*
 * 获得IP的真实地理信息 - TaoBao
 * @param string $ip  IP地址
 * @return array      返回成功查询后的数组
*/
function isTaobao($ip=''){
    if(empty($ip)){
        return '请输入IP地址';
    }
    $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
    $ip=json_decode(file_get_contents($url));
    if((string)$ip->code=='1'){
        return false;
    }
    $data = (array)$ip->data;
    return $data;
}

/*
* SQL注入过滤
* $string : 需要过滤的字符串
* 返回过滤之后的字符串
*/
function isSql($string) {
    $source = 'or|and|xor|not|select|insert|update|delete|=>|<=|!=|=|%|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile';
    $badword = explode('|',$source);
    $badword1 = array_combine($badword,array_fill(0,count($badword),'/'));
    $string = strtr($string,$badword1);
    if (! get_magic_quotes_gpc ()) {
        if(is_array($string)) {
            foreach($string as $key => $val) {
                $string[$key] = isSql($val);
            }
        } else {
            $string = addslashes($string);
        }
    }
    return $string;
}

/**
 * @param $arr
 * @param string $name
 * @param int $pid
 * @return array
 * 无限菜单递归
 */
function memu($arr,$name='children',$pid=0){
    $atr=[];
    foreach($arr as $v){
        if($v['m_pid']==$pid){
            $v[$name]=memu($arr,$name,$v['m_id']);
            $atr[]=$v;
        }
    }
    return $atr;
}

/**
 * @param $arr
 * @param string $name
 * @param int $pid
 * @return array
 * 部门递归
 */
function unlimitedForLayer($arr,$name='children',$pid=0){
    $atr=[];
    foreach($arr as $v){
        if($v['pid']==$pid){
            $v[$name]=unlimitedForLayer($arr,$name,$v['id']);
            $atr[]=$v;
        }
    }
    return $atr;
}

/**
 * @param $arr  数组
 * @param $id   菜单id
 * @param string $name  子数组
 * @param int $pid
 * @return array
 */
function rolelist($arr,$id,$name='children',$pid=0){
    $selid=explode(',',$id);
    $atr=[];
    foreach($arr as $v){
        if($v['pid']==$pid){
            if (in_array($v['checkboxValue'],$selid)) $v['checked'] = true;
            $v['spread'] = true;
            $v[$name]=rolelist($arr,$id,$name='children',$v['checkboxValue']);
            $atr[]=$v;
        }

    }
    return $atr;
}

/**
 * @param $arr
 * @param string $name
 * @param int $pid
 * @return array
 * 岗位权限菜单
 */
function joblist($arr,$name='children',$pid=0){
    $atr=[];
    foreach($arr as $v){
        if($v['pid']==$pid){
            $v['spread'] = true;
            $v[$name]=joblist($arr,$name,$v['checkboxValue']);
            $atr[]=$v;
        }
    }
    return $atr;
}

/**
 * 多维数组无限极分类-递归
 * @param  array  : $cate  递归数组
 * @param  string : $id    已有权限节点
 * @param  string : $name  多维节点名称
 * @param  int    : $pid   初始递归父级
 * @return array  : 多维数组
 */
function roleUpd ($cate, $id, $name = 'children', $pid = 0) {
    $arr = [];
    if (!is_array($id)) $id = explode(',', $id);

    foreach ($cate as $v) {
        if ($v['pid'] == $pid) {
            unset($v['pid']);
            if (in_array($v['checkboxValue'], $id)) $v['checked'] = true;
            $v['spread'] = true;
            $v[$name] = roleUpd($cate, $id,$name, $v['checkboxValue']);
            $arr[] = $v;
        }
    }
    return $arr;
}