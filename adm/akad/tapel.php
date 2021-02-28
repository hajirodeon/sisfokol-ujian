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
$filenya = "tapel.php";
$diload = "document.formx.tahun1.focus();";
$judul = "Data Tahun Pelajaran";
$judulku = "[$adm_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}



//jika edit
if ($s == "edit")
	{
	//nilai
	$kdx = nosql($_REQUEST['kd']);

	//query
	$qx = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
				"WHERE kd = '$kdx'");
	$rowx = mysqli_fetch_assoc($qx);
	$e_tahun1 = nosql($rowx['tahun1']);
	$e_tahun2 = nosql($rowx['tahun2']);
	$e_status = nosql($rowx['status']);

	//jika aktif
	if ($e_status == "true")
		{
		$e_status_ket = "AKTIF";
		}
	else if ($e_status == "false")
		{
		$e_status_ket = "Tidak Aktif";
		}
	}



//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$kd = nosql($_POST['kd']);
	$tahun1 = nosql($_POST['tahun1']);
	$tahun2 = nosql($_POST['tahun2']);
	$status = nosql($_POST['status']);


	//nek null
	if ((empty($tahun1)) OR (empty($tahun2)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//jika baru
		if (empty($s))
			{
			//cek
			$qcc = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
						"WHERE tahun1 = '$tahun1' ".
						"AND tahun2 = '$tahun2'");
			$rcc = mysqli_fetch_assoc($qcc);
			$tcc = mysqli_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Tahun Pelajaran : $tahun1/$tahun2, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				pekem($pesan,$filenya);
				exit();
				}
			else
				{
				if ($status == "true")
					{
					//netralkan dulu
					mysqli_query($koneksi, "UPDATE m_tapel SET status = 'false'");
					}

				//query
				mysqli_query($koneksi, "INSERT INTO m_tapel(kd, tahun1, tahun2, status) VALUES ".
								"('$x', '$tahun1', '$tahun2', '$status')");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				xloc($filenya);
				exit();
				}
			}

		//jika update
		else if ($s == "edit")
			{
			if ($status == "true")
				{
				//netralkan dulu
				mysqli_query($koneksi, "UPDATE m_tapel SET status = 'false'");
				}

			//query
			mysqli_query($koneksi, "UPDATE m_tapel SET tahun1 = '$tahun1', ".
							"tahun2 = '$tahun2', ".
							"status = '$status' ".
							"WHERE kd = '$kd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			xloc($filenya);
			exit();
			}
		}
	}


//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysqli_query($koneksi, "DELETE FROM m_tapel ".
						"WHERE kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi *START
ob_start();

//query
$q = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
					"ORDER BY tahun1 ASC");
$row = mysqli_fetch_assoc($q);
$total = mysqli_num_rows($q);

//js
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
require("../../inc/menu/adm.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
Tahun Akademik :
<br>
<input name="tahun1" type="text" value="'.$e_tahun1.'" size="4" maxlength="4" onKeyPress="return numbersonly(this, event)"> /
<input name="tahun2" type="text" value="'.$e_tahun2.'" size="4" maxlength="4" onKeyPress="return numbersonly(this, event)">
</p>

<p>
Status :
<br>
<select name="status">
<option value="'.$e_status.'" selected>-'.$e_status_ket.'-</option>
<option value="true" selected>Aktif</option>
<option value="false" selected>Tidak Aktif</option>
</select>
</p>

<p>
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="submit" value="BATAL">
</p>';

if ($total != 0)
	{
	echo '<table width="400" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="1">&nbsp;</td>
	<td><strong><font color="'.$warnatext.'">Tahun Pelajaran</font></strong></td>
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
		$i_tahun1 = nosql($row['tahun1']);
		$i_tahun2 = nosql($row['tahun2']);
		$i_status = nosql($row['status']);




		//jika aktif
		if ($i_status == "true")
			{
			$i_status_ket = "[<font color='red'><strong>AKTIF</strong></font>].";
			}
		else if ($i_status == "false")
			{
			$i_status_ket = "";
			}


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
       	</td>
		<td>
		<a href="'.$filenya.'?s=edit&kd='.$i_kd.'">
		<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
		</a>
		</td>
		<td>
		'.$i_tahun1.'/'.$i_tahun2.' '.$i_status_ket.'
		</td>
        </tr>';
		}
	while ($row = mysqli_fetch_assoc($q));

	echo '</table>
	<table width="400" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	<input name="jml" type="hidden" value="'.$total.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kdx.'">
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$total.')">
	<input name="btnBTL" type="reset" value="BATAL">
	<input name="btnHPS" type="submit" value="HAPUS">
	</td>
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

echo '</form>';
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