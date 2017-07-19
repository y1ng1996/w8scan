<?php
/**
 * 爬虫插件管理，添加，显示
 *
 * @copyright (c) w8scan All Rights Reserved
 */
 class Splugins_Model{
     /**
    * 获取指定行内容
    *
    * @param $file 文件路径
    * @param $line 行数
    * @param $length 指定行返回内容长度
    */
    function getLine($file, $line, $length = 4096){
        $back = array();
        $returnTxt = @implode('', @file($file));
        preg_match("/Name:(.*)/i", $returnTxt, $tplName);
        preg_match("/Descript:(.*)/i", $returnTxt, $descript);
        $back["name"] = !empty($tplName[1]) ? trim($tplName[1]) : substr(strrchr($file, "/"),1);
        $back["descript"] = !empty($descript[1]) ? trim($descript[1]) : "这家伙很懒，没有描述";
        return $back;
    }

    /*
    * 获取指定文件夹的所有文件
    *
    */
    function tree($directory) 
    { 
        $mydir = dir($directory); 
        $filedir = array();
        while($file = $mydir->read())
        { 
            if((is_dir("$directory/$file")) AND ($file!=".") AND ($file!="..")) 
            {
                $filedir[] = $file;
                tree("$directory/$file"); 
            } 
            else if(($file!=".") AND ($file!="..")){
                $filedir[] = $file;
            } 
            
        }
        $mydir->close(); 
        return $filedir;
    } 

    function Getinfo($dirx){
        $filenames = $this->tree($dirx);
        $info = array();
        foreach($filenames as $filename){
            $rtext = $this->getLine($dirx.'/'.$filename,20);
            $name = trim($rtext["name"]);
            $descript = trim($rtext["descript"]);
            $tem_arr = array();
            $tem_arr["descript"] = $descript;
            $tem_arr["name"] = $name;
            $tem_arr["all_path"] = $dirx.'/'.$filename;
            $tem_arr["path"] = $filename;
            $info[] = $tem_arr;
        }
        return $info;
    }


 }