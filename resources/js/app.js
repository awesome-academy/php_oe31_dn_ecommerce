$(document).ready(function () {
    var fullUrl = $('meta[name=fullUrl]').attr("content");
    var baseUrl = $('meta[name=baseUrl]').attr("content");

    $('.filter-form').on('change', function () {
       var value = $(this).val();
       if (value !== "") {
           var urlRedirect = baseUrl + "/products/filter/" + value;
           window.location.href = urlRedirect;
       }
    });

    $('.filter-form-category').on('change', function () {
        var value = $(this).val();
        if (fullUrl.includes('filter')) {
            fullUrl = fullUrl.substring(0, fullUrl.indexOf('filter') - 1);
        }
        if (value !== "") {
            var urlRedirect = fullUrl + "/filter/" + value;
            window.location.href = urlRedirect;
        }
    });

    //fix height content css
    var windowHeight = $(window).height();
    var headerHeight = $('header').height();
    var contentHeight = $('.container.my-4').height();
    var footerHeight = $('footer').height();

    if ((headerHeight + contentHeight + footerHeight) < windowHeight) {
        $('html').addClass('h-100');
        $('body').addClass('h-100');
        $('.container.my-4').css('height', '77%');
    }

    //fix content input
    var name = $('#name').val();
    var email = $('#email').val();
    var phone = $('#phone').val();
    var address = $('#address').val();
    var birthdate = $('#birthdate').val();

    $('#name').val(name.trim(name));
    $('#email').val(email.trim(email));
    $('#phone').val(phone.trim(phone));
    $('#address').val(address.trim(address));
    $('#birthdate').val(birthdate.trim(birthdate));
});
