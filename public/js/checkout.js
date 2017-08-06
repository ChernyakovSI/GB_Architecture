/**
 * Created by palad on 29.07.2017.
 */
function createOrder() {

    $.post('create', function(data) {
        var url = "/person/";
        $(location).attr('href',url);
    });
}

//При загрузке страницы
$(document).ready(function () {
    $elem = $('#btn_continue');
    console.log($elem);
    $($elem).on('click', createOrder);
})