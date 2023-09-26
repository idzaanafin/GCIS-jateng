<!DOCTYPE html>
<html>
<head>
  <title>Details Geographical Criminal Information System</title>
</head>
<body>



<?php
// Retrieve the filter value from the GET parameters
$conn = mysqli_connect('localhost', 'root', '123','Data');


$filter = $_GET['filterValue'];
// $jenis= $_GET['jenis'];
// echo $jenis;
// if ($filter == 'INDAGSI'){
// 	$filter = 'Subdit I';
// }elseif ($filter == 'EKSUS'){
//         $filter = 'Subdit II';
// }elseif ($filter == 'TIPIDKOR'){
//         $filter = 'Subdit III';
// }elseif ($filter == 'TIPIDTER'){
//         $filter = 'Subdit IV';
// }elseif ($filter == 'SIBER'){
//         $filter = 'Subdit V';

$bidang= ["INDAGSI","EKSUS","TIPIDKOR","TIPIDTER","SIBER"];

if ($filter ==''){
		$filter = 'null';
}elseif (in_array($filter, $bidang)) {
		$filter = $filter;
}else {
		$monthName = $filter ; // Indonesian month name
		$months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
		$filter =  array_search($monthName, $months) + 1;
		$number_str = strval($filter);

// Check the length of the string
		if (strlen($number_str) === 1) {
    	$number_str = '0' . $number_str;
		}
		$bulan = "SELECT `Lokasi Kejadian` FROM `Kasus` WHERE `Waktu Kejadian`LIKE '%2023-$number_str-%' ";


		$hasil = mysqli_query($conn,$bulan);
//		echo $bulan;
		if ($hasil->num_rows > 0) {
		        while($row = $hasil->fetch_assoc()) {
                         echo "<p>". $row['Lokasi Kejadian']. "</p>";
                }}
}


//echo "<p>". $filter. "</p>";
// Construct the SQL query using the filter value
$sql = "SELECT `Lokasi Kejadian` FROM Kasus WHERE `Jenis Tindak Pidana` =  '$filter'" ;

// Execute the SQL query against your database using your preferred PHP database library (e.g., PDO, MySQLi, etc.)
$rs = mysqli_query($conn, $sql);
if ($rs->num_rows > 0) {
//		  // output data of each row
		  while($row = $rs->fetch_assoc()) {
           		 echo "<p>". $row['Lokasi Kejadian']. "</p>";
//			echo  $row["ID"]. $row["Nama Kasus"].  $row["Jenis Tindak Pidana"].   $row["Waktu Kejadian"].  $row["Lokasi Kejadian"]. "<br>";
         	}}
		else {
//			echo "<p>". "0 results". "</p>";
		}
			// $conn->close();
		?>

</body>
</html>