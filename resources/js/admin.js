$(document).ready(function () {
    function deleteConfirmItem(message) {
        return confirm(message);
    }

    $('.lock-user').on('click', function (event) {
        return confirm($('meta[name="confirmActiveUser"]').attr('content'));
    });

    $('.active-user').on('click', function (event) {
        return confirm($('meta[name="confirmActiveUser"]').attr('content'));
    });

    $('.delete-category').on('click', function (event) {
        return confirm($('meta[name="confirmDeleteCate"]').attr('content'));
    });

    $('.delete-product').on('click', function (event) {
        return confirm($('meta[name="confirmDeleteProduct"]').attr('content'));
    });

    $('.delete-order').on('click', function (event) {
        return confirm($('meta[name="confirmDeleteOrder"]').attr('content'));
    });

    $('.order-change-pending').on('click', function (event) {
        return confirm($('meta[name="confirmOrderPending"]').attr('content'));
    });

    $('.order-change-success').on('click', function (event) {
        return confirm($('meta[name="confirmOrderSuccess"]').attr('content'));
    });

    $('.order-change-cancel').on('click', function (event) {
        return confirm($('meta[name="confirmOrderCancel"]').attr('content'));
    });

    $('.delete-suggest').on('click', function (event) {
        return confirm($('meta[name="confirmDeleteSuggest"]').attr('content'));
    });

    $('.delete-comment').on('click', function (event) {
        return confirm($('meta[name="confirmDeleteComment"]').attr('content'));
    });

    $('.active-comment').on('click', function (event) {
        return confirm($('meta[name="confirmActiveComment"]').attr('content'));
    });

    $('.lock-comment').on('click', function (event) {
        return confirm($('meta[name="confirmLockComment"]').attr('content'));
    });

    //get and handle data
    //handleData is a function
    function statistic(handleData) {
        $.ajax({
            url: "admin/statistic",
            type: 'GET',
            contentType: 'application/json;charset=UTF-8',
            dataType: "json",
            async: true,
            success: function (response) {
                handleData(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
        return false;
    }
    Chart.defaults.global.defaultFontSize = 15;
    Chart.defaults.global.defaultFontColor = '#777';
    //call ajax to drwal chart
    statistic(function (data) {
        let myChart = document.getElementById('canvasUserSta').getContext('2d');
        // Global Options
        let massPopChart = new Chart(myChart, {
            type: 'bar',
            data: {
                labels: data.data_created_at,
                datasets: [{
                    label: 'VND',
                    data: data.data_price,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(255, 99, 132, 0.6)'
                    ],
                    borderWidth: 1,
                    borderColor: '#777',
                    hoverBorderWidth: 3,
                    hoverBorderColor: '#000'
                }]
            },
            options: {
                title: {
                    display: true,
                    text: data['title'],
                    fontSize: 25
                },
                legend: {
                    display: false,
                },
                layout: {
                    padding: {
                        left: 50,
                        right: 0,
                        bottom: 0,
                        top: 0
                    }
                },
                tooltips: {
                    enabled: true
                }
            }
        });
    });

    //order notify
    var baseUrl = $('meta[name="baseUrl"]').attr('content');
    var ordered = $('meta[name="orderedTrans"]').attr('content');
    var notifications   = $('.notifications');
    var notificationsCount  = parseInt($('#count-notification').text());
    var notificationDropdown  = notifications.find('.dropdown-notifications');
    Pusher.logToConsole = true;

    var pusherAppKey = $('meta[name="pusherAppKey"]').attr('content');
    var pusherAppCluster = $('meta[name="pusherCluster"]').attr('content');
    var pusher = new Pusher(pusherAppKey, {
        cluster: pusherAppCluster,
        encrypted: true,
    });

    var channel = pusher.subscribe('OrderNotify');
    channel.bind('send-message', function(data) {
        var existingNotifications = notificationDropdown.html();
        var newNotificationHtml =
            `<a target="_blank" href="` + baseUrl + `/admin/orders/` + data.id
            + `" class="dropdown-item">` + data.user + " " + ordered
            + ` - ` + data.created_at + `</a>`;
        notificationDropdown.append(newNotificationHtml);
        notificationsCount += 1;
        $('#count-notification').text(notificationsCount);
    });
});
