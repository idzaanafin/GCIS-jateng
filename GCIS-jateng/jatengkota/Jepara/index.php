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
            if ($_GET['by'] == 'jenis' && $_GET['subdit'] == 'Jepara') {
                echo '<a href="../index.php">
                            <img src="css/images/home.png" alt="Home" width="50px">
                         </a>';
            }elseif (in_array($_GET['subdit'],$jenis)) {
                echo '<a href="../index.php">
                            <img src="css/images/home.png" alt="Home" width="50px">
                         </a>';
            }elseif (($_GET['subdit'] == 'Jepara' && $_GET['by'] == 'bulan')) {
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

                           $result = mysqli_query($conn,"SELECT * FROM `Kasus` WHERE `Lokasi Kejadian` LIKE'Jepara%' AND `Jenis Tindak Pidana` = '$filter'");    
                        }elseif (in_array($filter, $bulan)){
                            $monthName = $filter ; // Indonesian month name
		                    $filter =  array_search($monthName, $bulan) + 1;
                            $result = mysqli_query($conn,"SELECT * FROM `Kasus` WHERE `Lokasi Kejadian` LIKE'Jepara%' AND `Waktu Kejadian`LIKE '%2023%$filter-%' ");
                        }else{
                            $result = mysqli_query($conn,"SELECT * FROM `Kasus` WHERE `Lokasi Kejadian` LIKE'Jepara%'");
                        }
?>

<main>
    <div class="map-container">
    <h1><strong>Peta Kriminalis Kabupaten Jepara</strong></h1>
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
        elseif ($_GET['subdit']=='Jepara' or ($_GET['subdit']=='Jepara' and$_GET['by'] == 'jenis') or ($_GET['subdit']=='Jepara' and$_GET['by'] == 'bulan') ) {echo '';}
        ?>


        <?php
        // bulan
        if (in_array($_GET['subdit'],$bulan) or ($_GET['subdit']=='Jepara' and$_GET['by'] == 'bulan')){
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
        }elseif (($_GET['by'] == 'jenis' and $_GET['subdit'] == 'Jepara') or in_array($_GET['subdit'],$jenis)) {
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
        }).fitBounds([[-6.997242909070762,109.86334157558056],[-5.691864778706831,111.69405480718851]]);
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
            if (feature.properties['OBJECTID'] >= 551.000000 && feature.properties['OBJECTID'] <= 564.636364 ) {
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
            if (feature.properties['OBJECTID'] >= 564.636364 && feature.properties['OBJECTID'] <= 578.272727 ) {
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
                fillColor: 'rgba(216,29,30,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 578.272727 && feature.properties['OBJECTID'] <= 591.909091 ) {
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
                fillColor: 'rgba(217,32,31,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 591.909091 && feature.properties['OBJECTID'] <= 605.545455 ) {
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
                fillColor: 'rgba(218,36,33,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 605.545455 && feature.properties['OBJECTID'] <= 619.181818 ) {
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
                fillColor: 'rgba(219,40,35,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 619.181818 && feature.properties['OBJECTID'] <= 632.818182 ) {
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
                fillColor: 'rgba(220,43,36,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 632.818182 && feature.properties['OBJECTID'] <= 646.454545 ) {
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
                fillColor: 'rgba(221,47,38,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 646.454545 && feature.properties['OBJECTID'] <= 660.090909 ) {
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
                fillColor: 'rgba(221,50,40,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 660.090909 && feature.properties['OBJECTID'] <= 673.727273 ) {
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
                fillColor: 'rgba(222,54,41,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 673.727273 && feature.properties['OBJECTID'] <= 687.363636 ) {
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
                fillColor: 'rgba(223,58,43,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 687.363636 && feature.properties['OBJECTID'] <= 701.000000 ) {
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
                fillColor: 'rgba(224,61,45,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 701.000000 && feature.properties['OBJECTID'] <= 786.363636 ) {
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
                fillColor: 'rgba(225,65,47,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 786.363636 && feature.properties['OBJECTID'] <= 871.727273 ) {
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
                fillColor: 'rgba(226,69,48,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 871.727273 && feature.properties['OBJECTID'] <= 957.090909 ) {
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
                fillColor: 'rgba(227,72,50,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 957.090909 && feature.properties['OBJECTID'] <= 1042.454545 ) {
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
                fillColor: 'rgba(228,76,52,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1042.454545 && feature.properties['OBJECTID'] <= 1127.818182 ) {
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
                fillColor: 'rgba(229,80,53,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1127.818182 && feature.properties['OBJECTID'] <= 1213.181818 ) {
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
                fillColor: 'rgba(230,83,55,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1213.181818 && feature.properties['OBJECTID'] <= 1298.545455 ) {
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
                fillColor: 'rgba(231,87,57,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1298.545455 && feature.properties['OBJECTID'] <= 1383.909091 ) {
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
                fillColor: 'rgba(232,90,58,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1383.909091 && feature.properties['OBJECTID'] <= 1469.272727 ) {
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
            if (feature.properties['OBJECTID'] >= 1469.272727 && feature.properties['OBJECTID'] <= 1554.636364 ) {
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
                fillColor: 'rgba(234,98,62,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1554.636364 && feature.properties['OBJECTID'] <= 1640.000000 ) {
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
                fillColor: 'rgba(234,101,63,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1640.000000 && feature.properties['OBJECTID'] <= 1694.636364 ) {
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
                fillColor: 'rgba(235,105,65,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1694.636364 && feature.properties['OBJECTID'] <= 1749.272727 ) {
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
                fillColor: 'rgba(236,109,67,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1749.272727 && feature.properties['OBJECTID'] <= 1803.909091 ) {
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
                fillColor: 'rgba(237,112,68,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1803.909091 && feature.properties['OBJECTID'] <= 1858.545455 ) {
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
                fillColor: 'rgba(238,116,70,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1858.545455 && feature.properties['OBJECTID'] <= 1913.181818 ) {
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
                fillColor: 'rgba(239,119,72,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1913.181818 && feature.properties['OBJECTID'] <= 1967.818182 ) {
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
                fillColor: 'rgba(240,123,73,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 1967.818182 && feature.properties['OBJECTID'] <= 2022.454545 ) {
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
                fillColor: 'rgba(241,127,75,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2022.454545 && feature.properties['OBJECTID'] <= 2077.090909 ) {
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
                fillColor: 'rgba(242,130,77,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2077.090909 && feature.properties['OBJECTID'] <= 2131.727273 ) {
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
                fillColor: 'rgba(243,134,78,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2131.727273 && feature.properties['OBJECTID'] <= 2186.363636 ) {
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
                fillColor: 'rgba(244,138,80,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2186.363636 && feature.properties['OBJECTID'] <= 2241.000000 ) {
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
                fillColor: 'rgba(245,141,82,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2241.000000 && feature.properties['OBJECTID'] <= 2253.454545 ) {
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
                fillColor: 'rgba(246,145,84,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2253.454545 && feature.properties['OBJECTID'] <= 2265.909091 ) {
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
                fillColor: 'rgba(247,149,85,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2265.909091 && feature.properties['OBJECTID'] <= 2278.363636 ) {
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
                fillColor: 'rgba(247,152,87,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2278.363636 && feature.properties['OBJECTID'] <= 2290.818182 ) {
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
                fillColor: 'rgba(248,156,89,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2290.818182 && feature.properties['OBJECTID'] <= 2303.272727 ) {
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
                fillColor: 'rgba(249,159,90,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2303.272727 && feature.properties['OBJECTID'] <= 2315.727273 ) {
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
            if (feature.properties['OBJECTID'] >= 2315.727273 && feature.properties['OBJECTID'] <= 2328.181818 ) {
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
                fillColor: 'rgba(251,167,94,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2328.181818 && feature.properties['OBJECTID'] <= 2340.636364 ) {
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
                fillColor: 'rgba(252,170,95,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2340.636364 && feature.properties['OBJECTID'] <= 2353.090909 ) {
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
                fillColor: 'rgba(253,174,97,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2353.090909 && feature.properties['OBJECTID'] <= 2365.545455 ) {
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
                fillColor: 'rgba(253,176,99,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2365.545455 && feature.properties['OBJECTID'] <= 2378.000000 ) {
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
                fillColor: 'rgba(253,178,102,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2378.000000 && feature.properties['OBJECTID'] <= 2392.363636 ) {
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
            if (feature.properties['OBJECTID'] >= 2392.363636 && feature.properties['OBJECTID'] <= 2406.727273 ) {
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
                fillColor: 'rgba(253,182,106,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2406.727273 && feature.properties['OBJECTID'] <= 2421.090909 ) {
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
                fillColor: 'rgba(253,184,108,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2421.090909 && feature.properties['OBJECTID'] <= 2435.454545 ) {
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
                fillColor: 'rgba(253,186,111,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2435.454545 && feature.properties['OBJECTID'] <= 2449.818182 ) {
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
                fillColor: 'rgba(253,188,113,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2449.818182 && feature.properties['OBJECTID'] <= 2464.181818 ) {
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
                fillColor: 'rgba(253,190,115,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2464.181818 && feature.properties['OBJECTID'] <= 2478.545455 ) {
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
                fillColor: 'rgba(253,192,118,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2478.545455 && feature.properties['OBJECTID'] <= 2492.909091 ) {
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
                fillColor: 'rgba(253,194,120,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2492.909091 && feature.properties['OBJECTID'] <= 2507.272727 ) {
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
                fillColor: 'rgba(254,196,122,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2507.272727 && feature.properties['OBJECTID'] <= 2521.636364 ) {
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
                fillColor: 'rgba(254,198,125,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2521.636364 && feature.properties['OBJECTID'] <= 2536.000000 ) {
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
                fillColor: 'rgba(254,200,127,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2536.000000 && feature.properties['OBJECTID'] <= 2545.454545 ) {
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
                fillColor: 'rgba(254,202,129,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2545.454545 && feature.properties['OBJECTID'] <= 2554.909091 ) {
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
                fillColor: 'rgba(254,204,131,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2554.909091 && feature.properties['OBJECTID'] <= 2564.363636 ) {
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
                fillColor: 'rgba(254,206,134,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2564.363636 && feature.properties['OBJECTID'] <= 2573.818182 ) {
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
                fillColor: 'rgba(254,208,136,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2573.818182 && feature.properties['OBJECTID'] <= 2583.272727 ) {
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
                fillColor: 'rgba(254,210,138,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2583.272727 && feature.properties['OBJECTID'] <= 2592.727273 ) {
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
                fillColor: 'rgba(254,212,141,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2592.727273 && feature.properties['OBJECTID'] <= 2602.181818 ) {
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
                fillColor: 'rgba(254,214,143,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2602.181818 && feature.properties['OBJECTID'] <= 2611.636364 ) {
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
                fillColor: 'rgba(254,215,145,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2611.636364 && feature.properties['OBJECTID'] <= 2621.090909 ) {
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
                fillColor: 'rgba(254,217,147,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2621.090909 && feature.properties['OBJECTID'] <= 2630.545455 ) {
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
                fillColor: 'rgba(254,219,150,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2630.545455 && feature.properties['OBJECTID'] <= 2640.000000 ) {
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
                fillColor: 'rgba(254,221,152,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2640.000000 && feature.properties['OBJECTID'] <= 2644.363636 ) {
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
                fillColor: 'rgba(254,223,154,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2644.363636 && feature.properties['OBJECTID'] <= 2648.727273 ) {
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
                fillColor: 'rgba(254,225,157,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2648.727273 && feature.properties['OBJECTID'] <= 2653.090909 ) {
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
                fillColor: 'rgba(254,227,159,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2653.090909 && feature.properties['OBJECTID'] <= 2657.454545 ) {
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
                fillColor: 'rgba(254,229,161,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2657.454545 && feature.properties['OBJECTID'] <= 2661.818182 ) {
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
                fillColor: 'rgba(254,231,163,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2661.818182 && feature.properties['OBJECTID'] <= 2666.181818 ) {
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
                fillColor: 'rgba(254,233,166,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2666.181818 && feature.properties['OBJECTID'] <= 2670.545455 ) {
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
                fillColor: 'rgba(255,235,168,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2670.545455 && feature.properties['OBJECTID'] <= 2674.909091 ) {
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
                fillColor: 'rgba(255,237,170,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2674.909091 && feature.properties['OBJECTID'] <= 2679.272727 ) {
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
                fillColor: 'rgba(255,239,173,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2679.272727 && feature.properties['OBJECTID'] <= 2683.636364 ) {
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
                fillColor: 'rgba(255,241,175,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2683.636364 && feature.properties['OBJECTID'] <= 2688.000000 ) {
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
            if (feature.properties['OBJECTID'] >= 2688.000000 && feature.properties['OBJECTID'] <= 2689.454545 ) {
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
                fillColor: 'rgba(255,245,180,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2689.454545 && feature.properties['OBJECTID'] <= 2690.909091 ) {
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
                fillColor: 'rgba(255,247,182,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2690.909091 && feature.properties['OBJECTID'] <= 2692.363636 ) {
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
                fillColor: 'rgba(255,249,184,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2692.363636 && feature.properties['OBJECTID'] <= 2693.818182 ) {
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
                fillColor: 'rgba(255,251,186,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2693.818182 && feature.properties['OBJECTID'] <= 2695.272727 ) {
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
                fillColor: 'rgba(255,253,189,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2695.272727 && feature.properties['OBJECTID'] <= 2696.727273 ) {
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
            if (feature.properties['OBJECTID'] >= 2696.727273 && feature.properties['OBJECTID'] <= 2698.181818 ) {
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
                fillColor: 'rgba(253,254,190,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2698.181818 && feature.properties['OBJECTID'] <= 2699.636364 ) {
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
                fillColor: 'rgba(251,253,190,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2699.636364 && feature.properties['OBJECTID'] <= 2701.090909 ) {
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
                fillColor: 'rgba(249,253,189,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2701.090909 && feature.properties['OBJECTID'] <= 2702.545455 ) {
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
                fillColor: 'rgba(247,252,188,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2702.545455 && feature.properties['OBJECTID'] <= 2704.000000 ) {
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
                fillColor: 'rgba(245,251,188,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2704.000000 && feature.properties['OBJECTID'] <= 2803.909091 ) {
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
                fillColor: 'rgba(243,250,187,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2803.909091 && feature.properties['OBJECTID'] <= 2903.818182 ) {
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
                fillColor: 'rgba(241,249,186,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 2903.818182 && feature.properties['OBJECTID'] <= 3003.727273 ) {
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
                fillColor: 'rgba(239,248,186,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3003.727273 && feature.properties['OBJECTID'] <= 3103.636364 ) {
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
                fillColor: 'rgba(237,248,185,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3103.636364 && feature.properties['OBJECTID'] <= 3203.545455 ) {
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
                fillColor: 'rgba(235,247,184,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3203.545455 && feature.properties['OBJECTID'] <= 3303.454545 ) {
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
                fillColor: 'rgba(232,246,184,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3303.454545 && feature.properties['OBJECTID'] <= 3403.363636 ) {
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
                fillColor: 'rgba(230,245,183,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3403.363636 && feature.properties['OBJECTID'] <= 3503.272727 ) {
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
                fillColor: 'rgba(228,244,182,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3503.272727 && feature.properties['OBJECTID'] <= 3603.181818 ) {
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
                fillColor: 'rgba(226,243,182,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3603.181818 && feature.properties['OBJECTID'] <= 3703.090909 ) {
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
                fillColor: 'rgba(224,243,181,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3703.090909 && feature.properties['OBJECTID'] <= 3803.000000 ) {
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
                fillColor: 'rgba(222,242,180,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3803.000000 && feature.properties['OBJECTID'] <= 3818.636364 ) {
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
                fillColor: 'rgba(220,241,180,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3818.636364 && feature.properties['OBJECTID'] <= 3834.272727 ) {
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
                fillColor: 'rgba(218,240,179,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3834.272727 && feature.properties['OBJECTID'] <= 3849.909091 ) {
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
                fillColor: 'rgba(216,239,178,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3849.909091 && feature.properties['OBJECTID'] <= 3865.545455 ) {
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
                fillColor: 'rgba(214,238,178,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3865.545455 && feature.properties['OBJECTID'] <= 3881.181818 ) {
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
                fillColor: 'rgba(212,238,177,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3881.181818 && feature.properties['OBJECTID'] <= 3896.818182 ) {
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
                fillColor: 'rgba(210,237,177,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3896.818182 && feature.properties['OBJECTID'] <= 3912.454545 ) {
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
                fillColor: 'rgba(208,236,176,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3912.454545 && feature.properties['OBJECTID'] <= 3928.090909 ) {
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
                fillColor: 'rgba(206,235,175,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3928.090909 && feature.properties['OBJECTID'] <= 3943.727273 ) {
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
                fillColor: 'rgba(204,234,175,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3943.727273 && feature.properties['OBJECTID'] <= 3959.363636 ) {
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
                fillColor: 'rgba(202,233,174,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3959.363636 && feature.properties['OBJECTID'] <= 3975.000000 ) {
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
                fillColor: 'rgba(200,233,173,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3975.000000 && feature.properties['OBJECTID'] <= 3992.727273 ) {
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
                fillColor: 'rgba(198,232,173,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 3992.727273 && feature.properties['OBJECTID'] <= 4010.454545 ) {
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
                fillColor: 'rgba(196,231,172,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4010.454545 && feature.properties['OBJECTID'] <= 4028.181818 ) {
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
                fillColor: 'rgba(194,230,171,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4028.181818 && feature.properties['OBJECTID'] <= 4045.909091 ) {
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
                fillColor: 'rgba(191,229,171,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4045.909091 && feature.properties['OBJECTID'] <= 4063.636364 ) {
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
                fillColor: 'rgba(189,228,170,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4063.636364 && feature.properties['OBJECTID'] <= 4081.363636 ) {
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
                fillColor: 'rgba(187,228,169,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4081.363636 && feature.properties['OBJECTID'] <= 4099.090909 ) {
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
                fillColor: 'rgba(185,227,169,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4099.090909 && feature.properties['OBJECTID'] <= 4116.818182 ) {
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
                fillColor: 'rgba(183,226,168,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4116.818182 && feature.properties['OBJECTID'] <= 4134.545455 ) {
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
                fillColor: 'rgba(181,225,167,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4134.545455 && feature.properties['OBJECTID'] <= 4152.272727 ) {
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
                fillColor: 'rgba(179,224,167,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4152.272727 && feature.properties['OBJECTID'] <= 4170.000000 ) {
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
                fillColor: 'rgba(177,223,166,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4170.000000 && feature.properties['OBJECTID'] <= 4199.909091 ) {
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
                fillColor: 'rgba(175,223,165,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4199.909091 && feature.properties['OBJECTID'] <= 4229.818182 ) {
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
                fillColor: 'rgba(173,222,165,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4229.818182 && feature.properties['OBJECTID'] <= 4259.727273 ) {
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
                fillColor: 'rgba(171,221,164,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4259.727273 && feature.properties['OBJECTID'] <= 4289.636364 ) {
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
                fillColor: 'rgba(168,219,165,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4289.636364 && feature.properties['OBJECTID'] <= 4319.545455 ) {
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
                fillColor: 'rgba(165,217,165,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4319.545455 && feature.properties['OBJECTID'] <= 4349.454545 ) {
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
                fillColor: 'rgba(162,214,166,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4349.454545 && feature.properties['OBJECTID'] <= 4379.363636 ) {
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
                fillColor: 'rgba(159,212,166,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4379.363636 && feature.properties['OBJECTID'] <= 4409.272727 ) {
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
                fillColor: 'rgba(155,210,167,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4409.272727 && feature.properties['OBJECTID'] <= 4439.181818 ) {
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
                fillColor: 'rgba(152,208,167,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4439.181818 && feature.properties['OBJECTID'] <= 4469.090909 ) {
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
                fillColor: 'rgba(149,206,168,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4469.090909 && feature.properties['OBJECTID'] <= 4499.000000 ) {
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
                fillColor: 'rgba(146,203,168,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4499.000000 && feature.properties['OBJECTID'] <= 4527.818182 ) {
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
                fillColor: 'rgba(143,201,169,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4527.818182 && feature.properties['OBJECTID'] <= 4556.636364 ) {
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
                fillColor: 'rgba(140,199,169,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4556.636364 && feature.properties['OBJECTID'] <= 4585.454545 ) {
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
                fillColor: 'rgba(137,197,170,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4585.454545 && feature.properties['OBJECTID'] <= 4614.272727 ) {
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
                fillColor: 'rgba(134,195,170,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4614.272727 && feature.properties['OBJECTID'] <= 4643.090909 ) {
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
                fillColor: 'rgba(130,192,171,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4643.090909 && feature.properties['OBJECTID'] <= 4671.909091 ) {
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
                fillColor: 'rgba(127,190,172,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4671.909091 && feature.properties['OBJECTID'] <= 4700.727273 ) {
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
                fillColor: 'rgba(124,188,172,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4700.727273 && feature.properties['OBJECTID'] <= 4729.545455 ) {
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
                fillColor: 'rgba(121,186,173,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4729.545455 && feature.properties['OBJECTID'] <= 4758.363636 ) {
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
                fillColor: 'rgba(118,184,173,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4758.363636 && feature.properties['OBJECTID'] <= 4787.181818 ) {
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
                fillColor: 'rgba(115,181,174,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4787.181818 && feature.properties['OBJECTID'] <= 4816.000000 ) {
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
                fillColor: 'rgba(112,179,174,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4816.000000 && feature.properties['OBJECTID'] <= 4965.181818 ) {
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
                fillColor: 'rgba(109,177,175,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 4965.181818 && feature.properties['OBJECTID'] <= 5114.363636 ) {
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
                fillColor: 'rgba(105,175,175,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 5114.363636 && feature.properties['OBJECTID'] <= 5263.545455 ) {
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
            if (feature.properties['OBJECTID'] >= 5263.545455 && feature.properties['OBJECTID'] <= 5412.727273 ) {
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
                fillColor: 'rgba(99,171,176,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 5412.727273 && feature.properties['OBJECTID'] <= 5561.909091 ) {
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
                fillColor: 'rgba(96,168,177,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 5561.909091 && feature.properties['OBJECTID'] <= 5711.090909 ) {
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
                fillColor: 'rgba(93,166,177,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 5711.090909 && feature.properties['OBJECTID'] <= 5860.272727 ) {
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
                fillColor: 'rgba(90,164,178,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 5860.272727 && feature.properties['OBJECTID'] <= 6009.454545 ) {
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
                fillColor: 'rgba(87,162,178,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 6009.454545 && feature.properties['OBJECTID'] <= 6158.636364 ) {
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
                fillColor: 'rgba(84,160,179,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 6158.636364 && feature.properties['OBJECTID'] <= 6307.818182 ) {
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
                fillColor: 'rgba(80,157,180,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 6307.818182 && feature.properties['OBJECTID'] <= 6457.000000 ) {
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
                fillColor: 'rgba(77,155,180,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 6457.000000 && feature.properties['OBJECTID'] <= 6538.090909 ) {
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
                fillColor: 'rgba(74,153,181,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 6538.090909 && feature.properties['OBJECTID'] <= 6619.181818 ) {
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
                fillColor: 'rgba(71,151,181,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 6619.181818 && feature.properties['OBJECTID'] <= 6700.272727 ) {
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
                fillColor: 'rgba(68,149,182,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 6700.272727 && feature.properties['OBJECTID'] <= 6781.363636 ) {
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
                fillColor: 'rgba(65,146,182,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 6781.363636 && feature.properties['OBJECTID'] <= 6862.454545 ) {
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
                fillColor: 'rgba(62,144,183,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 6862.454545 && feature.properties['OBJECTID'] <= 6943.545455 ) {
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
                fillColor: 'rgba(59,142,183,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 6943.545455 && feature.properties['OBJECTID'] <= 7024.636364 ) {
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
                fillColor: 'rgba(55,140,184,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 7024.636364 && feature.properties['OBJECTID'] <= 7105.727273 ) {
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
                fillColor: 'rgba(52,138,184,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 7105.727273 && feature.properties['OBJECTID'] <= 7186.818182 ) {
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
                fillColor: 'rgba(49,135,185,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 7186.818182 && feature.properties['OBJECTID'] <= 7267.909091 ) {
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
                fillColor: 'rgba(46,133,185,1.0)',
                interactive: true,
            }
            }
            if (feature.properties['OBJECTID'] >= 7267.909091 && feature.properties['OBJECTID'] <= 7349.000000 ) {
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
<h1><strong><?php if (in_array($_GET['subdit'],$jenis) or ($_GET['subdit'] == 'Jepara' and $_GET['by'] == 'jenis')){echo 'Berdasarkan Bidang Tindak Pidana';}elseif (in_array($_GET['subdit'],$bulan) or ($_GET['by'] == 'bulan' and $_GET['subdit'] == 'Jepara')  ){echo 'Berdasarkan Waktu';} ?></strong></h1>
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
