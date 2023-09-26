<?php

$conn = mysqli_connect('localhost', 'root', '123','Data');

// get the post records
$nama = ucwords(strtolower($_POST['Nama-Kasus']));
$bidang = strtoupper($_POST['bidang-tindak-pidana']);
$sub = ucwords(strtolower($_POST['SubKategoriFilter']));
$waktu = ucwords(strtolower($_POST['incident-time']));
$kota = ucwords(strtolower($_POST['city']));
$kecamatan = ucwords(strtolower($_POST['subDistrict']));

// database insert SQL code
$sql = "INSERT INTO `Kasus` (`ID`, `Nama Kasus`, `Jenis Tindak Pidana`, `Sub-Kategori`, `Waktu Kejadian`, `Lokasi Kejadian`) VALUES (0, '$nama', '$bidang', '$sub', '$waktu', '$kota - $kecamatan')";

// insert in database 
$rs = mysqli_query($conn, $sql);

if($rs)
{
	echo "Berhasil tambah kasus";
	header("Location: /detail.php");
}

?>