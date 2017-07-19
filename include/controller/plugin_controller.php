<?php
/*
 * 插件实现
 */
class Plugin_Controller {
    function add($params = ''){
        if(!empty($_POST["submit"])){
            $file = addslashes($_POST["filename"]);
            if(strpos($file,'.') or strpos($file,'/') or strpos($file,'\\'))emMsg("文件名命名有误");
            $python_code = $_POST["code"];
            $type = intval($_POST["type"]);
            // 组合文件路径
            $switch_type = array("plugins","spider","poc");
            $file_name = EMLOG_ROOT . DIRECTORY_SEPARATOR  ."py" . DIRECTORY_SEPARATOR  . $switch_type[$type] .DIRECTORY_SEPARATOR .$file. ".py";
            if(is_file($file_name)){
                emMsg("已有重复的文件名，请改名");
            }
            file_put_contents($file_name,$python_code);
            $tip = true;
        }
        include View::getView("header");
        include View::getview("plugin_add");  
    }
    function manager($params = ''){
        $Splugins = new Splugins_Controller();
        $count = $Splugins->getCount();
        include View::getView("header");
        include View::getview("plugin_manager"); 
    }
}