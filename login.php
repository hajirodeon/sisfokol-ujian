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
<td width="550">';


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




echo '<table bgcolor="orange" width="500" border="0" cellspacing="3" cellpadding="0">
<tr valign="top" align="right">
<td>
(c) 2017. '.$versi.'
</td>
</tr>
</table>



<table bgcolor="brown" width="500" border="0" cellspacing="3" cellpadding="0">
<tr valign="top" align="left">
<td align="right">
[<a href="'.$filenya.'">LOGIN</a>].

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