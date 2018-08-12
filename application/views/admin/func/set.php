<link rel="stylesheet" type="text/css" href="/resources/css/key.css">
<div class="func">
	<div class="left">功能键值</div>
	<div class="right">
		<input type="text" value="<?=$data['key']?>" disabled="disabled" >
	</div>
</div>
<div class="func">
	<div class="left">权限键值</div>
	<div class="right">
		<div class="mid">权限名称</div>
		<div class="mid">
			<button type="button" class="add_btn" onclick="add_line()">添加</button>
		</div>
	</div>
</div>
<form id="edit_from">
	<input type="hidden" name="key" value="<?=$data['key']?>">
	<div class="box">
	<?php $index = 0;?>
	<?php foreach ($set as $v): ?>
		<div class="list" data-index="<?=$index?>">
			<div class="list_box">
				<input type="text" data-allow="en" maxlength="12" placeholder="请输入权限键值" value="<?=$v->key?>" name="extendkey[<?=$index?>]" />
			</div>
			<div class="list_box">
				<input type="text" data-allow="no_space" maxlength="12" placeholder="请输入权限名称" value="<?=$v->auth_name?>" name="extendname[<?=$index?>]" />
			</div>
			<div class="list_box">
				<button type="button" class="delete_btn" onclick="deleteList(<?=$index?>)">删除</button>
			</div>
		</div>
	<?php $index++;?>
	<?php endforeach;?>
	</div>
</form>
<div class="btn_box">
    <button type="button" class="btn btn-success" data-btn="submit">保存</button>
</div>
<script type="text/javascript">
$(function(){
	$(".btn").click(save);
})
var index=<?=$index;?>;
function add_line(){
	var html='<div class="list" data-index="'+index+'" ><div class="list_box" ><input type="text" data-allow="en" maxlength="12" placeholder="请输入权限键值" value="" name="extendkey['+index+']" /></div><div class="list_box" ><input type="text" data-allow="no_space" maxlength="12" placeholder="请输入权限名称" value="" name="extendname['+index+']" /></div><div class="list_box" ><button type="button" class="delete_btn" onclick="deleteList('+index+')" >删除</button></div></div>';
	$(".box").append(html);
	index++;
}
function deleteList(id){
	$("[data-index='"+id+"']").remove();
}
var submiting=false;
function save(){
    if ( submiting ) {
        return;
    }
    submiting=true;
	var data=$("#edit_from").serialize();
	$.post('/admin/func/setSave',data, function(res, textStatus, xhr) {
		if (res.result=="SUCCESS") {
			parent.$.suc(res.msg);
			window.location.reload();
			submiting=false;
		}else{
            submiting=false;
			parent.$.warn(res.msg);
		}
	});
}
</script>
</body>
</html>
