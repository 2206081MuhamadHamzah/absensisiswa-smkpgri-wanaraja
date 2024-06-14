<?php
// Sertakan file konfigurasi database jika belum dilakukan
require '../../../config/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idSiswa']) && isset($_POST['idMengajar'])) {
    $idSiswa = $_POST['idSiswa'];
    $idMengajar = $_POST['idMengajar'];

    $query = "SELECT tgl_absen, ket FROM _logabsensi WHERE id_siswa = '$idSiswa' AND id_mengajar = '$idMengajar'";


    $result = mysqli_query($con, $query);

    if ($result) {
        // Membuat tampilan tabel untuk menampilkan detail absen
        $output = '<table>';
        $output .= '<tr><th>Tanggal Absen</th>
        <th>Keterangan</th>
        </tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['ket'] !== 'H') {
                $output .= '<tr>';
                $output .= '<td>' . $row['tgl_absen'] . '</td>';
                
                if ($row['ket'] === 'S' || $row['ket'] === 'I' || $row['ket'] === 'A') {
                    $output .= '<td>' . $row['ket'] . '</td>';
                } else {
                    // Tambahkan kondisi untuk nilai lain jika diperlukan
                    // Misalnya, jika tidak ingin menampilkan nilai selain 'S', 'I', atau 'A':
                    $output .= '<td></td>'; // Kolom akan tetap ada tapi kosong
                }
        
                $output .= '</tr>';
            }
        }
        
        $output .= '</table>';

        echo $output;
    } else {
        echo 'Gagal mengambil data kehadiran siswa.';
    }

    // Tutup koneksi database
    mysqli_close($con);
} else {
    echo 'Permintaan tidak valid.';
}
