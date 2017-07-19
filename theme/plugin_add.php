<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');} 
IsLogin()
?>
<div class="container-fluid">
<div class="row-fluid">
<?php include View::getview("left_side");?>
<div class="span9">
    <div class="row-fluid">
    <div class="page-header">
        <h1>添加插件 <small>可在线加入python脚本，确保py目录有可写权限</small></h1>
    </div>
    <form class="form-horizontal">
        <fieldset>
           
            <div class="control-group">
                <label class="control-label" for="role">Filename:</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="role" placeholder="不用以.py结尾 eg:sql_inject"/>
                </div>
            </div>
             <div class="control-group">
                <label class="control-label" for="active">插件类型</label>
                <div class="controls">
                <select class="form-control ">
                    <option>通用插件(/py/plugins)</option>
                    <option>爬虫插件(/py/spider)</option>
                    <option>POC插件(/py/poc)</option>
                </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="description">Pyhton</label>
                <div class="controls">
                    <textarea class="input-xlarge" id="description" rows="12" placeholder="python代码"></textarea>
                </div>
            </div>

            <div class="form-actions">
                <input type="submit" class="btn btn-success btn-large" value="Save Rule" /> <a class="btn" href="roles.html">Cancel</a>
            </div>					
        </fieldset>
    </form>
    </div>
</div>
</div>
<?php include View::getview("footer");?>