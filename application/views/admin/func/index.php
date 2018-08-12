<extend name="Public/list" />
<block name="content">
    <div class="head container-fluid">
        <div class="row">
            <span class="title"><?=$title?></span>
            <?php if (in_array('add', $key['auth_key'])): ?>
            <button type="button" class="btn btn-success btn-right" onclick="parent.adminObj.add('/admin/func/add','添加功能')">添加</button>
            <?php endif;?>
        </div>
    </div>
    <div class="content container-fluid">
        <div class="search-box">
            <form class="form-inline" id="search_form">
                <div class="row">
                    <div class="form-group">
                        <label for="exampleInputName2">键值</label>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="请输入键值" name="like:key">
                    </div>
                </div>
            </form>
        </div>
        <div class="data-show">
            <table class="table table-bordered">
                <thead>
                    <tr class="active">
                        <th>键值</th>
                        <th>键名</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody id="data_box">

                </tbody>
            </table>
        </div>
        <div class="page_box container-fluid"></div>
        <script type="text/html" id="data_tpl">
            <tr>
                <td>
                    <%= key %>
                </td>
                <td>
                    <%= func_name %>
                </td>
                <td>
                    <a href="javascript:parent.adminObj.edit('/admin/func/edit/<%=key%>/browse','查看');" class="list-btn browse"></a>
                    <?php if (in_array('edit', $key['auth_key'])): ?>
                    <a href="javascript:parent.adminObj.edit('/admin/func/edit/<%=key%>/edit','编辑功能');" class="list-btn edit"></a>
                    <?php endif;?>
                    <?php if (in_array('delete', $key['auth_key'])): ?>
                    <a href="javascript:parent.adminObj.deleteData('/admin/func/deleteData/<%=key%>');" class="list-btn del"></a>
                    <?php endif;?>
                    <?php if (in_array('edit', $key['auth_key'])): ?>
                    <a href="javascript:parent.adminObj.edit('/admin/func/setFunc/<%=key%>','编辑权限');" class="list-text">编辑权限</a>
                    <?php endif;?>
                </td>
            </tr>
        </script>
    </div>
</block>
<block name="js">
    <script type="text/javascript">
        var dataObj = new list({
            box: $('#data_box'),
            url: '/admin/func/pageData',
            tpl: 'data_tpl'
        });
        const pageObj = new page($('.page_box'));
        dataObj.setPage(pageObj);
        dataObj.setSearch($("#search_form"), true);
        dataObj.get_data();
    </script>
</block>