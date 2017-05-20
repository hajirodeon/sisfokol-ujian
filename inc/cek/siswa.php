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




///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd4_session = nosql($_SESSION['kd4_session']);
$no4_session = nosql($_SESSION['no4_session']);
$nama4_session = balikin($_SESSION['nama4_session']);
$username4_session = nosql($_SESSION['username4_session']);
$ppd_session = nosql($_SESSION['ppd_session']);

$qbw = mysql_query("SELECT kd FROM siswa ".
						"WHERE kd = '$kd4_session' ".
						"AND usernamex = '$username4_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd4_session))
	OR (empty($username4_session))
	OR (empty($ppd_session)))
	{
	//re-direct
	$pesan = "ANDA BELUM LOGIN. SILAHKAN LOGIN DAHULU...!!!";
	pekem($pesan,$sumber);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>