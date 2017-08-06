/**
 * Created by palad on 29.07.2017.
 */
function logout() {

    $.post('/login/', { "disconnect": "1"}, function(data) {
        window.location.reload();
    });
}

function toPerson() {
    var url = "/person/";
    $(location).removeAttr("href");
    $(location).attr('href',url);
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

//При загрузке страницы
$(document).ready(function () {
    $('#logout').on('click', logout);
    $('.menu_item_dropdown').hover(lightItem);
    $('#account_txt').on('click', toPerson);
})