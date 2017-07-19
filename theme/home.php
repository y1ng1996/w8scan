<div class="container-fluid">
      <div class="row-fluid">
        <?php include View::getview("left_side");?>
        <div class="span9">
          <div class="well hero-unit">
            <h1>Welcome, w8scan</h1>
            <p>w8scan由w8ay开发，是一款轻量级插件化扫描器。扫描器原理模仿了bugscan，用户可在节点进行扫描。现在，你可以创建一个用户，新建一个目标，在节点上进行扫描. 注册口令为52w8scan</p>
            <p><a class="btn btn-success btn-large" href="./?task_add">Scan Target &raquo;</a></p>
          </div>
          <div class="row-fluid">
            <div class="span3">
              <h3>任务总数</h3>
              <p><a href="#" class="badge badge-inverse">N/N</a></p>
            </div>
            <div class="span3">
              <h3>正在进行的任务</h3>
              <p><a href="users.html" class="badge badge-inverse">N</a></p>
            </div>
            <div class="span3">
              <h3>插件总量</h3>
			  <p><a href="#" class="badge badge-inverse"><?=$plugin_count?></a></p>
            </div>
            <div class="span3">
              <h3>用户数量</h3>
			  <p><a href="roles.html" class="badge badge-inverse">N</a></p>
            </div>
          </div>
		  <br />
		  <div class="row-fluid">
			<div class="page-header">
				<h1>W8scan 能提供的的作用 <small>Approve or Reject</small></h1></br>
        <table class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th>功能名称</th>
						<th>功能描述</th>
					</tr>
				</thead>
				<tbody>
        <tr>
            <td>网站爬虫</td>
            <td>将网站爬个遍~</td>
        </tr>
				<?php 
				foreach($plugin_data as $val){
          echo "<tr>";
          echo "<td>{$val["name"]}</td>";
          echo "<td>{$val["descript"]}</td>";
          echo "</tr>";
        }
        ?>
				</tbody>
			</table>
			</div>
		  </div>
        </div>
      </div>
      <?php 
      include View::getview("footer");
      ?>