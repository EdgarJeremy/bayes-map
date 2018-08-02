var map;
var mapAdd;

function initMap() {
    var centerManado = { lat: 1.4834423, lng: 124.8378349 };
    var style = [{ "featureType": "landscape.natural", "elementType": "geometry.fill", "stylers": [{ "visibility": "on" }, { "color": "#e0efef" }] }, { "featureType": "poi", "elementType": "geometry.fill", "stylers": [{ "visibility": "on" }, { "hue": "#1900ff" }, { "color": "#c0e8e8" }] }, { "featureType": "road", "elementType": "geometry", "stylers": [{ "lightness": 100 }, { "visibility": "simplified" }] }, { "featureType": "road", "elementType": "labels", "stylers": [{ "visibility": "off" }] }, { "featureType": "transit.line", "elementType": "geometry", "stylers": [{ "visibility": "on" }, { "lightness": 700 }] }, { "featureType": "water", "elementType": "all", "stylers": [{ "color": "#65a4d7" }] }];
    map = new GMaps({
        div: '#map',
        center: centerManado,
        disableDefaultUI: true
    });
    map.setOptions({
        styles: style
    });
    var $editLatitude = $('#editLatitude');
    var $editLongitude = $('#editLongitude');
    var marker = map.addMarker({
        lat: centerManado.lat,
        lng: centerManado.lng,
        draggable: true,
        dragend: function (event) {
            var latLng = event.latLng;
            $editLatitude.val(latLng.lat());
            $editLongitude.val(latLng.lng());
        },
        title: 'Lokasi tempat wisata'
    });

    var $latitude = $('#latitude');
    var $longitude = $('#longitude');
    $latitude.val(centerManado.lat);
    $longitude.val(centerManado.lng);

    mapAdd = new GMaps({
        div: '#map-add',
        center: { lat: 1.4834423, lng: 124.8378349 },
        disableDefaultUI: true
    });
    mapAdd.setOptions({
        styles: style
    });
    mapAdd.addMarker({
        lat: centerManado.lat,
        lng: centerManado.lng,
        draggable: true,
        dragend: function (event) {
            var latLng = event.latLng;
            $latitude.val(latLng.lat());
            $longitude.val(latLng.lng());
        },
        title: 'Lokasi tempat wisata'
    });

    var $editBtn = $('.edit-btn');
    var $editPreview = $('#preview');
    var $editOverlay = $('#preview #overlay');

    $editBtn.on('click', function (e) {
        var id_tempat = $(this).data().id;
        $editOverlay.hide();
        $editBtn.removeClass('btn-success').addClass('btn-primary');
        $(this).removeClass('btn-primary').addClass('btn-success');
        fetch('../apis/tempat.php?id_tempat=' + id_tempat).then(function (response) { return response.json() })
            .then(function (data) {
                var latLng = new google.maps.LatLng(parseFloat(data.latitude), parseFloat(data.longitude));
                $editPreview.find('input[name="nama"]').val(data.nama);
                $editPreview.find('textarea[name="deskripsi"]').val(data.deskripsi);
                $editPreview.find('input[name="id_tempat"]').val(data.id_tempat);
                $editPreview.find('input[name="latitude"]').val(data.latitude);
                $editPreview.find('input[name="longitude"]').val(data.longitude);
                marker.setPosition(latLng);
                map.setCenter(parseFloat(data.latitude), parseFloat(data.longitude));
            }).catch(function (err) { alert(err.toString()) });
    });

    var $cancelEdit = $('.cancel-edit');

    $cancelEdit.on('click', function (e) {
        var latLng = new google.maps.LatLng(centerManado.lat, centerManado.lng);
        $editOverlay.show();
        $editPreview.find('input[name="nama"]').val('');
        $editPreview.find('textarea[name="deskripsi"]').val('');
        $editPreview.find('input[name="id_tempat"]').val('');
        $editPreview.find('input[name="latitude"]').val('');
        $editPreview.find('input[name="longitude"]').val('');
        marker.setPosition(latLng);
        map.setCenter(centerManado.lat, centerManado.lng);
        $editBtn.removeClass('btn-success').addClass('btn-primary');
    });

    var $deleteBtn = $('.delete-btn');
    $deleteBtn.on('click', function (e) {
        var confirmed = confirm('Anda yakin ingin menghapus tempat?');
        if (confirmed) {
            return true;
        } else {
            e.preventDefault();
            return false;
        }
    });

    var $ticketBtn = $('.ticket-btn');
    $ticketBtn.on('click', function (e) {
        var $ticketModal = $('#ticketModal');
        var data = $(this).data().data;
        $ticketModal.modal('show');
        $ticketModal.find('input#id_tempat').val(data.id_tempat);
        $ticketModal.find('input#nama').val(data.nama);
        $ticketModal.find('textarea#deskripsi').val(data.deskripsi);
    });

    var $showMore = $('.show-more');
    $showMore.on('click', function(){
        var real = $(this).data().real;
        swal({
            text: real
        });
    });

    initChart();
}

function initChart() {

    fetch('../apis/chart_bar_tempat.php', { credentials: 'include' }).then(function(response) { return response.json() })
        .then(function(data){
            /** Bar chart */
            Highcharts.chart('bar-chart', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Statistik kunjungan tempat wisata anda'
                },
                subtitle: {
                    text: 'Hasil chart adalah hitungan keseluruhan tiket yang terjual'
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