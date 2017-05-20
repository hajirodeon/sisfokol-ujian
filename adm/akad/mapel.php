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

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "mapel.php";
$judul = "Data Mata Pelajaran";
$judulku = "[$adm_session] ==> $judul";
$judulx = $judul;
$mpkd = nosql($_REQUEST['mpkd']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&jnskd=$jnskd";



//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();";
	}
else if (empty($jnskd))
	{
	$diload = "document.formx.jenis.focus();";
	}






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$jnskd = nosql($_POST['jnskd']);
	$progdik = nosql($_POST['progdik']);
	$mpkd = nosql($_POST['mpkd']);
	$no = nosql($_POST['no']);
	

	//jika null
	if (empty($progdik))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&jnskd=$jnskd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//cek
		$qcc = mysql_query("SELECT * FROM m_mapel ".
								"WHERE kd_tapel = '$tapelkd' ".
								"AND kd_kelas = '$kelkd' ".
								"AND kd_jenis = '$jnskd' ".
								"AND kd = '$mpkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//not null
		if ($tcc != 0)
			{
			//update
			mysql_query("UPDATE m_mapel SET no = '$no', ".
							"mapel = '$progdik' ".
							"WHERE kd = '$mpkd'");
			}
		else
			{
			//query
			mysql_query("INSERT INTO m_mapel(kd, kd_tapel, kd_kelas, kd_jenis, ".
								"no, mapel, kkm, postdate) VALUES ".
								"('$x', '$tapelkd', '$kelkd', '$jnskd', ".
								"'$no', '$progdik', '$kkm', '$today')");
			}
		}



	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($ke);
	exit();
	}




//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$jnskd = nosql($_POST['jnskd']);



	//looping mapel
	$qdt = mysql_query("SELECT * FROM m_mapel ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND kd_kelas = '$kelkd' ".
							"AND kd_jenis = '$jnskd' ".
							"ORDER BY round(no) ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
		{
		//kd e
		$dt_kd = nosql($rdt['kd']);
		$i = $i + 1;

		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM m_mapel ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$kelkd' ".
						"AND kd_jenis = '$jnskd' ".
						"AND kd = '$kd'");
		}
	while ($rdt = mysql_fetch_assoc($qdt));



	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($ke);
	exit();
	}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();



//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
require("../../inc/menu/adm.php");

xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
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
echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkelas = balikin($rowbtx['kelas']);

echo '<option value="'.$btxkd.'">'.$btxkelas.'</option>';

$qbt = mysql_query("SELECT * FROM m_kelas ".
						"ORDER BY round(no) ASC, ".
						"kelas ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = balikin($rowbt['kelas']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>,



Jenis Mata Pelajaran : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qjnx = mysql_query("SELECT * FROM m_mapel_jenis ".
						"WHERE kd = '$jnskd'");
$rowjnx = mysql_fetch_assoc($qjnx);
$jnx_kd = nosql($rowjnx['kd']);
$jnx_jns = balikin($rowjnx['nama']);

echo '<option value="'.$jnx_kd.'">'.$jnx_jns.'</option>';

//jenis
$qjn = mysql_query("SELECT * FROM m_mapel_jenis ".
						"ORDER BY nama ASC");
$rowjn = mysql_fetch_assoc($qjn);

do
	{
	$jn_kd = nosql($rowjn['kd']);
	$jn_jns = balikin($rowjn['nama']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&jnskd='.$jn_kd.'">'.$jn_jns.'</option>';
	}
while ($rowjn = mysql_fetch_assoc($qjn));

echo '</select>

<input name="tapelkd" type="hidden" value="'.nosql($_REQUEST['tapelkd']).'">
<input name="jnskd" type="hidden" value="'.nosql($_REQUEST['jnskd']).'">
<input name="kelkd" type="hidden" value="'.nosql($_REQUEST['kelkd']).'">


</td>
</tr>
</table>
<br>';

//nilai
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$jnskd = nosql($_REQUEST['jnskd']);

//nek blm
if (empty($tapelkd))
	{
	echo '<p>
	<strong><font color="#FF0000">TAHUN PELAJARAN Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($kelkd))
	{
	echo '<strong><font color="#FF0000">KELAS Belum Dipilih...!</font></strong>';
	}
else if (empty($jnskd))
	{
	echo '<strong><font color="#FF0000">JENIS MATA PELAJARAN Belum Dipilih...!</font></strong>';
	}
else
	{
	//query
	$qx = mysql_query("SELECT * FROM m_mapel ".
						"WHERE kd = '$mpkd'");
	$rowx = mysql_fetch_assoc($qx);
	$e_no = nosql($rowx['no']);
	$e_mapel = balikin2($rowx['mapel']);

	
	echo '<p>
	No.Index :
	<br>
	<input name="no" type="text" value="'.$e_no.'" size="1" maxlength="1">
	<br>
	<br>
	Nama :
	<br>
	<input name="progdik" type="text" value="'.$e_mapel.'" size="30">
	
	<input name="mpkd" type="hidden" value="'.$mpkd.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="BATAL">
	</p>';
	
	
	
	//query
	$q = mysql_query("SELECT * FROM m_mapel ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$kelkd' ".
						"AND kd_jenis = '$jnskd' ".
						"ORDER BY round(no) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);
		
		
	if ($total != 0)
		{
		echo '<table width="400" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="1"><strong><font color="'.$warnatext.'">No. Index</font></strong></td>
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
	
			$nomer = $nomer + 1;
			$i_kd = nosql($row['kd']);
			$i_no = nosql($row['no']);
			$i_nama = balikin($row['mapel']);
	
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
        	</td>
			<td>
			<a href="'.$filenya.'?s=edit&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&jnskd='.$jnskd.'&mpkd='.$i_kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$i_no.'</td>
			<td>'.$i_nama.'</td>
        	</tr>';
			}
		while ($row = mysql_fetch_assoc($q));
	
		echo '</table>
		<table width="400" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="263">
		<input name="jml" type="hidden" value="'.$total.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$total.')">
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		</td>
		<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>TIDAK ADA DATA. Silahkan Entry Dahulu...!!</strong>
		</font>
		</p>';
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