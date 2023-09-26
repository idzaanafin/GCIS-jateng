<!DOCTYPE html>
<html>
<head>
  <title>Details Geographical Criminal Information System</title>
</head>
<body>



<?php
// Retrieve the filter value from the GET parameters
$conn = mysqli_connect('localhost', 'root', '123','Data');

$kota = ["Banjarnegara",
"Banyumas",
"Batang",
"Blora",
"Boyolali",
"Brebes",
"Cilacap",
"Demak",
"Grobogan",
"Jepara",
"Karanganyar",
"Kebumen",
"Kendal",
"Klaten",
"Kudus",
"Magelang",
"Pati",
"Pekalongan",
"Pemalang",
"Purbalingga",
"Purworejo",
"Rembang",
"Semarang",
"Sragen",
"Sukoharjo",
"Tegal",
"Temanggung",
"Wonogiri",
"Wonosobo",
"Kota Magelang",
"Kota Pekalongan",
"Kota Salatiga",
"Kota Semarang",
"Kota Surakarta",
"Kota Tegal"];

$filter = $_GET['filterValue'];
$bidang= ["INDAGSI","EKSUS","TIPIDKOR","TIPIDTER","SIBER"];
if (in_array($filter, $bidang)) {
	$filter = $filter;
}elseif (in_array($filter, $kota)){

	$sql = "SELECT * FROM `Kasus` WHERE `Lokasi Kejadian`LIKE '$filter%' ";
		$hasil = mysqli_query($conn,$sql);
	//		echo $bulan;
			if ($hasil->num_rows > 0) {
					while($row = $hasil->fetch_assoc()) {
							 echo "<p>". $row['Lokasi Kejadian']. "</p>";
					}}

}else {
		$monthName = $filter ; // Indonesian month name
		$months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
		$filter =  array_search($monthName, $months) + 1;
		$bulan = "SELECT `Lokasi Kejadian` FROM `Kasus` WHERE `Waktu Kejadian`LIKE '%2023%$filter-%' ";


		$hasil = mysqli_query($conn,$bulan);
//		echo $bulan;
		if ($hasil->num_rows > 0) {
		        while($row = $hasil->fetch_assoc()) {
                         echo "<p>". $row['Lokasi Kejadian']. "</p>";
                }}

}


//echo "<p>". $filter. "</p>";
// Construct the SQL query using the filter value
$sql =  "SELECT `Lokasi Kejadian` FROM Kasus WHERE `Jenis Tindak Pidana` = '$filter' AND `Lokasi Kejadian` LIKE'Jepara%'";

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
			$conn->close();
		?>

</body>
</html>