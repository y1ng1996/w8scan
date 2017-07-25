<?php

/**
 * 基础函数库
 * @copyright (c) Emlog All Rights Reserved
 */
function __autoload($class) {
    $class = strtolower($class);
    if (file_exists(EMLOG_ROOT . '/include/model/' . $class . '.php')) {
        require_once(EMLOG_ROOT . '/include/model/' . $class . '.php');
    } elseif (file_exists(EMLOG_ROOT . '/include/lib/' . $class . '.php')) {
        require_once(EMLOG_ROOT . '/include/lib/' . $class . '.php');
    } elseif (file_exists(EMLOG_ROOT . '/include/controller/' . $class . '.php')) {
        require_once(EMLOG_ROOT . '/include/controller/' . $class . '.php');
    } else {
        emMsg($class . '加载失败。');
    }
}

/**
 * 去除多余的转义字符
 */
function doStripslashes() {
    if (!get_magic_quotes_gpc()) {
        $_GET = stripslashesDeep($_GET);
        $_POST = stripslashesDeep($_POST);
        $_COOKIE = stripslashesDeep($_COOKIE);
        $_REQUEST = stripslashesDeep($_REQUEST);
    }
    
}

/**
 * 递归去除转义字符
 */
function stripslashesDeep($value) {
    $value = is_array($value) ? array_map('stripslashesDeep', $value) : stripslashes($value);
    
    return $value;
}

/**
 * 转换HTML代码函数
 *
 * @param unknown_type $content
 * @param unknown_type $wrap 是否换行
 */
function htmlClean($content, $nl2br = true) {
    $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
    if ($nl2br) {
        $content = nl2br($content);
    }
    $content = str_replace('  ', '&nbsp;&nbsp;', $content);
    $content = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $content);
    return $content;
}

/**
 * 获取用户ip地址
 */
function getIp() {
    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        $ip = '';
    }
    return $ip;
}

/**
 * 获取站点地址(仅限根目录脚本使用,目前仅用于首页ajax请求)
 */
function getBlogUrl() {
    $phpself = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';
    if (preg_match("/^.*\//", $phpself, $matches)) {
        return 'http://' . $_SERVER['HTTP_HOST'] . $matches[0];
    } else {
        return BLOG_URL;
    }
}

/**
 * 获取当前访问的base url
 */
function realUrl() {
    static $real_url = NULL;
    
    if ($real_url !== NULL) {
        return $real_url;
    }
    
    $emlog_path = EMLOG_ROOT . DIRECTORY_SEPARATOR;
    $script_path = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME);
    $script_path = str_replace('\\', '/', $script_path);
    $path_element = explode('/', $script_path);
    
    $this_match = '';
    $best_match = '';
    
    $current_deep = 0;
    $max_deep = count($path_element);
    
    while($current_deep < $max_deep) {
        $this_match = $this_match . $path_element[$current_deep] . DIRECTORY_SEPARATOR;
        
        if (substr($emlog_path, strlen($this_match) * (-1)) === $this_match) {
            $best_match = $this_match;
        }
        
        $current_deep++;
    }
    
    $best_match = str_replace(DIRECTORY_SEPARATOR, '/', $best_match);
    $real_url  = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $real_url .= $_SERVER["SERVER_NAME"];
    $real_url .= in_array($_SERVER['SERVER_PORT'], array(80, 443)) ? '' : ':' . $_SERVER['SERVER_PORT'];
    $real_url .= $best_match;
    
    return $real_url;
}

/**
 * 验证email地址格式
 */
function checkMail($email) {
    if (preg_match("/^[\w\.\-]+@\w+([\.\-]\w+)*\.\w+$/", $email) && strlen($email) <= 60) {
        return true;
    } else {
        return false;
    }
}

/**
 * 截取编码为utf8的字符串
 *
 * @param string $strings 预处理字符串
 * @param int $start 开始处 eg:0
 * @param int $length 截取长度
 */
function subString($strings, $start, $length) {
    if (function_exists('mb_substr') && function_exists('mb_strlen')) {
        $sub_str = mb_substr($strings, $start, $length, 'utf8');
        return mb_strlen($sub_str, 'utf8') < mb_strlen($strings, 'utf8') ? $sub_str . '...' : $sub_str;
    }
    $str = substr($strings, $start, $length);
    $char = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        if (ord($str[$i]) >= 128)
            $char++;
    }
    $str2 = substr($strings, $start, $length + 1);
    $str3 = substr($strings, $start, $length + 2);
    if ($char % 3 == 1) {
        if ($length <= strlen($strings)) {
            $str3 = $str3 .= '...';
        }
        return $str3;
    }
    if ($char % 3 == 2) {
        if ($length <= strlen($strings)) {
            $str2 = $str2 .= '...';
        }
        return $str2;
    }
    if ($char % 3 == 0) {
        if ($length <= strlen($strings)) {
            $str = $str .= '...';
        }
        return $str;
    }
}

/**
 * 分页函数
 *
 * @param int $count 条目总数
 * @param int $perlogs 每页显示条数目
 * @param int $page 当前页码
 * @param string $url 页码的地址
 */
function pagination($count, $perlogs, $page, $url, $anchor = '') {
    $pnums = @ceil($count / $perlogs);
    // $re = '<ul class="pagination">';
    // $urlHome = preg_replace("|[\?&/][^\./\?&=]*page[=/\-]|", "", $url);
    $urlHome = $url.'1';
    for ($i = $page-2; $i <= $page + 2 && $i <= $pnums; $i++) {
        if ($i > 0) {
            if ($i == $page) {
                $re .= " <li class='active'><a href='#'>$i</a></li>";
            } elseif ($i == 1) {
                $re .= " <li><a href=\"$urlHome$anchor\">$i</a></li> ";
            } else {
                $re .= " <li><a href=\"$url$i$anchor\">$i</a></li> ";
            }
        }
        if(($page==1||$page==2)&&$i == ($page + 2)){
            $i1 = $i + 1;
            $i2 = $i + 2;
            $re .= " <li><a href=\"$url$i1$anchor\">$i1</a></li> ";
            if($page==1){
            $re .= " <li><a href=\"$url$i2$anchor\">$i2</a></li> ";
            }
        }
    }
    if ($page >= 1)
        $re = "<li><a href=\"{$urlHome}\" title=\"首页\">首页</a></li>$re";
    if ($page != $pnums)
        $re .= "<li><a href=\"$url$pnums$anchor\" title=\"尾页\">尾页</a></li>";
    if ($pnums <= 1)
        $re = '';
	$re = '<ul class="pagination">'.$re;
    $re .= '</ul>';
	return $re;
}


/**
 * 时间转化函数
 *
 * @param $now
 * @param $datetemp
 * @param $dstr
 * @return string
 */
function smartDate($datetemp, $dstr = 'Y-m-d H:i') {
    $op = '';
    $sec = time() - $datetemp;
    $hover = floor($sec / 3600);
    if ($hover == 0) {
        $min = floor($sec / 60);
        if ($min == 0) {
            $op = $sec . ' 秒前';
        } else {
            $op = "$min 分钟前";
        }
    } elseif ($hover < 24) {
        $op = "约 {$hover} 小时前";
    } else {
        $op = date($dstr, $datetemp);
    }
    return $op;
}

/**
 * 生成一个随机的字符串
 *
 * @param int $length
 * @param boolean $special_chars
 * @return string
 */
function getRandStr($length = 12, $special_chars = true) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    if ($special_chars) {
        $chars .= '!@#$%^&*()';
    }
    $randStr = '';
    for ($i = 0; $i < $length; $i++) {
        $randStr .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $randStr;
}

/**
 * 寻找两数组所有不同元素
 */
function findArray($array1, $array2) {
    $r1 = array_diff($array1, $array2);
    $r2 = array_diff($array2, $array1);
    $r = array_merge($r1, $r2);
    return $r;
}

/**
 * 计算时区的时差
 * @param string $remote_tz 远程时区
 * @param string $origin_tz 标准时区
 *
 */
function getTimeZoneOffset($remote_tz, $origin_tz = 'UTC') {
    if ($origin_tz === null) {
        if (!is_string($origin_tz = date_default_timezone_get())) {
            return false; // A UTC timestamp was returned -- bail out!
        }
    }
    $origin_dtz = new DateTimeZone($origin_tz);
    $remote_dtz = new DateTimeZone($remote_tz);
    $origin_dt = new DateTime('now', $origin_dtz);
    $remote_dt = new DateTime('now', $remote_dtz);
    $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
    return $offset;
}

/**
 * 获取指定月份的天数
 */
function getMonthDayNum($month, $year) {
    $month = (int)$month;
    $year = (int)$year;
    
    $months_map = array(1=>31, 3=>31, 4=>30, 5=>31, 6=>30, 7=>31, 8=>31, 9=>30, 10=>31, 11=>30, 12=>31);
    if (array_key_exists($month, $months_map)) {
        return $months_map[$month];
    }
    else {
        if ($year % 100 === 0) {
            if ($year % 400 === 0) {
                return 29;
            } else {
                return 28;
            }
        }
        else if ($year % 4 === 0) {
            return 29;
        }
        else {
            return 28;
        }
    }
}




/**
 * 页面跳转
 */
function emDirect($directUrl) {
    header("Location: $directUrl");
    exit;
}

/**
 * 显示系统信息
 *
 * @param string $msg 信息
 * @param string $url 返回地址
 * @param boolean $isAutoGo 是否自动返回 true false
 */
function emMsg($msg, $url = 'javascript:history.back(-1);', $isAutoGo = false) {
    if ($msg == '404') {
        header("HTTP/1.1 404 Not Found");
        $msg = '抱歉，你所请求的页面不存在！';
    }
    echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
EOT;
    if ($isAutoGo) {
        echo "<meta http-equiv=\"refresh\" content=\"2;url=$url\" />";
    }
    echo <<<EOT
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示信息</title>
<style type="text/css">
<!--
body {
    background-color:#F7F7F7;
    font-family: Arial;
    font-size: 12px;
    line-height:150%;
}
.main {
    background-color:#FFFFFF;
    font-size: 12px;
    color: #666666;
    width:650px;
    margin:60px auto 0px;
    border-radius: 10px;
    padding:30px 10px;
    list-style:none;
    border:#DFDFDF 1px solid;
}
.main p {
    line-height: 18px;
    margin: 5px 20px;
}
-->
</style>
</head>
<body>
<div class="main">
<p>$msg</p>
EOT;
    if ($url != 'none') {
        echo '<p><a href="' . $url . '">&laquo;点击返回</a></p>';
    }
    echo <<<EOT
</div>
</body>
</html>
EOT;
    exit;
}

/**
 * 显示404错误页面
 * 
 */
function show_404_page() {
    if (is_file(TEMPLATE_PATH . '404.php')) {
        header("HTTP/1.1 404 Not Found");
        include View::getView('404');
        exit;
    } else {
        emMsg('404', BLOG_URL);
    }
}

/**
 * 判断用户是否登陆
 *
 */
function IsLogin(){
    if(empty($_SESSION["uid"])){
        emDirect("./?login");
        return false;
    }
    return true;
}

/**
 * 检测是否为管理员
 *
 *
 */
function IsAdmim(){
    if(!empty($_SESSION["admin"])&&$_SESSION["admin"]==TRUE){
        return TRUE;
    }
    return FALSE;
}

/**
 * hmac 加密
 *
 * @param unknown_type $algo hash算法 md5
 * @param unknown_type $data 用户名和到期时间
 * @param unknown_type $key
 * @return unknown
 */
if(!function_exists('hash_hmac')) {
    function hash_hmac($algo, $data, $key) {
        $packs = array('md5' => 'H32', 'sha1' => 'H40');

        if (!isset($packs[$algo])) {
            return false;
        }

        $pack = $packs[$algo];

        if (strlen($key) > 64) {
            $key = pack($pack, $algo($key));
        } elseif (strlen($key) < 64) {
            $key = str_pad($key, 64, chr(0));
        }

        $ipad = (substr($key, 0, 64) ^ str_repeat(chr(0x36), 64));
        $opad = (substr($key, 0, 64) ^ str_repeat(chr(0x5C), 64));

        return $algo($opad . pack($pack, $algo($ipad . $data)));
    }
}
