<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');} 
IsLogin();
if(!IsAdmim()){
    emMsg("没有管理员权限");
}

?>
<div class="container-fluid">
<div class="row-fluid">
<?php include View::getview("left_side");?>
<div class="span9">
    <div class="row-fluid">
    <div class="page-header">
        <h1>Web指纹添加 <small>Add WebDNA</small></h1>
    </div>
    <form class="form-horizontal" method="POST" action="">
    <?php 
    if($tip):
    ?>
    <div class="alert alert-success" role="alert">
    加入指纹成功！<code><a href="?webdna_manager"> 查看插件</a></code>
    </div>
    <?php endif;?>
        <fieldset>
            <div class="control-group">
                <label class="control-label" for="role">Name</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" name="cms_name" id="role" placeholder="CMS名称"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="role">PATH</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" name="cms_path" id="role" placeholder="CMS路径"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="role">关键词</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="role" name="cms_keyword" placeholder="关键词"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="role">MD5</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="role" name="cms_md5" placeholder="MD5值"/>
                </div>
            </div>
            <div class="form-actions">
                <input type="submit" class="btn btn-success btn-large" name="submit" value="Save Rule" /> <a class="btn" href="?webdna_manager">Cancel</a>
            </div>					
        </fieldset>
    </form>
    </div>
</div>
</div>
<?php include View::getview("footer");?>