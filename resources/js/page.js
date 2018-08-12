class page {
    constructor(box) {
        this.page = 1;
        this.every_set = [10, 25, 50, 100];
        this.every = this.every_set[0];
        this.box = box;
        this.dataObj = null;
        this.init();
    }
    init() {
        let box = this.box;
        if (box.length === 0) {
            return;
        }
        let html = `
			<div class="data_show">
				显示第<span id="data_start"></span>
				至<span id="data_end"></span>项结果，
				共<span id="data_count"></span>项
			</div>
		`;
        box.append(html);
        box.append('<div class="page_show"></div>');
        let eveBox = $('<div class="every_show"><span>每页:</span></div>');
        let eveSel = $("<select></select>");
        for (let i = 0; i < this.every_set.length; i++) {
            eveSel.append('<option value="' + this.every_set[i] + '">' + this.every_set[i] + '</option>');
        }
        eveSel.change(function(evt) {
            let self = typeof(evt.target) === 'object' ? $(evt.target) : $(evt.srcElement);
            this.every = self.val();
            this.change(1);
        }.bind(this));
        eveBox.append(eveSel);
        box.append(eveBox);
    }
    set() {
        return {
            page: this.page,
            every: this.every
        };
    }
    update(page) {
        if (this.page > 1 && this.page > page.page_count) {
            this.change(page.page_count);
            return;
        }
        let start = page.count_all === 0 ? 0 : (page.page - 1) * page.every + 1;
        $("#data_start").html(start);
        let end = page.page * page.every;
        let es = end < page.count_all ? end : page.count_all;
        $("#data_end").html(es);
        $("#data_count").html(page.count_all);
        let num = parseInt(page.page);
        let pcou = parseInt(page.page_count);
        let s = (num - 3) > 1 ? (num - 3) : 1;
        let ov = pcou - (num + 3);
        if (ov < 0) {
            s += ov;
            if (s < 1) {
                s = 1;
            }
        }
        let arr = [];
        let i = 0;
        do {
            arr.push(s);
            i++;
            s++;
        } while (i < 7 && s <= pcou);
        let show = $('.page_show');
        show.html('');
        if (num > 1) {
            show.append('<button onclick="pageObj.change(1)"><<</button>');
            show.append('<button onclick="pageObj.change(' + (num - 1) + ')"><</button>');
        }
        for (i = 0; i < arr.length; i++) {
            let but = $('<button onclick="pageObj.change(' + arr[i] + ')">' + arr[i] + '</button>');
            if (arr[i] == num) {
                but.addClass('active');
            }
            show.append(but);
        }
        if (num < pcou) {
            show.append('<button onclick="pageObj.change(' + (num + 1) + ')">></button>');
            show.append('<button onclick="pageObj.change(' + pcou + ')">>></button>');
        }
    }
    change(page, model) {
        if (typeof(page) === 'number') {
            this.page = page;
        }
        dataObj.setCondition({
            page: this.page,
            every: this.every
        }).model(model).get_data();
    }
}