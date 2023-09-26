<?php
include('session.php');
?>

<!DOCTYPE html>
<html>
<head>
  <title>Geographical Criminal Information System</title>
  <link rel="stylesheet" href="admin.css">
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
        <h1>DIREKTORAT RESERSE KRIMINAL KHUSUS POLDA JAWA TENGAH </h1>
        </div>
        </div>
    </header>

    <!-- halaman body -->
<div class="nama">
  <h2>ADMIN</h2>
</div>
    <div class="container1">

      <form id="admin-form" action="send.php" method="post">
        <div class="input-group">
          <label for="case-name">Nama Kasus</label>
          <input type="text" id="Nama-Kasus" name="Nama-Kasus" placeholder="Masukkan Kasus" required>
        </div>
        <div class="input-group">
          <label for="bidang-tindak-pidana">Bidang Tindak Pidana</label>
          <select id="bidang-tindak-pidana" onchange="Options()" name="bidang-tindak-pidana" required>
            <option value="">Pilih Bidang Tindak Pidana</option>
           <option value="INDAGSI">INDAGSI</option>
            <option value="EKSUS">EKSUS</option>
            <option value="TIPIDKOR">TIPIDKOR</option>
            <option value="TIPIDTER">TIPIDTER</option>
            <option value="SIBER">SIBER</option>
          </select>
        </div>
        <div class="input-group">
          <label for="SubKategoriFilter">Sub-Kategori</label>
          <select id="SubKategoriFilter" name="SubKategoriFilter" required>
            <option value="">Pilih Sub-Kategori</option>
          </select>
        </div>
        <div class="input-group">
	<label for="city">Kota / Kabupaten</label>
	  <select id="city" onchange="showOptions()" name="city" required>
	    <option value="">Pilih Kota / Kabupaten</option>
      <option value="Banjarnegara">Banjarnegara</option>
      <option value="Banyumas">Banyumas</option>
      <option value="Batang">Batang</option>
      <option value="Blora">Blora</option>
      <option value="Boyolali">Boyolali</option>
      <option value="Brebes">Brebes</option>
      <option value="Cilacap">Cilacap</option>
      <option value="Demak">Demak</option>
      <option value="Grobogan">Grobogan</option>
      <option value="Jepara">Jepara</option>
      <option value="Karanganyar">Karanganyar</option>
      <option value="Kebumen">Kebumen</option>
      <option value="Kendal">Kendal</option>
      <option value="Klaten">Klaten</option>
      <option value="Kudus">Kudus</option>
      <option value="Magelang">Magelang</option>
      <option value="Pati">Pati</option>
      <option value="Pekalongan">Pekalongan</option>
      <option value="Pemalang">Pemalang</option>
      <option value="Purbalingga">Purbalingga</option>
      <option value="Purworejo">Purworejo</option>
      <option value="Rembang">Rembang</option>
      <option value="Semarang">Semarang</option>
      <option value="Sragen">Sragen</option>
      <option value="Sukoharjo">Sukoharjo</option>
      <option value="Tegal">Tegal</option>
      <option value="Temanggung">Temanggung</option>
      <option value="Wonogiri">Wonogiri</option>
      <option value="Wonosobo">Wonosobo</option>
      <option value="Kota Magelang">Kota Magelang</option>
      <option value="Kota Pekalongan">Kota Pekalongan</option>
      <option value="Kota Salatiga">Kota Salatiga</option>
      <option value="Kota Semarang">Kota Semarang</option>
      <option value="Kota Surakarta">Kota Surakarta</option>
      <option value="Kota Tegal">Kota Tegal</option>
	  </select>
        </div>
	<div class="input-group">
	<label for="subDistrict">Kecamatan</label>
	  <select id="subDistrict" name="subDistrict" required>
	    <option value="">Pilih Kecamatan</option>
	  </select>

	</div>
        <div class="input-group">
          <label for="incident-time">Waktu Kejadian</label>
          <input type="datetime-local" id="incident-time" name="incident-time" required>
        </div>
        <div class="submit-button">
          <button type="submit">+ Tambah Kasus</button>
        </div>
      </form>
    </div>
  </div>
<script>
    function showOptions() {
      var citySelect = document.getElementById("city");
      var subDistrictSelect = document.getElementById("subDistrict");
      var selectedCity = citySelect.value;
      subDistrictSelect.innerHTML = ""; // Clear previous options

      if (selectedCity === "Banjarnegara") {
        var options = ["Banjarmangu", "Banjarnegara", "Batur", "Bawang", "Kalibening", "karangkobar", "Madukara",
        "Mandiraja", "Pagedongan", "Pagentan", "Pandanarum", "Pejawaran", "Punggelan", "Purwanegara", "Purworeja Klampok",
        "Rakit", "Sigaluh", "Susukan", "Wanadadi", "Wanayasa"];
        addOptions(subDistrictSelect, options);
      } else if (selectedCity === "Banyumas") {
        var options = ["Ajibarang", "Banyumas", "Baturaden", "Cilongok", "Gumelar", "Kalibagor", "Karanglewas", 
        "Kebasen", "Kedung Banteng", "Kembaran", "Kemranjen", "Jatilawang", "Lumbir", "Patikraja", "Pekuncen",
        "Purwojati", "Purwokerto Barat", "Purwokerto Selatan", "Purwokerto Timur", "Purwokerto Utara", "Rawalo",
        "Sokaraja", "Somagede", "Sumbang", "Sumpiuh", "Tambak", "Wangon"];
        addOptions(subDistrictSelect, options);
      } else if (selectedCity === "Batang") {
        var options = ["Limpung", "Pecalungan", "Bandar", "Banyuputih", "Batang", "Bawang", "Blado", "Gringsing",
        "Kandeman", "Reban", "Subah", "Tersono", "Tulis", "Warungasem", "Wonotunggal"];
        addOptions(subDistrictSelect, options);
      } else if (selectedCity === "Blora") {
        var options = ["Banjarejo", "Blora", "Bogorejo", "Cepu", "Japah", "Jati", "Jepon", "Jiken", "Kedungtuban",
        "Kradenan", "Kunduran", "Ngawen", "Randublatung", "Sambong", "Todanan", "Tunjungan"];
        addOptions(subDistrictSelect, options);
      } else if (selectedCity === "Boyolali") {
        var options = ["Ampel", "Andong", "Banyudono", "Boyolali", "Cepogo", "Gladagsari", "Juwangi", "Karanggede",
        "Kemusu", "Klego", "Mojosongo", "Musuk", "Ngemplak", "Nogosari", "Sambi", "Sawit", "Selo", "Simo", "Tamansari",
        "Teras", "Wonosamodro", "Wonosegoro"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Brebes") {
        var options = ["Banjarharjo", "Bantarkawung", "Brebes", "Bulakamba", "Bumiayu", "Jatibarang", "Kersana",
        "Ketanggungan", "Larangan", "Losari", "Paguyangan", "Salem", "Sirampog", "Songgom", "Tanjung", "Tonjong",
        "Wanasari"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Cilacap") {
        var options = ["Adipala", "Bantarsari", "Binangun", "Cilacap Selatan", "Cilacap Tengah", "Cilacap Utara",
        "Cimanggu", "Cipari", "Dayeuhluhur", "Gandrungmangu", "Jeruklegi", "Kampung Laut", "Karangpucung",
        "Kawunganten", "Kedungreja", "Kesugihan", "Kroya", "Majenang", "Maos", "Nusawungu", "Patimuan", "Sampang",
        "Sidareja", "Wanareja"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Demak") {
        var options = ["Bonang", "Demak", "Dempet", "Gajah", "Guntur", "Karanganyar", "Karangawen", "Karangtengah",
        "Kebonagung", "Mijen", "Mranggen", "Sayung", "Wedung", "Wonosalam"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Grobogan") {
        var options = ["Brati", "Gabus", "Geyer", "Godong", "Grobogan", "Gubug", "Karangrayung", "Kedungjati",
        "Klambu", "Kradenan", "Ngaringan", "Penawangan", "Pulokulon", "Purwodadi", "Tanggungharjo", "Tawangharjo",
        "Tegowanu", "Toroh", "Wirosari"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Jepara") {
        var options = ["Bangsri", "Batealit", "Donorojo", "Jepara", "Kalinyamatan", "Karimunjawa", "Kedung", "Keling",
        "Kembang", "Mayong", "Mlonggo", "Nalumsari", "Pakis Aji", "Pecangaan", "Tahunan", "Welahan"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Karanganyar") {
        var options = ["Colomadu", "Gondangrejo", "Jaten", "Jatipuro", "Jatiyoso", "Jenawi", "Jumapolo", "Jumantono",
        "Karanganyar", "Karangpandan", "Kebakkramat", "Kerjo", "Matesih", "Ngargoyoso", "Mojogedang", "Tasikmadu",
        "Tawangmangu"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Kebumen") {
        var options = ["Adimulyo", "Alian", "Ambal", "Ayah", "Bonorowo", "Buayan", "Buluspesantren", "Gombong",
        "Karanganyar", "Karanggayam", "Karangsambung", "Kebumen", "Klirong", "Kutowinangun", "Kuwarasan", "Mirit",
        "Padureso", "Pejagoan", "Petanahan", "Prembun", "Poncowarno", "Puring", "Rowokele", "Sadang", "Sempor",
        "Sruweng"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Kendal") {
        var options = ["Brangsong", "Boja", "Cepiring", "Gemuh", "Kaliwungu", "Kaliwungu Selatan", "Kendal", "Limbangan",
        "Ngampel", "Plantungan", "Pageruyung", "Patean", "Patebon", "Pegandon", "Ringinarum", "Rowosari", "Singorojo",
        "Sukorejo", "Weleri"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Klaten") {
        var options = ["Bayat", "Cawas", "Ceper", "Delanggu", "Gantiwarno", "Jatinom", "Jogonalan", "Juwiring", "Kalikotes",
        "Karanganom", "Karangdowo", "Karangnongko", "Kebonarum", "Kemalang", "Klaten Selatan", "Klaten Tengah", "Klaten Utara",
        "Manisrenggo", "Ngawen", "Pedan", "Polanharjo", "Prambanan", "Trujuk", "Tulung", "Wonosari"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Kudus") {
        var options = ["Bae", "Dawe", "Gebog", "Jati", "Jekulo", "Kaliwungu", "Kudus", "Mejobo", "Undaan"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Magelang") {
        var options = ["Bandongan", "Borobudur", "Candimulyo", "Dukun", "Grabag", "Kajoran", "Kaliangkrik", "Mertoyudan",
        "Mungkid", "Muntilan", "Ngablak", "Ngluwar", "Pakis", "Salam", "Salamaan", "Sawangan", "Secang", "Srumbung",
        "Tegalrejo", "Tempuran", "Windusari"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Pati") {
        var options = ["Batangan", "Ciluwak", "Dukuhseti", "Gabus", "Gembong", "Gunungwungkal", "Jaken", "Jakenan",
        "Juwana", "Kayen", "Margorejo", "Margoyoso", "Pati", "Pucakwangi", "Sukolilo", "Tambakromo", "Tayu", "Tlogowungu",
        "Trangkil", "Wedarijaksa", "Winong"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Pekalongan") {
        var options = ["Bojong", "Buaran", "Doro", "Kajen", "Kandangserang", "Karanganyar", "Karangdadap", "Kedungwuni",
        "Kesesi", "Lebakbarang", "Paninggaran", "Petungkriyono", "Siwalan", "Sragi", "Talun", "Tirto", "Wiradesa",
        "Wonokerto", "Wonopringgo"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Pemalang") {
        var options = ["Ampelgading", "Bantarbolang", "Belik", "Bodeh", "Comal", "Moga", "Pemalang", "Petarukan",
        "Pulosari", "Randudongkal", "Taman", "Ulujami", "Warungpring", "Watukumpul"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Purbalingga") {
        var options = ["Bobotsari", "Bojongsari", "Bukateja", "Kaligondang", "Kalimanah", "Karanganyar", "Karangjambu",
        "Karangmoncol", "Karangreja", "Kejobong", "Kemangkon", "Kertanegara", "Kutasari", "Mrebet", "Padamara",
        "Pengadegan", "Purbalingga", "Rembang"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Purworejo") {
        var options = ["Bagelen", "Banyuurip", "Bayan", "Bener", "Bruno", "Butuh", "Gebang", "Grabag", "Kaligesing",
        "Kemiri", "Kutoarjo", "Loano", "Pituruh", "Purwodadi", "Purworejo", "Ngombol"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Rembang") {
        var options = ["Bulu", "Gunem", "Kaliori", "Kragan", "Lasem", "Pamotan", "Pancur", "Rembang", "Sale", "Sarang",
        "Sedan", "Sluke", "Sulang", "Sumber"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Sragen") {
        var options = ["Gemolong", "Gesi", "Gondang", "Jenar", "Kalijambe", "Karangmalang", "Kedawung", "Masaran", "Miri",
        "Mondokan", "Ngrampal", "Lupuh", "Sambirejo", "Sambungmacan", "Sidoharjo", "Sragen", "Sukodono", "Sumberlawang",
        "Tangen", "Tanon"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Semarang") {
        var options = ["Ambarawa", "Bancak", "Bandungan", "Banyubiru", "Bawen", "Bergas", "Bringin", "Getasan", "Jambu",
        "Kaliwungu", "Pabelan", "Pringapus", "Suruh", "Susukan", "Sumowono", "Tengaran", "Tuntang", "Ungaran Barat",
        "Ungaran Timur"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Sukoharjo") {
        var options = ["Baki", "Bendosari", "Bulu", "Gatak", "Grogol", "Kartasura", "Mojolaban", "Nguter", "Polokarto",
        "Sukoharjo", "Tawangsari", "Weru"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Temanggung") {
        var options = ["Bansari", "Bejen", "Bulu", "Candiroto", "Gemawang", "Jumo", "Kaloran", "Kandangan" ,"Kedu",
        "Kledung", "Kranggan", "Ngadirejo", "Parakan", "Pringsurat", "Selopampang", "Temanggung", "Tembarak", "Tlogomulyo",
        "Tretep", "Wonoboyo"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Tegal") {
        var options = ["Adiwerna", "Balapulang", "Bojong", "Bumijawa", "Dukuhturi", "Dukuhwaru", "Jatinegara", "Kedungbanteng",
        "Kramat", "Lebaksiu", "Margasari", "Pagerbarang", "Pangkah", "Slawi", "Suradadi", "Talang", "Taruh", "Warureja"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Wonogiri") {
        var options = ["Baturetno", "Batuwarno", "Bulukerto", "Eromoko", "Girimarto", "Giritronto", "Giriwoyo", "Jatipurno",
        "Jatiroto", "Jatisrono", "Karangtengah", "Kismantoro", "Manyaran", "Ngadirojo", "Nguntoronadi", "Paranggupito",
        "Pracimantoro", "Puhpelem", "Purwantoro", "Selogiri", "Sidoharjo", "Slogohimo", "Tirtomoyo", "Wonogiri", "Wuryantoro"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Wonosobo") {
        var options = ["Garung", "Kalibawang", "Kalikajar", "Kaliwiro", "Kejajar", "Kepil", "Kertek", "Leksono", "Mojotengah",
        "Sapuran", "Selomerto", "Sukoharjo", "Wadaslintang", "Watumalang", "Wonosobo"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Kota Magelang") {
        var options = ["Magelang Selatan", "Magelang Tengah", "Magelang Utara"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Kota Pekalongan") {
        var options = ["Pekalongan Barat", "Pekalongan Selatan", "Pekalongan Timur", "Pekalongan Utara"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Kota Surakarta") {
        var options = ["Banjarsari", "Jebres", "Laweyan", "Pasar Kliwon", "Serengan"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Kota Salatiga") {
        var options = ["Argomulyo", "Sidorejo", "Sidomukti", "Tingkir"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Kota Semarang") {
        var options = ["Banyumanik", "Candisari", "Gajahmungkur", "Gayamsari", "Genuk", "Gunungpati", "Mijen",
        "Ngaliyan", "Pedurungan", "Semarang Barat", "Semarang Selatan", "Semarang Tengah", "Semarang Timur", "Semarang Utara",
        "Tembalang", "Tugu"];
        addOptions(subDistrictSelect, options); 
      } else if (selectedCity === "Kota Tegal") {
        var options = ["Margadana", "Tegal Barat", "Tegal Selatan", "Tegal Timur"];
        addOptions(subDistrictSelect, options); 
      }
    }

    function addOptions(selectElement, options) {
      for (var i = 0; i < options.length; i++) {
        var option = document.createElement("option");
        option.text = options[i];
        option.value = options[i];
        selectElement.add(option);
      }
    }

    function Options() {
      var bidangSelect = document.getElementById("bidang-tindak-pidana");
      var SubKategoriFilterSelect = document.getElementById("SubKategoriFilter");
      var selectedbidang = bidangSelect.value;
      SubKategoriFilterSelect.innerHTML = "";
      
      if (selectedbidang === "INDAGSI") {
        var options = ["Hak Kekayaan Intelektual", "Perfilman", "Budidaya Tanaman", "Telekomunikasi", "Penyiaran / Pers", "Perumahan / Pemukiman",
        "Asuransi", "Investasi", "Penanaman Modal", "Industri", "Pangan", "Perlindungan Konsumen", "Perdagangan", "Kesehatan",
        "Kepabeanan", "Karantina"];
        addOptions(SubKategoriFilterSelect, options);
      } else if (selectedbidang === "EKSUS") {
        var options = ["Fidusia", "Perbankan", "Perkoperasian", "Transfer Dana", "Pencucian Uang", "Uang Palsu"];
        addOptions(SubKategoriFilterSelect, options);
      } else if (selectedbidang === "TIPIDKOR") {
        var options = ["Undang - Undang TIPIDKOR"];
        addOptions(SubKategoriFilterSelect, options);
      } else if (selectedbidang === "TIPIDTER") {
        var options = ["Illegal Logging", "Konservasi Sumber Daya Alam", "Illegal Minning", "Minyak & Gas", "Ketenaga Listrikan", "Kesehatan", "Lingkungan Hidup",
        "Sumber Daya Air", "Illegal Fishing", "Perikanan", "Peternakan", "Cagar Budaya", "Perkebunan", "Ketenagakerjaan"];
        addOptions(SubKategoriFilterSelect, options);
      } else if (selectedbidang === "SIBER") {
        var options = ["Tindak Pidana Informasi & Transaksi Elektronik", "Pornografi", "Telekomunikasi"];
        addOptions(SubKategoriFilterSelect, options);
      }
    }

      

  </script>
<br>
<br>
<br>

<footer>
    <h4>&copy; Copyright 
      2023-Developed by intern SMKN 7 Semarang</h4>
</footer>
</body>
</html>