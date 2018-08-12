<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="renderer" content="webkit">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>后台主页</title>
     <link rel="stylesheet" type="text/css" href="/resources/css/home.css">
    <link rel="stylesheet" type="text/css" href="/resources/bootstrap/css/bootstrap.min.css">

</head>

<body>
    <div class="ccontent-box">
    <header class="container-fluid">
        <a class="brand" href="/admin/home/index">
            <img src="/resources/media/image/logo.png" alt="logo" />
        </a>
        <ul class="nav pull-right" style="margin-right: 50px;">
            <li class="dropdown user">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" id="userinfo">
                    <?php if (!empty($header_img)): ?>
                    <img class="head_img" src="<?=$header_img?>" />
                    <?php endif;?>
                    <span class="username"><?=$true_name?></span>
                    <i class="icon-angle-down"></i>
                </a>
                <ul class="dropdown-menu" style="min-width:120px;">
                    <li><a href="javascript:adminObj.edit('/admin/home/pwd','修改密码');"><i class="icon-user"></i>修改密码</a></li>
                    <li><a href="/admin/home/loginout"><i class="icon-key"></i>退出登录</a></li>
                </ul>
            </li>
        </ul>
    </header>
    <main>
        <div class="left">
            <?=$menu?>
        </div>
        <div class="content">
            <iframe src="/admin/home/welcome" id="list" name="list"></iframe>
        </div>
    </main>
</div>
    <script src="/resources/js/jquery-3.0.0.min.js" type="text/javascript"></script>
    <script src="/resources/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/resources/layer/layer.js" type="text/javascript"></script>
    <script src="/resources/js/jq_notice.js" type="text/javascript"></script>
    <script src="/resources/js/admin.js" type="text/javascript"></script>
</body>

</html>