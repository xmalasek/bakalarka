
var map, newUser, users, mapquest, firstLoad;

firstLoad = true;

//users = new L.FeatureGroup();
users = new L.MarkerClusterGroup({spiderfyOnMaxZoom: true, showCoverageOnHover: false, zoomToBoundsOnClick: true});
newUser = new L.LayerGroup();

mapquest = new L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
});

map = new L.Map('map', {
    center: new L.LatLng(49.316735, 16.483175),
    zoom: 15,
    layers: [mapquest, users, newUser]
});

// GeoLocation Control
function geoLocate() {
    map.locate({setView: true, maxZoom: 17});
}
var geolocControl = new L.control({
    position: 'topright'
});
geolocControl.onAdd = function (map) {
    var div = L.DomUtil.create('div', 'leaflet-control-zoom leaflet-control');
    div.innerHTML = '<a class="leaflet-control-geoloc" href="#" onclick="geoLocate(); return false;" title="My location"></a>';
    return div;
};

map.addControl(geolocControl);
map.addControl(new L.Control.Scale());

//map.locate({setView: true, maxZoom: 3});

$(document).ready(function() {
    $.ajaxSetup({cache:false});
    $('#map').css('height', ($(window).height() - 50));
    // getUsers(); //TODO odkomentovat
});


$(window).resize(function () {
    $('#map').css('height', ($(window).height() - 50));
}).resize();


function geoLocate() {
    map.locate({setView: true, maxZoom: 17});
}

function initRegistration() {
    map.addEventListener('click', onMapClick);
    $('#map').css('cursor', 'crosshair');
    return false;
}

function cancelRegistration() {
    newUser.clearLayers();
    $('#map').css('cursor', '');
    map.removeEventListener('click', onMapClick);
}

function getUsers() {
    $.getJSON("get_users.php", function (data) {
        for (var i = 0; i < data.length; i++) {
            var location = new L.LatLng(data[i].lat, data[i].lng);
            var name = data[i].name;
            var website = data[i].website;
            if (data[i].website.length > 7) {
                var title = "<div style='font-size: 18px; color: #0078A8;'><a href='"+ data[i].website +"' target='_blank'>"+ data[i].name + "</a></div>";
            }
            else {
                var title = "<div style='font-size: 18px; color: #0078A8;'>"+ data[i].name +"</div>";
            }
            if (data[i].city.length > 0) {
                var city = "<div style='font-size: 14px;'>"+ data[i].city +"</div>";
            }
            else {
                var city = "";
            }
            var marker = new L.Marker(location, {
                title: name
            });
            marker.bindPopup("<div style='text-align: center; margin-left: auto; margin-right: auto;'>"+ title + city +"</div>", {maxWidth: '400'});
            users.addLayer(marker);
        }
    }).complete(function() {
        if (firstLoad == true) {
            map.fitBounds(users.getBounds());
            firstLoad = false;
        };
    });
}

function onMapClick(e) {
    var markerLocation = new L.LatLng(e.latlng.lat, e.latlng.lng);
    var marker = new L.Marker(markerLocation);
    newUser.clearLayers();
    newUser.addLayer(marker);
    var form =  '<form id="inputform" enctype="multipart/form-data" class="well">'+
        '<label><strong>Název:</strong> <i></i></label>'+
        '<input type="text" class="span3" placeholder="Název" id="name" name="name" />'+
        '<label><strong>Typ:</strong> <i></i></label>'+
        '<input type="text" class="span3" placeholder="Typ" id="email" name="email" />'+
        '<label><strong>Označení:</strong></label>'+
        '<input type="text" class="span3" placeholder="Označení" id="city" name="city" />'+
        '<label><strong>Popis:</strong></label>'+
        '<input type="text" class="span3" placeholder="Popis" id="website" name="website" value="" />'+
        '<input style="display: none;" type="text" id="lat" name="lat" value="'+e.latlng.lat.toFixed(6)+'" />'+
        '<input style="display: none;" type="text" id="lng" name="lng" value="'+e.latlng.lng.toFixed(6)+'" /><br><br>'+
        '<div class="row-fluid">'+
        '<div class="span6" style="text-align:center;"><button type="button" class="btn" onclick="cancelRegistration()">Storno</button></div>'+
        '<div class="span6" style="text-align:center;"><button type="button" class="btn btn-primary" onclick="insertUser()">Odeslat</button></div>'+
        '</div>'+
        '</form>';
    marker.bindPopup(form).openPopup();
}



















/*

var popup = L.popup();


var lat = 49.313967;
var lng = 16.476821;

var marker = L.marker([lat,lng]).addTo(map)
    .bindPopup("Zde bydlím"
    ).openPopup();

function geoLocate() {
    map.locate({setView: true, maxZoom: 17});
}
var geolocControl = new L.control({
    position: 'topright'
});
geolocControl.onAdd = function (map) {
    var div = L.DomUtil.create('div', 'leaflet-control-zoom leaflet-control');
    div.innerHTML = '<a class="leaflet-control-geoloc" href="#" onclick="geoLocate(); return false;" title="My location"></a>';
    return div;
};

*/



