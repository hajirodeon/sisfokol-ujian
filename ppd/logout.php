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
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
require("../inc/cek/siswa.php");


nocache;




//berikan password baru
$passbaru1 = substr(md5($today),0,7);
$passbarux = md5($passbaru1);



//set
mysqli_query($koneksi, "UPDATE siswa SET passwordx = '$passbarux' ".
				"WHERE kd = '$kd4_session'");






//hapus session
session_unset();
session_destroy();

//re-direct
$pesan = "Anda Telah Berhasil LogOut. Terima Kasih.";
pekem($pesan,$sumber);
exit();
?>