<!DOCTYPE html>
<html>
<head>
  <title>Geographic Criminal Information System Time</title>
  <link rel="stylesheet" href="batang.css">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="stylesheet" href="css/leaflet.css"><link rel="stylesheet" href="css/L.Control.Locate.min.css">
        <link rel="stylesheet" href="css/qgis2webbatang.css"><link rel="stylesheet" href="css/fontawesome-all.min.css">
        <link rel="stylesheet" href="css/leaflet-search.css">
        <link rel="stylesheet" href="css/leaflet-control-geocoder.Geocoder.css">
        <link rel="stylesheet" href="css/fontawesome-all.min.css">
        <link rel="stylesheet" href="batang.css">
        <style>
        #map {
            width: 600px;
            height: 400px;
        }
        
      </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
  <!-- header -->

  <header>
    <header class="sub-header">
      <div class="logo">
        <img src="css/images/krimsus.png" alt="Logo">
      </div>
      <div class="title">
        <h1>DIREKTORAT RESERSE KRIMINAL KHUSUS<br>
          POLDA JAWA TENGAH</h1>
    
    <div class="home">
      <a href="../home/index.html">
        <img src="css/images/home.png" alt="Home">
      </a>
        </div>
        <div class="chart">
      <a href="../detail.php">
                        <img src="css/images/detail.png" alt="Detail">
                      </a>
                 </div>  
      </div>
    </div>
  </header>

  <!-- body -->

  <main>
    <div class="arrow">
      <a href="../jatengkota/index.html">
        <img src="css/images/arrow.png" alt="Arrow">
      </a>
    </div>
    <div class="map-container">
      <h2>Peta Kriminalis Tahun 2023</h2>
      <div id="map">
        <script src="js/qgis2web_expressions.js"></script>
        <script src="js/leaflet.js"></script><script src="js/L.Control.Locate.min.js"></script>
        <script src="js/multi-style-layer.js"></script>
        <script src="js/leaflet.rotatedMarker.js"></script>
        <script src="js/leaflet.pattern.js"></script>
        <script src="js/leaflet-hash.js"></script>
        <script src="js/Autolinker.min.js"></script>
        <script src="js/rbush.min.js"></script>
        <script src="js/labelgun.min.js"></script>
        <script src="js/labels.js"></script>
        <script src="js/leaflet-control-geocoder.Geocoder.js"></script>
        <script src="js/leaflet-search.js"></script>
        <script src="data/ADM_KOTAKAB_2021_0.js"></script>
        <script>


function filterhighlight(layer,nama){
	var highlightlayer=layer;
	for (i in nama){
	if (nama.includes(layer.feature.properties['WADMKK'])) {
	        if (layer.feature.geometry.type === 'LineString') {
        	    highlightlayer.setStyle({
                	color: '#f0000',
        	    });
	        } else {
        	    highlightlayer.setStyle({
                fillColor: '#ffff00',
                fillOpacity: 1
	            });
	        }
	} else{
//		if (layer.feature.geometry.type === 'LineString') {
                    for (i in layer._eventParents) {
                        layer._eventParents[i].resetStyle(layer);
                    }


//	}
	}

}
}
        var highlightLayer;
        function highlightFeature(e) {
            highlightLayer = e.target;

            if (e.target.feature.geometry.type === 'LineString') {
              highlightLayer.setStyle({
                color: '#ffff00',
              });
            } else {
              highlightLayer.setStyle({
                fillColor: '#ffff00',
                fillOpacity: 1
              });
            }
        }

        var map = L.map('map', {
            zoomControl:true, maxZoom:28, minZoom:1
        }).fitBounds([[-8.273966397349906,108.2929080079117],[-5.663210136649983,111.95433447108864]]);
        var hash = new L.Hash(map);
        map.attributionControl.setPrefix('<a href="https://github.com/tomchadwin/qgis2web" target="_blank"></a>  <a href="https://leafletjs.com" title="A JS library for interactive maps"></a>  <a href="https://qgis.org"></a>')
        var autolinker = new Autolinker({truncate: {length: 30, location: 'smart'}});
        L.control.locate({locateOptions: {maxZoom: 19}}).addTo(map);
        var bounds_group = new L.featureGroup([]);
        function setBounds() {
        }
        function pop_ADM_KOTAKAB_2021_0(feature, layer) {
            layer.on({
                mouseout: function(e) {
                    for (i in e.target._eventParents) {
                        e.target._eventParents[i].resetStyle(e.target);
                    }
                },
                mouseover: highlightFeature,
            });
            var popupContent = '<table>\
                    <tr>\
                        <td colspan="2"><strong>KOTA / KABUPATEN</strong><br />' + (feature.properties['WADMKK'] !== null ? autolinker.link(feature.properties['WADMKK'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2"><strong>PROVINSI</strong><br />' + (feature.properties['WADMPR'] !== null ? autolinker.link(feature.properties['WADMPR'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                    <tr>\
                        <td colspan="2"><a href="/jatengkota/'+ (feature.properties['WADMKK'] !== null ? autolinker.link(feature.properties['WADMKK'].toLocaleString()) : '') +'"><strong>Details</strong></a><br /></td>\
                    </tr>\
                </table>';
            layer.bindPopup(popupContent, {maxHeight: 400});
        }

        function style_ADM_KOTAKAB_2021_0_0() {
            return {
                pane: 'pane_ADM_KOTAKAB_2021_0',
                interactive: true,
            }
        }
        function style_ADM_KOTAKAB_2021_0_1() {
            return {
                pane: 'pane_ADM_KOTAKAB_2021_0',
                opacity: 1,
                color: 'rgba(0,0,0,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0,
                fillOpacity: 0,
                interactive: true,
            }
        }
        map.createPane('pane_ADM_KOTAKAB_2021_0');
        map.getPane('pane_ADM_KOTAKAB_2021_0').style.zIndex = 400;
        map.getPane('pane_ADM_KOTAKAB_2021_0').style['mix-blend-mode'] = 'normal';
        var layer_ADM_KOTAKAB_2021_0 = new L.geoJson.multiStyle(json_ADM_KOTAKAB_2021_0, {
            attribution: '',
            interactive: true,
            dataVar: 'json_ADM_KOTAKAB_2021_0',
            layerName: 'layer_ADM_KOTAKAB_2021_0',
            pane: 'pane_ADM_KOTAKAB_2021_0',
            onEachFeature: pop_ADM_KOTAKAB_2021_0,
            styles: [style_ADM_KOTAKAB_2021_0_0,style_ADM_KOTAKAB_2021_0_1,]
        });
        bounds_group.addLayer(layer_ADM_KOTAKAB_2021_0);
        map.addLayer(layer_ADM_KOTAKAB_2021_0);
        var osmGeocoder = new L.Control.Geocoder({
            collapsed: true,
            position: 'topleft',
            text: 'Search',
            title: 'Testing'
        }).addTo(map);
        document.getElementsByClassName('leaflet-control-geocoder-icon')[0]
        .className += ' fa fa-search';
        document.getElementsByClassName('leaflet-control-geocoder-icon')[0]
        .title += 'Search for a place';
        setBounds();
        var i = 0;
        layer_ADM_KOTAKAB_2021_0.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['WADMKK'] !== null?String('<div style="color: #323232; font-size: 10pt; font-weight: bold; font-family: \'Times New Roman\', sans-serif;">' + layer.feature.properties['WADMKK']) + '</div>':''), {permanent: true, offset: [-0, -16], className: 'css_ADM_KOTAKAB_2021_0'});
            labels.push(layer);
            totalMarkers += 1;
              layer.added = true;
              addLabel(layer, i);
              i++;
        });
        map.addControl(new L.Control.Search({
            layer: layer_ADM_KOTAKAB_2021_0,
            initial: false,
            hideMarkerOnCollapse: true,
            propertyName: 'WADMKK'}));
        document.getElementsByClassName('search-button')[0].className +=
         ' fa fa-binoculars';
        resetLabels([layer_ADM_KOTAKAB_2021_0]);
        map.on("zoomend", function(){
            resetLabels([layer_ADM_KOTAKAB_2021_0]);
        });
        map.on("layeradd", function(){
            resetLabels([layer_ADM_KOTAKAB_2021_0]);
        });
        map.on("layerremove", function(){
            resetLabels([layer_ADM_KOTAKAB_2021_0]);
        });
        </script>
      </div>
      </main>

    <div class="chart-container">
      <div class="title">
        <strong>Berdasarkan Waktu</strong>
      </div>
      <p id='demo'></p>
<!-- diagram batang -->
      <div class="chart">
      <a href="../detail.php">
                        <img src="css/images/detail.png" alt="Detail">
                      </a>
                 </div>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<canvas id="myChart" style="width:30%;max-width:500px;"></canvas>
<script>
$(document).ready(function() {
            $.ajax({
                url: 'jumlahkasus.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var JANUARI = response.JANUARI;
                    var FEBRUARI = response.FEBRUARI;
                    var MARET = response.MARET;
                    var APRIL = response.APRIL;
                    var MEI = response.MEI;
			              var JUNI = response.JUNI;
			              var JULI = response.JULI;
			              var AGUSTUS = response.AGUSTUS;
			              var SEPTEMBER = response.SEPTEMBER;
			              var OKTOBER = response.OKTOBER;
			              var NOVEMBER = response.NOVEMBER;
			              var DESEMBER = response.DESEMBER;

  var xValues = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember",""];
  var yValues = [JANUARI,FEBRUARI,MARET,APRIL,MEI,JUNI,JULI,AGUSTUS,SEPTEMBER,OKTOBER,NOVEMBER,DESEMBER,0];
//var yValues = [3,3,3,3,3,3,3,3,3,3,3]
  var barColors = ["blue", "blue","blue","blue","blue", "blue", "blue", "blue", "blue", "blue", "blue", "blue"];

var myChart = new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: { display: false },
    title: {
      display: true
    },
onClick: function(e, elements) {
    if (elements && elements.length > 0) {
      var clickedElement = elements[0];
      if (clickedElement) {
        var clickedIndex = clickedElement._index;
        var clickedLabel = xValues[clickedIndex];
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	    // Handle the response from the PHP script if needed
		var response = this.responseText;
		    var parser = new DOMParser();
		    var doc = parser.parseFromString(response, "text/html");
		    var paragraphs = doc.querySelectorAll("p");
		    var filterkota;
			filterkota=[];
//    var paragraphContent = "";

    // Iterate over each <p> tag and concatenate their content
		    for (var i = 0; i < paragraphs.length; i++) {
		      paragraphContent = paragraphs[i].innerHTML.split(" - ")[0];
    
			filterkota.push(paragraphContent);}
    // Display the concatenated content
		    layer_ADM_KOTAKAB_2021_0.eachLayer(function(layer) {
		    filterhighlight(layer, filterkota);
        var filterpopupContent = '<table>\
                    <tr>\
                        <td colspan="2"><strong>KOTA / KABUPATEN</strong><br />' + (layer.feature.properties['WADMKK'] !== null ? autolinker.link(layer.feature.properties['WADMKK'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2"><strong>PROVINSI</strong><br />' + (layer.feature.properties['WADMPR'] !== null ? autolinker.link(layer.feature.properties['WADMPR'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2"><a href="/jatengkota/'+ (filterkota.includes(layer.feature.properties['WADMKK']) ? autolinker.link(layer.feature.properties['WADMKK'].toLocaleString()+"?subdit="+clickedLabel) :autolinker.link(layer.feature.properties['WADMKK'].toLocaleString()) ) +'"><strong>Details</strong></a><br /></td>\
                    </tr>\
                </table>';
            layer.bindPopup(filterpopupContent, {maxHeight: 400}).closePopup();
			});
//    document.getElementById("demo").innerHTML += filterkota;
		  }

	};
	xhttp.open("GET", "filter_script.php?filterValue=" + clickedLabel, true);
	xhttp.send();


}}}}

  });




},error: function(xhr, status, error) {
                    console.log(error);
                }
});        
});

          </script>


  <footer>
    <h3>
        <a href="../loginPage/loginpage.html" style="color: white;">add admin </a>
        &copy; Copyright 2023-Developed by intern SMKN 7 Semarang
    </h3>
  </footer>
</body>
</html>