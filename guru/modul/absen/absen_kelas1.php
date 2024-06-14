<?php
// Ambil data pelajaran dari URL
$idMengajar = isset($_GET['pelajaran']) ? $_GET['pelajaran'] : null;

// Pastikan ID pelajaran telah diatur dan valid
if ($idMengajar === null) {
    echo "ID pelajaran tidak tersedia.";
    exit;
}

// Tampilkan data mengajar
$kelasMengajar = mysqli_query($con, "SELECT * FROM tb_mengajar
    INNER JOIN tb_master_mapel ON tb_mengajar.id_mapel = tb_master_mapel.id_mapel
    INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas = tb_mkelas.id_mkelas
    INNER JOIN tb_semester ON tb_mengajar.id_semester = tb_semester.id_semester
    INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran = tb_thajaran.id_thajaran
    WHERE tb_mengajar.id_guru = '$data[id_guru]' AND tb_mengajar.id_mengajar = '$idMengajar' AND tb_thajaran.status = 1");

foreach ($kelasMengajar as $d) {
    // ...
}
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

<div class="page-inner">
    <div class="page-header">
        <!-- ... -->
    </div>

    <div class="row">
        <?php
        // Dapatkan pertemuan terakhir di tb izin
        $last_pertemuan = mysqli_query($con, "SELECT * FROM _logabsensi WHERE id_mengajar = '$idMengajar' GROUP BY pertemuan_ke ORDER BY pertemuan_ke DESC LIMIT 1");
        $cekPertemuan = mysqli_num_rows($last_pertemuan);
        $jml = mysqli_fetch_array($last_pertemuan);

        if ($cekPertemuan > 0) {
            $pertemuan = (int)$jml['pertemuan_ke'] + 1;

        } else {
            $pertemuan = 1;
        }
        ?>
            </div>
            <input type="hidden" name="pertemuan" value="<?= $pertemuan ?>">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post">
                        <!-- ... -->
                    </form>
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <!-- ... -->
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NIS/NISN</th>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th>
                                            <th>Tahun Masuk</th>
                                            <th>Status</th>
                                            <th>Foto</th>
                                            <th>Absensi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Tampilkan data siswa berdasarkan kelas yang dipilih
                                        $siswa = mysqli_query($con, "SELECT * FROM tb_siswa WHERE id_mkelas = '$d[id_mkelas]' ORDER BY id_siswa ASC ");
                                        $jumlahSiswa = mysqli_num_rows($siswa);

                                        $no = 1; // Untuk nomor urut
                                        foreach ($siswa as $s) {
                                            ?>
                                            <tr>
                                                <td><?= $no++; ?>.</td>
                                                <td><?= $s['nis']; ?></td>
                                                <td><b class="text-success"><?= $s['nama_siswa']; ?></b></td>
                                                <td><?= $d['nama_kelas']; ?></td>
                                                <td><?= $s['th_angkatan']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($s['status'] == 1) {
                                                        echo "<span class='badge badge-success'>Aktif</span>";
                                                    } else {
                                                        echo "<span class='badge badge-danger'>Off</span>";
                                                    }
                                                    ?>
                                                </td>
                                                <td><img src="../assets/img/user/<?= $s['foto'] ?>" width="45" height="45"></td>
                                                <td>
                                                    <input type="checkbox" name="id_siswa-<?= $s['id_siswa']; ?>" value="<?= $s['id_siswa']; ?>">
                                                    <select name="ket-<?= $s['id_siswa']; ?>">
                                                        <option value="H">Hadir</option>
                                                        <option value="I">Izin</option>
                                                        <option value="S">Sakit</option>
                                                        <option value="A">Absen</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <center>
                                    <button type="submit" name="absen" class="btn btn-success">
                                        <i class="fa fa-check"></i> Simpan Absensi
                                    </button>
                                    <a href="?page=absen&act=update&pelajaran=<?= $idMengajar; ?>" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Update Absensi
                                    </a>
                                </center>
                            </form>
                            <?php
                 if (isset($_POST['absen'])) {
                    $total = $jumlahSiswa;
                    $today = date('Y-m-d');
                    $pertemuan = $_POST['pertemuan'];
                    
                    for ($i = 1; $i <= $total; $i++) {
                        $id_siswa = $_POST['id_siswa-' . $i];
                        $ket = $_POST['ket-' . $id_siswa];
                        
                        $insert = mysqli_query($con, "INSERT INTO _logabsensi (id_mengajar, id_siswa, tgl_absen, ket, pertemuan_ke) VALUES ('$idMengajar', '$id_siswa', '$today', '$ket', '$pertemuan')");
                        
                        if (!$insert) {
                            // Handle error
                            echo "Gagal menyimpan absensi untuk siswa dengan ID: $id_siswa";
                        }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
