<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="stylesheet" href="css/leaflet.css"><link rel="stylesheet" href="css/L.Control.Locate.min.css">
        <link rel="stylesheet" href="css/qgis2web.css"><link rel="stylesheet" href="css/fontawesome-all.min.css">
        <link rel="stylesheet" href="css/leaflet-search.css">
        <link rel="stylesheet" href="css/leaflet-control-geocoder.Geocoder.css">
        <link rel="stylesheet" href="css/fontawesome-all.min.css">
        <link rel="stylesheet" href="css/diagramlingkaran.css">
        <style>
        #map {
            width: 600px;
            height: 400px;
        }
        </style>
        <title>Information System for Types of Geographic Crimes</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>

        <!-- header -->
        <header class="header">
          <div class="container">
            <div class="logo">
                <img src="css/images/krimsus.png" alt="Logo">
            </div>
            <div class="title">
              <h1>DIREKTORAT RESERSE KRIMINAL KHUSUS POLDA JAWA TENGAH</h1>
            </div>
            <div class ="home">
            <a href="../index.php">
              <img src="css/images/home.png" alt="Home" width="50px">
            </a>
            </div>
          </div>
  </header>

<!-- body -->
<main>
  <div class="map-container">
  <h1><strong>Peta Kriminalis Tahun 2023</strong></h1> 
            <a href="../detail.php">
              <img src="css/images/detail.png" alt="Detail">
            </a>
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
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script>

function filterhighlight(layer,nama){
	var highlightlayer=layer;
    if (nama.includes(layer.feature.properties['WADMKK'])) {
            console.log(nama);
        	    highlightlayer.setStyle({
                color: 'black',
                fillColor: '#ffff00',
                fillOpacity: 1
	            });
	        
	} else{
                  for (i in layer._eventParents) {
                        layer._eventParents[i].resetStyle(layer);
	}}

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
                fillColor: '#3366CC',
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
                        e.target._eventParents[30].resetStyle(e.target);
                },
                mouseover: highlightFeature,
            });
            
            var popupContent = '<table>\
                    <tr>\
                        <td colspan="2"><strong>KOTA / KABUPATEN</strong><br />' + (layer.feature.properties['WADMKK'] !== null ? autolinker.link(layer.feature.properties['WADMKK'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2"><strong>PROVINSI</strong><br />' + (layer.feature.properties['WADMPR'] !== null ? autolinker.link(layer.feature.properties['WADMPR'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2"><a href="/jatengkota/'+ (layer.feature.properties['WADMKK'] !== null ? autolinker.link(layer.feature.properties['WADMKK'].toLocaleString()+"?subdit="+layer.feature.properties['WADMKK'].toLocaleString()+"&by=jenis") : '') +'"><strong>Details</strong></a><br /></td>\
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
      </div>
    <div class="chart-container">
    <a href="diagrambatang.php">
              <img src="css/images/arrow.png" alt="Arrow">
            </a>
      <div class="title">
        <strong>Berdasarkan Bidang Tindak Pidana</strong>
      </div>


        <!-- diagram lingkaran -->   
        <div style="width: 550px; height: 400px; margin: -530px 0 0 calc(100% - 750px);">
          <div id="piechart"></div>
        </div>
        
<p id="demo"></p>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  // Load google charts
$(document).ready(function() {
            $.ajax({
                url: 'jumlahkasus.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var INDAGSI = response.INDAGSI;
                    var EKSUS = response.EKSUS;
                    var TIPIDKOR = response.TIPIDKOR;
                    var TIPIDTER = response.TIPIDTER;
                    var SIBER = response.SIBER;
//                error: function(xhr, status, error) {
  //                  console.log(error);
    //            }
//});        
//});

  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  // Draw the chart and set the chart values
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Bidang Tindak Pidana', 'Jumlah Kasus'],
      ['INDAGSI', INDAGSI],
      ['EKSUS', EKSUS],
      ['TIPIDKOR', TIPIDKOR],
      ['TIPIDTER',TIPIDTER],
      ['SIBER', SIBER]
    ]);

    // Optional; add a title and set the width and height of the chart
    var options = {
      'width': 480,
      'height': 280,
      'chartArea': { 'width': '100%', 'height': '85%' },
      'backgroundColor': 'transparent',
      'legend': { 'position': 'bottom'}

    };
    function updateOptions() {
  if (window.matchMedia("(max-width: 600px)").matches) {
    options.chartArea.width = '170%';
    options.chartArea.height = '85%';
    options.legend.position = 'bottom';
  } else {
    options.chartArea.width = '100%';
    options.chartArea.height = '85%';
    options.legend.position = 'bottom';
  }
}

updateOptions(); // Panggil fungsi untuk pengecekan awal

window.addEventListener('resize', updateOptions);
    
    
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);

   google.visualization.events.addListener(chart, 'select', selectHandler);

    function selectHandler() {
      var selectedItem = chart.getSelection()[0];
      console.log(selectedItem.row);
      // if (selectedItem) {
        var value = data.getValue(selectedItem.row, 0);
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
    var response = this.responseText;
    var parser = new DOMParser();
    var doc = parser.parseFromString(response, "text/html");
    var paragraphs = doc.querySelectorAll("p");
    var filterkota;
	filterkota=[];
    for (var i = 0; i < paragraphs.length; i++) {
      paragraphContent = paragraphs[i].innerHTML.split(" - ")[0];
    
	filterkota.push(paragraphContent);}
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
                        <td colspan="2"><a href="/jatengkota/'+ (filterkota.includes(layer.feature.properties['WADMKK']) ? autolinker.link(layer.feature.properties['WADMKK'].toLocaleString()+"?subdit="+value) :autolinker.link(layer.feature.properties['WADMKK'].toLocaleString()+"?subdit="+layer.feature.properties['WADMKK'].toLocaleString()+"&by=jenis") ) +'"><strong>Details</strong></a><br /></td>\
                        </tr>\
                </table>';

            layer.bindPopup(filterpopupContent, {maxHeight: 400}).closePopup();
    
	});
//    document.getElementById("demo").innerHTML += filterkota;
  }

	};
	xhttp.open("GET", "filter_script.php?filterValue=" + value, true);
	xhttp.send();
  
//	document.getElementById("demo").innerHTML = this.responseText;
	// }
     }
 }
},error: function(xhr, status, error) {
                    console.log(error);
                }
});        
});

</script>
</div>
<br>  
<br>  
<br>  
<br>  
<br>
</main>
<!-- footer -->
<footer>
  <h3>
    <a href="/admin.php" class="inline-text">add admin</a> &copy; Copyright 2023-Developed by intern SMKN 7 Semarang
  </h3>
</footer>
</body>
</html>