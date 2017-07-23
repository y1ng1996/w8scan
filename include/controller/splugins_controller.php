<?php

 class Splugins_Controller{

     function DisplayOnSpider(){
        $spider = new Splugins_Model();
        $infos = $spider->Getinfo(EMLOG_ROOT."/py/spider");
        // print_r($info);
        foreach($infos as $info){
            $descipt = $info["name"];
            $name = $info["path"];
            echo "<input type='checkbox' value='{$name}' name='spider_plugins[]'> {$descipt}";
        }
     }

     function DisplayOnPlugins(){
        $spider = new Splugins_Model();
        $infos = $spider->Getinfo(EMLOG_ROOT."/py/plugins");
        // print_r($info);
        foreach($infos as $info){
            $descipt = $info["name"];
            $name = $info["path"];
            echo "<input type='checkbox' value='{$name}' name='plugins[]'> {$descipt}";
        }
     }

    function DisplayOnPoc(){
        $spider = new Splugins_Model();
        $infos = $spider->Getinfo(EMLOG_ROOT."/py/poc");
        // print_r($info);
        foreach($infos as $info){
            $descipt = $info["name"];
            $name = $info["path"];
            echo "<input type='checkbox' value='{$name}' name='poc[]'> {$descipt}";
        }
     }

     function getCount(){
         $spider = new Splugins_Model();
         $infos = $spider->Getinfo(EMLOG_ROOT."/py/plugins");
         $num = count($infos);
         $infos = $spider->Getinfo(EMLOG_ROOT."/py/spider");
         $num += count($infos);
         $infos = $spider->Getinfo(EMLOG_ROOT."/py/poc");
         $num += count($infos);
         return $num;
     }

    function DisplayOnHome(){
        $spider = new Splugins_Model();
        $infos = $spider->Getinfo(EMLOG_ROOT."/py/plugins");
        $infos1 = $spider->Getinfo(EMLOG_ROOT."/py/spider");
        $infos2 = $spider->Getinfo(EMLOG_ROOT."/py/poc");
        return array_merge($infos,$infos1,$infos2);
    }

     function DisplayOnManager(){
        $spider = new Splugins_Model();
        $infos = $spider->Getinfo(EMLOG_ROOT."/py/plugins");
        // print_r($info);
        $space = '';
        $i = 0;
        foreach($infos as $k=>$info){
            $i++;
            $name = $info["path"];
            $space .= '<tr class="list-users">
					<td>'.$i.'</td>
					<td>'.$info["name"].'</td>
                    <td>'.$info["descript"].'</td>
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
					<td>'.$info["name"].'</td>
                    <td>'.$info["descript"].'</td>
					<td>爬虫插件</td>
					<td>/py/spider/'.$name.'</td>
					<td><span class="label label-success">running</span></td>
					<td>
							<a class="btn btn-mini" href="#">删除</a>
                            <a class="btn btn-mini" href="#">编辑</a>
					</td>
				</tr>';
        }
        $infos = $spider->Getinfo(EMLOG_ROOT."/py/poc");
        foreach($infos as $k=>$info){
            $i++;
            $descipt = $info["descript"];
            $name = $info["path"];
            $space .= '<tr class="list-users">
					<td>'.$i.'</td>
					<td>'.$info["name"].'</td>
                    <td>'.$info["descript"].'</td>
					<td>POC插件</td>
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