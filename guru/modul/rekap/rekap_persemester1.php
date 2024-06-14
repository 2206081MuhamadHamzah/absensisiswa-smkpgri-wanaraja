<?php
require 'vendor/autoload.php';
include '../../../config/db.php';

// Menginisialisasi variabel
$index = @$_GET['index'];
$pelajaran = isset($_GET['pelajaran']) ? $_GET['pelajaran'] : '';
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$selectedDate = isset($_GET['selectedDate']) ? $_GET['selectedDate'] : '';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

// Memeriksa jika data absen dikirim melalui POST
if (isset($_POST['absen'])) {
    $tgl_hari_ini = $_POST['tgl'];
    $pertemuan = $_POST['pertemuan'];

    for ($i = 0; $i <= $total; $i++) {
        $id_siswa = $_POST['id_siswa-' . $i];
        $ket = $_POST['ket-' . $i];

        // Cek apakah data absensi untuk siswa dan tanggal yang sama sudah ada
        $cekAbsenHariIni = mysqli_query($con, "SELECT * FROM _logabsensi WHERE tgl_absen='$tgl_hari_ini' AND id_mengajar='$pelajaran' AND id_siswa='$id_siswa'");

        if (mysqli_num_rows($cekAbsenHariIni) == 0) {
            $insert = mysqli_query($con, "INSERT INTO _logabsensi (id_mengajar, id_siswa, tgl_absen, ket, pertemuan) VALUES ('$pelajaran', '$id_siswa', '$tgl_hari_ini', '$ket', '$pertemuan')");
        }
    }
}

// Fungsi untuk mengambil jumlah kehadiran berdasarkan kode ket
function getAttendanceCount($con, $idSiswa, $pelajaran, $kelas, $ket, $selectedDate) {
    // Query untuk mengambil jumlah kehadiran
    $query = "SELECT COUNT(ket) AS jumlah FROM _logabsensi
              INNER JOIN tb_mengajar ON _logabsensi.id_mengajar = tb_mengajar.id_mengajar
              INNER JOIN tb_semester ON tb_mengajar.id_semester = tb_semester.id_semester
              INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran = tb_thajaran.id_thajaran
              WHERE _logabsensi.id_siswa = '$idSiswa' AND _logabsensi.ket = '$ket' 
              AND _logabsensi.id_mengajar = '$pelajaran' AND tb_mengajar.id_mkelas = '$kelas'
              AND tb_thajaran.status = 1 AND tb_semester.status = 1
              AND _logabsensi.tgl_absen = '$selectedDate'";  // Tambahkan filter tanggal

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['jumlah'];
}

// Query untuk mengambil data siswa dan absensi
$query = "SELECT tb_siswa.*, _logabsensi.tgl_absen
          FROM _logabsensi
          INNER JOIN tb_siswa ON _logabsensi.id_siswa = tb_siswa.id_siswa
          INNER JOIN tb_mengajar ON _logabsensi.id_mengajar = tb_mengajar.id_mengajar
          INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas = tb_mkelas.id_mkelas
          INNER JOIN tb_semester ON tb_mengajar.id_semester = tb_semester.id_semester
          INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran = tb_thajaran.id_thajaran
          WHERE tb_mengajar.id_mengajar = '$pelajaran' AND tb_mengajar.id_mkelas = '$kelas'
          AND tb_thajaran.status = 1 AND tb_semester.status = 1";

// Ubah format tanggal saat mengambil dari URL
if (!empty($selectedDate)) {
    $selectedDate = date('Y/m/d', strtotime($selectedDate));
}
if (!empty($startDate)) {
    $startDate = date('Y/m/d', strtotime($startDate));
}
if (!empty($endDate)) {
    $endDate = date('Y/m/d', strtotime($endDate));
}

$query .= " GROUP BY _logabsensi.id_siswa
            ORDER BY _logabsensi.id_siswa ASC";

$qry = mysqli_query($con, $query);

// Query untuk mengambil informasi kelas dan mata pelajaran
$kelasMengajarQuery = "SELECT tb_guru.id_guru, tb_master_mapel.mapel, tb_mkelas.nama_kelas
                       FROM tb_mengajar
                       INNER JOIN tb_guru ON tb_mengajar.id_guru = tb_guru.id_guru
                       INNER JOIN tb_master_mapel ON tb_mengajar.id_mapel = tb_master_mapel.id_mapel
                       INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas = tb_mkelas.id_mkelas
                       INNER JOIN tb_semester ON tb_mengajar.id_semester = tb_semester.id_semester
                       INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran = tb_thajaran.id_thajaran
                       WHERE tb_mengajar.id_mengajar = '$pelajaran' AND tb_mengajar.id_mkelas = '$kelas'
                       AND tb_thajaran.status = 1 AND tb_semester.status = 1";

$kelasMengajar = mysqli_query($con, $kelasMengajarQuery);
$kelasData = mysqli_fetch_assoc($kelasMengajar);
$namaKelas = $kelasData['nama_kelas'];
$mapel = $kelasData['mapel'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Guru | Aplikasi Absensi</title>
    <link rel="icon" href="../../../logo-removebg-preview.png" type="image/png">
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="../assets/img/icon.ico" type='image/x-icon'/>
    <!-- Fonts and icons -->
    <script src="../../../assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Lato:300,400,700,900"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../../../assets/css/fonts.min.css']},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
</head>
<body>
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
$(document).ready(function() {
    var dataTable = $('#basic-datatables').DataTable();

    function applyDateFilter() {
        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;

        // Ubah format tanggal jika tidak kosong
        if (startDate) {
            startDate = startDate.replace(/-/g, '/');
        }

        if (endDate) {
            endDate = endDate.replace(/-/g, '/');
        }

        // Update the URL to include selected dates
        var newURL = window.location.href.split('?')[0];
        newURL += "?pelajaran=<?= $pelajaran ?>&kelas=<?= $kelas ?>";
        if (startDate && endDate) {
            newURL += "&startDate=" + startDate + "&endDate=" + endDate;
        }
        window.location.href = newURL;
    }
});

// Masukkan kode JavaScript tambahan yang Anda butuhkan di sini
    </script>

    <div class="card">
        <div class="card-body">
            <h2 class="judul-kelas">Daftar Kehadiran Siswa dari Mata Pelajaran <?= isset($mapel) ? strtoupper($mapel) : 'Tidak Tersedia'; ?> KELAS <?= isset($namaKelas) ? strtoupper($namaKelas) : 'Tidak Tersedia'; ?></h2>
            <div style="text-align: center;">
                <label for="startDate">Tanggal Awal:</label>
                <input type="date" id="startDate" name="startDate">
                <label for="endDate">Tanggal Akhir:</label>
                <input type="date" id="endDate" name="endDate">
                <button onclick="applyDateFilter()">Terapkan Filter</button>
            </div>

            <style>
    .judul-kelas {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        color: #333;
        padding: 12px;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
    }body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .table-container {
        max-height: 300px; /* Atur tinggi maksimal sesuai preferensi Anda */
        overflow: auto;
    }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    .card {
        max-width: 150vh; /* Sesuaikan dengan lebar yang diinginkan */
        margin: 0 auto;
        padding: 20px; /* Sesuaikan dengan padding yang diinginkan */
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }.ml-auto, .mx-auto {
    margin-left: auto!important;
    }
</style>
            <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NIS/NISN</th>
                        <th>NAMA SISWA</th>
                        <th>JENIS KELAMIN</th>
                        <th bgcolor="#76FF03" orderable="false">H</th>
                        <th bgcolor="#FFC107" orderable="false">S</th>
                        <th bgcolor="#4CAF50" orderable="false">I</th>
                        <th bgcolor="#D50000" orderable="false">A</th>
                        <th data-order="asc">TANGGAL ABSEN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($ds = mysqli_fetch_assoc($qry)) {
                        $warna = ($no % 2 == 1) ? "#ffffff" : "#f0f0f0";
                    ?>
                        <tr bgcolor="<?= $warna; ?>">
                            <td align="center"><?= $no++; ?></td>
                            <td align="center"><?= $ds['nis']; ?></td>
                            <td align="center"><?= $ds['nama_siswa']; ?></td>
                            <td align="center"><?= $ds['jk']; ?></td>
                            <td align="center"><?= getAttendanceCount($con, $ds['id_siswa'], $pelajaran, $kelas, 'H', $ds['tgl_absen']); ?></td>
                            <td align="center"><?= getAttendanceCount($con, $ds['id_siswa'], $pelajaran, $kelas, 'S', $ds['tgl_absen']); ?></td>
                            <td align="center"><?= getAttendanceCount($con, $ds['id_siswa'], $pelajaran, $kelas, 'I', $ds['tgl_absen']); ?></td>
                            <td align="center"><?= getAttendanceCount($con, $ds['id_siswa'], $pelajaran, $kelas, 'A', $ds['tgl_absen']); ?></td>
                            <td align="center"><?= date('Y-m-d', strtotime($ds['tgl_absen'])); ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <div style="text-align: center;">
                <label for="customFilename">Nama File Excel:</label>
                <input type="text" id="customFilename" name="customFilename">
                <a href="export.php?pelajaran=<?= $pelajaran ?>&kelas=<?= $kelas ?>&selectedDate=<?= $selectedDate ?>&customFilename=" + encodeURIComponent(document.getElementById('customFilename').value) class="btn btn-success">
                    <i class="fa fa-file-excel"></i> Ekspor ke Excel
                </a>
            </div>
        </div>
    </div>

    <footer class="footer" style="position: fixed; bottom: 0; width: 100%; background-color: #ddd; color: #000;">
        <div class="container">
            <div class="copyright ml-auto" style="padding: 10px 20px 10px 0; text-align: right;">
                &copy; <?php echo date('Y');?> Absensi SMK PGRI WANARAJA (<a href="index.php" style="color: #000; text-decoration: none;">Muhamad Hamzah </a> | 2023)
            </div>
        </div>
    </footer>
</body>
</html>
