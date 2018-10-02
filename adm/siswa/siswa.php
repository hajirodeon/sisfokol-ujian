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
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "siswa.php";
$judul = "Data Siswa";
$judulku = "$judul  [$adm_session]";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$swkd = nosql($_REQUEST['swkd']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&page=$page";







//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();";
	}




//nek enter, ke simpan
$x_enter = 'onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	}"';




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);



	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
	xloc($ke);
	exit();
	}





//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin2($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);


	//cek
	if ((empty($crkd)) OR (empty($kunci)))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	}










//jika batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&page=$page";
	xloc($ke);
	exit();
	}



//jika daftar siswa
if ($_POST['btnDS'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&page=$page";
	xloc($ke);
	exit();
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$jml = nosql($_POST['jml']);
	$page = nosql($_POST['page']);


	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM siswa ".
					"ORDER BY round(nis) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);



	//ambil semua
	do
		{
		//ambil nilai
		$i = $i + 1;
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del data
		mysql_query("DELETE FROM siswa ".
						"WHERE kd = '$kd'");

		//nek $kd gak null
		if (!empty($kd))
			{
			//hapus file
			$cc_filex = $data['filex'];
			$path1 = "../../filebox/siswa/$kd/$cc_filex";
			unlink ($path1);
			}
		}
	while ($data = mysql_fetch_assoc($result));

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($ke);
	exit();
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$a = nosql($_POST['a']);
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$swkd = nosql($_POST['swkd']);


	$nis = nosql($_POST['nis']);
	$nama = cegah($_POST['nama']);
	$kelamin = nosql($_POST['kelamin']);

	$tmp_lahir = cegah($_POST['tmp_lahir']);

	
	$mtgl = $_POST['datepicker1'];
	$mpecah1 = explode("/", $mtgl);
	$daftar_bln = $mpecah1[0];
	$daftar_tgl = $mpecah1[1];
	$daftar_thn = $mpecah1[2];
	$tgl_lahir = "$daftar_thn:$daftar_bln:$daftar_tgl";

	$agama = nosql($_POST['agama']);
	$alamat = cegah($_POST['alamat']);
	$telp = cegah($_POST['telp']);
	$ket = cegah($_POST['ket']);


	//nek edit
	if ($s == "edit")
		{
		//nilai
		$s_userx = $nis;
		$s_passx = md5($nis);

		//update
		mysql_query("UPDATE siswa SET usernamex = '$s_userx', ".
							"passwordx = '$s_passx', ".
							"nis = '$nis', ".
							"nama = '$nama', ".
							"alamat = '$alamat', ".
							"telp = '$telp', ".
							"ket = '$ket', ".							
							"tmp_lahir = '$tmp_lahir', ".
							"tgl_lahir = '$tgl_lahir', ".
							"kelamin = '$kelamin', ".
							"agama = '$agama' ".
							"WHERE kd = '$swkd'");


		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$ke = "$filenya?s=edit&tapelkd=$tapelkd&kelkd=$kelkd&swkd=$swkd&a=a#a";
		xloc($ke);
		exit();
		}



	//nek baru
	if ($s == "baru")
		{
		//nek null
		if ((empty($nis)) OR (empty($nama)))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&s=baru&swkd=$swkd&a=$a#a";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//cek
			$qcc = mysql_query("SELECT * FROM siswa ".
									"WHERE nis = '$nis'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//re-direct
				$pesan = "NIS Tersebut Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&s=baru&swkd=$x&a=$a#a";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//insert ke biodata
				$s_userx = $nis;
				$s_passx = md5($nis);
				$xx = md5($today3);


				//insert data siswa
				mysql_query("INSERT INTO siswa(kd, kd_tapel, kd_kelas, usernamex, passwordx, nis, nama, ".
									"alamat, tmp_lahir, tgl_lahir, kelamin, agama, telp, ket, postdate) VALUES ".
									"('$swkd', '$tapelkd', '$kelkd', '$s_userx', '$s_passx', '$nis', '$nama', ".
									"'$alamat', '$tmp_lahir', '$tgl_lahir', '$kelamin', '$agama', '$telp', '$ket', '$today')");



				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
				xloc($ke);
				exit();
				}
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/menu/adm.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<script type="text/javascript">
$(document).ready(function() {
$(function() {
	$('#datepicker1').datepicker({
		changeMonth: true,
		yearRange: "-100:-10",
		changeYear: true
		});

	});




});
</script>


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




echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';

echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<option value="'.$tpx_kd.'">'.$tpx_thn1.'/'.$tpx_thn2.'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd <> '$tapelkd' ".
						"ORDER BY tahun1 ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>, 




Kelas : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qjnx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowjnx = mysql_fetch_assoc($qjnx);
$jnx_kd = nosql($rowjnx['kd']);
$jnx_jns = balikin($rowjnx['kelas']);

echo '<option value="'.$jnx_kd.'">'.$jnx_jns.'</option>';

//jenis
$qjn = mysql_query("SELECT * FROM m_kelas ".
						"ORDER BY no ASC, ".
						"kelas ASC");
$rowjn = mysql_fetch_assoc($qjn);

do
	{
	$jn_kd = nosql($rowjn['kd']);
	$jn_jns = balikin($rowjn['kelas']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$jn_kd.'">'.$jn_jns.'</option>';
	}
while ($rowjn = mysql_fetch_assoc($qjn));

echo '</select>



<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="swkd" type="hidden" value="'.$swkd.'">

</td>
</tr>
</table>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="swkd" type="hidden" value="'.$swkd.'">';


//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($kelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>
	</p>';
	}
	
else
	{
	//entry baru / edit
	if (($s == "baru") OR ($s == "edit"))
		{
		//nilai
		$swkd = nosql($_REQUEST['swkd']);
		$tapelkd = nosql($_REQUEST['tapelkd']);
		$kelkd = nosql($_REQUEST['kelkd']);



		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//query
		$qnil = mysql_query("SELECT siswa.*, siswa.kd AS mskd, ".
								"DATE_FORMAT(siswa.tgl_lahir, '%d') AS lahir_tgl, ".
								"DATE_FORMAT(siswa.tgl_lahir, '%m') AS lahir_bln, ".
								"DATE_FORMAT(siswa.tgl_lahir, '%Y') AS lahir_thn ".
								"FROM siswa ".
								"WHERE kd = '$swkd'");
		$rnil = mysql_fetch_assoc($qnil);
		$y_nis = nosql($rnil['nis']);
		$y_nisn = nosql($rnil['nisn']);
		$y_nama = balikin($rnil['nama']);
		$y_alamat = balikin($rnil['alamat']);
		$y_jkelkd = nosql($rnil['kelamin']);

		$y_tmp_lahir = balikin($rnil['tmp_lahir']);
		$y_lahir_tgl = nosql($rnil['lahir_tgl']);
		$y_lahir_bln = nosql($rnil['lahir_bln']);
		$y_lahir_thn = nosql($rnil['lahir_thn']);
		$tgl_lahir = "$y_lahir_bln/$y_lahir_tgl/$y_lahir_thn";

		$y_agmkd = balikin($rnil['agama']);
		$y_telp = balikin($rnil['telp']);
		$y_ket = balikin($rnil['ket']);

		//view
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr valign="top">
		<td>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="200">
		1. NIS
		</td>
		<td width="10">: </td>
		<td>
		<input name="nis" type="text" value="'.$y_nis.'" size="10">
		</td>
		</tr>

		<tr valign="top">
		<td width="200">
		2. Nama Lengkap
		</td>
		<td width="10">: </td>
		<td>
		<input name="nama" type="text" value="'.$y_nama.'" size="30">
		</td>
		</tr>

		<tr valign="top">
		<td width="200">
		3. Jenis Kelamin
		</td>
		<td width="10">: </td>
		<td>
		<select name="kelamin">';
		echo '<option value="'.$jkelx_kd.'" selected>'.$y_jkelkd.'</option>';
		echo '<option value="L">L</option>
		<option value="P">P</option>';
		echo '</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="200">
		4. TTL
		</td>
		<td width="10">: </td>
		<td>
		<input name="tmp_lahir" type="text" value="'.$y_tmp_lahir.'" size="30">,
		<input name="datepicker1" id="datepicker1" type="text" value="'.$tgl_lahir.'" size="10">
		</td>
		</tr>

		<tr valign="top">
		<td width="200">
		5. Agama
		</td>
		<td width="10">: </td>
		<td>

		<select name="agama">';
		echo '<option value="'.$y_agmkd.'" selected>'.$y_agmkd.'</option>';
		echo '<option value="Islam">Islam</option>
		<option value="Kristen">Kristen</option>
		<option value="Katolik">Katolik</option>
		<option value="Budha">Budha</option>
		<option value="Hindu">Hindu</option>
		<option value="Konghuchu">Konghuchu</option>
		<option value="Kepercayaan">Kepercayaan</option>';
		echo '</select>
		</td>
		</tr>

		<tr valign="top">
		<td width="200">
		6. Alamat
		</td>
		<td width="10">: </td>
		<td>
		<input name="alamat" type="text" value="'.$y_alamat.'" size="50">
		</td>
		</tr>


		<tr valign="top">
		<td width="200">
		7. Telp
		</td>
		<td width="10">: </td>
		<td>
		<input name="telp" type="text" value="'.$y_telp.'" size="30">
		</td>
		</tr>
		
		
		<tr valign="top">
		<td width="200">
		8. Keterangan
		</td>
		<td width="10">: </td>
		<td>
		<input name="ket" type="text" value="'.$y_ket.'" size="30">
		</td>
		</tr>
		

		</tr>
		</table>

		<input name="s" type="hidden" value="'.$s.'">
		<input name="a" type="hidden" value="a">
		<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		<input name="kelkd" type="hidden" value="'.$kelkd.'">
		<input name="swkd" type="hidden" value="'.$swkd.'">
		<input name="btnSMP" type="submit" value="SIMPAN">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="btnDS" type="submit" value="DAFTAR SISWA >>">


		</td>

		</tr>
		</table>
		<br>
		<br>';
		}
	else
		{
		//query DATA
		$tapelkd = nosql($_REQUEST['tapelkd']);
		$kelkd = nosql($_REQUEST['kelkd']);

		//nis
		if ($crkd == "cr01")
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT siswa.*, ".
							"DATE_FORMAT(siswa.tgl_lahir, '%d') AS tgl, ".
							"DATE_FORMAT(siswa.tgl_lahir, '%m') AS bln, ".
							"DATE_FORMAT(siswa.tgl_lahir, '%Y') AS thn, ".
							"siswa.kd AS mskd ".
							"FROM siswa ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND nis LIKE '%$kunci%' ".
							"ORDER BY nis ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}

		//nama
		else if ($crkd == "cr02")
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT siswa.*, ".
							"DATE_FORMAT(siswa.tgl_lahir, '%d') AS tgl, ".
							"DATE_FORMAT(siswa.tgl_lahir, '%m') AS bln, ".
							"DATE_FORMAT(siswa.tgl_lahir, '%Y') AS thn, ".
							"siswa.kd AS mskd ".
							"FROM siswa ".
							"WHERE siswa.kd_tapel = '$tapelkd' ".
							"AND siswa.kd_kelas = '$kelkd' ".
							"AND siswa.nama LIKE '%$kunci%' ".
							"ORDER BY siswa.nama ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}

		else
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT siswa.*, ".
							"DATE_FORMAT(siswa.tgl_lahir, '%d') AS tgl, ".
							"DATE_FORMAT(siswa.tgl_lahir, '%m') AS bln, ".
							"DATE_FORMAT(siswa.tgl_lahir, '%Y') AS thn, ".
							"siswa.kd AS mskd ".
							"FROM siswa ".
							"WHERE siswa.kd_tapel = '$tapelkd' ".
							"AND siswa.kd_kelas = '$kelkd' ".
							"ORDER BY siswa.nis ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}



			echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr bgcolor="'.$warna02.'">
			<td>
			[<a href="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&s=baru&swkd='.$x.'&a=a#a" title="Entry Data">Entry Data</a>]. 
	
		
			</td>
			<td align="right">';
			echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
			echo '<option value="'.$filenya.'?crkd='.$crkd.'&crtipe='.$crtipe.'&kunci='.$kunci.'" selected>'.$crtipe.'</option>
			<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&crkd=cr01&crtipe=NIS&kunci='.$kunci.'">NIS</option>
			<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&crkd=cr02&crtipe=Nama&kunci='.$kunci.'">Nama</option>
			</select>
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="kunci" type="text" value="'.$kunci.'" size="30">
			<input name="crkd" type="hidden" value="'.$crkd.'">
			<input name="crtipe" type="hidden" value="'.$crtipe.'">
			<input name="btnCARI" type="submit" value="CARI >>">
			<input name="btnRST" type="submit" value="RESET">
			</td>
			</tr>
			</table>';

			//nek ada
			if ($count != 0)
				{
				echo '<table width="100%" border="1" cellpadding="3" cellspacing="0">
				<tr bgcolor="'.$warnaheader.'">
				<td width="1">&nbsp;</td>
				<td width="1">&nbsp;</td>
				<td width="50"><strong>NIS</strong></td>
				<td width="150"><strong>Nama</strong></td>
				<td width="5"><strong>L/P</strong></td>
				<td width="150"><strong>TTL.</strong></td>
				<td><strong>Alamat</strong></td>
				<td><strong>Telp.</strong></td>
				<td><strong>Ket.</strong></td>				
				</tr>';

				do
					{
					if ($warna_set ==0)
						{
						$warna = $warna01;
						$warna_set = 1;
						}
					else
						{
						$warna = $warna02;
						$warna_set = 0;
						}

					$nomer = $nomer + 1;

					$kd = nosql($data['mskd']);
					$nis = nosql($data['nis']);
					$i_userx = nosql($data['usernamex']);
					$i_passx = nosql($data['passwordx']);
					$nama = balikin($data['nama']);
					$i_alamat = balikin($data['alamat']);
					$i_telp = balikin($data['telp']);
					$i_ket = balikin($data['ket']);
					$kd_kelamin = nosql($data['kelamin']);
					$tmp_lahir = balikin2($data['tmp_lahir']);
					$tgl_lahir = nosql($data['tgl']);
					$bln_lahir = nosql($data['bln']);
					$thn_lahir = nosql($data['thn']);





					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$kd.'">
					<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'">
					</td>
					<td>
					<a href="'.$filenya.'?s=edit&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&swkd='.$kd.'&a=a#a"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
					</td>
					<td valign="top">
					'.$nis.'
					</td>
					<td valign="top">
					'.$nama.'
					</td>
					<td valign="top">
					'.$kd_kelamin.'
					</td>
					<td valign="top">
					'.$tmp_lahir.', '.$tgl_lahir.' '.$arrbln1[$bln_lahir].' '.$thn_lahir.'
					</td>
					<td valign="top">
					'.$i_alamat.'
					</td>
					<td valign="top">
					'.$i_telp.'
					</td>
					<td valign="top">
					'.$i_ket.'
					</td>
					</tr>';
					}
				while ($data = mysql_fetch_assoc($result));

				echo '</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="3">
				<tr>
				<td width="250">
				<input type="button" name="Button" value="SEMUA" onClick="checkAll('.$limit.')">
				<input name="btnBTL" type="reset" value="BATAL">
				<input name="btnHPS" type="submit" value="HAPUS">
				<input name="jml" type="hidden" value="'.$limit.'">
				<input name="s" type="hidden" value="'.$s.'">
				<input name="total" type="hidden" value="'.$count.'">
				</td>
				<td align="right"><font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
				</tr>
				</table>';
				}
			}
		}

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
xfree($qbw);
xclose($koneksi);
exit();
?>