<?php 
include '../../../config/db.php';

$bulan = $_GET['bulan'];
$tglBulan = date('Y');

// Ganti tanggal rekap sesuai yang diinginkan
$tanggalRekap = '2023-11-5';

$kelasMengajar = mysqli_query($con,"SELECT * FROM tb_mengajar 
	INNER JOIN tb_guru ON tb_mengajar.id_guru=tb_guru.id_guru
	INNER JOIN tb_master_mapel ON tb_mengajar.id_mapel=tb_master_mapel.id_mapel
	INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas=tb_mkelas.id_mkelas
	INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
	INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
	WHERE tb_mengajar.id_mengajar='$_GET[pelajaran]' AND tb_mengajar.id_mkelas='$_GET[kelas]'  AND tb_thajaran.status=1 AND tb_semester.status=1");

foreach ($kelasMengajar as $d) 
$tglBulan = $tanggalRekap; // Menggunakan tanggal rekap yang ditentukan
$tglTerakhir = date('t',strtotime($tglBulan));

?>
<style>
	body{
		font-family: arial;
	}
</style>
<table width="100%">
	<tr>
		<td>
			<img src="../../../logo-removebg-preview.PNG" width="130">
		</td>
		<td>
			<center>
				<h1>
					ABSENSI SISWA <br>
					<small> SMK PGRI WANARAJA</small>
				</h1>
				<hr>
				<em>
					Jl. Koropeak No.771, Cinunuk, Kec. Sucinaraja, <br>  Kabupaten Garut, Jawa Barat 44183 <br>
					<b>yahoo: smkpgriwanaraja@yahoo.com Telp. (0262) 444234</b> 
				</em>
			</center>
		</td>
		<td>
			<table width="100%">
				<tr>
					<td colspan="2"><b style="border: 2px solid;padding: 7px;">
						KELAS (<?= strtoupper($d['nama_kelas']) ?>)
					</b> </td>
					<td>
						<b style="border: 2px solid;padding: 7px;">
							<?=$d['semester'] ?> |
							<?=$d['tahun_ajaran'] ?>
						</b>
					</td>
					<td rowspan="5">
						<ul>
							<li>H= Hadir</li>
							<li>S = Sakit</li>
							<li>I = Izin</li>
							<li>A = Absen</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Nama Guru </td>
					<td>:</td>
					<td><?=$d['nama_guru'] ?></td>
				</tr>
				<tr>
					<td>Bidang Studi </td>
					<td>:</td>
					<td><?=$d['mapel'] ?></td>
				</tr>
				<tr>
					<td>Wali Kelas </td>
					<td>:</td>
					<td><?=$walas['nama_guru'] ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<hr style="height: 3px;border: 1px solid;">

<table width="100%" border="1" cellpadding="2" style="border-collapse: collapse;">
	<tr>
		<td rowspan="2" bgcolor="#EFEBE9" align="center">NO</td>
		<td rowspan="2" bgcolor="#EFEBE9">NAMA SISWA</td>
		<td rowspan="2" bgcolor="#EFEBE9" align="center">L/P</td>
		<td colspan="<?=$tglTerakhir;?>" style="padding: 8px;">PERTEMUAN BULAN : <b style="text-transform: uppercase;"><?php echo namaBulan($bulan);?> <?= date('Y',strtotime($tglBulan)); ?></b></td>
		<td colspan="5" align="center" bgcolor="#EFEBE9">JUMLAH</td>
	</tr>
	<tr>
		<?php 
		for ($i = 1; $i <= $tglTerakhir ; $i++) {
			echo "<td bgcolor='#EFEBE9' align='center'>".$i."</td>";
		}
		?> 
		<td bgcolor="#76FF03" align="center">H</td>
		<td bgcolor="#FFC107" align="center">S</td>
		<td bgcolor="#4CAF50" align="center">I</td>
		<td bgcolor="#D50000" align="center">A</td>
	</tr>
	<?php 
	// tampilkan absen siswa
	$no = 1;
	foreach ($qry as $ds) {
		$warna = ($no % 2 == 1) ? "#ffffff" : "#f0f0f0";
		?>
		<tr bgcolor="<?=$warna; ?>">
			<td align="center"><?=$no++; ?></td>
			<td><?=$ds['nama_siswa'];?></td>
			<td align="center"><?=$ds['jk'];?></td>
			<?php 
			for ($i = 1; $i <= $tglTerakhir; $i++) {
				$ket = mysqli_query($con, "SELECT * FROM _logabsensi
					INNER JOIN tb_mengajar ON _logabsensi.id_mengajar=tb_mengajar.id_mengajar
					INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
					INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
					WHERE DAY(tgl_absen)='$i' AND id_siswa='$ds[id_siswa]' AND _logabsensi.id_mengajar='$_GET[pelajaran]' AND DATE(tgl_absen)='$tanggalRekap' AND tb_mengajar.id_mkelas='$_GET[kelas]'  AND tb_thajaran.status=1 AND tb_semester.status=1 GROUP BY DAY(tgl_absen) ");
				foreach ($ket as $h) {
					if ($h['ket'] == 'H') {
						echo "<b style='color:#2196F3;'>H</b>";
					} elseif ($h['ket'] == 'I') {
						echo "<b style='color:#4CAF50;'>I</b>";
						} elseif ($h['ket'] == 'S') {
						echo "<b style='color:#FFC107;'>S</b>";
					} else {
						echo "<b style='color:#D50000;'>A</b>";
					}
				}
			}
			?>
			<td align="center" style="font-weight: bold;">
				<?php 
				$sakit = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(ket) AS sakit FROM _logabsensi
					INNER JOIN tb_mengajar ON _logabsensi.id_mengajar=tb_mengajar.id_mengajar
					INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
					INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
					WHERE _logabsensi.id_siswa='$ds[id_siswa]' and _logabsensi.ket='S' and DATE(tgl_absen)='$tanggalRekap' and _logabsensi.id_mengajar='$_GET[pelajaran]' AND tb_mengajar.id_mkelas='$_GET[kelas]'  AND tb_thajaran.status=1 AND tb_semester.status=1 "));
				echo $sakit['sakit'];
				?>
			</td>
			<td align="center" style="font-weight: bold;">
				<?php 
				$izin = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(ket) AS izin FROM _logabsensi
					INNER JOIN tb_mengajar ON _logabsensi.id_mengajar=tb_mengajar.id_mengajar
					INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
					INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
					WHERE _logabsensi.id_siswa='$ds[id_siswa]' and _logabsensi.ket='I' and DATE(tgl_absen)='$tanggalRekap' and _logabsensi.id_mengajar='$_GET[pelajaran]' AND tb_mengajar.id_mkelas='$_GET[kelas]'  AND tb_thajaran.status=1 AND tb_semester.status=1 "));
				echo $izin['izin'];
				?>
			</td align="center" style="font-weight: bold;">
				<?php 
				$alfa = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(ket) AS alfa FROM _logabsensi
					INNER JOIN tb_mengajar ON _logabsensi.id_mengajar=tb_mengajar.id_mengajar
					INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
					INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
					WHERE _logabsensi.id_siswa='$ds[id_siswa]' and _logabsensi.ket='A' and DATE(tgl_absen)='$tanggalRekap' and _logabsensi.id_mengajar='$_GET[pelajaran]' AND tb_mengajar.id_mkelas='$_GET[kelas]'  AND tb_thajaran.status=1 AND tb_semester.status=1 "));
				echo $alfa['alfa'];
				?>
			</td>
			</td>
		</tr>
		<?php 
	}
	?>
</table>

<p></p>
<table width="100%">
	<tr>
		<td align="right">
			<p>
				Garut, <?= date('d F Y'); ?>
			</p>
			<p>
				Kepala Sekolah
				<br>
				<br>
				<br>
				<br>
				<br>
				Deni Roswandi, SE. <br>
				----------------------<br>
				NIP.6252751653200013
			</p>
		</td>
	</tr>
</table>

<script>
	window.print();
</script>
