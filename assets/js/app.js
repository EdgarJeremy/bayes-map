$(document).ready(function(){

    var centerManado = { lat: 1.4834423, lng: 124.8378349 };
    var map = new GMaps({
        div: '#map',
        center: centerManado,
        disableDefaultUI: true
    });
    map.setOptions({
        styles: [{ "featureType": "landscape.natural", "elementType": "geometry.fill", "stylers": [{ "visibility": "on" }, { "color": "#e0efef" }] }, { "featureType": "poi", "elementType": "geometry.fill", "stylers": [{ "visibility": "on" }, { "hue": "#1900ff" }, { "color": "#c0e8e8" }] }, { "featureType": "road", "elementType": "geometry", "stylers": [{ "lightness": 100 }, { "visibility": "simplified" }] }, { "featureType": "road", "elementType": "labels", "stylers": [{ "visibility": "off" }] }, { "featureType": "transit.line", "elementType": "geometry", "stylers": [{ "visibility": "on" }, { "lightness": 700 }] }, { "featureType": "water", "elementType": "all", "stylers": [{ "color": "#65a4d7" }] }]
    });

    var marker = map.addMarker({
        lat: centerManado.lat,
        lng: centerManado.lng,
        title: 'Lokasi tempat wisata'
    });
    marker.setVisible(false);

    initBarChart();

    var $btnTempat = $('.btn-tempat');
    $btnTempat.on('click', function(e){
        var data = $(this).data().data;
        $btnTempat.removeClass('active').find('p').css({'color': '#000'});
        $(this).addClass('active').find('p').css({'color': '#fff'});

        showLineChart(data.id_tempat);
        marker.setPosition(new google.maps.LatLng(parseFloat(data.latitude), parseFloat(data.longitude)));
        map.setCenter(parseFloat(data.latitude), parseFloat(data.longitude));
        e.preventDefault();
        return false;
    });

    var $layerChart = $('#layer-chart');
    var $layerChartCloseBtn = $('#layer-chart #close');
    $layerChartCloseBtn.on('click', closeLineChart);

    function initBarChart() {
        fetch('./apis/chart_bar_tempat.php?all', { credentials: 'include' }).then(function (response) { return response.json() })
            .then(function (data) {
                /** Bar chart */
                Highcharts.chart('bar-chart', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Statistik kunjungan tempat wisata'
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: 'Total tiket terjual'
                        }

                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y} tiket'
                            }
                        }
                    },

                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> tiket terjual<br/>'
                    },

                    series: [
                        {
                            name: "Tempat Wisata",
                            colorByPoint: true,
                            data: data
                        }
                    ]
                });
            });
    }

    function showLineChart(id_tempat) {
        $layerChart.show();
        marker.setVisible(true);
        fetch('./apis/chart_line_tempat.php?id_tempat=' + id_tempat).then(function(response){ return response.json()})
            .then(function(data){
                var series = [];
                for(var i = 0; i < data.length; i++) {
                    series.push([(new Date(data[i][0])).getTime(), data[i][1]]);
                }
                // Create the chart
                Highcharts.stockChart('line-chart', {
                    rangeSelector: {
                        selected: 0
                    },

                    title: {
                        text: 'Statistik pengunjung per hari'
                    },

                    series: [{
                        name: 'Tiket terjual',
                        data: series
                    }]
                });
            });
        
    }

    function closeLineChart() {
        $btnTempat.removeClass('active').find('p').css({'color': '#000'});
        $layerChart.hide();
        marker.setVisible(false);
        map.setCenter(parseFloat(centerManado.lat), parseFloat(centerManado.lng));
    }

});