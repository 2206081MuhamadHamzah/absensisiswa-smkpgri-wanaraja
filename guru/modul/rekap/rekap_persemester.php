<?php
require 'vendor/autoload.php';
include '../../../config/db.php';
$index = @$_GET['index'];
// Sesuaikan dengan lokasi autoload.php


// Ambil parameter dari URL
$pelajaran = isset($_GET['pelajaran']) ? $_GET['pelajaran'] : '';
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$selectedDate = isset($_GET['selectedDate']) ? $_GET['selectedDate'] : '';

// Fungsi untuk mengambil jumlah kehadiran berdasarkan kode ket
function getAttendanceCount($con, $idSiswa, $pelajaran, $kelas, $ket) {
    $query = "SELECT COUNT(ket) AS jumlah FROM _logabsensi
              INNER JOIN tb_mengajar ON _logabsensi.id_mengajar=tb_mengajar.id_mengajar
              INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
              INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
              WHERE _logabsensi.id_siswa='$idSiswa' AND _logabsensi.ket='$ket' 
              AND _logabsensi.id_mengajar='$pelajaran' AND tb_mengajar.id_mkelas='$kelas'
              AND tb_thajaran.status=1 AND tb_semester.status=1";

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['jumlah'];
}

// Query untuk mengambil data siswa
$query = "SELECT tb_siswa.*, _logabsensi.tgl_absen
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


$qry = mysqli_query($con, $query);

// Query untuk mengambil informasi kelas dan mata pelajaran
$kelasMengajarQuery = "SELECT tb_guru.id_guru, tb_master_mapel.mapel, tb_mkelas.nama_kelas
                       FROM tb_mengajar
                       INNER JOIN tb_guru ON tb_mengajar.id_guru=tb_guru.id_guru
                       INNER JOIN tb_master_mapel ON tb_mengajar.id_mapel=tb_master_mapel.id_mapel
                       INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas=tb_mkelas.id_mkelas
                       INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
                       INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
                       WHERE tb_mengajar.id_mengajar='$pelajaran' AND tb_mengajar.id_mkelas='$kelas'
                       AND tb_thajaran.status=1 AND tb_semester.status=1";

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
  var dataTable = $('#basic-datatables').DataTable()
  $('#filter-date').on('change', function() {
      var selectedDate = $(this).val();
      dataTable.column(8) // Ganti 8 dengan indeks kolom tanggal absen
        .search(selectedDate)
        .draw();
    });
    // Menangani perubahan tanggal pemfilteran
        });
			$('#multi-filter-select').DataTable( {
				"pageLength": 5,
				initComplete: function () {
					this.api().columns().every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value=""></option></select>')
						.appendTo( $(column.footer()).empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
								);

							column
							.search( val ? '^'+val+'$' : '', true, false )
							.draw();
						} );

						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
				}
			});

			// Add Row
			$('#add-row').DataTable({
				"pageLength": 5,
			});

			var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

			$('#addRowButton').click(function() {
				$('#add-row').dataTable().fnAddData([
					$("#addName").val(),
					$("#addPosition").val(),
					$("#addOffice").val(),
					action
					]);
				$('#addRowModal').modal('hide');

			});
            function showAttendanceDetails(idSiswa) {
        var modal = document.getElementById('detailAbsenModal');

        // Mengambil data kehadiran siswa berdasarkan ID siswa dari database
        // Gantilah dengan kode yang sesuai untuk mengambil data dari database
        var requestData = { idSiswa: idSiswa };
        
        $.ajax({
            type: 'POST',
            url: 'get_attendance_data.php', // Buat script PHP untuk mengambil data kehadiran siswa
            data: requestData,
            success: function(response) {
                var detailAbsen = document.getElementById('isiDetailAbsen');
                detailAbsen.innerHTML = response;
                modal.style.display = 'block';
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
    function showAttendanceDetails(idSiswa, idMengajar) {
    var modal = document.getElementById('detailAbsenModal');
    var detailAbsenContainer = document.getElementById('isiDetailAbsen');

    var requestData = { idSiswa: idSiswa, idMengajar: idMengajar };

    $.ajax({
        type: 'POST',
        url: 'get_data.php',
        data: requestData,
        success: function(response) {
            detailAbsenContainer.innerHTML = response;
            modal.style.display = 'block';

            // Sembunyikan tabel utama
            var mainTable = document.getElementById('basic-datatables');
            mainTable.style.display = 'none';

            // Menambahkan fungsi sortir di dalam detail absensi
            $(document).ready(function() {
                var detailTable = $('#detailTable').DataTable();
                $('#sort-by-ket').on('click', function() {
                    var column = 4; // Ganti dengan indeks kolom keterangan
                    var order = 'asc'; // Ubah ke 'desc' jika ingin mengurutkan secara terbalik

                    detailTable.order([column, order]).draw();
                });
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function closeAttendanceDetails() {
    var modal = document.getElementById('detailAbsenModal');
    modal.style.display = 'none';

    // Tampilkan kembali tabel utama
    var mainTable = document.getElementById('basic-datatables');
    mainTable.style.display = 'table'; // Ubah kembali display menjadi 'table'
}



    </script>

    <div class="card">
        <div class="card-body">
            <h2 class="judul-kelas">Daftar Kehadiran Siswa dari Mata Pelajaran <?= isset($mapel) ? strtoupper($mapel) : 'Tidak Tersedia'; ?> KELAS <?= isset($namaKelas) ? strtoupper($namaKelas) : 'Tidak Tersedia'; ?></h2>
            <form action="rekapan.php" method="get">
        <label for="tanggal">Pilih Tanggal:</label>
        <input type="date" name="tanggal" id="tanggal" required>
        <button type="submit">Tampilkan Rekapan</button>
    </form>
    
    <!-- Modal untuk detail absen -->
    <div id="detailAbsenModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeAttendanceDetails()">&times;</span>
        <div id="isiDetailAbsen">
            <!-- Table for attendance details -->
            <table id="detailAttendanceTable" class="display">
                <!-- Table headers and rows will go here -->
            </table>
        </div>
    </div>
</div>

            <style>
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
<div style="max-height: 400px; overflow: auto;">
           <table id="basic-datatables" class="display table table-striped table-hover">

    <thead>
        <tr>
            <th>NO</th>
            <th>NIS/NISN</th>
            <th>NAMA SISWA</th>
            <th>JENIS KELAMIN</th>
            <th bgcolor="#76FF03">H</th>
            <th bgcolor="#FFC107">S</th>
            <th bgcolor="#4CAF50">I</th>
            <th bgcolor="#D50000">A</th>
            <th>TANGGAL ABSEN</th>
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
                <td align="center">
                        <!-- Tambahkan event onClick untuk menampilkan detail kehadiran -->
                        <a href="javascript:void(0);" onclick="showAttendanceDetails(<?= $ds['id_siswa']; ?>, <?= $pelajaran; ?>)" style="text-decoration: none; color: black;">
                        <?= $ds['nama_siswa']; ?>
                        </a>
                    </td>
                <td align="center"><?= $ds['jk']; ?></td>
                <td align="center"><?= getAttendanceCount($con, $ds['id_siswa'], $pelajaran, $kelas, 'H'); ?></td>
                <td align="center"><?= getAttendanceCount($con, $ds['id_siswa'], $pelajaran, $kelas, 'S'); ?></td>
                <td align="center"><?= getAttendanceCount($con, $ds['id_siswa'], $pelajaran, $kelas, 'I'); ?></td>
                <td align="center"><?= getAttendanceCount($con, $ds['id_siswa'], $pelajaran, $kelas, 'A'); ?></td>
                <td align="center"><?= $ds['tgl_absen']; ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
    </div>
<div style="text-align: center;">
    <label for="customFilename">Nama File Excel:</label>
    <input type="text" id="customFilename" name="customFilename">
    
    <a href="export.php?pelajaran=<?= $pelajaran ?>&kelas=<?= $kelas ?>&selectedDate=<?= $selectedDate ?>&customFilename=" + encodeURIComponent(document.getElementById('customFilename').value) class="btn btn-success">
        <i class="fa fa-file-excel"></i> Ekspor ke Excel
    </a>
</div>

    <footer class="footer" style="position: fixed; bottom: 0; width: 100%; background-color: #ddd; color: #000;">
    <div class="container">
        <div class="copyright ml-auto" style="padding: 10px 200px 10px 0; text-align: right;">
            &copy; <?php echo date('Y');?> Absensi SMK PGRI WANARAJA (<a href="index.php" style="color: #000; text-decoration: none;">Muhamad Hamzah </a> | 2023)
        </div>
    </div>
</footer>


</body>
</html>
