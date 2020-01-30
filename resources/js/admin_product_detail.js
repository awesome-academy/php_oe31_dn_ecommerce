$(document).ready(function () {
    //fix content input
    var name = $('#name').val();
    var description = $('#description').val();
    var price = $('#price').val();
    var sale_price = $('#sale_price').val();
    var sale_percent = $('#sale_percent').val();

    $('#name').val(name.trim(name));
    $('#description').val(description.trim(description));
    $('#price').val(price.trim(price));
    $('#sale_price').val(sale_price.trim(sale_price));
    $('#sale_percent').val(sale_percent.trim(sale_percent));
});
