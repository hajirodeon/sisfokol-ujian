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
require("../../inc/cek/guru.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "soal_post.php";
$judul = "Input/Edit Soal";
$judulku = "[$adm_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$mpkd = nosql($_REQUEST['mpkd']);
$gkd = nosql($_REQUEST['gkd']);
$s = nosql($_REQUEST['s']);
$soalkd = nosql($_REQUEST['soalkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//focus
$diload = "document.formx.y_no.focus();";



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//bikin folder
//jika baru
if ($s == "baru")
	{
	//nilai
	$path3 = "../../filebox";
	$path2 = "../../filebox/soal";
	$path1 = "../../filebox/soal/$soalkd";
	chmod($path3,0777);
	chmod($path2,0777);

	//cek, sudah ada belum
	if (!file_exists($path1))
		{
		mkdir("$path1", 0777);
		}
	}




//nek batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_REQUEST['tapelkd']);
	$kelkd = nosql($_REQUEST['kelkd']);
	$mpkd = nosql($_REQUEST['mpkd']);
	$gkd = nosql($_REQUEST['gkd']);
	$page= nosql($_REQUEST['page']);


	//re-direct
	$ke = "soal.php?tapelkd=$tapelkd&kelkd=$kelkd&mpkd=$mpkd&gkd=$gkd&page=$page";
	xloc($ke);
	exit();
	}





//jika edit
if ($s == "edit")
	{
	//nilai
	$tapelkd = nosql($_REQUEST['tapelkd']);
	$kelkd = nosql($_REQUEST['kelkd']);
	$mpkd = nosql($_REQUEST['mpkd']);
	$gkd = nosql($_REQUEST['gkd']);
	$soalkd = nosql($_REQUEST['soalkd']);
	$page= nosql($_REQUEST['page']);

	//query soal
	$qx = mysql_query("SELECT * FROM m_soal ".
						"WHERE kd_guru_mapel = '$gkd' ".
						"AND kd = '$soalkd'");
	$rowx = mysql_fetch_assoc($qx);
	$x_no = nosql($rowx['no']);
	$x_isi = balikin($rowx['isi']);
	$x_kunci = nosql($rowx['kunci']);
	$x_status = nosql($rowx['aktif']);



	//jika aktif
	if ($x_status == "true")
		{
		$x_status2 = "AKAN DIKERJAKAN SISWA";
		}
	else if ($x_status == "false")
		{
		$x_status2 = "CADANGAN";
		}
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$mpkd = nosql($_POST['mpkd']);
	$gkd = nosql($_POST['gkd']);
	$soalkd = nosql($_POST['soalkd']);
	$page = nosql($_POST['page']);
	$x_no = nosql($_POST['y_no']);
	$x_isi = cegah2($_POST['editor']);
	$x_kunci = nosql($_POST['y_kunci']);
	$x_status = nosql($_POST['y_status']);

	//nek null
	if ((empty($x_no)) OR (empty($x_isi)) OR (empty($x_kunci)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mpkd=$mpkd&gkd=$gkd&soalkd=$soalkd&s=baru";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika baru
		if ($s == "baru")
			{
			///cek
			$qcc = mysql_query("SELECT * FROM m_soal ".
						"WHERE kd_guru_mapel = '$gkd' ".
						"AND isi = '$x_isi'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//re-direct
				$pesan = "Soal Tersebut Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mpkd=$mpkd&gkd=$gkd&soalkd=$soalkd&s=baru";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//insert soal
				mysql_query("INSERT INTO m_soal(kd, kd_guru_mapel, no, isi, kunci, aktif, postdate) VALUES ".
								"('$soalkd', '$gkd', '$x_no', '$x_isi', '$x_kunci', '$x_status', '$today')");


				//re-direct
				$ke = "soal.php?tapelkd=$tapelkd&kelkd=$kelkd&mpkd=$mpkd&gkd=$gkd";
				xloc($ke);
				exit();
				}
			}


		//jika update
		else if ($s == "edit")
			{
			//update soal
			mysql_query("UPDATE m_soal SET no = '$x_no', ".
							"isi = '$x_isi', ".
							"kunci = '$x_kunci', ".
							"postdate = '$today', ".
							"aktif = '$x_status' ".
							"WHERE kd_guru_mapel = '$gkd' ".
							"AND kd = '$soalkd'");

							
			//re-direct
			$ke = "soal.php?tapelkd=$tapelkd&kelkd=$kelkd&mpkd=$mpkd&gkd=$gkd";
			xloc($ke);
			exit();
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();



//js
require("../../inc/js/editor.js");
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");
require("../../inc/js/swap.js");
require("../../inc/js/openwindow.js");
require("../../inc/menu/guru.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaover.'">
<td>
<strong>Mata Pelajaran :</strong> ';

//terpilih
$qmpx = mysql_query("SELECT * FROM m_mapel ".
						"WHERE kd = '$mpkd'");
$rowmpx = mysql_fetch_assoc($qmpx);
$mpx_kd = nosql($rowmpx['kd']);
$mpx_mapel = balikin($rowmpx['mapel']);

echo ''.$mpx_mapel.'
</td>
</tr>
</table>
<p>
<strong>No. Soal : </strong>
<br>
<input name="y_no" type="text" value="'.$x_no.'" size="3" onKeyPress="return numbersonly(this, event)">,
</p>

<p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<strong>Isi Soal : </strong>
</td>
</tr>
</table>
<br>
<textarea id="editor" name="editor" rows="20" cols="80" style="width: 100%">'.$x_isi.'</textarea>
</p>

<p>
<strong>Kunci Jawaban :</strong>
<br>
<select name="y_kunci">
<option value="'.$x_kunci.'" selected>'.$x_kunci.'</option>';

//looping opsi
for ($j=1;$j<=5;$j++)
	{
	//array pilihan
	$arrpil = array('1' => 'A',
					'2' => 'B',
					'3' => 'C',
					'4' => 'D',
					'5' => 'E');

	echo '<option value="'.$arrpil[$j].'">'.$arrpil[$j].'</option>';
	}

echo '</select>
</p>



<p>
<strong>Status :</strong>
<br>
<select name="y_status">
<option value="'.$x_status.'" selected>'.$x_status2.'</option>
<option value="true">Akan Dikerjakan Siswa</option>
<option value="false">Soal Cadangan</option>
</select>
</p>



<p>
<input name="jml" type="hidden" value="'.$count.'">
<input name="s" type="hidden" value="'.$s.'">
<input name="soalkd" type="hidden" value="'.$soalkd.'">
<input name="gkd" type="hidden" value="'.$gkd.'">
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="mpkd" type="hidden" value="'.$mpkd.'">
<input name="page" type="hidden" value="'.$page.'">
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="submit" value="BATAL">
</p>
</form>
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