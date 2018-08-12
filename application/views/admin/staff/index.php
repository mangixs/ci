<div class="head container-fluid">
	<div class="row">
		<span class="title"><?=$title?></span>
		<?php if (in_array('add', $key['auth_key'])): ?>
		<button type="button"  class="btn btn-success btn-right" onclick="parent.adminObj.add('/admin/staff/add','添加管理员')" >添加</button>
		<?php endif;?>
	</div>
</div>
<div class="content container-fluid">
	<div class="data-show">
		<table class="table table-bordered">
		   <thead>
		      	<tr class="active">
		         	<th>登录名</th>
		         	<th>头像</th>
		         	<th>员工编号</th>
		        	<th>姓名</th>
		        	<th>添加时间</th>
		        	<th>操作</th>
		      	</tr>
		   </thead>
		   <tbody id="data_box">
				<?php foreach ($data as $k => $v): ?>
					<tr>
						<td><?=$v['login_name']?></td>
						<td>
							<?php if (!empty($v['header_url'])): ?>
								<img src="<?=$v['header_img']?>" width="48px" height="48px">
							<?php endif;?>
						</td>
						<td><?=$v['staff_num']?></td>
						<td><?=$v['true_name']?></td>
						<td><?=$v['insert_at']?></td>
						<td>
							<a href="javascript:parent.adminObj.edit('/admin/staff/edit/<?=$v['id']?>/browse','查看');" class="list-btn browse"></a>
							<?php if (in_array('edit', $key['auth_key'])): ?>
							<a href="javascript:parent.adminObj.edit('/admin/staff/edit/<?=$v['id']?>/edit','编辑管理员');" class="list-btn edit" ></a>
							<?php endif;?>
							<?php if (in_array('delete', $key['auth_key'])): ?>
							<a href="javascript:parent.adminObj.deleteData('/admin/staff/deleteData/<?=$v['id']?>');" class="list-btn del" ></a>
							<?php endif;?>
							<?php if (in_array('edit', $key['auth_key'])): ?>
							<a href="javascript:parent.adminObj.edit('/admin/staff/setJob/<?=$v['id']?>','设置职位');" class="list-text" >职位</a>
							<?php endif;?>
						</td>
					</tr>
				<?php endforeach;?>
		   </tbody>
		</table>
	</div>
	<div class="page_box container-fluid text-center">
		<?=$page?>
	</div>
</div>
<script type="text/javascript">
var dataObj={};
dataObj.get_data = function(){
	window.location.reload();
}
</script>
</body>
</html>