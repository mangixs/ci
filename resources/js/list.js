class list {
    constructor(seting) {
        this.requiring = false;
        this.data_key = 'data';
        this.data = null;
        this.model_set = 'flush';
        this.ready = false;
        this.timeout = null;
        this.searchBox = null;
        this.searchType = 'JSON';
        this.successReturn = null;
        this.errorReturn = null;
        this.pageObj = null;
        this.selectObj = null;
        this.condition = {};
        this.baseCondition = {};
        this.config(seting);
    }
    config(config) {
        if (typeof(config) !== 'object') {
            alert('设置未定义');
            return;
        }
        if (typeof(config.box) !== 'object' && config.box.length !== 1) {
            alert('数去显示区未定义');
            return;
        }
        if (typeof(config.url) !== 'string') {
            alert('数据获取地址未定义');
            return;
        }
        if (typeof(config.tpl) !== 'string' && $('#' + config.tpl.length !== 1)) {
            alert('数据渲染地址未定义');
            return;
        }
        this.url = __base_url + config.url;
        this.box = config.box;
        this.tpl = config.tpl;
        this.ready = true;
        this.debug = typeof(config.debug) === 'boolean' ? config.debug : false;
        this.searchType = typeof(config.searchType) === 'string' ? config.searchType : 'JSON';
    }
    get_data() {
        if (this.requiring == true && !this.ready) {
            return;
        }
        this.requiring = true;
        $.extend(this.suc_callback.prototype, {
            dataObj: this
        })
        let data = this.getCondition();
        let config = {
            url: encodeURI(this.url),
            data: data,
            success: this.suc_callback.bind(this),
            error: this.err_callback.bind(this),
        }
        let ajax = $.ajax(config);
    }
    suc_callback(res, xhr) {
        this.requiring = false;
        if (this.debug) {
            console.log(res);
        }
        if (typeof(res[this.data_key]) === 'undefined') {
            parent.$.err('未能获取到有效数据');
            return;
        }
        this.handle(res[this.data_key]);
        if (this.pageObj) {
            this.pageObj.update(res.page);
        }
    }
    err_callback() {
        this.requiring = false;
        parent.$.err("获取数据错误！");
    }
    handle(datas) {
        let tpl = this.tpl;
        let box = this.box;
        let self = this;
        switch (this.model_set) {
            case 'after':
                $.each(datas, (k, v) => {
                    v = self.dataBeforeHandle(v);
                    box.append(template.render(tpl, v));
                });
                break;
            case 'before':
                $.each(datas, (k, v) => {
                    v = self.dataBeforeHandle(v);
                    box.prepend(template.render(tpl, v));
                });
                break;
            case 'flush':
            default:
                box.html('');
                $.each(datas, (k, v) => {
                    v = self.dataBeforeHandle(v);
                    box.append(template.render(tpl, v));
                });
                break;
        }
        if (typeof(this.successReturn) === 'function') {
            this.successReturn(datas);
        }
    }
    dataBeforeHandle(v) {
        return v;
    }
    getCondition() {
        let arr = [];
        for (let k in this.baseCondition) {
            arr.push(k + '=' + this.baseCondition[k]);
        }
        for (let k in this.condition) {
            arr.push(k + '=' + this.condition[k]);
        }
        return arr.join('&');
    }
    setCondition(set) {
        if (typeof(set) === 'object') {
            for (let k in set) {
                this.condition[k] = set[k];
            }
        }
        return this;
    }
    resetCondition() {
        this.condition = {};
        return this;
    }
    setPage(obj) {
        this.pageObj = obj;
        obj.dataObj = this;
        return this;
    }
    model(set) {
        if (set) {
            this.model_set = set;
        }
        return this;
    }
    first() {
        if (this.pageObj) {
            this.pageObj.change(1);
        }
        return this;
    }
    setDebug() {
        this.debug = true;
        return this;
    }
    setSearch(box, act) {
        if (box.length === 0) {
            return;
        }
        this.searchBox = box;
        if (act) {
            box.find("input[type='text'][name]").keyup(this.searchStart.bind(this));
            box.find("select[name]").change(this.searchStart.bind(this));
        }
        box.find('button').click(this.handleSearch.bind(this));
    }
    searchStart() {
        clearInterval(this.timeout);
        this.timeout = setTimeout(this.handleSearch.bind(this), 1000);
    }
    handleSearch() {
        let set = this.searchBox.serializeArray();
        switch (this.searchType) {
            case 'JSON':
            case 'json':
                let arrs = {};
                for (let k in set) {
                    arrs[set[k].name] = set[k].value;
                }
                let str = JSON.stringify(arrs);
                this.setCondition({
                    search: str
                });
                break;
            case 'GET':
            case 'get':
                let arr = {};
                for (let k in set) {
                    arr[set[k].name] = set[k].value;
                }
                this.setCondition(arr);
                break;
        }
        this.first();
    }
    setBaseCondition(set) {
        if (typeof(set) === 'object') {
            for (let k in set) {
                this.baseCondition[k] = set[k];
            }
        }
        return this;
    }
    removeBaseCondition(k) {
        if (this.baseCondition.hasOwnProperty(k)) {
            delete this.baseCondition[k];
        }
    }
    removeCondition(k) {
        if (this.condition.hasOwnProperty(k)) {
            delete this.condition[k];
        }
    }
    screenData() {
        this.handle(res[this.data_key]);
        if (this.pageObj) {
            this.pageObj.update(res.page);
        }
    }
}