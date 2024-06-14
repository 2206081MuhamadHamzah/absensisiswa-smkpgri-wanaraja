<?php
if (isset($_POST['idSiswa'])) {
    $idSiswa = $_POST['idSiswa'];

    // Query untuk mengambil data kehadiran siswa berdasarkan ID siswa
    $query = "SELECT tgl_absen, ket FROM _logabsensi WHERE id_siswa = $idSiswa";
    $result = mysqli_query($con, $query);

    $attendanceData = array(
        'H' => array(),
        'S' => array(),
        'I' => array(),
        'A' => array(),
    );

    while ($row = mysqli_fetch_assoc($result)) {
        $attendanceData[$row['ket']][] = $row['tgl_absen'];
    }

    // Menampilkan data kehadiran dalam format HTML
    echo '<h4>Detail Kehadiran Siswa</h4>';
    echo '<p>Nama Siswa: ' . $namaSiswa . '</p>';
    echo '<table>';
    echo '<tr><th>Ket</th><th>Tanggal</th></tr>';
    foreach ($attendanceData as $ket => $dates) {
        echo '<tr>';
        echo '<td>' . $ket . '</td>';
        echo '<td>' . implode(', ', $dates) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>
