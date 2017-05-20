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
require("../../inc/class/paging.php");
require("../../inc/cek/guru.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "soal.php";
$judul = "Data Soal Ujian Online";
$judulku = "[$adm_session] ==> $judul";
$judulx = $judul;

$tapelkd = nosql($_REQUEST['tapelkd']);
$gkd = nosql($_REQUEST['gkd']);

//pel-nya
$quru = mysql_query("SELECT * FROM guru_mapel ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_guru = '$kd1_session' ".
						"AND kd = '$gkd'");
$ruru = mysql_fetch_assoc($quru);
$turu = mysql_num_rows($quru);
$kd_prog_pddkn = nosql($ruru['kd_mapel']);
$kd_kelas = nosql($ruru['kd_kelas']);


//kelas
$q2 = mysql_query("SELECT * FROM m_kelas ".
					"WHERE kd = '$kd_kelas'");
$r2 = mysql_fetch_assoc($q2);
$gkelas = balikin($r2['kelas']);




//mapel
$q1 = mysql_query("SELECT * FROM m_mapel ".
					"WHERE kd = '$kd_prog_pddkn'");
$r1 = mysql_fetch_assoc($q1);
$gpel = balikin($r1['mapel']);




$gkd = nosql($_REQUEST['gkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//focus
$diload = "document.formx.y_no.focus();";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$gkd = nosql($_POST['gkd']);

	//ambil semua
	for ($i=1; $i<=$limit;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);


		//del
		mysql_query("DELETE FROM m_soal ".
						"WHERE kd_guru_mapel = '$gkd' ".
						"AND kd = '$kd'");


		//query
		$qcc = mysql_query("SELECT * FROM m_soal_filebox ".
								"WHERE kd_guru_mapel = '$gkd'");
		$rcc = mysql_fetch_assoc($qcc);

		do
			{
			//hapus file
			$cc_filex = $rcc['filex'];
			$path1 = "../../filebox/soal/$soalkd/$cc_filex";
			chmod($path1,0777);
			unlink ($path1);
			}
		while ($rcc = mysql_fetch_assoc($qcc));

		//hapus query
		mysql_query("DELETE FROM m_soal_filebox ".
						"WHERE kd_guru_mapel = '$gkd' ".
						"AND kd_soal = '$kd'");

		//nek $kd gak null
		if (!empty($kd))
			{
			//hapus folder
			$path2 = "../../filebox/soal/$kd";
			chmod($path2,0777);
			delete ($path2);
			}
		}

	//auto-kembali
	$ke = "$filenya?gkd=$gkd";
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
require("../../inc/menu/guru.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaover.'">
<td>';



//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);



//terpilih
$mpx_mapel = $gpel;

echo 'Tahun Pelajaran : <b>'.$tpx_thn1.'/'.$tpx_thn2.'</b>. 
Mata Pelajaran : <strong>'.$mpx_mapel.'</strong>. 
[Kelas : <b>'.$gkelas.'</b>].
[<a href="../index.php?tapelkd='.$tapelkd.'">Daftar Mapel Lainnya</a>].
</td>
</tr>
</table>


<p>
[<a href="soal_post.php?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&mpkd='.$mpkd.'&gkd='.$gkd.'&soalkd='.$x.'&s=baru">Input Soal Baru</a>].
</p>';


//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT * FROM m_soal ".
				"WHERE kd_guru_mapel = '$gkd' ".
				"ORDER BY round(no) ASC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$target = "$filenya?gkd=$gkd";
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);

if ($count != 0)
	{
	echo '<p>
	Total Soal : <b>'.$count.'</b>
	<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr align="center" bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="1">&nbsp;</td>
	<td width="1"><strong><font color="'.$warnatext.'">No.</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Isi Soal</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Kunci Jawaban</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Status akan Dikerjakan</font></strong></td>
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
		$kd = nosql($data['kd']);
		$d_no = nosql($data['no']);
		$d_isi = balikin($data['isi']);
		$d_kunci = nosql($data['kunci']);
		$d_aktif = nosql($data['aktif']);

		//jika aktif
		if ($d_aktif == "true")
			{
			$d_status = "AKAN DIKERJAKAN SISWA";
			}
		else if ($d_aktif == "false")
			{
			$d_status = "CADANGAN";
			$warna = "orange";
			}

		$d_isi2 = pathasli2($d_isi);


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'">
		</td>
		<td>
		<a href="soal_post.php?s=edit&gkd='.$gkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&mpkd='.$kd_prog_pddkn.'&soalkd='.$kd.'&page='.$page.'">
		<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
		</a>
		</td>
		<td>'.$d_no.'.</td>
		<td>
		'.$d_isi2.'
		</td>
		<td><strong>'.$d_kunci.'</strong></td>
		<td><strong>'.$d_status.'</strong></td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));


	echo '</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td width="263">
	<input name="jml" type="hidden" value="'.$count.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kdx.'">
	<input name="gkd" type="hidden" value="'.$gkd.'">
	<input name="page" type="hidden" value="'.$page.'">
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')">
	<input name="btnBTL" type="submit" value="BATAL">
	<input name="btnHPS" type="submit" value="HAPUS">
	</td>
	<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
	</tr>
	</table>
	</p>';
	}
else
	{
	echo '<p>
	<font color="red">
	<strong>Belum Ada Data Soal. Silahkan Entry...</strong>
	</font>
	</p>';
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
xclose($koneksi);
exit();
?>