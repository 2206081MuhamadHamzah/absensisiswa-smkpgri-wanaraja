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

// Ambil data bulan yang dipilih oleh siswa
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Default ke bulan saat ini jika tidak ada yang dipilih

$querySiswa = mysqli_query($con, "SELECT * FROM tb_siswa WHERE nis = $idSiswa");

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
    <title>Detail Absensi Siswa</title>
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
    Detail Absensi Siswa: <?= $namaSiswa ?>
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
                <!-- Tambahkan kode untuk menampilkan detail absensi siswa berdasarkan bulan -->
                <!-- ...
                ... -->
            </div>
        </div>
    </div>
</body>
</html>
