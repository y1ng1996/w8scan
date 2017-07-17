<?php

 class Splugins_Controller{

     function DisplayOnSpider(){
        $spider = new Splugins_Model();
        $infos = $spider->Getinfo(EMLOG_ROOT."/py/spider");
        // print_r($info);
        foreach($infos as $info){
            $descipt = $info["descript"];
            $name = $info["path"];
            echo "<input type='checkbox' value='{$name}' name='spider_plugins[]'> {$descipt}";
        }
     }

     function DisplayOnPlugins(){
        $spider = new Splugins_Model();
        $infos = $spider->Getinfo(EMLOG_ROOT."/py/plugins");
        // print_r($info);
        foreach($infos as $info){
            $descipt = $info["descript"];
            $name = $info["path"];
            echo "<input type='checkbox' value='{$name}' name='plugins[]'> {$descipt}";
        }
     }

     function getCount(){
         $spider = new Splugins_Model();
         $infos = $spider->Getinfo(EMLOG_ROOT."/py/plugins");
         $num = count($infos);
         $infos = $spider->Getinfo(EMLOG_ROOT."/py/spider");
         $num += count($infos);
         return $num;
     }
     function DisplayOnManager(){
        $spider = new Splugins_Model();
        $infos = $spider->Getinfo(EMLOG_ROOT."/py/plugins");
        // print_r($info);
        $space = '';
        $i = 0;
        foreach($infos as $k=>$info){
            $i++;
            $descipt = $info["descript"];
            $name = $info["path"];
            $space .= '<tr class="list-users">
					<td>'.$i.'</td>
					<td>'.$descipt.'</td>
					<td>通用插件</td>
					<td>/py/plugins/'.$name.'</td>
					<td><span class="label label-success">running</span></td>
					<td>
							<a class="btn btn-mini" href="#">删除</a>
                            <a class="btn btn-mini" href="#">编辑</a>
					</td>
				</tr>';
        }
        $infos = $spider->Getinfo(EMLOG_ROOT."/py/spider");
        foreach($infos as $k=>$info){
            $i++;
            $descipt = $info["descript"];
            $name = $info["path"];
            $space .= '<tr class="list-users">
					<td>'.$i.'</td>
					<td>'.$descipt.'</td>
					<td>爬虫插件</td>
					<td>/py/spider/'.$name.'</td>
					<td><span class="label label-success">running</span></td>
					<td>
							<a class="btn btn-mini" href="#">删除</a>
                            <a class="btn btn-mini" href="#">编辑</a>
					</td>
				</tr>';
        }
        echo $space;
     }

 }