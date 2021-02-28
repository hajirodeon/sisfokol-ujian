<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL-UjianOnline                                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * https://github.com/hajirodeon                     ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// SMS/WA/TELEGRAM	: 081-829-88-54                         ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////





session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/siswa.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "mapel_soal_finish.php";
$judul = "Ujian Telah Usai";
$judulku = "[$ppd_session : $no4_session.$nama4_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$gkd = nosql($_REQUEST['gkd']);
$pelkd = nosql($_REQUEST['pelkd']);





//ketahui tapel aktif
$qtp = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
			"WHERE status = 'true'");
$rtp = mysqli_fetch_assoc($qtp);
$tp_tapelkd = nosql($rtp['kd']);
$tp_tahun1 = nosql($rtp['tahun1']);
$tp_tahun2 = nosql($rtp['tahun2']);




//PROSES/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika usai
if ($s == "selesai")
	{
	//update
	mysqli_query($koneksi, "UPDATE siswa_soal_nilai ".
					"SET waktu_akhir = '$today' ".
					"WHERE kd_siswa = '$kd4_session' ".
					"AND kd_guru_mapel = '$gkd'");

	//re-direct
	$ke = "$filenya?gkd=$gkd&pelkd=$pelkd";
	xloc($ke);
	exit();
	}





//jika lagi... pelajaran yang sama
if ($_POST['btnLGI'])
	{
	//ambil nilai
	$gkd = nosql($_POST['gkd']);
	$pelkd = nosql($_POST['pelkd']);

	//kosongkan session rimer
	$_SESSION['x_sesi'] = 0;

/*
	//kosongkan pengerjaan yang telah ada
	mysqli_query($koneksi, "DELETE FROM siswa_soal ".
			"WHERE kd_siswa = '$kd4_session' ".
			"AND kd_guru_mapel = '$gkd'");
*/
	mysqli_query($koneksi, "UPDATE siswa_soal SET jawab = '' ".
			"WHERE kd_siswa = '$kd4_session' ".
			"AND kd_guru_mapel = '$gkd'");


	mysqli_query($koneksi, "DELETE FROM siswa_soal_nilai ".
			"WHERE kd_siswa = '$kd4_session' ".
			"AND kd_guru_mapel = '$gkd'");

	//re-direct
	$ke = "mapel_soal.php?s=baru&gkd=$gkd&pelkd=$pelkd";
	xloc($ke);
	exit();
	}





//kerjakan pelajaran lain
if ($_POST['btnPEL'])
	{
	//kosongkan session rimer
	$_SESSION['x_sesi'] = 0;

	//re-direct
	$ke = "../index.php";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//isi *START
ob_start();


//js
require("../../inc/js/swap.js");
require("../../inc/menu/siswa.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//mapel
$qmpx = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
						"WHERE kd = '$pelkd'");
$rowmpx = mysqli_fetch_assoc($qmpx);
$mpx_kd = nosql($rowmpx['kd']);
$mpx_mapel = balikin($rowmpx['mapel']);



//pel-nya
$quru = mysqli_query($koneksi, "SELECT * FROM guru_mapel ".
						"WHERE kd = '$gkd'");
$ruru = mysqli_fetch_assoc($quru);
$mpx_kd = nosql($ruru['kd']);
$mpx_bobot = nosql($ruru['bobot']);
$mpx_menit = nosql($ruru['jml_menit']);





//m_soal
$qsol = mysqli_query($koneksi, "SELECT * FROM m_soal ".
						"WHERE kd_guru_mapel = '$gkd'");
$rsol = mysqli_fetch_assoc($qsol);
$tsol = mysqli_num_rows($qsol);


//soal yang dikerjakan
$qsyd = mysqli_query($koneksi, "SELECT * FROM siswa_soal ".
			"WHERE kd_siswa = '$kd4_session' ".
			"AND kd_guru_mapel = '$gkd' ".
			"AND jawab <> ''");
$rsyd = mysqli_fetch_assoc($qsyd);
$tsyd = mysqli_num_rows($qsyd);




//jml. jawaban BENAR
$qju = mysqli_query($koneksi, "SELECT siswa_soal.*, m_soal.* ".
			"FROM siswa_soal, m_soal ".
			"WHERE siswa_soal.kd_soal = m_soal.kd ".
			"AND siswa_soal.kd_siswa = '$kd4_session' ".
			"AND siswa_soal.kd_guru_mapel = '$gkd' ".
			"AND siswa_soal.jawab = m_soal.kunci");
$rju = mysqli_fetch_assoc($qju);
$tju = mysqli_num_rows($qju);


//jml. jawaban SALAH
$tsalah = round($tsyd - $tju);

//waktu mulai dan akhir
$qjux = mysqli_query($koneksi, "SELECT * FROM siswa_soal_nilai ".
			"WHERE kd_siswa = '$kd4_session' ".
			"AND kd_guru_mapel = '$gkd'");
$rjux = mysqli_fetch_assoc($qjux);
$wk_mulai = $rjux['waktu_mulai'];
$wk_akhir = $rjux['waktu_akhir'];


//total skor
//$tskor = $mpx_bobot * $tju;
$tskor = 0.25 * $tju;
$wuk_nilku = $mpx_bobot * $tskor;


//update nilai
mysqli_query($koneksi, "UPDATE siswa_soal_nilai ".
		"SET jml_benar = '$tju', ".
		"jml_salah = '$tsalah', ".
		"skor = '$tskor' ".
		"WHERE kd_siswa = '$kd4_session' ".
		"AND kd_guru_mapel = '$gkd'");



//cek
$qcc2 = mysqli_query($koneksi, "SELECT * FROM siswa_tertulis ".
			"WHERE kd_siswa = '$kd4_session' ".
			"AND kd_guru_mapel = '$gkd'");
$rcc2 = mysqli_fetch_assoc($qcc2);
$tcc2 = mysqli_num_rows($qcc2);

//jika ada
if ($tcc2 != 0)
	{
	//entry update
	mysqli_query($koneksi, "UPDATE siswa_tertulis SET nilai = '$wuk_nilku' ".
			"WHERE kd_siswa = '$kd4_session' ".
			"AND kd_guru_mapel = '$gkd'");
	}
else
	{
	mysqli_query($koneksi, "INSERT INTO siswa_tertulis(kd, kd_siswa, kd_guru_mapel, nilai) VALUES ".
			"('$x', '$kd4_session', '$gkd', '$wuk_nilku')");
	}



//ciptakan session, banyaknya pengerjaan...
$jml_sesiku = $_SESSION[$gkd];



//jika null
if (empty($jml_sesiku))
	{
	//buat sesi jml = 1
	$_SESSION[$gkd] = "1";
	}
else
	{
	$_SESSION[$gkd] = $jml_sesiku + 1;
	}






echo '<form action="'.$filenya.'" method="post" name="formx">';




echo '<p>
Mata Pelajaran :
<br>
<input name="nil1" type="text" value="'.$mpx_mapel.'" size="30" class="input" readonly>
</p>

<p>
Bobot Nilai :
<br>
<input name="nil2" type="text" value="'.$mpx_bobot.'" size="5" class="input" readonly>
</p>

<p>
Batas Waktu Pengerjaan :
<br>
<input name="nil3" type="text" value="'.$mpx_menit.' Menit." size="15" class="input" readonly>
</p>


<p>
Waktu Mulai Pengerjaan :
<br>
<input name="nil4" type="text" value="'.$wk_mulai.'" size="20" class="input" readonly>
</p>

<p>
Waktu Selesai Pengerjaan :
<br>
<input name="nil5" type="text" value="'.$wk_akhir.'" size="20" class="input" readonly>
</p>

<p>
Jumlah Soal yang Dikerjakan :
<br>
<input name="nil6" type="text" value="'.$tsyd.'" size="5" class="input" readonly>
</p>

<p>
Jumlah Jawaban Benar :
<br>
<input name="nil7" type="text" value="'.$tju.'" size="5" class="input" readonly>
</p>
<p>
jumlah Jawaban Salah :
<br>
<input name="nil8" type="text" value="'.$tsalah.'" size="5" class="input" readonly>
</p>
<br>';









//nilai tertulis ////////////////////////////////////////////////////////////////////////////////////
//skor
$qcku = mysqli_query($koneksi, "SELECT SUM(nilai) AS nilku ".
			"FROM siswa_tertulis ".
			"WHERE kd_siswa = '$kd4_session'");
$rcku = mysqli_fetch_assoc($qcku);
$nil_tertulis = round(nosql($rcku['nilku']),2);








echo '<p>
<input name="gkd" type="hidden" value="'.$gkd.'">
<input name="pelkd" type="hidden" value="'.$pelkd.'">
<input name="btnPEL" type="submit" value="Ujian Pelajaran Lain">
</p>';


echo '</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>