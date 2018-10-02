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
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "index.php";
$judul = "Selamat Datang....";
$judulku = "$judul  [$ppd_session : $no4_session. $nama4_session]";


//isi *START
ob_start();

//menu
require("../inc/menu/siswa.php");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="middle">
<td valign="middle">
<p>
Anda Berada di <font color="blue"><strong>SISWA</strong></font> : <strong>'.$nama4_session.'.</strong>
</p>
<p><em>{Login Ini Hanyalah Sekali. Jikalau LogOut, Maka Harus Minta Akses Lagi dari Guru.)</em></p>
</td>
</tr>
</table>';




//data ne
$qdty = mysql_query("SELECT * FROM siswa ".
						"WHERE kd = '$kd4_session'");
$rdty = mysql_fetch_assoc($qdty);
$tdty = mysql_num_rows($qdty);


echo '<table width="900" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="50"><strong>Tahun Pelajaran</strong></td>
<td width="50"><strong>Kelas</strong></td>
<td><strong>Mata Pelajaran</strong></td>
</tr>';

//nek gak null
if ($tdty != 0)
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


		//nilai
		$dty_swkd = nosql($rdty['mskd']);
		$dty_tapelkd = nosql($rdty['kd_tapel']);
		$dty_kelkd = nosql($rdty['kd_kelas']);


		//tapel
		$qypel = mysql_query("SELECT * FROM m_tapel ".
								"WHERE kd = '$dty_tapelkd'");
		$rypel = mysql_fetch_assoc($qypel);
		$ypel_thn1 = nosql($rypel['tahun1']);
		$ypel_thn2 = nosql($rypel['tahun2']);

		//kelas
		$qykel = mysql_query("SELECT * FROM m_kelas ".
								"WHERE kd = '$dty_kelkd'");
		$rykel = mysql_fetch_assoc($qykel);
		$ykel_kelas = balikin($rykel['kelas']);






		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$ypel_thn1.'/'.$ypel_thn2.'</td>
		<td>'.$ykel_kelas.'</td>
		<td>';


/*
		//pel-nya
		$quru = mysql_query("SELECT m_mapel.* ".
								"FROM m_mapel, guru_mapel ".
								"WHERE guru_mapel.kd_mapel = m_mapel.kd ".
								"AND guru_mapel.kd_tapel = '$dty_tapelkd' ".
								"AND guru_mapel.kd_kelas = '$dty_kelkd'");
		$ruru = mysql_fetch_assoc($quru);


		do
			{
			$gkd = nosql($ruru['kd']);
			$qpel = nosql($ruru['mapel']);


			echo "$qpel <br>";
			}
		while ($ruru = mysql_fetch_assoc($quru));

*/


		//pel-nya
		$quru = mysql_query("SELECT m_mapel.* ".
								"FROM m_mapel, guru_mapel ".
								"WHERE guru_mapel.kd_mapel = m_mapel.kd ".
								"AND guru_mapel.kd_tapel = '$dty_tapelkd' ".
								"AND guru_mapel.kd_kelas = '$dty_kelkd'");
		$ruru = mysql_fetch_assoc($quru);


		do
			{
			$mpkd = nosql($ruru['kd']);
			$qpel = nosql($ruru['mapel']);
			
			
			
			
			//pel-nya
			$quru = mysql_query("SELECT * FROM guru_mapel ".
									"WHERE kd_tapel = '$dty_tapelkd' ".
									"AND kd_mapel = '$mpkd' ".
									"AND kd_kelas = '$dty_kelkd'");
			$ruru = mysql_fetch_assoc($quru);
			$turu = mysql_num_rows($quru);		
			$gkd = nosql($ruru['kd']);
			$x_bobot = nosql($ruru['bobot']);
			$x_menit = nosql($ruru['jml_menit']);
			
	
			//jumlah soal
			$qku = mysql_query("SELECT * FROM m_soal ".
								"WHERE kd_guru_mapel = '$gkd' ".
								"AND aktif = 'true'");
			$rku = mysql_fetch_assoc($qku);
			$tku = mysql_num_rows($qku);



			echo ''.$qpel.' 
			<br>
			[Jumlah Soal : '.$tku.']. [Jumlah Bobot : '.$x_bobot.']. [Jumlah Max.Mengerjakan : '.$x_menit.' Menit].
			<br>
			[<a href="ujian/mapel_soal.php?s=baru&gkd='.$gkd.'&pelkd='.$mpkd.'" title="Ujian Mata Pelajaran : '.$qpel.'";>
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">].
			
			<br>
			<br>';
			}
		while ($ruru = mysql_fetch_assoc($quru));


		echo '</td>
		</tr>';
		}
	while ($rdty = mysql_fetch_assoc($qdty));
	}

echo '</table>
<br><br><br>';

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>