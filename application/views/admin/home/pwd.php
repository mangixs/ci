
	<div class="detail">
	    <form id="edit_form" >
	    	<div class="detail-row">
	    		<div class="row-label">
	    			<span class="must">旧密码:</span>
	    		</div>
	    		<div class="row-input">
	    			<input type="password" data-allow="login" name="old" placeholder="请输入旧密码" maxlength="12">
	    		</div>
	    	</div>
	        <div class="detail-row">
	            <div class="row-label">
	                <span class="must">新密码:</span>
	            </div>
	            <div class="row-input">
	                <input type="password" data-allow="login" name="pwd" placeholder="请输入新密码" >
	            </div>
	        </div>
	        <div class="detail-row">
	            <div class="row-label">
	                <span class="must">新密码:</span>
	            </div>
	            <div class="row-input">
	                <input type="password" data-allow="login" name="newpwd" placeholder="确认新密码" maxlength="12">
	            </div>
	        </div>
	    </form>
	</div>

	<div class="btn_box">
		<button type="button" class="btn btn-success">保存</button>
	</div>
<script type="text/javascript">
$(function(){
	$(".btn").click(save);
})
let sub=false;
function save(){
	if ( sub ) {
		return;
	}
	var old=$("input[name='old']").val().replace(/\s/g,'');
	if ( old  == '') {
		parent.$.warn('请输入旧密码');
		return;
	}
	var pwd=$("input[name='pwd']").val().replace(/\s/g,'');
	var newpwd=$("input[name='newpwd']").val().replace(/\s/g,'');
	if ( pwd.length <=5 ) {
		parent.$.warn('密码长度大于5');
		return;
	}
	if ( pwd != newpwd ) {
		parent.$.warn('新密码不一致');
		return;
	}
	sub=true;
	$.ajax({
		url:"/admin/home/changePwd",
		data:$("#edit_form").serialize(),
		type:'post',
		error:function(){
			sub=false;
			parent.$.warn('服务器忙，请重试');
		},
		success:function(res){
			if ( res.result == 'SUCCESS' ) {
				parent.$.suc(res.msg);
				window.location.reload();
			}else{
				sub=false;
				parent.$.warn(res.msg);
			}
		}
	})
}
</script>
</body>
</html>
