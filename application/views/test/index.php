<!DOCTYPE html>
<html>

<head>
    <title>接口测试页面</title>
    <link rel="stylesheet" href="/resources/bootstrap/css/bootstrap.min.css">
    <style type="text/css">
        .row-height {
            height: 34px;
            line-height: 34px;
        }

        .result {
            min-height: 400px;
        }

        .intergarl {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">接口测试</h1>
        <div class="row">
            <div class="col-xs-9">
                <div class="form-group">
                    <label>url</label>
                    <input type="text" name="url" class="form-control" placeholder="url" value="http://">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <select class="form-control" name="type">
				<option value="get">get</option>
				<option value="post">post</option>
			</select>
            </div>
            <div class="col-xs-4">
                <button type="button" class="btn btn-success" onclick="testObj.add()">添加参数</button>
            </div>
            <div class="col-xs-4">
                <button type="button" class="btn btn-success" onclick="testObj.save()">提交</button>
            </div>
        </div>
        <div class="row row-height">
            <div class="col-xs-4">
                <span class="row-text">key</span>
            </div>
            <div class="col-xs-4">
                <span class="row-text">value</span>
            </div>
        </div>
        <div class="content">

        </div>
        <div class="result container">

        </div>
    </div>
    <script type="text/javascript" src="/resources/js/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" src="/resources/layer/layer.js"></script>
    <script type="text/javascript">
        class test {
            constructor() {
                this.index = 0;
            }
            add() {
                let html = `
			<div class="row intergarl" data-row="${this.index}">
				<div class="col-xs-4">
					<input type="text" class="form-control" data-key="${this.index}" placeholder="请输入key">
				</div>
				<div class="col-xs-4">
					<input type="text" class="form-control" data-value="${this.index}" placeholder="请输入value">
				</div>
				<div class="col-xs-4">
					<button type="button" class="btn btn-danger" onclick="testObj.deleteRow(${this.index})">删除</button>
				</div>
			</div>
		`;
                $(".content").append(html);
                this.index++;
            }
            deleteRow(id) {
                $("[data-row='" + id + "']").remove();
            }
            save() {
                let url = $("input[name='url']").val();
                if (url == '') {
                    layer.msg('请填写url');
                    return;
                }
                let data = {};
                if ($("[data-row]").length > 0) {
                    let tmp = false;
                    $("[data-row]").each(function() {
                        let index = $(this).attr('data-row');
                        let key = $("input[data-key='" + index + "']").val();
                        let value = $("input[data-value='" + index + "']").val();
                        if (key == '' || value == '') {
                            tmp = true;
                            return false;
                        }
                    })
                    $("[data-row]").each(function() {
                        let index = $(this).attr('data-row');
                        let key = $("input[data-key='" + index + "']").val();
                        let value = $("input[data-value='" + index + "']").val();
                        data[index] = {};
                        data[index].key = key;
                        data[index].value = value;
                    })
                }
                let type = $("select[name='type']").val();
                $.ajax({
                    url: "<?=base_url('test/save')?>",
                    type: 'post',
                    data: 'url=' + encodeURI(url) + '&type=' + type + '&data=' + JSON.stringify(data),
                    error: function(res) {
                        $(".result").html(res);
                    },
                    success: function(res) {
                        $(".result").html(res);
                    }
                })
            }
        }
        const testObj = new test();
    </script>
</body>

</html>
