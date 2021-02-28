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
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "guru_mapel.php";
$judul = "Data Guru Mapel";
$judulku = "[$adm_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$s = nosql($_REQUEST['s']);
$ke = "$filenya?tapelkd=$tapelkd&jnskd=$jnskd";




//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
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
	$pelkd = nosql($_POST['pelkd']);
	$gurkd = nosql($_POST['gurkd']);

	//nek null
	if ((empty($pelkd)) OR (empty($gurkd)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//cek
		$qc = mysqli_query($koneksi, "SELECT * FROM guru_mapel ".
							"WHERE kd_guru = '$gurkd' ".
							"AND kd_mapel = '$pelkd' ".
							"AND kd_kelas = '$kelkd'");
		$rc = mysqli_fetch_assoc($qc);
		$tc = mysqli_num_rows($qc);

		//nek ada, msg
		if ($tc != 0)
			{
			//re-direct
			$pesan = "Guru Tersebut Telah Mengajar Mata Pelajaran Tersebut. Silahkan Ganti...!";
			pekem($pesan,$ke);
			}
		else
			{
			//query
			mysqli_query($koneksi, "INSERT INTO guru_mapel(kd, kd_tapel, kd_guru, kd_mapel, ".
							"kd_kelas, postdate) VALUES ".
							"('$x', '$tapelkd', '$gurkd', '$pelkd', ".
							"'$kelkd', '$today')");


			//re-direct
			xloc($ke);
			exit();
			}
		}
	}





//jika hapus
if ($s == "hapus")
	{
	//nilai
	$tapelkd = nosql($_REQUEST['tapelkd']);
	$kelkd = nosql($_REQUEST['kelkd']);
	$jnskd = nosql($_REQUEST['jnskd']);
	$pelkd = nosql($_REQUEST['pelkd']);
	$gurkd = nosql($_REQUEST['gurkd']);
	$gkd = nosql($_REQUEST['gkd']);

	//query
	mysqli_query($koneksi, "DELETE FROM guru_mapel ".
					"WHERE kd = '$gkd'");

	//re-direct
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


//menu
require("../../inc/menu/adm.php");

xheadline($judul);

//VIEW //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$ke.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysqli_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<option value="'.$tpx_kd.'">'.$tpx_thn1.'/'.$tpx_thn2.'</option>';

$qtp = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
						"WHERE kd <> '$tapelkd' ".
						"ORDER BY tahun1 ASC");
$rowtp = mysqli_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysqli_fetch_assoc($qtp));

echo '</select>,


Jenis Mata Pelajaran : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qjnx = mysqli_query($koneksi, "SELECT * FROM m_mapel_jenis ".
						"WHERE kd = '$jnskd'");
$rowjnx = mysqli_fetch_assoc($qjnx);
$jnx_kd = nosql($rowjnx['kd']);
$jnx_jns = balikin($rowjnx['nama']);

echo '<option value="'.$jnx_kd.'">'.$jnx_jns.'</option>';

//jenis
$qjn = mysqli_query($koneksi, "SELECT * FROM m_mapel_jenis ".
						"WHERE kd <> '$jnskd' ".
						"ORDER BY no ASC");
$rowjn = mysqli_fetch_assoc($qjn);

do
	{
	$jn_kd = nosql($rowjn['kd']);
	$jn_jns = balikin($rowjn['nama']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&jnskd='.$jn_kd.'">'.$jn_jns.'</option>';
	}
while ($rowjn = mysqli_fetch_assoc($qjn));

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="jnskd" type="hidden" value="'.$jnskd.'">
</td>
</tr>
</table>
<br>';


//nek blm
if (empty($tapelkd))
	{
	echo '<p>
	<strong><font color="#FF0000">TAHUN PELAJARAN Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($jnskd))
	{
	echo '<p>
	<strong><font color="#FF0000">JENIS MATA PELAJARAN Belum Dipilih...!</font></strong>
	</p>';
	}
else
	{
	echo '<select name="gurkd">
	<option value="" selected>-GURU-</option>';

	//daftar guru
	$qg = mysqli_query($koneksi, "SELECT * FROM guru ".
						"ORDER BY nama ASC");
	$rg = mysqli_fetch_assoc($qg);



	do
		{
		$i_kd = nosql($rg['kd']);
		$i_nip = nosql($rg['nip']);
		$i_nama = balikin($rg['nama']);



		echo '<option value="'.$i_kd.'">'.$i_nama.'  ['.$i_nip.'].</option>';
		}
	while ($rg = mysqli_fetch_assoc($qg));

	echo '</select>
	<br>

	<select name="pelkd">
	<option value="" selected>-MATA PELAJARAN-</option>';
	//daftar mapel
	$qbs = mysqli_query($koneksi, "SELECT m_mapel.kd AS mpkd, ".
							"m_mapel.*, ".
							"m_kelas.* ".
							"FROM m_mapel, m_kelas ".
							"WHERE m_mapel.kd_kelas = m_kelas.kd ".
							"AND m_mapel.kd_tapel = '$tapelkd' ".
							"AND m_mapel.kd_jenis = '$jnskd' ".
							"ORDER BY round(m_mapel.no) ASC, ".
							"m_mapel.mapel ASC");
	$rbs = mysqli_fetch_assoc($qbs);

	do
		{
		$bskd = nosql($rbs['mpkd']);
		$bspel = balikin2($rbs['mapel']);
		$bskelas = balikin2($rbs['kelas']);

		echo '<option value="'.$bskd.'">'.$bspel.' [Kelas : '.$bskelas.'].</option>';
		}
	while ($rbs = mysqli_fetch_assoc($qbs));

	echo '</select>
	<br>



	<select name="kelkd">
	<option value="" selected>-KELAS-</option>';

	//daftar 
	$qg = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
						"ORDER BY no ASC, ".
						"kelas ASC");
	$rg = mysqli_fetch_assoc($qg);



	do
		{
		$i_kd = nosql($rg['kd']);
		$i_nama = balikin($rg['kelas']);



		echo '<option value="'.$i_kd.'">'.$i_nama.'</option>';
		}
	while ($rg = mysqli_fetch_assoc($qg));

	echo '</select>
	<br>

	
	
	<input name="btnSMP" type="submit" value="TAMBAH >>">
	</p>';

	//query
	$q = mysqli_query($koneksi, "SELECT * FROM guru ".
							"ORDER BY round(nip) ASC");
	$row = mysqli_fetch_assoc($q);
	$total = mysqli_num_rows($q);

	if ($total != 0)
		{
		echo '<table width="700" border="1" cellpadding="3" cellspacing="0">
    	<tr bgcolor="'.$warnaheader.'">
		<td width="5" valign="top"><strong>No.</strong></td>
		<td width="5" valign="top"><strong>NIP</strong></td>
    	<td valign="top"><strong><font color="'.$warnatext.'">Guru</font></strong></td>
    	<td width="300" valign="top"><strong><font color="'.$warnatext.'">Kelas - Mata Pelajaran</font></strong></td>
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
			$i_grkd = nosql($row['kd']);
			$i_nip = nosql($row['nip']);
			$i_nama = balikin($row['nama']);


			echo "<tr bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td valign="top">'.$nomer.'. </td>
   			<td valign="top">'.$i_nip.'</td>
			<td valign="top">
			'.$i_nama.'
			</td>
			<td valign="top">';


			//pel-nya
			$quru = mysqli_query($koneksi, "SELECT * FROM guru_mapel ".
									"WHERE kd_guru = '$i_grkd'");
			$ruru = mysqli_fetch_assoc($quru);


			do
				{
				$gkd = nosql($ruru['kd']);
				$kd_prog_pddkn = nosql($ruru['kd_mapel']);
				$kd_kelas = nosql($ruru['kd_kelas']);


				//mapel
				$q1 = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
									"WHERE kd = '$kd_prog_pddkn'");
				$r1 = mysqli_fetch_assoc($q1);
				$gpel = balikin($r1['mapel']);


				//kelas
				$q2 = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
									"WHERE kd = '$kd_kelas'");
				$r2 = mysqli_fetch_assoc($q2);
				$gkelas = balikin($r2['kelas']);


				//nek null
				if (empty($gkd))
					{
					echo "-";
					}
				else
					{


					echo '<strong>*</strong>('.$gkelas.') '.$gpel.'
					[<a href="'.$ke.'&s=hapus&gkd='.$gkd.'" title="HAPUS --> '.$gpel.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>]. <br>';
					}
				}
			while ($ruru = mysqli_fetch_assoc($quru));



			echo '</td>
   			</tr>';
			}
		while ($row = mysqli_fetch_assoc($q));

		echo '</table>
		<table width="700" border="0" cellspacing="0" cellpadding="3">
    	<tr>
    	<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
    	</tr>
	  	</table>';
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
?>