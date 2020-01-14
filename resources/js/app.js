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
});
