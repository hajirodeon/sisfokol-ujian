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
require("../../inc/cek/guru.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "nilai.php";
$judul = "Nilai Ujian Tertulis";
$judulku = "$judul  [$adm_session]";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$mpkd = nosql($_REQUEST['mpkd']);
$gkd = nosql($_REQUEST['gkd']);
$swkd = nosql($_REQUEST['swkd']);
$noregx = nosql($_REQUEST['noregx']);



//pel-nya
$quru = mysqli_query($koneksi, "SELECT * FROM guru_mapel ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_guru = '$kd1_session' ".
						"AND kd = '$gkd'");
$ruru = mysqli_fetch_assoc($quru);
$turu = mysqli_num_rows($quru);
$kd_prog_pddkn = nosql($ruru['kd_mapel']);
$kd_kelas = nosql($ruru['kd_kelas']);


//kelas
$q2 = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
					"WHERE kd = '$kd_kelas'");
$r2 = mysqli_fetch_assoc($q2);
$gkelas = balikin($r2['kelas']);




//mapel
$q1 = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
					"WHERE kd = '$kd_prog_pddkn'");
$r1 = mysqli_fetch_assoc($q1);
$gpel = balikin($r1['mapel']);




$gkd = nosql($_REQUEST['gkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}





$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}


$limit = "50";










//isi *START
ob_start();



//js
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
require("../../inc/js/jumpmenu.js");
require("../../inc/menu/guru.php");
xheadline($judul);



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="990" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaheader.'">
<td>';

//terpilih
$qtpx = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysqli_fetch_assoc($qtpx);
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
</table>';


//jumlah soal
$qsol = mysqli_query($koneksi, "SELECT * FROM m_soal ".
						"WHERE kd_guru_mapel = '$gkd' ".
						"AND aktif = 'true'");
$rsol = mysqli_fetch_assoc($qsol);
$tsol = mysqli_num_rows($qsol);



echo 'Jumlah Soal : <strong>'.$tsol.'</strong>.
<br>
<font color="magenta">
<strong>Warna Magenta </strong>
</font>
: Tidak Ada Yang Dikerjakan. Dan Tidak Dikumpulkan.
<br>
<font color="cyan">
<strong>Warna Cyan </strong>
</font>: Mengerjakan Semua Soal Yang Ada. Dan Sudah Dikumpulkan.
<br>
<font color="orange">
<strong>Warna Orange </strong>
</font>: Mengerjakan Semua Soal Yang Ada. Dan Tidak Dikumpulkan.
<br>
<font color="yellow">
<strong>Warna Yellow </strong>
</font>: Sedang Mengerjakan. Dan Belum Selesai. Atau Belum Dikumpulkan.
<br>
<font color="red">
<strong>Warna Merah </strong>
</font>: Telah Selesai. Dan Dikumpulkan.
<br>

<table width="990" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="100"><strong>Mulai Pengerjaan</strong></td>
<td width="100"><strong>Calon</strong></td>
<td width="100"><strong>Jml. Soal Yang Dikerjakan</strong></td>
<td width="100"><strong>Jml. Jawaban Benar</strong></td>
<td width="100"><strong>Jml. Jawaban Salah</strong></td>
<td width="100"><strong>Selesai Pengerjaan</strong></td>
<td width="50"><strong>Skor</strong></td>
<td width="50"><strong>Total</strong></td>
</tr>';



//query
$p = new Pager();
$start = $p->findStart($limit);


//daftar calon yang mengerjakan
$sqlcount = "SELECT DISTINCT(kd_siswa) AS swkd ".
				"FROM siswa_soal_nilai, siswa ".
				"WHERE siswa_soal_nilai.kd_siswa = siswa.kd ".
				"AND siswa.kd_tapel = '$tapelkd' ".
				"ORDER BY siswa_soal_nilai.waktu_mulai DESC, ".
				"siswa_soal_nilai.waktu_akhir DESC";
$sqlresult = $sqlcount;

$count = mysqli_num_rows(mysqli_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
$target = "$filenya?mpkd=$mpkd";
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysqli_fetch_array($result);


do
	{
	$wuka_ckd = nosql($data['swkd']);


	//query
	$qdt = mysqli_query($koneksi, "SELECT * FROM siswa ".
							"WHERE kd = '$wuka_ckd'");
	$rdt = mysqli_fetch_assoc($qdt);
	$dt_noregx = nosql($rdt['nis']);
	$dt_nama = balikin($rdt['nama']);




	//soal yang dikerjakan
	$qsyd = mysqli_query($koneksi, "SELECT * FROM siswa_soal ".
							"WHERE kd_siswa = '$wuka_ckd' ".
							"AND kd_guru_mapel = '$gkd' ".
							"AND jawab <> ''");
	$rsyd = mysqli_fetch_assoc($qsyd);
	$tsyd = mysqli_num_rows($qsyd);


	//jml. jawaban BENAR, SALAH, Skor, dan waktu mengerjakan
	$qwuk = mysqli_query($koneksi, "SELECT * FROM siswa_soal_nilai ".
							"WHERE kd_siswa ='$wuka_ckd' ".
							"AND kd_guru_mapel = '$gkd'");
	$rwuk = mysqli_fetch_assoc($qwuk);
	$wuk_jbenar = nosql($rwuk['jml_benar']);
	$wuk_jsalah = nosql($rwuk['jml_salah']);
	$wuk_skor = nosql($rwuk['skor']);
	$wuk_mulai = $rwuk['waktu_mulai'];
	$wuk_akhir = $rwuk['waktu_akhir'];
	$wuk_nilku = $wuk_skor * $e_bobot;
	$wuk_jawab = $wuk_jbenar + $wuk_jsalah;


/*
		//jika belum mengerjakan
		if (($wuk_jawab == $tsol) AND ($wuk_akhir == "0000-00-00 00:00:00"))
			{
			$warna = "cyan";
			}
*/
	//jika belum mengerjakan
	if (empty($tsyd))
		{
		$warna = "magenta";
		}

	//mengerjakan semua
	else if ($tsyd == $tsol)
		{
		//jika selesai
		if ($wuk_akhir <> "0000-00-00 00:00:00")
			{
			$warna = "cyan";
			}
		else if ($wuk_akhir == "0000-00-00 00:00:00")
			{
			$warna = "orange";
			}

		}

	else if (!empty($tsyd))
		{
		//jika selesai
		if ($wuk_akhir <> "0000-00-00 00:00:00")
			{
			$warna = "red";
			}
		else if ($wuk_akhir == "0000-00-00 00:00:00")
			{
			$warna = "yellow";
			}
/*
			else if (($wuk_akhir <> "0000-00-00 00:00:00") AND ($wuk_akhir < $wuk_mulai))
				{
				$warna = "blue";
				}

			else if (($wuk_akhir <> "0000-00-00 00:00:00") AND (empty($wuk_jbenar)))
				{
				$warna = "magenta";
				}
*/
		}




	//cari yang sudah ngerjakan, tp belum ngumpulkan...
	//mapel
	$qmpx = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
				"WHERE kd = '$mpkd'");
	$rowmpx = mysqli_fetch_assoc($qmpx);
	$mpx_kd = nosql($rowmpx['kd']);
	$mpx_mapel = balikin($rowmpx['mapel']);
	$mpx_bobot = nosql($rowmpx['bobot']);
	$mpx_menit = nosql($rowmpx['jml_menit']);




	//jml. jawaban BENAR
	$qju = mysqli_query($koneksi, "SELECT siswa_soal.*, m_soal.* ".
				"FROM siswa_soal, m_soal ".
				"WHERE siswa_soal.kd_soal = m_soal.kd ".
				"AND siswa_soal.kd_siswa = '$wuka_ckd' ".
				"AND siswa_soal.kd_guru_mapel = '$gkd' ".
				"AND siswa_soal.jawab = m_soal.kunci");
	$rju = mysqli_fetch_assoc($qju);
	$tju = mysqli_num_rows($qju);




	//soal yang dikerjakan
	$qsyd = mysqli_query($koneksi, "SELECT * FROM siswa_soal ".
				"WHERE kd_siswa = '$wuka_ckd' ".
				"AND kd_guru_mapel = '$gkd' ".
				"AND jawab <> ''");
	$rsyd = mysqli_fetch_assoc($qsyd);
	$tsyd = mysqli_num_rows($qsyd);



	//jml. jawaban SALAH
	$tsalah = round($tsyd - $tju);

	//waktu mulai dan akhir
	$qjux = mysqli_query($koneksi, "SELECT * FROM siswa_soal_nilai ".
							"WHERE kd_siswa = '$wuka_ckd' ".
							"AND kd_guru_mapel = '$gkd'");
	$rjux = mysqli_fetch_assoc($qjux);
	$wk_mulai = $rjux['waktu_mulai'];
	$wk_akhir = $rjux['waktu_akhir'];


	//total skor
	//$tskor = $mpx_bobot * $tju;
	$tskor = 0.25 * $tju;
	$wuk_nilku = $mpx_bobot * $tskor;


	//update nilai
	mysqli_query($koneksi, "UPDATE siswa_soal_nilai ".
					"SET jml_benar = '$tju', ".
					"jml_salah = '$tsalah', ".
					"skor = '$tskor' ".
					"WHERE kd_siswa = '$wuka_ckd' ".
					"AND kd_guru_mapel = '$gkd'");





	//cek
	$qcc2 = mysqli_query($koneksi, "SELECT * FROM siswa_tertulis ".
						"WHERE kd_siswa = '$wuka_ckd' ".
						"AND kd_guru_mapel = '$gkd'");
	$rcc2 = mysqli_fetch_assoc($qcc2);
	$tcc2 = mysqli_num_rows($qcc2);

	//jika ada
	if ($tcc2 != 0)
		{
		//entry update
		mysqli_query($koneksi, "UPDATE siswa_tertulis SET nilai = '$wuk_nilku' ".
						"WHERE kd_siswa = '$wuka_ckd' ".
						"AND kd_guru_mapel = '$gkd'");
		}
	else
		{
		mysqli_query($koneksi, "INSERT INTO siswa_tertulis(kd, kd_siswa, kd_guru_mapel, nilai) VALUES ".
				"('$xyz', '$wuka_ckd', '$gkd', '$wuk_nilku')");
		}





	//nilai tertulis ////////////////////////////////////////////////////////////////////////////////////
	//skor
	$qcku = mysqli_query($koneksi, "SELECT SUM(nilai) AS nilku ".
							"FROM siswa_tertulis ".
							"WHERE kd_siswa = '$wuka_ckd'");
	$rcku = mysqli_fetch_assoc($qcku);
	$nil_tertulis = round(nosql($rcku['nilku']),2);





	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='white';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$wuk_mulai.'</td>
	<td>'.$dt_noregx.'. '.$dt_nama.'</td>
	<td align="right">'.$tsyd.'</td>
	<td align="right">'.$wuk_jbenar.'</td>
	<td align="right">'.$wuk_jsalah.'</td>
	<td>'.$wuk_akhir.'</td>
	<td align="right"><strong>'.$wuk_skor.'</strong></td>
	<td align="right"><strong>'.$wuk_nilku.'</strong></td>
	</tr>';
	}
while ($data = mysqli_fetch_assoc($result));

echo '</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td align="left">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
</tr>
</table>';



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