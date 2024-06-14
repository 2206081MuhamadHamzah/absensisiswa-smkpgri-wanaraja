<?php
session_start();

$con = new mysqli("localhost", "root", "", "db_imas");
if ($con->connect_error) {
    die("Koneksi gagal: " . $con->connect_error);
}


// Deklarasi fungsi hanya jika belum ada
if (!function_exists('namaBulan')) {
    function namaBulan($angkaBulan) {
        $namaBulan = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );
        return $namaBulan[$angkaBulan];
    }
}


if (isset($_GET['id'])) {
    $idSiswa = $_GET['id'];
} else {
    echo "ID siswa tidak tersedia.";
    exit;
}

// Ambil data bulan yang dipilih oleh siswa
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
 // Default ke bulan saat ini jika tidak ada yang dipilih

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

                <form class="form-inline" method="GET">
                    <label for="bulan">Pilih Bulan:</label>
                    <select class="form-control" id="bulan" name="bulan">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            $selected = ($i == $bulan) ? "selected" : "";
                            echo "<option value='$i' $selected>" . namaBulan($i) . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                </form>
                <hr>
                <!-- Sisipkan data kehadiran berdasarkan bulan yang dipilih -->
                <div class="row">
                    <?php
                    $qry = mysqli_query($con, "SELECT * FROM _logabsensi
                        INNER JOIN tb_mengajar ON _logabsensi.id_mengajar = tb_mengajar.id_mengajar
                        INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran = tb_thajaran.id_thajaran
                        INNER JOIN tb_semester ON tb_mengajar.id_semester = tb_semester.id_semester
                        WHERE _logabsensi.id_siswa = '$idSiswa' AND tb_thajaran.status = 1 AND tb_semester.status = 1 AND MONTH(tgl_absen) = $bulan
                        GROUP BY MONTH(tgl_absen) ORDER BY MONTH(tgl_absen) DESC");

                    if (!$qry) {
                        echo "Gagal menjalankan query: " . mysqli_error($con);
                        exit;
                    }

                    if (mysqli_num_rows($qry) === 0) {
                        echo "Data absensi tidak ditemukan.";
                        exit;
                    }

                    foreach ($qry as $bulanData) {
                        $bulan = date('m', strtotime($bulanData['tgl_absen']));
                    ?>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-primary">BULAN <?= namaBulan($bulan) ?> <?= date('Y') ?></h5>
                                <!-- Tampilkan data kehadiran di sini -->
                                <table class="table">
                                    <tr>
                                        <td>Hadir</td>
                                        <td>
                                            <?php
                                            $hadir = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(ket) AS hadir FROM _logabsensi WHERE id_siswa='$idSiswa' and ket='H' and MONTH(tgl_absen)='$bulan'"));
                                            echo $hadir['hadir'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sakit</td>
                                        <td>
                                            <?php
                                            $sakit = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(ket) AS sakit FROM _logabsensi WHERE id_siswa='$idSiswa' and ket='S' and MONTH(tgl_absen)='$bulan'"));
                                            echo $sakit['sakit'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Izin</td>
                                        <td>
                                            <?php
                                            $izin = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(ket) AS izin FROM _logabsensi WHERE id_siswa='$idSiswa' and ket='I' and MONTH(tgl_absen)='$bulan'"));
                                            echo $izin['izin'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Absen</td>
                                        <td>
                                            <?php
                                            $alfa = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(ket) AS alfa FROM _logabsensi WHERE id_siswa='$idSiswa' and ket='A' and MONTH(tgl_absen)='$bulan'"));
                                            echo $alfa['alfa'];
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
