<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL-UjianOnline                                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * http://yahoogroup.com/groups/linuxbiasawae/       ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS	: 081-829-88-54                                 ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////




session_start();


//ambil nilai
require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");
$tpl = LoadTpl("template/login.html");


nocache;

//nilai
$filenya = "login.php";
$judul = "Login";
$judulku = $judul;
$pesan = "PASSWORD SALAH. HARAP DIULANGI...!!!";
$s = nosql($_REQUEST['s']);





//ketahui tapel aktif
$qtp = mysql_query("SELECT * FROM m_tapel ".
					"WHERE status = 'true'");
$rtp = mysql_fetch_assoc($qtp);
$tp_tapelkd = nosql($rtp['kd']);
$tp_tahun1 = nosql($rtp['tahun1']);
$tp_tahun2 = nosql($rtp['tahun2']);





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnOK'])
	{
	//ambil nilai
	$aksess = nosql($_POST["aksess"]);
	$username = nosql($_POST["usernamex"]);
	$password = md5(nosql($_POST["passwordx"]));

	//cek null
	if ((empty($aksess)) OR (empty($username)) OR (empty($password)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//jika siswa
		if ($aksess == "tp01")
			{
			//query
			$q = mysql_query("SELECT siswa.*, siswa.kd AS sckd, ".
								"siswa.nama AS scnama ".
								"FROM siswa ".
								"WHERE siswa.usernamex = '$username' ".
								"AND siswa.passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);
	
			//cek login
			if ($total != 0)
				{
				session_start();
	
				//nilai
				$_SESSION['kd4_session'] = nosql($row['sckd']);
				$_SESSION['no4_session'] = nosql($row['scno']);
				$_SESSION['nama4_session'] = nosql($row['scnama']);
				$_SESSION['username4_session'] = $username;
				$_SESSION['ppd_session'] = "SISWA";
				$kd4_session = nosql($row['sckd']);
				$no4_session = nosql($row['scno']);
				$nama4_session = nosql($row['scnama']);
				$username4_session = $username;
				$ppd_session = "SISWA";
	
	
	
				//entri history ////////////////////////////////////////////////////////////////////////////////////////////////
				$ketnya = "Login $ppd_session : $username4_session";
				mysql_query("INSERT INTO login_log(kd, kd_tapel, kd_login, url_inputan, postdate) VALUES ".
						"('$x', '$tp_tapelkd', '$kd4_session', '$ketnya', '$today')");
				//entri history ////////////////////////////////////////////////////////////////////////////////////////////////
	
	
				//re-direct
				$ke = "ppd/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}



		//jika guru
		else if ($aksess == "tp02")
			{
			//query
			$q = mysql_query("SELECT * FROM guru ".
								"WHERE usernamex = '$username' ".
								"AND passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);
	
			//cek login
			if ($total != 0)
				{
				session_start();
	
				//nilai
				$_SESSION['kd1_session'] = nosql($row['kd']);
				$_SESSION['username1_session'] = $username;
				$_SESSION['adm_session'] = "GURU";
				$kd1_session = nosql($row['kd']);
				$username1_session = $username;
				$adm_session = "GURU";
	
	
	
				//entri history ////////////////////////////////////////////////////////////////////////////////////////////////
				$ketnya = "Login $adm_session : $username1_session";
				mysql_query("INSERT INTO login_log(kd, kd_tapel, kd_login, url_inputan, postdate) VALUES ".
								"('$x', '$tp_tapelkd', '$kd1_session', '$ketnya', '$today')");
				//entri history ////////////////////////////////////////////////////////////////////////////////////////////////
	
		
				//re-direct
				$ke = "admgr/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}



		//jika admin
		else if ($aksess == "tp03")
			{
			//query
			$q = mysql_query("SELECT * FROM adminx ".
								"WHERE usernamex = '$username' ".
								"AND passwordx = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);
	
			//cek login
			if ($total != 0)
				{
				session_start();
	
				//nilai
				$_SESSION['kd1_session'] = nosql($row['kd']);
				$_SESSION['username1_session'] = $username;
				$_SESSION['adm_session'] = "Administrator";
				$kd1_session = nosql($row['kd']);
				$username1_session = $username;
				$adm_session = "Administrator";
	
	
	
				//entri history ////////////////////////////////////////////////////////////////////////////////////////////////
				$ketnya = "Login $adm_session : $username1_session";
				mysql_query("INSERT INTO login_log(kd, kd_tapel, kd_login, url_inputan, postdate) VALUES ".
								"('$x', '$tp_tapelkd', '$kd1_session', '$ketnya', '$today')");
				//entri history ////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
				//re-direct
				$ke = "adm/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//re-direct
				pekem($pesan, $filenya);
				exit();
				}			
			}


		else
			{
			//re-direct
			pekem($pesan, $filenya);
			exit();	
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top" align="center">
<td width="100">';



//jika null 
if (empty($s))
	{
	echo '<table bgcolor="gray" width="500" border="0" cellspacing="3" cellpadding="0">
	<tr valign="top">
	<td width="50">
	<img src="'.$sumber.'/img/logo.png" width="100" border="0">
	</td>
	
	<td>
	
	<div id="d_utama">
	<table bgcolor="maroon" width="100%" border="0" cellspacing="3" cellpadding="0">
	<tr valign="top">
	<td>
	
	<h2>
	SISFOKOL-Ujian Online
	</h2>
	</td>
	</tr>
	</table>
	
	<p>
	Akses :
	<br>
	<select name="aksess">
	<option value="" selected></option>
	<option value="tp01">Siswa</option>
	<option value="tp02">Guru</option>
	<option value="tp03">Admin</option>
	</select>
	</p>
	
	<p>
	Username :
	<br>
	<input name="usernamex" type="text" size="10">
	</p>
	
	
	<p>
	Password :
	<br>
	<input name="passwordx" type="password" size="10">
	</p>
	
	
	<p>
	<input name="btnBTL" type="reset" value="BATAL">
	<input name="btnOK" type="submit" value="OK &gt;&gt;&gt;">
	</p>
	
	</td>
	</tr>
	</table>
	
	</div>';
	}

	
else if ($s == "pengembang")
	{
	echo '<table bgcolor="gray" width="500" border="0" cellspacing="3" cellpadding="0">
	<tr valign="top" height="300">
	<td>
	<table bgcolor="maroon" width="100%" border="0" cellspacing="3" cellpadding="0">
	<tr valign="top">
	<td>
	<h2>
	Pengembang Aplikasi SISFOKOL-UjianOnline
	</h2>
	</td>
	</tr>
	</table>
	<p>
	Aplikasi SISFOKOL-UjianOnline ini dibuat oleh Agus Muhajir. (http://omahbiasawae.com). 
	</p>
	
	<p>
	Merupakan versi pertama, yang rilis pada April 2015 ini. Sebenarnya sistem yang ada adalah hasil pengembangan terpisah dari SISFOKOL SD/SMP/SMA/SMK. 
	Yang lebih khusus hanya pada konten UjianOnline saja.
	</p>
	
	<p>
	Informasi selengkapnya, bisa kontak ke :
	<br>
	E-Mail/FB : hajirodeon@yahoo.com
	<br>
	SMS/WhatsApp/Telegram : 0818298854.
	<br>
	http://omahbiasawae.com/
	<br>
	http://sisfokol.wordpress.com/
	<br>
	http://yahoogroup.com/groups/sisfokol/
	<br>
	http://www.tokopedia.com/omahbiasawae/
	</p>
	</td>
	</tr>
	</table>';	
	}


else if ($s == "cd")
	{
	echo '<table bgcolor="gray" width="500" border="0" cellspacing="3" cellpadding="0">
	<tr valign="top" height="300">
	<td>
	<table bgcolor="maroon" width="100%" border="0" cellspacing="3" cellpadding="0">
	<tr valign="top">
	<td>
	<h2>
	Beli Paket CD Donasi
	</h2>
	</td>
	</tr>
	</table>
		
	
	
	<p>
	Bila Anda merasa menggunakan aplikasi ini, ada manfaatnya, 
	silahkan bisa turut serta memberikan donasi pengembangan aplikasi ini. 
	Agar kelanjutan dan kelangsungan pengembangan aplikasi basis OpenSource ini, bisa terus rilis tiap tahunnya. 
	
	Yakni dengan membeli Paket CD Donasi. Besarnya sekitar 100rb.
	</p>
	
	<p>
	Yang dapat diperoleh :
	<UL>
		<LI>E-Book .pdf instalasi dan penggunaan.</LI>
		<LI>File webserver XAMPP 1.7.7.</LI>
		<LI>File Source Code SISFOKOL-UJIAN yang telah ter-update.</LI>
		<LI>Adanya menu Import/Export data siswa, data guru, dan data soal.</LI>
		<LI>Adanya menu Laporan Data Nilai Siswa.</LI>
		<LI>Bebas dari iklan.</LI>
		<LI>Tenang dan Nyaman dalam menggunakan.</LI>
	</UL>
	</p>
	
	
	<p>
	Silahkan lakukan konfirmasi dahulu, via email : hajirodeon@yahoo.com, atau via SMS/WA/Telegram : 0818298854. 
	Donasi beserta ongkos kirim paket CD, bisa lakukan transfer ke :
	<br>
	Bank Mandiri Cab.Pemuda Semarang.
	<br>
	A/N. Agus Muhajir
	<br>
	135-00-040-3665-1.
	</p>
	
	<p>
	Kemudian silahkan konfirmasikan bukti transfer, dan alamat lengkap untuk pengiriman paketnya.
	</p>
	<br>
	
	<p>
	Semoga Karya saya ini bisa bermanfaat ya... ;-D
	</p>
	<p>
	Agus Muhajir.
	</p>
	</td>
	</tr>
	</table>';
		
	}
	
	




else if ($s == "kastumisasi")
	{
	echo '<table bgcolor="gray" width="500" border="0" cellspacing="3" cellpadding="0">
	<tr valign="top" height="300">
	<td>
	<table bgcolor="maroon" width="100%" border="0" cellspacing="3" cellpadding="0">
	<tr valign="top">
	<td>
	<h2>
	Beli Paket Kastumisasi
	</h2>
	</td>
	</tr>
	</table>
		


	<p>
	Layanan ini adalah kastumisasi, yakni revisi yang Anda inginkan agar aplikasi ini, bisa sesuai keinginan. 
	</p>
	
	<p>
	Besarnya donasi sekitar 800rb.
	</p>
	
	<p>
	Informasi lebih lanjut :
	<br>
	E-Mail : hajirodeon@yahoo.com
	<br>
	SMS/WA/Telegram : 0818298854.
	</p>
	</td>
	</tr>
	</table>';
	}



echo '<table bgcolor="orange" width="500" border="0" cellspacing="3" cellpadding="0">
<tr valign="top" align="right">
<td>
(c) 2015. '.$versi.'
</td>
</tr>
</table>



<table bgcolor="brown" width="500" border="0" cellspacing="3" cellpadding="0">
<tr valign="top" align="left">
<td width="200">
<a href="http://www.omahbiasawae.com/" target="_blank">OmahBIASAWAE.COM</a>
<br>
<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FOmahbiasawae%2F570684559728799&amp;width&amp;layout=button&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=80&amp;appId=312487135596733" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:20px;" allowTransparency="true"></iframe>
</td>
<td align="right">
[<a href="'.$filenya.'">LOGIN</a>].
<br>
 
*[<a href="'.$filenya.'?s=pengembang">Pengembang</a>].
<br>
[<a href="'.$filenya.'?s=cd">Beli Paket CD DONASI</a>].
<br>
[<a href="'.$filenya.'?s=kastumisasi">Beli Paket Kastumisasi</a>].
</td>
</tr>
</table>



   <table width="500" border="0" cellpadding="0" cellspacing="0" bgcolor="orange">
    <tr>
      <td align="left">
	  <font color="gray">
	  <iframe frameborder="0" width="500" src="http://iklan.omahbiasawae.com/iklanbaris.php" scrolling="no" name="frku" height="30"></iframe>
	  </font>
	  </td>
    </tr>
  </table>










</td>
</tr>
</table>





</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>