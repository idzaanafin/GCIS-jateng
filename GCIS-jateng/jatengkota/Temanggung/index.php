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
        <link rel="stylesheet" href="css/kecamatan.css">
        <style>
        #map {
            width: 600px;
            height: 400px;
        }
        </style>
        <title>Information System for Types of Geographic Crimes</title>
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
            <?php
            $conn=mysqli_connect("localhost","root","123","Data");
            // Check connection
            if (mysqli_connect_errno())
            {
                    echo "Failed to connect to database";}
            $jenis = ["INDAGSI","EKSUS","TIPIDKOR","TIPIDTER","SIBER"];
            $bulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            $filter = $_GET['subdit'];
            if ($_GET['by'] == 'jenis' && $_GET['subdit'] == 'Temanggung') {
                echo '<a href="../index.php">
                            <img src="css/images/home.png" alt="Home" width="50px">
                         </a>';
            }elseif (in_array($_GET['subdit'],$jenis)) {
                echo '<a href="../index.php">
                            <img src="css/images/home.png" alt="Home" width="50px">
                         </a>';
            }elseif (($_GET['subdit'] == 'Temanggung' && $_GET['by'] == 'bulan')) {
                echo '<a href="../diagrambatang.php">
                            <img src="css/images/home.png" alt="Home" width="50px">
                        </a>';
            }elseif (in_array($_GET['subdit'],$bulan)) {  
                echo  '<a href="../diagrambatang.php">
                            <img src="css/images/home.png" alt="Home" width="50px">
                        </a>';
            }
            ?>
            </div>
    </div>
  </header>

<!-- body -->
<?php
                        $conn=mysqli_connect("localhost","root","123","Data");
                        // Check connection
                        if (mysqli_connect_errno())
                        {
                                echo "Failed to connect to database";}
                        $jenis = ["INDAGSI","EKSUS","TIPIDKOR","TIPIDTER","SIBER"];
                        $bulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
                        $filter = $_GET['subdit'];
                        // $jenis= $_GET['jenis'];
                        // echo $jenis;
                        if (in_array($filter,$jenis)){
                            $filter=$filter;

                           $result = mysqli_query($conn,"SELECT * FROM `Kasus` WHERE `Lokasi Kejadian` LIKE'Temanggung%' AND `Jenis Tindak Pidana` = '$filter'");    
                        }elseif (in_array($filter, $bulan)){
                            $monthName = $filter ; // Indonesian month name
		                    $filter =  array_search($monthName, $bulan) + 1;
                            $result = mysqli_query($conn,"SELECT * FROM `Kasus` WHERE `Lokasi Kejadian` LIKE'Temanggung%' AND `Waktu Kejadian`LIKE '%2023%$filter-%' ");
                        }else{
                            $result = mysqli_query($conn,"SELECT * FROM `Kasus` WHERE `Lokasi Kejadian` LIKE'Temanggung%'");
                        }
?>

<main>
    <div class="map-container">
    <h1><strong>Peta Kriminalis Kabupaten Temanggung</strong></h1>
        <a href="/detail.php">
              <img src="css/images/detail.png" alt="Detail">
        </a> 
        
        <div class="tabel1">
        <?php
        
        if (in_array($filter,$jenis)){
            if ($filter == 'INDAGSI'){
                    $bidang = 'Subdit I';
            }elseif ($filter == 'EKSUS'){
                    $bidang = 'Subdit II';
            }elseif ($filter == 'TIPIDKOR'){
                    $bidang = 'Subdit III';
            }elseif ($filter == 'TIPIDTER'){
                    $bidang = 'Subdit IV';
            }elseif ($filter == 'SIBER'){
                    $bidang = 'Subdit V';
            }
        }
        
        if (in_array($_GET['subdit'],$bulan)){echo "<h3>Bulan ". $_GET['subdit']. "</h3>";}
        elseif (in_array($_GET['subdit'],$jenis)) {echo "<h3>". $_GET['subdit']. " ( $bidang )</h3>";}
        elseif ($_GET['subdit']=='Temanggung' or ($_GET['subdit']=='Temanggung' and$_GET['by'] == 'jenis') or ($_GET['subdit']=='Temanggung' and$_GET['by'] == 'bulan') ) {echo '';}
        ?>


        <?php
        // bulan
        if (in_array($_GET['subdit'],$bulan) or ($_GET['subdit']=='Temanggung' and$_GET['by'] == 'bulan')){
        echo "<table>
          <thead>
            <tr>
                <th>No.</th>
                <th>INDAGSI</th>
                <th>EKSUS</th>
                <th>TIPIDKOR</th>
                <th>TIPIDTER</th>
                <th>SIBER</th>
            </tr>"; 
            if ($result->num_rows > 0) {
                // output data of each row
                $id=1;
                $subdit1 = [];
                $subdit2 = [];
                $subdit3 = [];
                $subdit4 = [];
                $subdit5 = [];
                
                $list = 0;
                while($row = $result->fetch_assoc()) {
                    if ($row["Jenis Tindak Pidana"] == 'INDAGSI'){
                        $subdit1[] =  $row["Nama Kasus"]. " - ". explode(' - ',$row["Lokasi Kejadian"])[1];
                      }elseif ($row["Jenis Tindak Pidana"] == 'EKSUS') {
                        $subdit2[] =  $row["Nama Kasus"]. " - ". explode(' - ',$row["Lokasi Kejadian"])[1];
                      }elseif ($row["Jenis Tindak Pidana"] == 'TIPIDKOR') {
                        $subdit3[] =  $row["Nama Kasus"]. " - ". explode(' - ',$row["Lokasi Kejadian"])[1];
                      }elseif ($row["Jenis Tindak Pidana"] == 'TIPIDTER') {
                        $subdit4[] =  $row["Nama Kasus"]. " - ". explode(' - ',$row["Lokasi Kejadian"])[1]; 
                      }elseif ($row["Jenis Tindak Pidana"] == 'SIBER') {
                        $subdit5[] =  $row["Nama Kasus"]. " - ". explode(' - ',$row["Lokasi Kejadian"])[1]; 
                      }
      //			echo  $row["ID"]. $row["Nama Kasus"].  $row["Jenis Tindak Pidana"].   $row["Waktu Kejadian"].  $row["Lokasi Kejadian"]. "<br>";
                      }
                      $jumlah = count($subdit1)+count($subdit2)+count($subdit3)+count($subdit4)+count($subdit5);
                      $baris = max([count($subdit1),count($subdit2),count($subdit3),count($subdit4),count($subdit5)]);
                      while($list < $baris) {
                           if ($subdit1[$list] != ''){$s1 =$subdit1[$list];} else {$s1 ='-';}
                           if ($subdit2[$list] != ''){$s2 =$subdit2[$list];} else {$s2 ='-';}
                           if ($subdit3[$list] != ''){$s3 =$subdit3[$list];} else {$s3 ='-';}
                           if ($subdit4[$list] != ''){$s4 =$subdit4[$list];} else {$s4 ='-';}
                           if ($subdit5[$list] != ''){$s5 =$subdit5[$list];} else {$s5 ='-';}
                          echo "<tr> <td>$id</td> <td>$s1</td> <td>$s2</td> <td>$s3</td> <td>$s4</td> <td>$s5</td> <tr>";
                          $list +=1;
                          $id+=1;
                      }
                      
                      
                }else{
                    $jumlah =0;
                }
                
                echo " 
                </thead>
                </table>
                <strong>
                <h4 style='color: white; margin-top: 10px; margin-bottom: 0;'>JUMLAH KASUS : $jumlah</h4>
                </strong>";
        }elseif (($_GET['by'] == 'jenis' and $_GET['subdit'] == 'Temanggung') or in_array($_GET['subdit'],$jenis)) {
        // jenis
        echo "<table>
          <thead>
            <tr>
                <th>No.</th>
                <th>Nama Kasus</th>
                <th>Kecamatan</th>
            </tr>";
            if ($result->num_rows > 0) {
                // output data of each row
                $id=1;
                while($row = $result->fetch_assoc()) {
                  echo "<tr>";
                           echo "<td>". $id. "</td>";
                          echo "<td>". $row["Nama Kasus"]. "</td>";
                          echo "<td>". explode(' - ',$row["Lokasi Kejadian"])[1]. "</td>";
                   echo"</tr>";
                  $id+=1;
      //			echo  $row["ID"]. $row["Nama Kasus"].  $row["Jenis Tindak Pidana"].   $row["Waktu Kejadian"].  $row["Lokasi Kejadian"]. "<br>";
                   }
                    $jumlah = $id-1;
                    if ($jumlah == -1){
                    $jumlah = 0;
                    }
                   }else{
                $jumlah=0;
            }
                   echo " 
                   </thead>
                   </table>
                   <strong>
                   <h4 style='color: white; margin-top: 10px; margin-bottom: 0;'>JUMLAH KASUS : $jumlah</h4>
                   </strong>";
                }
        else{
            // buat kosongsementara
            echo "<table>
            <thead>
            <th>No.</th>
                <th>Nama Kasus</th>
                <th>Kecamatan</th>";
            
          

		if ($result->num_rows > 0) {
		  // output data of each row
          $id=1;
		  while($row = $result->fetch_assoc()) {
	        echo "<tr>";
        	         echo "<td>". $id. "</td>";
           		 echo "<td>". $row["Nama Kasus"]. "</td>";
           		 echo "<td>". explode(' - ',$row["Lokasi Kejadian"])[1]. "</td>";
         	echo"</tr>";
            $id+=1;
//			echo  $row["ID"]. $row["Nama Kasus"].  $row["Jenis Tindak Pidana"].   $row["Waktu Kejadian"].  $row["Lokasi Kejadian"]. "<br>";
         	}
             $jumlah = $id-1;
             if ($jumlah == -1){
                 $jumlah = 0;
             }
             }else{
                $jumlah=0;
            }
             echo " 
             </thead>
             </table>
             <strong>
             <h4 style='color: white; margin-top: 10px; margin-bottom: 0;'>JUMLAH KASUS : $jumlah</h4>
             </strong>";
     
        }
			$conn->close();
          
?>        
      </div>
         
        <div id="map">
        </div>
        <script src="js/qgis2web_expressions.js"></script>
        <script src="js/leaflet.js"></script><script src="js/L.Control.Locate.min.js"></script>
        <script src="js/leaflet.rotatedMarker.js"></script>
        <script src="js/leaflet.pattern.js"></script>
        <script src="js/leaflet-hash.js"></script>
        <script src="js/Autolinker.min.js"></script>
        <script src="js/rbush.min.js"></script>
        <script src="js/labelgun.min.js"></script>
        <script src="js/labels.js"></script>
        <script src="js/leaflet-control-geocoder.Geocoder.js"></script>
        <script src="js/leaflet-search.js"></script>
        <script src="data/Batas_Kecamatan_BIG_0.js"></script>
        <script>
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
        }).fitBounds([[-7.412124584659297,109.89383067273447],[-7.069333370161358,110.37457444916451]]);
        var hash = new L.Hash(map);
        map.attributionControl.setPrefix('<a href="https://github.com/tomchadwin/qgis2web" target="_blank"></a> <a href="https://leafletjs.com" title="A JS library for interactive maps"></a> <a href="https://qgis.org"></a>');
        var autolinker = new Autolinker({truncate: {length: 30, location: 'smart'}});
        L.control.locate({locateOptions: {maxZoom: 19}}).addTo(map);
        var bounds_group = new L.featureGroup([]);
        function setBounds() {
        }
        function pop_Batas_Kecamatan_BIG_0(feature, layer) {
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
                        <td colspan="2"><strong>KECAMATAN</strong><br />' + (feature.properties['WADMKC'] !== null ? autolinker.link(feature.properties['WADMKC'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2"><strong>KABUPATEN</strong><br />' + (feature.properties['WADMKK'] !== null ? autolinker.link(feature.properties['WADMKK'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2"><strong>PROVINSI</strong><br />' + (feature.properties['WADMPR'] !== null ? autolinker.link(feature.properties['WADMPR'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
            layer.bindPopup(popupContent, {maxHeight: 400});
        }

        function style_Batas_Kecamatan_BIG_0_0(feature) {
            if (feature.properties['OBJECTID'] >= 585.000000 && feature.properties['OBJECTID'] <= 774.703704 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(215,25,28,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 774.703704 && feature.properties['OBJECTID'] <= 1121.814815 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(221,48,39,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1121.814815 && feature.properties['OBJECTID'] <= 1149.888889 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(227,71,49,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1149.888889 && feature.properties['OBJECTID'] <= 1233.481481 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(233,94,60,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1233.481481 && feature.properties['OBJECTID'] <= 1733.629630 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(238,117,70,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1733.629630 && feature.properties['OBJECTID'] <= 2189.333333 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(244,140,81,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2189.333333 && feature.properties['OBJECTID'] <= 2370.222222 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(250,163,92,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2370.222222 && feature.properties['OBJECTID'] <= 2422.925926 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(253,180,104,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2422.925926 && feature.properties['OBJECTID'] <= 2569.666667 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(253,193,119,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2569.666667 && feature.properties['OBJECTID'] <= 2638.629630 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(254,205,133,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2638.629630 && feature.properties['OBJECTID'] <= 2763.444444 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(254,218,148,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2763.444444 && feature.properties['OBJECTID'] <= 2934.000000 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(254,230,162,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2934.000000 && feature.properties['OBJECTID'] <= 3002.518519 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(255,243,177,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3002.518519 && feature.properties['OBJECTID'] <= 3591.851852 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(255,255,191,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3591.851852 && feature.properties['OBJECTID'] <= 4226.444444 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(242,250,187,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4226.444444 && feature.properties['OBJECTID'] <= 4414.407407 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(229,245,183,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4414.407407 && feature.properties['OBJECTID'] <= 4687.370370 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(216,239,179,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4687.370370 && feature.properties['OBJECTID'] <= 4820.666667 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(203,234,174,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4820.666667 && feature.properties['OBJECTID'] <= 5086.296296 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(190,229,170,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 5086.296296 && feature.properties['OBJECTID'] <= 5246.185185 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(177,224,166,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 5246.185185 && feature.properties['OBJECTID'] <= 5949.666667 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(161,214,166,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 5949.666667 && feature.properties['OBJECTID'] <= 6820.185185 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(141,200,169,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 6820.185185 && feature.properties['OBJECTID'] <= 6821.592593 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(122,186,172,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 6821.592593 && feature.properties['OBJECTID'] <= 6839.555556 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(102,173,176,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 6839.555556 && feature.properties['OBJECTID'] <= 6963.037037 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(82,159,179,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 6963.037037 && feature.properties['OBJECTID'] <= 7064.777778 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(63,145,183,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 7064.777778 && feature.properties['OBJECTID'] <= 7423.000000 ) {
                return {
                pane: 'pane_Batas_Kecamatan_BIG_0',
                opacity: 1,
                color: 'rgba(35,35,35,1.0)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight: 1.0, 
                fill: true,
                fillOpacity: 1,
                fillColor: 'rgba(43,131,186,1.0)',
                interactive: true,
            }
            }
        }
        map.createPane('pane_Batas_Kecamatan_BIG_0');
        map.getPane('pane_Batas_Kecamatan_BIG_0').style.zIndex = 400;
        map.getPane('pane_Batas_Kecamatan_BIG_0').style['mix-blend-mode'] = 'normal';
        var layer_Batas_Kecamatan_BIG_0 = new L.geoJson(json_Batas_Kecamatan_BIG_0, {
            attribution: '',
            interactive: true,
            dataVar: 'json_Batas_Kecamatan_BIG_0',
            layerName: 'layer_Batas_Kecamatan_BIG_0',
            pane: 'pane_Batas_Kecamatan_BIG_0',
            onEachFeature: pop_Batas_Kecamatan_BIG_0,
            style: style_Batas_Kecamatan_BIG_0_0,
        });
        bounds_group.addLayer(layer_Batas_Kecamatan_BIG_0);
        map.addLayer(layer_Batas_Kecamatan_BIG_0);
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
        layer_Batas_Kecamatan_BIG_0.eachLayer(function(layer) {
            var context = {
                feature: layer.feature,
                variables: {}
            };
            layer.bindTooltip((layer.feature.properties['WADMKC'] !== null?String('<div style="color: #323232; font-size: 10pt; font-weight: bold; font-family: \'Times New Roman\', sans-serif;">' + layer.feature.properties['WADMKC']) + '</div>':''), {permanent: true, offset: [-0, -16], className: 'css_Batas_Kecamatan_BIG_0'});
            labels.push(layer);
            totalMarkers += 1;
              layer.added = true;
              addLabel(layer, i);
              i++;
        });
        map.addControl(new L.Control.Search({
            layer: layer_Batas_Kecamatan_BIG_0,
            initial: false,
            hideMarkerOnCollapse: true,
            propertyName: 'WADMKC'}));
        document.getElementsByClassName('search-button')[0].className +=
         ' fa fa-binoculars';
        resetLabels([layer_Batas_Kecamatan_BIG_0]);
        map.on("zoomend", function(){
            resetLabels([layer_Batas_Kecamatan_BIG_0]);
        });
        map.on("layeradd", function(){
            resetLabels([layer_Batas_Kecamatan_BIG_0]);
        });
        map.on("layerremove", function(){
            resetLabels([layer_Batas_Kecamatan_BIG_0]);
        });
        </script>
        </div>
    </div>
<br>
<script>
   function filterhighlight(layer,nama){
	var highlightlayer=layer;
	for (i in nama){
	if (nama.includes(layer.feature.properties['WADMKC'])) {
	        // if (layer.feature.geometry.type === 'LineString') {
        	    highlightlayer.setStyle({
                	color: 'blue',
        	    // });
	        // } else {
        	    // highlightlayer.setStyle({
                fillColor: '#ffff00',
                fillOpacity: 1,
                weight: 4.5
	            });
	        // }
	} else{
//		if (layer.feature.geometry.type === 'LineString') {
                    for (i in layer._eventParents) {
                        layer._eventParents[i].resetStyle(layer);
                    }
                    layer.on({
                    mouseout: function(e) {
                    for (i in e.target._eventParents) {
                        e.target._eventParents[i].resetStyle(e.target);
                    }
                },
            });


//	}
	}

}
}
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		var response = this.responseText;
		    var parser = new DOMParser();
		    var doc = parser.parseFromString(response, "text/html");
		    var paragraphs = doc.querySelectorAll("p");
		    var filterkota;
			filterkota=[];

    // Iterate over each <p> tag and concatenate their content
		    for (var i = 0; i < paragraphs.length; i++) {
		      paragraphContent = paragraphs[i].innerHTML.split(" - ")[1];
    
			filterkota.push(paragraphContent);}
			console.log(filterkota);
    // Display the concatenated content
		    layer_Batas_Kecamatan_BIG_0.eachLayer(function(layer) {
		    filterhighlight(layer, filterkota);
// Usage example

            });

}	};
	function getParameterByName(name) {
                  var url = window.location.href;
                  name = name.replace(/[\[\]]/g, "\\$&"); // Escape special characters
                  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)");
                  var results = regex.exec(url);
                  if (!results) return null;
                  if (!results[2]) return '';
                  return decodeURIComponent(results[2].replace(/\+/g, " "));
                }

	var jenis = getParameterByName('subdit');
	console.log(jenis);
	xhttp.open("GET", "filter_script.php?filterValue=" + jenis, true);
	xhttp.send();
</script>
<div class="title">
<h1><strong><?php if (in_array($_GET['subdit'],$jenis) or ($_GET['subdit'] == 'Temanggung' and $_GET['by'] == 'jenis')){echo 'Berdasarkan Bidang Tindak Pidana';}elseif (in_array($_GET['subdit'],$bulan) or ($_GET['by'] == 'bulan' and $_GET['subdit'] == 'Temanggung')  ){echo 'Berdasarkan Waktu';} ?></strong></h1>
      </div>
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
