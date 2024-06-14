<?php
// Include file konfigurasi database jika belum termasuk
include '../../../config/db.php';

// Periksa jika parameter yang diperlukan ada dalam permintaan
if (isset($_GET['pelajaran']) && isset($_GET['kelas'])) {
    $pelajaranId = $_GET['pelajaran'];
    $kelasId = $_GET['kelas'];

    // Buat kueri ke database untuk mengambil data sesuai parameter
    $query = "SELECT tb_siswa.*, _logabsensi.tgl_absen 
              FROM _logabsensi
              INNER JOIN tb_siswa ON _logabsensi.id_siswa = tb_siswa.id_siswa
              WHERE _logabsensi.id_mengajar = '$pelajaranId' AND _logabsensi.id_mkelas = '$kelasId'";

    // Eksekusi kueri
    $result = mysqli_query($con, $query);

    // Siapkan array untuk data yang akan dikembalikan
    $data = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Sesuaikan dengan struktur data yang diperlukan
            $data[] = [
                'id_siswa' => $row['id_siswa'],
                'tgl_absen' => $row['tgl_absen'],
                'nama_siswa' => $row['nama_siswa'],
                'nis' => $row['nis'],
                'jk' => $row['jk']
            ];
        }
    }

    // Kembalikan data dalam format JSON
    echo json_encode($data);
} else {
    // Jika parameter tidak lengkap, berikan respons error
    echo json_encode(['error' => 'Parameter tidak lengkap']);
}
?>
