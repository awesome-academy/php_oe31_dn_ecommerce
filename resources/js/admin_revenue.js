import { convertVnd } from "./function_support";

$(document).ready(function () {

    $('#filter-revenue').on('click', function () {
        var year = $('#revenue-year').val();
        var month = $('#revenue-month').val();
        if (year == '') {
            alert($('meta[name="requiredSelectYear"]').attr('content'));
        }
        else {
            var url = "revenue/time?year=" + year;
            if (month != '') {
                url += "&month=" + month;
            }
        }
        statisticFilter(url);
    });

    function statisticFilter(url) {
        $.ajax({
            url: url,
            type: 'GET',
            contentType: 'application/json;charset=UTF-8',
            dataType: "json",
            async: true,
            success: function (response) {
                if (response.item.length == 0) {
                    var message = $('meta[name="noRevenue"]').attr('content');
                    alert(message);
                }
                drawChart(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
        return false;
    }

    statisticFilter("revenue/current-month");
    function drawChart(data) {
        let chartRevenue = document.getElementById('canvasRevenueCurrentMonth').getContext('2d');
        if (window.bar_revenue !== undefined) {
            window.bar_revenue.destroy();
        }
        window.bar_revenue = new Chart(chartRevenue, {
            type: 'line',
            data: {
                labels: data.item,
                datasets: [{
                    data: data.money,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                    ],
                    borderWidth: 1,
                    borderColor: '#777',
                    hoverBorderWidth: 3,
                    hoverBorderColor: '#000',
                    pointRadius: 8,
                    pointHoverRadius: 5,
                    lineTension: 0.25,
                }]
            },
            options: {
                animation: {
                    duration: 2000,
                },
                title: {
                    display: true,
                    fontSize: 25,
                    text: data.title,
                },
                tooltips: {
                    enabled: true,
                    callbacks: {
                        label: function (data) {
                            return convertVnd(data.value, "");
                        }
                    },

                },
                scales: {
                    yAxes: [{
                        ticks: {
                            callback: function (value) {
                                return convertVnd(value, "");
                            }
                        },
                    }],
                },
                bezierCurve : false,
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
            }
        });
    }
});
