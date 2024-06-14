<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$con = mysqli_connect("localhost", "root", "", "db_imas");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$tanggal_terpilih = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';

if (!empty($tanggal_terpilih)) {
    $query = "SELECT tb_siswa.nis, tb_siswa.nama_siswa, tb_siswa.jk, GROUP_CONCAT(DISTINCT _logabsensi.ket) AS keterangan, _logabsensi.tgl_absen
           FROM tb_siswa
           LEFT JOIN _logabsensi ON tb_siswa.id_siswa = _logabsensi.id_siswa
           WHERE _logabsensi.tgl_absen = '$tanggal_terpilih' 
           AND _logabsensi.pertemuan_ke = (SELECT MIN(pertemuan_ke) FROM _logabsensi WHERE id_siswa = tb_siswa.id_siswa AND tgl_absen = '$tanggal_terpilih')
           GROUP BY tb_siswa.nis, _logabsensi.tgl_absen";

    $result = mysqli_query($con, $query);

    $spreadsheet = new Spreadsheet();
    $worksheet = $spreadsheet->getActiveSheet();

    $worksheet->setCellValue('A1', 'NO');
    $worksheet->setCellValue('B1', 'NIS/NISN');
    $worksheet->setCellValue('C1', 'NAMA SISWA');
    $worksheet->setCellValue('D1', 'JENIS KELAMIN');
    $worksheet->setCellValue('E1', 'Keterangan');
    $worksheet->setCellValue('F1', 'TANGGAL ABSEN');

    $no = 1;
    $row = 2;
    while ($data = mysqli_fetch_assoc($result)) {
        $worksheet->setCellValue('A' . $row, $no++);
        $worksheet->setCellValue('B' . $row, $data['nis']);
        $worksheet->setCellValue('C' . $row, $data['nama_siswa']);
        $worksheet->setCellValue('D' . $row, $data['jk']);
        $worksheet->setCellValue('E' . $row, $data['keterangan']);
        $worksheet->setCellValue('F' . $row, $data['tgl_absen']);
        $row++;
    }

    $filename = 'Rekapan_Absensi_' . $tanggal_terpilih . '.xlsx';
    $filename = rawurlencode($filename);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo "Silakan pilih tanggal untuk melihat rekapan.";
}

mysqli_close($con);
?>
