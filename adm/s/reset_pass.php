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
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "reset_pass.php";
$diload = "document.formx.akses.focus();";
$judul = "Reset Password";
$judulku = "[$adm_session] ==> $judul";
$juduli = $judul;
$tpkd = nosql($_REQUEST['tpkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$tipe = cegah($_REQUEST['tipe']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}







//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika reset
if ($_POST['btnRST'])
	{
	//entri history ////////////////////////////////////////////////////////////////////////////////////////////////
	//ketahui tapel aktif
	$qtp = mysql_query("SELECT * FROM m_tapel ".
				"WHERE status = 'true'");
	$rtp = mysql_fetch_assoc($qtp);
	$tp_tapelkd = nosql($rtp['kd']);
	$tp_tahun1 = nosql($rtp['tahun1']);
	$tp_tahun2 = nosql($rtp['tahun2']);


	$ketnya = "$judulku [EDIT DATA]";
	mysql_query("INSERT INTO login_log(kd, kd_tapel, kd_login, url_inputan, postdate) VALUES ".
			"('$x', '$tp_tapelkd', '$kd1_session', '$ketnya', '$today')");
	//entri history ////////////////////////////////////////////////////////////////////////////////////////////////




	$tpkd = nosql($_POST['tpkd']);
	$tipe = cegah($_POST['tipe']);
	$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";
	$page = nosql($_POST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}




	//nek calon .........................................................................................................................
	if ($tpkd == "tp03")
		{
		//nilai
		$item = nosql($_POST['item']);
		$page = nosql($_POST['page']);
		$passbarux = md5($passbaru);

		//cek
		if (empty($item))
			{
			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//update
			mysql_query("UPDATE siswa SET passwordx = '$passbarux' ".
							"WHERE kd = '$item'");

			//auto-kembali
			$pesan = "Password Baru : $passbaru";
			pekem($pesan,$ke);
			exit();
			}
		}
		
		
		
		


	//nek guru .........................................................................................................................
	if ($tpkd == "tp05")
		{
		//nilai
		$item = nosql($_POST['item']);
		$page = nosql($_POST['page']);
		$passbarux = md5($passbaru);

		//cek
		if (empty($item))
			{
			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//update
			mysql_query("UPDATE guru SET passwordx = '$passbarux' ".
							"WHERE kd = '$item'");

			//auto-kembali
			$pesan = "Password Baru : $passbaru";
			pekem($pesan,$ke);
			exit();
			}
		}
		
	//...................................................................................................................................
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/adm.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Akses : ';
echo "<select name=\"akses\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$filenya.'?tpkd='.$tpkd.'" selected>--'.$tipe.'--</option>
<option value="'.$filenya.'?tpkd=tp05&tipe=Guru">Guru</option>
<option value="'.$filenya.'?tpkd=tp03&tipe=Siswa">Siswa</option>
</select>
</td>
</tr>
</table>

<p>';



//nek guru ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($tpkd == "tp05")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM guru ".
					"ORDER BY nama ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?tpkd=$tpkd&tipe=$tipe";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);



	//view
	echo '<table width="700" border="1" cellspacing="0" cellpadding="3">
	<tr align="center" bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="100"><strong><font color="'.$warnatext.'">NIP</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
	</tr>';

	if ($count != 0)
		{
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
			$d_kd = nosql($data['kd']);
			$d_noreg = nosql($data['nip']);
			$d_username = nosql($data['usernamex']);
			$d_password = nosql($data['passwordx']);
			$d_nama = balikin($data['nama']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="radio" name="item" value="'.$d_kd.'">
			</td>
			<td>'.$d_noreg.'</td>
			<td>'.$d_nama.'</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));
		}

	echo '</table>
	<table width="700" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="page" type="hidden" value="'.$page.'">
	<input name="btnRST" type="submit" value="RESET">
	</td>
	<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
	</tr>
	</table>
	<br><br>';
	}




//nek siswa ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($tpkd == "tp03")
	{
	//ketahui tapel aktif
	$qtp = mysql_query("SELECT * FROM m_tapel ".
							"WHERE status = 'true'");
	$rtp = mysql_fetch_assoc($qtp);
	$tp_tapelkd = nosql($rtp['kd']);
	$tp_tahun1 = nosql($rtp['tahun1']);
	$tp_tahun2 = nosql($rtp['tahun2']);



	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT siswa.*, siswa.nama AS scnama ".
					"FROM siswa ".
					"WHERE siswa.kd_tapel = '$tp_tapelkd' ".
					"ORDER BY nis ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?tpkd=$tpkd&tipe=$tipe";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);



	//view
	echo 'Tahun Pelajaran : '.$tp_tahun1.'/'.$tp_tahun2.'
	<table width="700" border="1" cellspacing="0" cellpadding="3">
	<tr align="center" bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="100"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
	</tr>';

	if ($count != 0)
		{
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
			$d_kd = nosql($data['kd']);
			$d_noreg = nosql($data['nis']);
			$d_username = nosql($data['usernamex']);
			$d_password = nosql($data['passwordx']);
			$d_nama = balikin($data['scnama']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="radio" name="item" value="'.$d_kd.'">
			</td>
			<td>'.$d_noreg.'</td>
			<td>'.$d_nama.'</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));
		}

	echo '</table>
	<table width="700" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="page" type="hidden" value="'.$page.'">
	<input name="btnRST" type="submit" value="RESET">
	</td>
	<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
	</tr>
	</table>
	<br><br>';
	}


echo '</p></form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>