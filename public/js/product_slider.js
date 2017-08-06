/**
 * Created by palad on 29.07.2017.
 */
function selectItemColor() {
    $('#select_text_color').html($(this, '.option_text').html());
}

function selectItemSize() {
    $('#select_text_size').html($(this, '.option_text').html());
}

function lightItem() {
    $('.menu_item_dropdown').css({
        color: 'black',
        backgroundColor: 'white'
    });
    $(this).css({
        color: 'black',
        backgroundColor: '#EEEEEE'
    });
}

function toBasket() {
    if ($('#form_product_btn_add').css("background-color") == "rgb(60, 179, 113)") {
        var url = "/cart/";
        $(location).attr('href',url);
        return;
    }
    else {
        $product = $("#form_product_price").text();
        $product = $product.replace(" руб.", "").trim();

        if ($("#select_text_color").text().trim() == "Цвет..."){
            $color = "Цвет...";
        }
        else {
            $color = $("#select_text_color .color_code")[0].value;
        }

        $quantity = $("#user_quantity").val();
        if ($quantity == 0) {
            $('#user_quantity').css({"border-color": "#F08080"});
            return;
        }
        else
        {
            $('#user_quantity').css({"border-color": "#000000"});
        }

        $.post('/cart/add', {
            "product": $("#product_id").val(),
            "price": $product,
            "quantity": $("#user_quantity").val(),
            "color": $color,
            "size": $("#select_text_size").text().trim()
        }, function(data) {
            //console.log(data);
            $('#form_product_btn_add').css({"background-color": "#3CB371"});
            $('#form_product_btn_text').text('Go to the Cart');
        });
    }
}

//При загрузке страницы
$(document).ready(function () {
    var $slides = $('.slide');
    var $btnLeft = $('#slider_prev');
    var $btnRight = $('#slider_next');
    var ACTIVE = 'active';
    var ACTIVE_DOT = '.' + ACTIVE;
    var SLIDE_TIME = 1000;

    $slides.not(ACTIVE_DOT).hide();

    $btnLeft.on('click', function () {
        if($slides.filter(ACTIVE_DOT).prev().hasClass('slide')){
            $slides.filter(ACTIVE_DOT)
                .removeClass(ACTIVE)
                //.slideUp(SLIDE_TIME)
                .animate({width: 'toggle'}, 0)
                .prev()
                .addClass(ACTIVE)
                //.slideDown(SLIDE_TIME);
                .animate({width: 'toggle'}, 0)
        } else {
            console.log('No slides');
        }
    });

    $btnRight.on('click', function () {
        if($slides.filter(ACTIVE_DOT).next().hasClass('slide')){
            $slides.filter(ACTIVE_DOT)
                .removeClass(ACTIVE)
                //.slideUp(SLIDE_TIME)
                .animate({width: 'toggle'}, 0)
                .next()
                .addClass(ACTIVE)
                //.slideDown(SLIDE_TIME);
                .animate({width: 'toggle'}, 0)
        } else {
            console.log('No slides');
        }
    });

    $('.menu_item_dropdown_color').on('click', selectItemColor);
    $('.menu_item_dropdown_size').on('click', selectItemSize);
    $('.menu_item_dropdown').hover(lightItem);
    $('#form_product_btn_add').on('click', toBasket);
})