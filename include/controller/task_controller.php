<?php
/*
 * 任务管理实现
 */
class Task_Controller {

    function add($params = ''){
        if(!empty($_POST["url"])){
            // 开始处理提交表单
            $task = new Task_Model();
            $uid = (int)$_SESSION["uid"];
            $token = $task->add(addslashes($_POST["url"]),addslashes($_POST["descript"]),$_POST["plugins"],$_POST["spider_plugins"],$_POST["poc"],$uid);
            $callback_url = BLOG_URL.'?get/'.$token;
        }
        include View::getView("header");
        include View::getview("task_add");  
    }
    function manager($params = ''){
        $task = new Task_Model();
        $uid = (int)$_SESSION["uid"];
        $LogData = $task->GetPageData($uid);
        // print_r($LogData);
        // die();
        include View::getView("header");
        include View::getview("task_manager"); 
    }

    // 返回接口页面
    function task_callback($params = ''){
        if($params[1]=='/'&&!empty($params[2])){
            $token = $params[2];
            include View::getView("task_callback");
        }else{
            exit("sql error");//假错误
        }
    }

    // 更新数据页面
    function reciver_data($params = ''){
        $data = addslashes($_POST["data"]);
        $flag_ = addslashes($_POST["flag"]);
        if($params[1]=='/'&&!empty($params[2])&&(!empty($data)||!empty($flag_))){
            $token = $params[2];
            $task = new Task_Model();
            if($flag_){
                $task->update_Status($token,"1");
                exit();
            }
            $task->update_Result($token,$data);
            echo "success!";
        }else{
            exit("sql error");//假错误
        }
    }

    // 删除任务
    function delete($params = ''){
        if($params[1]=='/'&&!empty($params[2])){
            $uid = $params[2];
            $task = new Task_Model();
            $task->deleteLog($uid);
            emMsg("删除任务成功！");
        }else{
            exit("sql error");//假错误
        }
    }

}