<link rel="stylesheet" type="text/css" href="/resources/css/menu.css">
<div class="detail">
    <form id="edit_form" data-action='admin/menu/save'>
        <input type="hidden" value="<?=$action?>" name="action">
        <input type="hidden" value="" name="id">
        <div class="detail-row">
            <div class="row-label">父级菜单:</div>
            <div class="row-input">
                <select name="parent">
                <option value="0">无父级菜单</option>
                <?php foreach ($all as $v): ?>
                    <option value="<?=$v['id']?>">
                        <?php if ($v['level'] > 0): ?>
                        |
                        <?php for ($i = 0; $i < $v['level']; $i++): ?>
                        --
                        <?php endfor;?>
                        <?php endif;?>
                        <?=$v['named']?>
                    </option>
                <?php endforeach;?>
            </select>
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span class="must">名称:</span>
            </div>
            <div class="row-input">
                <input type="text" name="named" placeholder="请输入名称" maxlength="12">
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span class="must">链接:</span>
            </div>
            <div class="row-input">
                <input type="text" name="url" placeholder="请输入菜单链接" maxlength="36">
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span class="must">权限</span>
            </div>
            <div class="row-input">
                <button type="button" class="file" id="auth">设置权限</button>
                <input type="hidden" name="screen_auth">
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">排序:</div>
            <div class="row-input">
                <input type="text" name="sort" placeholder="请输入菜单排序" maxlength="4" data-allow="number" value="100">
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">图标</div>
            <div class="row-input">
                <a href="javascript:;" class="file" id="upload_btn">选择文件
                    <input id="upload_btn" type="file" name="file" multiple>
                </a>
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span>图标预览:</span>
            </div>
            <div class="row-input">
                <div class="img-box">

                </div>
                <input type="hidden" name="icon">
            </div>
        </div>
    </form>
</div>
    <div class="btn_box">
    <button type="button" class="btn btn-success" data-btn="submit">保存</button>
</div>
<div class="key_bg"></div>
<div class="key_box">
    <div class="detail_box">
        <div class="row">
            <div class="label">功能名称</div>
            <div class="content"><span>权限</span></div>
        </div>
        <form id="key">
            <?php foreach ($func as $f): ?>
            <div class="list">
                <div class="list_label">
                    <?=$f['func_name']?>:</div>
                <div class="list_content">
                    <div class="list_box">
                        <input type="checkbox" data-key="export" data-func="<?=$f['key']?>" name="<?=$f['key']?>:export" value="export"><span>查看</span>
                    </div>
                    <?php foreach ($f['auth'] as $a): ?>
                    <div class="list_box">
                        <input type="checkbox" data-key="<?=$a['key']?>" data-func="<?=$f['key']?>" name="<?=$f['key']?>:<?=$a['key']?>" value="<?=$a['key']?>"><span><?=$a['auth_name']?></span>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
            <?php endforeach;?>
        </form>
        <div class="list">
            <button type="button" class="blue" id="save">保存</button>
            <button type="button" class="blue" id="close">关闭</button>
        </div>
    </div>
</div>
<script type="text/javascript" src="/resources/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/resources/jQuery-File-Upload/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="/resources/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
<script type="text/javascript">
    $(function() {
        $('#upload_btn').fileupload({
            dataType: 'json',
            url: "<?=base_url('admin/staff/uploadImage')?>",
            done: function(e, data) {
                if(data.result.result !='SUCCESS'){
                    parent.$.warn(data.result.msg);
                }
                $("input[name='icon']").val(data.result.url);
                let html = `
                    <img  src="${data.result.url}" width='100px' height='100px' />
                `;
                $('.img-box').html(html);
            }
        });
        $("#auth").click(function() {
            $('.key_bg,.key_box').show();
        })
        $(".key_bg,#close").click(function() {
            $('.key_bg,.key_box').hide();
        })
        $("#save").click(function() {
            var data = $('#key').serializeArray();
            if (data.length <= 0) {
                parent.$.warn("请选择权限");
                return;
            }
            var tmp = {};
            $.each(data, function(k, v) {
                var func = v.name.replace(':' + v.value, '');
                if (!tmp[func]) {
                    tmp[func] = [];
                }
                tmp[func].push(v.value);
            })
            var val = JSON.stringify(tmp);
            $("input[name='screen_auth']").val(val);
            $('.key_bg,.key_box').hide();
        })
        <?php if ($action == 'add'): ?>
        $("select[name='parent']").val(<?=$pid?>).trigger('change');
        <?php endif;?>
    })
    const editObj = new edit();
    editObj.saveurl = 'admin/menu/edit/<id>/edit';
    <?php if ($action != 'add'): ?>
    editObj.setForm($("#edit_form"), <?=json_encode($data)?>);
    editObj.choseBox = choseBox;

    function choseBox() {
        $.each(JSON.parse(this.saveData.screen_auth), function(k, v) {
            $.each(v, function(s, d) {
                $("input[name='" + k + ":" + d + "']").attr('checked', true);
            })
        })
        if(this.saveData.icon !=''){
            let html = `
                    <img  src="${this.saveData.icon}" width='100px' height='100px' />
                `;
            $('.img-box').html(html);
        }
    }
    editObj.choseBox();
    <?php endif;?>
</script>
</body>
</html>