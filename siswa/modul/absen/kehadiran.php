<?php
session_start();

$con = new mysqli("localhost", "root", "", "db_imas");
if ($con->connect_error) {
    die("Koneksi gagal: " . $con->connect_error);
}

if (isset($_GET['id'])) {
    $idSiswa = $_GET['id'];
} else {
    echo "ID siswa tidak tersedia.";
    exit;
}

$querySiswa = mysqli_query($con, "SELECT * FROM tb_siswa WHERE id_siswa = $idSiswa");

if (!$querySiswa) {
    echo "Gagal menjalankan query: " . mysqli_error($con);
    exit;
}

if (mysqli_num_rows($querySiswa) === 0) {
    echo "Data siswa tidak ditemukan.";
    exit;
}

$dataSiswa = mysqli_fetch_assoc($querySiswa);
$namaSiswa = $dataSiswa['nama_siswa'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Kehadiran Siswa | Aplikasi Absensi</title>
	<link rel="icon" href="../../../logo-removebg-preview.png" type="image/png">
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="../assets/img/icon.ico" type="image/x-icon"/>

    <title>Kehadiran Siswa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            margin: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" style="color: #007bff; font-size: 24px; font-weight: bold; text-align: center;">
                    Kehadiran Siswa: <?= $namaSiswa ?>
                </h4>
                <!-- Tidak ada pemilihan bulan -->
                <hr>
                <!-- Sisipkan data rekapan kehadiran siswa -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Rekapan Kehadiran <?= $namaSiswa ?></h5>
                                <!-- Tampilkan data rekapan kehadiran di sini -->
                                <table class="table">
                                    <tr>
                                        <td>Total Hadir</td>
                                        <td>
                                            <?php
                                            $totalHadir = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(ket) AS total_hadir FROM _logabsensi WHERE id_siswa='$idSiswa' AND ket='H'"));
                                            echo $totalHadir['total_hadir'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Sakit</td>
                                        <td>
                                            <?php
                                            $totalSakit = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(ket) AS total_sakit FROM _logabsensi WHERE id_siswa='$idSiswa' AND ket='S'"));
                                            echo $totalSakit['total_sakit'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Izin</td>
                                        <td>
                                            <?php
                                            $totalIzin = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(ket) AS total_izin FROM _logabsensi WHERE id_siswa='$idSiswa' AND ket='I'"));
                                            echo $totalIzin['total_izin'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Absen</td>
                                        <td>
                                            <?php
                                            $totalAbsen = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(ket) AS total_absen FROM _logabsensi WHERE id_siswa='$idSiswa' AND ket='A'"));
                                            echo $totalAbsen['total_absen'];
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
