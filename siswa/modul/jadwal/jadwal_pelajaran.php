<?php
// Membuat koneksi ke database
$con = new mysqli("localhost", "root", "", "db_imas") or die(mysqli_error($con));

// Periksa koneksi
if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Di sini, Anda harus menggantikan 'nama_kolom_id_mkelas' dengan nama kolom yang sesuai di tabel mkelas.
// Anda perlu menentukan cara Anda akan mengidentifikasi kelas yang sesuai, misalnya dengan menggunakan sesi atau parameter URL.
// Berikut contoh jika Anda mengambil ID kelas dari parameter URL.
if (isset($_GET['id_mkelas'])) {
    $id_mkelas = $_GET['id_mkelas'];
} else {
    // Default jika tidak ada ID kelas yang diberikan.
    $id_mkelas = 1; // Gantilah dengan ID kelas yang sesuai jika dibutuhkan.
}

// Tampilkan data jadwal pelajaran siswa
$query = "SELECT * FROM tb_mengajar
          INNER JOIN tb_master_mapel ON tb_mengajar.id_mapel = tb_master_mapel.id_mapel
          INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas = tb_mkelas.id_mkelas
          INNER JOIN tb_semester ON tb_mengajar.id_semester = tb_semester.id_semester
          INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran = tb_thajaran.id_thajaran
          WHERE tb_mkelas.id_mkelas = '$id_mkelas' AND tb_thajaran.status = 1";

$result = mysqli_query($con, $query);

if (!$result) {
    throw new Exception("Kueri SQL gagal: " . mysqli_error($con));
}

if (mysqli_num_rows($result) == 0) {
    throw new Exception("Data jadwal pelajaran tidak ditemukan.");
}
?>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Jadwal Pelajaran Siswa</h4>
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
                <a href="#">Jadwal Pelajaran</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
        </ul>
    </div>
    <div class="row mt-4">
        <?php
        while ($jd = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col-md-5 col-xs-12">
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                    <strong><h3><?= $jd['mapel']; ?></h3></strong>
                    <hr>
                    <ul>
                        <li>
                            Hari: <?= $jd['hari']; ?>
                        </li>
                        <li>
                            Jam Ke: <?= $jd['jamke']; ?>
                        </li>
                        <li>
                            Waktu: <?= $jd['jam_mengajar']; ?>
                        </li>
                        <li>
                            Guru: <?= $jd['nama_guru']; ?>
                        </li>
                        <li>
                            Kelas: <?= $jd['nama_kelas']; ?>
                        </li>
                    </ul>
                    <hr>
                    <a href="?page=absen&pelajaran=<?= $jd['id_mengajar'] ?> " class="btn btn-default btn-block text-left">
                        <i class="fas fa-clipboard-check"></i>
                        Isi Absen
                    </a>
                    <a href="?page=rekap&pelajaran=<?= $jd['id_mengajar'] ?> " class="btn btn-secondary btn-block text-left">
                        <i class="fas fa-list-alt"></i>
                        Rekap Absen
                    </a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <a href="javascript:history.back()" class="btn btn-default"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
</div>
