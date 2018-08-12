<div class="detail">
    <form id="edit_form" data-action="admin/func/save">
        <input type="hidden" value="<?=$action?>" name="action">
        <input type="hidden" value="" name="id">
        <div class="detail-row">
            <div class="row-label">
                <span class="must">键值:</span>
            </div>
            <div class="row-input">
                <input type="text" data-allow="login_name" name="key" placeholder="请输入键值" maxlength="24">
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">功能名称:</div>
            <div class="row-input">
                <input type="text" name="func_name" placeholder="请输入键名" maxlength="14">
            </div>
        </div>
    </form>
    <div class="btn_box">
        <button type="button" class="btn btn-success" data-btn="submit">保存</button>
    </div>
</div>
<script type="text/javascript">
    const editObj = new edit();
    editObj.saveurl = 'admin/func/edit/<id>/edit';
    <?php if ($action != 'add'): ?>
    editObj.setForm($("#edit_form"), <?=json_encode($data)?>);
    <?php endif;?>
</script>
</body>
</html>