<!DOCTYPE html>
<html>

<head>
    <title>Geographical Criminal Information System</title>
    <link rel="stylesheet" href="detail.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <!-- header -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <img src="krimsus.png" alt="Logo">
            </div>
            <div class="title">
                <h1>DIREKTORAT RESERSE KRIMINAL KHUSUS POLDA JAWA TENGAH</h1>
            </div>
            <div class ="home">
            <a href="index.php">
              <img src="home.png" alt="Home" width="50px">
            </a>
          </div>
        </div>
    </header>

    <!-- halaman body -->
    <main>
        <div class="peta">
            <h1>Peta Kriminalis Tahun 2023</h1>
            <img src="peta1.png" />
            <br>
            <br>
            <a href="/jatengkota/">klik untuk bidang tindak pidana
</a>
        </div>
        <?php
        $conn = mysqli_connect("localhost", "root", "123", "Data");
        // Check connection
        if (mysqli_connect_errno()) {
            echo "Failed to connect to database";
        }
        $result = mysqli_query($conn, "SELECT * FROM `Kasus` ORDER BY `Waktu Kejadian`ASC");
        ?>
        <div class="container1">
            <div class="table-container1">
                <table id="dataTable">
                    <thead>
                        <tr class="barisjudul">
                            <th>No.</th>
                            <th>Nama Kasus</th>
                            <th>Bidang Tindak Pidana</th>
                            <th>Sub-Kategori</th>
                            <th>Waktu Kejadian</th>
                            <th>Tempat Kejadian</th>
                        </tr>

                        <?php

                        if ($result->num_rows > 0) {
                            // output data of each row
                            $id = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $id . "</td>";
                                echo "<td>" . $row["Nama Kasus"] . "</td>";
                                echo "<td>" . $row["Jenis Tindak Pidana"] . "</td>";
                                echo "<td>" . $row["Sub-Kategori"] . "</td>";
                                echo "<td>" . $row["Waktu Kejadian"] . "</td>";
                                echo "<td>" . $row["Lokasi Kejadian"] . "</td>";
                                echo "</tr>";
                                $id += 1;
                                //			echo  $row["ID"]. $row["Nama Kasus"].  $row["Jenis Tindak Pidana"].   $row["Waktu Kejadian"].  $row["Lokasi Kejadian"]. "<br>";
                            }
                        } else {
                            // echo "0 results";
                        }
                        $conn->close();
                        ?>

                    </thead>
                </table>
            </div>

            <div class="filters-container1">
                <div class="filter">
                    <label for="Bidang Tindak PidanaFilter">Bidang Tindak Pidana :</label>
                    <select id="Bidang Tindak PidanaFilter">
                        <option value="">All</option>
                        <option value="INDAGSI" onclick="myFunction()">INDAGSI</option>
                        <option value="EKSUS" onclick="myFunction()">EKSUS</option>
                        <option value="TIPIDKOR" onclick="myFunction()">TIPIDKOR</option>
                        <option value="TIPIDTER" onclick="myFunction()">TIPIDTER</option>
                        <option value="SIBER" onclick="myFunction()">SIBER</option>
                    </select>
                </div>
                <div class="filter">
                    <label for="SubKategoriFilter">Sub-Kategori :</label>
                    <select id="SubKategoriFilter">
                        <option value="">All</option>
                        <option value="Hak Kekayaan Intelektual" onclick="myFunction()">INDAGSI - Hak Kekayaan Intelektual</option>
                        <option value="Perfilman" onclick="myFunction()">INDAGSI - Perfilman</option>
                        <option value="Budidaya Tanaman" onclick="myFunction()">INDAGSI - Budidaya Tanaman</option>
                        <option value="Telekomunikasi" onclick="myFunction()">INDAGSI - Telekomunikasi</option>
                        <option value="Penyiaran / Pers" onclick="myFunction()">INDAGSI - Penyiaran / Pers</option>
                        <option value="Perumahan / Pemukiman" onclick="myFunction()">INDAGSI - Perumahan / Pemukiman</option>
                        <option value="Asuransi" onclick="myFunction()">INDAGSI - Asuransi</option>
                        <option value="Investasi" onclick="myFunction()">INDAGSI - Investasi</option>
                        <option value="Penanaman Modal" onclick="myFunction()">INDAGSI - Penanaman Modal</option>
                        <option value="Industri" onclick="myFunction()">INDAGSI - Industri</option>
                        <option value="Pangan" onclick="myFunction()">INDAGSI - Pangan</option>
                        <option value="Perlindungan Konsumen" onclick="myFunction()">INDAGSI - Perlindungan Konsumen</option>
                        <option value="Perdagangan" onclick="myFunction()">INDAGSI - Perdagangan</option>
                        <option value="Kesehatan" onclick="myFunction()">INDAGSI - Kesehatan</option>
                        <option value="Kepabeanan" onclick="myFunction()">INDAGSI - Kepabeanan</option>
                        <option value="Karantina" onclick="myFunction()">INDAGSI - Karantina</option>
                        <option value="Fidusia" onclick="myFunction()">EKSUS - Fidusia</option>
                        <option value="Perbankan" onclick="myFunction()">EKSUS - Perbankan</option>
                        <option value="Perkoperasian" onclick="myFunction()">EKSUS - Perkoperasian</option>
                        <option value="Transfer Dana" onclick="myFunction()">EKSUS - Transfer Dana</option>
                        <option value="Pencucian Uang" onclick="myFunction()">EKSUS - Pencucian Uang</option>
                        <option value="Uang Palsu" onclick="myFunction()">EKSUS - Uang Palsu</option>
                        <option value="Undang - Undang TIPIDKOR" onclick="myFunction()">TIPIDKOR - Undang - Undang TIPIDKOR</option>
                        <option value="Illegal Logging" onclick="myFunction()">TIPIDTER - Illegal Logging</option>
                        <option value="Konservasi Sumber Daya Alam" onclick="myFunction()">TIPIDTER - Konservasi Sumber Daya Alam</option>
                        <option value="Illegal Minning" onclick="myFunction()">TIPIDTER - Illegal Minning</option>
                        <option value="Minyak & Gas" onclick="myFunction()">TIPIDTER - Minyak & Gas</option>
                        <option value="Ketenaga Listrikan" onclick="myFunction()">TIPIDTER - Ketenaga Listrikan</option>
                        <option value="Kesehatan" onclick="myFunction()">TIPIDTER - Kesehatan</option>
                        <option value="Lingkungan Hidup" onclick="myFunction()">TIPIDTER - Lingkungan Hidup</option>
                        <option value="Sumber Daya Air" onclick="myFunction()">TIPIDTER - Sumber Daya Air</option>
                        <option value="Illegal Fishing" onclick="myFunction()">TIPIDTER - Illegal Fishing</option>
                        <option value="Perikanan" onclick="myFunction()">TIPIDTER - Perikanan</option>
                        <option value="Peternakan" onclick="myFunction()">TIPIDTER - Peternakan</option>
                        <option value="Cagar Budaya" onclick="myFunction()">TIPIDTER - Cagar Budaya</option>
                        <option value="TIPIDTER" onclick="myFunction()">TIPIDTER - Perkebunan</option>
                        <option value="Tindak Pidana Informasi & Transaksi Elektronik" onclick="myFunction()">SIBER - Tindak Pidana Informasi & Transaksi Elektronik</option>
                        <option value="Pornografi" onclick="myFunction()">SIBER - Pornografi</option>
                        <option value="Telekomunikasi" onclick="myFunction()">SIBER - Telekomunikasi</option>
                    </select>
                    </div>
                <div class="filter">
                    <label for="BulanFilter">Bulan :</label>
                    <select id="BulanFilter">
                        <option value="">All</option>
                        <option value="2023-01-" onclick="myFunction()">Januari</option>
                        <option value="2023-02-" onclick="myFunction()">Februari</option>
                        <option value="2023-03-" onclick="myFunction()">Maret</option>
                        <option value="2023-04-" onclick="myFunction()">April</option>
                        <option value="2023-05-" onclick="myFunction()">Mei</option>
                        <option value="2023-06-" onclick="myFunction()">Juni</option>
                        <option value="2023-07-" onclick="myFunction()">Juli</option>
                        <option value="2023-08-" onclick="myFunction()">Agustus</option>
                        <option value="2023-09-" onclick="myFunction()">September</option>
                        <option value="2023-10-" onclick="myFunction()">Oktober</option>
                        <option value="2023-11-" onclick="myFunction()">November</option>
                        <option value="2023-12-" onclick="myFunction()">Desember</option>
                    </select>
                </div>
                <div class="filter">
                    <label for="TanggalFilter">Tanggal :</label>
                    <select id="TanggalFilter">
                        <option value="">All</option>
                        <option value="-01t" onclick="myFunction()">01</option>
                        <option value="-02t" onclick="myFunction()">02</option>
                        <option value="-03t" onclick="myFunction()">03</option>
                        <option value="-04t" onclick="myFunction()">04</option>
                        <option value="-05t" onclick="myFunction()">05</option>
                        <option value="-06t" onclick="myFunction()">06</option>
                        <option value="-07t" onclick="myFunction()">07</option>
                        <option value="-08t" onclick="myFunction()">08</option>
                        <option value="-09t" onclick="myFunction()">09</option>
                        <option value="-10t" onclick="myFunction()">10</option>
                        <option value="-11t" onclick="myFunction()">11</option>
                        <option value="-12t" onclick="myFunction()">12</option>
                        <option value="-13t" onclick="myFunction()">13</option>
                        <option value="-14t" onclick="myFunction()">14</option>
                        <option value="-15t" onclick="myFunction()">15</option>
                        <option value="-16t" onclick="myFunction()">16</option>
                        <option value="-17t" onclick="myFunction()">17</option>
                        <option value="-18t" onclick="myFunction()">18</option>
                        <option value="-19t" onclick="myFunction()">19</option>
                        <option value="-20t" onclick="myFunction()">20</option>
                        <option value="-21t" onclick="myFunction()">21</option>
                        <option value="-22t" onclick="myFunction()">22</option>
                        <option value="-23t" onclick="myFunction()">23</option>
                        <option value="-24t" onclick="myFunction()">24</option>
                        <option value="-25t" onclick="myFunction()">25</option>
                        <option value="-26t" onclick="myFunction()">26</option>
                        <option value="-27t" onclick="myFunction()">27</option>
                        <option value="-28t" onclick="myFunction()">28</option>
                        <option value="-29t" onclick="myFunction()">29</option>
                        <option value="-30t" onclick="myFunction()">30</option>
                        <option value="-31t" onclick="myFunction()">31</option>
                    </select>
                </div>
                <div class="filter">
                    <label for="lokasiFilter">Lokasi :</label>
                    <select id="lokasiFilter">
                        <option value="">All</option>
                        <option value="Banjarnegara" onclick="myFunction()">Banjarnegara</option>
                        <option value="Banyumas" onclick="myFunction()">Banyumas</option>
                        <option value="Batang" onclick="myFunction()">Batang</option>
                        <option value="Blora" onclick="myFunction()">Blora</option>
                        <option value="Boyolali" onclick="myFunction()">Boyolali</option>
                        <option value="Brebes" onclick="myFunction()">Brebes</option>
                        <option value="Cilacap" onclick="myFunction()">Cilacap</option>
                        <option value="Demak" onclick="myFunction()">Demak</option>
                        <option value="Grobogan" onclick="myFunction()">Grobogan</option>
                        <option value="Jepara" onclick="myFunction()">Jepara</option>
                        <option value="Karanganyar" onclick="myFunction()">Karanganyar</option>
                        <option value="Kebumen" onclick="myFunction()">Kebumen</option>
                        <option value="Kendal" onclick="myFunction()">Kendal</option>
                        <option value="Klaten" onclick="myFunction()">Klaten</option>
                        <option value="Kudus" onclick="myFunction()">Kudus</option>
                        <option value="Magelang" onclick="myFunction()">Magelang</option>
                        <option value="Pati" onclick="myFunction()">Pati</option>
                        <option value="Pekalongan" onclick="myFunction()">Pekalongan</option>
                        <option value="Pemalang" onclick="myFunction()">Pemalang</option>
                        <option value="Purbalingga" onclick="myFunction()">Purbalingga</option>
                        <option value="Purworejo" onclick="myFunction()">Purworejo</option>
                        <option value="Rembang" onclick="myFunction()">Rembang</option>
                        <option value="Semarang" onclick="myFunction()">Semarang</option>
                        <option value="Sragen" onclick="myFunction()">Sragen</option>
                        <option value="Sukoharjo" onclick="myFunction()">Sukoharjo</option>
                        <option value="Tegal" onclick="myFunction()">Tegal</option>
                        <option value="Temanggung" onclick="myFunction()">Temanggung</option>
                        <option value="Wonogiri" onclick="myFunction()">Wonogiri</option>
                        <option value="Wonosobo" onclick="myFunction()">Wonosobo</option>
                        <option value="Kota Magelang" onclick="myFunction()">Kota Magelang</option>
                        <option value="Kota Pekalongan" onclick="myFunction()">Kota Pekalongan</option>
                        <option value="Kota Salatiga" onclick="myFunction()">Kota Salatiga</option>
                        <option value="Kota Semarang" onclick="myFunction()">Kota Semarang</option>
                        <option value="Kota Surakarta" onclick="myFunction()">Kota Surakarta</option>
                        <option value="Kota Tegal" onclick="myFunction()">Kota Tegal</option>
                    </select>
                </div>
            </div>
        </div>
    </main>

    <footer>
      <h4>
        <a href="/admin.php">add admin </a>&copy; Copyright
        2023-Developed by intern SMKN 7 Semarang
      </h4>
    </footer>
    <script>
     var selectElement = document.getElementById('Bidang Tindak PidanaFilter');
      // Add an event listener for the change event
      selectElement.addEventListener('change', function() {
       // Get the selected option
       var selectedOption = selectElement.value;

       // Check if Option 1 is selected
       if (selectedOption === 'all') {
          // Reload the page
          location.reload();
       }
     });

var selectElement2 = document.getElementById('lokasiFilter');
    // Add an event listener for the change event
    selectElement2.addEventListener('change', function() {
      // Get the selected option
      var selectedOption = selectElement2.value;

      // Check if Option 1 is selected
      if (selectedOption === 'all') {
        // Reload the page
        location.reload();
      }
    });
var v = document.getElementById("SubKategoriFilter");    
var w = document.getElementById("BulanFilter");
var x = document.getElementById("Bidang Tindak PidanaFilter");
var y = document.getElementById("lokasiFilter");
var z = document.getElementById("TanggalFilter");
v.addEventListener("click", myFunction);
w.addEventListener("click", myFunction);
y.addEventListener("click", myFunction);
x.addEventListener("click", myFunction);
z.addEventListener("click", myFunction);
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("Bidang Tindak PidanaFilter");
  var input2 = document.getElementById("lokasiFilter");
  var input3 = document.getElementById("BulanFilter");
  var input4 = document.getElementById("TanggalFilter");
  var input5 = document.getElementById("SubKategoriFilter");
  filter = input.value.toUpperCase(); //Bidang Tindak PidanaFilter
  var filter2 = input2.value.toUpperCase(); //lokasiFilter
  var filter3 = input3.value.toUpperCase(); //BulanFilter
  var filter4 = input4.value.toUpperCase(); //TanggalFilter
  var filter5 = input5.value.toUpperCase(); //SubKategoriFilter
  table = document.getElementById("dataTable");
  tr = table.getElementsByTagName("tr");

  var visibleIndex = 1; 

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 1; i < tr.length; i++) {
    
    td = tr[i].getElementsByTagName("td")[2]; //kolom Bidang Tindak Pidana
    var td4 = tr[i].getElementsByTagName("td")[4]; //kolom Waktu Kejadian
	var td3 = tr[i].getElementsByTagName("td")[3]; //Sub-Kategori	
    var td2 = tr[i].getElementsByTagName("td")[5]; //lokasi

	var match1 = filter === "" || (td && td.textContent.toUpperCase().indexOf(filter) > -1 ); //Bidang Tindak PidanaFilter
	var match2 = filter2 === "" || (td2 && td2.textContent.toUpperCase().split(' - ')[0].indexOf(filter2) > -1 && td2.textContent.split(' - ')[0].length == filter2.length); //lokasiFilter
	var match3 = filter3 === "" || (td4 && td4.textContent.toUpperCase().indexOf(filter3) > -1); //BulanFilter
    var match4 = filter4 === "" || (td4 && td4.textContent.toUpperCase().indexOf(filter4) > -1); //TanggalFilter
    var match5 = filter5 === "" || (td3 && td3.textContent.toUpperCase().indexOf(filter5) > -1); //SubKategoriFilter
    if (match1 && match2 && match3 && match4 && match5) {
  // td.style.display = "";
  tr[i].getElementsByTagName("td")[0].innerHTML = visibleIndex ;
	tr[i].style.display = "";
  visibleIndex++ ; 
   } else {
	tr[i].style.display= "none";
}

    }
  }
 

</script>
</body>

</html>