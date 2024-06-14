<?php
// Tampilkan data mengajar
$kelasMengajar = mysqli_query($con, "SELECT * FROM tb_mengajar 
    INNER JOIN tb_master_mapel ON tb_mengajar.id_mapel = tb_master_mapel.id_mapel
    INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas = tb_mkelas.id_mkelas
    INNER JOIN tb_semester ON tb_mengajar.id_semester = tb_semester.id_semester
    INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran = tb_thajaran.id_thajaran
    WHERE tb_mengajar.id_guru = '$data[id_guru]' AND tb_mengajar.id_mengajar = '$_GET[pelajaran]'  AND tb_thajaran.status = 1");

foreach ($kelasMengajar as $d)
?>

<!-- Your HTML code here -->

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Rekap Absen</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">KELAS (<?= strtoupper($d['nama_kelas']) ?> )</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#"><?= strtoupper($d['mapel']) ?></a>
            </li>
        </ul>
    </div>

   
    
        <?php
    $qry = mysqli_query($con, "SELECT * FROM _logabsensi
        INNER JOIN tb_mengajar ON _logabsensi.id_mengajar = tb_mengajar.id_mengajar
        INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran = tb_thajaran.id_thajaran
        INNER JOIN tb_semester ON tb_mengajar.id_semester = tb_semester.id_semester
        WHERE _logabsensi.id_mengajar = '$_GET[pelajaran]' and tb_thajaran.status = 1 and tb_semester.status = 1
        GROUP BY MONTH(tgl_absen) ORDER BY MONTH(tgl_absen) DESC
    ");

    while ($bulan = mysqli_fetch_array($qry)) {
        $bulanNumber = date('m', strtotime($bulan['tgl_absen']));
        $bulanName = namaBulan($bulanNumber);
    ?>

    <?php } ?>
    </div>
    <div class="col-md-12 col-xs-12 mt-3">
    <a href="modul/rekap/rekap_persemester.php?pelajaran=<?= $_GET['pelajaran'] ?>&kelas=<?= $d['id_mkelas'] ?>&index=<?= $d['index'] ?>"
        style="text-decoration: none;" class="text-success">
        <div class="alert alert-success alert-dismissible" role="alert">
            <strong>REKAP ABSENSI (<?= strtoupper($d['nama_kelas']) ?> - <b><?= strtoupper($d['tahun_ajaran']) ?></b>)</strong>
        </div>
    </a>
</div>

            </a>
        </div>
    </div>
</div>

</div>

						
					</div>
					<center>
					<a href="javascript:history.back()" class="btn btn-default"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
				</center>
					
				</div>
				