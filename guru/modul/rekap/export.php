<?php
include '../../../config/db.php'; // Sesuaikan dengan lokasi file konfigurasi database Anda
require 'vendor/autoload.php'; // Sesuaikan dengan lokasi autoload.php

// Ambil parameter dari URL
$pelajaran = isset($_GET['pelajaran']) ? $_GET['pelajaran'] : '';
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$selectedDate = isset($_GET['selectedDate']) ? $_GET['selectedDate'] : '';

// Query data yang ingin Anda ekspor ke Excel
$query = "SELECT tb_siswa.nis, tb_siswa.nama_siswa, tb_siswa.jk,
                 (SELECT COUNT(ket) FROM _logabsensi WHERE id_siswa = tb_siswa.id_siswa AND ket = 'H') AS H,
                 (SELECT COUNT(ket) FROM _logabsensi WHERE id_siswa = tb_siswa.id_siswa AND ket = 'S') AS S,
                 (SELECT COUNT(ket) FROM _logabsensi WHERE id_siswa = tb_siswa.id_siswa AND ket = 'I') AS I,
                 (SELECT COUNT(ket) FROM _logabsensi WHERE id_siswa = tb_siswa.id_siswa AND ket = 'A') AS A,
                 _logabsensi.tgl_absen
           FROM _logabsensi
           INNER JOIN tb_siswa ON _logabsensi.id_siswa=tb_siswa.id_siswa
           INNER JOIN tb_mengajar ON _logabsensi.id_mengajar=tb_mengajar.id_mengajar
           INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas=tb_mkelas.id_mkelas
           INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
           INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
           WHERE tb_mengajar.id_mengajar='$pelajaran' AND tb_mengajar.id_mkelas='$kelas'
           AND tb_thajaran.status=1 AND tb_semester.status=1";

if (!empty($selectedDate)) {
    $query .= " AND _logabsensi.tgl_absen = '$selectedDate'";
}

$query .= " GROUP BY _logabsensi.id_siswa
           ORDER BY _logabsensi.id_siswa ASC";

$result = mysqli_query($con, $query);

// Inisialisasi Spreadsheet
$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
$worksheet = $spreadsheet->getActiveSheet();

// Header kolom Excel
$worksheet->setCellValue('A1', 'NO');
$worksheet->setCellValue('B1', 'NIS/NISN');
$worksheet->setCellValue('C1', 'NAMA SISWA');
$worksheet->setCellValue('D1', 'JENIS KELAMIN');
$worksheet->setCellValue('E1', 'H');
$worksheet->setCellValue('F1', 'S');
$worksheet->setCellValue('G1', 'I');
$worksheet->setCellValue('H1', 'A');
$worksheet->setCellValue('I1', 'TANGGAL ABSEN');

// Isi data ke dalam Excel
$no = 1;
$row = 2;
while ($data = mysqli_fetch_assoc($result)) {
    $worksheet->setCellValue('A' . $row, $no++);
    $worksheet->setCellValue('B' . $row, $data['nis']);
    $worksheet->setCellValue('C' . $row, $data['nama_siswa']);
    $worksheet->setCellValue('D' . $row, $data['jk']);
    $worksheet->setCellValue('E' . $row, $data['H']);
    $worksheet->setCellValue('F' . $row, $data['S']);
    $worksheet->setCellValue('G' . $row, $data['I']);
    $worksheet->setCellValue('H' . $row, $data['A']);
    $worksheet->setCellValue('I' . $row, $data['tgl_absen']);
    $row++;
}

$customFilename = isset($_GET['customFilename']) ? $_GET['customFilename'] : 'laporan_kehadiran.xlsx';
$filename = rawurlencode($customFilename);



// Set header untuk file Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Simpan ke output
$writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit;
