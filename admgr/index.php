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

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
require("../inc/cek/guru.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "index.php";
$judul = "Selamat Datang....";
$judulku = "$judul  [$adm_session]";
$s = nosql($_REQUEST['s']);
$tapelkd = nosql($_REQUEST['tapelkd']);










//jika simpan
if ($_POST['btnSMP'])
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



	//nilai
	$gkd = nosql($_POST['gkd']);
	$tapelkd = nosql($_POST['tapelkd']);
	$mpkd = nosql($_POST['mpkd']);
	$x_bobot = nosql($_POST['bobot']);
	$x_menit = nosql($_POST['menit']);



	//update
	mysql_query("UPDATE guru_mapel SET bobot = '$x_bobot', ".
					"jml_menit = '$x_menit' ".
					"WHERE kd = '$gkd'");


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd";
	xloc($ke);
	exit();
	}








//jika batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd";
	xloc($ke);
	exit();
	}






//isi *START
ob_start();

//menu
require("../inc/js/swap.js");
require("../inc/js/jumpmenu.js");
require("../inc/menu/guru.php");

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

echo '<option value="'.nosql($rowtpx['kd']).'">'.nosql($rowtpx['tahun1']).'/'.nosql($rowtpx['tahun2']).'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd <> '$tapelkd' ".
			"ORDER BY tahun1 DESC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>';


//nek null
if (empty($tapelkd))
	{
	echo '<p>
	<font color="red">
	<strong>TAHUN PELAJARAN Belum Ditentukan...!!</strong>
	</font>
	</p>


	<br><br><br>

	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<td valign="middle" align="center">
	<p>
	Anda Berada di <font color="blue"><strong>GURU AREA</strong></font>
	</p>
	<p><em>{Harap Dikelola Dengan Baik.)</em></p>
	<p>&nbsp;</p>
	</td>
	</tr>
	</table>';
	}

else
	{
	//jika edit
	if ($s == "edit")
		{
		//nilai
		$mpkd = nosql($_REQUEST['mpkd']);
		$kelkd = nosql($_REQUEST['kelkd']);


		//pel-nya
		$quru = mysql_query("SELECT * FROM guru_mapel ".
								"WHERE kd_tapel = '$tapelkd' ".
								"AND kd_guru = '$kd1_session' ".
								"AND kd_mapel = '$mpkd' ".
								"AND kd_kelas = '$kelkd'");
		$ruru = mysql_fetch_assoc($quru);
		$turu = mysql_num_rows($quru);		
		$gkd = nosql($ruru['kd']);
		$x_bobot = nosql($ruru['bobot']);
		$x_menit = nosql($ruru['jml_menit']);

		//mapel
		$q1 = mysql_query("SELECT * FROM m_mapel ".
							"WHERE kd = '$mpkd'");
		$r1 = mysql_fetch_assoc($q1);
		$gpel = balikin($r1['mapel']);


		//kelas
		$q2 = mysql_query("SELECT * FROM m_kelas ".
							"WHERE kd = '$kelkd'");
		$r2 = mysql_fetch_assoc($q2);
		$gkelas = balikin($r2['kelas']);


		echo '<p>
		Nama MaPel : 
		<br>
		<b>'.$gpel.'</b> 
		<br>
		[Kelas : '.$gkelas.']
		</p>
		
		<p>
		Bobot :
		<br>
		<input name="bobot" type="text" value="'.$x_bobot.'" size="2" onKeyPress="return numbersonly(this, event)">
		</p>
		
		<p>
		Jml.Menit Max. Ujian Online :
		<br>
		<input name="menit" type="text" value="'.$x_menit.'" size="2" onKeyPress="return numbersonly(this, event)">
		</p>


		<p>
		<input name="s" type="hidden" value="'.$s.'">
		<input name="gkd" type="hidden" value="'.$gkd.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="mpkd" type="hidden" value="'.$mpkd.'">
		<input name="kelkd" type="hidden" value="'.$kelkd.'">
		<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		<input name="btnSMP" type="submit" value="SIMPAN">
		<input name="btnBTL" type="submit" value="BATAL">
		</p>';				
		}
	else
		{
		echo '<table width="900" border="1" cellpadding="3" cellspacing="0">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="5"><strong><font color="'.$warnatext.'">No.</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Kelas</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Mata Pelajaran</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Bobot</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Jml.Menit</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Soal</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Aktif</font></strong></td>		
		<td width="50"><strong><font color="'.$warnatext.'">Cadangan</font></strong></td>	
		<td width="50"><strong><font color="'.$warnatext.'">Data Siswa</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Siswa Nilai</font></strong></td>	
		</tr>';
		
	
		//pel-nya
		$quru = mysql_query("SELECT * FROM guru_mapel ".
								"WHERE kd_tapel = '$tapelkd' ".
								"AND kd_guru = '$kd1_session'");
		$ruru = mysql_fetch_assoc($quru);
		$turu = mysql_num_rows($quru);
		
		
		//jika gak null
		if (!empty($turu))
			{
			do
				{
				$nomex = $nomex + 1;
				$gkd = nosql($ruru['kd']);
				$kd_prog_pddkn = nosql($ruru['kd_mapel']);
				$kd_kelas = nosql($ruru['kd_kelas']);
		
		
				//mapel
				$q1 = mysql_query("SELECT * FROM m_mapel ".
									"WHERE kd = '$kd_prog_pddkn'");
				$r1 = mysql_fetch_assoc($q1);
				$gpel = balikin($r1['mapel']);
		
		
				//kelas
				$q2 = mysql_query("SELECT * FROM m_kelas ".
									"WHERE kd = '$kd_kelas'");
				$r2 = mysql_fetch_assoc($q2);
				$gkelas = balikin($r2['kelas']);
		
		
	
	
	
				$d_bobot = nosql($ruru['bobot']);
				$d_menit = nosql($ruru['jml_menit']);
				$d_status = nosql($ruru['aktif']);
		
		

		
				//jumlah soal
				$qku = mysql_query("SELECT * FROM m_soal ".
									"WHERE kd_guru_mapel = '$gkd'");
				$rku = mysql_fetch_assoc($qku);
				$tku = mysql_num_rows($qku);
		
		
		
				//jumlah soal aktif
				$qku2 = mysql_query("SELECT * FROM m_soal ".
										"WHERE kd_guru_mapel = '$gkd' ".
										"AND aktif = 'true'");
				$rku2 = mysql_fetch_assoc($qku2);
				$tku2 = mysql_num_rows($qku2);
		
				//jumlah soal pasif
				$qku3 = mysql_query("SELECT * FROM m_soal ".
										"WHERE kd_guru_mapel = '$gkd' ".
										"AND aktif = 'false'");
				$rku3 = mysql_fetch_assoc($qku3);
				$tku3 = mysql_num_rows($qku3);
		
	
		
			
				echo "<tr bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<a href="'.$filenya.'?tapelkd='.$tapelkd.'&s=edit&mpkd='.$kd_prog_pddkn.'&kelkd='.$kd_kelas.'&kd='.$d_kd.'">
				<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
				</a>
				</td>
				<td valign="top">'.$nomex.'.</td>
				<td valign="top">'.$gkelas.'</td>
				<td valign="top">'.$gpel.'</td>
				<td>'.$d_bobot.'</td>
				<td>'.$d_menit.'</td>
				<td>
				<a href="akad/soal.php?tapelkd='.$tapelkd.'&kelkd='.$kd_kelas.'&mpkd='.$kd_prog_pddkn.'&gkd='.$gkd.'">
				<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
				</a>
				<br>
				'.$tku.' Soal
				</td>
				<td>'.$tku2.'</td>
				<td>'.$tku3.'</td>
				<td>
				<a href="siswa/siswa.php?tapelkd='.$tapelkd.'&kelkd='.$kd_kelas.'&mpkd='.$kd_prog_pddkn.'&gkd='.$gkd.'">
				<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
				</a>
				</td>
				<td>
				<a href="siswa/nilai.php?tapelkd='.$tapelkd.'&kelkd='.$kd_kelas.'&mpkd='.$kd_prog_pddkn.'&gkd='.$gkd.'">
				<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
				</a>
				</td>
				</tr>';
				}
			while ($ruru = mysql_fetch_assoc($quru));
			}
		
		echo '</table>';
		}
	}





echo '</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>