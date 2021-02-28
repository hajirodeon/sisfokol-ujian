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

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/guru.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "siswa.php";
$judul = "Data Siswa";
$judulku = "$judul  [$adm_session]";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$swkd = nosql($_REQUEST['swkd']);
$mpkd = nosql($_REQUEST['mpkd']);
$gkd = nosql($_REQUEST['gkd']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&page=$page";







//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();";
	}




//nek enter, ke simpan
$x_enter = 'onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	}"';




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);



	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
	xloc($ke);
	exit();
	}





//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin2($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);


	//cek
	if ((empty($crkd)) OR (empty($kunci)))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	}











//jika batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&page=$page";
	xloc($ke);
	exit();
	}



//jika daftar siswa
if ($_POST['btnDS'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&page=$page";
	xloc($ke);
	exit();
	}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/menu/guru.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<script type="text/javascript">
$(document).ready(function() {
$(function() {
	$('#datepicker1').datepicker({
		changeMonth: true,
		yearRange: "-100:-10",
		changeYear: true
		});

	});




});
</script>


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




echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">
[<a href="../index.php?tapelkd='.$tapelkd.'">DAFTAR MATA PELAJARAN LAINNYA</a>].
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';


//terpilih
$qtpx = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysqli_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<b>
'.$tpx_thn1.'/'.$tpx_thn2.'</b>, 



Kelas : ';

//terpilih
$qjnx = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowjnx = mysqli_fetch_assoc($qjnx);
$jnx_kd = nosql($rowjnx['kd']);
$jnx_jns = balikin($rowjnx['kelas']);

echo '<b>
'.$jnx_jns.'
</b>


<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="swkd" type="hidden" value="'.$swkd.'">


</td>
</tr>
</table>';


//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($kelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>
	</p>';
	}
	
else
	{
	//query DATA
	$tapelkd = nosql($_REQUEST['tapelkd']);
	$kelkd = nosql($_REQUEST['kelkd']);

	//nis
	if ($crkd == "cr01")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT siswa.*, ".
						"DATE_FORMAT(siswa.tgl_lahir, '%d') AS tgl, ".
						"DATE_FORMAT(siswa.tgl_lahir, '%m') AS bln, ".
						"DATE_FORMAT(siswa.tgl_lahir, '%Y') AS thn, ".
						"siswa.kd AS mskd ".
						"FROM siswa ".
						"WHERE kd_tapel = '$tapelkd' ".
						"AND kd_kelas = '$kelkd' ".
						"AND nis LIKE '%$kunci%' ".
						"ORDER BY nis ASC";
		$sqlresult = $sqlcount;

		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}

	//nama
	else if ($crkd == "cr02")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT siswa.*, ".
						"DATE_FORMAT(siswa.tgl_lahir, '%d') AS tgl, ".
						"DATE_FORMAT(siswa.tgl_lahir, '%m') AS bln, ".
						"DATE_FORMAT(siswa.tgl_lahir, '%Y') AS thn, ".
						"siswa.kd AS mskd ".
						"FROM siswa ".
						"WHERE siswa.kd_tapel = '$tapelkd' ".
						"AND siswa.kd_kelas = '$kelkd' ".
						"AND siswa.nama LIKE '%$kunci%' ".
						"ORDER BY siswa.nama ASC";
		$sqlresult = $sqlcount;

		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}

	else
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT siswa.*, ".
						"DATE_FORMAT(siswa.tgl_lahir, '%d') AS tgl, ".
						"DATE_FORMAT(siswa.tgl_lahir, '%m') AS bln, ".
						"DATE_FORMAT(siswa.tgl_lahir, '%Y') AS thn, ".
						"siswa.kd AS mskd ".
						"FROM siswa ".
						"WHERE siswa.kd_tapel = '$tapelkd' ".
						"AND siswa.kd_kelas = '$kelkd' ".
						"ORDER BY siswa.nis ASC";
		$sqlresult = $sqlcount;

		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}



		echo '<table width="100%" border="0" cellpadding="3" cellspacing="0">
		<tr bgcolor="'.$warna02.'">
		<td>';
		echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
		echo '<option value="'.$filenya.'?crkd='.$crkd.'&crtipe='.$crtipe.'&kunci='.$kunci.'" selected>'.$crtipe.'</option>
		<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&crkd=cr01&crtipe=NIS&kunci='.$kunci.'">NIS</option>
		<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&crkd=cr02&crtipe=Nama&kunci='.$kunci.'">Nama</option>
		</select>
		<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		<input name="kelkd" type="hidden" value="'.$kelkd.'">
		<input name="kunci" type="text" value="'.$kunci.'" size="30">
		<input name="crkd" type="hidden" value="'.$crkd.'">
		<input name="crtipe" type="hidden" value="'.$crtipe.'">
		<input name="btnCARI" type="submit" value="CARI >>">
		<input name="btnRST" type="submit" value="RESET">
		</td>
		</tr>
		</table>';




		//jika beri pass
		if ($s == "beri")
			{
			//detail e
			$qdt = mysqli_query($koneksi, "SELECT * FROM siswa ".
									"WHERE kd = '$swkd'");
			$rdt = mysqli_fetch_assoc($qdt);
			$d_username = nosql($rdt['usernamex']);
			$d_nis = balikin($rdt['nis']);
			$d_nama = balikin($rdt['nama']);

		
			//berikan password baru
			$passbaru1 = substr(md5($today),0,7);
			$passbarux = md5($passbaru1);
		
		
		
		
		
			//set
			mysqli_query($koneksi, "UPDATE siswa SET passwordx = '$passbarux' ".
							"WHERE kd = '$swkd'");
		
		
			echo '<p>
			NIS :
			<br>
			<strong>'.$d_nis.'</strong>
			</p>
		
			<p>
			Nama :
			<br>
			<strong>'.$d_nama.'</strong>
			</p>
		
			<p>
			<hr>
			Password Baru :
			<br>
			<h1>
			'.$passbaru1.'
			</h1>
			<hr>
			</p>';
			}
		else
			{
			//nek ada
			if ($count != 0)
				{
				echo '<table width="100%" border="1" cellpadding="3" cellspacing="0">
				<tr bgcolor="'.$warnaheader.'">
				<td width="50"><strong>NIS</strong></td>
				<td width="150"><strong>Nama</strong></td>
				<td width="5"><strong>L/P</strong></td>
				<td width="150"><strong>TTL.</strong></td>
				<td><strong>Alamat</strong></td>
				<td><strong>Telp.</strong></td>
				<td><strong>Ket.</strong></td>				
				<td width="100"><strong>BERI PASSWORD UJIAN</strong></td>
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
	
					$kd = nosql($data['mskd']);
					$nis = nosql($data['nis']);
					$i_userx = nosql($data['usernamex']);
					$i_passx = nosql($data['passwordx']);
					$nama = balikin($data['nama']);
					$i_alamat = balikin($data['alamat']);
					$i_telp = balikin($data['telp']);
					$i_ket = balikin($data['ket']);
					$kd_kelamin = nosql($data['kelamin']);
					$tmp_lahir = balikin2($data['tmp_lahir']);
					$tgl_lahir = nosql($data['tgl']);
					$bln_lahir = nosql($data['bln']);
					$thn_lahir = nosql($data['thn']);
	
	
	
	
	
					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td valign="top">
					'.$nis.'
					</td>
					<td valign="top">
					'.$nama.'
					</td>
					<td valign="top">
					'.$kd_kelamin.'
					</td>
					<td valign="top">
					'.$tmp_lahir.', '.$tgl_lahir.' '.$arrbln1[$bln_lahir].' '.$thn_lahir.'
					</td>
					<td valign="top">
					'.$i_alamat.'
					</td>
					<td valign="top">
					'.$i_telp.'
					</td>
					<td valign="top">
					'.$i_ket.'
					</td>
	
					<td valign="top">
					<a href="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&mpkd='.$mpkd.'&gkd='.$gkd.'&s=beri&swkd='.$kd.'" title="Beri Password...">
					<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
					</a>
					</td>
					
					</tr>';
					}
				while ($data = mysqli_fetch_assoc($result));
	
				echo '</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="3">
				<tr>
				<td>
				<input name="jml" type="hidden" value="'.$limit.'">
				<input name="s" type="hidden" value="'.$s.'">
				<input name="total" type="hidden" value="'.$count.'">
				<font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'
				</td>
				</tr>
				</table>';
				}
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