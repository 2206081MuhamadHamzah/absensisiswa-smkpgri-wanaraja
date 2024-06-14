<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Guru | Aplikasi Absensi</title>
    <link rel="icon" href="../../../logo-removebg-preview.png" type="image/png">
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel='icon' href='../assets/img/icon.ico' type='image/x-icon'/>
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
<style>
    .judul-kelas {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        color: #333;
        padding: 12px;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
    }
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
    }
    .table-container {
        max-height: 400px;
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
        background-color: #3498db !important;
        color: #fff !important;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .card {
        max-width: 150vh;
        margin: 0 auto;
        padding: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="card">
    <div class="card-body">
        <h2 class="judul-kelas">Daftar Kehadiran Siswa dari Mata Pelajaran <?php echo isset($mapel) ? strtoupper($mapel) : 'Tidak Tersedia'; ?> KELAS <?php echo isset($namaKelas) ? strtoupper($namaKelas) : 'Tidak Tersedia'; ?></h2>
        <div class="text-center mt-3">
    <label for="sort-by-ket">Sortir berdasarkan Keterangan:</label>
    <select id="sort-by-ket" class="form-control">
        <option value="">Pilih Keterangan</option>
        <option value="H">Hadir</option>
        <option value="S">Sakit</option>
        <option value="I">Izin</option>
        <option value="A">Absen</option>
    </select>
</div>
        <div class="table-container">
            <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS/NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Keterangan</th>
                        <th>Tanggal Absen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
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
                        GROUP BY tb_siswa.nis, _logabsensi.tgl_absen
                        ";

                        $result = mysqli_query($con, $query);

                        if ($result) {
                            $counter = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . $counter++ . '</td>';
                                echo '<td>' . $row['nis'] . '</td>';
                                echo '<td>' . $row['nama_siswa'] . '</td>';
                                echo '<td>' . $row['jk'] . '</td>';
                                echo '<td>' . $row['keterangan'] . '</td>';
                                echo '<td>' . $row['tgl_absen'] . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo "Terjadi kesalahan dalam pengambilan data: " . mysqli_error($con);
                        }
                    } else {
                        echo "Silakan pilih tanggal untuk melihat rekapan.";
                    }
                    echo '<div class="text-center mt-3">';
                    echo '<a href="export1.php?tanggal=' . $tanggal_terpilih . '" class="btn btn-success" style="text-decoration: none; color: black;"><i class="far fa-file-excel"></i> Ekspor ke Excel</a>';
                    echo '</div>';
        
                    mysqli_close($con);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
   $(document).ready(function() {
        var table = $('#basic-datatables').DataTable();

        $('#sort-by-ket').on('change', function() {
            var selectedValue = $(this).val();
            table.columns(4).search('').draw(); // Clear any previous search

            if (selectedValue) {
                table.columns(4).search(selectedValue).draw();
            }
        });
    });
</script>
</body>
</html>
