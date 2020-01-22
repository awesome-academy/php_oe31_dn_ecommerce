$(document).ready(function () {
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

    //call ajax to drwal chart
    statistic(function (data) {
        let myChart = document.getElementById('canvasUserSta').getContext('2d');
        // Global Options
        Chart.defaults.global.defaultFontSize = 18;
        Chart.defaults.global.defaultFontColor = '#777';
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
});
