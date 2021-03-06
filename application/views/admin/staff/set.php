<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>设置职位</title>
    <style type="text/css">
        * {
            font-family: "Microsoft YaHei";
            margin: 0;
            padding: 0;
        }

        .box {
            padding-top: 20px;
        }

        .row {
            width: 100%;
            height: 30px;
            line-height: 30px;
            font-size: 14px;
        }

        .label {
            width: 40%;
            text-align: right;
            float: left;
            position: relative;
            height: inherit;
        }

        .label input {
            position: absolute;
            top: 8px;
            right: 15px;
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        .content {
            float: left;
            height: inherit;
            width: 59%;
        }
    </style>
    <script type="text/javascript" src="/resources/js/jquery-3.0.0.min.js"></script>
    <script type="text/javascript">
        $(function() {
            let staff_id = <?=$staff_id?>;
            $(".job").click(function() {
                let self = $(this);
                let val = self.val();
                let set = self.is(':checked');
                let data = 'staff_id=' + staff_id + '&job_id=' + val + '&set=' + set;
                var config = {
                    url: "/admin/staff/jobSave",
                    data: data,
                    type: 'post',
                    success: function(res) {
                        parent.$.suc(res.msg);
                    },
                }
                $.ajax(config);
            })
        })
    </script>
</head>

<body>
    <div class="box">
        <?php foreach ($data as $v): ?>
        <div class="row">
            <div class="label">
                <input type="checkbox" class="job" value="<?=$v['id']?>" <?php if (in_array($v['id'], $has)): ?> checked="checked"
                <?php endif;?> >
            </div>
            <div class="content">
                <span><?=$v['job_name']?></span>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</body>

</html>