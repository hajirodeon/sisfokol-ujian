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
require("../../inc/class/paging.php");
require("../../inc/cek/siswa.php");
$tpl = LoadTpl("../../template/ujian.html");

nocache;

//nilai
$filenya = "mapel_soal.php";
$judul = "Soal Ujian";
$judulku = "[$ppd_session : $no4_session.$nama4_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$x_sesi = nosql($_SESSION['x_sesi']);
$gkd = nosql($_REQUEST['gkd']);
$pelkd = nosql($_REQUEST['pelkd']);
$ke_sli = "mapel_soal_finish.php?s=selesai&gkd=$gkd&pelkd=$pelkd"; //target re-direct selesai
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$limit = "1";



//body onload
$diload = "Up();";








//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek baru
if ($s == "baru")
	{
	//null-kan session
	$_SESSION['x_sesi'] = 0;

	//kosongkan pengerjaan yang telah ada
	mysql_query("DELETE FROM siswa_soal ".
					"WHERE kd_siswa = '$kd4_session' ".
					"AND kd_guru_mapel = '$gkd'");

	mysql_query("DELETE FROM siswa_soal_nilai ".
					"WHERE kd_siswa = '$kd4_session' ".
					"AND kd_guru_mapel = '$gkd'");

	//insert baru
	mysql_query("INSERT INTO siswa_soal_nilai(kd, kd_siswa, kd_guru_mapel, waktu_mulai) VALUES ".
					"('$x', '$kd4_session', '$gkd', '$today')");

	//masukkan soal...
	$qku = mysql_query("SELECT * FROM m_soal ".
				"WHERE kd_guru_mapel = '$gkd' ".
				"AND aktif = 'true' ".
				"ORDER BY round(no) ASC");
	$rku = mysql_fetch_assoc($qku);
	$tku = mysql_num_rows($qku);

	do
		{
		$ku_no = $ku_no + 1;
		$xyz = md5("$x$ku_no");
		$ku_kd = nosql($rku['kd']);

		//entri
		mysql_query("INSERT INTO siswa_soal(kd, kd_siswa, kd_guru_mapel, kd_soal) VALUES ".
				"('$xyz', '$kd4_session', '$gkd', '$ku_kd')");
		}
	while ($rku = mysql_fetch_assoc($qku));


	//re-direct
	$ke = "$filenya?gkd=$gkd&pelkd=$pelkd";
	xloc($ke);
	exit();
	}





//nek revisi
if ($s == "rev")
	{
	//null-kan session
	$_SESSION['x_sesi'] = 0;


	//cek
	$qku2 = mysql_query("SELECT * FROM siswa_soal_nilai ".
				"WHERE kd_siswa = '$kd4_session' ".
				"AND kd_guru_mapel = '$gkd'");
	$rku2 = mysql_fetch_assoc($qku2);
	$tku2 = mysql_num_rows($qku2);

	//jika belum ada
	if (empty($tku2))
		{
		//insert baru
		mysql_query("INSERT INTO siswa_soal_nilai(kd, kd_siswa, kd_guru_mapel, waktu_mulai) VALUES ".
				"('$x', '$kd4_session', '$gkd', '$today')");
		}





	//masukkan soal...
	$qku = mysql_query("SELECT * FROM m_soal ".
				"WHERE kd_guru_mapel = '$gkd' ".
				"AND aktif = 'true' ".
				"ORDER BY round(no) ASC");
	$rku = mysql_fetch_assoc($qku);
	$tku = mysql_num_rows($qku);

	do
		{
		$ku_no = $ku_no + 1;
		$xyz = md5("$x$ku_no");
		$ku_kd = nosql($rku['kd']);


		//cek
		$qku3 = mysql_query("SELECT * FROM siswa_soal ".
					"WHERE kd_siswa = '$kd4_session' ".
					"AND kd_guru_mapel = '$gkd' ".
					"AND kd_soal = '$ku_kd'");
		$rku3 = mysql_fetch_assoc($qku3);
		$tku3 = mysql_num_rows($qku3);


		//jika belum ada
		if (empty($tku3))
			{
			//entri
			mysql_query("INSERT INTO siswa_soal(kd, kd_siswa, kd_guru_mapel, kd_soal) VALUES ".
					"('$xyz', '$kd4_session', '$gkd', '$ku_kd')");
			}
		}
	while ($rku = mysql_fetch_assoc($qku));



	//re-direct
	$ke = "$filenya?gkd=$gkd&pelkd=$pelkd";
	xloc($ke);
	exit();
	}





//jika lainnya
if ($_POST['btnLAIN'])
	{
	//ambil nilai
	$gkd = nosql($_POST['gkd']);

	//re-direct
	$ke = "$filenya?gkd=$gkd";
	xloc($ke);
	exit();
	}





//jika selesai
if ($_POST['btnSLS'])
	{
	//ambil nilai
	$gkd = nosql($_POST['gkd']);

	//update
	mysql_query("UPDATE siswa_soal_nilai ".
					"SET waktu_akhir = '$today' ".
					"WHERE kd_siswa = '$kd4_session' ".
					"AND kd_guru_mapel = '$gkd'");

	//re-direct
	$ke = "mapel_soal_finish.php?s=selesai&gkd=$gkd&pelkd=$pelkd";
	xloc($ke);
	exit();
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$gkd = nosql($_POST['gkd']);
	$pelkd = nosql($_POST['pelkd']);
	$page = nosql($_POST['page']);
	$disp1 = nosql($_POST['disp1']);

	//ambil jml.detik berjalan
	$nil1_disp1 = substr($disp1,0,2); //menit

	if (strlen($nil1_disp1) == 1)
		{
		$nil1_disp1 = "0$nil1_disp1";
		}

	$nil1x_disp1 = (int)($nil1_disp1 * 60); //jadikan detik
	$nil2_disp1 = substr($disp1,-2); //detik
	$nilx_disp1 = (int)($nil1x_disp1 + $nil2_disp1);

	//penanda session timer
	if (empty($_SESSION['x_sesi']))
		{
		//session_register("x_sesi");
		$_SESSION['x_sesi'] = $nilx_disp1;
		}
	else
		{
		$_SESSION['x_sesi'] = $nilx_disp1;
		}


	for ($k=1;$k<=$limit;$k++)
		{
		$xx = md5("$x$k");

		//soalkd
		$xsoalkd = "soalkd";
		$xsoalkdx = "$xsoalkd$k";
		$xsoalkdx2 = nosql($_POST["$xsoalkdx"]);

		//jawab
		$xjawab = "jawab";
		$xjawabx = "$xjawab$k";
		$xjawabx2 = nosql($_POST["$xjawabx"]);

		//cek
		$qcc = mysql_query("SELECT * FROM siswa_soal ".
					"WHERE kd_siswa = '$kd4_session' ".
					"AND kd_guru_mapel = '$gkd' ".
					"AND kd_soal = '$xsoalkdx2'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//nek ada
		if ($tcc != 0)
			{
			//update
			mysql_query("UPDATE siswa_soal SET jawab = '$xjawabx2' ".
					"WHERE kd_siswa = '$kd4_session' ".
					"AND kd_guru_mapel = '$gkd' ".
					"AND kd_soal = '$xsoalkdx2'");
			}
		else
			{
			//insert
			mysql_query("INSERT INTO siswa_soal(kd, kd_siswa, kd_guru_mapel, kd_soal, jawab) VALUES".
					"('$xx', '$kd4_session', '$gkd', '$xsoalkdx2', '$xjawabx2')");
			}
		}
	while ($data = mysql_fetch_assoc($result));


	//re-direct
	$ke = "$filenya?gkd=$gkd&pelkd=$pelkd&page=$page";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//mapel terpilih ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qmpx = mysql_query("SELECT * FROM m_mapel ".
					"WHERE kd = '$pelkd'");
$rowmpx = mysql_fetch_assoc($qmpx);
$mpx_mapel = balikin($rowmpx['mapel']);


//pel-nya
$quru = mysql_query("SELECT * FROM guru_mapel ".
						"WHERE kd = '$gkd'");
$ruru = mysql_fetch_assoc($quru);
$mpx_kd = nosql($ruru['kd']);
$mpx_bobot = nosql($ruru['bobot']);
$mpx_menit2 = nosql($ruru['jml_menit']);
$mpx_menit = 2 * $mpx_menit2;
$mpx_detik = $mpx_menit2 * 60; //detik




//m_soal
$qsol = mysql_query("SELECT * FROM m_soal ".
			"WHERE kd_guru_mapel = '$gkd'");
$rsol = mysql_fetch_assoc($qsol);
$tsol = mysql_num_rows($qsol);




//ujian. utk. tag META Refresh & settimeout //////////////////////////////////////////////////////////////
if (empty($s)) //jika bukan baru, apalagi edit. ini real time...
	{
//	$wkdet = (($mpx_menit * 60) - $x_sesi); //detik
	$wkdet = (($mpx_menit * 60) - $x_sesi); //detik
	$ke_sli = "mapel_soal_finish.php?s=selesai&gkd=$gkd&pelkd=$pelkd";
	$wkurl = $ke_sli;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////





//utk. counter real time (js) ////////////////////////////////////////////////////////////////////////////
$nil_mnt = (int)($wkdet / 60); //batas waktu menit
$nil_dtk = $wkdet % 60; //batas waktu detik

//ke-n
$nil_mnt_seli = $mpx_menit - $nil_mnt; //menit ke-n
$nil_dtk_seli = 60 - $nil_dtk; //detik ke-n

//nek 1
if ($nil_mnt_seli >= 1)
	{
	$nil_mnt_seli = $nil_mnt_seli - 1;
	}


//nek 60 ////////////////////////////////////////////////////
if ($nil_dtk_seli == 60)
	{
	if ($x_sesi < 60)
		{
		$nil_mnt_seli = 0;
		}

	else if ($x_sesi == 60)
		{
		$nil_mnt_seli = 1;
		}

	else if ($x_sesi >= 120)
		{
		$nil_mnt_seli = $nil_mnt_seli + 1;
		}


	//nol-kan detik
	$nil_dtk_seli = 0;
	}
//nek 60 ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////



//deteksi jika telah dikerjakan
$qdte = mysql_query("SELECT * FROM siswa_soal_nilai ".
			"WHERE kd_siswa = '$kd4_session' ".
			"AND kd_guru_mapel = '$gkd'");
$rdte = mysql_fetch_assoc($qdte);
$dte_akhir = $rdte['waktu_akhir'];

if ((!empty($_SESSION['x_sesi'])) AND ($dte_akhir != "0000-00-00 00:00:00"))
	{
	//re-direct
	$pesan = "Anda Sudah Melakukan Ujian. Jika Ingin Melakukan Lagi, Silahkan Kerjakan Lagi. Terima Kasih.";
	$ke = "$filenya?s=baru&gkd=$gkd&pelkd=$pelkd";
	pekem($pesan,$ke);
	exit();
	}







//isi *START
ob_start();



//js
require("../../inc/js/swap.js");
require("../../inc/menu/siswa.php");
require("inc_counter.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
Mata Pelajaran :
<br>
<input name="nilx3" size="30" type="text" value="'.$mpx_mapel.'" class="input" readonly>
</p>


<p>
Jumlah Soal : <strong>'.$tsol.'</strong>.
Bobot Nilai : <strong>'.$mpx_bobot.'</strong>.
Waktu Pengerjaan : <strong>'.$mpx_menit2.' Menit.</strong>
<br>
<br>';

//query
$p = new Pager();
$start = $p->findStart($limit);

/*
$sqlcount = "SELECT DISTINCT(m_soal.kd) AS soalkd ".
		"FROM m_soal ".
		"WHERE m_soal.kd_guru_mapel = '$gkd' ".
		"AND m_soal.aktif = 'true' ".
		"ORDER BY round(m_soal.no) ASC";
$sqlresult = $sqlcount;

*/

$sqlcount = "SELECT DISTINCT(m_soal.kd) AS soalkd ".
		"FROM m_soal, siswa_soal ".
		"WHERE siswa_soal.kd_soal = m_soal.kd ".
		"AND siswa_soal.kd_siswa = '$kd4_session' ".
		"AND siswa_soal.jawab = '' ".
		"AND siswa_soal.kd_guru_mapel = '$gkd' ".
		"AND m_soal.kd_guru_mapel = '$gkd' ".
		"AND m_soal.aktif = 'true' ".
		"ORDER BY RAND()";
$sqlresult = $sqlcount;




$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$target = "$filenya?gkd=$gkd";
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


//waktu mulai
$qmul = mysql_query("SELECT * FROM siswa_soal_nilai ".
							"WHERE kd_siswa = '$kd4_session' ".
							"AND kd_guru_mapel = '$gkd'");
$rmul = mysql_fetch_assoc($qmul);
$mul_mulai = $rmul['waktu_mulai'];


$_SESSION['start'] = time();
$_SESSION['expire'] = $_SESSION['start'] + ($mpx_menit2 * 60);


//detik
$jmldetik = $mpx_menit2 * 60;

function setExpires($jmldetik) 
	{
	$nilku = gmdate('D, d M Y H:i:s', time()+$jmldetik);
	header('Expires: $nilku GMT');
	}
	
setExpires($jmldetik);



//jika waktu habis
$now = time(); 
if ($now > $_SESSION['expire']) 
		{
        session_destroy();
		
		//re-direct
		$ke_sli = "mapel_soal_finish.php?s=selesai&gkd=$gkd&pelkd=$pelkd";
		xloc($ke_sli);
		exit();
		}
			


echo 'Tgl & Jam Mulai :
<input name="nilx2" size="20" type="text" value="'.$mul_mulai.'" class="input" readonly>,
Waktu Pengerjaan :
<input name="disp1" size="7" type="text" class="input" readonly>
<img src="'.$sumber.'/img/sebentar.gif" width="16" height="16">
<br>';

//timeout
echo '<script>setTimeout("location.href=\''.$ke_sli.'\'", '.$wkdet.'000);</script>
<iframe name="ifr_sesi" frameborder="0" height="0" width="0" src="ifr_sesi.php"></iframe>
<table width="100%" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td><strong><font color="'.$warnatext.'">Soal</font></strong></td>
</tr>';

if ($count != 0)
	{
	do
		{
		if ($warna_set ==0)
			{
			$warna = "white";
			$warna_set = 1;
			}
		else
			{
			$warna = "white";
			$warna_set = 0;
			}

		$nomer = $nomer + 1;
		$kd = nosql($data['soalkd']);



		//detal
		$qdt = mysql_query("SELECT * FROM m_soal ".
					"WHERE kd = '$kd'");
		$rdt = mysql_fetch_assoc($qdt);
		$d_no = nosql($rdt['no']);
		$d_isi = balikin($rdt['isi']);
		$d_isi2 = pathasli2($d_isi);

		//yang dijawab
		$qjbu = mysql_query("SELECT * FROM siswa_soal ".
					"WHERE kd_siswa = '$kd4_session' ".
					"AND kd_guru_mapel = '$gkd' ".
					"AND kd_soal = '$kd'");
		$rjbu= mysql_fetch_assoc($qjbu);
		$d_jawab = nosql($rjbu['jawab']);

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		<input name="soalkd'.$nomer.'" type="hidden" value="'.$kd.'">
		'.$d_isi2.'
		<p>
		<hr>
		<strong>Jawab :</strong>
		<select name="jawab'.$nomer.'">
		<option value="'.$d_jawab.'" selected>'.$d_jawab.'</option>
		<option value="A">A</option>
		<option value="B">B</option>
		<option value="C">C</option>
		<option value="D">D</option>
		<option value="E">E</option>
		</select>
		<hr>
		</p>
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));
	}


echo '</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td width="263">
<input name="jml" type="hidden" value="'.$total.'">
<input name="gkd" type="hidden" value="'.$gkd.'">
<input name="pelkd" type="hidden" value="'.$pelkd.'">
<input name="page" type="hidden" value="'.$page.'">
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnLAIN" type="submit" value="LIHAT SOAL LAINNYA">
<input name="btnSLS" type="submit" value="SELESAI DAN KUMPULKAN >>">
</td>
<td align="right">'.$pagelist.'
Sisa Soal Belum Terjawab : <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
</tr>
</table>
</form>
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