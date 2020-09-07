$(function () {
    'use strict';

    $(document).on("pageInit", "#page-city-picker", function (e) {
        $("#city-picker").cityPicker({
            toolbarTemplate: '<header class="bar bar-nav">\
            <button class="button button-link pull-right close-picker">确定</button>\
            <h1 class="title">选择所在地址</h1>\
            </header>',
            date: '#date',//省输入框,一般都是隐藏的，获取身份ID
            city: '#city', //城市输入框，一般都是隐藏的，获取城市ID
			district: '#district' //城市输入框，一般都是隐藏的，获取城市ID
        });
    });

    $.init();
});
