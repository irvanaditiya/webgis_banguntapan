<html>
<head>

<title>WEBGIS BANGUNTAPAN</title>
<h1>Website Kecamatan Banguntapan</h1>
<!--sisipkan kode pemuatan disini -->
<link rel="stylesheet" href="leaflet/leaflet.css"/>
<script src="leaflet/leaflet.js"></script>

<link rel="stylesheet" href="leaflet/leaflet.groupedlayercontrol.css"/>
<script src="leaflet/leaflet.groupedlayercontrol.js"></script>

<link rel="stylesheet" href="leaflet/leaflet-compass-master/src/leaflet-compass.css" />
<script src="leaflet/leaflet-compass-master/src/leaflet-compass.js"></script>

<link rel="stylesheet" href="leaflet/Leaflet-Legend-master/src/leaflet.legend.css" />
<script type="text/javascript" src="leaflet/Leaflet-Legend-master/src/leaflet.legend.js"></script>

<link rel="stylesheet" href="leaflet/Leaflet-MousePosition-master/src/L.Control.MousePosition.css" />
<script src="leaflet/Leaflet-MousePosition-master/src/L.Control.MousePosition.js"></script>

<script type="text/javascript" src="leaflet/leaflet.ajax.min.js"></script>

</head>
<body>
<!-- peta akan ditampilkan disini -->
<div style="height:600px" id="mapid"></div>
</body>

<style>
h1 {
	text-align: center;
	color: orange;
}
.legend {
    line-height: 18px;
    color: #555;
}
.legend i {
    width: 18px;
    height: 18px;
    float: left;
    margin-right: 8px;
    opacity: 0.7;
}
</style>

<script>
var mymap = L.map('mapid').setView([-7.8217469,110.4167568], 13);

var GoogleMaps = new L.TileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
opacity: 1.0, attribution: 'WEBGIS Banguntapan by Muhammad Irvan Aditiya'
}).addTo(mymap);
var GoogleSatelliteHybrid = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
maxZoom: 22,
attribution: 'WEBGIS Banguntapan by Muhammad Irvan Aditiya'
});

var baseLayers = {
'Google Satellite Hybrid': GoogleSatelliteHybrid,
'Google Maps': GoogleMaps,
};

L.control.groupedLayers(baseLayers).addTo(mymap);

function popUp(f,l){
    var out = [];
    if (f.properties){
        for(key in f.properties){
            out.push(key+": "+f.properties[key]);
        }
        l.bindPopup(out.join("<br />"));
    }
}
var jsonmap = L.geoJson.ajax("http://localhost/latihan3/GeoJson.php",{onEachFeature: popUp }
).addTo(mymap);

var jsontoko = L.geoJson.ajax("http://localhost/latihan3/GeoJson_toko.php",{onEachFeature: popUp }
).addTo(mymap);

<!--Skala Bar -->
L.control.scale().addTo(mymap);

<!--Orientasi Arah Mata Angin -->
mymap.addControl( new L.Control.Compass() );

<!--Mouse Position -->
L.control.mousePosition({
	position: "bottomright",
	prefix: "Koordinat Geografis"
}).addTo(mymap);

//mendefinisikan style dari polygon
    var PolygonStyle = {
        fillColor: '#FFCC33',
        weight: 2,
        opacity: 1,
        color: 'gray',
        dashArray: '3',
        fillOpacity: 0.7
    };
 //menambahkan style pada saat load GeoJson
  var URL = "http://localhost/latihan3/GeoJson.php"; 
  var jsonmap = L.geoJson.ajax(URL,
    {onEachFeature: popUp,
     style: PolygonStyle
    }).addTo(mymap);

function getColor(d) {
    return d > 90 ? '#330000' :
           d > 80 ? '#800026' :
           d > 70 ? '#BD0026' :
           d > 60 ? '#E31A1C' :
           d > 50 ? '#FC4E2A' :
           d > 40 ? '#FD8D3C' :
           d > 30 ? '#FEB24C' :
           d > 20 ? '#FED976' :
           d > 10 ? '#FFEDA0' :
                    '#FFFFFF';
	}

function pilihstyle(feature) {
    return {
        fillColor: getColor(feature.properties.Populasi),
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7 
	};
}

  var URL = "http://localhost/latihan3/GeoJson.php"; 
  var jsonmap = L.geoJson.ajax(URL,
    {onEachFeature: popUp,
     style: pilihstyle
    }).addTo(mymap);

var legend = L.control({position: 'bottomright'});

legend.onAdd = function (map) {

    var div = L.DomUtil.create('div', 'info legend'),
        grades = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90],
        labels = [];

    
    for (var i = 0; i < grades.length; i++) {
        div.innerHTML +=
            '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
            grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
    }

    return div;
};

legend.addTo(mymap);


</script>
</html>
