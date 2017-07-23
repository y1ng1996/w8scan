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
			<script>
				function formSubmit()
				{
				key = $("#webkey").val();
				window.location.href="?webdna_manager/search/" + key;
				}

			</script>
				<h1>指纹管理 <small>WebDNA total:<?php echo $lognum;?></small>
				<div class="input-group" style="float:right">
				<input type="text" class="form-control" placeholder="Search for..." id="webkey">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="formSubmit()" style="margin-bottom: 12px;">搜索</button>
				</span>
				</div>
				</h1>
			</div>
			<table class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th>指纹名称</th>
						<th>请求路径</th>
						<th>关键字</th>
						<th>MD5</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($logDate as $k=>$v):?>
				<tr class="list-users">
					<td><?php echo htmlClean($v["name"]);?></td>
					<td><?php echo htmlClean($v["url"]);?></td>
					<td><?php echo htmlClean($v["re"]);?></td>
					<td><?php echo htmlClean($v["md5"]);?></td>
					<td>
                    <a class="btn btn-mini" href="?webdna_manager/delete/<?php echo $v["index"];?>">删除</a>
					
					</td>
				</tr>
				<?php endforeach;?>
				</tbody>
			</table>
			<?php echo $page_url;?>
			<a href="?webdna_add" class="btn btn-success">新指纹</a>
		  </div>
        </div>
      </div>
    <?php include View::getview("footer");?>