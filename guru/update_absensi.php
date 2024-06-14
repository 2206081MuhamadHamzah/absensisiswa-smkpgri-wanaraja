<?php
// Pastikan sesi dimulai
session_start();

// Membuat koneksi ke database
$con = new mysqli("localhost", "root", "", "db_imas");
if ($con->connect_error) {
    die("Koneksi gagal: " . $con->connect_error);
}

// Memeriksa apakah ada sesi guru
if (isset($_SESSION['guru'])) {
    $id_guru = $_SESSION['guru'];
} else {
    echo "Sesi 'id_guru' tidak tersedia.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan data dari formulir
    $pelajaran = $_POST['pelajaran'];
    $id_siswa = $_POST['id_siswa'];
    $update_status = $_POST['update_status'];

    // Query untuk mengatur ulang data absensi siswa
    $query = "UPDATE _logabsensi SET ket = ? WHERE id_mengajar = ? AND id_siswa = ? AND tgl_absen = CURDATE()";

    $stmt = $con->prepare($query);
    if (!$stmt) {
        echo "Error: " . $con->error;
    }
    
    $stmt->bind_param("sss", $update_status, $pelajaran, $id_siswa);

    if ($stmt->execute()) {
        // Redirect kembali ke halaman absensi_kelas.php
        header("Location: absen_kelas.php?pelajaran=$pelajaran");
        exit;
    } else {
        echo "Gagal mengupdate data absensi: " . $stmt->error;
        exit;
    }
} else {
    echo "Akses tidak sah.";
    exit;
}
