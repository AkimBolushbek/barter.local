
$(window).load(function () {
    $('.flexslider').flexslider({
        animation: "slide",
        start: function (slider) {
            $('#window').css({'display': 'none', 'left': 0});
            $('body').removeClass('loading');
        }
    });
});

$(document).ready(function () {

    var divs = $('ul.rotate-1 > li'),
            k = 0,
            cntInGroup = 2; // по сколько элементов в группе

    divs.each(function (i) {
        if (i % cntInGroup == 0) {
            k++;
        }
        $(this).addClass('tmp-1' + k);
    });
    for (i = 1; i <= divs.length + 1 / cntInGroup; i++) {
        $('.tmp-1' + i).wrapAll('<div class="slide" style="width: 100px; height: 100%; float: left;"></div>');
    }

    var divs2 = $('ul.rotate-2 > li'),
            k = 0,
            cntInGroup = 2; // по сколько элементов в группе

    divs2.each(function (i) {
        if (i % cntInGroup == 0) {
            k++;
        }
        $(this).addClass('tmp-2' + k);
    });
    for (i = 1; i <= divs2.length + 1 / cntInGroup; i++) {
        $('.tmp-2' + i).wrapAll('<div class="slide" style="width: 100px; height: 100%; float: left;"></div>');
    }

    $('.rotate-1').bxSlider({
        useCSS: true,
        //auto: true,
        pager: false,
        controls: true,
        minSlides: 3,
        maxSlides: 3,
        slideWidth: 98,
        slideMargin: 5,
        slideSelector: '.slide',
        infiniteLoop: false
    });

    $('.rotate-2').bxSlider({
        useCSS: true,
        //auto: true,
        pager: false,
        controls: true,
        minSlides: 3,
        maxSlides: 3,
        slideWidth: 98,
        slideMargin: 5,
        slideSelector: '.slide',
        infiniteLoop: false
    });

    $('.view_all').click(function () {
        $(this).parent().hide();
        $(this).parent().next().show();
        return false;
    });
    $('.show_all').click(function () {
        $(this).parent().prev().show();
        $(this).parent().hide();
        return false;
    });

    setTimeout(function () {
        $('#mBnSearch').attr('value', 'Отправить');
    }, 3000);

});
