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

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
$tpl = LoadTpl("../../template/ifr_sesi.html");

nocache;

//nilai
$s = $_REQUEST['s'];
$xsesi = $_SESSION['x_sesi'];
$filenya = "ifr_sesi.php";
$nilai = 1; //per detik refresh

//deteksi
if ($s == "baru")
	{
	if (empty($_SESSION['x_sesi']))
		{
		session_register("x_sesi");
		$_SESSION['x_sesi'] = $nilai;
		}
	else
		{
		$_SESSION['x_sesi'] = $_SESSION['x_sesi'] + $nilai;
		
		
		//jika waktu habis
		$now = time(); 
		if ($now > $_SESSION['expire']) 
				{
		        session_destroy();
				}
				
		}

	echo "<script>location.href='$filenya'</script>";
	}



//isi *START
ob_start();



echo 'Detik Ke-'.$xsesi.'
<script>
setTimeout("location.href=\''.$filenya.'?s=baru\'", '.$nilai.'000);
</script>';


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//null-kan
exit();
?>