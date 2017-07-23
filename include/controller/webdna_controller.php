<?php
/*
 * 指纹识别
 */
class WebDNA_Controller {
    function add($params = ''){
        $WebDNA = new WebDNA_Model();
        if(!empty($_POST["submit"])){
            $cms_name = $_POST["cms_name"];
            $cms_path = $_POST["cms_path"];
            $cms_keyword = $_POST["cms_keyword"];
            $cms_md5 = $_POST["cms_md5"];
            
            $WebDNA->insert($cms_name,$cms_path,$cms_keyword,$cms_md5);
            $tip = true;
        }
        include View::getView("header");
        include View::getview("webdna_add");  
    }
    function manager($params = ''){
        $page = isset($params[0])&&$params[1]=="/" ? abs(intval($params[2])) : 1;
        $WebDNA = new WebDNA_Model();
        $lognum = $WebDNA->getall();

        $total_pages = ceil($lognum / 10);
        if ($page > $total_pages) {
            $page = $total_pages;
        }
		$pageurl .= BLOG_URL.'?webdna_manager/';
        $page_url = pagination($lognum, 10, $page, $pageurl);
        $logDate = $WebDNA->getdata($page-1,10);

        include View::getView("header");
        include View::getview("webdna_manager"); 
    }

    function delete($params = ''){
        $id = intval($params[1]);
        if($id >= 0){
            $WebDNA = new WebDNA_Model();
            $WebDNA->delete($id);
            emMsg("删除指纹成功");
        }else{
            emMsg("id错误！");
        }
        
    }

    function search($params = ''){
        $key = $params[1];
        $WebDNA = new WebDNA_Model();
        
        /*$total_pages = ceil($lognum / 10);
        if ($page > $total_pages) {
            $page = $total_pages;
        }
		$pageurl .= BLOG_URL.'?webdna_manager/';
        $page_url = pagination($lognum, 10, $page, $pageurl);
        $logDate = $WebDNA->getdata($page-1,10);*/
        $logDate = $WebDNA->search($key);
        $lognum = count($logDate);
        /*echo $key;
        var_dump($logDate);
        die();*/
        include View::getView("header");
        include View::getview("webdna_manager"); 
    }
}