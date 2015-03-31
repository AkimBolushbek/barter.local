$(document).ready(function () {

    $('.reed-full').click(function () {
        var t = $(this).text();
        if ($(this).text() == 'Прочитать отзыв полностью') {
            $(this).text($(this).attr('data-text')).attr('data-text', t);
            $(this).parent().find('.desc').css('display', 'none');
            $(this).parent().find('.hidden_text').css('display', 'block');
        } else {
            $(this).text($(this).attr('data-text')).attr('data-text', t);
            $(this).parent().find('.desc').css('display', 'block');
            $(this).parent().find('.hidden_text').css('display', 'none');
        }
        return false;
    });

    $(document).scroll(function () {
        if ($(document).scrollTop() >= 97) {
            $(".main-menu").addClass("fix-menu");
        } else {
            $(".main-menu").removeClass("fix-menu");
        }
    });

    $('.partners').bxSlider({
        useCSS: false,
        auto: true,
        pager: false,
        controls: true,
        minSlides: 6,
        maxSlides: 6,
        slideWidth: 150,
        slideMargin: 15
    });


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

});
