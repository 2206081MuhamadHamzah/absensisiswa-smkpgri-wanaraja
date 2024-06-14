<?php 
// tampilkan data mengajar
$kelasMengajar = mysqli_query($con,"SELECT * FROM tb_mengajar 

INNER JOIN tb_master_mapel ON tb_mengajar.id_mapel=tb_master_mapel.id_mapel
INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas=tb_mkelas.id_mkelas

INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
WHERE tb_mengajar.id_guru='$data[id_guru]' AND tb_mengajar.id_mengajar='$_GET[pelajaran]'  AND tb_thajaran.status=1  ");

foreach ($kelasMengajar as $d) 



	?>



<!-- 
<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						
					</div>
				</div> -->
<div class="page-inner">

	<div class="page-header">
<!-- <h4 class="page-title">KELAS (<?=strtoupper($d['nama_kelas']) ?> )</h4> -->
<ul class="breadcrumbs" style="font-weight: bold;">
<li class="nav-home">
<a href="#">
<i class="flaticon-home"></i>
</a>
</li>
<li class="separator">
<i class="flaticon-right-arrow"></i>
</li>
<li class="nav-item">
<a href="#">KELAS (<?=strtoupper($d['nama_kelas']) ?> )</a>
</li>
<li class="separator">
<i class="flaticon-right-arrow"></i>
</li>
<li class="nav-item">
<a href="#"><?=strtoupper($d['mapel']) ?></a>
</li>
</ul>

</div>

					
					<div class="row">
						
						
						<?php 
                        $today = $_POST['tgl'];

								// dapatkan pertemuan terakhir di tb izin
								$last_pertemuan = mysqli_query($con,"SELECT * FROM _logabsensi WHERE id_mengajar='$_GET[pelajaran]' GROUP BY pertemuan_ke ORDER BY pertemuan_ke DESC LIMIT 1  ");
								$cekPertemuan = mysqli_num_rows($last_pertemuan);
								$jml = mysqli_fetch_array($last_pertemuan);

								if ($cekPertemuan > 0 ) {
								$pertemuan = (int)$jml['pertemuan_ke']+1;
								}else{
								 $pertemuan = 1;
									
								}


								?>

							  <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    <p>
                        <span class="badge badge-default" style="padding: 7px;font-size: 14px;"><b>Daftar Siswa</b></span>
                        <span class="badge badge-primary" style="padding: 7px;font-size: 14px;">
                            Pertemuan Ke : <b><?=$pertemuan; ?></b>
                        </span>
                    </p>
                    <input type="date" name="tgl" class="form-control" value="<?=date('Y-m-d') ?>" style="background-color: #3498db;color: #FFEB3B;">
                    <input type="hidden" name="pertemuan" class="form-control" value="<?=$pertemuan; ?>">
                    <div class="card-list">
					<?php 
$siswa = mysqli_query($con, "SELECT * FROM tb_siswa WHERE id_mkelas='$d[id_mkelas]' ORDER BY id_siswa ASC ");
$jumlahSiswa = mysqli_num_rows($siswa);
?>
<style>
   body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .table-container {
        max-height: 400px; /* Atur tinggi maksimal sesuai preferensi Anda */
        overflow: auto;
    }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        

</style>
<div class="item-list">
    <div class="info-user">
        <input type="hidden" name="pelajaran" value="<?= $_GET['pelajaran'] ?>">
    </div>
    <div class="status mt-0" Style="max-height: 400px; overflow: auto;">
        <!-- Tabel disini -->
		
        <table id="basic-datatables" class="table table-bordered" style="max-height: 400px; overflow: auto;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Angkatan</th>
                    <th>Foto</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
				$tgl_hari_ini = date('Y-m-d');
				foreach ($siswa as $i => $s) {
					$siswa_telah_absen_hari_ini = mysqli_query($con, "SELECT * FROM _logabsensi WHERE id_siswa='$s[id_siswa]' AND tgl_absen='$tgl_hari_ini' AND id_mengajar='$_GET[pelajaran]' AND ket=''");
				?>
				<tr>
					<td><?= $i + 1; ?></td>
					<td><?= $s['nis']; ?></td>
					<td><?= $s['nama_siswa']; ?></td>
					<td><?= strtoupper($d['nama_kelas']); ?></td>
					<td><?= $s['th_angkatan']; ?></td>
					<td>
						<img src="../assets/img/user/<?= $s['foto']; ?>" class="avatar-img rounded-circle" alt="Foto Siswa">
					</td>
					<td>
						<div class="form-group">
							<input type="hidden" name="id_siswa-<?= $i; ?>" value="<?= $s['id_siswa'] ?>">
							<select name="ket-<?= $i; ?>" class="form-control">
								<option value="H">Hadir</option>
								<option value="I">Izin</option>
								<option value="S">Sakit</option>
								<option value="A">Absen</option>
							</select>
						</div>
					</td>
				</tr>
				<?php } ?>
            </tbody>
        </table>
    </div>
</div>										
							</div>
									<!-- <input type="submit" name="absen" class="btn btn-info"> -->
									<center>
										<button type="submit" name="absen" class="btn btn-success">
										<i class="fa fa-check"></i> Selesai
									</button>

									<a href="?page=absen&act=update&pelajaran=<?=$_GET['pelajaran']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Update Absesnsi</a>

								
									<a href="index.php" class="btn btn-default"><i class="fas fa-arrow-circle-left"></i> Kembali</a> 
									</center>
								</div>
								</form>

								
								<?php 
									if (isset($_POST['absen'])) {
										
										$total = $jumlahSiswa-1;
										$today = $_POST['tgl'];
										$pertemuan = $_POST['pertemuan'];

										for ($i =0; $i <=$total ; $i++) {

											$id_siswa = $_POST['id_siswa-'.$i];
											$pelajaran = $_POST['pelajaran'];
											$ket = $_POST['ket-'.$i];


											$cekAbsesnHariIni = mysqli_num_rows(mysqli_query($con,"SELECT * FROM _logabsensi WHERE tgl_absen='$today' AND id_mengajar='$pelajaran' AND id_siswa='$id_siswa' "));

											if ($cekAbsesnHariIni > 0) {


													echo "
													<script type='text/javascript'>
													setTimeout(function () { 

													swal('Sorry!', 'Absen Hari ini sudah dilakukan', {
													icon : 'error',
													buttons: {        			
													confirm: {
													className : 'btn btn-danger'
													}
													},
													});    
													},10);  
													window.setTimeout(function(){ 
													window.location.replace('?page=absen&pelajaran=$_GET[pelajaran]');
													} ,3000);   
													</script>";
							
											}else{

												$insert = mysqli_query($con,"INSERT INTO _logabsensi VALUES (NULL,'$pelajaran','$id_siswa','$today','$ket','$pertemuan')");

										if ($insert) {


											echo "
											<script type='text/javascript'>
											setTimeout(function () { 

											swal('Berhasil', 'Absen hari ini telah tersimpan!', {
											icon : 'success',
											buttons: {        			
											confirm: {
											className : 'btn btn-success'
											}
											},
											});    
											},10);  
											window.setTimeout(function(){ 
											window.location.replace('?page=absen&pelajaran=$_GET[pelajaran]');
											} ,3000);   
											</script>";


											}


										



										}



											
										}


									}

								 ?>
								 
							</div>
						</div>



						
					</div>
					
				</div>

					
					