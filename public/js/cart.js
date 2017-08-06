/**
 * Created by palad on 29.07.2017.
 */
function editCart() {
    $cart_id = $(this).parent().siblings('.cart_position')[0].value;

    $wrap_price = $(this).parent().siblings('.unit_price')[0];
    $elem_price = $($wrap_price).children('.basket_price')[0];

    $wrap_total = $(this).parent().siblings('.subtotal')[0];
    $elem_total = $($wrap_total).children('.basket_subtotal')[0];

    $price = $($elem_price).text();
    $price = $price.replace(" руб.", "").trim();
    $total = $(this).val() * $price;
    $($elem_total).text($total + " руб.");

    refreshSum();

    $.post('/cart/edit', {
        "cart_id": $cart_id,
        "quantity": $(this).val()
    });
}

function refreshSum() {
    $totals = $('.basket_subtotal');

    $sum = 0;
    $.each($totals,function(index,value){
        $total = +$(value).text().replace(" руб.", "").trim();
        $sum += $total;
    });

    $("#subtotal_group_value").text($sum + " руб.");
    $("#grandtotal_group_value").text($sum + " руб.");
}

function deleteCart() {
    if (confirm("Вы подтверждаете удаление?")) {
        $cart_id = $(this).siblings('.cart_position')[0].value;

        $cart_str = $(this).parent();
        $line_str = $(this).parent().next('.line_separate');

        $($cart_str).remove();
        $($line_str).remove();

        refreshSum();

        $.post('/cart/delete', {
            "cart_id": $cart_id
        });

        return true;
    } else {
        return false;
    }
}

function clear() {
    if (confirm("Вы подтверждаете очищение корзины?")) {
        $cart_str = $('.basket_row');
        $line_str = [];
        $.each($cart_str,function(index,value){
            $line_str.push($(value).next('.line_separate'));
            $(value).remove();
        });

        $.each($line_str,function(index,value){
            $(value).remove();
        });

        refreshSum();

        $.post('/cart/clear');

        return true;
    } else {
        return false;
    }
}

function toCatolog() {
    var url = "../";
    $(location).attr('href',url);
}

function checkout() {
    var url = "../checkout/";
    $(location).attr('href',url);
}

//При загрузке страницы
$(document).ready(function () {
    $('.basket_quantity').on('change', editCart);
    $('.action').on('click', deleteCart);
    $('#basket_continue').on('click', toCatolog);
    $('#basket_clear').on('click', clear);
    $('#btn_procced_checkout').on('click', checkout);
})