<?php
include '../../../config/db.php';

if (isset($_POST['selectedDate'])) {
    $selectedDate = $_POST['selectedDate'];

    $query = "SELECT tb_siswa.*, _logabsensi.*
        FROM _logabsensi
        INNER JOIN tb_siswa ON _logabsensi.id_siswa=tb_siswa.id_siswa
        INNER JOIN tb_mengajar ON _logabsensi.id_mengajar=tb_mengajar.id_mengajar
        INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas=tb_mkelas.id_mkelas
        INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
        INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
        WHERE tb_mengajar.id_mengajar='" . $_GET['pelajaran'] . "' AND tb_mengajar.id_mkelas='" . $_GET['kelas'] . "' AND tb_thajaran.status=1 AND tb_semester.status=1
            AND _logabsensi.tgl_absen = '" . $selectedDate . "'
        GROUP BY _logabsensi.id_siswa
        ORDER BY _logabsensi.id_siswa ASC";

    $result = mysqli_query($con, $query);
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);
}
?>
