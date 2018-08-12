<div class="detail">
    <form id="edit_form" data-action="admin/staff/save" >
        <input type="hidden" value="<?=$action?>" name="action">
        <input type="hidden" value="" name="id">
        <div class="detail-row">
            <div class="row-label">
                <span class="must">登录名:</span>
            </div>
            <div class="row-input">
                <input type="text" data-allow="login" name="login_name" placeholder="请输入用户登录名" maxlength="16">
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span>初始密码:</span>
            </div>
            <div class="row-input">
                <span class="notice">初始密码为123456</span>
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span>姓名:</span>
            </div>
            <div class="row-input">
                <input type="text"  name="true_name" placeholder="请输入用户姓名" maxlength="12">
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span>用户编号:</span>
            </div>
            <div class="row-input">
                <input type="text" data-allow="number" name="staff_num" placeholder="请输入用户编号" maxlength="5">
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span>用户头像:</span>
            </div>
            <div class="row-input">
                <a href="javascript:;" class="file">选择文件
                     <input id="upload_btn" type="file" name="file" multiple>
                </a>
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span>头像预览:</span>
            </div>
            <div class="row-input">
                <div class="img-box">
                </div>
                <input type="hidden" name="header_img">
            </div>
        </div>
    </form>
    <div class="btn_box">
        <button type="button" class="btn btn-success" data-btn="submit">保存</button>
    </div>
</div>
<script type="text/javascript" src="/resources/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/resources/jQuery-File-Upload/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="/resources/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
<script type="text/javascript">
$(function(){
    $('#upload_btn').fileupload({
        dataType: 'json',
        url: "<?=base_url('admin/staff/uploadImage')?>",
        done: function(e, data) {
            if(data.result.result !='SUCCESS'){
                parent.$.warn(data.result.msg);
            }
            $("input[name='header_img']").val(data.result.url);
            let html = `
                <img  src="${data.result.url}" width='100px' height='100px' />
            `;
            $('.img-box').html(html);
        }
    });
})
const editObj = new edit();
<?php if ($action !== 'add'): ?>
editObj.setForm($("#edit_form"),<?=json_encode($data)?>);
<?php endif;?>
editObj.saveurl='admin/staff/edit/<id>/edit';
editObj.showImg = function(){
    if(this.saveData.header_img !=''){
        let html = `
                <img  src="${this.saveData.header_img}" width='100px' height='100px' />
            `;
        $('.img-box').html(html);
    }
}
editObj.showImg();
</script>
