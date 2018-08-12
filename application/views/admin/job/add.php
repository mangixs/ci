<div class="detail">
    <form id="edit_form" data-action="/admin/job/save" >
        <input type="hidden" value="<?=$action?>" name="action">
        <input type="hidden" value="" name="id">
    	<div class="detail-row">
    		<div class="row-label">
    			<span class="must">职位名:</span>
    		</div>
    		<div class="row-input">
    			<input type="text" name="job_name" placeholder="请输入职位名" maxlength="12">
    		</div>
    	</div>
        <div class="detail-row">
            <div class="row-label">
                <span>职位描述:</span>
            </div>
            <div class="row-input">
                <textarea name="explain" placeholder="请输入职位描述"></textarea>
            </div>
        </div>
    </form>
</div>
    <div class="btn_box">
        <button type="button" class="btn btn-success" data-btn="submit">保存</button>
    </div>
<script type="text/javascript">
const editObj = new edit();
<?php if ($action != 'add'): ?>
editObj.setForm($("#edit_form"),<?=json_encode($data)?>);
<?php endif;?>
editObj.saveurl='admin/job/edit/<id>/edit';
</script>
</body>
</html>