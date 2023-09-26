<?php
header('Content-Type: application/json');
// Retrieve the filter value from the GET parameters
$conn = mysqli_connect('localhost', 'root', '123','Data');



//echo "<p>". $filter. "</p>";
// Construct the SQL query using the filter value
$total = "SELECT `Jenis Tindak Pidana` FROM Kasus" ;
$perbulan = "SELECT `Waktu Kejadian` FROM Kasus";
$hasil = mysqli_query($conn,$perbulan);
$januari = [];
$februari = [];
$maret = [];
$april = [];
$mei = [];
$juni = [];
$juli = [];
$agustus = [];
$september = [];
$oktober = [];
$november = [];
$desember = [];
if ($hasil->num_rows > 0) {
                  // output data of each row
                  while($row = $hasil->fetch_assoc()) {
                         $value = $row['Waktu Kejadian'];
			 $tanggal = explode('t', $value)[0];
			 $bulan = explode('-', $tanggal)[1];
			if ($bulan == '01') {
		        $januari[] = $bulan;
		    } elseif ($bulan == '02') {
		        $februari[] = $bulan;
		    } elseif ($bulan == '03') {
		        $maret[] = $bulan;
		    } elseif ($bulan == '04') {
		        $april[] = $bulan;
		    } elseif ($bulan == '05') {
		        $mei[] = $bulan;
		    } elseif ($bulan == '06') {
		        $juni[] = $bulan;
		    } elseif ($bulan == '07') {
		        $juli[] = $bulan;
		    } elseif ($bulan == '08') {
		        $agustus[] = $bulan;
		    } elseif ($bulan == '09') {
		        $september[] = $bulan;
		    } elseif ($bulan == '10') {
		        $oktober[] = $bulan;
		    } elseif ($bulan == '11') {
		        $november[] = $bulan;
		    } elseif ($bulan == '12') {
		        $desember[] = $bulan;
		    }
                   }}
                else {
                        // echo "<p>". "0 results". "</p>";
                }
// Execute the SQL query against your database using your preferred PHP database library (e.g., PDO, MySQLi, etc.)
$rs = mysqli_query($conn, $total);
$INDAGSI = [];
$EKSUS = [];
$TIPIDKOR = [];
$TIPIDTER = [];
$SIBER = [];
if ($rs->num_rows > 0) {
		  // output data of each row
		  while($row = $rs->fetch_assoc()) {
           		 $value = $row['Jenis Tindak Pidana'];
			if ($value == 'INDAGSI') {
		        $INDAGSI[] = $value;
		    } elseif ($value == 'EKSUS') {
		        $EKSUS[] = $value;
		    } elseif ($value == 'TIPIDKOR') {
		        $TIPIDKOR[] = $value;
		    } elseif ($value == 'TIPIDTER') {
		        $TIPIDTER[] = $value;
		    } elseif ($value == 'SIBER') {
		        $SIBER[] = $value;
		    }
         	}}
		else {
			// echo "<p>". "0 results". "</p>";
		}
			$response = [
		    'INDAGSI' => count($INDAGSI),
		    'EKSUS' => count($EKSUS),
		    'TIPIDKOR' => count($TIPIDKOR),
		    'TIPIDTER' => count($TIPIDTER),
		    'SIBER' => count($SIBER),
			'JANUARI'=> count($januari),
			'FEBRUARI'=> count($februari),
			'MARET'=> count($maret),
			'APRIL'=> count($april),
			'MEI'=> count($mei),
			'JUNI'=> count($juni),
			'JULI'=> count($juli),
			'AGUSTUS'=> count($agustus),
			'SEPTEMBER'=> count($september),
			'OKTOBER'=> count($oktober),
			'NOVEMBER'=> count($november),
			'DESEMBER'=> count($desember)];

		$response =json_encode($response);			
		echo $response;

			$conn->close();
		?>