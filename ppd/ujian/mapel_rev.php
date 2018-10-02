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
require("../../inc/cek/siswa.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "mapel_rev.php";
$judul = "Ujian Mata Pelajaran";
$judulku = "[$ppd_session : $no4_session.$nama4_session] ==> $judul";
$judulx = $judul;








//ketahui tapel aktif
$qtp = mysql_query("SELECT * FROM m_tapel ".
			"WHERE status = 'true'");
$rtp = mysql_fetch_assoc($qtp);
$tp_tapelkd = nosql($rtp['kd']);
$tp_tahun1 = nosql($rtp['tahun1']);
$tp_tahun2 = nosql($rtp['tahun2']);





//isi *START
ob_start();


//js
require("../../inc/js/swap.js");
require("../../inc/menu/siswa.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';



//query
$q = mysql_query("SELECT * FROM m_mapel ".
			"WHERE kd_tapel = '$tp_tapelkd' ".
			"ORDER BY no ASC");
$row = mysql_fetch_assoc($q);
$total = mysql_num_rows($q);

echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="50"><strong><font color="'.$warnatext.'">No</font></strong></td>
<td><strong><font color="'.$warnatext.'">Nama Pelajaran</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Jml. Soal</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Bobot</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Jml. Menit</font></strong></td>
<td width="1">&nbsp;</td>
</tr>';

if ($total != 0)
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
		$d_kd = nosql($row['kd']);
		$d_nilkd = nosql($row['no']);
		$d_mapel = balikin($row['mapel']);
		$d_bobot = nosql($row['bobot']);
		$d_menit = nosql($row['jml_menit']);



		//jumlah soal
		$qku = mysql_query("SELECT * FROM m_soal ".
					"WHERE kd_mapel = '$d_kd' ".
					"AND aktif = 'true'");
		$rku = mysql_fetch_assoc($qku);
		$tku = mysql_num_rows($qku);


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$d_nilkd.'</td>
		<td>'.$d_mapel.'</td>
		<td>'.$tku.'</td>
		<td>'.$d_bobot.'</td>
		<td>'.$d_menit.'</td>
		<td>
		<a href="mapel_soal.php?s=rev&mapelkd='.$d_kd.'" title="Ujian Mata Pelajaran : '.$d_mapel.'";>
		<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
		</a>
		</td>
		</tr>';
		}
	while ($row = mysql_fetch_assoc($q));
	}

echo '</table>';


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