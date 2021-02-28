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
require("../../inc/cek/adm.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "guru.php";
$judul = "Data Guru";
$judulku = "[$adm_session] ==> $judul";
$judulx = $judul;

$s = nosql($_REQUEST['s']);
$m = nosql($_REQUEST['m']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
$ke = $filenya;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//PROSES ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin2($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);


	//cek
	if ((empty($crkd)) OR (empty($kunci)))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	}



//batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}









//ke daftar pegawai
if ($_POST['btnDF'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($filenya);
	exit();
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$page = nosql($_REQUEST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}


	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM guru ".
					"ORDER BY nip ASC";
	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);


	//ambil semua
	do
		{
		//ambil nilai
		$i = $i + 1;
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);


		//del
		mysqli_query($koneksi, "DELETE FROM guru ".
						"WHERE kd = '$kd'");
		}
	while ($data = mysqli_fetch_assoc($result));


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?page=$page";
	xloc($ke);
	exit();
	}





//jika simpan
if ($_POST['btnSMP1'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$nip = strip2(nosql($_POST['nip']));
	$nama1 = cegah($_POST['nama1']);




	//jika baru ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($s == "add")
		{
		//nek null
		if ((empty($nip)) OR (empty($nama1)))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);
	
			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!";
			$ke = "$filenya?s=add&kd=$x";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//cek
			$qcc = mysqli_query($koneksi, "SELECT * FROM guru ".
									"WHERE nip = '$nip'");
			$rcc = mysqli_fetch_assoc($qcc);
			$tcc = mysqli_num_rows($qcc);
	
			//nek ada
			if ($tcc != 0)
				{
				//re-direct
				$pesan = "NIP Tersebut Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?s=add&kd=$x";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//set akses
				$x_userx = $nip;
				$x_passx = md5($nip);
	
				//insert
				mysqli_query($koneksi, "INSERT INTO guru(kd, usernamex, passwordx, nip, nama, postdate) VALUES ".
								"('$kd', '$x_userx', '$x_passx', '$nip', '$nama1', '$today')");
	
				//diskonek
				xfree($qbw);
				xclose($koneksi);
	
				//re-direct
				xloc($filenya);
				exit();
				}
			}
		}

	//jika edit ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	else if ($s == "edit")
		{
		//nilai
		$nip = strip2(nosql($_POST['nip']));
		$nama1 = cegah($_POST['nama1']);



		//set akses
		$x_userx = $nip;
		$x_passx = md5($nip);

		//update
		mysqli_query($koneksi, "UPDATE guru SET usernamex = '$x_userx', ".
						"passwordx = '$x_passx', ".
						"nip = '$nip', ".
						"nama = '$nama1' ".
						"WHERE kd = '$kd'");

		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		xloc($filenya);
		exit();
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////










//isi *START
ob_start();




//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/js/swap.js");



//menu
require("../../inc/menu/adm.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td width="500">';
xheadline($judul);
echo ' [<a href="'.$filenya.'?s=add&kd='.$x.'" title="Entry Data Baru">Entry Data Baru</a>]
</td>
<td align="right">';
echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$filenya.'?crkd='.$crkd.'&crtipe='.$crtipe.'&kunci='.$kunci.'" selected>'.$crtipe.'</option>
<option value="'.$filenya.'?crkd=cr01&crtipe=NIP&kunci='.$kunci.'">NIP</option>
<option value="'.$filenya.'?crkd=cr05&crtipe=Nama&kunci='.$kunci.'">Nama</option>
</select>
<input name="kunci" type="text" value="'.$kunci.'" size="20">
<input name="crkd" type="hidden" value="'.$crkd.'">
<input name="crtipe" type="hidden" value="'.$crtipe.'">
<input name="btnCARI" type="submit" value="CARI >>">
<input name="btnRST" type="submit" value="RESET">
</td>
</tr>
</table>';


//jika view /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (empty($s))
	{
	//nip
	if ($crkd == "cr01")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM guru ".
						"WHERE nip LIKE '%$kunci%' ".
						"ORDER BY round(nip) ASC";
		$sqlresult = $sqlcount;

		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}


	//nama
	else if ($crkd == "cr05")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM guru ".
						"WHERE nama LIKE '%$kunci%' ".
						"ORDER BY nama ASC";
		$sqlresult = $sqlcount;

		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}

	else
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT * FROM guru ".
						"ORDER BY round(nip) ASC";
		$sqlresult = $sqlcount;

		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}

	if ($count != 0)
		{
		//view data
		echo '<table width="700" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="200"><strong><font color="'.$warnatext.'">NIP</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
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

			//nilai
			$nomer = $nomer + 1;
			$kd = nosql($data['kd']);
			$usernamex = nosql($data['usernamex']);
			$passwordx = nosql($data['passwordx']);
			$nip = balikin2($data['nip']);
			$nama = balikin($data['nama']);


			//set akses
			if ((empty($usernamex)) OR (empty($passwordx)))
				{
				$x_userx = $nip;
				$x_passx = md5($nip);

				mysqli_query($koneksi, "UPDATE guru SET usernamex = '$x_userx', ".
								"passwordx = '$x_passx' ".
								"WHERE kd = '$kd'");
				}


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$kd.'">
			<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'">
    		</td>
			<td>
			<a href="'.$filenya.'?s=edit&kd='.$kd.'" title="EDIT..."><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>'.$nip.'</td>
			<td>'.$nama.'</td>
    		</tr>';
			}
		while ($data = mysqli_fetch_assoc($result));

		echo '</table>
		<table width="900" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		<input name="jml" type="hidden" value="'.$limit.'">
		<input name="s" type="hidden" value="'.nosql($_REQUEST['s']).'">
		<input name="m" type="hidden" value="'.nosql($_REQUEST['m']).'">
		<input name="kd" type="hidden" value="'.nosql($_REQUEST['kd']).'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">

		
		<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
		</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>TIDAK ADA DATA.</strong>
		</font>
		</p>';
		}
	}



//jika import //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($s == "import")
	{
	echo '<p>
	Silahkan Masukkan File yang akan Di-Import :
	<br>
	<input name="filex_xls" type="file" size="30">
	<br>
	<input name="s" type="hidden" value="'.$s.'">
	<input name="btnBTL" type="submit" value="BATAL">
	<input name="btnIM2" type="submit" value="IMPORT >>">
	</p>';
	}



//jika add / edit ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else
	{
	//nilai
	$kd = nosql($_REQUEST['kd']);



	//data query -> datadiri
	$qnil = mysqli_query($koneksi, "SELECT * FROM guru ".
							"WHERE kd = '$kd'");
	$rnil = mysqli_fetch_assoc($qnil);
	$y_nip = nosql($rnil['nip']);
	$y_nama = balikin($rnil['nama']);


	echo '<table border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td width="150">
	NIP
	</td>
	<td>: </td>
	<td>
	<input name="nip" type="text" value="'.$y_nip.'" size="20">
	</td>
	</tr>

	<tr valign="top">
	<td width="150">
	Nama
	</td>
	<td>: </td>
	<td>
	<input name="nama1" type="text" value="'.$y_nama.'" size="30">
	</td>
	</tr>


	</table>

	<input name="s" type="hidden" value="'.$s.'">
	<input name="btnSMP1" type="submit" value="SIMPAN">
	<input name="btnDF" type="submit" value="DAFTAR GURU >>">';
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