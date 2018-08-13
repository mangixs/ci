$(function() {
    $(".parent-a").click(function() {
        let child = $(this).next();
        let arrow = $(this).children().filter('.arrow');
        if (child.is(":visible")) {
            child.slideUp();
        } else {
            child.slideDown();
        }
        if ($(this).hasClass('parent-bg')) {
            $(this).removeClass('parent-bg');
            arrow.css({
                'transform': 'rotate(-45deg)'
            });
        } else {
            $(this).addClass('parent-bg');
            arrow.css({
                'transform': 'rotate(45deg)'
            });
        }
    })
    $(".child-a").click(function() {
        $(".child-a").removeClass('parent-bg');
        $(this).addClass('parent-bg');
    })
    $(".server-a").click(function() {
        $(".server-a").removeClass('parent-bg');
        $(this).addClass('parent-bg');
    })
})
class admin {
    constructor() {
        this.mainIfmWin = null;
    }
    add(url, title) {
        if (url == '' && typeof(url) != 'string') {
            $.warn('网址不正确');
            return;
        }
        if (title == '' && typeof(title) != 'string') {
            $.warn('标题错误');
            return;
        }
        let height = $(window).height() * 0.95 + 'px';
        let width = $(window).width() * 0.7 + 'px';
        layer.open({
            type: 2,
            title: title,
            content: url,
            area: [width, height],
            shadeClose: true,
        })
    }
    closePage() {
        layer.closeAll();
    }
    PageGetData() {
        let ifm = $("#list");
        this.mainIfmWin = (typeof(ifm[0].contentWindow) == 'object' ? ifm[0].contentWindow : ifm[0].window);
        this.mainIfmWin.dataObj.get_data();
    }
    edit(url, title) {
        if (url == '' && typeof(url) != 'string') {
            $.warn('网址不正确');
            return;
        }
        if (title == '' && typeof(title) != 'string') {
            $.warn('标题错误');
            return;
        }
        let height = $(window).height() * 0.95 + 'px';
        let width = $(window).width() * 0.7 + 'px';
        layer.open({
            type: 2,
            title: title,
            content: url,
            area: [width, height],
            shadeClose: true,
        })
    }
    deleteData(url) {
        if (url == '' && typeof(url) != 'string') {
            $.warn('网址不正确');
            return;
        }
        layer.alert('你确定删除该数据吗？', {
            icon: 0,
            title: '提示',
            btn: ['确定', '取消'],
            yes: function(index) {
                layer.close(index);
                $.ajax({
                    url: url,
                    type: 'get',
                    error: function() {
                        $.warn("服务器忙");
                    },
                    success: function(res) {
                        if (res.result == "SUCCESS") {
                            $.suc(res.msg);
                            this.PageGetData();
                        } else {
                            $.warn(res.msg);
                        }
                    }.bind(this)
                })
            }.bind(this)
        })
    }
}
var adminObj = new admin();