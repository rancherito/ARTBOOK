jQuery.fn.searchBox2 = function () {
    let el = this;
    let input = $(`<input type="text" placeholder="INGRESE PALABRA CLAVE">`);
    let DATA = [];
    let btn_active = null
    this.addClass('searchBox2');
    this.append(input, '<i class="fa fa-search"></i>');
    this.searchBox2_dropdown = $(`<div id="${this.attr('id')}-dropdown" class="searchBox2-dropdown-content" style="display: none"></div>`);
    $(document.body).append(this.searchBox2_dropdown);

    function voidData() {
        if (DATA.length === 0) el.searchBox2_dropdown.empty().append('<a class="searchBox2-option-void">SIN RESULTADOS</a>');
    }

    input.focusin(function () {
        if (input.val().length) el.searchBox2_dropdown.show();
        else el.searchBox2_dropdown.hide();
        input.select();
        voidData();
        updatePosition();
    });
    input.keyup(e=>{
        el.searchBox2_dropdown.css('display', input.val().length ? 'block' : 'none')
        voidData()
    });
    let updatePosition = function () {
        let pos = el[0].getBoundingClientRect();
        el.searchBox2_dropdown.css({ top: pos.top + el.outerHeight() - 3, left: pos.left });
        el.searchBox2_dropdown.outerWidth(el.outerWidth())
    }

    this.searchBox2_keyup = function (fun) {
        if (typeof fun === 'function') {
            input.keyup(function (e) {
                if (e.keyCode != 13) fun(input);
            });
        }
		return this
    }
	this.searchBox2_onwrite = function (fun) {
        if (typeof fun === 'function') {
            input.keyup(function (e) {
                if (e.keyCode != 13) fun(input.val(), input.val().length);
            });
			input.change(function (e) {
                fun(input.val(), input.val().length);
            });
        }
		return this
    }
    this.searchBox2_focus = () => {
        input.focusin();
    }
    this.searchBox2_input = function () { return input }
    this.searchBox2_onselect = function (fun) {
        let mif = function (btn) {
            if (btn_active) btn_active.removeClass('searchBox2_option_active')
            btn.addClass('searchBox2_option_active')
            btn_active = btn;
            if (typeof fun === 'function') fun({value: btn.attr('value'), text: btn.text()});
            el.searchBox2_dropdown.hide();
        }
        el.searchBox2_dropdown.on('click', 'a.searchBox2-option', function () {
            mif($(this))
        });
        input.keyup(function (e) {
            if (DATA.length && e.keyCode == 13) mif($(el.searchBox2_dropdown.find('a.searchBox2-option')[0]))
        })
		return this
    }
    this.searchBox2_placeholder = d => { input.attr('placeholder', d) }
    this.searchBox2_data = data => {

        if (JSON.stringify(data) !== JSON.stringify(DATA)) {
            DATA = [];
            this.searchBox2_dropdown.empty();

            if (data.length) {
                DATA = data;
                DATA.forEach(it => {
                    if (typeof it['value'] != 'undefined' && typeof it['text'] != 'undefined') {
                        this.searchBox2_dropdown.append($(`<a class="searchBox2-option" value="${it['value']}" href="#">${it['text']}</a>`));
                    }
                });
            }
            voidData();
        }
    }
    this.searchBox2_dataClear = () => { this.searchBox2_dropdown.empty(); }

    $(window)
        .scroll(updatePosition)
        .resize(updatePosition)
        .click( e => {
            const ele = e.target
            if (ele !== input[0]) el.searchBox2_dropdown.hide();
        });
    this.searchBox2_dropdown.click( e => {
        e.stopPropagation();
    })
    return this; // This is needed so other functions can keep chaining off of this
};
